<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'date', 'price', 'size', 'type', 'image'];

    public function categorys() 
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function orders() 
    {
        return $this->belongsToMany(Product::class, 'order_product')->withPivot(['price','quantity'])->withTimestamps();
    }
}
