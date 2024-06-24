<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instsales extends Model
{
    //
    protected $primaryKey = null;
    public $incrementing = false;

    protected $table='upload_inst_sales_data';

    protected $fillable=[
        'sales_year',
        'sales_month',
        'sales_cata',
        'company',
        'sales_person',
        'sales_bdt'
    ];
    public $timestamps=false;
}
