<?php

namespace App\Services;

use InvalidArgumentException;

class ScrapeFactory
{
    /**
     * サイトに応じて処理するクラスを作成
     *
     * @param int $siteId
     * @return ScrapeInterface
     */
    public static function create(int $siteId): ScrapeInterface
    {
        switch ($siteId) {
            case 1:
                return new RencaScrape();
            case 2:
                return new AnotherScrape();
            default:
                throw new InvalidArgumentException('factoryの生成に失敗しました');
        }
    }
}
