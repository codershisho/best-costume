<?php

namespace App\Services;

use App\Models\TScrapeSite;
use Illuminate\Support\Facades\Log;

class AnotherScrape extends AbstractScrape
{
    protected static $_siteId = 2;

    public function scrapeFilter(): void
    {
        $title = $this->_crawler->filter('.panel > h1');
        $description = $this->_crawler->filter('div > div.panel-1 > table > tbody > tr:last-child > td');
        $price = $this->_crawler->filter('span.kakaku');
        $images = $this->_crawler->filter('li > a > img')->each(function ($el) {
            return ($el->attr('src'));
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
