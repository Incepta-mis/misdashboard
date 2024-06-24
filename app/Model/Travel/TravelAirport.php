<?php

namespace App\Model\Travel;

use Illuminate\Database\Eloquent\Model;

class TravelAirport extends Model
{
    protected $table = "mis.travel_airport";
    protected $fillable = [
        'id',
        'country',
        'city',
        'airport_name',
        'iata',
        'created_at' ,
        'create_user',
        'updated_at',
        'update_user'
    ];
}
