<?php

namespace App\Http\Controllers\TDS;

use App\Http\Controllers\Controller;
use DateTime;
use http\Env\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


class TalentDevelopmentFormController extends Controller
{
    public $filename;

    public function user_guidelines()
    {
        return view('talent_development/user_guidelines');
    }

    public function index(Request $request = null, $empId  = null)
    {
        $empId = $request->emp_id;
        if (!empty($empId)) {
            $uid = Auth::user()->user_id;
            $emp_his_info = DB::select("select get_emp_desig('$empId') desig_name,a.*,b.*
            from
            (select * from mis.EMP_HIS_INFO where emp_id  = ? ) a, 
            (select * from mis.EMP_HIS_MOREINFO where emp_id  = ? ) b
            where a.emp_id = b.emp_id ", [$empId, $empId]);

            $empList = DB::select("select distinct emp_id,get_emp_name(emp_id) emp_name from mis.leave_emp_info where head_of_dept =  '$empId' or REPORT_SUPERVISOR = '$empId'   and valid = 'YES' order by emp_id ");

            $cnt = DB::select(" select count(*) mgr from mis.leave_emp_info where head_of_dept ='$empId' or REPORT_SUPERVISOR = '$empId' ");


            Log::info("this is manager info if");
            Log::info($cnt);

            $emp_his_moreinfoid = DB::select("select * from mis.EMP_HIS_MOREINFO where emp_id  = ? ", [$empId]);
            $emp_his_emplment_old = DB::select("select * from mis.EMP_HIS_EMPLOYEEMENT where emp_id  = ? order by emplo_from desc ", [$empId]);
            $emp_his_job_last = DB::select("select * from( select * from mis.emp_his_employeement where emp_id  = ? and upper(emplo_comp_name) not like Upper('%INCEPTA%') order by emplo_from desc) where rownum=1", [$empId]);
            $emp_his_language = DB::select("select * from mis.EMP_HIS_LANGUAGE where emp_id  = ? order by sl asc", [$empId]);
            // $emp_his_language = DB::select("select * from mis.EMP_HIS_EDUCATION where emp_id  = ? order by edu_passing_yr desc", [$uid]);

           // $head_dtl = DB::select("select get_emp_name(head_of_dept) head_name, get_emp_desig(head_of_dept) head_desig, get_emp_joining(head_of_dept) joining from mis.leave_emp_info where emp_id = '$empId'");

            //$head_dtl = DB::select("select get_emp_nam, get_emp_desig(head_of_dept) head_desig, get_emp_joining(head_of_dept) joining from mis.leave_emp_info where emp_id = '$empId'");

            $head_dtl = DB::select("SELECT DISTINCT dgi.desig_name,imf.SUR_NAME,imf.JOINING_DATE FROM hrms.emp_information@WEB_TO_HRMS imf,hrms.EMP_DESIGNATION@WEB_TO_HRMS dgi where  
                                                                dgi.DESIG_ID = imf.DESIG_ID  and imf.EMP_ID='$empId' ");



            $emp_his_edu_old = DB::select("select * from mis.EMP_HIS_EDUCATION eie,MIS.EDU_DEGREE ed where emp_id  = ? and EIE.EDU_DESIG_NAME = ED.DEG_ID order by ED.PRECEDENCE desc ", [$empId]);
            $edu_all_board = DB::select("SELECT B.BOARD_ID, B.BOARD_NAME FROM MIS.EDU_BOARD B");
            $edu_all_grp = DB::select("SELECT * FROM MIS.EDU_GROUP B");
            $edu_all_degree = DB::select("SELECT * FROM MIS.EDU_DEGREE B");

            $emp_his_pro_quali = DB::select("select * from mis.EMP_HIS_PRO_EQUALI where emp_id  = ? ", [$empId]);

            $development_group = DB::select("select * from mis.td_development_group");

            /*Successors info for manager*/
            $successor= DB::select("select emp_id employee_id, initcap(emp_id ||'-'|| sur_name )as emp_id_name, sur_name emp_name , mis.get_emp_desig(emp_id) desig
            from hrms.emp_information@WEB_TO_HRMS
            where emp_id in (
                select emp_id
                from mis.leave_emp_info
                where head_of_dept = '$uid'
                and valid = 'YES'
            )
            and emp_id != '$uid'
            order by emp_id

            ");

            /*Successors info for specific user*/
            $all_users_successor= DB::select("select * from MIS.TDS_TALENT_DEVELOPMENT_SUCCESS

             where employee_id  = '$empId'");
            $users_successor=[];
            $another_user_successor=[];

            foreach ($all_users_successor as $us){

                if($us->serial_no!=4){
                    array_push($users_successor,$us);
                }else{
                    array_push($another_user_successor,$us);
                }
            }

            $check_for_search='yes';

            /**
             * retrieve info for updating data
             */
            $tds_dev_info = DB::select("select * from MIS.TDS_TALENT_DEVELOPMENT_INFO

             where employee_id  = '$empId'");

            $head_of_dept = DB::select("select HEAD_OF_DEPT from MIS.LEAVE_EMP_INFO where HEAD_OF_DEPT='$uid' or REPORT_SUPERVISOR='$uid'");
           // dd($emp_his_info);

            return view('talent_development/talent_development_from',
                compact('emp_his_info', 'head_dtl', 'emp_his_moreinfoid', 'emp_his_edu_old',
                    'edu_all_degree', 'edu_all_board', 'edu_all_grp', 'emp_his_emplment_old', 'development_group',
                    'emp_his_job_last', 'emp_his_language', 'emp_his_pro_quali','empList','cnt','successor',
                    'tds_dev_info','users_successor','check_for_search','users_successor','another_user_successor','head_of_dept'
                ));
        }
        else {

            $uid = Auth::user()->user_id;

            $emp_his_info = DB::select("select get_emp_desig('$uid') desig_name,a.*,b.*
            from
            (select * from mis.EMP_HIS_INFO where emp_id  = ? ) a, 
            (select * from mis.EMP_HIS_MOREINFO where emp_id  = ? ) b
            where a.emp_id = b.emp_id ", [$uid, $uid]);

            if(empty($emp_his_info)){
                return view('talent_development/error_information');
            }

            /*$empList = DB::select(" select distinct emp_id,get_emp_name(emp_id) emp_name from mis.leave_emp_info where head_of_dept =  '$uid' and valid = 'YES' order by emp_id ");
            $cnt = DB::select(" select count(*) mgr from mis.leave_emp_info where head_of_dept = ? ", [$uid]);

            */

            $empList = DB::select("select distinct emp_id,get_emp_name(emp_id) emp_name from mis.leave_emp_info where head_of_dept =  '$uid' or REPORT_SUPERVISOR = '$uid'   and valid = 'YES' order by emp_id ");

            $cnt = DB::select(" select count(*) mgr from mis.leave_emp_info where head_of_dept ='$uid' or REPORT_SUPERVISOR = '$uid' ");


            Log::info("this is manager info");
            Log::info($cnt);


            $emp_his_moreinfoid = DB::select("select * from mis.EMP_HIS_MOREINFO where emp_id  = ? ", [$uid]);
            $emp_his_emplment_old = DB::select("select * from mis.EMP_HIS_EMPLOYEEMENT where emp_id  = ? order by emplo_from desc ", [$uid]);
            $emp_his_job_last = DB::select("select * from( select * from mis.emp_his_employeement where emp_id  = ? and upper(emplo_comp_name) not like Upper('%INCEPTA%') order by emplo_from desc) where rownum=1", [$uid]);
            $emp_his_language = DB::select("select * from mis.EMP_HIS_LANGUAGE where emp_id  = ? order by sl asc", [$uid]);
            // $emp_his_language = DB::select("select * from mis.EMP_HIS_EDUCATION where emp_id  = ? order by edu_passing_yr desc", [$uid]);


            /*$head_dtl = DB::select("select get_emp_name(head_of_dept) head_name, get_emp_desig(head_of_dept) head_desig, get_emp_joining(head_of_dept) joining from mis.leave_emp_info where emp_id = '$uid'");*/

            $head_dtl = DB::select("SELECT DISTINCT dgi.desig_name,imf.SUR_NAME,imf.JOINING_DATE FROM hrms.emp_information@WEB_TO_HRMS imf,hrms.EMP_DESIGNATION@WEB_TO_HRMS dgi where  
                                                                dgi.DESIG_ID = imf.DESIG_ID  and imf.EMP_ID='$uid' ");




            $emp_his_edu_old = DB::select("select * from mis.EMP_HIS_EDUCATION eie,MIS.EDU_DEGREE ed where emp_id  = ? and EIE.EDU_DESIG_NAME = ED.DEG_ID order by ED.PRECEDENCE desc ", [$uid]);
            $edu_all_board = DB::select("SELECT B.BOARD_ID, B.BOARD_NAME FROM MIS.EDU_BOARD B");
            $edu_all_grp = DB::select("SELECT * FROM MIS.EDU_GROUP B");
            $edu_all_degree = DB::select("SELECT * FROM MIS.EDU_DEGREE B");

            $emp_his_pro_quali = DB::select("select * from mis.EMP_HIS_PRO_EQUALI where emp_id  = ? ", [$uid]);

            $development_group = DB::select("select * from mis.td_development_group");


            //get second page info
            $tds_dev_info = DB::select("select * from MIS.TDS_TALENT_DEVELOPMENT_INFO

             where employee_id  = '$uid'");

            //get successors info
            $successor= DB::select("select emp_id employee_id, initcap(emp_id ||'-'|| sur_name )as emp_id_name, sur_name emp_name , mis.get_emp_desig(emp_id) desig
            from hrms.emp_information@WEB_TO_HRMS
            where emp_id in (
            
                select emp_id
                from mis.leave_emp_info
                where head_of_dept = '$uid'
                and valid = 'YES'
            
            )
            and emp_id != '$uid'
            order by emp_id
            
            ");

            /*Successors info for specific user*/
            $all_users_successor= DB::select("select * from MIS.TDS_TALENT_DEVELOPMENT_SUCCESS

             where employee_id  = '$uid'");
            $users_successor=[];
            $another_user_successor=[];
            foreach ($all_users_successor as $us){

                if($us->serial_no!=4){
                    array_push($users_successor,$us);
                }else{
                    array_push($another_user_successor,$us);
                }
            }

            $check_for_search='no';

            //$head_of_dept = DB::select("select HEAD_OF_DEPT from MIS.LEAVE_EMP_INFO where HEAD_OF_DEPT='$uid'");
            $head_of_dept = DB::select("select HEAD_OF_DEPT from MIS.LEAVE_EMP_INFO where HEAD_OF_DEPT='$uid' or REPORT_SUPERVISOR='$uid'");



            return view('talent_development/talent_development_from',
                compact('emp_his_info', 'head_dtl', 'emp_his_moreinfoid', 'emp_his_edu_old',
                    'edu_all_degree', 'edu_all_board', 'edu_all_grp', 'emp_his_emplment_old', 'development_group',
                    'emp_his_job_last', 'emp_his_language', 'emp_his_pro_quali','empList','cnt','successor',
                    'tds_dev_info','check_for_search','users_successor','another_user_successor','head_of_dept'
                ));
        }

    }

    public function employeeTdPDF(Request $request)
    {
        $uid = $request->emp_id;

        $emp_his_info = DB::select("select get_emp_desig('$uid') desig_name,a.*,b.*
        from
        (select * from mis.EMP_HIS_INFO where emp_id  = ? ) a, 
        (select * from mis.EMP_HIS_MOREINFO where emp_id  = ? ) b
        where a.emp_id = b.emp_id ", [$uid, $uid]);

        $emp_his_moreinfoid = DB::select("select * from mis.EMP_HIS_MOREINFO where emp_id  = ? ", [$uid]);
        $emp_his_emplment_old = DB::select("select * from mis.EMP_HIS_EMPLOYEEMENT where emp_id  = ? order by emplo_from desc ", [$uid]);
        $emp_his_job_last = DB::select("select * from( select * from mis.emp_his_employeement where emp_id  = ? and upper(emplo_comp_name) not like Upper('%INCEPTA%') order by emplo_from desc) where rownum=1", [$uid]);
        $emp_his_language = DB::select("select * from mis.EMP_HIS_LANGUAGE where emp_id  = ? order by sl asc", [$uid]);


        $head_dtl = DB::select("select get_emp_name(head_of_dept) head_name, get_emp_desig(head_of_dept) head_desig, get_emp_joining(head_of_dept) joining from mis.leave_emp_info where emp_id = '$uid'");

        $emp_his_edu_old = DB::select("select * from mis.EMP_HIS_EDUCATION eie,MIS.EDU_DEGREE ed where emp_id  = ? and EIE.EDU_DESIG_NAME = ED.DEG_ID order by ED.PRECEDENCE desc ", [$uid]);
        $edu_all_board = DB::select("SELECT B.BOARD_ID, B.BOARD_NAME FROM MIS.EDU_BOARD B");
        $edu_all_grp = DB::select("SELECT * FROM MIS.EDU_GROUP B");
        $edu_all_degree = DB::select("SELECT * FROM MIS.EDU_DEGREE B");

        $emp_his_pro_quali = DB::select("select * from mis.EMP_HIS_PRO_EQUALI where emp_id  = ? ", [$uid]);

        $pdf = \PDF::loadView('talent_development.reports.td_form_pdf',
            compact('emp_his_info', 'head_dtl', 'emp_his_moreinfoid', 'emp_his_edu_old',
                'edu_all_degree', 'edu_all_board', 'edu_all_grp', 'emp_his_emplment_old',
                'emp_his_job_last', 'emp_his_language', 'emp_his_pro_quali'
            )
        )->setPaper('a4', 'landscape');

        return $pdf->stream('EmployeeTD.pdf');
    }

    public function getGroupText(Request $request)
    {
        $rs = DB::select("SELECT * FROM MIS.TD_DEVELOPMENT_GROUP where dg_id = '$request->group_id'");
        return response()->json($rs);
    }

    public function getPotentialText(Request $request)
    {
        $rs = DB::select("SELECT * FROM MIS.TD_POTENTIALS_EXPLAINED where pe_id = '$request->pe_id'");
        return response()->json($rs);
    }

    //TDS Manager
    public function tds_manager_form()
    {
        $uid = Auth::user()->user_id;
        $rs = DB::select(" select emp_id, mis.get_emp_name(emp_id) emp_name from mis.leave_emp_info where head_of_dept = '$uid' and valid = 'YES' order by emp_id");
        return view('talent_development/talent_manager_from', compact('rs'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSuccessorsInfo(Request $request){

        $successor= DB::select("select emp_id employee_id,  mis.get_emp_desig($request->emp_id) desig
            from hrms.emp_information@WEB_TO_HRMS
            where emp_id='$request->emp_id'
            ");
        return response()->json($successor);

        if($successor){
            return response()->json($successor);
        }else{
            return response()->json("");
        }


    }

    /*
     * Other successor name current position
     * */
    public function getOtherEmpNamePosition(Request $request){

        $emp_id = $request->emp_id;

        $empNamePosition = DB::select("SELECT DISTINCT dgi.desig_name,imf.SUR_NAME FROM hrms.emp_information@WEB_TO_HRMS imf,hrms.EMP_DESIGNATION@WEB_TO_HRMS dgi  
        where  dgi.DESIG_ID = imf.DESIG_ID  and imf.EMP_ID='$emp_id' ");

        if($empNamePosition){
            return response()->json($empNamePosition);
        }else{
            return response()->json("");
        }

    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Update TDS Information
     */
    public function updateTdsInformation(Request $request){
        /**
         * TDS Table Data
         */
        $user_id = Auth::user()->user_id;
        DB::setDateFormat('DD-MON-RR');
        $tds_data = $request->tds_data;

        //successors table data
        $emp_designation = $request->emp_designation;
        $successors_ids = $request->successors_id;
        $successors_readiness = $request->successors_readiness;
        $emp_name = $request->emp_name;
        $serial_no = $request->serial_numbers;
        $rr = $request->tds_data['employee_id'];
        $tds_status = DB::table('MIS.TDS_TALENT_DEVELOPMENT_INFO')->where('employee_id',($request->tds_data['employee_id']))->update($tds_data);


       if($tds_status){
           $employee_id = $request->tds_data['employee_id'];
           $successor_old_data =  DB::select("select * from MIS.TDS_TALENT_DEVELOPMENT_SUCCESS  where employee_id  = ? ", [$employee_id] );

           if(!empty($successor_old_data)){
               $delete_status = DB::delete("delete from MIS.TDS_TALENT_DEVELOPMENT_SUCCESS
                                        where EMPLOYEE_ID=?",[$rr]);

               if($delete_status){
                   if(!empty($successors_ids)){
                       for($i=0;$i<sizeof($successors_ids);$i++){
                           $successors_data['SUCCESSOR_ID']= $successors_ids[$i];
                           $successors_data['EMPLOYEE_ID']= $request->tds_data['employee_id'];
                           $successors_data['SUCCESSOR_READINESS']= $successors_readiness[$i];
                           $successors_data['EMP_DESIGNATION']= $emp_designation[$i];
                           $successors_data['EMP_NAME']= $emp_name[$i];
                           $successors_data['MANAGER_ID']= $user_id;
                           $successors_data['SERIAL_NO']= $serial_no[$i];
                           $successors_status = DB::table('MIS.TDS_TALENT_DEVELOPMENT_SUCCESS')->insert($successors_data);
                       }
                       if($successors_status){
                           return response()->json(['status'=>'UPDATED']);
                       }else{
                           return response()->json(['status'=>'ERROR 500']);
                       }
                   }else{
                       return response()->json(['status'=>'UPDATED']);
                   }
               }
               else{
                   return response()->json(['status'=>'ERROR 500']);
               }
           }else{
               if(!empty($successors_ids)){
                   for($i=0;$i<sizeof($successors_ids);$i++){
                       $successors_data['SUCCESSOR_ID']= $successors_ids[$i];
                       $successors_data['EMPLOYEE_ID']= $request->tds_data['employee_id'];
                       $successors_data['SUCCESSOR_READINESS']= $successors_readiness[$i];
                       $successors_data['EMP_DESIGNATION']= $emp_designation[$i];
                       $successors_data['EMP_NAME']= $emp_name[$i];
                       $successors_data['MANAGER_ID']= $user_id;
                       $successors_data['SERIAL_NO']= $serial_no[$i];
                       $successors_status = DB::table('MIS.TDS_TALENT_DEVELOPMENT_SUCCESS')->insert($successors_data);
                   }
                   if($successors_status){
                       return response()->json(['status'=>'UPDATED']);
                   }else{
                       return response()->json(['status'=>'ERROR 500']);
                   }
               }else{
                   return response()->json(['status'=>'UPDATED']);
               }
           }

       }else{
           return response()->json(['status'=>'ERROR 500']);
       }

    }

    public function saveTdsInformation(Request $request){

        $user_id = Auth::user()->user_id;
        DB::setDateFormat('DD-MON-RR');
        $tds_data = $request->tds_data;
        $tds_data['CREATE_USER']= Auth::user()->user_id;

        //successors table data
        $successors_data['CREATE_USER']= Auth::user()->user_id;
        $successors_ids = $request->successors_id;
        $emp_designation = $request->emp_designation;
        $emp_name = $request->emp_name;
        $successors_readiness = $request->successors_readiness;
        $successors_serial_no = $request->serial_no;
        $tds_status = DB::table('MIS.TDS_TALENT_DEVELOPMENT_INFO')->insert($tds_data);


        if($tds_status){
            if(!empty($successors_ids)){
                for($i=0;$i<sizeof($successors_ids);$i++){
                    $successors_data['SUCCESSOR_ID']= $successors_ids[$i];
                    $successors_data['EMPLOYEE_ID']= $request->tds_data['employee_id'];
                    $successors_data['SUCCESSOR_READINESS']= $successors_readiness[$i];
                    $successors_data['EMP_DESIGNATION']= $emp_designation[$i];
                    $successors_data['EMP_NAME']= $emp_name[$i];
                    $successors_data['MANAGER_ID']= $user_id;
                    $successors_data['SERIAL_NO']= $successors_serial_no[$i];
                    $successors_status = DB::table('MIS.TDS_TALENT_DEVELOPMENT_SUCCESS')->insert($successors_data);
                }

                if($successors_status){
                    return response()->json(['status' => 'SAVED']);
                }else{
                    return response()->json(['status'=>'ERROR 500']);
                }
            }else{
                return response()->json(['status'=>'SAVED']);
            }

        }else{
            return response()->json(['status'=>'ERROR 500']);
        }

    }

    /**
     * @param $imp_info
     * @return mixed
     * Get Full Page PDF
     */
    public function employeeInfopdf($imp_info){

        $uid = $imp_info;
        $emp_his_info = DB::select("select get_emp_desig('$uid') desig_name,a.*,b.*
        from
        (select * from mis.EMP_HIS_INFO where emp_id  = ? ) a, 
        (select * from mis.EMP_HIS_MOREINFO where emp_id  = ? ) b
        where a.emp_id = b.emp_id ", [$uid, $uid]);
        //dd($emp_his_info);

        $emp_his_moreinfoid = DB::select("select * from mis.EMP_HIS_MOREINFO where emp_id  = ? ", [$uid]);
        $emp_his_emplment_old = DB::select("select * from mis.EMP_HIS_EMPLOYEEMENT where emp_id  = ? order by emplo_from desc ", [$uid]);
        $emp_his_job_last = DB::select("select * from( select * from mis.emp_his_employeement where emp_id  = ? and upper(emplo_comp_name) not like Upper('%INCEPTA%') order by emplo_from desc) where rownum=1", [$uid]);
        $emp_his_language = DB::select("select * from mis.EMP_HIS_LANGUAGE where emp_id  = ? order by sl asc", [$uid]);


        $head_dtl = DB::select("select get_emp_name(head_of_dept) head_name, get_emp_desig(head_of_dept) head_desig, get_emp_joining(head_of_dept) joining from mis.leave_emp_info where emp_id = '$uid'");

        $emp_his_edu_old = DB::select("select * from mis.EMP_HIS_EDUCATION eie,MIS.EDU_DEGREE ed where emp_id  = ? and EIE.EDU_DESIG_NAME = ED.DEG_ID order by ED.PRECEDENCE desc ", [$uid]);
        $edu_all_board = DB::select("SELECT B.BOARD_ID, B.BOARD_NAME FROM MIS.EDU_BOARD B");
        $edu_all_grp = DB::select("SELECT * FROM MIS.EDU_GROUP B");
        $edu_all_degree = DB::select("SELECT * FROM MIS.EDU_DEGREE B");

        $emp_his_pro_quali = DB::select("select * from mis.EMP_HIS_PRO_EQUALI where emp_id  = ? ", [$uid]);

       //second page
        $tds_dev_info = DB::select("select * from MIS.TDS_TALENT_DEVELOPMENT_INFO

             where employee_id  = ? ", [$uid]);


        $tds_dev_success = DB::select("select * from MIS.TDS_TALENT_DEVELOPMENT_SUCCESS

             where employee_id  = ? ", [$uid]);


        $pdf = \PDF::loadView('talent_development.reports.tds_form_pdf',
            compact('emp_his_info', 'head_dtl', 'emp_his_moreinfoid', 'emp_his_edu_old',
                'edu_all_degree', 'edu_all_board', 'edu_all_grp', 'emp_his_emplment_old',
                'emp_his_job_last', 'emp_his_language', 'emp_his_pro_quali','tds_dev_info','tds_dev_success')
        )->setPaper('a4', 'landscape');

        $date = date('Y-m-d');
        $t=time();

        $path = public_path('TalentDevelopment/');
        $fileName =  $uid . '_'. $date . '_' .$t. '.'.'pdf' ;

        $pdf->save($path . '/' . $fileName);


        //send mail
        $u_id = Auth::user()->user_id;
        $user_email=   DB::select("select MAIL_ADDRESS from MIS.LEAVE_EMP_INFO where EMP_ID='$uid'");
        $user_email = $user_email[0]->mail_address;
        $user_email = 'abc@gmail.com';
        $supervisor_email ='masroor@inceptapharma.com';


        /*Get User name dept desig*/
        $user_info = DB::select("SELECT DISTINCT dpt.dept_name,dgi.desig_name,imf.SUR_NAME,imf.JOINING_DATE FROM hrms.emp_information@WEB_TO_HRMS imf
                                                                  ,hrms.EMP_DESIGNATION@WEB_TO_HRMS dgi,hrms.DEPT_INFORMATION@WEB_TO_HRMS dpt where  
                                                                dgi.DESIG_ID = imf.DESIG_ID and dpt.DEPT_ID = imf.DEPT_ID  and imf.EMP_ID='$u_id' ");

        $user_name =$user_info[0]->sur_name;
        $user_designation =$user_info[0]->desig_name;
        $user_dept =$user_info[0]->dept_name;



        try {
            $user_email = $user_email;

            $to_mail = array();
            array_push($to_mail,$supervisor_email);

            $data = array(
                'user_name' => $user_name,
                'user_designation' => $user_designation,
                'emp_id' => $u_id,
                'user_dept' => $user_dept,
            );
            $path = public_path('TalentDevelopment/');

            Mail::send(['text' => 'talent_development/mail'], $data,  function ($message) use($path,$fileName,$to_mail,$user_name,$user_email,$user_dept) {
                $message->to($to_mail)->subject('Talent Development User Info Updated');
                $message->from($user_email);
                // $message->attach(storage_path('/donation/summary_report.pdf'));


                $message->attach(public_path('TalentDevelopment/'.$fileName));
            });

            return $pdf->stream($fileName);

           // return response()->json("success");

        }

        //catch exception
        catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }


    }


    /**
     * TDS HR form
     */
    public function tds_hr_form(Request $request = null, $empId  = null){

        $empId = $request->emp_id;
        $empListt = 'dfdgfhgfhg';

        if (!empty($empId)) {
            $emp_his_info = DB::select("select get_emp_desig('$empId') desig_name,a.*,b.*
            from
            (select * from mis.EMP_HIS_INFO where emp_id  = ? ) a, 
            (select * from mis.EMP_HIS_MOREINFO where emp_id  = ? ) b
            where a.emp_id = b.emp_id ", [$empId, $empId]);


            return view('talent_development/tds_hr_form');
        }else{
            $empList = DB::select("select distinct EMPLOYEE_ID from MIS.TDS_TALENT_DEVELOPMENT_INFO");
            return view('talent_development/tds_hr_form', compact('empList'));
        }

    }

    public function convert_object_to_array($data) {

        if (is_object($data)) {
            $data = get_object_vars($data);
        }

        if (is_array($data)) {
            return array_map(__FUNCTION__, $data);
        }
        else {
            return $data;
        }
    }

    public function send_email_to_manager(Request $request){

        $emp_id = $request->emp_id;

        $hod_id = DB::select("select HEAD_OF_DEPT from MIS.LEAVE_EMP_INFO where EMP_ID='$emp_id'");
        $hod_id = $hod_id[0]->head_of_dept;

        $hod_email=   DB::select("select MAIL_ADDRESS from MIS.LEAVE_EMP_INFO where EMP_ID='$hod_id'");
        $hod_email = $hod_email[0]->mail_address;

        $supervisor_id = DB::select("select HEAD_OF_DEPT from MIS.LEAVE_EMP_INFO where EMP_ID='$emp_id'");
        $supervisor_id = $supervisor_id[0]->head_of_dept;

        $supervisor_email=   DB::select("select MAIL_ADDRESS from MIS.LEAVE_EMP_INFO where EMP_ID='$supervisor_id'");
        $supervisor_email = $supervisor_email[0]->mail_address;

        $user_email=   DB::select("select MAIL_ADDRESS from MIS.LEAVE_EMP_INFO where EMP_ID='$request->emp_id'");
        $user_email = $user_email[0]->mail_address;

        $user_info=   DB::select("select SUR_NAME from MIS.EMP_HIS_INFO where EMP_ID='$request->emp_id'");
        $user_name = $user_info[0]->sur_name;


        $user_desig=   DB::select("select EMPLO_DESIG from MIS.EMP_HIS_EMPLOYEEMENT where EMP_ID='$request->emp_id'");
        $user_designation = $user_desig[0]->emplo_desig;

        $user_dept =   DB::select("select DEPARTMENT from MIS.EMP_HIS_EMPLOYEEMENT where EMP_ID='$request->emp_id'");
        $user_dept = $user_dept[0]->department;



        try {

            $to_mail = array();
            $to_mail[]=  $hod_email;
            $to_mail[]=  $supervisor_email;

            //$user_email = 'sayla@gmail.com.com';
            $data = array(
                'user_name' => $user_name,
                'user_designation' => $user_designation,
                'emp_id' => $emp_id,
                'user_dept' => $user_dept,
            );

            Mail::send(['text' => 'talent_development/mail'], $data,  function ($message) use($to_mail,$user_name,$user_email,$user_dept) {
                $message->to($to_mail)->subject('Talent Development User Info Updated');
                $message->from($user_email);

            });

            return response()->json("success");

        }

        //catch exception
        catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }

    }

    public function send_finish_email(Request $request){

        $uid = Auth::user()->user_id;
        $user_email=   DB::select("select MAIL_ADDRESS from MIS.LEAVE_EMP_INFO where EMP_ID='$uid'");
        $user_email = $user_email[0]->mail_address;
        $user_email = 'abc@gmail.com';
        $supervisor_email ='sayla@inceptapharma.com';


        $user_name ="sayla";
        $user_designation='software engineer';
        $user_dept ='it';

        $date = date('Y-m-d');
        $fileName =  $uid . '_'. $date . '.'.'pdf' ;



        try {
            $user_email = $user_email;

            $to_mail = array();
            array_push($to_mail,$supervisor_email);


            $data = array(
                'user_name' => $user_name,
                'user_designation' => $user_designation,
                'emp_id' => $uid,
                'user_dept' => $user_dept,
            );
            $path = public_path('pdf/');

            Mail::send(['text' => 'talent_development/mail'], $data,  function ($message) use($path,$fileName,$to_mail,$user_name,$user_email,$user_dept) {
                            $message->to($to_mail)->subject('Talent Development User Info Updated');
                            $message->from($user_email);
               // $message->attach(storage_path('/donation/summary_report.pdf'));


                $message->attach(public_path('pdf/'.$fileName));
            });

            return response()->json("success");

        }

            //catch exception
        catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }

    }


}
















