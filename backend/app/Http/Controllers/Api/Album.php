<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AlbumResource;
use Illuminate\Http\Request;
use App\Models\FileCategory;
use Illuminate\Support\Facades\Storage;

class Album extends Controller
{

    public function index(Request $request)
    {
        $query = FileCategory::query();
        if ($request->has('category_id') && isset($request->category_id) && $request->category_id != 1) {
            $query->where('category_id', $request->category_id);
        }
        $data = $query->paginate(10);
        return AlbumResource::collection($data);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            $categoryId = $request->selectedCategory;

            FileCategory::uploadFiles($files, $categoryId);

            return response()->json(['message' => 'ファイルがアップロードされました'], 200);
        }

        return response()->json(['message' => 'アップロードされたファイルがありません'], 400);
    }

    /**
     * アルバムの削除
     * - 配列でidでわたってくる
     *
     * @param Request $request
     * @return void
     */
    public function delete(Request $request)
    {
        $ids = collect($request->ids);
        $ids->each(function ($id) {
            // データの削除
            $m = FileCategory::find($id);
            $m->delete();

            // 実ファイルの削除
            $filePath = $m->file_path;
            Storage::disk('public')->delete($filePath);
        });
        return response()->json(['message' => 'アルバムを削除しました。']);
    }
}
