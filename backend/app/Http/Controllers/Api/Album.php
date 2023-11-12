<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Album extends Controller
{
    public function upload(Request $request)
    {
        Logger("aaaa");
        Logger($request->all());
        $files = $request->file('file');

        logger($files);
        // foreach ($files as $index => $file) {
        //     $fileName = $file->getClientOriginalName();
        //     $file->storeAS('public', $fileName);
        // }
    }
}
