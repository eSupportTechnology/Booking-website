<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_type',
        'path',
        'property_type',
        'property_id',
    ];

    // Optional: Define the relationship to Property
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

     public function files()
    {
        return $this->hasMany(File::class);
    }
}
