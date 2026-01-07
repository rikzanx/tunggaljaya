<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class SupplierController extends Controller
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
        $suppliers = Supplier::get();
        return view('admin.supplier.supplier',[
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.supplier.supplier-create');
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
            return redirect()->route("supplier.index")->with('danger', $validator->errors()->first());
        }

        $supplier = Supplier::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email
        ]);

        if($supplier){
            return redirect()->route("supplier.index")->with('status', "Sukses menambhakan Pelanggan");
        }else{
            return redirect()->route("supplier.index")->with('danger', "Terjadi Kesalahan saat menambahkan pelanggan.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('admin.supplier.supplier-edit',[
            'supplier' => $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
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
            return redirect()->route("supplier.index")->with('danger', $validator->errors()->first());
        }
        $supplier = Supplier::findOrFail($id);
        $supplier->name = $request->name;
        $supplier->address = $request->address;
        $supplier->phone = $request->phone;
        $supplier->email = $request->email;
        
        if($supplier->save()){
            return redirect()->route("supplier.index")->with('status', "Sukses merubah Pelanggan");
        }else {
            return redirect()->route("supplier.index")->with('danger', "Terjadi Kesalahan");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Supplier::destroy($id)){
            return redirect()->route("supplier.index")->with('status', "Sukses menghapus pelanggan");
        }else {
            return redirect()->route("supplier.index")->with('danger', "Terjadi Kesalahan");
        }
    }
}
