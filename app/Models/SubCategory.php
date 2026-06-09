<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'is_active',
    ];

    // Relasi ke Category (Many-to-One)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
