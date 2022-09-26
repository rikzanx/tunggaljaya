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
        $products = Product::skip(0)->take(6)->orderBy('dilihat','DESC')->get();
        $products_footer = Product::skip(0)->take(6)->get();
        return view('index',[
            'company'=> $company,
            'sliders' => $sliders,
            'categories' => $categories,
            'products' => $products,
            'products_footer' => $products_footer,
        ]);
    }

    public function about(){
        $company = Company::first();
        $categories = Category::all();
        $products_footer = Product::skip(0)->take(6)->get();
        return view('about',[
            'company'=> $company,
            'categories' => $categories,
            'products_footer' => $products_footer,
        ]);
    }
    public function contact(){
        $company = Company::first();
        $categories = Category::all();
        $products_footer = Product::skip(0)->take(6)->get();
        return view('contact',[
            'company'=> $company,
            'categories' => $categories,
            'products_footer' => $products_footer,
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
        $products_footer = Product::skip(0)->take(6)->get();
        // dd($products);
        return view('product',[
            'company'=> $company,
            'categories' => $categories,
            'label' => $label,
            'products' => $products,
            'products_footer' => $products_footer,
            'category_option' => $category_option
        ]);
    }
    public function productdetail($slug){
        $company = Company::first();
        $categories = Category::all();
        $product = Product::with('images')->where('slug',$slug)->firstOrFail();
        $dilihat = $product->dilihat+1;
        // dd($dilihat);
        $product->dilihat = $dilihat;
        $product->save();
        $products = Product::with('images')->get();
        $products_footer = Product::skip(0)->take(6)->get();
        return view('product-detail',[
            'company'=> $company,
            'categories' => $categories,
            'product' => $product,
            'products' => $products,
            'products_footer' => $products_footer,
        ]);
    }
}
