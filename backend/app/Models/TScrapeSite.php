<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TScrapeSite extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    public function msite()
    {
        return $this->belongsTo('App\Models\MScrapeSite', 'site_id', 'id');
    }
}
