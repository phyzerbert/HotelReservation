<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'name', 'email', 'stars', 'city', 'address', 'url', 'number_of_rooms', 'room_type',
    ];

    public function reservations(){
        return $this->hasMany('App\Models\Reservation');
    }
}
