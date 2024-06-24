<?php

namespace App\Http\Controllers\Attendence;

use Carbon\Carbon;
use http\Client\Curl\User;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use App\Mail\OrderShipped;



use Prophecy\Exception\Doubler\InterfaceNotFoundException;


class AttendenceMngController extends Controller
{
    public function viewAttendence(){

        $allEmp = DB::select("select distinct emp_id,sur_name from hrms.emp_information@WEB_TO_HRMS where valid='YES' order by emp_id desc");

        $empWork = DB::select("select distinct emp_id,emp_name from mis.EMP_OTHERS_WORK_HISTORY_EXT
                            order by emp_id");
        return view('Attendence.attendence', ['allEmp' => $allEmp,'empWork'=>$empWork]);

    }

    public function getEmpInfo(Request $request){
        $emp_id = $request->employee_id;

        $allEmpData = DB::select("SELECT DISTINCT desig_name,dgi.DESIG_ID,imf.EMP_ID,imf.EMP_TYPE,imf.SECTION_ID,imf.SUR_NAME,dpi.dept_id,dpi.dept_name,pi.plant_id,pi.plant_name,wci.WORK_CENTER_ID,wci.WORK_CENTER_ID,wci.WORK_CENTER_NAME FROM hrms.emp_information@WEB_TO_HRMS imf,
       hrms.dept_information@WEB_TO_HRMS dpi, hrms.plant_info@WEB_TO_HRMS pi , hrms.EMP_DESIGNATION@WEB_TO_HRMS dgi , hrms.WORK_CENTER_INFORMATION@WEB_TO_HRMS wci  where imf.DEPT_ID = dpi.DEPT_ID  and  pi.plant_id = imf.plant_id 
       and  dgi.DESIG_ID = imf.DESIG_ID  and  wci.WORK_CENTER_ID = imf.WORK_CENTER_ID  and imf.EMP_ID='$emp_id'");

        return response()->json(
            ['allEmpData' => $allEmpData]
        );
    }

    public function saveAttendence(Request $request)
    {
        $uid = Auth::user()->user_id;
        $date = Carbon::now()->format('Y-m-d H:m:s');
        $dataList = json_decode($request->dataListObject, true);

        $dataList['create_user'] = $uid;
        $dataList['create_date'] = $date;


        $emp_id = $dataList['emp_id'];
        $emp_name = $dataList['emp_name'];
        $emp_deg = $dataList['emp_deg'];
        $emp_dpt = $dataList['emp_dpt'];
        $emp_sec = $dataList['emp_sec'];
        $wc = $dataList['wc'];
        $date_from = $dataList['date_from'];
        $date_to = $dataList['date_to'];
        $status = $dataList['status'];
        $reason_type = $dataList['reason_type'];
        $reason_by_emp = $dataList['REASON_OF_ABSENCE_BY_EMP'];
        $reason_acceptability = $dataList['reason_acceptability'];
        $emp_type = $dataList['emp_type'];

        /*Calculate Date*/
        $absence_days = $date_to - $date_from;
        $emp_dept_name=   DB::select("select DEPT_NAME from HRMS.DEPT_INFORMATION@WEB_TO_HRMS where DEPT_ID='$emp_dpt'");
        $emp_sec_name=   DB::select("select SECTION_NAME from HRMS.SECTION_INFORMATION@WEB_TO_HRMS where SECTION_ID='$emp_sec'");
        $dept = $emp_dept_name[0]->dept_name;
        $section = $emp_sec_name[0]->section_name;

        $saving_status = DB::table('MIS.EMP_OTHERS_WORK_HISTORY_EXT')->insert($dataList);

        if ($saving_status) {
            try {
                $user_email=   DB::select("select MAIL_ADDRESS from MIS.LEAVE_EMP_INFO where EMP_ID='$uid'");
                $user_email = $user_email[0]->mail_address;

                $user_info=   DB::select("select NAME from  MIS.DASHBOARD_USERS_INFO where USER_ID='$uid'");
                $user_name = $user_info[0]->name;

                //User Designation
                $user_desig=   DB::select("select DESIG from MIS.DASHBOARD_USERS_INFO  where USER_ID='$uid'");
                if(!empty($user_dept_id)){
                    $user_designation = $user_desig[0]->desig;
                }else{
                    $user_designation = '';
                }

                //User Dept
                $user_dept_id =   DB::select("select DEPT_ID from HRMS.EMP_INFORMATION@WEB_TO_HRMS where EMP_ID='$uid'");
                if(!empty($user_dept_id)){
                    $user_dept_id_val = $user_dept_id[0]->dept_id;
                    $user_dept =   DB::select("select DEPT_NAME from  HRMS.DEPT_INFORMATION@WEB_TO_HRMS where DEPT_ID='$user_dept_id_val'");
                    $user_dept = $user_dept[0]->dept_name;
                }


                $emp_sup_head=   DB::select("select REPORT_SUPERVISOR,HEAD_OF_DEPT from MIS.LEAVE_EMP_INFO where EMP_ID='$emp_id'");


                $emp_sup_head_mail=array();
                if(!empty($emp_sup_head)){
                    $emp_sup = $emp_sup_head[0]->report_supervisor;
                    $emp_dept_head = $emp_sup_head[0]->head_of_dept;

                    if($emp_dept_head){
                        $dept_head_mail =   DB::select("select mail_address from MIS.LEAVE_EMP_INFO where EMP_ID='$emp_dept_head'");
                        if($dept_head_mail){
                            $emp_sup_head_mail[] =$dept_head_mail[0]->mail_address;
                        }
                    }

                    if($emp_sup){
                        $sup_mail =   DB::select("select mail_address from MIS.LEAVE_EMP_INFO where EMP_ID='$emp_sup'");
                        if($sup_mail){
                            $emp_sup_head_mail[] =$sup_mail[0]->mail_address;
                        }
                    }
                }

                $emp_sup_head_mail[]=  "smnazmul@inceptapharma.com";
                $emp_sup_head_mail[]=   "ranzoo@inceptapharma.com";
                $emp_sup_head_mail[]=   "habiba@inceptapharma.com";


                $to_mail = array(
                    "shaon@inceptapharma.com",
                  //  "sayla@inceptapharma.com",
                );

                if($status=='Select Status'){
                    $status='';
                }

                if($reason_type=='Select Reason Type'){
                    $reason_type='';
                }

                if($reason_acceptability=='Select Acceptability'){
                    $reason_acceptability='';
                }


                $emp_name_val = explode('-', $emp_name);
                $emp_name_last = $emp_name_val[1];


                $data = array(
                    'emp_id' => $emp_id,
                    'emp_name' => $emp_name_last,
                    'emp_deg' => $emp_deg,
                    'emp_dept' => $dept,
                    'emp_sec' => $section,
                    'wc' => $wc,
                    'date_from' => $date_from,
                    'date_to' => $date_to,
                    'status' => $status,
                    'reason_type' => $reason_type,
                    'reason_by_emp' => $reason_by_emp,
                    'reason_acceptability' => $reason_acceptability,
                    'emp_type' => $emp_type,

                    'user_name' => $user_name,
                    'user_designation' => $user_designation,
                    'user_email' => $user_email,
                    'user_dept' => $user_dept,
                    'uid' => $uid,
                    'absence_days' => $absence_days,

                );


                Mail::to($to_mail)->cc($emp_sup_head_mail)->send(new OrderShipped($data));

                 // Mail::to($to_mail)->send(new OrderShipped($data));
                return response()->json(['result'=>'success']);
            }

            catch(Exception $e) {
                echo 'Message: ' .$e->getMessage();
            }


        } else {
            return response()->json(['result'=>'error']);

        }
    }

    /*Display Datatable*/
    public function getDisplayInfo(Request $request){
        $emp_id = $request->employee_code;
        $empData = DB::select("select  * from mis.EMP_OTHERS_WORK_HISTORY_EXT where emp_id = ? 
                   order by emp_id", [$emp_id]);

        return response()->json(
            ['empData' => $empData]
        );
    }

    /* Graphical interface start*/
    public function shiftTradeRequest(){

        $date  = date('m/d/Y',strtotime("-1 days"));

        $allEmpData = DB::select("select EMP_NAME,
                             SCEDULE_START_TIME,SCEDULE_END_TIME from HRMS.EMP_WORK_STATUS_FINAL@WEB_TO_HRMS 
       where working_date = to_date('$date','mm/dd/yyyy')");

        $allPlants = DB::select("SELECT DISTINCT PLANT_ID,PLANT_NAME FROM HRMS.PLANT_INFO@WEB_TO_HRMS WHERE COM_ID = 1 ORDER BY PLANT_ID");

        $department = DB::select("select distinct DEPT_ID,dept_name from hrms.dept_information@WEB_TO_HRMS where PLANT_ID='1000' order by dept_name ");

        $allPlant = DB::select("select distinct PLANT_ID,plant_name from hrms.PLANT_INFO@WEB_TO_HRMS  order by PLANT_ID");

        $allEmp = DB::select("select distinct EMP_ID,sur_name from hrms.EMP_INFORMATION@WEB_TO_HRMS  order by EMP_ID DESC");

        $allDesig = DB::select("select distinct DESIG_ID,DESIG_NAME from hrms.EMP_DESIGNATION@WEB_TO_HRMS  order by DESIG_ID");

        $work_center  = DB::select("select distinct WORK_CENTER_ID,WORK_CENTER_NAME from hrms.WORK_CENTER_INFORMATION@WEB_TO_HRMS  order by WORK_CENTER_ID");

        $companyData = DB::select("select distinct com_id,com_name from hrms.company_info@WEB_TO_HRMS order by com_id ");

        $empType = DB::select("select distinct emp_type from hrms.EMP_INFORMATION@WEB_TO_HRMS where emp_type!='NULL' order by emp_type");

        return view('Attendence.ShiftTradeRequest', ['depts' => $department,'allPlant' => $allPlant,'allEmp' => $allEmp,
            'allDesig' => $allDesig,'companyData' => $companyData,'workCenter' => $work_center,'empType' => $empType]);
    }


    public function getPlants(Request $request)
    {
        $co_id = $request->c_id;
        $allPlants = DB::select("select distinct plant_id,plant_name from hrms.plant_info@WEB_TO_HRMS where com_id = ? 
                   order by plant_id", [$co_id]);

        return response()->json(
            ['plant' => $allPlants]
        );
    }

    public function getDepts(Request $request)
    {
        $plant_id = $request->plant_id;
        $dept = DB::select("select distinct dept_id,dept_name from hrms.dept_information@WEB_TO_HRMS where plant_id=?", [$plant_id]);
        return response()->json(
            ['dept' => $dept]
        );
    }

    public function getSections(Request $request)
    {
        $dept_id = $request->dept_id;
        $section = DB::select("select distinct ei.plant_id,ei.dept_id,ei.section_id,si.section_name from hrms.emp_information@WEB_TO_HRMS
        ei,hrms.section_information@WEB_TO_HRMS si where ei.dept_id='$dept_id' and  ei.section_id = si.section_id
        ");

        return response()->json(
            ['sections' => $section]
        );

    }

    public function getWorkCenters(Request $request){

        $sec_id = $request->sec_id;
        $plant_id = $request->plant_id;
        $dept_id = $request->dept_id;

        if($sec_id=='all'){
            $sec_id='ALL';
        }

        $work_center = DB::select("select WORK_CENTER_ID,WORK_CENTER_NAME
                from(
                select 'ALL' all_data,WORK_CENTER_ID,WORK_CENTER_NAME,SECTION_ID
                from  hrms.WORK_CENTER_INFORMATION@WEB_TO_HRMS  
                
                where  PLANT_ID= '$request->plant_id'
                and  DEPT_ID= '$request->dept_id'
                  
                ) 
                where '$sec_id'= case when '$sec_id' = 'ALL' then all_data else to_char(SECTION_ID) end
        
         ");


        return response()->json(
            ['workCenter' => $work_center]
        );
    }

    public function getEmpType(Request $request){

        $wc_id = $request->wc_id;
        $sec_id = $request->sec_id;
        $dept_id = $request->dept_id;

        $empType = DB::select("
    
                    Select DISTINCT EMP_TYPE from (select DISTINCT EMP_TYPE,WORK_CENTER_ID from(
                        select DISTINCT EMP_TYPE,section_id,WORK_CENTER_ID
                        from  hrms.emp_information@WEB_TO_HRMS  
                        where dept_id ='$dept_id'
                        and  section_id= decode ('$sec_id','ALL',section_id,'$sec_id') AND EMP_TYPE!='NULL'                       
                      )  where  WORK_CENTER_ID= decode ('$wc_id','ALL',WORK_CENTER_ID,'$wc_id') )
              

         ");

        return response()->json(
            ['emp_type' => $empType]
        );
    }

    public function getEmployee(Request $request){

        $wc_id = $request->wc_id;
        $sec_id = $request->sec_id;
        $dept_id = $request->dept_id;
        $emp_type = $request->type;

        $emp = DB::select("
                    Select DISTINCT emp_id,sur_name from (
                    Select DISTINCT emp_id,sur_name,WORK_CENTER_ID from (select DISTINCT emp_id,sur_name,WORK_CENTER_ID,EMP_TYPE from(
                        select DISTINCT EMP_TYPE,emp_id,sur_name,WORK_CENTER_ID
                        from  hrms.emp_information@WEB_TO_HRMS  
                        where dept_id ='$dept_id'
                        and  section_id= decode ('$sec_id','ALL',section_id,'$sec_id')                             
                      ) where  WORK_CENTER_ID= decode ('$wc_id','ALL',WORK_CENTER_ID,'$wc_id') 
                )where  EMP_TYPE= decode ('$emp_type','ALL',EMP_TYPE,'$emp_type') )
         ");
        return response()->json(
            ['emp' => $emp]
        );

    }

    public function getEmployeeData(Request $request)
    {
        $sec_id = $request->sec_id;

        $EmpData = DB::select("select emp_id,sur_name from hrms.emp_information@WEB_TO_HRMS 
                   WHERE SECTION_ID='$sec_id' ");

        $work_center = DB::select("select WORK_CENTER_ID,WORK_CENTER_NAME from hrms.WORK_CENTER_INFORMATION@WEB_TO_HRMS 
                   WHERE SECTION_ID='$sec_id' ");

        return response()->json(
            ['emp' => $EmpData,'work_center' => $work_center]
        );
    }

    /*Draw main graph*/
    public function getAlldata(){

        $dateOne=date('m/d/Y',strtotime("-1 days"));

        /* $allEmp = DB::select("select EMP_NAME,PLANT_ID,emp_id,
                            SCEDULE_START_TIME,SCEDULE_END_TIME,default_status from HRMS.EMP_WORK_STATUS_FINAL@WEB_TO_HRMS
        where valid='YES' and working_date = to_date('$dateOne','mm/dd/yyyy')");*/

        $allEmp = DB::select("select emf.EMP_NAME,emf.PLANT_ID,emf.emp_id,
                             emf.SCEDULE_START_TIME,emf.SCEDULE_END_TIME,emf.default_status,ed.DESIG_NAME from HRMS.EMP_WORK_STATUS_FINAL@WEB_TO_HRMS  emf, HRMS.EMP_DESIGNATION@WEB_TO_HRMS  ed
       where emf.DESIG_ID =ed.DESIG_ID and  emf.valid='YES' and emf.working_date = to_date('$dateOne','mm/dd/yyyy')");


        /*  $empEarlyOut = DB::select("select EMP_NAME,PLANT_ID,emp_id,first_in_time,last_out_time,
                               SCEDULE_START_TIME,SCEDULE_END_TIME,default_status from HRMS.EMP_WORK_STATUS_FINAL@WEB_TO_HRMS
         where valid='YES' and working_status='EARLY OUT'  and working_date = to_date('$dateOne','mm/dd/yyyy')");*/


        $empEarlyOut = DB::select("select emf.EMP_NAME,emf.PLANT_ID,emf.emp_id,emf.first_in_time,emf.last_out_time,
                             emf.SCEDULE_START_TIME,emf.SCEDULE_END_TIME,emf.default_status, ed.DESIG_NAME  from HRMS.EMP_WORK_STATUS_FINAL@WEB_TO_HRMS  emf, HRMS.EMP_DESIGNATION@WEB_TO_HRMS  ed
       where emf.DESIG_ID =ed.DESIG_ID and  emf.valid='YES' and emf.working_date = to_date('$dateOne','mm/dd/yyyy') ");



        $empLateIn = DB::select("select emf.EMP_NAME,emf.PLANT_ID,emf.emp_id,emf.first_in_time,emf.last_out_time,
                             emf.SCEDULE_START_TIME,emf.SCEDULE_END_TIME,emf.default_status, ed.DESIG_NAME  from HRMS.EMP_WORK_STATUS_FINAL@WEB_TO_HRMS  emf, HRMS.EMP_DESIGNATION@WEB_TO_HRMS  ed
       where emf.DESIG_ID =ed.DESIG_ID and  emf.valid='YES' and emf.working_date = to_date('$dateOne','mm/dd/yyyy') ");


        $empLaunchTime = DB::select("select TIME_START,PLANT_ID,
                             TIME_END from HRMS.MEAL_TIME_ALL@WEB_TO_HRMS 
       where MEAL_TYPE='LUNCH' order by PLANT_ID");


        $empSnacksTime = DB::select("select TIME_START,PLANT_ID,
                             TIME_END from HRMS.MEAL_TIME_ALL@WEB_TO_HRMS 
       where MEAL_TYPE='SNACKS' order by PLANT_ID");

        $empOverTime = DB::select("select OVERTIME_START_TIME,EMP_NAME,OVERTIME_END_TIME,PLANT_ID,emp_id,default_status 
        from HRMS.EMP_OVERTIME_STATUS_FINAL@WEB_TO_HRMS where valid='YES' and working_date = to_date('$dateOne','mm/dd/yyyy')");

        /*All emp details*/
        $allEmpDetails = array();
        for ($i=0;$i<10;$i++) {

            $emp_desig = $allEmp[$i]->desig_name;
            $desig_short = explode(',', $emp_desig);

            $temp['category'] = $allEmp[$i]->emp_name.'/'.$allEmp[$i]->emp_id.'/'.$desig_short[0];

            if($allEmp[$i]->default_status=='PRESENT'){
                $temp['columnSettings']['fill'] = '#8FBE69';
            }else if($allEmp[$i]->default_status=='OSD'){
                $temp['columnSettings']['fill'] = '#EA9D3A';
            }else if($allEmp[$i]->default_status=='LEAVE'){
                $temp['columnSettings']['fill'] = '#AEF05F';
            }else if($allEmp[$i]->default_status=='HOLIDAY'){
                $temp['columnSettings']['fill'] = '#3AC2EA';
            }else if($allEmp[$i]->default_status=='ABSENT'){
                $temp['columnSettings']['fill'] = '#DC3E28';
            }
            $temp['fromDate']  = substr($allEmp[$i]->scedule_start_time,0,-3);
            $temp['toDate']  = substr($allEmp[$i]->scedule_end_time,0,-3);
            array_push($allEmpDetails, $temp);
        }

        Log::info("emp sayla");
        Log::info(count($allEmpDetails));





        /*Late iIn Count*/
        $tempLateIn = array();
        for ($i=0;$i<10;$i++) {

            $emp_desig = $empLateIn[$i]->desig_name;
            $desig_short = explode(',', $emp_desig);

            $tempLateIn['category'] = $empLateIn[$i]->emp_name.'/'.$empLateIn[$i]->emp_id.'/'.$desig_short[0];

            if($empLateIn[$i]->default_status=='PRESENT'){
                $tempLateIn['columnSettings']['fill'] = '#1B4897';
            }else if($empLateIn[$i]->default_status=='OSD'){
                $tempLateIn['columnSettings']['fill'] = '#EA9D3A';
            }else if($empLateIn[$i]->default_status=='LEAVE'){
                $tempLateIn['columnSettings']['fill'] = '#AEF05F';
            }else if($empLateIn[$i]->default_status=='HOLIDAY'){
                $tempLateIn['columnSettings']['fill'] = '#3AC2EA';
            }else if($empLateIn[$i]->default_status=='ABSENT'){
                $tempLateIn['columnSettings']['fill'] = '#DC3E28';
            }

            $tempLateIn['fromDate']  = substr($empLateIn[$i]->scedule_start_time,0,-3);
            $tempLateIn['toDate']  = substr($empLateIn[$i]->first_in_time,0,-3);
            array_push($allEmpDetails, $tempLateIn);
        }


        /*Late Early Out Count*/
        $tempEarlyOut = array();
        for ($i=0;$i<10;$i++) {

            $emp_desig = $empEarlyOut[$i]->desig_name;
            $desig_short = explode(',', $emp_desig);

            $tempEarlyOut['category'] = $empEarlyOut[$i]->emp_name.'/'.$empEarlyOut[$i]->emp_id.'/'.$desig_short[0];

            if($empEarlyOut[$i]->default_status=='PRESENT'){
                $tempEarlyOut['columnSettings']['fill'] = '#721AAB';
            }else if($empEarlyOut[$i]->default_status=='OSD'){
                $tempEarlyOut['columnSettings']['fill'] = '#EA9D3A';
            }else if($empEarlyOut[$i]->default_status=='LEAVE'){
                $tempEarlyOut['columnSettings']['fill'] = '#AEF05F';
            }else if($empEarlyOut[$i]->default_status=='HOLIDAY'){
                $tempEarlyOut['columnSettings']['fill'] = '#3AC2EA';
            }else if($empEarlyOut[$i]->default_status=='ABSENT'){

                $tempEarlyOut['columnSettings']['fill'] = '#DC3E28';
            }


            $tempEarlyOut['fromDate']  = substr($empEarlyOut[$i]->last_out_time,0,-3);
            $tempEarlyOut['toDate']  = substr($empEarlyOut[$i]->scedule_end_time,0,-3);

            array_push($allEmpDetails, $tempEarlyOut);
        }



        /* employee Snacks details*/
        for ($i=0;$i<10;$i++) {
            foreach ($empSnacksTime as $empSnacksTimeS) {
                $emp_desig = $allEmp[$i]->desig_name;
                $desig_short = explode(',', $emp_desig);

                $tempSnacks['category'] = $allEmp[$i]->emp_name.'/'.$allEmp[$i]->emp_id.'/'.$desig_short[0];


                if($allEmp[$i]->default_status=='PRESENT'){
                    $tempSnacks['columnSettings']['fill'] = '#F48A9F';
                }else if($allEmp[$i]->default_status=='OSD'){
                    $tempSnacks['columnSettings']['fill'] = '#EA9D3A';
                }else if($allEmp[$i]->default_status=='LEAVE'){
                    $tempSnacks['columnSettings']['fill'] = '#AEF05F';
                }else if($allEmp[$i]->default_status=='HOLIDAY'){
                    $tempSnacks['columnSettings']['fill'] = '#3AC2EA';
                }else if($allEmp[$i]->default_status=='ABSENT'){
                    $tempSnacks['columnSettings']['fill'] = '#DC3E28';
                }

                if ($allEmp[$i]->plant_id == $empSnacksTimeS->plant_id ) {

                    $date_time_split = explode(' ', $allEmp[0]->scedule_start_time);
                    $date['date'] = $date_time_split[0];

                    $time_start_split = explode(' ', $empSnacksTimeS->time_start);
                    $time_start['time'] = $time_start_split[1];


                    $time_end_split = explode(' ', $empSnacksTimeS->time_end);
                    $time_end['time'] = $time_end_split[1];

                    $startDTSnacks = date('Y-m-d H:i:s', strtotime(  $date['date']." ".$time_start['time']));
                    $endDTSnacks = date('Y-m-d H:i:s', strtotime(  $date['date']." ".$time_end['time']));

                    $tempSnacks['fromDate']  = substr($startDTSnacks,0,-3);
                    $tempSnacks['toDate']  = substr($endDTSnacks,0,-3);

                    break;
                }

            }
            array_push($allEmpDetails,$tempSnacks);
        }
        $allEmpDetailsJson = json_encode($allEmpDetails);





        /* employee lunch details*/
        for ($i=0;$i<10;$i++) {
            foreach ($empLaunchTime as $launchTimnes) {

                $emp_desig = $allEmp[$i]->desig_name;
                $desig_short = explode(',', $emp_desig);

                $tempLaunch['category'] = $allEmp[$i]->emp_name.'/'.$allEmp[$i]->emp_id.'/'.$desig_short[0];

                if($allEmp[$i]->default_status=='PRESENT'){
                    $tempLaunch['columnSettings']['fill'] = '#ECE77E';
                }else if($allEmp[$i]->default_status=='OSD'){
                    $tempLaunch['columnSettings']['fill'] = '#EA9D3A';
                }else if($allEmp[$i]->default_status=='LEAVE'){
                    $tempLaunch['columnSettings']['fill'] = '#AEF05F';
                }else if($allEmp[$i]->default_status=='HOLIDAY'){
                    $tempLaunch['columnSettings']['fill'] = '#3AC2EA';
                }else if($allEmp[$i]->default_status=='ABSENT'){
                    $tempLaunch['columnSettings']['fill'] = '#DC3E28';
                }


                if ($allEmp[$i]->plant_id == $launchTimnes->plant_id ) {

                    $date_time_split = explode(' ', $allEmp[0]->scedule_start_time);
                    $date['date'] = $date_time_split[0];

                    $time_start_split = explode(' ', $launchTimnes->time_start);
                    $time_start['time'] = $time_start_split[1];


                    $time_end_split = explode(' ', $launchTimnes->time_end);
                    $time_end['time'] = $time_end_split[1];

                    $startDT = date('Y-m-d H:i:s', strtotime(  $date['date']." ".$time_start['time']));
                    $endDT = date('Y-m-d H:i:s', strtotime(  $date['date']." ".$time_end['time']));


                    $tempLaunch['fromDate']  = substr($startDT,0,-3);
                    $tempLaunch['toDate']  = substr($endDT,0,-3);


                    break;
                }

            }
            array_push($allEmpDetails,$tempLaunch);
        }





        /* employee overtime details*/
        $testArray = array();
        $tempOverTime = array();
        for ($i=0;$i<10;$i++) {
            foreach ($empOverTime as $empOverTimes) {

                if($empOverTimes->emp_id==$allEmp[$i]->emp_id){

                    $emp_desig = $allEmp[$i]->desig_name;
                    $desig_short = explode(',', $emp_desig);

                    $tempOverTime['category'] = $allEmp[$i]->emp_name.'/'.$allEmp[$i]->emp_id.'/'.$desig_short[0];

                    $tempOverTime['fromDate']  = substr($empOverTimes->overtime_start_time,0,-3);
                    $tempOverTime['toDate']  = substr($empOverTimes->overtime_end_time,0,-3);

                    if($empOverTimes->default_status=='PRESENT'){
                        $tempOverTime['columnSettings']['fill'] = '#D473E8';
                    }else if($empOverTimes->default_status=='OSD'){
                        $tempOverTime['columnSettings']['fill'] = '#EA9D3A';
                    }else if($empOverTimes->default_status=='LEAVE'){
                        $tempOverTime['columnSettings']['fill'] = '#AEF05F';
                    }else if($empOverTimes->default_status=='HOLIDAY'){
                        $tempOverTime['columnSettings']['fill'] = '#3AC2EA';
                    }else if($empOverTimes->default_status=='ABSENT'){
                        $tempOverTime['columnSettings']['fill'] = '#DC3E28';
                    }

                    array_push($allEmpDetails,$tempOverTime);
                    break;
                }
            }
        }



        $allEmpDetailsJson = json_encode($allEmpDetails);
        /* all employee name records*/
        $countTwo= 0;
        $empName = array();
        for ($i=0;$i<10;$i++){
            $emp_desig = $allEmp[$i]->desig_name;
            $desig_short = explode(',', $emp_desig);

            $tempTwo['category']  = $allEmp[$i]->emp_name.'/'.$allEmp[$i]->emp_id.'/'.$desig_short[0];
            array_push($empName, $tempTwo);

        }
        $empNameJson = json_encode($empName);

        log::info("emp name");
        Log::info(count($empName));

        Log::info("emp name detaisl");
        log:info(count($allEmpDetails));

        return response()->json(['allEmpJson'=>$allEmpDetailsJson,'allEmpNameJson'=>$empNameJson]);

    }

    /*Get Dept wise data*/
    public function getDataDeptWise(Request $request){

        $date_from  = Carbon::parse( $request->date_from)->format('Y-M-d');
        $date_to = Carbon::parse( $request->date_to)->format('Y-M-d');

        $plant_id = $request->plant_id;
        $dept_id = $request->dept_id;
        $sec_id = $request->sec_id;
        $wc_id = $request->wc_id;
        $type_id = $request->type_id;
        $emp_id = $request->emp_id;
        $absLate = $request->abs;

        if($sec_id == 'All'){
            $sec_id = 'ALL';
        }

        if($wc_id == 'All'){
            $wc_id = 'ALL';
        }

        if($type_id == 'All'){
            $type_id = 'ALL';
        }

        if($emp_id == 'All'){
            $emp_id = 'ALL';
        }

        /* All employee records*/
        $allEmp = DB::select("select DISTINCT EMP_NAME,EMP_id,SCEDULE_START_TIME,SCEDULE_END_TIME,plant_id,default_status,DESIG_NAME,EMP_TYPE from (
                                     
                            select DISTINCT EMP_NAME,EMP_id,SCEDULE_START_TIME,SCEDULE_END_TIME,plant_id,default_status,DESIG_NAME,EMP_TYPE from (
               
                        select DISTINCT EMP_NAME,EMP_TYPE,EMP_id,SCEDULE_START_TIME,SCEDULE_END_TIME,plant_id,DESIG_NAME,default_status from (
             
                    select  DISTINCT EMP_NAME,WORK_CENTER_ID,EMP_TYPE,section_id,EMP_id,SCEDULE_START_TIME,SCEDULE_END_TIME,plant_id,DESIG_NAME,default_status from (
            
                    select DISTINCT ew.EMP_NAME,ew.PLANT_ID,ew.emp_id,ew.section_id,em.WORK_CENTER_ID,ew.EMP_TYPE,ew.SCEDULE_START_TIME,ew.SCEDULE_END_TIME,ew.default_status,di.DESIG_NAME
                    from HRMS.EMP_WORK_STATUS_FINAL@WEB_TO_HRMS ew, hrms.emp_information@WEB_TO_HRMS em, hrms.EMP_DESIGNATION@WEB_TO_HRMS di
                    
                    where ew.PLANT_ID= em.PLANT_ID   
                    and ew.DEPT_ID= em.DEPT_ID 
                    and  ew.DESIG_ID= di.DESIG_ID  
                    and  ew.PLANT_ID='$plant_id'
                    and  ew.DEPT_ID= '$dept_id'
                    and ew.WORKING_DATE = '$date_from'
                    
                    and em.valid = 'YES' order by ew.emp_id
                    
                     )where  section_id =  decode ('$sec_id','ALL',section_id,'$sec_id') order by emp_id
                    
                    ) where  WORK_CENTER_ID = decode ('$wc_id','ALL',WORK_CENTER_ID,'$wc_id')
                    
                    ) where  EMP_TYPE = decode ('$type_id','ALL',EMP_TYPE,'$type_id') order by EMP_NAME
                                
                    )where  EMP_id = decode ('$emp_id','ALL',EMP_id,'$emp_id') order by EMP_id
            
         ");

        $empLaunchTime = DB::select("select TIME_START,PLANT_ID,
                              TIME_END from HRMS.MEAL_TIME_ALL@WEB_TO_HRMS  
      
        where  MEAL_TYPE='LUNCH'
        and PLANT_ID= decode('$request->plant_id','',PLANT_ID,'$request->plant_id')");

        $empSnacksTime = DB::select("select TIME_START,PLANT_ID,
                             TIME_END from HRMS.MEAL_TIME_ALL@WEB_TO_HRMS  
           where  MEAL_TYPE='SNACKS'
        and PLANT_ID= decode('$request->plant_id','',PLANT_ID,'$request->plant_id')");


        $empOverTime = DB::select("select DISTINCT OVERTIME_START_TIME,EMP_NAME,OVERTIME_END_TIME,PLANT_ID,emp_id,default_status,EMP_TYPE,DESIG_NAME from (
                                     
                            select DISTINCT OVERTIME_START_TIME,EMP_NAME,OVERTIME_END_TIME,PLANT_ID,emp_id,emp_type,default_status,DESIG_NAME from (
               
                        select DISTINCT OVERTIME_START_TIME,EMP_NAME,OVERTIME_END_TIME,PLANT_ID,emp_id,WORK_CENTER_ID,emp_type,default_status,DESIG_NAME from (
            
                    select  DISTINCT OVERTIME_START_TIME,EMP_NAME,OVERTIME_END_TIME,PLANT_ID,emp_id,WORK_CENTER_ID,emp_type,section_id,default_status,DESIG_NAME from (
                        
                    select DISTINCT ew.OVERTIME_START_TIME,ew.EMP_NAME,ew.OVERTIME_END_TIME,ew.PLANT_ID,ew.emp_id,em.WORK_CENTER_ID,ew.emp_type,em.section_id
                            ,ew.default_status,di.DESIG_NAME
                    from HRMS.EMP_OVERTIME_STATUS_FINAL@WEB_TO_HRMS ew, hrms.emp_information@WEB_TO_HRMS em, hrms.EMP_DESIGNATION@WEB_TO_HRMS di
                    
                    where ew.PLANT_ID= em.PLANT_ID   
                    and ew.DEPT_ID= em.DEPT_ID 
                    and  ew.DESIG_ID= di.DESIG_ID 
                    and  ew.PLANT_ID='$plant_id'
                    and  ew.DEPT_ID= '$dept_id'
                    and ew.WORKING_DATE = '$date_from'
                    and em.valid = 'YES' order by ew.emp_id
                    
                     )where  section_id =  decode ('$sec_id','ALL',section_id,'$sec_id') order by emp_id
                    
                    ) where  WORK_CENTER_ID = decode ('$wc_id','ALL',WORK_CENTER_ID,'$wc_id')
                    
                    ) where  EMP_TYPE = decode ('$type_id','ALL',EMP_TYPE,'$type_id') order by EMP_NAME
                                
                    )where  EMP_id = decode ('$emp_id','ALL',EMP_id,'$emp_id') order by EMP_id
            
         ");


        $empLateIn = DB::select("select DISTINCT EMP_NAME,EMP_id,SCEDULE_START_TIME,SCEDULE_END_TIME,plant_id,default_status,FIRST_IN_TIME,EMP_TYPE,DESIG_NAME from (
                                     
                            select DISTINCT EMP_NAME,EMP_id,SCEDULE_START_TIME,SCEDULE_END_TIME,plant_id,default_status,FIRST_IN_TIME,EMP_TYPE,DESIG_NAME from (
               
                        select DISTINCT EMP_NAME,EMP_TYPE,EMP_id,SCEDULE_START_TIME,SCEDULE_END_TIME,plant_id,default_status,FIRST_IN_TIME,DESIG_NAME from (
             
                    select  DISTINCT EMP_NAME,WORK_CENTER_ID,EMP_TYPE,section_id,EMP_id,SCEDULE_START_TIME,SCEDULE_END_TIME,plant_id,default_status,FIRST_IN_TIME,DESIG_NAME from (
                
                    select DISTINCT ew.EMP_NAME,ew.PLANT_ID,ew.emp_id,ew.section_id,em.WORK_CENTER_ID,ew.EMP_TYPE,ew.SCEDULE_START_TIME,ew.SCEDULE_END_TIME,
                                    ew.default_status,ew.FIRST_IN_TIME,di.DESIG_NAME
                    
                    from HRMS.EMP_WORK_STATUS_FINAL@WEB_TO_HRMS ew, hrms.emp_information@WEB_TO_HRMS em, hrms.EMP_DESIGNATION@WEB_TO_HRMS di
                   
                    where ew.PLANT_ID= em.PLANT_ID   
                    and ew.DEPT_ID= em.DEPT_ID 
                    and  ew.DESIG_ID= di.DESIG_ID 
                    and  ew.PLANT_ID='$plant_id'
                    and  ew.DEPT_ID= '$dept_id'
                    and ew.WORKING_DATE = '$date_from'
                  
                    and em.valid = 'YES' and WORKING_STATUS='LATE IN' order by ew.emp_id
                    
                     )where  section_id =  decode ('$sec_id','ALL',section_id,'$sec_id') order by emp_id
                    
                    ) where  WORK_CENTER_ID = decode ('$wc_id','ALL',WORK_CENTER_ID,'$wc_id')
                    
                    ) where  EMP_TYPE = decode ('$type_id','ALL',EMP_TYPE,'$type_id') order by EMP_NAME
                                
                    )where  EMP_id = decode ('$emp_id','ALL',EMP_id,'$emp_id') order by EMP_id
            
         ");



        $empAbsent = DB::select("select DISTINCT EMP_NAME,EMP_id,SCEDULE_START_TIME,SCEDULE_END_TIME,plant_id,default_status,FIRST_IN_TIME,EMP_TYPE,DESIG_NAME from (
                                     
                            select DISTINCT EMP_NAME,EMP_id,SCEDULE_START_TIME,SCEDULE_END_TIME,plant_id,default_status,FIRST_IN_TIME,EMP_TYPE,DESIG_NAME from (
               
                        select DISTINCT EMP_NAME,EMP_TYPE,EMP_id,SCEDULE_START_TIME,SCEDULE_END_TIME,plant_id,default_status,FIRST_IN_TIME,DESIG_NAME from (
             
                    select  DISTINCT EMP_NAME,WORK_CENTER_ID,EMP_TYPE,section_id,EMP_id,SCEDULE_START_TIME,SCEDULE_END_TIME,plant_id,default_status,FIRST_IN_TIME,DESIG_NAME from (
                
                    select DISTINCT ew.EMP_NAME,ew.PLANT_ID,ew.emp_id,ew.section_id,em.WORK_CENTER_ID,ew.EMP_TYPE,ew.SCEDULE_START_TIME,ew.SCEDULE_END_TIME,
                                    ew.default_status,ew.FIRST_IN_TIME,di.DESIG_NAME
                    
                    from HRMS.EMP_WORK_STATUS_FINAL@WEB_TO_HRMS ew, hrms.emp_information@WEB_TO_HRMS em, hrms.EMP_DESIGNATION@WEB_TO_HRMS di
                   
                    where ew.PLANT_ID= em.PLANT_ID   
                    and ew.DEPT_ID= em.DEPT_ID 
                    and  ew.DESIG_ID= di.DESIG_ID 
                    and  ew.PLANT_ID='$plant_id'
                    and  ew.DEPT_ID= '$dept_id'
                    and ew.WORKING_DATE = '$date_from'
                  
                    and em.valid = 'YES' and WORKING_STATUS='ABSENT' order by ew.emp_id
                    
                     )where  section_id =  decode ('$sec_id','ALL',section_id,'$sec_id') order by emp_id
                    
                    ) where  WORK_CENTER_ID = decode ('$wc_id','ALL',WORK_CENTER_ID,'$wc_id')
                    
                    ) where  EMP_TYPE = decode ('$type_id','ALL',EMP_TYPE,'$type_id') order by EMP_NAME
                                
                    )where  EMP_id = decode ('$emp_id','ALL',EMP_id,'$emp_id') order by EMP_id
            
         ");


        $empEarlyOut = DB::select("select DISTINCT EMP_NAME,EMP_id,SCEDULE_START_TIME,SCEDULE_END_TIME,plant_id,default_status,LAST_OUT_TIME,EMP_TYPE,DESIG_NAME from (
                                     
                            select DISTINCT EMP_NAME,EMP_id,SCEDULE_START_TIME,SCEDULE_END_TIME,plant_id,default_status,LAST_OUT_TIME,EMP_TYPE,DESIG_NAME from (
               
                        select DISTINCT EMP_NAME,EMP_TYPE,EMP_id,SCEDULE_START_TIME,SCEDULE_END_TIME,plant_id,default_status,LAST_OUT_TIME,DESIG_NAME from (
             
                    select  DISTINCT EMP_NAME,WORK_CENTER_ID,EMP_TYPE,section_id,EMP_id,SCEDULE_START_TIME,SCEDULE_END_TIME,plant_id,default_status,LAST_OUT_TIME,DESIG_NAME from (
                
                    select DISTINCT ew.EMP_NAME,ew.PLANT_ID,ew.emp_id,ew.section_id,em.WORK_CENTER_ID,ew.EMP_TYPE,ew.SCEDULE_START_TIME,ew.SCEDULE_END_TIME,
                                    ew.default_status,ew.LAST_OUT_TIME,di.DESIG_NAME
                    
                    from HRMS.EMP_WORK_STATUS_FINAL@WEB_TO_HRMS ew, hrms.emp_information@WEB_TO_HRMS em, hrms.EMP_DESIGNATION@WEB_TO_HRMS di
                    
                    where ew.PLANT_ID= em.PLANT_ID   
                    and ew.DEPT_ID= em.DEPT_ID 
                    and  ew.DESIG_ID= di.DESIG_ID 
                    and  ew.PLANT_ID='$plant_id'
                    and  ew.DEPT_ID= '$dept_id'
                    and ew.WORKING_DATE = '$date_from'

                    and em.valid = 'YES' and working_status='EARLY OUT' order by ew.emp_id
                    
                     )where  section_id =  decode ('$sec_id','ALL',section_id,'$sec_id') order by emp_id
                    
                    ) where  WORK_CENTER_ID = decode ('$wc_id','ALL',WORK_CENTER_ID,'$wc_id')
                    
                    ) where  EMP_TYPE = decode ('$type_id','ALL',EMP_TYPE,'$type_id') order by EMP_NAME
                                
                    )where  EMP_id = decode ('$emp_id','ALL',EMP_id,'$emp_id') order by EMP_id
            
         ");

        /* All employee records*/
        $empDetails = array();
        for ($i=0;$i<sizeof($allEmp);$i++) {

            $emp_desig = $allEmp[$i]->desig_name;
            $desig_short = explode(',', $emp_desig);

            $temp['category'] = $allEmp[$i]->emp_name.'/'.$allEmp[$i]->emp_id.'/'.$desig_short[0];

            if($allEmp[$i]->default_status=='PRESENT'){
                $temp['columnSettings']['fill'] = '#8FBE69';
            }else if($allEmp[$i]->default_status=='OSD'){
                $temp['columnSettings']['fill'] = '#EA9D3A';
            }else if($allEmp[$i]->default_status=='LEAVE'){
                $temp['columnSettings']['fill'] = '#AEF05F';
            }else if($allEmp[$i]->default_status=='HOLIDAY'){
                $temp['columnSettings']['fill'] = '#3AC2EA';
            }else if($allEmp[$i]->default_status=='ABSENT'){

                /* Is Informed Starts*/
                $u_id = $allEmp[$i]->emp_id;
                $emp_id= json_decode( json_encode($u_id), true);

                $isInformed = DB::select("select REASON_ACCEPTABILITY from MIS.EMP_OTHERS_WORK_HISTORY_EXT
                                 where emp_id='$emp_id' AND STATUS='Absent'");

                if(!empty($isInformed)){
                    if($isInformed[0]->reason_acceptability=='Acceptable'){
                        $temp['columnSettings']['fill'] = '#e9967a';

                    }else if($isInformed[0]->reason_acceptability=='Unacceptable'){
                        $temp['columnSettings']['fill'] = '#DC3E28';
                    }
                }else{
                    $temp['columnSettings']['fill'] = '#DC3E28';
                }
                /* Is Informed ends*/
            }

            $temp['fromDate']  = substr($allEmp[$i]->scedule_start_time,0,-3);
            $temp['toDate']  = substr($allEmp[$i]->scedule_end_time,0,-3);
            array_push($empDetails, $temp);
        }

        /*Late iIn Count*/
        $tempLateIn = array();
        for ($i=0;$i<sizeof($empLateIn);$i++) {

            $emp_desig = $empLateIn[$i]->desig_name;
            $desig_short = explode(',', $emp_desig);

            $tempLateIn['category'] = $empLateIn[$i]->emp_name.'/'.$empLateIn[$i]->emp_id.'/'.$desig_short[0];

            if($empLateIn[$i]->default_status=='PRESENT'){
                $tempLateIn['columnSettings']['fill'] = '#1B4897';
            }else if($empLateIn[$i]->default_status=='OSD'){
                $tempLateIn['columnSettings']['fill'] = '#EA9D3A';
            }else if($empLateIn[$i]->default_status=='LEAVE'){
                $tempLateIn['columnSettings']['fill'] = '#AEF05F';
            }else if($empLateIn[$i]->default_status=='HOLIDAY'){
                $tempLateIn['columnSettings']['fill'] = '#3AC2EA';
            }else if($empLateIn[$i]->default_status=='ABSENT'){
                /* Is Informed Starts*/
                $u_id = $allEmp[$i]->emp_id;
                $emp_id= json_decode( json_encode($u_id), true);
                $isInformed = DB::select("select REASON_ACCEPTABILITY from MIS.EMP_OTHERS_WORK_HISTORY_EXT
                                 where emp_id='$emp_id' AND STATUS='Absent'");
                if(!empty($isInformed)){
                    if($isInformed[0]->reason_acceptability=='Acceptable'){
                        $empLateIn['columnSettings']['fill'] = '#e9967a';

                    }else if($isInformed[0]->reason_acceptability=='Unacceptable'){
                        $empLateIn['columnSettings']['fill'] = '#DC3E28';
                    }
                }else{
                    $empLateIn['columnSettings']['fill'] = '#DC3E28';
                }
                /* Is Informed ends*/
            }

            $tempLateIn['fromDate']  = substr($empLateIn[$i]->scedule_start_time,0,-3);
            $tempLateIn['toDate']  = substr($empLateIn[$i]->first_in_time,0,-3);
            array_push($empDetails, $tempLateIn);
        }


        /*Late Early Out Count*/
        $tempEarlyOut = array();
        for ($i=0;$i<sizeof($empEarlyOut);$i++) {

            $emp_desig = $empEarlyOut[$i]->desig_name;
            $desig_short = explode(',', $emp_desig);

            $tempEarlyOut['category'] = $empEarlyOut[$i]->emp_name.'/'.$empEarlyOut[$i]->emp_id.'/'.$desig_short[0];

            if($empEarlyOut[$i]->default_status=='PRESENT'){
                $tempEarlyOut['columnSettings']['fill'] = '#721AAB';
            }else if($empEarlyOut[$i]->default_status=='OSD'){
                $tempEarlyOut['columnSettings']['fill'] = '#EA9D3A';
            }else if($empEarlyOut[$i]->default_status=='LEAVE'){
                $tempEarlyOut['columnSettings']['fill'] = '#AEF05F';
            }else if($empEarlyOut[$i]->default_status=='HOLIDAY'){
                $tempEarlyOut['columnSettings']['fill'] = '#3AC2EA';
            }else if($empEarlyOut[$i]->default_status=='ABSENT'){

                /* Is Informed Starts*/
                $u_id = $allEmp[$i]->emp_id;
                $emp_id= json_decode( json_encode($u_id), true);

                $isInformed = DB::select("select REASON_ACCEPTABILITY from MIS.EMP_OTHERS_WORK_HISTORY_EXT
                                 where emp_id='$emp_id' AND STATUS='Absent'");

                if(!empty($isInformed)){

                    if($isInformed[0]->reason_acceptability=='Acceptable'){
                        $empEarlyOut['columnSettings']['fill'] = '#e9967a';

                    }else if($isInformed[0]->reason_acceptability=='Unacceptable'){
                        $empEarlyOut['columnSettings']['fill'] = '#DC3E28';
                    }
                }else{
                    $empEarlyOut['columnSettings']['fill'] = '#DC3E28';
                }
                /* Is Informed ends*/
            }

            $tempEarlyOut['fromDate']  = substr($empEarlyOut[$i]->last_out_time,0,-3);
            $tempEarlyOut['toDate']  = substr($empEarlyOut[$i]->scedule_end_time,0,-3);
            array_push($empDetails, $tempEarlyOut);
        }


        /* employee Snacks details*/
        $empDetailsSnacks=array();
        for ($i=0;$i<sizeof($allEmp);$i++) {
            foreach ($empSnacksTime as $empSnacksTimeS) {

                $emp_desig = $allEmp[$i]->desig_name;
                $desig_short = explode(',', $emp_desig);

                $tempSnacks['category'] = $allEmp[$i]->emp_name.'/'.$allEmp[$i]->emp_id.'/'.$desig_short[0];

                if($allEmp[$i]->default_status=='PRESENT'){
                    $tempSnacks['columnSettings']['fill'] = '#F48A9F';
                }else if($allEmp[$i]->default_status=='OSD'){
                    $tempSnacks['columnSettings']['fill'] = '#EA9D3A';
                }else if($allEmp[$i]->default_status=='LEAVE'){
                    $tempSnacks['columnSettings']['fill'] = '#AEF05F';
                }else if($allEmp[$i]->default_status=='HOLIDAY'){
                    $tempSnacks['columnSettings']['fill'] = '#3AC2EA';
                }else if($allEmp[$i]->default_status=='ABSENT'){

                    /* Is Informed Starts*/
                    $u_id = $allEmp[$i]->emp_id;
                    $emp_id= json_decode( json_encode($u_id), true);

                    $isInformed = DB::select("select REASON_ACCEPTABILITY from MIS.EMP_OTHERS_WORK_HISTORY_EXT
                                 where emp_id='$emp_id' AND STATUS='Absent'");

                    if(!empty($isInformed)){

                        if($isInformed[0]->reason_acceptability=='Acceptable'){
                            $tempSnacks['columnSettings']['fill'] = '#e9967a';

                        }else if($isInformed[0]->reason_acceptability=='Unacceptable'){
                            $tempSnacks['columnSettings']['fill'] = '#DC3E28';
                        }
                    }else{
                        $tempSnacks['columnSettings']['fill'] = '#DC3E28';
                    }
                    /* Is Informed ends*/
                }

                if ($allEmp[$i]->plant_id == $empSnacksTimeS->plant_id ) {
                    $date_time_split = explode(' ', $allEmp[0]->scedule_start_time);
                    $date['date'] = $date_time_split[0];

                    $time_start_split = explode(' ', $empSnacksTimeS->time_start);
                    $time_start['time'] = $time_start_split[1];


                    $time_end_split = explode(' ', $empSnacksTimeS->time_end);
                    $time_end['time'] = $time_end_split[1];


                    $startDTSnacks = date('Y-m-d H:i:s', strtotime(  $date['date']." ".$time_start['time']));
                    $endDTSnacks = date('Y-m-d H:i:s', strtotime(  $date['date']." ".$time_end['time']));


                    $tempSnacks['fromDate']  = substr($startDTSnacks,0,-3);
                    $tempSnacks['toDate']  = substr($endDTSnacks,0,-3);
                    break;
                }
            }
            array_push($empDetailsSnacks, $tempSnacks);
            array_push($empDetails,$tempSnacks);
        }

        /* employee lunch details*/
        $allEmpDetailsLunch=array();
        for ($i=0;$i<sizeof($allEmp);$i++) {
            foreach ($empLaunchTime as $launchTimnes) {
                $emp_desig = $allEmp[$i]->desig_name;
                $desig_short = explode(',', $emp_desig);
                $tempLaunch['category'] = $allEmp[$i]->emp_name.'/'.$allEmp[$i]->emp_id.'/'.$desig_short[0];

                if($allEmp[$i]->default_status=='PRESENT'){
                    $tempLaunch['columnSettings']['fill'] = '#ECE77E';
                }else if($allEmp[$i]->default_status=='OSD'){
                    $tempLaunch['columnSettings']['fill'] = '#EA9D3A';
                }else if($allEmp[$i]->default_status=='LEAVE'){
                    $tempLaunch['columnSettings']['fill'] = '#AEF05F';
                }else if($allEmp[$i]->default_status=='HOLIDAY'){
                    $tempLaunch['columnSettings']['fill'] = '#3AC2EA';
                }else if($allEmp[$i]->default_status=='ABSENT'){
                    /* Is Informed Starts*/
                    $u_id = $allEmp[$i]->emp_id;
                    $emp_id= json_decode( json_encode($u_id), true);

                    $isInformed = DB::select("select REASON_ACCEPTABILITY from MIS.EMP_OTHERS_WORK_HISTORY_EXT
                                 where emp_id='$emp_id' AND STATUS='Absent'");

                    if(!empty($isInformed)){

                        if($isInformed[0]->reason_acceptability=='Acceptable'){
                            $tempLaunch['columnSettings']['fill'] = '#e9967a';

                        }else if($isInformed[0]->reason_acceptability=='Unacceptable'){
                            $tempLaunch['columnSettings']['fill'] = '#DC3E28';
                        }
                    }else{
                        $tempLaunch['columnSettings']['fill'] = '#DC3E28';
                    }
                    /* Is Informed ends*/
                }

                if ($allEmp[$i]->plant_id == $launchTimnes->plant_id ) {

                    $date_time_split = explode(' ', $allEmp[0]->scedule_start_time);
                    $date['date'] = $date_time_split[0];

                    $time_start_split = explode(' ', $launchTimnes->time_start);
                    $time_start['time'] = $time_start_split[1];


                    $time_end_split = explode(' ', $launchTimnes->time_end);
                    $time_end['time'] = $time_end_split[1];

                    $startDT = date('Y-m-d H:i:s', strtotime(  $date['date']." ".$time_start['time']));
                    $endDT = date('Y-m-d H:i:s', strtotime(  $date['date']." ".$time_end['time']));


                    $tempLaunch['fromDate']  = substr($startDT,0,-3);
                    $tempLaunch['toDate']  = substr($endDT,0,-3);
                    break;
                }
            }
            array_push($allEmpDetailsLunch,$tempLaunch);
            array_push($empDetails,$tempLaunch);
        }


        /* employee overtime details*/
        $testArray = array();
        for ($i=0;$i<sizeof($allEmp);$i++) {

            for ($j = 0; $j < sizeof($empOverTime); $j++) {

                if(isset($empOverTime[$j]->emp_id) && isset($allEmp[$i]->emp_id)){

                    if ($empOverTime[$j]->emp_id == $allEmp[$i]->emp_id) {

                        $emp_desig = $empOverTime[$i]->desig_name;
                        $desig_short = explode(',', $emp_desig);

                        $tempOverTime['category'] = $allEmp[$i]->emp_name.'/'.$allEmp[$i]->emp_id.'/'.$desig_short[0];


                        if( $empOverTime[$j]->default_status =='PRESENT'){
                            $tempOverTime['columnSettings']['fill'] = '#D473E8';

                        }else if($empOverTime[$j]->default_status=='OSD'){
                            $tempOverTime['columnSettings']['fill'] = '#EA9D3A';
                        }else if($empOverTime[$j]->default_status=='LEAVE'){
                            $tempOverTime['columnSettings']['fill'] = '#AEF05F';
                        }else if($empOverTime[$j]->default_status=='HOLIDAY'){
                            $tempOverTime['columnSettings']['fill'] = '#3AC2EA';
                        }else if($empOverTime[$j]->default_status=='ABSENT'){
                            /*Is informed*/
                            $isInformed = DB::select("select REASON_ACCEPTABILITY from MIS.EMP_OTHERS_WORK_HISTORY_EXT
                                 where emp_id='$emp_id' AND STATUS='Absent'");
                            if(!$isInformed){
                                $empOverTime['columnSettings']['fill'] = '#DC3E28';
                            }else{
                                if($isInformed[0]->reason_acceptability=='Acceptable'){
                                    $empOverTime['columnSettings']['fill'] = '#e9967a';

                                }else if($isInformed[0]->reason_acceptability=='Unacceptable'){
                                    $empOverTime['columnSettings']['fill'] = '#DC3E28';
                                }
                            }
                            /*Is informed end*/
                        }

                        $tempOverTime['fromDate']  = substr($empOverTime[$j]->overtime_start_time,0,-3);
                        $tempOverTime['toDate']  = substr($empOverTime[$j]->overtime_end_time,0,-3);

                        array_push($empDetails,$tempOverTime);
                        break;
                    }
                }

            }
        }
        $empDetailsJson = json_encode($empDetails);

        $empName=array();
        for ($i=0;$i<sizeof($allEmp);$i++){

            $emp_desig = $allEmp[$i]->desig_name;
            $desig_short = explode(',', $emp_desig);

            $tempTwo['category']  =  $allEmp[$i]->emp_name.'/'.$allEmp[$i]->emp_id.'/'.$desig_short[0];
            array_push($empName, $tempTwo);
        }

        $empNameJson = json_encode($empName);

        $tempLateInDetails = array();
        $tempLateInName= array();
        if($absLate=='absent'){

            /*All emp absent stsrts*/
            $allEmpDetailsAbsent= array();
            for ($i=0;$i<sizeof($empAbsent);$i++) {
                $emp_desig = $empAbsent[$i]->desig_name;
                $desig_short = explode(',', $emp_desig);
                $temp['category'] = $empAbsent[$i]->emp_name.'/'.$empAbsent[$i]->emp_id.'/'.$desig_short[0];
                if($empAbsent[$i]->default_status=='ABSENT'){
                    /* Is Informed Starts*/
                    $u_id = $empAbsent[$i]->emp_id;
                    $emp_id= json_decode( json_encode($u_id), true);
                    $isInformed = DB::select("select REASON_ACCEPTABILITY from MIS.EMP_OTHERS_WORK_HISTORY_EXT
                                 where emp_id='$emp_id' AND STATUS='Absent'");
                    if(!empty($isInformed)){
                        if($isInformed[0]->reason_acceptability=='Acceptable'){
                            $temp['columnSettings']['fill'] = '#e9967a';

                        }else if($temp[0]->reason_acceptability=='Unacceptable'){
                            $tempLaunch['columnSettings']['fill'] = '#DC3E28';
                        }
                    }else{
                        $temp['columnSettings']['fill'] = '#DC3E28';
                    }
                }
                $temp['fromDate']  = substr($empAbsent[$i]->scedule_start_time,0,-3);
                $temp['toDate']  = substr($empAbsent[$i]->scedule_end_time,0,-3);
                array_push($allEmpDetailsAbsent, $temp);
                array_push($allEmpDetailsAbsent, $temp);
                array_push($allEmpDetailsAbsent, $temp);
            }
            $allEmpDetailsAbsentJson = json_encode($allEmpDetailsAbsent);
            /*All emp Absent ends*/


            /*Emp name absent starts*/
            $empNameAbsent=array();
            for ($i=0;$i<sizeof($empAbsent);$i++){

                $emp_desig = $empAbsent[$i]->desig_name;
                $desig_short = explode(',', $emp_desig);
                $tempTwo['category']  =  $empAbsent[$i]->emp_name.'/'.$empAbsent[$i]->emp_id.'/'.$desig_short[0];
                array_push($empNameAbsent, $tempTwo);
            }
            $empNameAbsentJson = json_encode($empNameAbsent);
            /*Emp name absent ends*/


            return response()->json(['allEmpDataJson'=>$allEmpDetailsAbsentJson,'allEmpNameJson'=>$empNameAbsentJson] );

        }elseif ($absLate=='lateIn'){

            $allEmpDetailsLateIn = array();

            /*Emp Late In snacks Starts*/
            for ($i=0;$i<sizeof($empLateIn);$i++) {

                foreach ($empSnacksTime as $empSnacksTimeS) {

                    $emp_desig = $empLateIn[$i]->desig_name;
                    $desig_short = explode(',', $emp_desig);
                    $tempSnacksLateIn['category'] = $empLateIn[$i]->emp_name.'/'.$empLateIn[$i]->emp_id.'/'.$desig_short[0];

                    if($empLateIn[$i]->default_status=='PRESENT'){
                        $tempSnacksLateIn['columnSettings']['fill'] = '#F48A9F';
                    }

                    if ($empLateIn[$i]->plant_id == $empSnacksTimeS->plant_id ) {

                        $date_time_split = explode(' ', $empLateIn[0]->scedule_start_time);
                        $date['date'] = $date_time_split[0];

                        $time_start_split = explode(' ', $empSnacksTimeS->time_start);
                        $time_start['time'] = $time_start_split[1];


                        $time_end_split = explode(' ', $empSnacksTimeS->time_end);
                        $time_end['time'] = $time_end_split[1];


                        $startDTSnacks = date('Y-m-d H:i:s', strtotime(  $date['date']." ".$time_start['time']));
                        $endDTSnacks = date('Y-m-d H:i:s', strtotime(  $date['date']." ".$time_end['time']));


                        $tempSnacksLateIn['fromDate']  = substr($startDTSnacks,0,-3);
                        $tempSnacksLateIn['toDate']  = substr($endDTSnacks,0,-3);
                        break;
                    }
                }
                array_push($allEmpDetailsLateIn,$tempSnacksLateIn);
            }
            /*Emp LAte in Snacks ends*/

            /*Emp Late in Details starts*/
            for ($i=0;$i<sizeof($empLateIn);$i++) {

                $emp_desig = $empLateIn[$i]->desig_name;
                $desig_short = explode(',', $emp_desig);

                $temp['category'] = $empLateIn[$i]->emp_name.'/'.$empLateIn[$i]->emp_id.'/'.$desig_short[0];

                if($empLateIn[$i]->default_status=='PRESENT'){
                    $temp['columnSettings']['fill'] = '#8FBE69';
                }
                $temp['fromDate']  = substr($empLateIn[$i]->scedule_start_time,0,-3);
                $temp['toDate']  = substr($empLateIn[$i]->scedule_end_time,0,-3);
                array_push($allEmpDetailsLateIn, $temp);
            }
            $empTempLateIn = array();
            for ($i=0;$i<sizeof($empLateIn);$i++) {
                $emp_desig = $empLateIn[$i]->desig_name;
                $desig_short = explode(',', $emp_desig);
                $empTempLateIn['category'] = $empLateIn[$i]->emp_name.'/'.$empLateIn[$i]->emp_id.'/'.$desig_short[0];
                if($empLateIn[$i]->default_status=='PRESENT'){
                    $empTempLateIn['columnSettings']['fill'] = '#1B4897';
                }
                $empTempLateIn['fromDate']  = substr($empLateIn[$i]->scedule_start_time,0,-3);
                $empTempLateIn['toDate']  = substr($empLateIn[$i]->first_in_time,0,-3);
                array_push($allEmpDetailsLateIn, $empTempLateIn);
            }
            /*Emp Late in Details ends*/

            $allEmpDetailsLateInJson = json_encode($allEmpDetailsLateIn);

            /*Emp name in late in starts*/
            $empNameLateIn=array();
            for ($i=0;$i<sizeof($empLateIn);$i++){

                $emp_desig = $empLateIn[$i]->desig_name;
                $desig_short = explode(',', $emp_desig);
                $tempTwo['category']  =  $empLateIn[$i]->emp_name.'/'.$empLateIn[$i]->emp_id.'/'.$desig_short[0];
                array_push($empNameLateIn, $tempTwo);
            }
            $tempLateInNameJson = json_encode($empNameLateIn);
            /*Emp name in late in ends*/

            return response()->json(['allEmpDataJson'=>$allEmpDetailsLateInJson,'allEmpNameJson'=>$tempLateInNameJson] );

        }
        return response()->json(['allEmpDataJson'=>$empDetailsJson,'allEmpNameJson'=>$empNameJson] );

    }

}