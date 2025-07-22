<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Individual extends Model
{
    use HasFactory;

    protected $fillable = [
        'accommodation_id',
        'first_name',
        'last_name',
        'date_of_birth',
    ];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }

    public function altNames()
    {
        return $this->hasMany(IndividualAltName::class);
    }
} 