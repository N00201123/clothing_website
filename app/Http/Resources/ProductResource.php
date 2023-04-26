<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //$categories = array();
        //foreach ($this->categories as $category) {
        //echo $category->category_type;
        //    array_push($categories, $category->category_type);
        //}

        //$orders = array();
        //foreach ($this->orders as $order) {
         //   echo $order->date;
         //   array_push($orders, $order->date);
        //}
        
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->date,
            'price' => $this -> price,
            'size' => $this -> size,
            'type' => $this -> type,
            'image' => $this -> image,
            //'categories' => $categories,
            //'orders' => $orders
        ];
    }
}
