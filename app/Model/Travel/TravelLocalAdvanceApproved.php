<?php


namespace App\Model\Travel;


use Illuminate\Database\Eloquent\Model;

class TravelLocalAdvanceApproved extends Model
{

    protected $table='MIS.TRAVEL_LOCAL_ADVANCE_APPR';
    protected $fillable = [
        'id',
        'document_no',
        'emp_id',
        'emp_name',
        'location',
        'amount',
        'sup_id',
        'sup_accept',
        'sup_accept_date',
        'dept_head_id',
        'dept_accept',
        'dept_accept_date',
        'created_at' ,
        'create_user',
        'status'
    ];
}