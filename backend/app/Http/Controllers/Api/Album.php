<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FileCategory;
use Illuminate\Support\Facades\Storage;

class Album extends Controller
{

    public function index()
    {
        $data = FileCategory::all();

        $data = $data->map(function ($file) {
            return [
                'category_id' => $file->category_id,
                'category_name' => $file->category->name,
                'image_url' => asset('storage/' . $file->file_path),
                'created_at' => $file->created_at
            ];
        });
        return response()->json($data);
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
}
