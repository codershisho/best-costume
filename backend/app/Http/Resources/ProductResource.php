<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'scrape_site_id' => $this->scrape_site_id,
            'name' => $this->name,
            'category_id' => $this->category_id,
            'price' => number_format($this->price),
            'description' => $this->description,
            'thumbnail' => $this->thumbnail(),
            'favorite' => $this->getFavorite(),
            'site' => $this->site->msite ?? '',
            'scrape_site' => $this->site,
            'menu' => $this->getMenu(),
            'updated_at' => $this->updated_at->format('Y-m-d'),
        ];
    }

    /**
     * 最初のメイン画像をサムネイル用で返す
     *
     * @return void
     */
    private function thumbnail()
    {
        if (!isset($this->site->images)) {
            // 自前の衣装の場合storageから画像をとってくる
            $files = Storage::files('public/ownProducts/' . $this->id);
            if (empty($files)) {
                return '';
            }
            $thumbnail = $files[0];
            $thumbnail = str_replace('public/', '', $thumbnail);
            return asset('storage/' . $thumbnail);
        }
        $images = explode(",", $this->site->images);
        return $images[0];
    }

    /**
     * 該当商品をお気に入り登録しているか判定
     *
     * @return void
     */
    private function getFavorite()
    {
        if (isset($this->favorite)) {
            return true;
        }
        return false;
    }

    /**
     * 親メニューと子メニュー名を結合して返す
     *
     * @return void
     */
    private function getMenu()
    {
        $menuName = $this->menu->name;
        $parentMenuName = $this->menu->parent->name;
        return $parentMenuName . ' > ' . $menuName;
    }
}
