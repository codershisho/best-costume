<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MScrapeSite;
use App\Http\Requests\ScrapeSiteRequest;
use App\Services\ScrapeFactory;

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

    /**
     * スクレイプ処理
     *
     * @param ScrapeSiteRequest $request
     * @return void
     */
    public function scrape(ScrapeSiteRequest $request)
    {
        $siteId = $request->site_id;
        $siteUrl = $request->url;

        $service = ScrapeFactory::create($siteId);
        $service->scrape($siteUrl);

        return response()->json([
            'message' => 'データ登録しました。'
        ]);
    }
}
