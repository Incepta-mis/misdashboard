<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

//    protected $table = 'users_info';
    protected $table = 'dashboard_users_info';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'upassword'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'upassword','raw_password'
    ];

    /**
     * User password 
     */
    public function getAuthPassword(){
       return $this->upassword;
    }

    public function category(){
        return $this->hasMany('App\MenuCategory','user_role','urole');
    }

    public function getCategory(){
        return $this->category()->orderBy('mcategory')->get();
    }

    public function getResearchExpenseUsers(){
        $qryRes = DB::SELECT("SELECT user_id FROM RESEARCH_EXPENSE_AUTH_USERS");
        return $qryRes;
    }
}
