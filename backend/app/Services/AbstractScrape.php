<?php

namespace App\Services;

use App\Models\TScrapeSite;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractScrape implements ScrapeInterface
{
    protected $_crawler;
    protected $_siteUrl;
    protected $_entity;

    /**
     * スクレイプ処理の開始
     *
     * @param string $siteUrl
     * @return void
     */
    public function scrape(string $siteUrl): void
    {
        $this->_siteUrl = $siteUrl;
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $siteUrl);
        $this->_crawler = new Crawler($response->getBody()->getContents());

        // 子クラスでサイトに応じたフィルタリング
        $this->scrapeFilter();
        // 保存
        $this->store();
    }

    /**
     * 各サイトに応じたフィルタリング
     *
     * @return void
     */
    abstract function scrapeFilter(): void;

    /**
     * スクレイプ結果の保存
     *
     * @return TScrapeSite
     */
    public function store(): TScrapeSite
    {
        return TScrapeSite::updateOrCreate(
            [
                'site_id' => $this->_entity['site_id'],
                'url' => $this->_entity['url'],
            ],
            [
                'title' => $this->_entity['title'],
                'description' => $this->_entity['description'],
                'price' => $this->_entity['price'],
            ]
        );
    }
}
