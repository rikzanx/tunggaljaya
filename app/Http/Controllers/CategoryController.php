<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Validator;
use Session;

class CategoryController extends Controller
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
        $categories = Category::get();
        return view('admin.category',[
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category-create');
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
            'image_category' => 'required|image:jpeg,png,jpg,gif,svg,jfif'
        ]);
        
        if ($validator->fails()) {
            return redirect()->route("kategori.index")->with('danger', $validator->errors()->first());
        }
        // dd($request->all());
        $uploadFolder = "img/category/";
        $image = $request->file('image_category');
        $imageName = time().'-'.$image->getClientOriginalName();
        $image->move(public_path($uploadFolder), $imageName);
        $image_link = $uploadFolder.$imageName;

        $category = Category::create([
            'name' => $request->name,
            'image_category' => $image_link
        ]);
        if($category){
            return redirect()->route("kategori.index")->with('status', "Sukses menambhakan kategori");
        }else{
            return redirect()->route("kategori.index")->with('danger', "Terjadi Kesalahan saat menambahkan kategori.");
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
        $category = Category::findOrFail($id);
        // dd($category);
        return view('admin.category-edit',[
            'category' => $category
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
        // dd($request->name);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route("kategori.index")->with('danger', $validator->errors()->first());
        }
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        if($request->hasFile('image_category')){
            $uploadFolder = "img/category/";
            $image = $request->file('image_category');
            $imageName = time().'-'.$image->getClientOriginalName();
            $image->move(public_path($uploadFolder), $imageName);
            $image_link = $uploadFolder.$imageName;
            $category->image_category = $image_link;
        }
        
        if($category->save()){
            return redirect()->route("kategori.index")->with('status', "Sukses merubah kategori");
        }else {
            return redirect()->route("kategori.index")->with('danger', "Terjadi Kesalahan");
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
        if(Category::destroy($id)){
            return redirect()->route("kategori.index")->with('status', "Sukses menghapus kategori");
        }else {
            return redirect()->route("kategori.index")->with('danger', "Terjadi Kesalahan");
        }
    }
}
