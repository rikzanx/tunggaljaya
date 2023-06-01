<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use Illuminate\Http\Request;
use Validator;
use Session;

class BarangController extends Controller
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
        $barangs = Barang::get();
        $jumlah = $barangs->sum('jumlah');
        return view('admin.barang',[
            'barangs' => $barangs,
            'jumlah' => $jumlah
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.barang-create');
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
            'jenis' => 'required|string|max:255',
            'ukuran' => 'required|string|max:255',
            'koneksi' => 'required|string|max:255',
            'material' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'jumlah' => 'required|integer',
            'keterangan' => 'required|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route("barang.index")->with('danger', $validator->errors()->first());
        }
        // dd($request->all());
        // $uploadFolder = "img/category/";
        // $image = $request->file('image_category');
        // $imageName = time().'-'.$image->getClientOriginalName();
        // $image->move(public_path($uploadFolder), $imageName);
        // $image_link = $uploadFolder.$imageName;

        $barang = Barang::create([
            'jenis' => $request->jenis,
            'ukuran' => $request->ukuran,
            'koneksi' => $request->koneksi,
            'material' => $request->material,
            'brand' => $request->brand,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);
        if($barang){
            return redirect()->route("barang.index")->with('status', "Sukses menambhakan barang");
        }else{
            return redirect()->route("barang.index")->with('danger', "Terjadi Kesalahan saat menambahkan barang.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        // dd($category);
        return view('admin.barang-edit',[
            'barang' => $barang
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jenis' => 'required|string|max:255',
            'ukuran' => 'required|string|max:255',
            'koneksi' => 'required|string|max:255',
            'material' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'jumlah' => 'required|integer',
            'keterangan' => 'required|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route("barang.index")->with('danger', $validator->errors()->first());
        }
        // dd($request->all());
        // $uploadFolder = "img/category/";
        // $image = $request->file('image_category');
        // $imageName = time().'-'.$image->getClientOriginalName();
        // $image->move(public_path($uploadFolder), $imageName);
        // $image_link = $uploadFolder.$imageName;

        $barang = Barang::findOrFail($id);
        $barang->jenis = $request->jenis;
        $barang->ukuran = $request->ukuran;
        $barang->koneksi = $request->koneksi;
        $barang->material = $request->material;
        $barang->brand = $request->brand;
        $barang->jumlah = $request->jumlah;
        $barang->keterangan = $request->keterangan;
        
        if($barang->save()){
            return redirect()->route("barang.index")->with('status', "Sukses merubah barang");
        }else{
            return redirect()->route("barang.index")->with('danger', "Terjadi Kesalahan saat merubah barang.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Barang::destroy($id)){
            return redirect()->route("barang.index")->with('status', "Sukses menghapus barang");
        }else {
            return redirect()->route("barang.index")->with('danger', "Terjadi Kesalahan");
        }
    }
}
