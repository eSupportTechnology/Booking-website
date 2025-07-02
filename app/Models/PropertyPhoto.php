<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyPhoto extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['property_id', 'photo_url', 'is_cover'];
    public function property() {
        return $this->belongsTo(Property::class);
    }
}
