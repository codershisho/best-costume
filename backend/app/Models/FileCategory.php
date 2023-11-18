<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\MCategory;

class FileCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(MCategory::class);
    }

    public static function uploadFiles($files, $categoryId)
    {
        foreach ($files as $file) {
            $fileName = uniqid() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('public/uploads', $fileName);

            self::create([
                'file_path' => $filePath,
                'category_id' => $categoryId,
            ]);
        }
    }
}
