<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class MyWorkShopsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $block = false;
        if ( $this->workshop->freelancer->blockedUser()->where('user_id', Auth::id())->first() != null  )
            $block = true;
        return [
            'id' => $this->id,
            'date' => $this->workshop->date,
            'updated_at' => $this->created_at,
            'created_at' => $this->created_at,
            'resource'=> [
                'name' => $this->workshop->name,
                'id' => $this->workshop->id,
                'date' => $this->workshop->date,
                'time' => $this->workshop->from_time,
                'images' => $this->workshop->images,
                'type' => 'workshop',
                "category"=> null,
                "category_id"=> null
            ],
            'freelancer'=> [
                'name' => $this->workshop->freelancer->name,
                'id' => $this->workshop->freelancer->id,
                'email' => $this->workshop->freelancer->email,
                'image' => $this->workshop->freelancer->image,
                'phone' => $this->workshop->freelancer->phone,
                'block' => $block,
            ],
        ];
    }
}
