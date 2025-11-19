<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertySubcategory extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name'];

    public function category()
    {
        return $this->belongsTo(PropertyCategory::class);
    }

    public function subtypes()
    {
        return $this->hasMany(PropertySubtype::class, 'subcategory_id');
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'subcategory_id');
    }
}