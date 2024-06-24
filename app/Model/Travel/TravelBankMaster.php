<?php


namespace App\Model\Travel;


use Illuminate\Database\Eloquent\Model;

class TravelBankMaster extends Model
{
    protected $table = "mis.travel_bank_master";
    protected $fillable = [
        'id',
        'company_id',
        'bank_name',
        'branch',
        'acc_no',
        'created_at' ,
        'create_user',
        'updated_at',
        'update_user'
    ];
}