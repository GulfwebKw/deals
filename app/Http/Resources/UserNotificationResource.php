<?php

namespace App\Http\Resources;

use App\UserNotification;
use Illuminate\Http\Resources\Json\JsonResource;

class UserNotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $userNotification = UserNotification::find($this->id);
        $userNotification = $userNotification->toArray();
        unset($userNotification['created_at']);
        unset($userNotification['updated_at']);
        return [
            'id' => $this->id,
            'date' => $this->date,
            'updated_at' => $this->created_at,
            'created_at' => $this->created_at,
            'resource' => array_merge([
                // 'id' => $this->id,
                // 'user_id' => $this->user_id,
                // 'image' => $this->image,
                // 'description_html_en' => $this->description_html_en,
                // 'description_html_ar' => $this->description_html_ar,
                // 'description_en' => $this->description_en,
                // 'description_ar' => $this->description_ar,
                // 'freelancer_id' => $this->freelancer_id,
                // 'data' => $this->data,
                'type' => 'notification'
            ],$userNotification),
            // 'user' => [
            //         'name' =>  $this->user->first_name . ' ' . $this->user->last_name,
            //         'id' => $this->user->id,
            //         'email' => $this->user->email,
            //         'phone' => $this->user->mobile,
            //         'image' => $this->user->image,
            //         'count' => $this->people,
            //         'order_id' => $this->id,
            // ],
        ];
    }
}
