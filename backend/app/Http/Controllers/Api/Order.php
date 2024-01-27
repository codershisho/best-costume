<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\TOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Order extends Controller
{
    /**
     * 注文一覧検索
     *
     * @param Request $request
     * @return void
     */
    public function search(Request $request)
    {
        $query = TOrder::query();
        $query = $query->with([
            'customer',
            'product.site',
            'statuss'
        ]);

        // ステータスで絞り込み
        if ($request->filled('status_id')) {
            $query->where('status', $request->status_id);
        }
        // 顧客名で絞り込み
        if ($request->filled('name')) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        $data = $query->paginate(100);
        return OrderResource::collection($data);
    }


    /**
     * 注文登録
     *
     * @param Request $request
     * @return void
     */
    public function store($id, Request $request)
    {
        try {
            DB::beginTransaction();

            TOrder::create([
                'customer_id' => $id,
                'product_id' => $request->product_id,
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        return response()->json(['message' => '登録しました']);
    }

    /**
     * 注文ステータス更新
     *
     * @param int $id customer_id
     * @param int $order_id order_id
     * @param Request $request
     * @return void
     */
    public function update($id, $order_id, Request $request)
    {
        try {
            DB::beginTransaction();

            $model = TOrder::findOrFail($order_id);
            $model->status = $request->status_id;
            $model->save();

            DB::commit();
            return response()->json(['message' => '更新しました']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
