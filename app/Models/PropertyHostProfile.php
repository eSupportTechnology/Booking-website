<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyHostProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'about_property',
        'about_host',
        'about_neighborhood',
        'show_property',
        'show_host',
        'show_neighborhood',
        'none_selected',
        'host_name'
    ];

    protected $casts = [
        'show_property' => 'boolean',
        'show_host' => 'boolean',
        'show_neighborhood' => 'boolean',
        'none_selected' => 'boolean'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}