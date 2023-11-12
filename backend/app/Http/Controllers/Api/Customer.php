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
     * @return void
     */
    public function index()
    {
        $data = MCustomer::with('status')->paginate(10);
        return CustomerResource::collection($data);
    }

    /**
     * 検索条件に合致したデータを検索
     *
     * @param Request $request
     * @return void
     */
    public function search(Request $request)
    {
        $q = MCustomer::query();
        if ($request->has('name')) {
            $q->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->has('status_id')) {
            $q->where('status_id', $request->status_id);
        }
        $data = $q->with('status')->paginate(10);
        return CustomerResource::collection($data);
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
