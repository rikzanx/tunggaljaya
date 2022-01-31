<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Category::create([
            'name' => "Gate Valve",
            'image_category' => "img/gate-valve.jpg",
        ]);
        \App\Models\Category::create([
            'name' => "Globe Valve",
            'image_category' => "img/globe-valve.jpg",
        ]);
        \App\Models\Category::create([
            'name' => "Ball Valve",
            'image_category' => "img/ball-valve.webp",
        ]);
    }
}
