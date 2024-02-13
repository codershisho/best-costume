<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MCustomer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded  = ['id'];

    public function status()
    {
        return $this->hasOne('App\Models\MStatus', 'id', 'status_id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'customer_id', 'id');
    }
}
