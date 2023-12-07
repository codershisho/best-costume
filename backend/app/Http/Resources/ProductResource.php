<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'scrape_site_id' => $this->scrape_site_id,
            'name' => $this->name,
            'category_id' => $this->category_id,
            'thumbnail' => $this->thumbnail(),
        ];
    }

    /**
     * 最初のメイン画像をサムネイル用で返す
     *
     * @return void
     */
    private function thumbnail()
    {
        $images = explode(",", $this->site->images);
        return $images[0];
    }
}
