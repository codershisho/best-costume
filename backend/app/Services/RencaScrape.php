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

        $this->_entity = [
            'site_id' => self::$_siteId,
            'url' => $this->_siteUrl,
            'title' => $title->text(),
            'description' => $description->text(),
            'price' => preg_replace('/[^0-9]/', '', $price->text()),
            'images' => implode(',', $images)
        ];
    }
}
