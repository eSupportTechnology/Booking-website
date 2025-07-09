<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['sender_id', 'receiver_id', 'booking_id', 'content', 'is_read'];
}
