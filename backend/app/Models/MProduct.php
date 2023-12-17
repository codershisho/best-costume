<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MProduct extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded  = ['id'];

    public function site()
    {
        return $this->belongsTo('App\Models\TScrapeSite', 'scrape_site_id', 'id');
    }

    public function menu()
    {
        return $this->belongsTo('App\Models\MMenu', 'category_id', 'id');
    }

    public function favorite()
    {
        return $this->belongsTo('App\Models\TFavorite', 'id', 'product_id');
    }
}
