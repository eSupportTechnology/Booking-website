<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyCategory extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyCategoryFactory> */
    use HasFactory;
    protected $fillable = ['name'];
    public function subcategories() {
        return $this->hasMany(PropertySubcategory::class, 'category_id');
    }

    public function properties() {
        return $this->hasMany(Property::class, 'category_id');
    }
}
