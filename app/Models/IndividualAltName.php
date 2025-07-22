<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndividualAltName extends Model
{
    use HasFactory;

    protected $fillable = [
        'individual_id',
        'alt_name',
    ];

    public function individual()
    {
        return $this->belongsTo(Individual::class);
    }
} 