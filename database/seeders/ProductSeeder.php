<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()->times(40)->create();

        // $product1 = new Product();
        // $product1->title = "Tommy Hilfiger";
        // $product1->description = "Black Heavyweight Hoodie";
        // $product1->date = "2022-01-28";
        // $product1->price = "19.99";
        // $product1->size = "M";
        // $product1-> type = "Hoodie";
        // $product1->image = "Clothes_pt1.png";
        // $product1->save();
    }
}
