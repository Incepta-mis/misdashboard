<?php


namespace App\Model\Travel;


use Illuminate\Database\Eloquent\Model;

class TravelIntlReqApproved extends Model
{
    protected $table = 'MIS.TRAVEL_INTL_REQ_APPR';
    protected $fillable = [
        'id',
        'document_no',
        'plant_id',
        'emp_id',
        'emp_name',
        'location',

        'dept_head_id',
        'dept_accept',
        'dept_accept_date',

        'site_head_id',
        'site_head_accept',
        'site_head_date',

        'plant_head_id',
        'plant_head_accept',
        'plant_head_date',

        'chairman_sir_id',
        'chairman_sir_accept',
        'chairman_sir_date',

        'chairman_madam_id',
        'chairman_madam_accept',
        'chairman_madam_date',

        'created_at',
        'create_user',
        'updated_at',
        'update_user',
        'status'
    ];
}