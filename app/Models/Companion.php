<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Companion extends Model
{
    protected $fillable = [
        'reservation_id', 'name', 'id_number', 'phone_number',
    ];

    public function reservation(){
        return $this->belongsTo('App\Models\Reservation');
    }
}
