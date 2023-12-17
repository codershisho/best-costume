<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Order extends Controller
{
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
                'product_id' => $request->id,
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        return response()->json([
            'message' => '注文登録完了しました'
        ]);
    }
}
