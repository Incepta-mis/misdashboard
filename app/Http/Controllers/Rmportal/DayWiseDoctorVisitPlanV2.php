<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 7/28/2018
 * Time: 12:39 PM
 */

namespace App\Http\Controllers\Rmportal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Input;
use Validator;
use File;
use Carbon;

class DayWiseDoctorVisitPlanV2 extends Controller
{
    public function visitPlanData(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        if ($request->ajax()) {

            $resp_data = DB::Select("select dwt.terr_id terr_id,di.doctor_id doctor_id,di.doctor_name doctor_name,tl.emp_id emp_id,tl.emp_name emp_name,
                                    twdp.week1,twdp.visit1,twdp.week2,twdp.visit2,twdp.week3,twdp.visit3,twdp.week4,twdp.visit4,
                                    case when week1 = 'Saturday' then 1
                                     when week1 = 'Sunday' then 2 
                                     when week1 = 'Monday' then 3 
                                     when week1 = 'Tuesday' then 4 
                                     when week1 = 'Wednesday' then 5 
                                     when week1 = 'Thursday' then 6 
                                     when week1 = 'Friday' then 7 end dseq
                                    from mis.territory_wise_doctor_plan twdp,(select distinct mpo_terr_id,mpo_emp_id emp_id,mpo_name emp_name
                                                                                from hrtms.hr_terr_list@web_to_hrtms
                                                                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'))tl,
                                                                               (select doctor_id,doctor_name from doctor_info.doctor_information@WEB_TO_SAMPLE_MSD where  nvl(DOCTOR_STATUS,'A') != 'DELETE') di
                                                                               ,(select distinct terr_id,doctor_id from mis.doctor_wise_territory where terr_id ='$request->TerrId') dwt
                                                                                           
                                    
                                    WHERE dwt.terr_id = tl.mpo_terr_id
                                    and dwt.doctor_id = di.doctor_id
                                    AND dwt.TERR_ID = '$request->TerrId'
                                    and twdp.terr_id(+) = dwt.terr_id
                                   -- and twdp.week1 is not null
                                    and twdp.doctor_id(+) = dwt.doctor_id
                                    ORDER BY DOCTOR_ID,dseq asc");

                        /*$resp_data = DB::select("select *
                        from mis.territory_wise_doctor_plan_t
                        where terr_id = '$request->TerrId'
                        --and doctor_id = 210672
                        ");*/

            return response()->json($resp_data);

        }
    }

    public function dayWiseDocPlanUpdatev2(Request $request){

        $data = $request->usdata;
        $systime = Carbon\Carbon::now();
        $status = 'YES';
        $uid = Auth::user()->user_id;

        DB::insert('insert into MIS.TERR_WISE_DOC_VISIT_REARRANGE
                (DOCTOR_ID, DOCTOR_NAME, TERR_ID, EMP_ID, EMP_NAME,WEEK1,VISIT1,WEEK2,VISIT2,WEEK3,VISIT3,WEEK4,VISIT4,WEEK,CHECK_VAL,CREATE_DATE,UPDATE_STATUS,CREATE_USER)
                values (?, ?, ?,?, ?, ?,?, ?, ?,?, ?, ?,?, ?, ?, ?, ?, ?)',
            [$data['doctor_id'], $data['doctor_name'], $data['terr_id'], $data['emp_id'], $data['emp_name'],
                $data['weekday'], $data['visit1'], $data['weekday'], $data['visit2'], $data['weekday'],
                $data['visit3'], $data['weekday'], $data['visit4'], strtoupper($data['week']), $data['check'],$systime,$status,$uid
            ]);


        if(strtoupper($data['week']) == 'WEEK-1') {

            DB::table('TERRITORY_WISE_DOCTOR_PLAN')
                ->where('TERR_ID',$data['terr_id'])
                ->where('DOCTOR_ID',$data['doctor_id'])
                ->where('WEEK1',ucfirst(strtolower($data['weekday'])))
                ->update(array(
                    'VISIT1'=>$data['check'],
                    'UPDATE_DATE' => $systime,
                    'UPDATE_USER' => $uid
                ));
            return response()->json(['success' => 'Change Successfully.']);

        }else if (strtoupper($data['week']) == 'WEEK-2'){
            DB::table('TERRITORY_WISE_DOCTOR_PLAN')
                ->where('TERR_ID',$data['terr_id'])
                ->where('DOCTOR_ID',$data['doctor_id'])
                ->where('WEEK2',ucfirst(strtolower($data['weekday'])))
                ->update(array(
                    'VISIT2'=>$data['check'],
                    'UPDATE_DATE' => $systime,
                    'UPDATE_USER' => $uid
                ));
            return response()->json(['success' => 'Change Successfully.']);
        }else if (strtoupper($data['week']) == 'WEEK-3'){
            DB::table('TERRITORY_WISE_DOCTOR_PLAN')
                ->where('TERR_ID',$data['terr_id'])
                ->where('DOCTOR_ID',$data['doctor_id'])
                ->where('WEEK3',ucfirst(strtolower($data['weekday'])))
                ->update(array(
                    'VISIT3'=>$data['check'],
                    'UPDATE_DATE' => $systime,
                    'UPDATE_USER' => $uid
                ));
            return response()->json(['success' => 'Change Successfully.']);
        }else if (strtoupper($data['week']) == 'WEEK-4'){
            DB::table('TERRITORY_WISE_DOCTOR_PLAN')
                ->where('TERR_ID',$data['terr_id'])
                ->where('DOCTOR_ID',$data['doctor_id'])
                ->where('WEEK4',ucfirst(strtolower($data['weekday'])))
                ->update(array(
                    'VISIT4'=>$data['check'],
                    'UPDATE_DATE' => $systime,
                    'UPDATE_USER' => $uid
                ));
            return response()->json(['success' => 'Change Successfully.']);
        }




//         return response()->json($request->all());
//         return response()->json(['success' => 'Change Successfully.']);
    }

}