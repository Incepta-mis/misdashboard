<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor_Information extends Model
{
    protected $primaryKey = 'doctor_id';
    protected $table = 'doctor_information';
    public $timestamps = null;
}
