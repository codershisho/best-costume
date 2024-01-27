<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MStatus;
use App\Models\TOrder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Status extends Controller
{
    public function index()
    {
        $data = MStatus::all();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $model = new MStatus();
            $model->fill($request->all());
            $model->save();

            DB::commit();
            return response()->json(['message' => '登録しました']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function update($id, Request $request)
    {
        try {
            DB::beginTransaction();

            $model = MStatus::findOrFail($id);
            $model->update($request->all());

            DB::commit();
            return response()->json(['message' => '更新しました']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            // ステータスを使用しているデータがあるかチェック
            $orders = TOrder::where('status', $id)->get();
            if ($orders->count() > 0) {
                throw new Exception("ステータスが紐づいている注文があるため削除できません。");
            }

            MStatus::destroy($id);

            DB::commit();
            return response()->json(['message' => '削除しました']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
