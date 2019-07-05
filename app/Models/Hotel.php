<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'name', 'stars', 'city', 'address', 'number_of_rooms', 'room_type',
    ];

    public function reservations(){
        return $this->hasMany('App\Models\Reservation');
    }
}
