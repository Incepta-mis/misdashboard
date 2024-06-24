<?php
/**
 * Created by PhpStorm.
 * User: raqib
 * Date: 2/17/2019
 * Time: 11:12 AM
 */

namespace App\Http\Controllers\Rmportal;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
{
   public function index(){
       return view('rm_portal.app_download')
           ->with('app',DB::select('select description des,app_link link from mis.msfa_app_link'));
   }

   public function view_msd_app(){
       return view('rm_portal.msd_td_app')
           ->with('app',DB::select('select description des,app_link link from mis.msd_app_link'));


           // Old Version app
           //https://drive.google.com/open?id=1iprEEsyvgpRV-lk_lFo7Anqyt9am8EVH 
   }

    public function view_nm_app(){
        return view('rm_portal.nm_app')
            ->with('app',DB::select(' select description des,app_link link from mis.mis_apps_info 
    where apps_name = \'Incepta NM\''));
    }

}