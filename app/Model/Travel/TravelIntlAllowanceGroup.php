<?php


namespace App\Model\Travel;


use Illuminate\Database\Eloquent\Model;

class TravelIntlAllowanceGroup extends Model
{
    protected $table = "mis.travel_intl_allowance_group";
    protected $fillable = [
        'ID',
        'DOCUMENT_NO',
        'GROUP_NO',
        'FROM_LOC',
        'TO_LOC',
        'FROM_DATE',
        'TO_DATE',
        'BD_FROM_TIME',
        'BD_TO_TIME',
        'FG_FROM_TIME',
        'FG_TO_TIME',
        'ACCOMMODATION',
        'AIR_FAIR',
        'HOTEL',
        'MEALS',
        'INCIDENTALS',
        'DA',
        'OTHERS',
        'DAY',
        'NIGHT',
        'CONVERSION_RATE',
        'LINETOTAL',
        'TOTAL',
        'CREATED_AT',
        'CREATE_USER',
        'UPDATED_AT',
        'UPDATE_USER'
    ];
}