<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = ['name'];

    /**
     * Get the properties that speak this language.
     */
    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_language');
    }
}
