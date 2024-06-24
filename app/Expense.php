<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    //
    protected $primaryKey = null;
    public $incrementing = false;

    protected $table='exp_expense_d';

    protected $fillable=[
        'EXP_DID',
        'EXP_ID',
        'EXP_DATE',
        'TOUR_TYPE',
        'TOUR_DETAILS',
        'DAILY_ALLOWANCE',
        'TA_DESCRIPTION',
        'TA_AMOUNT',
        'TA_IMAGE',
        'TA_IMAGE_STATUS',
        'CITY_FARE_ALLOWANCE',
        'OE_DESCRIPTION',
        'OE_AMOUNT',
        'OE_IMAGE',
        'OE_IMAGE_STATUS',
        'STATUS',
        'UPDATE_STATUS',
        'UPDATE_BY',
        'UPDATE_DATE',
        'CREATE_DATE',
        'EMP_ID',
        'CITY_FARE_ALLOWANCE_TYPE',
        'ADDITIONAL_AMOUNT'
    ];
    public $timestamps=false;
}
