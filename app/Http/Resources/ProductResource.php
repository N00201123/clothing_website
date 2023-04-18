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
        $categorys = array();
        foreach ($this->categorys as $category) {
        echo $category->category_type;
            array_push($categorys, $category->category_type);
        }
        
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->date,
            'price' => $this -> price,
            'size' => $this -> size,
            'type' => $this -> type,
            'image' => $this -> image,
            'categorys' => $categorys
        ];
    }
}
