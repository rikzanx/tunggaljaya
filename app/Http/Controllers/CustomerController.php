<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    public function __construct()
    {
            $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::get();
        return view('admin.customer.customer',[
            'customers' => $customers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.customer.customer-create');
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
            'name' => 'required|string|max:255',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect()->route("customer.index")->with('danger', $validator->errors()->first());
        }

        $customer = Customer::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email
        ]);

        if($customer){
            return redirect()->route("customer.index")->with('status', "Sukses menambhakan Pelanggan");
        }else{
            return redirect()->route("customer.index")->with('danger', "Terjadi Kesalahan saat menambahkan pelanggan.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
      $customer->load('invoices');
      // dd($customer->invoices);
      return view('admin.customer.customer-show',[
          'customer' => $customer
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customer.customer-edit',[
            'customer' => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route("customer.index")->with('danger', $validator->errors()->first());
        }
        $customer = Customer::findOrFail($id);
        $customer->name = $request->name;
        $customer->address = $request->address;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        
        if($customer->save()){
            return redirect()->route("customer.index")->with('status', "Sukses merubah Pelanggan");
        }else {
            return redirect()->route("customer.index")->with('danger', "Terjadi Kesalahan");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Customer::destroy($id)){
            return redirect()->route("customer.index")->with('status', "Sukses menghapus pelanggan");
        }else {
            return redirect()->route("customer.index")->with('danger', "Terjadi Kesalahan");
        }
    }
}
