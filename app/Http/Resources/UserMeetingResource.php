<?php

namespace App\Http\Resources;

use App\Address;
use Illuminate\Http\Resources\Json\JsonResource;

class UserMeetingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $address = new Address();
        if ( $this->area_id != null )
            $address = optional($this->userLocation);
        if ($this->location_id != null)
            $address = optional($this->location);

        return [
            'id' => $this->id,
            'date' => $this->slot->date,
            'start_time' => $this->slot->start_time,
            'end_time' => $this->slot->end_time,
            'updated_at' => $this->created_at,
            'created_at' => $this->created_at,
            'resource'=> [
                'name' => null,
                'id' => null,
                'date' => $this->date,
                'time' => $this->time,
                'images' => null,
                'type' => 'meeting',
                "category"=> null,
                "category_id"=> null
            ],
            'users'=> [
                [
                    'name' => $this->user->first_name . ' '.$this->user->last_name,
                    'id' => $this->user->id,
                    'email' => $this->user->email,
                    'phone' => $this->user->mobile,
                    'image' => $this->user->image,
                    'count' => 1,
                    'order_id' => $this->id,
                ]
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
