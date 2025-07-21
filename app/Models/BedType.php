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

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'bed_room')->withPivot('count')->withTimestamps();
    }
}