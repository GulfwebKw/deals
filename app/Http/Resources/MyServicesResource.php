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
        $address = optional();
        if ( $this->user_location_id != null )
            $address = optional($this->user_location);
        elseif ($this->freelancer_location_id != null)
            $address = optional($this->freelancer_location);

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
            'address' => [
                'name' => $address->full_name,
                'country' => $address->country,
                'area' => $address->area,
                'city' => $address->city,
                'block' => $address->block,
                'street' => $address->street,
                'avenue' => $address->avenue,
                'house_apartment' => $address->house_apartment,
                'floor' => $address->floor,
                'lat' => $address->lat,
                'lng' => $address->lng,
                'address' => $address->address,
            ],
        ];
    }
}
