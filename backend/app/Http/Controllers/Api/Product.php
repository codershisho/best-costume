<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\MProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Product extends Controller
{
    public function index()
    {
    }

    public function store(ProductRequest $request)
    {
        try {
            DB::beginTransaction();

            // 既存サイトとかぶってないかチェック
            $isExist = MProduct::where('scrape_site_id', $request->scrape_site_id)->exists();
            if ($isExist) {
                throw new Exception('すでにそのサイトは商品登録済みです');
            }

            $model = new MProduct();
            $model->fill($request->all());
            $model->save();

            DB::commit();

            return response()->json(['message' => '商品登録完了しました']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
