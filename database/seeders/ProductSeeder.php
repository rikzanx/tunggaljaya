<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Product::create([
            'category_id' => 1,
            'name' => "Gate Valve",
            'material' => "Cast Iron,Carbon Steel, Steinless Steel",
            'size' => "2,3,4,5,6,8,10",
            'rating' => "jis 10k, jis 20k, jis 30k, ansi 150, ansi 300, ansi 600",
            'connection' => "flange-end, screw",
            'brand' => "Kitz, GLT, Toyo dll.",
            'description' => "Gate Valve",
        ]);
        \App\Models\Product::create([
            'category_id' => 2,
            'name' => "Globe Valve",
            'material' => "Cast Iron,Carbon Steel, Steinless Steel",
            'size' => "2,3,4,5,6,8,10",
            'rating' => "jis 10k, jis 20k, jis 30k, ansi 150, ansi 300, ansi 600",
            'connection' => "flange-end, screw",
            'brand' => "Kitz, GLT, Toyo dll.",
            'description' => "Globe Valve",
        ]);
        \App\Models\Product::create([
            'category_id' => 3,
            'name' => "Ball Valve",
            'material' => "Cast Iron,Carbon Steel, Steinless Steel",
            'size' => "2,3,4,5,6,8,10",
            'rating' => "jis 10k, jis 20k, jis 30k, ansi 150, ansi 300, ansi 600",
            'connection' => "flange-end, screw",
            'brand' => "Kitz, GLT, Toyo dll.",
            'description' => "Ball Valve",
        ]);
    }
}
