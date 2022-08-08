<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeletedInvoice;
use App\Models\DeletedItem;
use App\Models\Company;
use Validator;
use session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DeletedInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = DeletedInvoice::with('items')->orderBy('id', 'DESC')->get();
        return view('admin.deletedinvoice',[
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
        
        return view('admin.deletedinvoice-create');
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
            'diskon_rate' => 'required',
            'tax_rate' => 'required',
            'profit' => 'required'
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
            $latestInvoice = DeletedInvoice::where('created_at','>=',$now->startOfMonth()->toDateTimeString())->where('created_at','<=',$now->endOfMonth()->toDateTimeString())->orderBy('id','DESC')->first();
            if($latestInvoice === null){
                $invoice->no_invoice = $now->year."/INV/".$now->isoformat('MM')."/0001";
                $invoice->id_inv = 1;
            }else{
                $invoice->no_invoice = $now->year."/INV/".$now->isoformat('MM')."/".sprintf('%04d', $latestInvoice->id_inv+1);
                $invoice->id_inv = $latestInvoice->id_inv+1;
            }
            $invoice->duedate = $request->duedate;
            $invoice->name_customer = $request->name_customer;
            $invoice->address_customer = $request->address_customer;
            $invoice->phone_customer = $request->phone_customer;
            $invoice->diskon_rate = $request->diskon_rate;
            $invoice->tax_rate = $request->tax_rate;
            $invoice->profit = $request->profit;
            if($request->has('comment')){
                $invoice->comment = $request->comment;
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
        $invoice = DeletedInvoice::with('items')->where('id',$id)->firstOrFail();
        $company = Company::first();
        // dd($invoice);
        return view('admin.deletedinvoice-show',[
            'invoice' => $invoice,
        'date_inv' => Carbon::createFromFormat('Y-m-d H:i:s', $invoice->created_at)->format('Y-m-d'),
            'company' => $company,
        ]);
    }

    public function show_proform($id)
    {
        $invoice = DeletedInvoice::with('items')->where('id',$id)->firstOrFail();
        $company = Company::first();
        // dd($invoice);
        return view('admin.deletedinvoice-show-proform',[
            'invoice' => $invoice,
        'date_inv' => Carbon::createFromFormat('Y-m-d H:i:s', $invoice->created_at)->format('Y-m-d'),
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
        $invoice = DeletedInvoice::with('items')->where('id',$id)->firstOrFail();
        return view('admin.deletedinvoice-edit',[
            "invoice" => $invoice
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
            'diskon_rate' => 'required',
            'tax_rate' => 'required',
            'profit' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect()->route("invoice.index")->with('danger', $validator->errors()->first());
        }
        // dd($request->comment);

        // foreach($invoices as $a){
        //     DeletedItem::where('invoice_id', $a->id)
        //     ->update([
        //         'duedate' => $a->duedate
        //         ]);
        // }
        DB::beginTransaction();
        try {
            $invoice = DeletedInvoice::findOrFail($id);
            $invoice->name_customer = $request->name_customer;
            $invoice->duedate = $request->duedate;
            $invoice->address_customer = $request->address_customer;
            $invoice->phone_customer = $request->phone_customer;
            $invoice->diskon_rate = $request->diskon_rate;
            $invoice->tax_rate = $request->tax_rate;
            $invoice->profit = $request->profit;
            if($request->has('comment')){
                $invoice->comment = $request->comment;
            }
            $invoice->save();
            $delete = DeletedItem::where('invoice_id',$id)->delete();
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
            DeletedInvoice::destroy($id);
            DeletedItem::where("invoice_id",'=',$id)->delete();
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
