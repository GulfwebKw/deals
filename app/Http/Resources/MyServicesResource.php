<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class MyServicesResource extends JsonResource
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
        if ( $this->service->freelancer->blockedUser()->where('user_id', Auth::id())->first() != null  )
            $block = true;
        return [
            'id' => $this->id,
            'date' => $this->date,
            'updated_at' => $this->created_at,
            'created_at' => $this->created_at,
            'resource'=> [
                'name' => $this->service->name,
                'id' => $this->service->id,
                'date' => $this->date,
                'time' => $this->time,
                'images' => $this->service->images,
                'type' => 'service',
                'category' => $this->service->category->lan[0]->title,
                'category_id' => $this->service->category->id,
            ],
            'freelancer'=> [
                'name' => $this->service->freelancer->name,
                'id' => $this->service->freelancer->id,
                'email' => $this->service->freelancer->email,
                'image' => $this->service->freelancer->image,
                'phone' => $this->service->freelancer->phone,
                'block' => $block,
            ],
        ];
    }
}
