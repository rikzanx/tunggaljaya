<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Company;

use Illuminate\Http\Request;
use Validator;
use session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keuangan = Keuangan::orderBy('created_at','DESC')->get();
        $company = Company::firstOrFail();
        $saldo = $company->saldo;
        return view('admin.keuangan',[
            'keuangan' => $keuangan,
            'saldo' => $saldo
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.keuangan-create');
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
            'amount' => 'required',
            'tipe' => 'required',
            'description' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route("keuangan.create")->with('danger', $validator->errors()->first());
        }
        // dd($request->comment);
        DB::beginTransaction();
        try {
            // $wallet = Wallet::findOrFail($request->wallet_id);
            $company = Company::firstOrFail();
            $keuangan = new Keuangan();
            $keuangan->amount = $request->amount;
            $keuangan->tipe = $request->tipe;
            $keuangan->description = $request->description;

            $balance_after = ($request->tipe == "pemasukan")? $company->saldo + $request->amount : $company->saldo - $request->amount;
            $keuangan->balance_after = $balance_after;
            $keuangan->save();

            $company->saldo = $balance_after;
            $company->save();
            DB::commit();
            return redirect()->route("keuangan.index")->with('status', "Sukses menambahkan keuangan");
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            $ea = "Terjadi Kesalahan saat menambahkan keuangan".$e->message;
            return redirect()->route("keuangan.index")->with('danger', $ea);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     $invoice = Invoice::with('items')->where('id',$id)->firstOrFail();
    //     $company = Company::first();
    //     // dd($invoice);
    //     return view('admin.invoice-show',[
    //         'invoice' => $invoice,
    //     'date_inv' => Carbon::createFromFormat('Y-m-d', $invoice->duedate)->format('Y-m-d'),
    //         'company' => $company,
    //     ]);
    // }

    // public function show_proform($id)
    // {
    //     $invoice = Invoice::with('items')->where('id',$id)->firstOrFail();
    //     $company = Company::first();
    //     // dd($invoice);
    //     return view('admin.invoice-show-proform',[
    //         'invoice' => $invoice,
    //     'date_inv' => Carbon::createFromFormat('Y-m-d', $invoice->duedate)->addDays(7)->format('Y-m-d'),
    //         'company' => $company,
    //     ]);
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     $invoice = Invoice::with('items')->where('id',$id)->firstOrFail();
    //     return view('admin.invoice-edit',[
    //         "invoice" => $invoice
    //     ]);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name_customer' => 'required|string|max:255',
    //         'address_customer' => 'required',
    //         'phone_customer' => 'required',
    //         'description' => 'required',
    //         'qty' => 'required',
    //         'item_price' => 'required',
    //         'diskon_rate' => 'required',
    //         'tax_rate' => 'required',
    //         'profit' => 'required'
    //     ]);
        
    //     if ($validator->fails()) {
    //         return redirect()->route("invoice.index")->with('danger', $validator->errors()->first());
    //     }
    //     // dd($request->comment);

    //     // foreach($invoices as $a){
    //     //     Item::where('invoice_id', $a->id)
    //     //     ->update([
    //     //         'duedate' => $a->duedate
    //     //         ]);
    //     // }
    //     DB::beginTransaction();
    //     try {
    //         $invoice = Invoice::findOrFail($id);
    //         $invoice->name_customer = $request->name_customer;
    //         $invoice->duedate = $request->duedate;
    //         $invoice->address_customer = $request->address_customer;
    //         $invoice->phone_customer = $request->phone_customer;
    //         $invoice->diskon_rate = $request->diskon_rate;
    //         $invoice->tax_rate = $request->tax_rate;
    //         $invoice->profit = $request->profit;
    //         if($request->has('comment')){
    //             $invoice->comment = $request->comment;
    //         }
    //         $invoice->save();
    //         $delete = Item::where('invoice_id',$id)->delete();
    //         for($i=0;$i<count($request->description);$i++){
    //             $item = new Item();
    //             $item->duedate = $request->duedate;
    //             $item->invoice_id = $invoice->id;
    //             $item->item_of = "pcs";
    //             $item->description = $request->description[$i];
    //             $item->qty = $request->qty[$i];
    //             $item->item_price = $request->item_price[$i];
    //             $item->save();
    //         }
    //         DB::commit();
    //         return redirect()->route("invoice.index")->with('status', "Sukses merubah invoice");
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         dd($e);
    //         $ea = "Terjadi Kesalahan saat merubah invoice".$e->message;
    //         return redirect()->route("invoice.index")->with('danger', $ea);
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     DB::beginTransaction();
    //     try{
    //         $invoice = Invoice::where('id',$id)->first();
    //         $deleted_invoice = new DeletedInvoice();
    //         $deleted_invoice->id_inv = $invoice->id_inv;
    //         $deleted_invoice->no_invoice = $invoice->no_invoice;
    //         $deleted_invoice->duedate = $invoice->duedate;
    //         $deleted_invoice->name_customer = $invoice->name_customer;
    //         $deleted_invoice->address_customer = $invoice->address_customer;
    //         $deleted_invoice->phone_customer = $invoice->phone_customer;
    //         $deleted_invoice->diskon_rate = $invoice->diskon_rate;
    //         $deleted_invoice->tax_rate = $invoice->tax_rate;
    //         $deleted_invoice->profit = $invoice->profit;
    //         $deleted_invoice->comment = $invoice->comment;
    //         $deleted_invoice->save();

    //         $items = Item::where('invoice_id','=',$id)->get();
    //         foreach($items as $item){
    //             $deleted_item = new DeletedItem();
    //             $deleted_item->duedate = $item->duedate;
    //             $deleted_item->invoice_id = $deleted_invoice->id;
    //             $deleted_item->item_of = "pcs";
    //             $deleted_item->description = $item->description;
    //             $deleted_item->qty = $item->qty;
    //             $deleted_item->item_price = $item->item_price;
    //             $deleted_item->save();
    //         }
    //         Invoice::destroy($id);
    //         Item::where("invoice_id",'=',$id)->delete();
    //         DB::commit();
    //         return redirect()->route("invoice.index")->with('status', "Sukses menghapus invoice");
    //     }catch(\Exception $e){
    //         DB::rollback();
    //         dd($e);
    //         $ea = "Terjadi Kesalahan saat menghapus invoice".$e->message;
    //         return redirect()->route("invoice.index")->with('danger', $ea);
    //     }
    // }
}
