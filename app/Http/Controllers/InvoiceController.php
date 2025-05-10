<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\DeletedInvoice;
use App\Models\DeletedItem;
use App\Models\Company;
use App\Models\Customer;
use Validator;
use session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use \Mpdf\Mpdf as PDF; 
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::with('items')->orderBy('id','DESC')->get();
        
        foreach($invoices as $inv){
            $inv->total=0;
            foreach($inv->items as $item){
                $inv->total += $item->total;
            }
        }
        return view('admin.invoice.invoice',[
            'invoices' => $invoices,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::get();
        return view('admin.invoice.invoice-create',[
            "customers" => $customers
        ]);
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
            'id_customer' => 'required',
            'address_customer' => 'required',
            'phone_customer' => 'required',
            'description' => 'required',
            'qty' => 'required',
            'item_price' => 'required',
            'diskon_rate' => 'required',
            'tax_rate' => 'required',
            'profit' => 'required',
            'dp' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect()->route("invoice.index")->with('danger', $validator->errors()->first());
        }
        // dd($request->comment);
        DB::beginTransaction();
        try {
            $invoice = new Invoice();
            $now = Carbon::parse($request->duedate);
            // dd($now->startOfMonth()->toDateTimeString());
            $latestInvoice = Invoice::where('created_at','>=',$now->startOfMonth()->toDateTimeString())->where('created_at','<=',$now->endOfMonth()->toDateTimeString())->orderBy('id','DESC')->first();
            if($latestInvoice === null){
                $invoice->no_invoice = $now->year."/INV/".$now->isoformat('MM')."/0001";
                $invoice->id_inv = 1;
            }else{
                $invoice->no_invoice = $now->year."/INV/".$now->isoformat('MM')."/".sprintf('%04d', $latestInvoice->id_inv+1);
                $invoice->id_inv = $latestInvoice->id_inv+1;
            }
            $invoice->duedate = $request->duedate;
            $invoice->tanggal_pengiriman = $request->tanggal_pengiriman;
            $invoice->name_customer = $request->name_customer;
            $invoice->id_customer = $request->id_customer;
            $invoice->address_customer = $request->address_customer;
            $invoice->phone_customer = $request->phone_customer;
            $invoice->diskon_rate = $request->diskon_rate;
            $invoice->tax_rate = $request->tax_rate;
            $invoice->profit = $request->profit;
            $invoice->dp = $request->dp;
            if($request->has('comment')){
                
                $invoice->comment = $request->comment;
            }
            if($request->has('notes_surat_jalan')){
                $invoice->notes_surat_jalan = $request->notes_surat_jalan;
            }
            $invoice->save();
            for($i=0;$i<count($request->description);$i++){
                $item = new Item();
                $item->duedate = $request->duedate;
                $item->invoice_id = $invoice->id;
                $item->item_of = "pcs";
                $item->description = $request->description[$i];
                $item->qty = $request->qty[$i];
                $item->item_price = $request->item_price[$i];
                $item->save();
            }
            DB::commit();
            return redirect()->route("invoice.index")->with('status', "Sukses menambahkan invoice");
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            $ea = "Terjadi Kesalahan saat menambahkan invoice".$e->message;
            return redirect()->route("invoice.index")->with('danger', $ea);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::with('items')->where('id',$id)->firstOrFail();
        $company = Company::first();
        $customers = Customer::get();
        // dd($invoice);
        return view('admin.invoice.invoice-show',[
            'invoice' => $invoice,
            'date_inv' => Carbon::createFromFormat('Y-m-d', $invoice->duedate)->format('Y-m-d'),
            'company' => $company,
            'customers' => $customers
        ]);
    }
    public function shown($id)
    {
        $invoice = Invoice::with('items')->where('id',$id)->firstOrFail();
        $company = Company::first();
        $name = "Invoice ".$invoice->no_invoice." ".$company->name.".pdf";
        $name = "Invoice ".$invoice->no_invoice." ".$company->name." ".now()->timestamp.".pdf";

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
        $header = [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $documentFileName . '"',
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT'
            ];
 
        // Write some simple Content
        $document->WriteHTML(view('admin.invoice.invoice-shown',[
            'invoice' => $invoice,
            'date_inv' => Carbon::createFromFormat('Y-m-d', $invoice->duedate)->format('Y-m-d'),
            'company' => $company,
        ]));
         
        // Save PDF on your public storage 
        Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "S"));
         
        // Get file back from storage with the give header informations
        return Storage::disk('public')->download($documentFileName, 'Request', $header); //
    }

    public function print($id)
    {
        $invoice = Invoice::with('items')->where('id',$id)->firstOrFail();
        $company = Company::first();
        // Setup a filename 
        $name = "Invoice ".$invoice->no_invoice." ".$company->name.".pdf";
$name = "Invoice ".$invoice->no_invoice." ".$company->name." ".now()->timestamp.".pdf";

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
        $header = [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $documentFileName . '"',
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT'
            ];
        // Write some simple Content
        $document->WriteHTML(view('admin.invoice.invoice-show-mpdf',[
            'invoice' => $invoice,
            'date_inv' => Carbon::createFromFormat('Y-m-d', $invoice->duedate)->format('Y-m-d'),
            'company' => $company,
        ]));
        return response($document->Output($name, 'S'), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="' . $name . '"',
        'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
        'Pragma' => 'no-cache',
        'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT',
    ]);
        // Save PDF on your public storage 
        Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "S"));
        // Get file back from storage with the give header informations
        return Storage::disk('public')->download($documentFileName, 'Request', $header); //
    }

    public function surat_jalan($id)
    {
        $invoice = Invoice::with('items')->where('id',$id)->firstOrFail();
        $company = Company::first();
        // dd($invoice);
        return view('admin.surat-jalan.surat-jalan',[
            'invoice' => $invoice,
        'date_inv' => Carbon::createFromFormat('Y-m-d', $invoice->duedate)->format('Y-m-d'),
        'tanggal_pengiriman' => Carbon::createFromFormat('Y-m-d', $invoice->tanggal_pengiriman)->format('Y-m-d'),
            'company' => $company,
        ]);
    }

    public function surat_jalan_new($id)
    {
        $invoice = Invoice::with('items')->where('id',$id)->firstOrFail();
        $company = Company::first();
        // dd($invoice);
        // return view('admin.surat-jalan.surat-jalan-new',[
        //     'invoice' => $invoice,
        // 'date_inv' => Carbon::createFromFormat('Y-m-d', $invoice->duedate)->format('Y-m-d'),
        // 'tanggal_pengiriman' => Carbon::createFromFormat('Y-m-d', $invoice->tanggal_pengiriman)->format('Y-m-d'),
        //     'company' => $company,
        // ]);

        // Setup a filename 
        $name = "Surat Jalan ".$company->name." ".$invoice->no_invoice.".pdf";
        $name = "Surat Jalan ".$invoice->no_invoice." ".$company->name." ".now()->timestamp.".pdf";

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
        $header = [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $documentFileName . '"',
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT'
            ];
 
        // Write some simple Content
        $document->WriteHTML(view('admin.surat-jalan.surat-jalan-new',[
            'invoice' => $invoice,
            'date_inv' => Carbon::createFromFormat('Y-m-d', $invoice->duedate)->format('Y-m-d'),
            'tanggal_pengiriman' => Carbon::createFromFormat('Y-m-d', $invoice->tanggal_pengiriman)->format('Y-m-d'),
            'company' => $company,
        ]));
         
        // Save PDF on your public storage 
        Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "S"));
         
        // Get file back from storage with the give header informations
        return Storage::disk('public')->download($documentFileName, 'Request', $header); //
    }

    public function show_proform($id)
    {
        $invoice = Invoice::with('items')->where('id',$id)->firstOrFail();
        $company = Company::first();
        // dd($invoice);
        return view('admin.invoice.invoice-show-proform',[
            'invoice' => $invoice,
        'date_inv' => Carbon::createFromFormat('Y-m-d', $invoice->duedate)->addDays(7)->format('Y-m-d'),
            'company' => $company,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customers = Customer::get();
        $invoice = Invoice::with('items')->where('id',$id)->firstOrFail();
        return view('admin.invoice.invoice-edit',[
            "invoice" => $invoice,
            "customers" => $customers
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
            'id_customer' => 'required',
            'address_customer' => 'required',
            'phone_customer' => 'required',
            'description' => 'required',
            'qty' => 'required',
            'item_price' => 'required',
            'diskon_rate' => 'required',
            'tax_rate' => 'required',
            'profit' => 'required',
            'dp' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect()->route("invoice.index")->with('danger', $validator->errors()->first());
        }
        // dd($request->comment);

        // foreach($invoices as $a){
        //     Item::where('invoice_id', $a->id)
        //     ->update([
        //         'duedate' => $a->duedate
        //         ]);
        // }
        DB::beginTransaction();
        try {
            $invoice = Invoice::findOrFail($id);
            $invoice->name_customer = $request->name_customer;
            $invoice->id_customer = $request->id_customer;
            $invoice->duedate = $request->duedate;
            $invoice->tanggal_pengiriman = $request->tanggal_pengiriman;
            $invoice->address_customer = $request->address_customer;
            $invoice->phone_customer = $request->phone_customer;
            $invoice->diskon_rate = $request->diskon_rate;
            $invoice->tax_rate = $request->tax_rate;
            $invoice->profit = $request->profit;
            $invoice->dp = $request->dp;
            if($request->has('comment')){
                $invoice->comment = $request->comment;
            }
            if($request->has('notes_surat_jalan')){
                $invoice->notes_surat_jalan = $request->notes_surat_jalan;
            }
            $invoice->save();
            $delete = Item::where('invoice_id',$id)->delete();
            for($i=0;$i<count($request->description);$i++){
                $item = new Item();
                $item->duedate = $request->duedate;
                $item->invoice_id = $invoice->id;
                $item->item_of = "pcs";
                $item->description = $request->description[$i];
                $item->qty = $request->qty[$i];
                $item->item_price = $request->item_price[$i];
                $item->save();
            }
            DB::commit();
            return redirect()->route("invoice.index")->with('status', "Sukses merubah invoice");
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            $ea = "Terjadi Kesalahan saat merubah invoice".$e->message;
            return redirect()->route("invoice.index")->with('danger', $ea);
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
        DB::beginTransaction();
        try{
            $invoice = Invoice::where('id',$id)->first();
            $deleted_invoice = new DeletedInvoice();
            $deleted_invoice->id_inv = $invoice->id_inv;
            $deleted_invoice->no_invoice = $invoice->no_invoice;
            $deleted_invoice->duedate = $invoice->duedate;
            $deleted_invoice->name_customer = $invoice->name_customer;
            $deleted_invoice->address_customer = $invoice->address_customer;
            $deleted_invoice->phone_customer = $invoice->phone_customer;
            $deleted_invoice->diskon_rate = $invoice->diskon_rate;
            $deleted_invoice->tax_rate = $invoice->tax_rate;
            $deleted_invoice->profit = $invoice->profit;
            $deleted_invoice->comment = $invoice->comment;
            $deleted_invoice->save();

            $items = Item::where('invoice_id','=',$id)->get();
            foreach($items as $item){
                $deleted_item = new DeletedItem();
                $deleted_item->duedate = $item->duedate;
                $deleted_item->invoice_id = $deleted_invoice->id;
                $deleted_item->item_of = "pcs";
                $deleted_item->description = $item->description;
                $deleted_item->qty = $item->qty;
                $deleted_item->item_price = $item->item_price;
                $deleted_item->save();
            }
            Invoice::destroy($id);
            Item::where("invoice_id",'=',$id)->delete();
            DB::commit();
            return redirect()->route("invoice.index")->with('status', "Sukses menghapus invoice");
        }catch(\Exception $e){
            DB::rollback();
            dd($e);
            $ea = "Terjadi Kesalahan saat menghapus invoice".$e->message;
            return redirect()->route("invoice.index")->with('danger', $ea);
        }
    }
}
