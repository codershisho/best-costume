<?php

namespace App\Services;

use App\Models\TScrapeSite;

interface ScrapeInterface
{
    /**
     * スクレイプ処理
     *
     * @param string $siteUrl
     * @return void
     */
    public function scrape(string $siteUrl): TScrapeSite;
}
