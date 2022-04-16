<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'gender' => $this->gender,
            'datebirth' => $this->datebirth,
            'weight' => $this->weight,
            'description' => $this->description,
            'image' => $this->image,
            'categories_id' => $this->categories_id,
            'categories_name' => $this->category->namecategory
        ];
    }
}
