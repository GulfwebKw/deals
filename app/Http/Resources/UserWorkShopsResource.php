<?php

namespace App\Http\Resources;

use App\User;
use App\WorkshopOrder;
use Illuminate\Http\Resources\Json\JsonResource;
use function foo\func;

class UserWorkShopsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $users = WorkshopOrder::where('workshop_id' , $this->id)->with('user')->get()->map(function ($data){
            return [
                'name' => $data->user->first_name . ' '.$data->user->last_name,
                'id' => $data->user->id,
                'email' => $data->user->email,
                'image' => $data->user->image,
                'phone' => $data->user->mobile,
                'count' => $data->people_count,
                'order_id' => $data->id,
                ];
        });
        return [
            'id' => $this->id,
            'date' => $this->date,
            'start_time' => $this->from_time,
            'end_time' => $this->to_time,
            'updated_at' => $this->created_at,
            'created_at' => $this->created_at,
            'resource'=> [
                'name' => $this->name,
                'id' => $this->id,
                'date' => $this->date,
                'time' => $this->from_time,
                'images' => $this->images,
                'type' => 'workshop',
                "category"=> null,
                "category_id"=> null
            ],
            'users'=> $users,
            'address' => [
                'name' => null,
                'country' => $this->area->city->country['title_'.app()->getLocale()],
                'area' => $this->area['title_'.app()->getLocale()],
                'city' => $this->area->city['title_'.app()->getLocale()],
                'block' => $this->block,
                'street' => $this->street,
                'avenue' => null,
                'house_apartment' => $this->house_apartment,
                'floor' => $this->floor,
                'lat' => null,
                'lng' => null,
                'address' => null,
            ],
        ];
    }
}
