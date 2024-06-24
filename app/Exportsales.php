<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exportsales extends Model
{
    //

    protected $primaryKey = null;
    public $incrementing = false;

    protected $table='upload_export_sales_data';

    protected $fillable=[
        'sales_year',
        'sales_month',
        'sales_cata',
        'company',
        'sales_person',
        'sales_bdt',
        'sales_usd'
    ];
    public $timestamps=false;
}
