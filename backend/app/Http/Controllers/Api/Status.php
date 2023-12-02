<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MStatus;
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
            return response()->json([
                'message' => 'ステータス登録完了'
            ]);
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
            return response()->json([
                'message' => 'ステータス更新完了'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
