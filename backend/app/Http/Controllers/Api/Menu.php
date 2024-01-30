<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MMenu;
use App\Models\MProduct;
use Illuminate\Http\Request;

class Menu extends Controller
{
    public function index()
    {
        $data = MMenu::with(['children'])->whereNull('parent_id')->get();

        $data = $data->map(function ($parent) {
            $children = collect($parent['children']);
            $parent['children'] = $children->map(function ($child) {
                $count = MProduct::where('category_id', $child['id'])->count();
                $child['count'] = $count;
                return $child;
            });
            return $parent;
        });

        return response()->json([
            'data' => $data,
            'message' => ''
        ]);
    }
}
