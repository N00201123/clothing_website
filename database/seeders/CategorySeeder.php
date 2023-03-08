<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->times(3)->create();

        foreach(Category::all() as $category)   {
            $products = Product::inRandomOrder()->take(rand(1,3))->pluck('id');
            $category->products()->attach($products);
        }
    }
}
