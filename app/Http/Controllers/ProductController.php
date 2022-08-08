<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ImagesProduct;
use Illuminate\Http\Request;
use Validator;
use session;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
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
        $products = Product::with('images')->get();
        return view('admin.product',[
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();
        return view('admin.product-create',[
            'categories' => $categories
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
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'material' => 'required',
            'size' => 'required',
            'rating' => 'required',
            'connection' => 'required',
            'brand' => 'required',
            'description' => 'required',
            'filenames' => 'required',
            'filenames.*' => 'image'
        ]);
        
        if ($validator->fails()) {
            return redirect()->route("produk.index")->with('danger', $validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            //code...
            // dd("oke");
            $product= new Product();
            $product->category_id = $request->category_id;
            $product->name = $request->name;
            $product->material = $request->material;
            $product->size = $request->size;
            $product->rating = $request->rating;
            $product->connection = $request->connection;
            $product->brand = $request->brand;
            $product->description = $request->description;
            $product->save();
            if($request->hasfile('filenames')){
                foreach($request->file('filenames') as $file)
                {
                    $imageproduct = new ImagesProduct();
                    $uploadFolder = "img/product/";
                    $image = $file;
                    $imageName = time().'-'.$image->getClientOriginalName();
                    $image->move(public_path($uploadFolder), $imageName);
                    $image_link = $uploadFolder.$imageName;
                    $imageproduct->product_id = $product->id;
                    $imageproduct->image_product = $image_link;
                    $imageproduct->save();
                }
            }
            //commit
            DB::commit();
            return redirect()->route("produk.index")->with('status', "Sukses menambhakan produk");
        } catch (\Exception $e) {
            DB::rollback();
            $ea = "Terjadi Kesalahan saat menambahkan kategori".$e->message;
            return redirect()->route("produk.index")->with('danger', $ea);
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
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::get();
        // dd($category);
        return view('admin.product-edit',[
            'product' => $product,
            'categories' => $categories,
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
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'material' => 'required',
            'size' => 'required',
            'rating' => 'required',
            'connection' => 'required',
            'brand' => 'required',
            'description' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route("produk.index")->with('danger', $validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            //code...
            // dd("oke");
            $product= Product::findOrFail($id);
            $product->category_id = $request->category_id;
            $product->name = $request->name;
            $product->material = $request->material;
            $product->size = $request->size;
            $product->rating = $request->rating;
            $product->connection = $request->connection;
            $product->brand = $request->brand;
            $product->description = $request->description;
            $product->save();
            if($request->hasfile('filenames')){
                $delete = ImagesProduct::where('product_id',$id)->delete();
                foreach($request->file('filenames') as $file)
                {
                    $imageproduct = new ImagesProduct();
                    $uploadFolder = "img/product/";
                    $image = $file;
                    $imageName = time().'-'.$image->getClientOriginalName();
                    $image->move(public_path($uploadFolder), $imageName);
                    $image_link = $uploadFolder.$imageName;
                    $imageproduct->product_id = $id;
                    $imageproduct->image_product = $image_link;
                    $imageproduct->save();
                }
            }
            //commit
            DB::commit();
            return redirect()->route("produk.index")->with('status', "Sukses merubah produk");
        } catch (\Exception $e) {
            DB::rollback();
            $ea = "Terjadi Kesalahan saat merubah produk".$e->message;
            return redirect()->route("produk.index")->with('danger', $ea);
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
        DB::beginTransaction();
        try{
            Product::destroy($id);
            $delete = ImagesProduct::where('product_id',$id)->delete();
            DB::commit();
            return redirect()->route("produk.index")->with('status', "Sukses menghapus product");

        }catch (\Exception $e) {
            DB::rollback();
            $ea = "Terjadi Kesalahan saat merubah produk".$e->message;
            return redirect()->route("produk.index")->with('danger', $ea);
        }
    }
}
