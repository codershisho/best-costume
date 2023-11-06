<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\MCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Customer extends Controller
{
    /**
     * 顧客一覧を返す
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $data = MCustomer::with('status')->get();
        return response()->json(CustomerResource::collection($data));
    }

    /**
     * 顧客の新規登録
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $m = new MCustomer();
            $m->fill($request->all());
            $m->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
