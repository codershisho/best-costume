<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MCategory;

class Category extends Controller
{
    public function index()
    {
        return MCategory::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        return MCategory::create($data);
    }

    public function show(MCategory $mCategory)
    {
        return $mCategory;
    }

    public function update(Request $request, MCategory $mCategory)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $mCategory->update($data);

        return $mCategory;
    }

    public function destroy(MCategory $mCategory)
    {
        $mCategory->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
