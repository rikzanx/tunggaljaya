<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\ImagesSlider;
use App\Models\ImagesProduct;
use App\Models\Category;
use App\Models\Product;


class PageController extends Controller
{
    //
    public function welcome(){
        $company = Company::first();
        $sliders = ImagesSlider::all();
        $categories = Category::all();
        return view('index',[
            'company'=> $company,
            'sliders' => $sliders,
            'categories' => $categories
        ]);
    }

    public function about(){
        $company = Company::first();
        $categories = Category::all();
        return view('about',[
            'company'=> $company,
            'categories' => $categories
        ]);
    }
    public function contact(){
        $company = Company::first();
        $categories = Category::all();
        return view('contact',[
            'company'=> $company,
            'categories' => $categories
        ]);
    }
    public function product(Request $request){
        $company = Company::first();
        $categories = Category::get();
        $label = "Semua Produk";
        $products = Product::with('images')->paginate(10);
        $category_option = 0;
        if($request->has('category')){
            $products = Product::where('category_id',$request->category)->with('images')->paginate(10);
            $category = Category::where('id',$request->category)->firstOrFail();
            $label = $category->name;
            $category_option = $category->id;
        }
        // dd($products);
        return view('product',[
            'company'=> $company,
            'categories' => $categories,
            'label' => $label,
            'products' => $products,
            'category_option' => $category_option
        ]);
    }
    public function productdetail($slug){
        $company = Company::first();
        $categories = Category::all();
        $product = Product::with('images')->where('slug',$slug)->firstOrFail();
        $products = Product::with('images')->get();
        return view('product-detail',[
            'company'=> $company,
            'categories' => $categories,
            'product' => $product,
            'products' => $products
        ]);
    }
}
