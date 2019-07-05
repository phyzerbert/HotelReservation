<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'visitor_name',
        'visitor_email',
        'visitor_phone_number',
        'visit_date',
        'id_number',
        'passport_id',
        'passport_image',
        'number_of_rooms',
        'hotel_id',
        'check_in_date',
        'check_out_date',
        'room_type',
        'note',
    ];

    public function companions(){
        return $this->hasMany('App\Models\Companion');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function hotel(){
        return $this->belongsTo('App\Models\Hotel');
    }
}
