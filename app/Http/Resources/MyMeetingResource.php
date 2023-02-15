<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class MyMeetingResource extends JsonResource
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
        if ( $this->freelancer->blockedUser()->where('user_id', Auth::id())->first() != null  )
            $block = true;
        return [
            'id' => $this->id,
            'date' => $this->slot->date,
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
            'freelancer'=> [
                'name' => $this->freelancer->name,
                'id' => $this->freelancer->id,
                'email' => $this->freelancer->email,
                'image' => $this->freelancer->image,
                'phone' => $this->freelancer->phone,
                'block' => $block,
            ],
        ];
    }
}
