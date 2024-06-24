<?php


namespace App\Model\Travel;


use Illuminate\Database\Eloquent\Model;

class TravelLocalFiAdvance extends Model
{
    protected $table="mis.travel_local_fi_advance";
    protected $fillable = [
        'id',
        'advice_no',
        'document_no',
        'company_id',
        'company_name',
        'emp_id',
        'emp_name',
        'bank_acc_no',
        'bank_name',
        'routing_no',
        'amount',
        'created_at' ,
        'create_user',
        'updated_at',
        'update_user'
    ];
}