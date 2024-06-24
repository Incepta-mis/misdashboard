<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 6/2/2018
 * Time: 8:51 AM
 */

namespace App\Http\Controllers\SCM;


use App\Http\Controllers\Controller;

use App\ScmCompanyInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


class ScmCompanyInfoController extends Controller
{
    public function index()
    {

        $cmp_info = DB::select("select plant,company_short_name,company_full_name,company_ho_address,company_factory_address,company_import_ln
                    from MIS.SCM_COMPANY_INFO");
        return view('scm_portal/company_upload')->with('cmp_info',$cmp_info);
    }

    public function importExcel()
    {
        DB::statement("alter session set nls_date_format = 'dd-mm-yy'");
        $uid = Auth::user()->user_id;

        // if(Input::hasFile('import_file')){

        $file_name = Input::file('import_file');

        //validation
        $rules = array('import_file' => 'required'); //'required'
        $msg = array('import_file.required' => 'This field is required');
        $validator_empty = Validator::make(array('import_file' => $file_name), $rules, $msg);
        if ($validator_empty->fails()) {
            return Redirect::to('scm_portal/company_upload_page')->withErrors($validator_empty);
        } else if ($validator_empty->passes()) {

            $ext = strtolower($file_name->getClientOriginalExtension());

            $validator = Validator::make(
                array('ext' => $ext),
                array('ext' => 'in:xls,xlsx')
            );

            if ($validator->fails()) {
                // send back to the page with the input data and errors
                $notification = array(
                    'message' => 'Please Upload excel file!',
                    'alert-type' => 'error'
                );
                return Redirect::to('scm_portal/company_upload_page')->withErrors($validator)->with($notification);

            } else if ($validator->passes()) {

                $data = Excel::load($file_name, function ($reader) {
                })->get();

                if (!empty($data) && $data->count()) {
                    foreach ($data as $key => $value) {

                        // dd($value);

                        if (ScmCompanyInfo::where('PLANT', $value->plant)) {

                            DB::DELETE("
                                delete from MIS.SCM_COMPANY_INFO
                                where PLANT = ?", [$value->plant]);
                        }
                        $insert[] = [
                            'PLANT' => trim($value->plant),
                            'COMPANY_SHORT_NAME' => trim($value->company_short_name),
                            'COMPANY_FULL_NAME' => trim($value->company_full_name),
                            'COMPANY_HO_ADDRESS' => trim($value->company_ho_address),
                            'COMPANY_FACTORY_ADDRESS' => trim($value->company_factory_address),
                            'COMPANY_IMPORT_LN' => trim($value->import_ln),
                            'CREATE_USER' => $uid
                        ];


                    }
                    if (!empty($insert)) {

                        try {
                            DB::table('SCM_COMPANY_INFO')->insert($insert);
                        } catch (\Exception $ee) {
                            DB::rollBack();
                            $notification = array(
                                'message' => 'Duplicate Row found in excel!',
                                'alert-type' => 'error'
                            );
                            return Redirect::to('scm_portal/company_upload_page')->with($notification);
                        }

                        $dt = Carbon::now()->format('d-m-Y');
                        $sl = DB::select("SELECT count(*) cnt
                                      FROM mis.SCM_COMPANY_INFO
                                      WHERE to_char(CREATE_DATE,'DD-MM-RRRR') = ?
                                      AND CREATE_USER = ?", [$dt, $uid]);
                        $cnt = $sl[0]->cnt;

                        $notification = array(
                            'message' => 'File Uploaded successfully! ' . $cnt . ' rows inserted',
                            'alert-type' => 'success'
                        );
                        return Redirect::to('scm_portal/company_upload_page')->with($notification);

                    } else {
                        $notification = array(
                            'message' => 'upload excel column format not valid!',
                            'alert-type' => 'error'
                        );
                        return Redirect::to('scm_portal/company_upload_page')->with($notification);
                    }
                }
            }
        }

        // }
    }
}