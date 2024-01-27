<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TFavorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Favorite extends Controller
{

    public function search(Request $request)
    {
    }

    public function store($id, Request $request)
    {
        try {
            DB::beginTransaction();

            $query = TFavorite::query();
            $query = $query->withTrashed();
            $data = $query->where('customer_id', $id)
                ->where('product_id', $request->id)
                ->first();
            if (isset($data)) {
                // 存在するとき
                if (isset($data->deleted_at)) {
                    // 削除扱いを解除
                    $data->restore();
                } else {
                    // 削除
                    $data->delete();
                }
            } else {
                // 存在しない
                TFavorite::create([
                    'customer_id' => $id,
                    'product_id' => $request->id,
                ]);
            }

            DB::commit();
            return response()->json(['message' => '登録しました']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
