<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MScrapeSite;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class WebScraping extends Controller
{
    /**
     * 登録済みのサイト一覧を返す
     *
     * @return void
     */
    public function site()
    {
        $data = MScrapeSite::all();
        return response()->json($data);
    }

    public function scrape(Request $request)
    {
        Logger($request);
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
