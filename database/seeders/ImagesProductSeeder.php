<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ImagesProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\ImagesProduct::create([
            'product_id' => 1,
            'image_product' => "img/product/gate-valve.jpg",
        ]);
        \App\Models\ImagesProduct::create([
            'product_id' => 2,
            'image_product' => "img/product/globe-valve.jpg",
        ]);
        \App\Models\ImagesProduct::create([
            'product_id' => 3,
            'image_product' => "img/product/ball-valve.webp",
        ]);
    }
}
