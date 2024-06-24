<?php


namespace App\Model\Travel;


use Illuminate\Database\Eloquent\Model;

class TravelInternationalNoteSheetDetails extends Model
{
    protected $table = 'MIS.TRAVEL_INTL_NOTE_SHEET_DETAILS';
    protected $fillable = [
        'id',
        'document_no',
        'group_no',
        'day',
        'conversion_rate',
        'air_fare',
        'air_fare_day',
        'air_fare_night',
        'hotel',
        'hotel_day',
        'hotel_night',

        'meals',
        'meals_day',
        'meals_night',

        'incidentals',
        'incidentals_day',
        'incidentals_night',

        'da',
        'da_day',
        'da_night',

        'others',
        'linetotal',
        'created_at',
        'create_user',
        'updated_at',
        'update_user'
    ];
}

