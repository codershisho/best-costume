<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

/**
 * RENCAサイトのスクレイプ処理
 */
class RencaScrape extends AbstractScrape
{
    protected static $_siteId = 1;

    public function scrapeFilter(): void
    {
        $title = $this->_crawler->filter('.box_item_det > h3');
        $description = $this->_crawler->filter('.detail_description');
        $price = $this->_crawler->filter('.pri > span');
        $images = $this->_crawler->filter('li > img')->each(function ($el) {
            return ($el->attr('data-lazy'));
        });
        $images = $this->selectImages($images);

        $this->_entity = [
            'site_id' => self::$_siteId,
            'url' => $this->_siteUrl,
            'title' => $title->text(),
            'description' => $description->text(),
            'price' => preg_replace('/[^0-9]/', '', $price->text()),
            'images' => implode(',', $images)
        ];
    }

    /**
     * サイズ違いで同じ画像が取れてしまうのでサイズが大きいほうのみで抽出する
     *
     * @param array $images
     * @return array
     */
    private function selectImages(array $images)
    {
        $imageCollection = collect($images);
        // nullを除外する
        $imageCollection = $imageCollection->filter(function ($item) {
            return $item !== null;
        });

        $imageNames = $imageCollection->map(function ($image) {
            $pattern = '/\_(.*)/';
            preg_match($pattern, $image, $matches);
            return $matches[1] ?? null;
        })->filter()->unique()->values();


        $result = $imageNames->map(function ($name) use ($imageCollection) {
            $filteredArray = [];
            $foundIndexes = [];
            foreach ($imageCollection as $index => $element) {
                if (is_string($element) && strpos($element, $name) !== false) {
                    // 同じ要素が既に見つかっていないか確認
                    if (!in_array($element, $foundIndexes, true)) {
                        // 新しい配列に追加
                        $filteredArray[] = $element;
                        // 既に見つかった要素を登録
                        $foundIndexes[] = $element;
                    }
                }
            }
            return $filteredArray[0];
        })->values()->toArray();

        return $result;
    }
}
