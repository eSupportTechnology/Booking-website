<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'reg_number', 'rating', 'cancellation_policy'];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
