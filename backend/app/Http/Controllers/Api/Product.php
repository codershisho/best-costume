<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductEditRequest;
use App\Http\Resources\ProductDetailResource;
use App\Http\Resources\ProductResource;
use App\Models\MProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Product extends Controller
{
    /**
     * 検索処理
     *
     * @return void
     */
    public function search(Request $request)
    {
        $customerId = $request->customer_id;
        $query = MProduct::query();
        $query->orderBy('created_at', 'desc');
        $query = $query->with([
            'site',
            'site.msite',
            'menu',
            'menu.parent',
            'favorite' => function ($query) use ($customerId) {
                // 各ユーザーのお気に入り情報も一緒に取る
                $query->where('customer_id', $customerId);
            }
        ]);
        // カテゴリーで絞り込み
        if ($request->has('category')) {
            $query = $query->where('category_id', $request->category);
        }
        // 衣装名で絞り込み
        if ($request->has('searchText')) {
            $query = $query->where('name', 'like', '%' . $request->searchText . '%');
        }
        // お気に入り検索
        if ($request->has('isLikeSearch') && $request->isLikeSearch == 'true') {
            $query = $query->whereHas('favorite', function ($q) {
                $q->whereNotNull('id');
            });
        }
        $data = $query->paginate(50);
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
        $data = MProduct::with('site', 'menu.parent')->findOrFail($id);
        return response()->json([
            'data' => new ProductDetailResource($data),
            'message' => ''
        ]);
    }

    public function store(ProductRequest $request)
    {
        try {
            DB::beginTransaction();

            // 外部サイトからの商品登録の場合のみ
            // if ($request->scrape_site_id != 0) {
            //     // 既存サイトとかぶってないかチェック
            //     $isExist = MProduct::where('scrape_site_id', $request->scrape_site_id)->exists();
            //     if ($isExist) {
            //         throw new Exception('すでにそのサイトは商品登録済みです');
            //     }
            // }

            $model = new MProduct();
            $model->fill($request->all());
            $model->save();

            if ($request->hasFile('files')) {
                $files = $request->file('files');
                $productId = $model->id;
                foreach ($files as $file) {
                    $fileName = uniqid() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('public/ownProducts/' . $productId, $fileName);
                    $filePath = str_replace('public/', '', $filePath);
                }
            }

            DB::commit();

            return response()->json(['message' => '登録しました']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function update($id, Request $request)
    {
        logger($id);
        logger($request->all());
        try {
            DB::beginTransaction();

            $m = MProduct::findOrFail($id);
            $m->name = $request['name'];
            $m->category_id = $request['category_id'];
            $m->price = (int)str_replace(',', '', $request['price']);
            $m->description = $request['description'];
            $m->save();

            if ($request->hasFile('files')) {
                // すでにアップ済みの全画像を削除⇒アップロードされた画像を配置
                Storage::disk('public')->deleteDirectory('ownProducts/' . $id);
                $files = $request->file('files');
                $productId = $id;
                foreach ($files as $file) {
                    $fileName = uniqid() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('public/ownProducts/' . $productId, $fileName);
                    $filePath = str_replace('public/', '', $filePath);
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        return response()->json(['message' => '更新しました']);
    }

    public function delete(Request $request)
    {
        try {
            DB::beginTransaction();

            $ids = collect($request->ids)->toArray();
            MProduct::destroy($ids);

            DB::commit();
            return response()->json(['message' => '削除しました']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
