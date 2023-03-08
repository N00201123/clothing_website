<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::factory()->times(11)->create();

        foreach(Order::all() as $orders)   {
            $products = Product::inRandomOrder()->take(rand(1,3))->pluck('id');
            $orders->products()->attach($products);
        }
    }
}
