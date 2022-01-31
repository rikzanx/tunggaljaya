<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Company::create([
                'name'    => "CV Tunggal Jaya",
                'about'    => "Kami adalah perusahaan yang bergerak di bidang valve, fitting. Melayani pemesanan valve dan jasa service / reparasi, pemasangan, instalasi pipa hydrant.",
                'address' => "jl. Margodadi 2-89, Kota Surabaya, Jawa Timur",
                'telp' => "+628125982217",
                'email' => "tunggaljaya5902@gmail.com",
                'image_company' => "img/imagecompany.jpg",
        ]);
    }
}
