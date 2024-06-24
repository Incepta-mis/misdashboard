<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpHisLanguage extends Model
{
    protected $table = 'mis.emp_his_language';
    public $timestamps = false;
    protected $primaryKey = 'emp_id';

    protected $fillable = [
       'emp_id',
       'lang',
       'lang_level',
       'sl',
       'create_user',
       'create_date'
    ];
}
