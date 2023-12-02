<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MCategory;
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

    public function destroy(MCategory $mCategory)
    {
        $mCategory->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
