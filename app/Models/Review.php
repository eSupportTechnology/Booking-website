<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['booking_id', 'property_id', 'user_id', 'rating', 'comment'];
}
