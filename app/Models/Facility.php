<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'code',
        'description',
        'is_available',
        'subcategory_id',
        'capacity',
    ];

    // Relasi ke Category (Many-to-One)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    // Relasi ke SubCategory (Many-to-One)
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
