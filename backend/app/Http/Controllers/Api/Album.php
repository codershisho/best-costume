<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Album extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('files')) {
            $files = $request->file('files');

            foreach ($files as $file) {
                // ファイルを保存するディレクトリパスを指定します
                $path = storage_path('app/public/uploads');

                // ファイル名を一意にするための処理を行います
                $fileName = uniqid() . '_' . $file->getClientOriginalName();

                // ファイルを指定したパスに保存します
                $file->move($path, $fileName);
            }

            return response()->json(['message' => 'ファイルがアップロードされました'], 200);
        }

        return response()->json(['message' => 'アップロードされたファイルがありません'], 400);
    }
}
