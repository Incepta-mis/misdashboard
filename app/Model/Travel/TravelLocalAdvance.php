<?php


namespace App\Model\Travel;


use Illuminate\Database\Eloquent\Model;

class TravelLocalAdvance extends Model
{
    protected $table='MIS.TRAVEL_LOCAL_ADVANCE';
    protected $fillable = [
        'document_no',
        'id',
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