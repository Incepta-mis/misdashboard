<?php

namespace App\Model\Travel;

use Illuminate\Database\Eloquent\Model;

class TravelGradeWiseAllowance extends Model
{
    protected $table='MIS.TRAVEL_GRADE_WISE_ALLOWANCE';
    protected $fillable = ['grade', 'location'];
}
