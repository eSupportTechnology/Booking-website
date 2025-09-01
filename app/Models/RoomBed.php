<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomBed extends Model
{
    protected $fillable = ['room_id', 'bed_type_id', 'count'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function bedType()
    {
        return $this->belongsTo(BedType::class);
    }
}
