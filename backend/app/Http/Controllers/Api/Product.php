<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductDetailResource;
use App\Http\Resources\ProductResource;
use App\Models\MProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Product extends Controller
{
    /**
     * 検索処理
     *
     * @return void
     */
    public function search()
    {
        $data = MProduct::with('site')->paginate(50);
        return ProductResource::collection($data);
    }

    /**
     * id検索
     *
     * @param int $id
     * @return void
     */
    public function show(int $id)
    {
        $data = MProduct::with('site')->findOrFail($id);
        return response()->json([
            'data' => new ProductDetailResource($data),
            'message' => '検索完了しました。'
        ]);
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
