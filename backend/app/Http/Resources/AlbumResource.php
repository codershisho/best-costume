<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'category_id' => $this->category_id,
            'category_name' => $this->category->name,
            'category_color' => $this->category->color,
            'image_url' => asset('storage/' . $this->file_path),
            'created_at' => $this->created_at->format('Y-m-d h:i:s')
        ];
    }
}
