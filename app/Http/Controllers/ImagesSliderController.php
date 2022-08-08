<?php

namespace App\Http\Controllers;

use App\Models\ImagesSlider;
use Illuminate\Http\Request;
use Validator;
use Session;

class ImagesSliderController extends Controller
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
        $sliders = ImagesSlider::get();
        return view('admin.slider',[
            'sliders' => $sliders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slider-create');
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
            'image_slider' => 'required|image:jpeg,png,jpg,gif,svg,jfif|max:2048'
        ]);
        
        if ($validator->fails()) {
            return redirect()->route("slider.index")->with('danger', $validator->errors()->first());
        }
        // dd($request->all());
        $uploadFolder = "img/sliders/";
        $image = $request->file('image_slider');
        $imageName = time().'-'.$image->getClientOriginalName();
        $image->move(public_path($uploadFolder), $imageName);
        $image_link = $uploadFolder.$imageName;

        $slider = ImagesSlider::create([
            'image_slider' => $image_link
        ]);
        if($slider){
            return redirect()->route("slider.index")->with('status', "Sukses menambhakan slider");
        }else{
            return redirect()->route("slider.index")->with('danger', "Terjadi Kesalahan saat menambahkan kategori.");
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
        $slider = ImagesSlider::findOrFail($id);
        // dd($category);
        return view('admin.slider-edit',[
            'slider' => $slider
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
            'image_slider' => 'required|image:jpeg,png,jpg,gif,svg,jfif|max:2048'
        ]);
        
        if ($validator->fails()) {
            return redirect()->route("slider.index")->with('danger', $validator->errors()->first());
        }
        $slider = ImagesSlider::findOrFail($id);
        $uploadFolder = "img/sliders/";
        $image = $request->file('image_slider');
        $imageName = time().'-'.$image->getClientOriginalName();
        $image->move(public_path($uploadFolder), $imageName);
        $image_link = $uploadFolder.$imageName;
        $slider->image_slider = $image_link;
        
        if($slider->save()){
            return redirect()->route("slider.index")->with('status', "Sukses merubah slider");
        }else {
            return redirect()->route("slider.index")->with('danger', "Terjadi Kesalahan");
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
        if(ImagesSlider::destroy($id)){
            return redirect()->route("slider.index")->with('status', "Sukses menghapus slider");
        }else {
            return redirect()->route("slider.index")->with('danger', "Terjadi Kesalahan");
        }

    }
}
