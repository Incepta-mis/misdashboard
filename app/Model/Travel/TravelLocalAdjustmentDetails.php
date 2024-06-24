<?php


namespace App\Model\Travel;


use Illuminate\Database\Eloquent\Model;

class TravelLocalAdjustmentDetails extends Model
{
    protected $table = "MIS.TRAVEL_LOCAL_ADJUST_DETAILS";
    protected $fillable = [
        'id',
        'document_no',
        'days',
        'accommodation',
        'breakfast',
        'launch',
        'dinner',
        'snacks',
        'rw_to_bus',
        'bus_to_rw',
        'lc',
        'da',
        'transport',
        'tips',
        'miscellaneous',
        'linetotal',
        'remarks',
        'created_at' ,
        'create_user',
        'updated_at',
        'update_user'
    ];
}