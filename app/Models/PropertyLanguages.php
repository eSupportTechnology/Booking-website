<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyLanguages extends Model
{
    use HasFactory;
    protected $fillable = ['property_id', 'language_id'];
    public $timestamps = false;
}
