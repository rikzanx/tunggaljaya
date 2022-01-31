<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ImagesSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\ImagesSlider::create([
            'image_slider' => "img/valve-cover-1.jpg",
        ]);
        \App\Models\ImagesSlider::create([
            'image_slider' => "img/valve-cover-2.jpg",
        ]);
        \App\Models\ImagesSlider::create([
            'image_slider' => "img/valve-cover-3.png",
        ]);
    }
}
