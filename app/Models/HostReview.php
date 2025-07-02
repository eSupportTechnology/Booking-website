<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HostReview extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['booking_id', 'property_id', 'host_id', 'guest_id', 'rating', 'comment'];
}
