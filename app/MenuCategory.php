<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    protected $table = 'DASH_MENU_CATEGORY';
    protected $primaryKey = 'user_role';

    public function user(){
        return $this->belongsTo('App\User','role','user_role');
    }
}
