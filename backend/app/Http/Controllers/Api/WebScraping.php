<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Symfony\Component\DomCrawler\Crawler;

class WebScraping extends Controller
{
    public function scrape()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://renca.jp/item/WWYY5004000');
        $crawler = new Crawler($response->getBody()->getContents());
        $name = $crawler->filter('.box_item_det > h3');
        // Logger($name);
        return response()->json([
            'msg' => $name->text()
        ]);
    }
}
