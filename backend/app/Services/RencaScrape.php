<?php

namespace App\Services;

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
        // TODO imageのスクレイプ&保存

        $this->_entity = [
            'site_id' => self::$_siteId,
            'url' => $this->_siteUrl,
            'title' => $title->text(),
            'description' => $description->text(),
            'price' => preg_replace('/[^0-9]/', '', $price->text()),
        ];
    }
}
