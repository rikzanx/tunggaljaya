<?php

namespace App\Http\Controllers;

use App\Models\Prospect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class ProspectController extends Controller
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
        $prospects = Prospect::get();
        return view('admin.prospect.prospect',[
            'prospects' => $prospects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.prospect.prospect-create');
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
            return redirect()->route("prospect.index")->with('danger', $validator->errors()->first());
        }

        $prospect = Prospect::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email
        ]);

        if($prospect){
            return redirect()->route("prospect.index")->with('status', "Sukses menambhakan Pelanggan");
        }else{
            return redirect()->route("prospect.index")->with('danger', "Terjadi Kesalahan saat menambahkan pelanggan.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prospect  $prospect
     * @return \Illuminate\Http\Response
     */
    public function show(Prospect $prospect)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prospect  $prospect
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $prospect = Prospect::findOrFail($id);
        return view('admin.prospect.prospect-edit',[
            'prospect' => $prospect
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prospect  $prospect
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'status' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect()->route("prospect.index")->with('danger', $validator->errors()->first());
        }
        $prospect = Prospect::findOrFail($id);
        $prospect->name = $request->name;
        $prospect->address = $request->address;
        $prospect->phone = $request->phone;
        $prospect->email = $request->email;
        $prospect->status = $request->status;
        
        if($prospect->save()){
            return redirect()->route("prospect.index")->with('status', "Sukses merubah Pelanggan");
        }else {
            return redirect()->route("prospect.index")->with('danger', "Terjadi Kesalahan");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prospect  $prospect
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Prospect::destroy($id)){
            return redirect()->route("prospect.index")->with('status', "Sukses menghapus pelanggan");
        }else {
            return redirect()->route("prospect.index")->with('danger', "Terjadi Kesalahan");
        }
    }
}
