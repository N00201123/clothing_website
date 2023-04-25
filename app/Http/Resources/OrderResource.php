<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
        return [
            'id' => $this->id,
            'date' => $this->date,
            'shipping_price' => $this->shipping_price,
            'customer_id' => $this->customer_id,
            'products' => $products
        ];
    }
}
