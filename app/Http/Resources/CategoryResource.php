<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $products = array();
        foreach ($this->products as $product) {
        echo $product->title;
            array_push($products, $product->title);
        }
        return[
            'id' => $this-> id,
            'category_type' => $this->category_type,
            'products' => $products
        ];
    }
}
