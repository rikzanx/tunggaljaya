<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratPenawaran;
use App\Models\SuratPenawaranItem;
use App\Models\DeletedInvoice;
use App\Models\DeletedItem;
use App\Models\Company;
use Validator;
use session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use \Mpdf\Mpdf as PDF; 
use Illuminate\Support\Facades\Storage;

class SuratPenawaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suratpenawarans = SuratPenawaran::with('items')->get();
        return view('admin.suratpenawaran.suratpenawaran',[
            'suratpenawarans' => $suratpenawarans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.suratpenawaran.suratpenawaran-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_customer' => 'required|string|max:255',
            'address_customer' => 'required',
            'phone_customer' => 'required',
            'description' => 'required',
            'qty' => 'required',
            'item_price' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route("surat-penawaran.index")->with('danger', $validator->errors()->first());
        }
        // dd($request->comment);
        DB::beginTransaction();
        try {
            $suratpenawaran = new SuratPenawaran();
            $now = Carbon::parse($request->duedate);
            // dd($now->startOfMonth()->toDateTimeString());
            $latestInvoice = SuratPenawaran::where('created_at','>=',$now->startOfMonth()->toDateTimeString())->where('created_at','<=',$now->endOfMonth()->toDateTimeString())->orderBy('id','DESC')->first();
            if($latestInvoice === null){
                $suratpenawaran->no_surat = $now->year."/PNW/".$now->isoformat('MM')."/0001";
                $suratpenawaran->id_pnw = 1;
            }else{
                $suratpenawaran->no_surat= $now->year."/PNW/".$now->isoformat('MM')."/".sprintf('%04d', $latestInvoice->id_inv+1);
                $suratpenawaran->id_pnw = $latestInvoice->id_inv+1;
            }
            $suratpenawaran->duedate = $request->duedate;
            $suratpenawaran->name_customer = $request->name_customer;
            $suratpenawaran->address_customer = $request->address_customer;
            $suratpenawaran->phone_customer = $request->phone_customer;
            if($request->has('comment')){
                $suratpenawaran->comment = $request->comment;
            }
            $suratpenawaran->save();
            for($i=0;$i<count($request->description);$i++){
                $item = new SuratPenawaranItem();
                $item->duedate = $request->duedate;
                $item->suratpenawaran_id = $suratpenawaran->id;
                $item->item_of = "pcs";
                $item->description = $request->description[$i];
                $item->qty = $request->qty[$i];
                $item->item_price = $request->item_price[$i];
                $item->save();
            }
            DB::commit();
            return redirect()->route("surat-penawaran.index")->with('status', "Sukses menambahkan surat penawaran");
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            $ea = "Terjadi Kesalahan saat menambahkan surat penawaran".$e->message;
            return redirect()->route("surat-penawaran.index")->with('danger', $ea);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showold($id)
    {
        $suratpenawaran = SuratPenawaran::with('items')->where('id',$id)->firstOrFail();
        $company = Company::first();
        // dd($suratpenawaran);
        return view('admin.suratpenawaran.suratpenawaran-show',[
            'suratpenawaran' => $suratpenawaran,
            'date_inv' => Carbon::createFromFormat('Y-m-d', $suratpenawaran->duedate)->format('Y-m-d'),
            'company' => $company,
        ]);
    }
    public function show($id)
    {
        $suratpenawaran = SuratPenawaran::with('items')->where('id',$id)->firstOrFail();
        $company = Company::first();
        // Setup a filename 
        $name = "Surat Penawaran ".$company->name." ".$suratpenawaran->no_surat.".pdf";
        $documentFileName = $name;
        // Create the mPDF document
        $document = new PDF( [
            'mode' => 'utf-8',
            'format' => 'A3',
            'margin_header' => '3',
            'margin_top' => '20',
            'margin_bottom' => '20',
            'margin_footer' => '2',
        ]);     
        // Set some header informations for output
        $header = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$documentFileName.'"'
        ];
        // Write some simple Content
        $document->WriteHTML(view('admin.suratpenawaran.suratpenawaran-show-mpdf',[
            'suratpenawaran' => $suratpenawaran,
            'date_inv' => Carbon::createFromFormat('Y-m-d', $suratpenawaran->duedate)->format('Y-m-d'),
            'company' => $company,
            'signature' => true
        ]));
        // Save PDF on your public storage 
        Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "S"));
        // Get file back from storage with the give header informations
        return Storage::disk('public')->download($documentFileName, 'Request', $header); //
    }
    public function showkosong($id)
    {
        $suratpenawaran = SuratPenawaran::with('items')->where('id',$id)->firstOrFail();
        $company = Company::first();
        // Setup a filename 
        $name = "Surat Penawaran ".$company->name." ".$suratpenawaran->no_surat.".pdf";
        $documentFileName = $name;
        // Create the mPDF document
        $document = new PDF( [
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_header' => '3',
            'margin_top' => '20',
            'margin_bottom' => '20',
            'margin_footer' => '2',
        ]);     
        // Set some header informations for output
        $header = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$documentFileName.'"'
        ];
        // Write some simple Content
        $document->WriteHTML(view('admin.suratpenawaran.suratpenawaran-show-mpdf-kosong',[
            'suratpenawaran' => $suratpenawaran,
            'date_inv' => Carbon::createFromFormat('Y-m-d', $suratpenawaran->duedate)->format('Y-m-d'),
            'company' => $company,
        ]));
        // Save PDF on your public storage 
        Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "S"));
        // Get file back from storage with the give header informations
        return Storage::disk('public')->download($documentFileName, 'Request', $header); //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $suratpenawaran = Suratpenawaran::with('items')->where('id',$id)->firstOrFail();
        return view('admin.suratpenawaran.suratpenawaran-edit',[
            "suratpenawaran" => $suratpenawaran
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name_customer' => 'required|string|max:255',
            'address_customer' => 'required',
            'phone_customer' => 'required',
            'description' => 'required',
            'qty' => 'required',
            'item_price' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route("surat-penawaranindex")->with('danger', $validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            $suratpenawaran = SuratPenawaran::findOrFail($id);
            $suratpenawaran->name_customer = $request->name_customer;
            $suratpenawaran->duedate = $request->duedate;
            $suratpenawaran->address_customer = $request->address_customer;
            $suratpenawaran->phone_customer = $request->phone_customer;
            if($request->has('comment')){
                $suratpenawaran->comment = $request->comment;
            }
            $suratpenawaran->save();
            $delete = SuratPenawaranItem::where('suratpenawaran_id',$id)->delete();
            for($i=0;$i<count($request->description);$i++){
                $item = new SuratPenawaranItem();
                $item->duedate = $request->duedate;
                $item->suratpenawaran_id = $suratpenawaran->id;
                $item->item_of = "pcs";
                $item->description = $request->description[$i];
                $item->qty = $request->qty[$i];
                $item->item_price = $request->item_price[$i];
                $item->save();
            }
            DB::commit();
            return redirect()->route("surat-penawaran.index")->with('status', "Sukses merubah surat penawaran");
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            $ea = "Terjadi Kesalahan saat merubah surat penawaran".$e->message;
            return redirect()->route("surat-penawaran.index")->with('danger', $ea);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
