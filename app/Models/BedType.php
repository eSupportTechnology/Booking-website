<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BedType extends Model
{
    protected $fillable = ['name'];

    public function roomBeds()
    {
        return $this->hasMany(RoomBed::class);
    }
}