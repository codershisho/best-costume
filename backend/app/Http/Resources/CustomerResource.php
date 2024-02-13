<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'visit_date' => $this->visit_date,
            'status_id' => $this->status_id,
            'status_name' => $this->status->name,
            'status_color' => $this->status->color,
            'login_id' => $this->user->name,
            'login_pass' => $this->user->password_plane,
        ];
    }
}
