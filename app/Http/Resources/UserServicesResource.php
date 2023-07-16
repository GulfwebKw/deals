<?php

namespace App\Http\Resources;

use App\Address;
use Illuminate\Http\Resources\Json\JsonResource;

class UserServicesResource extends JsonResource
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
        if ( $this->user_location_id != null )
            $address = optional($this->user_location);
        elseif ($this->freelancer_location_id != null)
            $address = optional($this->freelancer_location);

        return [
            'id' => $this->id,
            'date' => $this->date,
            'start_time' => $this->timeSlot->start_time,
            'end_time' => $this->timeSlot->end_time,
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
            'users'=> [
                [
                    'name' =>  $this->order->user->first_name . ' '.$this->order->user->last_name,
                    'id' => $this->order->user->id,
                    'email' => $this->order->user->email,
                    'phone' => $this->order->user->mobile,
                    'image' => $this->order->user->image,
                    'count' => $this->people,
                    'order_id' => $this->order->id,
                ],
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
