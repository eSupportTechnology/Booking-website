<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertySubtype extends Model
{
    use HasFactory;
    protected $fillable = ['subcategory_id', 'name'];
    public function subcategory() {
        return $this->belongsTo(PropertySubcategory::class);
    }
}
