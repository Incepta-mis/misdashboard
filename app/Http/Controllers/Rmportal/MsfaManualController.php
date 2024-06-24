<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 18/02/18
 * Time: 15:06
 */

namespace App\Http\Controllers\Rmportal;

use App\ItemWiseDoctorAssign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Input;
use Validator;
use File;



class MsfaManualController extends Controller
{

    public function index()
    {


        /*$path = storage_public('msfa_manual/'.$filename.'_1');


        if (!File::exists($path)) {

            abort(404);

        }


        $file = File::get($path);

        $type = File::mimeType($path);



        $response = Response::make($file, 200);

        $response->header("Content-Type", $type);*/



       // return $response;

       // return view('rm_portal/msfa_manual', ['image_path'=>$response]);
        return view('rm_portal/msfa_manual');
    }





}