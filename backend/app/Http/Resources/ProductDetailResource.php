<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'scrape_site_id' => $this->scrape_site_id,
            'name' => $this->name,
            'category_id' => $this->category_id,
            'category_name' => $this->menu->name,
            'price' => $this->price(),
            'description' => $this->description(),
            'images' => $this->images(),
        ];
    }

    /**
     * 円表示
     *
     * @return void
     */
    private function price()
    {
        return '￥' . number_format($this->price);
    }

    /**
     * 商品説明
     * - 自前で登録してない場合はスクレイプ先の説明文に代替え
     *
     * @return void
     */
    private function description()
    {
        if (isset($this->description)) {
            return $this->description;
        }
        return $this->site->description;
    }

    /**
     * スクレイプした全画像をカンマ区切りを配列にして返す
     *
     * @return void
     */
    private function images()
    {
        if (!isset($this->site->images)) {
            // 自前の衣装の場合storageから画像をとってくる
            $files = Storage::files('public/ownProducts/' . $this->id);
            if (empty($files)) {
                return '';
            }
            $images = collect($files)->map(function ($path) {
                $path = str_replace('public/', '', $path);
                return asset('storage/' . $path);
            });
            return $images;
        }
        return explode(",", $this->site->images);
    }
}
