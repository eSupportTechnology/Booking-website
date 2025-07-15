<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertySubcategory extends Model
{
    /** @use HasFactory<\Database\Factories\PropertySubcategoryFactory> */
    use HasFactory;
    protected $fillable = ['category_id', 'name'];
    public function category() {
        return $this->belongsTo(PropertyCategory::class, 'category_id');
    }
    public function subtypes() {
        return $this->hasMany(PropertySubtype::class, 'subcategory_id');
    }
}
