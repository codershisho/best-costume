<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\MCustomer;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Customer extends Controller
{
    /**
     * 顧客一覧を返す
     *
     * @return void
     */
    public function index()
    {
        $data = MCustomer::with(['status', 'user'])->paginate(100);
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

            $customerId = $m->id;
            $digit = strlen((string)$customerId);
            $addZero = 5 - $digit;
            $userName = 'user';
            for ($i = 0; $i < $addZero; $i++) {
                $userName = $userName . '0';
            }
            $userName = $userName . (string)$customerId;

            $u = new User();
            $u->name = $userName;
            $plane = Str::random(6);
            $u->password = Hash::make($plane);
            $u->password_plane = $plane;
            $u->customer_id = $customerId;
            $u->save();

            DB::commit();
            return response()->json(['message' => '登録しました']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * 顧客情報の更新
     *
     * @param [type] $id
     * @param Request $request
     * @return void
     */
    public function update($id, Request $request)
    {
        try {
            DB::beginTransaction();

            $m = MCustomer::find($id);
            $m->fill($request->all());
            $m->save();

            DB::commit();
            return response()->json(["message" => '更新しました']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
