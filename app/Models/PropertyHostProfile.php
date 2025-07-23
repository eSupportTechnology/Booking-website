<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyHostProfile extends Model
{
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
}
