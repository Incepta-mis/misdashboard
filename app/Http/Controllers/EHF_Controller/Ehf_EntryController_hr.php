<?php

namespace App\Http\Controllers\EHF_Controller;

//use Illuminate\Contracts\Logging\Log;
use App\EmpHisLanguage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Input;
use App\EmpHistoryMoreInfo;
use App\EmpHisAddress;
use App\EmpHisFamiDetail;
use App\EmpHisEducation;
use App\EmpHisEmployeement;
use App\EMP_HIS_CHILDBROSIS;
use App\EMP_HIS_PRO_QUALI;
use App\EmpHisGuarantor;
use App\EmpHisNominee;
use App\EmpHisReference;
use Carbon\Carbon;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;
use Illuminate\Support\Facades\Log;
use App\EmpHistoryInfo;
use Illuminate\Support\Facades\Validator;

class Ehf_EntryController_hr extends Controller

{

    public function eh_hr_viewForm()
    {
        return view('emp_history.entry_form_hr.emp_his_entry_form_hr');
    }

    public function eh_hr_user_viewForm($value ='d')
    {
        $exist = true;
        $login_emp_id = $value;
        $login_admin_emp_id = Auth::user()->user_id;
        $hr_admin = false;

        $login_hr = DB::select("
                                            select emp_id,emp_name from mis.emp_his_admin
                                            where emp_id=?", [$login_admin_emp_id]);

        if (count($login_hr) > 0) {
            $hr_admin = true;
        }


        $login_moreinfo = DB::select("select e.*,f.*,d.*,d.dept_name as emp_dept_name ,initcap(f.desig_name) as design_nam_1st_upper,r.grade egrade
                                           from hrms.emp_information@web_to_hrms e,
                                            hrms.emp_designation@web_to_hrms f,
                                            hrms.dept_information@web_to_hrms d,
                                            hrms.emp_rank@web_to_hrms r
                                            where e.desig_id=f.desig_id
                                            and e.dept_id=d.dept_id
                                            and e.rank_id = r.rank_id
                                            and e.emp_id=?", [$login_emp_id]);

        if (count($login_moreinfo) === 0) {
            $exist = false;
        }

        //company name
        $company_name = DB::select("select initcap(lower(com_name)) com_name
                                        from hrms.company_info@web_to_hrms ci
                                        where ci.com_id = ?", [$login_moreinfo[0]->com_id]);

        //get the divisions-------------
        $bd_div = DB::select("SELECT B.DIV_ID, B.DIV_NAME, B.BN_NAME FROM MIS.BD_DIVISONS B");
        //get the districts-------------
        $bd_dis = DB::select("SELECT B.DIS_ID, B.DIVISION_ID, B.DIS_NAME FROM MIS.BD_DISTRICTS B");
        //get the all country-------------
        $all_country = DB::select("SELECT A.COUNTRY_ID, A.COUNTRY_CODE, A.COUNTRY_NAME FROM MIS.ALL_COUNTRIES A");

        $login_urright_desig = $login_moreinfo[0]->desig_name;

        //30.9.2019
        //get the divisions-------------
        $edu_all_uni = DB::select("Select uname id,uname text from mis.edu_university");
        $edu_all_sub = DB::select("Select subject id,subject text from mis.edu_subject");
        $edu_all_board = DB::select("SELECT B.BOARD_ID, B.BOARD_NAME FROM MIS.EDU_BOARD B");
        $edu_all_grp = DB::select("SELECT * FROM MIS.EDU_GROUP B");
        $edu_all_degree = DB::select("SELECT * FROM MIS.EDU_DEGREE B");
        //30.9.2019

        ///see if data already exists
        $emp_his_moreinfoid = DB::select("select * from mis.EMP_HIS_MOREINFO where emp_id  = ? ", [$login_emp_id]);
        $emp_his_infoid = DB::select("select * from mis.EMP_HIS_INFO where emp_id  = ? ", [$login_emp_id]);
        $emp_his_addr = DB::select("select * from mis.EMP_HIS_ADDR where emp_id  = ? ", [$login_emp_id]);
        $emp_hisfamidetail = DB::select("select * from mis.EMP_FAMILY_DETAIL where emp_id  = ? ", [$login_emp_id]);
        $emp_his_edu_old = DB::select("select * from mis.EMP_HIS_EDUCATION eie,MIS.EDU_DEGREE ed
                                            where emp_id  = ?
                                            and EIE.EDU_DESIG_NAME = ED.DEG_ID
                                            order by ED.PRECEDENCE desc ", [$login_emp_id]);

        $emp_his_emplment_old_ext = DB::select("select * from mis.EMP_HIS_EMPLOYEEMENT where emp_id  = ? and upper(emplo_comp_name) not like 'INCEPTA%' order by emplo_from desc", [$login_emp_id]);
        $emp_his_emplment_old_int = DB::select("select * from mis.EMP_HIS_EMPLOYEEMENT where emp_id  = ? and upper(emplo_comp_name) like 'INCEPTA%' order by emplo_from desc", [$login_emp_id]);
        $emp_his_cbs_old = DB::select("select * from mis.EMP_HIS_CHILDBROSIS where emp_id  = ? ", [$login_emp_id]);
        $emp_his_pro_quali = DB::select("select * from mis.EMP_HIS_PRO_EQUALI where emp_id  = ? ", [$login_emp_id]);
        $emp_his_ref_data = DB::select("select * from mis.EMP_HIS_REFERENCE where emp_id  = ? ", [$login_emp_id]);
        $emp_his_nomi_data = DB::select("select * from mis.EMP_HIS_NOMINEE where emp_id  = ? ", [$login_emp_id]);
        $emp_his_qurantr_data = DB::select("select * from mis.EMP_HIS_GUARANTOR where emp_id  = ? ", [$login_emp_id]);
        $emp_his_language = EmpHisLanguage::where('emp_id', '=', $login_emp_id)->orderBy('sl')->get();
        $emp_desig_list = DB::select("select distinct trim(desig) desig
                                            from(
                                            select desig_name,
                                                   case when instr(desig_name,',') <> 0
                                                     then substr(desig_name,0,instr(desig_name,',')-1) else desig_name
                                                   end desig
                                            from hrms.EMP_DESIGNATION@web_to_hrms
                                            where upper(desig_name) <> 'WRONG'
                                            )order by desig");

//        dd( compact('login_urright_desig', 'login_moreinfo', 'bd_div', 'bd_dis', 'all_country',
//            'emp_his_moreinfoid', 'emp_his_addr', 'emp_his_infoid', 'emp_hisfamidetail',
//            'emp_his_edu_old', 'emp_his_cbs_old', 'emp_his_emplment_old_ext', 'emp_his_emplment_old_int', 'emp_his_pro_quali',
//            'emp_his_ref_data', 'emp_his_nomi_data', 'emp_his_qurantr_data', 'edu_all_board', 'edu_all_degree', 'edu_all_grp',
//            'edu_all_uni', 'edu_all_sub', 'emp_his_language', 'emp_desig_list', 'company_name', 'exist', 'hr_admin'));


        return view('emp_history.entry_form_hr.emp_his_entry_form_hr_user',
            compact('login_urright_desig', 'login_moreinfo', 'bd_div', 'bd_dis', 'all_country',
                'emp_his_moreinfoid', 'emp_his_addr', 'emp_his_infoid', 'emp_hisfamidetail',
                'emp_his_edu_old', 'emp_his_cbs_old', 'emp_his_emplment_old_ext', 'emp_his_emplment_old_int', 'emp_his_pro_quali',
                'emp_his_ref_data', 'emp_his_nomi_data', 'emp_his_qurantr_data', 'edu_all_board', 'edu_all_degree', 'edu_all_grp',
                'edu_all_uni', 'edu_all_sub', 'emp_his_language', 'emp_desig_list', 'company_name', 'exist', 'hr_admin'));


    }

    public function searchEmployee(Request $request){
        try{
            if(strlen($request->search) > 4){
                $result = DB::select("       
                                select emp_id id, emp text 
                                 from (
                                 SELECT emp_id||' | '||sur_name emp,emp_id
                                 from mis.emp_his_info
                                 where upper(emp_id) like ('%$request->search%')
                                 order by 1 asc)
                            ");

                Log::info($result);
                return response()->json(['results' => $result],200);
            }else{
                return response()->json(['results' => []],200);
            }
        }catch (\Exception $ex){
            Log::info($ex->getMessage());
            return response()->json($ex->getMessage());
        }
    }

    public function ajaxImageUploadPost(Request $request)
    {
        if ($request->ajax()) {

            $data = $request->file('file');
            $emp = $request->emp_id;

            $image = \Image::make($data)->resize(200, 200);

            $extension = $data->getClientOriginalExtension();
//            $filename = Auth::user()->user_id . '_profilepic' . '.' . $extension; // renameing image
            $filename = $emp . '_profilepic' . '.' . $extension; // renameing image
            $path = public_path('emp_history_img/');


            $usersImage = public_path("emp_history_img/{$filename}"); // get previous image from folder
            if (File::exists($usersImage)) { // unlink or remove previous image from folder
                unlink($usersImage);
            } else {
                // dd('File is not exists.');
                $pp = 'nofileexist';
            }

            //INSERT employee image in db table==================================================================

            $emp_his_moreinfo = array(
                'emp_id' => $emp,
                'emp_img' => $filename,

                'create_user' => Auth::user()->user_id,
                'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                'update_user' => Auth::user()->user_id,
                'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
            );

            //if this emp_id exits in this table or not
//            $emp_his_moreinfoid = EmpHistoryMoreInfo::all()->where('emp_id', Auth::user()->user_id);
            $emp_his_moreinfoid = DB::select("select * from mis.EMP_HIS_MOREINFO where emp_id  = ? ", [$emp]);
//            dd($emp_his_moreinfoid);

            if (empty($emp_his_moreinfoid[0]->emp_id)) {
                //Insert part for page1-------------------------------------
                EmpHistoryMoreInfo::insert($emp_his_moreinfo);

            } else {
                //if exit then do update part--------------------------------------------------
                DB::table('mis.emp_his_moreinfo')->where('emp_id', $emp)->update([
                    'emp_img' => $filename,
                    'update_user' => Auth::user()->user_id,
                    'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
                ]);
            }
            $image->save($path . $filename);
//            $upload_success = $data->move($path, $filename);

            return response()->json([
                'success' => 'done',
                'valueimg' => $data,
                'emp_img' => $filename
            ]);

        }
    }

    public function postPageoneForm(Request $request)
    {
        if ($request->ajax() && $request) {

            $login_user_id = Auth::user()->user_id;
            $passed_user_id  = $request->fd['emp_code_nam'];
            $emp_his_moreinfo = array(
                'emp_id' => $request->fd['emp_code_nam'],
                'app_source' => $request->fd['app_source_op'],
                'app_sour_other' => $request->fd['app_source_op_other'],
                'nid_type' => $request->fd['nid_type'],
                'nid' => $request->fd['emp_nid_no'],
                'birt_dt_ssc' => empty($request->fd['date_birth_ssc']) ? "" : Carbon::createFromFormat('d/m/Y', $request->fd['date_birth_ssc'])->toDateString(),
                'birth_dt_ori' => empty($request->fd['date_birth_ori']) ? "" : Carbon::createFromFormat('d/m/Y', $request->fd['date_birth_ori'])->toDateString(),
                'birth_place_cuntry' => $request->fd['emp_bir_country'],
                'emp_mob_no_offi' => $request->fd['emp_mob_official'],
                'emp_mail_offi' => $request->fd['emp_mail_official'],
                'emp_mob_no_per' => $request->fd['emp_mob_personal'],
                'emp_mail_per' => $request->fd['emp_mail_personal'],
                'marriage_date' => empty($request->fd['emp_mari_date']) ? "" : Carbon::createFromFormat('d/m/Y', $request->fd['emp_mari_date'])->toDateString(),
                'no_of_child' => $request->fd['no_of_child'],
                'desig_first_time' => $request->fd['desig_at_time_join'],
                'create_user' => Auth::user()->user_id,
                'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                'update_user' => Auth::user()->user_id,
                'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
            );


                //if this emp_id exits in this table or not
                $emp_his_moreinfoid = DB::select("select * from mis.EMP_HIS_MOREINFO where emp_id  = ? ", [$passed_user_id]);



            if (empty($emp_his_moreinfoid[0]->emp_id)) {
//                //Insert part for page1
                EmpHistoryMoreInfo::insert($emp_his_moreinfo);
            } else {
//                //if exit then do update part--------------------------------------------------
//                unset($emp_his_moreinfo['create_user']);
//                unset($emp_his_moreinfo['create_date']);
//
//                $uo=$emp_his_moreinfo;

                DB::table('mis.emp_his_moreinfo')->where('emp_id', $passed_user_id )->update([

                    'app_source' => $request->fd['app_source_op'],
                    'app_sour_other' => $request->fd['app_source_op_other'],
                    'nid' => $request->fd['emp_nid_no'],
                    'nid_type' => $request->fd['nid_type'],
                    'birt_dt_ssc' => empty($request->fd['date_birth_ssc']) ? "" : Carbon::createFromFormat('d/m/Y', $request->fd['date_birth_ssc'])->toDateString(),
                    'birth_dt_ori' => empty($request->fd['date_birth_ori']) ? "" : Carbon::createFromFormat('d/m/Y', $request->fd['date_birth_ori'])->toDateString(),
                    'birth_place_cuntry' => $request->fd['emp_bir_country'],
                    'emp_mob_no_offi' => $request->fd['emp_mob_official'],
                    'emp_mail_offi' => $request->fd['emp_mail_official'],
                    'emp_mob_no_per' => $request->fd['emp_mob_personal'],
                    'emp_mail_per' => $request->fd['emp_mail_personal'],

                    'marriage_date' => empty($request->fd['emp_mari_date']) ? "" : Carbon::createFromFormat('d/m/Y', $request->fd['emp_mari_date'])->toDateString(),
                    'no_of_child' => $request->fd['no_of_child'],
                    'desig_first_time' => $request->fd['desig_at_time_join'],

                    'update_user' => Auth::user()->user_id,
                    'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
                ]);

            }
//            $emp_his_addrid = EmpHisAddress::all();
            $emp_his_addrid = DB::select("select * from mis.EMP_HIS_ADDR where emp_id  = ? ", [$passed_user_id]);

            if (empty($emp_his_addrid[0]->emp_id)) {
                $emp_his_addr = array(
                    'emp_id' => $request->fd['emp_code_nam'],

                    'pre_careof' => $request->fd['careOfPresent'],
                    'pre_country' => $request->fd['countryPresent'],
                    'pre_addr_1st' => $request->fd['villageTownPre1st'],
                    'pre_addr_2nd' => $request->fd['villageTownPre2nd'],
                    'pre_div' => $request->fd['pread_bd_div'],
                    'pre_dis' => $request->fd['pread_bd_dis'],
                    'pre_police_sta' => $request->fd['PoliceStaPre'],
                    'pre_post_off' => $request->fd['postOfficePresent'],
                    'pre_post_code' => $request->fd['postCodePresent'],
                    'pre_phne' => $request->fd['phonenoPresent'],

                    'per_careof' => $request->fd['careOfPerma'],
                    'per_country' => $request->fd['countryPerma'],
                    'per_addr_1st' => $request->fd['villageTownPerma1st'],
                    'per_addr_2nd' => $request->fd['villageTownPer2nd'],
                    'per_div' => $request->fd['pd_bd_div'],
                    'per_dis' => $request->fd['pd_bd_dis'],
                    'per_police_sta' => $request->fd['PoliceStaPerma'],
                    'per_post_off' => $request->fd['postOfficePerma'],
                    'per_post_code' => $request->fd['postCodePerma'],
                    'per_phne' => $request->fd['phonenoPerma'],

                    'emer_careof' => $request->fd['careOfemer'],
                    'emer_country' => $request->fd['emerCountry'],
                    'emer_addr_1st' => $request->fd['villageTownemer1st'],
                    'emer_addr_2nd' => $request->fd['villageTownemer2nd'],
                    'emer_div' => $request->fd['emer_bd_div'],
                    'emer_dis' => $request->fd['emer_bd_dis'],
                    'emer_police_sta' => $request->fd['postStaEmer'],
                    'emer_post_off' => $request->fd['postOfficeEmer'],
                    'emer_post_code' => $request->fd['postcodeEmer'],
                    'emer_phne' => $request->fd['phonenoEmer'],
                    'emer_relation' => $request->fd['emer_relation'],

                    'create_user' => Auth::user()->user_id,
                    'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                    'update_user' => Auth::user()->user_id,
                    'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
                );
                //Insert part for page1
//                EmpHistoryMoreInfo::insert($emp_his_moreinfo);
                EmpHisAddress::insert($emp_his_addr);

            } else {
                //if exit then do update part--------------------------------------------------

                if ($emp_his_moreinfoid[0]->emp_final_sub == 'submit_yes') {
                    DB::table('mis.emp_his_addr')->where('emp_id', $passed_user_id)->update([
                        'pre_careof' => $request->fd['careOfPresent'],
                        'pre_country' => $request->fd['countryPresent'],
                        'pre_addr_1st' => $request->fd['villageTownPre1st'],
                        'pre_addr_2nd' => $request->fd['villageTownPre2nd'],
                        'pre_div' => $request->fd['pread_bd_div'],
                        'pre_dis' => $request->fd['pread_bd_dis'],
                        'pre_police_sta' => $request->fd['PoliceStaPre'],
                        'pre_post_off' => $request->fd['postOfficePresent'],
                        'pre_post_code' => $request->fd['postCodePresent'],
                        'pre_phne' => $request->fd['phonenoPresent'],

                        'per_careof' => $request->fd['careOfPerma'],
                        'per_country' => $request->fd['countryPerma'],
                        'per_addr_1st' => $request->fd['villageTownPerma1st'],
                        'per_addr_2nd' => $request->fd['villageTownPer2nd'],
                        'per_div' => $emp_his_addrid[0]->per_div,
                        'per_dis' => $emp_his_addrid[0]->per_dis,
                        'per_police_sta' => $request->fd['PoliceStaPerma'],
                        'per_post_off' => $request->fd['postOfficePerma'],
                        'per_post_code' => $request->fd['postCodePerma'],
                        'per_phne' => $request->fd['phonenoPerma'],

                        'emer_careof' => $request->fd['careOfemer'],
                        'emer_country' => $request->fd['emerCountry'],
                        'emer_addr_1st' => $request->fd['villageTownemer1st'],
                        'emer_addr_2nd' => $request->fd['villageTownemer2nd'],
                        'emer_div' => $request->fd['emer_bd_div'],
                        'emer_dis' => $request->fd['emer_bd_dis'],
                        'emer_police_sta' => $request->fd['postStaEmer'],
                        'emer_post_off' => $request->fd['postOfficeEmer'],
                        'emer_post_code' => $request->fd['postcodeEmer'],
                        'emer_phne' => $request->fd['phonenoEmer'],
                        'emer_relation' => $request->fd['emer_relation'],

                        'update_user' => Auth::user()->user_id,
                        'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')]);
                } else {
                    DB::table('mis.emp_his_addr')->where('emp_id', $passed_user_id )->update([
                        'pre_careof' => $request->fd['careOfPresent'],
                        'pre_country' => $request->fd['countryPresent'],
                        'pre_addr_1st' => $request->fd['villageTownPre1st'],
                        'pre_addr_2nd' => $request->fd['villageTownPre2nd'],
                        'pre_div' => $request->fd['pread_bd_div'],
                        'pre_dis' => $request->fd['pread_bd_dis'],
                        'pre_police_sta' => $request->fd['PoliceStaPre'],
                        'pre_post_off' => $request->fd['postOfficePresent'],
                        'pre_post_code' => $request->fd['postCodePresent'],
                        'pre_phne' => $request->fd['phonenoPresent'],

                        'per_careof' => $request->fd['careOfPerma'],
                        'per_country' => $request->fd['countryPerma'],
                        'per_addr_1st' => $request->fd['villageTownPerma1st'],
                        'per_addr_2nd' => $request->fd['villageTownPer2nd'],
                        'per_div' => $request->fd['pd_bd_div'],
                        'per_dis' => $request->fd['pd_bd_dis'],
                        'per_police_sta' => $request->fd['PoliceStaPerma'],
                        'per_post_off' => $request->fd['postOfficePerma'],
                        'per_post_code' => $request->fd['postCodePerma'],
                        'per_phne' => $request->fd['phonenoPerma'],

                        'emer_careof' => $request->fd['careOfemer'],
                        'emer_country' => $request->fd['emerCountry'],
                        'emer_addr_1st' => $request->fd['villageTownemer1st'],
                        'emer_addr_2nd' => $request->fd['villageTownemer2nd'],
                        'emer_div' => $request->fd['emer_bd_div'],
                        'emer_dis' => $request->fd['emer_bd_dis'],
                        'emer_police_sta' => $request->fd['postStaEmer'],
                        'emer_post_off' => $request->fd['postOfficeEmer'],
                        'emer_post_code' => $request->fd['postcodeEmer'],
                        'emer_phne' => $request->fd['phonenoEmer'],
                        'emer_relation' => $request->fd['emer_relation'],

                        'update_user' => Auth::user()->user_id,
                        'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')]);
                }
            }
//            $emp_his_info = EmpHistoryInfo::all();
            $emp_his_info = DB::select("select * from mis.EMP_HIS_INFO where emp_id  = ? ", [$passed_user_id]);
            if (empty($emp_his_info[0]->emp_id)) {


            } else {
                DB::table('mis.emp_his_info')->where('emp_id', $passed_user_id)->update([

                    'maritial_status' => $request->fd['mari_status'],
                    'religion' => $request->fd['emp_religion'],
                    'birth_place' => $request->fd['emp_bir_dis'],
                    'nationality' => $request->fd['emp_nationality'],
                    'update_user' => Auth::user()->user_id,
                    'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
                ]);
            }

            return response()->json(
                [
                    'dis_id' => "9999",
                    'emp_nid_no' => 'fhdsf',
                    'toatlval' => $request->fd,
                    'moreemp' => $emp_his_moreinfo,
                    'status' => 'Y'
                ]);
        }
    }

    public function postPagetwoForm(Request $request)
    {
        if ($request->ajax() && $request) {

            Log::info($request->all());

            $passed_user_id  = $request->fdtwo['emp_code_nam'];

//            dd($passed_user_id);

            if (empty($request->fdtwo['emp_height_ft']) && empty($request->fdtwo['emp_height_inch'])) {
                $height = "";
            } else {
                $height = $request->fdtwo['emp_height_ft'] . ' ft ' . $request->fdtwo['emp_height_inch'] . ' inch';
            }

            DB::table('mis.emp_his_moreinfo')->where('emp_id', $passed_user_id)->update([
                'emp_passport_no' => $request->fdtwo['emp_passport_no'],
                'drive_license' => $request->fdtwo['emp_driving_license'],
                'tin_no' => $request->fdtwo['emp_tin_no'],
                'bank_ac_no' => $request->fdtwo['bank_ac_no'],
                'bank_name' => $request->fdtwo['bank_name'],
                'emp_height' => $height,

                'update_user' => Auth::user()->user_id,
                'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
            ]);

            $emp_his_info = DB::select("select * from mis.EMP_HIS_INFO where emp_id  = ? ", [$passed_user_id]);

            if (empty($emp_his_info[0]->emp_id)) {

            } else {
                DB::table('mis.emp_his_info')->where('emp_id', $passed_user_id)->update([

                    'gender' => $request->fdtwo['emp_gender'],
                    'blood_group' => $request->fdtwo['emp_blood'],

                    'update_user' => Auth::user()->user_id,
                    'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
                ]);
            }

            $emp_his_famideatil = DB::select("select * from mis.EMP_FAMILY_DETAIL where emp_id  = ? ", [$passed_user_id]);
            if (empty($emp_his_famideatil[0]->emp_id)) {
                $emp_his_fam = array(
                    'emp_id' => $passed_user_id,

                    'father_name' => $request->fdtwo['fa_relation_name'],
                    'fa_bir_date' => empty($request->fdtwo['rela_datebir_faid']) ? "" : Carbon::createFromFormat('d/m/Y', $request->fdtwo['rela_datebir_faid'])->toDateString(),
                    'fa_place_birth' => $request->fdtwo['fa_relation_plabir'],
                    'fa_cuntry_birth' => $request->fdtwo['emp_all_countryfa'],
                    'fa_nationality' => $request->fdtwo['fa_rel_nationality'],
                    'fa_mob_no' => $request->fdtwo['fa_relation_mobno'],

                    'mother_name' => $request->fdtwo['mo_relation_name'],
                    'mo_bir_date' => empty($request->fdtwo['rela_datebir_moid']) ? "" : Carbon::createFromFormat('d/m/Y', $request->fdtwo['rela_datebir_moid'])->toDateString(),
                    'mo_place_birth' => $request->fdtwo['mo_relation_plabir'],
                    'mo_cuntry_birth' => $request->fdtwo['emp_all_countrymo'],
                    'mo_nationality' => $request->fdtwo['mo_rel_nationality'],
                    'mo_mob_no' => $request->fdtwo['mo_relation_mobno'],

                    'spouse_name' => $request->fdtwo['sp_relation_name'],
                    'sp_bir_date' => empty($request->fdtwo['rela_datebir_spid']) ? "" : Carbon::createFromFormat('d/m/Y', $request->fdtwo['rela_datebir_spid'])->toDateString(),
                    'sp_place_birth' => $request->fdtwo['sp_relation_plabir'],
                    'sp_cuntry_birth' => $request->fdtwo['emp_all_countrysp'],
                    'sp_nationality' => $request->fdtwo['sp_rel_nationality'],
                    'sp_mob_no' => $request->fdtwo['sp_relation_mobno'],

                    'create_user' => Auth::user()->user_id,
                    'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                    'update_user' => Auth::user()->user_id,
                    'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
                );
                //Insert part for page1

                EmpHisFamiDetail::insert($emp_his_fam);
            } else {
                DB::table('mis.emp_family_detail')->where('emp_id', $passed_user_id)->update([

                    'father_name' => $request->fdtwo['fa_relation_name'],
                    'fa_bir_date' => empty($request->fdtwo['rela_datebir_faid']) ? "" : Carbon::createFromFormat('d/m/Y', $request->fdtwo['rela_datebir_faid'])->toDateString(),

                    'fa_place_birth' => $request->fdtwo['fa_relation_plabir'],
                    'fa_cuntry_birth' => $request->fdtwo['emp_all_countryfa'],
                    'fa_nationality' => $request->fdtwo['fa_rel_nationality'],
                    'fa_mob_no' => $request->fdtwo['fa_relation_mobno'],

                    'mother_name' => $request->fdtwo['mo_relation_name'],
                    'mo_bir_date' => empty($request->fdtwo['rela_datebir_moid']) ? "" : Carbon::createFromFormat('d/m/Y', $request->fdtwo['rela_datebir_moid'])->toDateString(),

                    'mo_place_birth' => $request->fdtwo['mo_relation_plabir'],
                    'mo_cuntry_birth' => $request->fdtwo['emp_all_countrymo'],
                    'mo_nationality' => $request->fdtwo['mo_rel_nationality'],
                    'mo_mob_no' => $request->fdtwo['mo_relation_mobno'],

                    'spouse_name' => $request->fdtwo['sp_relation_name'],
                    'sp_bir_date' => empty($request->fdtwo['rela_datebir_spid']) ? "" : Carbon::createFromFormat('d/m/Y', $request->fdtwo['rela_datebir_spid'])->toDateString(),

                    'sp_place_birth' => $request->fdtwo['sp_relation_plabir'],
                    'sp_cuntry_birth' => $request->fdtwo['emp_all_countrysp'],
                    'sp_nationality' => $request->fdtwo['sp_rel_nationality'],
                    'sp_mob_no' => $request->fdtwo['sp_relation_mobno'],

                    'update_user' => Auth::user()->user_id,
                    'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
                ]);
            }
            //-----------------------------------------------------------------------------------------------------------------
            //employee education multi data insert ----------------------
//            Log::info($request->fdtwo['edu_deg_nam'][0]);

            $data_edu_avail = DB::select("select * from mis.EMP_HIS_EDUCATION where emp_id  = ? ", [$passed_user_id]);

            $emp_his_moreinfo_t = DB::select("select * from mis.emp_his_moreinfo where emp_id  = ? ", [$passed_user_id]);

//            if ($emp_his_moreinfo_t[0]->emp_final_sub == 'submit_yes') {
//                //then no change to education fields
//            } else {
                ///////////////////education/////////////////////
                if (count($data_edu_avail) == 0) {

                } else {
                    DB::table('MIS.EMP_HIS_EDUCATION')->where('emp_id', $passed_user_id)->delete();
                }
                $count_edu = count($request->fdtwo['edu_deg_nam']);

                if ($count_edu > 1) {
                    //if multi rows data to save
                    foreach ($request->fdtwo['edu_deg_nam'] as $key => $v) {

                        Log::info('data to subject ' . $request->fdtwo['edu_subject'][$key]);

                        $data_edu = array(
                            'emp_id' => $passed_user_id,
                            'edu_desig_name' => $v,
                            'edu_insti_name' => $request->fdtwo['edu_insti_nam'][$key],
                            'edu_group' => $request->fdtwo['edu_group'][$key],

                            'edu_subject' => $request->fdtwo['edu_subject'][$key],
                            'edu_board' => $request->fdtwo['edu_board'][$key],
                            'edu_passing_yr' => $request->fdtwo['edu_passing_yr'][$key],
                            'edu_div_cgpa' => $request->fdtwo['edu_cgpa'][$key],
                            'edu_marks' => $request->fdtwo['edu_marks'][$key],

                            'create_user' => Auth::user()->user_id,
                            'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                            'update_user' => Auth::user()->user_id,
                            'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
                        );

                        if (empty($v)) {

                        } else {
                            EmpHisEducation::insert($data_edu);
                        }
                    }

                } elseif ($count_edu == 1) {

                    //if single row data to save
                    Log::info('data to subject2 insert ' . $request->fdtwo['edu_subject']);
                    $data_edu = array(
                        'emp_id' => $passed_user_id,
                        'edu_desig_name' => $request->fdtwo['edu_deg_nam'],
                        'edu_insti_name' => $request->fdtwo['edu_insti_nam'],
                        'edu_group' => $request->fdtwo['edu_group'],
                        'edu_subject' => $request->fdtwo['edu_subject'],
                        'edu_board' => $request->fdtwo['edu_board'],
                        'edu_passing_yr' => $request->fdtwo['edu_passing_yr'],
                        'edu_div_cgpa' => $request->fdtwo['edu_cgpa'],
                        'edu_marks' => $request->fdtwo['edu_marks'],
                        'create_user' => Auth::user()->user_id,
                        'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                        'update_user' => Auth::user()->user_id,
                        'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')

                    );
                    EmpHisEducation::insert($data_edu);

                } elseif ($count_edu == 0) {

                } else {

                }
                ////////////////////education end//////////////
//            }

            //employee language

            try {
                $check = EmpHisLanguage::find($passed_user_id);

                if (count($check) > 0) {
                    EmpHisLanguage::where('emp_id', '=', $passed_user_id)->delete();
                }

                for ($i = 0; $i < count($request->fdtwo['langu']); $i++) {
                    EmpHisLanguage::create([
                        'emp_id' => $passed_user_id,
                        'lang' => $request->fdtwo['langu'][$i],
                        'lang_level' => $request->fdtwo['language_level'][$i],
                        'sl' => $i + 1,
                        'create_user' => Auth::user()->user_id,
                        'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
                    ]);

                }

            } catch (\Exception $exception) {
                Log::info($exception->getMessage());
            }

            //end employee language

            ///----------------emp history -------employeement multi data or single data insert

//            $data_empment_avail = EmpHisEmployeement::all()->where('emp_id', Auth::user()->user_id);
            $data_empment_avail = DB::select("select * from mis.EMP_HIS_EMPLOYEEMENT where emp_id  = ? ", [$passed_user_id]);

            if (count($data_empment_avail) == 0) {

            } else {
                DB::table('MIS.EMP_HIS_EMPLOYEEMENT')->where('emp_id', $passed_user_id)->delete();
            }
            $count_employeement = count($request->fdtwo['emplo_com_name']);

            if ($count_employeement > 1) {
                foreach ($request->fdtwo['emplo_com_name'] as $k_ment => $ement) {

                    $empment = array(
                        'emp_id' => $passed_user_id,
                        'emplo_comp_name' => $ement,
                        'emplo_desig' => $request->fdtwo['emplo_desig_name'][$k_ment],
//                        'emplo_from' => $request->fdtwo['emplo_from'][$k_ment],
//                        'emplo_to' => $request->fdtwo['emplo_to'][$k_ment],
                        'emplo_from' => empty($request->fdtwo['emplo_from'][$k_ment]) ? "" : Carbon::createFromFormat('d/m/Y', $request->fdtwo['emplo_from'][$k_ment])->toDateString(),
                        'emplo_to' => empty($request->fdtwo['emplo_to'][$k_ment]) ? "" : Carbon::createFromFormat('d/m/Y', $request->fdtwo['emplo_to'][$k_ment])->toDateString(),
//                        'emplo_from' => $request->fdtwo['emplo_from'][$k_ment],
//                        'emplo_to' => $request->fdtwo['emplo_to'][$k_ment],
                        'department' => $request->fdtwo['emplo_country_dept'][$k_ment],
                        'country' => $request->fdtwo['emplo_country_nam'][$k_ment],
                        'emplo_ref_name' => $request->fdtwo['emplo_ref_nam'][$k_ment],
                        'emplo_cont_no' => $request->fdtwo['emplo_contact_no'][$k_ment],
                        'emplo_rea_lev' => $request->fdtwo['emplo_rea_leav'][$k_ment],

                        'create_user' => Auth::user()->user_id,
                        'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                        'update_user' => Auth::user()->user_id,
                        'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')

                    );

                    if (empty($ement)) {

                    } else {
                        EmpHisEmployeement::insert($empment);
                    }
                }

            } elseif ($count_employeement == 1) {

                $empment = array(
                    'emp_id' => $passed_user_id,
                    'emplo_comp_name' => $request->fdtwo['emplo_com_name'],
                    'emplo_desig' => $request->fdtwo['emplo_desig_name'],
//                    'emplo_from' => $request->fdtwo['emplo_from'],
//                    'emplo_to' => $request->fdtwo['emplo_to'],
                    'emplo_from' => empty($request->fdtwo['emplo_from']) ? "" : Carbon::createFromFormat('d/m/Y', $request->fdtwo['emplo_from'])->toDateString(),
                    'emplo_to' => empty($request->fdtwo['emplo_to']) ? "" : Carbon::createFromFormat('d/m/Y', $request->fdtwo['emplo_to'])->toDateString(),
                    'country' => $request->fdtwo['emplo_country_nam'],
                    'department' => $request->fdtwo['emplo_country_dept'],
                    'emplo_ref_name' => $request->fdtwo['emplo_ref_nam'],
                    'emplo_cont_no' => $request->fdtwo['emplo_contact_no'],
                    'emplo_rea_lev' => $request->fdtwo['emplo_rea_leav'],

                    'create_user' => Auth::user()->user_id,
                    'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                    'update_user' => Auth::user()->user_id,
                    'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')

                );
                EmpHisEmployeement::insert($empment);
            }

            //-----------------------------------------------------------------------------------------------------------------------------
            return response()->json(
                [
                    'dis_id' => "9999",
                    'emp_nid_no' => 'fhdsf',
                    'toatlval' => $request->fdtwo,
                    'status' => 'Y'
//                    'len' => $request->fdtwo['edu_deg_nam'][0]

                ]);

        }
    }

    public function postPagethreeForm(Request $request)
    {
        if ($request->ajax() && $request) {

            $passed_user_id  = $request->fdthree['emp_code_nam'];


            DB::table('mis.emp_his_moreinfo')->where('emp_id', $passed_user_id )->update([
                'relative_incep' => $request->fdthree['incep_rel'],
                'rela_incep_empnam' => $request->fdthree['incep_rel_empnam'],
                'rela_incep_empcode' => $request->fdthree['incep_rel_empcode'],
                'rela_incep_emprel' => $request->fdthree['incep_rel_rela'],

                'update_user' => Auth::user()->user_id,
                'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
            ]);

            //---------------------------employee history children brother sister-------------------------

//            $data_empcbs_avail = EMP_HIS_CHILDBROSIS::all()->where('emp_id', Auth::user()->user_id);
            $data_empcbs_avail = DB::select("select * from mis.EMP_HIS_CHILDBROSIS where emp_id  = ? ", [ $passed_user_id ]);


            if (count($data_empcbs_avail) == 0) {

            } else {
                DB::table('MIS.EMP_HIS_CHILDBROSIS')->where('emp_id', $passed_user_id)->delete();

            }
//            $count_cbs = count($request->fdthree['cbs_country_bir']);

            if (!empty($request->fdthree['cbs_title'])) {
                $count_cbs = count($request->fdthree['cbs_title']);
                if ($count_cbs > 1) {
                    foreach ($request->fdthree['cbs_title'] as $k_cbs => $cbs_val) {

                        $emp_cbs = array(
                            'emp_id' => $passed_user_id,

                            'cbs_title' => $cbs_val,
                            'cbs_name' => $request->fdthree['cbs_name'][$k_cbs],
//                            'cbs_date_birth' => $request->fdthree['cbs_datebir'][$k_cbs],
                            'cbs_date_birth' => empty($request->fdthree['cbs_datebir'][$k_cbs]) ? "" : Carbon::createFromFormat('d/m/Y', $request->fdthree['cbs_datebir'][$k_cbs])->toDateString(),
                            'cbs_plac_birth' => $request->fdthree['cbs_placebir'][$k_cbs],
                            'cbs_cuntry_birth' => $request->fdthree['cbs_country_bir'][$k_cbs],
                            'cbs_nationality' => $request->fdthree['cbs_nationality'][$k_cbs],
                            'cbs_relation' => !empty($request->fdthree['cbs_relationship'][$k_cbs]) ? $request->fdthree['cbs_relationship'][$k_cbs] : "",

                            'create_user' => Auth::user()->user_id,
                            'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                            'update_user' => Auth::user()->user_id,
                            'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')

                        );
                        EMP_HIS_CHILDBROSIS::insert($emp_cbs);

                    }

                } elseif ($count_cbs == 1) {
                    $emp_cbs = array(
                        'emp_id' => $passed_user_id,

                        'cbs_title' => $request->fdthree['cbs_title'],
                        'cbs_name' => $request->fdthree['cbs_name'],
//                        'cbs_date_birth' => $request->fdthree['cbs_datebir'],
                        'cbs_date_birth' => empty($request->fdthree['cbs_datebir']) ? "" : Carbon::createFromFormat('d/m/Y', $request->fdthree['cbs_datebir'])->toDateString(),
                        'cbs_plac_birth' => $request->fdthree['cbs_placebir'],
                        'cbs_cuntry_birth' => $request->fdthree['cbs_country_bir'],
                        'cbs_nationality' => $request->fdthree['cbs_nationality'],
                        'cbs_relation' => !empty($request->fdthree['cbs_relationship']) ? $request->fdthree['cbs_relationship'] : "",

                        'create_user' => Auth::user()->user_id,
                        'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                        'update_user' => Auth::user()->user_id,
                        'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')

                    );
                    EMP_HIS_CHILDBROSIS::insert($emp_cbs);

                }

            }

            //---------------------------employee history children brother sister----------End---------------

            //---------------------------employee history Professional Qualification ---------start----------------

//            $data_empproquali_avail = EMP_HIS_PRO_QUALI::all()->where('emp_id', Auth::user()->user_id);
            $data_empproquali_avail = DB::select("select * from mis.EMP_HIS_PRO_EQUALI where emp_id  = ? ", [$passed_user_id]);

            if (count($data_empproquali_avail) == 0) {

            } else {
                DB::table('MIS.EMP_HIS_PRO_EQUALI')->where('emp_id', $passed_user_id)->delete();

            }
            $count_proquali = count($request->fdthree['proquali_inst_nam']);

            if ($count_proquali > 1) {
                foreach ($request->fdthree['proquali_inst_nam'] as $k_pro => $pro_val) {

                    $emp_pro_quali_data = array(
                        'emp_id' => $passed_user_id,

                        'pro_insti_nam' => $pro_val,
                        'pro_duration' => $request->fdthree['proquali_duration'][$k_pro],

                        'pro_from' => empty($request->fdthree['proquali_from'][$k_pro]) ? "" : Carbon::createFromFormat('d/m/Y', $request->fdthree['proquali_from'][$k_pro])->toDateString(),
                        'pro_to' => empty($request->fdthree['proquali_to'][$k_pro]) ? "" : Carbon::createFromFormat('d/m/Y', $request->fdthree['proquali_to'][$k_pro])->toDateString(),

                        'pro_cour_nam' => $request->fdthree['proquali_coursenam'][$k_pro],
                        'pro_result' => $request->fdthree['proquali_result'][$k_pro],
                        'pro_cuntry' => $request->fdthree['proquali_country'][$k_pro],

                        'create_user' => Auth::user()->user_id,
                        'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                        'update_user' => Auth::user()->user_id,
                        'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')

                    );
                    EMP_HIS_PRO_QUALI::insert($emp_pro_quali_data);

                }

            } elseif ($count_proquali == 1) {

                $emp_pro_quali_data = array(
                    'emp_id' => $passed_user_id,

                    'pro_insti_nam' => $request->fdthree['proquali_inst_nam'],
                    'pro_duration' => $request->fdthree['proquali_duration'],
                    'pro_cour_nam' => $request->fdthree['proquali_coursenam'],
                    'pro_result' => $request->fdthree['proquali_result'],
                    'pro_cuntry' => $request->fdthree['proquali_country'],

                    'pro_from' => empty($request->fdthree['proquali_from']) ? "" : Carbon::createFromFormat('d/m/Y', $request->fdthree['proquali_from'])->toDateString(),
                    'pro_to' => empty($request->fdthree['proquali_to']) ? "" : Carbon::createFromFormat('d/m/Y', $request->fdthree['proquali_to'])->toDateString(),

                    'create_user' => Auth::user()->user_id,
                    'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                    'update_user' => Auth::user()->user_id,
                    'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')

                );
                EMP_HIS_PRO_QUALI::insert($emp_pro_quali_data);

            }

            //---------------------------employee history Professional Qualification ---------end----------------

            //----------------------------------------------------------------------------------

            return response()->json(
                [
                    'dis_id' => "9999",
                    'emp_nid_no' => 'fhdsf',
                    'hh' => $request->fdthree,
                    'cbs_empty' => empty($request->fdthree['cbs_title']),
                    'status' => 'Y'
                ]);

        }
    }

    public function postPageFourForm(Request $request)
    {
        if ($request->ajax() && $request) {

            $passed_user_id  = $request->fdfour['emp_code_nam'];


            //---------------------------employee history Professional Qualification ---------start----------------

//            $emp_his_ref = EmpHisReference::all()->where('emp_id', Auth::user()->user_id);

            $emp_his_ref = DB::select("select * from mis.EMP_HIS_REFERENCE where emp_id  = ? ", [ $passed_user_id]);

            if (empty($emp_his_ref[0]->emp_id)) {
                $data_reference = array(
                    'emp_id' =>  $passed_user_id,

                    'ref_one_nam' => $request->fdfour['ref_one_name'],
                    'ref_one_desig' => $request->fdfour['ref_one_desig'],
                    'ref_one_mob_no' => $request->fdfour['ref_one_phn_number'],
                    'ref_one_email' => $request->fdfour['ref_one_mail'],
                    'ref_one_addr' => $request->fdfour['ref_one_addr'],

                    'ref_two_nam' => $request->fdfour['ref_two_name'],
                    'ref_two_desig' => $request->fdfour['ref_two_desig'],
                    'ref_two_mob_no' => $request->fdfour['ref_two_phn_number'],
                    'ref_two_email' => $request->fdfour['ref_two_mail'],
                    'ref_two_addr' => $request->fdfour['ref_two_addr'],

                    'create_user' => Auth::user()->user_id,
                    'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                    'update_user' => Auth::user()->user_id,
                    'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')

                );
                EmpHisReference::insert($data_reference);
            } else {
                //update-----------------------------------------
                DB::table('mis.emp_his_reference')->where('emp_id',  $passed_user_id)->update([
                    'ref_one_nam' => $request->fdfour['ref_one_name'],
                    'ref_one_desig' => $request->fdfour['ref_one_desig'],
                    'ref_one_mob_no' => $request->fdfour['ref_one_phn_number'],
                    'ref_one_email' => $request->fdfour['ref_one_mail'],
                    'ref_one_addr' => $request->fdfour['ref_one_addr'],

                    'ref_two_nam' => $request->fdfour['ref_two_name'],
                    'ref_two_desig' => $request->fdfour['ref_two_desig'],
                    'ref_two_mob_no' => $request->fdfour['ref_two_phn_number'],
                    'ref_two_email' => $request->fdfour['ref_two_mail'],
                    'ref_two_addr' => $request->fdfour['ref_two_addr'],

                    'update_user' => Auth::user()->user_id,
                    'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
                ]);
            }

            /////===================================nominee multi datta insert================
            ////=========================================================================================

//            $data_empnomi_avail = EmpHisNominee::all()->where('emp_id', Auth::user()->user_id);
            $data_empnomi_avail = DB::select("select * from mis.EMP_HIS_NOMINEE where emp_id  = ? ", [ $passed_user_id]);
            if (count($data_empnomi_avail) == 0) {

            } else {
                DB::table('MIS.emp_his_nominee')->where('emp_id',  $passed_user_id )->delete();
            }

            $count_nomi = count($request->fdfour['nominee_nam']);

            if ($count_nomi > 1) {
                foreach ($request->fdfour['nominee_nam'] as $k_nomi => $nomi_val) {

                    $emp_nomi_data_one = array(
                        'emp_id' =>  $passed_user_id,

                        'nominee_nam' => $nomi_val,
//                        'nominee_nam' => $request->fdfour['nominee_nam'][$k_nomi],
                        'nominee_addr' => $request->fdfour['nominee_addr'][$k_nomi],
                        'nominee_mob_no' => $request->fdfour['nominee_contact_no'][$k_nomi],
                        'nominee_rel' => $request->fdfour['nominee_rela'][$k_nomi],
                        'nominee_share' => $request->fdfour['nominee_share'][$k_nomi],
                        'nominee_img' => isset($data_empnomi_avail[0]) && $data_empnomi_avail[0]->nominee_img !== '' ? $data_empnomi_avail[0]->nominee_img : '',
                        'create_user' => Auth::user()->user_id,
                        'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                        'update_user' => Auth::user()->user_id,
                        'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
                    );

                    if (empty($nomi_val)) {

                    } else {
                        EmpHisNominee::insert($emp_nomi_data_one);
                    }

                }

            } elseif ($count_nomi == 1) {
                $emp_nominee_data = array(
                    'emp_id' =>  $passed_user_id,

                    'nominee_nam' => $request->fdfour['nominee_nam'],
                    'nominee_addr' => $request->fdfour['nominee_addr'],
                    'nominee_mob_no' => $request->fdfour['nominee_contact_no'],
                    'nominee_rel' => $request->fdfour['nominee_rela'],
                    'nominee_share' => $request->fdfour['nominee_share'],
                    'nominee_img' => isset($data_empnomi_avail[0]) && $data_empnomi_avail[0]->nominee_img !== '' ? $data_empnomi_avail[0]->nominee_img : '',
                    'create_user' => Auth::user()->user_id,
                    'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                    'update_user' => Auth::user()->user_id,
                    'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')

                );
                if (empty($request->fdfour['nominee_nam'])) {

                } else {
                    EmpHisNominee::insert($emp_nominee_data);
                }

            }

            //---------------------------employee history Professional Qualification ---------end----------------
            ///------------------------distribution part----guarantor------------------------
            $login_emp_id = Auth::user()->user_id;
            $login_moreinfo = DB::select("select e.*,f.*,d.*,d.dept_name as emp_dept_name ,initcap(f.desig_name) as design_nam_1st_upper
                           from hrms.emp_information@web_to_hrms e,
                            hrms.emp_designation@web_to_hrms f,
                            hrms.dept_information@web_to_hrms d 
                            where e.emp_id=?
                            and e.desig_id=f.desig_id
                            and e.dept_id=d.dept_id", [$passed_user_id]);

//            $login_moreinfo[0]->emp_dept_name='DISTRIBUTION';
            if ($login_moreinfo[0]->emp_dept_name == 'DISTRIBUTION' || $login_moreinfo[0]->emp_dept_name == 'CENTRAL WAREHOUSE') {

                $emp_his_guarantor = DB::select("select * from mis.EMP_HIS_GUARANTOR where emp_id  = ? ", [$passed_user_id]);

                if (empty($emp_his_guarantor[0]->emp_id)) {
                    $emp_his_gurantor_data = array(
                        'emp_id' => $passed_user_id,

                        'guarantor_nam' => $request->fdfour['careOfguar'],
                        'guarantor_cuntry' => $request->fdfour['guarCountry'],
                        //'guarantor_addr1' => $request->fdfour['villageTownguar1st'],
                        //'guarantor_addr2' => $request->fdfour['villageTownguar2nd'],
                        'guarantor_div' => $request->fdfour['guar_bd_div'],
                        'guarantor_dist' => !empty($request->fdfour['guar_bd_dis']) ? $request->fdfour['guar_bd_dis'] : "",
                        'guarantor_polista' => $request->fdfour['postStaguar'],
                        'guarantor_postoff' => $request->fdfour['postOfficeguar'],
                        'guarantor_pcode' => $request->fdfour['postcodeguar'],
                        //'guarantor_mob_no' => $request->fdfour['phonenoguar'],

                        'guarantor_relation' => $request->fdfour['relationOfguar'],
                        'guarantor_homeaddr' => $request->fdfour['grntrHomeAdd'],
                        //'guarantor_orgdetails' => $request->fdfour['grntrOrgDetails'],
                        'guarantor_desig' => $request->fdfour['grntrdesig'],
                        'guarantor_orgname' => $request->fdfour['grntroname'],
                        'guarantor_orgaddr' => $request->fdfour['grntroaddr'],
                        'guarantor_email' => $request->fdfour['grntremail'],
                        'guarantor_cno' => $request->fdfour['grntrcno'],


                        'create_user' => Auth::user()->user_id,
                        'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                        'update_user' => Auth::user()->user_id,
                        'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
                    );
                    //Insert part for page1
//                EmpHistoryMoreInfo::insert($emp_his_moreinfo);
                    EmpHisGuarantor::insert($emp_his_gurantor_data);
                } else {
                    //if exit then do update part--------------------------------------------------
                    DB::table('mis.EMP_HIS_GUARANTOR')->where('emp_id', $passed_user_id)->update([

                        'guarantor_nam' => $request->fdfour['careOfguar'],
                        'guarantor_cuntry' => $request->fdfour['guarCountry'],
                        //'guarantor_addr1' => $request->fdfour['villageTownguar1st'],
                        //'guarantor_addr2' => $request->fdfour['villageTownguar2nd'],
                        'guarantor_div' => $request->fdfour['guar_bd_div'],
                        'guarantor_dist' => !empty($request->fdfour['guar_bd_dis']) ? $request->fdfour['guar_bd_dis'] : "",
                        'guarantor_polista' => $request->fdfour['postStaguar'],
                        'guarantor_postoff' => $request->fdfour['postOfficeguar'],
                        'guarantor_pcode' => $request->fdfour['postcodeguar'],
                        //'guarantor_mob_no' => $request->fdfour['phonenoguar'],


                        'guarantor_relation' => $request->fdfour['relationOfguar'],
                        'guarantor_homeaddr' => $request->fdfour['grntrHomeAdd'],
                        //'guarantor_orgdetails' => $request->fdfour['grntrOrgDetails'],
                        'guarantor_desig' => $request->fdfour['grntrdesig'],
                        'guarantor_orgname' => $request->fdfour['grntroname'],
                        'guarantor_orgaddr' => $request->fdfour['grntroaddr'],
                        'guarantor_email' => $request->fdfour['grntremail'],
                        'guarantor_cno' => $request->fdfour['grntrcno'],

                        'update_user' => Auth::user()->user_id,
                        'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')]);
                }
            }

            //----------------------------------------------------------------------------------
            if (strtoupper($request->type) === 'FS') {
                DB::table('mis.emp_his_moreinfo')->where('emp_id', $passed_user_id)->update([
                    'emp_final_sub' => 'submit_yes',
                    'update_user' => Auth::user()->user_id,
                    'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
                ]);
            }

            return response()->json(
                [
                    'dis_id' => "9999",
                    'emp_nid_no' => 'fhdsf',
                    'hh' => $request->fdfour,
                    'status' => 'Y'
                ]);

        }
    }

    public function nominee_image_upload(Request $request)
    {

        $data = $request->file('file');
        $emp = $request->emp_id;
        $image = \Image::make($data)->resize(200, 200);

        $extension = $data->getClientOriginalExtension();
        $filename = $emp . '_nominee' . '.' . $extension;
        $path = public_path('emp_history_img/nominee/');


        $nomineeImage = public_path("emp_history_img/nominee/{$filename}");
        if (File::exists($nomineeImage)) {
            // unlink or remove previous image from folder
            unlink($nomineeImage);
        }

        $status = DB::table('mis.emp_his_nominee')->where('emp_id', $emp)->update([
            'nominee_img' => $filename,
            'update_user' => Auth::user()->user_id,
            'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
        ]);

        $response = 'f';
        if ($status) {
            $image->save($path . $filename);
            $response = 't';
        }

        return response()->json([
            'nominee_img' => $filename,
            'status' => $response
        ]);
    }

    public function mail_pdf(Request $request)
    {
        if ($request->ajax()) {

            $passed_user_id  = $request->emp_id;

            $user = DB::select('select user_id,name,email,raw_password
                                from mis.dashboard_users_info
                                where user_id = ?', [$passed_user_id]);

            $responseData = [];
            if ($user) {
                if (strpos($request->email, '@') !== false && strpos($request->email, '.com') !== false) {

                    $login_emp_id = Auth::user()->user_id;
                    $login_moreinfo = DB::select("select e.*,f.*,d.*,d.dept_name as emp_dept_name ,initcap(f.desig_name) as design_nam_1st_upper,
                           initcap(e.sur_name) as sur_name_1st_upper,
                            initcap(d.dept_name) as emp_dept_name_1st_upper from hrms.emp_information@web_to_hrms e,
                            hrms.emp_designation@web_to_hrms f,
                            hrms.dept_information@web_to_hrms d 
                            where e.emp_id=?
                            and e.desig_id=f.desig_id
                            and e.dept_id=d.dept_id", [$passed_user_id]);


                    $login_urright_desig = $login_moreinfo[0]->desig_name;
                    //get the divisions-------------
                    $bd_div = DB::select("SELECT B.DIV_ID, B.DIV_NAME, B.BN_NAME FROM MIS.BD_DIVISONS B");
                    //get the districts-------------
                    $bd_dis = DB::select("SELECT B.DIS_ID, B.DIVISION_ID, B.DIS_NAME FROM MIS.BD_DISTRICTS B");
                    //get the all country-------------
                    $all_country = DB::select("SELECT A.COUNTRY_ID, A.COUNTRY_CODE, A.COUNTRY_NAME FROM MIS.ALL_COUNTRIES A");
                    $emp_his_moreinfoid = DB::select("select * from mis.EMP_HIS_MOREINFO where emp_id  = ? ", [$passed_user_id]);
                    $emp_his_infoid = DB::select("select * from mis.EMP_HIS_INFO where emp_id  = ? ", [$passed_user_id]);
                    $emp_his_addr = DB::select("select * from mis.EMP_HIS_ADDR where emp_id  = ? ", [$passed_user_id]);
                    $emp_hisfamidetail = DB::select("select * from mis.EMP_FAMILY_DETAIL where emp_id  = ? ", [$passed_user_id]);
                    $emp_his_edu_old = DB::select("select * from mis.EMP_HIS_EDUCATION where emp_id  = ? order by edu_passing_yr desc", [$passed_user_id]);
                    $emp_his_emplment_old = DB::select("select * from mis.EMP_HIS_EMPLOYEEMENT where emp_id  = ? ", [$passed_user_id]);
                    $emp_his_cbs_old = DB::select("select * from mis.EMP_HIS_CHILDBROSIS where emp_id  = ? ", [$passed_user_id]);
                    $emp_his_pro_quali = DB::select("select * from mis.EMP_HIS_PRO_EQUALI where emp_id  = ? ", [$passed_user_id]);
                    $emp_his_ref_data = DB::select("select * from mis.EMP_HIS_REFERENCE where emp_id  = ? ", [$passed_user_id]);
                    $emp_his_nomi_data = DB::select("select * from mis.EMP_HIS_NOMINEE where emp_id  = ? ", [$passed_user_id]);
                    $emp_his_qurantr_data = DB::select("select * from mis.EMP_HIS_GUARANTOR where emp_id  = ? ", [$passed_user_id]);
                    $emp_his_emplment_old_ext = DB::select("select * from mis.EMP_HIS_EMPLOYEEMENT where emp_id  = ? and upper(emplo_comp_name) not like 'INCEPTA%' order by emplo_from desc", [$passed_user_id]);
                    $emp_his_emplment_old_int = DB::select("select * from mis.EMP_HIS_EMPLOYEEMENT where emp_id  = ? and upper(emplo_comp_name) like 'INCEPTA%' order by emplo_from desc", [$passed_user_id]);

                    //30.9.2019
                    //get the divisions-------------
                    $edu_all_board = DB::select("SELECT B.BOARD_ID, B.BOARD_NAME FROM MIS.EDU_BOARD B");
                    $edu_all_grp = DB::select("SELECT * FROM MIS.EDU_GROUP B");
                    $edu_all_degree = DB::select("SELECT * FROM MIS.EDU_DEGREE B");
                    //30.9.2019
                    $emp_his_language = EmpHisLanguage::where('emp_id', '=', $passed_user_id)->orderBy('sl')->get();

                    //data----------------------------

                    $headerHtml = view()->make('emp_history.entry_form_hr.pdf_header_hr',['user' =>$passed_user_id])->render();

                    $pdf = \SPDF::setOptions([
                        'images' => true,
                        'margin-top' => '15mm',
                        'header-html' => $headerHtml
                    ])->loadView('emp_history/entry_form_hr/emp_his_pdf', compact('login_urright_desig', 'login_moreinfo', 'bd_div', 'bd_dis', 'all_country',
                        'emp_his_moreinfoid', 'emp_his_addr', 'emp_his_infoid', 'emp_hisfamidetail',
                        'emp_his_edu_old', 'emp_his_cbs_old', 'emp_his_emplment_old_ext','emp_his_emplment_old_int', 'emp_his_pro_quali',
                        'emp_his_ref_data', 'emp_his_nomi_data', 'emp_his_qurantr_data', 'edu_all_board', 'edu_all_grp', 'edu_all_degree','emp_his_language'))->setPaper('a4', 'portrait');


                    Mail::send(['html' => 'emp_history.emp_his_mail_pdf_hr'], ['user' => $user], function ($message) use ($user, $pdf,$request) {
                        $message->to($request->email, $user[0]->name)
                            ->subject('Employee History Form');
                        $message->attachData($pdf->output(), 'Employee_history_form.pdf', [
                            'mime' => 'application/pdf',
                        ]);
                        $message->from('hr@inceptapharma.com');
                    });
                    $responseData = ['response' => 'Please check your email!'];

                } else {
                    $responseData = ['response' => 'Email ID not valid! Please contact with HR Department'];
                }
            } else {
                $responseData = ['response' => 'Employee code not valid!'];
            }

            return response()->json($responseData);
        }
    }

    public function emphistory_pdf(Request $request)
    {

        //update after clicking 'download pdf'....HR fields restrcited
//        DB::table('mis.emp_his_moreinfo')->where('emp_id', Auth::user()->user_id)->update([
//            'emp_final_sub' => 'submit_yes',
//            'update_user' => Auth::user()->user_id,
//            'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
//        ]);
        //data-------------------------------------

//        $passed_user_id  = $request->field1['emp'];

        $passed_user_id = $request->emp_code_nam;


            $login_emp_id = Auth::user()->user_id;
            $login_moreinfo = DB::select("select e.*,f.*,d.*,d.dept_name as emp_dept_name ,initcap(f.desig_name) as design_nam_1st_upper,
                           initcap(e.sur_name) as sur_name_1st_upper,
                            initcap(d.dept_name) as emp_dept_name_1st_upper from hrms.emp_information@web_to_hrms e,
                            hrms.emp_designation@web_to_hrms f,
                            hrms.dept_information@web_to_hrms d 
                            where e.emp_id=?
                            and e.desig_id=f.desig_id
                            and e.dept_id=d.dept_id", [$passed_user_id]);


            $login_urright_desig = $login_moreinfo[0]->desig_name;
            //get the divisions-------------
            $bd_div = DB::select("SELECT B.DIV_ID, B.DIV_NAME, B.BN_NAME FROM MIS.BD_DIVISONS B");
            //get the districts-------------
            $bd_dis = DB::select("SELECT B.DIS_ID, B.DIVISION_ID, B.DIS_NAME FROM MIS.BD_DISTRICTS B");
            //get the all country-------------
            $all_country = DB::select("SELECT A.COUNTRY_ID, A.COUNTRY_CODE, A.COUNTRY_NAME FROM MIS.ALL_COUNTRIES A");
            $emp_his_moreinfoid = DB::select("select * from mis.EMP_HIS_MOREINFO where emp_id  = ? ", [$passed_user_id]);
            $emp_his_infoid = DB::select("select * from mis.EMP_HIS_INFO where emp_id  = ? ", [$passed_user_id]);
            $emp_his_addr = DB::select("select * from mis.EMP_HIS_ADDR where emp_id  = ? ", [$passed_user_id]);
            $emp_hisfamidetail = DB::select("select * from mis.EMP_FAMILY_DETAIL where emp_id  = ? ", [$passed_user_id]);
            $emp_his_edu_old = DB::select("select * from mis.EMP_HIS_EDUCATION where emp_id  = ? order by edu_passing_yr desc", [$passed_user_id]);
            $emp_his_emplment_old_ext = DB::select("select * from mis.EMP_HIS_EMPLOYEEMENT where emp_id  = ? and upper(emplo_comp_name) not like 'INCEPTA%' order by emplo_from desc", [$passed_user_id]);
            $emp_his_emplment_old_int = DB::select("select * from mis.EMP_HIS_EMPLOYEEMENT where emp_id  = ? and upper(emplo_comp_name) like 'INCEPTA%' order by emplo_from desc", [$passed_user_id]);
            $emp_his_cbs_old = DB::select("select * from mis.EMP_HIS_CHILDBROSIS where emp_id  = ? ", [$passed_user_id]);
            $emp_his_pro_quali = DB::select("select * from mis.EMP_HIS_PRO_EQUALI where emp_id  = ? ", [$passed_user_id]);
            $emp_his_ref_data = DB::select("select * from mis.EMP_HIS_REFERENCE where emp_id  = ? ", [$passed_user_id]);
            $emp_his_nomi_data = DB::select("select * from mis.EMP_HIS_NOMINEE where emp_id  = ? ", [$passed_user_id]);
            $emp_his_qurantr_data = DB::select("select * from mis.EMP_HIS_GUARANTOR where emp_id  = ? ", [$passed_user_id]);


            //30.9.2019
            //get the divisions-------------
            $edu_all_board = DB::select("SELECT B.BOARD_ID, B.BOARD_NAME FROM MIS.EDU_BOARD B");
            $edu_all_grp = DB::select("SELECT * FROM MIS.EDU_GROUP B");
            $edu_all_degree = DB::select("SELECT * FROM MIS.EDU_DEGREE B");
            //30.9.2019
            $emp_his_language = EmpHisLanguage::where('emp_id', '=', $passed_user_id)->orderBy('sl')->get();


            //data----------------------------
            $headerHtml = view()->make('emp_history.entry_form_hr.pdf_header_hr',['user' =>$passed_user_id])->render();

        $pdf = \SPDF::setOptions([
            'images' => true,
            'margin-top' => '15mm',
            'header-html' => $headerHtml
        ])->loadView('emp_history/entry_form_hr/emp_his_pdf', compact('login_urright_desig', 'login_moreinfo', 'bd_div', 'bd_dis', 'all_country',
            'emp_his_moreinfoid', 'emp_his_addr', 'emp_his_infoid', 'emp_hisfamidetail',
            'emp_his_edu_old', 'emp_his_cbs_old', 'emp_his_emplment_old_ext','emp_his_emplment_old_int', 'emp_his_pro_quali',
            'emp_his_ref_data', 'emp_his_nomi_data', 'emp_his_qurantr_data', 'edu_all_board', 'edu_all_grp', 'edu_all_degree', 'emp_his_language'))->setPaper('a4', 'portrait');

        return $pdf->download('Employee_history_form.pdf');



    }

    public function emphistory_pdf_preview(Request $request)
    {
        //data-------------------------------------

        $passed_user_id = $request->emp_code_nam;

        $login_emp_id = Auth::user()->user_id;

        $login_moreinfo = DB::select("select e.*,f.*,d.*,d.dept_name as emp_dept_name ,initcap(f.desig_name) as design_nam_1st_upper,
                           initcap(e.sur_name) as sur_name_1st_upper,
                            initcap(d.dept_name) as emp_dept_name_1st_upper from hrms.emp_information@web_to_hrms e,
                            hrms.emp_designation@web_to_hrms f,
                            hrms.dept_information@web_to_hrms d 
                            where e.emp_id=?
                            and e.desig_id=f.desig_id
                            and e.dept_id=d.dept_id", [$passed_user_id]);


        $login_urright_desig = $login_moreinfo[0]->desig_name;
        //get the divisions-------------
        $bd_div = DB::select("SELECT B.DIV_ID, B.DIV_NAME, B.BN_NAME FROM MIS.BD_DIVISONS B");
        //get the districts-------------
        $bd_dis = DB::select("SELECT B.DIS_ID, B.DIVISION_ID, B.DIS_NAME FROM MIS.BD_DISTRICTS B");
        //get the all country-------------
        $all_country = DB::select("SELECT A.COUNTRY_ID, A.COUNTRY_CODE, A.COUNTRY_NAME FROM MIS.ALL_COUNTRIES A");
        $emp_his_moreinfoid = DB::select("select * from mis.EMP_HIS_MOREINFO where emp_id  = ? ", [$passed_user_id]);
        $emp_his_infoid = DB::select("select * from mis.EMP_HIS_INFO where emp_id  = ? ", [$passed_user_id]);
        $emp_his_addr = DB::select("select * from mis.EMP_HIS_ADDR where emp_id  = ? ", [$passed_user_id]);
        $emp_hisfamidetail = DB::select("select * from mis.EMP_FAMILY_DETAIL where emp_id  = ? ", [$passed_user_id]);
        $emp_his_edu_old = DB::select("select * from mis.EMP_HIS_EDUCATION where emp_id  = ? order by edu_passing_yr desc", [$passed_user_id]);
        $emp_his_emplment_old_ext = DB::select("select * from mis.EMP_HIS_EMPLOYEEMENT where emp_id  = ? and upper(emplo_comp_name) not like 'INCEPTA%' order by emplo_from desc", [$passed_user_id]);
        $emp_his_emplment_old_int = DB::select("select * from mis.EMP_HIS_EMPLOYEEMENT where emp_id  = ? and upper(emplo_comp_name) like 'INCEPTA%' order by emplo_from desc", [$passed_user_id]);
        $emp_his_cbs_old = DB::select("select * from mis.EMP_HIS_CHILDBROSIS where emp_id  = ? ", [$passed_user_id]);
        $emp_his_pro_quali = DB::select("select * from mis.EMP_HIS_PRO_EQUALI where emp_id  = ? ", [$passed_user_id]);
        $emp_his_ref_data = DB::select("select * from mis.EMP_HIS_REFERENCE where emp_id  = ? ", [$passed_user_id]);
        $emp_his_nomi_data = DB::select("select * from mis.EMP_HIS_NOMINEE where emp_id  = ? ", [$passed_user_id]);
        $emp_his_qurantr_data = DB::select("select * from mis.EMP_HIS_GUARANTOR where emp_id  = ? ", [$passed_user_id]);


        //30.9.2019
        //get the divisions-------------
        $edu_all_board = DB::select("SELECT B.BOARD_ID, B.BOARD_NAME FROM MIS.EDU_BOARD B");
        $edu_all_grp = DB::select("SELECT * FROM MIS.EDU_GROUP B");
        $edu_all_degree = DB::select("SELECT * FROM MIS.EDU_DEGREE B");
        //30.9.2019
        $emp_his_language = EmpHisLanguage::where('emp_id', '=', $passed_user_id)->orderBy('sl')->get();

        //data----------------------------
        $pdf = \SPDF::setOptions([
            'images' => true
        ])->loadView('emp_history/entry_form_hr/emp_his_pdf_preview', compact('login_urright_desig', 'login_moreinfo', 'bd_div', 'bd_dis', 'all_country',
            'emp_his_moreinfoid', 'emp_his_addr', 'emp_his_infoid', 'emp_hisfamidetail',
            'emp_his_edu_old', 'emp_his_cbs_old', 'emp_his_emplment_old_ext','emp_his_emplment_old_int', 'emp_his_pro_quali',
            'emp_his_ref_data', 'emp_his_nomi_data', 'emp_his_qurantr_data', 'edu_all_board', 'edu_all_grp', 'edu_all_degree','emp_his_language'))->setPaper('a4', 'portrait');

//        return $pdf->inline('Employee_history_Preview.pdf');
        return $pdf->inline('Employee_history_Preview.pdf');




    }


}
