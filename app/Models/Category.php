<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    // Relasi ke Facility (One-to-Many)
    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }
    // Relasi ke SubCategory (One-to-Many)
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
