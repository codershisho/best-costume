<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FileCategory;
use Illuminate\Http\Request;
use App\Models\MCategory;
use Exception;
use Illuminate\Support\Facades\DB;

class Category extends Controller
{
    public function index()
    {
        return MCategory::all();
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $model = new MCategory();
            $model->fill($request->all());
            $model->save();

            DB::commit();
            return response()->json([
                'message' => 'カテゴリー登録完了'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function show(MCategory $mCategory)
    {
        return $mCategory;
    }

    public function update($id, Request $request)
    {
        try {
            DB::beginTransaction();

            $model = MCategory::findOrFail($id);
            $model->update($request->all());

            DB::commit();
            return response()->json([
                'message' => 'カテゴリー更新完了'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            // 紐づいているアルバムのデータがないかチェック
            $data = FileCategory::where('category_id', $id)->get();
            if ($data->count() > 0) {
                throw new Exception('カテゴリーが紐づいているアルバムがあるため削除できません。');
            }

            MCategory::destroy($id);

            DB::commit();
            return response()->json([
                'message' => 'カテゴリー削除完了'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
