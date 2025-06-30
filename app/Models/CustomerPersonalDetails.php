<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPersonalDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'display_name',
        'phone_number',
        'date_of_birth',
        'nationality',
        'gender',
        'address',
        'passport_details',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
