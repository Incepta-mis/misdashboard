<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemWiseDoctorAssign extends Model
{
    protected $table =  'ITEM_WISE_DOCTOR_ASSIGN';
       // protected $table =  'DOCTOR_WISE_ITEM_UTIL_TEMP';

//    public function scopeWhereArray($query, $array) {
//        foreach($array as $field => $value) {
//            $query->where($field, $value);
//        }
//        return $query;
//    }
}
