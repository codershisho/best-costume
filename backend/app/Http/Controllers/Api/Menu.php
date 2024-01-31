<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MMenu;
use Illuminate\Http\Request;

class Menu extends Controller
{
    public function index()
    {
        $data = MMenu::with('children')->whereNull('parent_id')->get();
        return response()->json([
            'data' => $data,
            'message' => ''
        ]);
    }
}
