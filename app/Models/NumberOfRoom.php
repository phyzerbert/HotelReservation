<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NumberOfRoom extends Model
{
    protected $fillables = [
        'min', 'max',
    ];
}
