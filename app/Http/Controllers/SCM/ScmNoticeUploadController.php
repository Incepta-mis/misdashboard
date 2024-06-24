<?php

namespace App\Http\Controllers\SCM;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ScmNoticeUploadController extends Controller
{
    public function index(){
        $uid = Auth::user()->user_id;
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $url = "https://";
        else
            $url = "http://";
        $url.= $_SERVER['HTTP_HOST'];
        $data = DB::SELECT("SELECT * FROM SCM_NOTICE_UPLOAD WHERE CREATED_BY = '$uid'");
        return view("scm_portal/ScmNotice",['data'=>$data,'url'=>$url]);
    }
    public function uploadSCMnotice(Request $request){

        $uid = Auth::user()->user_id;
        $auth_name = Auth::user()->name;

        $file_name = Input::file('upload_file');
        $date = Carbon::now()->format('Y-m-d H:m:s');

        //validation
        $rules = array('upload_file' => 'required'); //'required'
        $msg = array('upload_file.required' => 'This field is required');
        $validator_empty = Validator::make(array('upload_file' => $file_name), $rules, $msg);

        if($validator_empty->fails()) {
            return Redirect::to('scm_portal/scm_notice')->withErrors($validator_empty);
        }else if($validator_empty->passes()) {
            $valid = Validator::make(array('notice_name' => $request->notice_name), [
                'notice_name' => 'required'
            ],array('notice_name.required' => 'This field is required'));

            if ($valid->fails()) {
                return Redirect::to('scm_portal/scm_notice')->withErrors($valid);
            }else {
                try {
                    $notice_name = $request->notice_name;
                    $fileName = $request->file('upload_file')->getClientOriginalName();
                    $name = pathinfo($fileName, PATHINFO_FILENAME);
                    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                    $final = $name."_".$uid.strtotime("now").".".$extension;
                    $path = Storage::putFileAs(
                        'scm_notice', $request->file('upload_file'), $final
                    );
                    $new_path = "app/".$path;

                    //  return storage_path($new_path);

                    DB::insert("INSERT INTO SCM_NOTICE_UPLOAD (NOTICE_NAME, FILE_PATH, CREATED_BY, CREATED_AT) VALUES(?,?,?,?)",
                        [$notice_name,$new_path,$uid,$date]);

                    $notification = array(
                        'message' => 'File uploaded successfully! ',
                        'alert-type' => 'success'
                    );
                    return Redirect::to('scm_portal/scm_notice')->with($notification);
                } catch (\Exception $ee) {
                    DB::rollBack();
                    $notification = array(
                        'message' => 'Database Error!',
                        'alert-type' => 'error'
                    );
                    return Redirect::to('scm_portal/scm_notice')->with($notification);
                }
            }
        }
    }
    public function deleteThisRecord(Request $request){
        $id = $request->id;
        if($id != ""){
            $result =  DB::DELETE('DELETE FROM MIS.SCM_NOTICE_UPLOAD WHERE ID = ?',[$id]);
            return response()->json(['result'=> $result]);
        }else{
            return response()->json(['result'=> 2]);
        }
    }
}
