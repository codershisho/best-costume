<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MStatus;
use Illuminate\Http\Request;

class Status extends Controller
{
    public function index()
    {
        $data = MStatus::all();
        return response()->json($data);
    }
}
