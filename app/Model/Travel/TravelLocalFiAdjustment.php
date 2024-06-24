<?php


namespace App\Model\Travel;


use Illuminate\Database\Eloquent\Model;

class TravelLocalFiAdjustment extends Model
{
    protected $table = "mis.travel_local_fi_adjustment";
    protected $fillable = [
        'id',
        'emp_id',
        'document_no',
        'advance_amt',
        'expense_amt' ,
        'emp_adjust_amt',
        'fi_adjust_amt',
        'fi_sap_doc',
        'create_user',
        'updated_at',
        'update_user'
    ];
}