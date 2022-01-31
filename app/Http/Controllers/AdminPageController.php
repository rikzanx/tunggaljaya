<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\ImagesSlider;
use App\Models\ImagesProduct;
use App\Models\Category;
use App\Models\Product;

class AdminPageController extends Controller
{
    public function __construct()
    {
            $this->middleware('auth');
    }
    public function index(){
        $categories = Category::get();
        $images_slider= ImagesSlider::get();
        $products = Product::get();
        return view('admin.dashboard',[
            'categories' => $categories,
            'images_slider' => $images_slider,
            'products' => $products,
        ]);
    }
}
