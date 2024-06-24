<?php


namespace App\Model\Travel;


use Illuminate\Database\Eloquent\Model;

class TravelLocalAdjustment extends Model
{
    protected $table='MIS.TRAVEL_LOCAL_ADJUSTMENT';
    protected $fillable = [
        'id',
        'adjustment_status',
        'adjustment_details',
        'document_no',
        'emp_id',
        'emp_name',
        'grade',
        'desig_name',
        'dept_name',
        'purpose',
        'cost_center_id',
        'cost_center_name',
        'gl_code',
        'from_loc',
        'to_loc',
        'destination',
        'from_time',
        'to_time',
        'days',
        'accommodation',
        'meals',
        'incidentals',
        'da',
        'means_of_transport',
        'transport',
        'others',
        'linetotal',
        'created_at',
        'create_user'
    ];
}