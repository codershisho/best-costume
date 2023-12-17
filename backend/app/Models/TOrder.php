<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TOrder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    public function customer()
    {
        return $this->belongsTo('App\Models\MCustomer', 'customer_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\MProduct', 'product_id', 'id');
    }

    public function statuss()
    {
        return $this->belongsTo('App\Models\MStatus', 'status', 'id');
    }
}
