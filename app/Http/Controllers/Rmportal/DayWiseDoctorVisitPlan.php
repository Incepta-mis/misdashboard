<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 28/02/18
 * Time: 14:42
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


class DayWiseDoctorVisitPlan extends Controller
{
    public function visitPlanData(Request $request)
    {
          DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        if ($request->ajax()) {
            // $resp_data = DB::Select("SELECT TERR_ID,DOCTOR_ID,DOCTOR_NAME,EMP_ID,EMP_NAME,VISIT1 \"WEEK-1\",VISIT2 \"WEEK-2\",VISIT3 \"WEEK-3\",VISIT4 \"WEEK-4\"
            //                             FROM MIS.TERRITORY_WISE_DOCTOR_PLAN
            //                             WHERE UPPER(WEEK1) = '$request->Vday'
            //                             --AND NVL(VISIT1,0)+NVL(VISIT2,0)+NVL(VISIT3,0)+NVL(VISIT4,0) > 0
            //                             AND TERR_ID = '$request->TerrId'
            //                             ORDER BY DOCTOR_ID
            //                         ");
            //  $resp_data = DB::Select("SELECT dwt.TERR_ID TERR_ID,di.DOCTOR_ID DOCTOR_ID,di.DOCTOR_NAME DOCTOR_NAME,tl.EMP_ID EMP_ID,tl.EMP_NAME EMP_NAME,twdp.VISIT1 \"WEEK-1\",twdp.VISIT2 \"WEEK-2\",twdp.VISIT3 \"WEEK-3\",twdp.VISIT4 \"WEEK-4\"
            // FROM MIS.TERRITORY_WISE_DOCTOR_PLAN twdp,(select distinct mpo_terr_id,mpo_emp_id emp_id,mpo_name emp_name
            //                                             from hrtms.hr_terr_list@web_to_hrtms
            //                                             where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'))tl,
            //                                            (select doctor_id,doctor_name from doctor_info.doctor_information@WEB_TO_SAMPLE_MSD) di
            //                                            ,(select distinct terr_id,doctor_id from mis.doctor_wise_territory where terr_id ='$request->TerrId') dwt

            // WHERE dwt.terr_id = tl.mpo_terr_id
            // and dwt.doctor_id = di.doctor_id
            // and UPPER(WEEK1) = '$request->Vday'
            // --AND NVL(VISIT1,0)+NVL(VISIT2,0)+NVL(VISIT3,0)+NVL(VISIT4,0) > 0
            // AND dwt.TERR_ID = '$request->TerrId'
            // and twdp.terr_id(+) = dwt.terr_id
            // and twdp.doctor_id(+) = dwt.doctor_id
            // ORDER BY DOCTOR_ID ");
            // return response()->json($resp_data);



$resp_data = DB::Select("SELECT dwt.TERR_ID TERR_ID,di.DOCTOR_ID DOCTOR_ID,di.DOCTOR_NAME DOCTOR_NAME,tl.EMP_ID EMP_ID,tl.EMP_NAME EMP_NAME,
twdp.VISIT1 \"WEEK-1\",c.pv1,twdp.VISIT2 \"WEEK-2\",c.pv2,twdp.VISIT3 \"WEEK-3\",c.pv3,twdp.VISIT4 \"WEEK-4\",pv4
            FROM MIS.TERRITORY_WISE_DOCTOR_PLAN twdp,(select distinct mpo_terr_id,mpo_emp_id emp_id,mpo_name emp_name
                                                        from hrtms.hr_terr_list@web_to_hrtms
                                                        where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'))tl,
                                                       (select doctor_id,doctor_name from doctor_info.doctor_information @WEB_TO_SAMPLE_MSD where  nvl(DOCTOR_STATUS,'A') != 'DELETE' ) di
                                                       ,(select distinct terr_id,doctor_id from mis.doctor_wise_territory where terr_id ='$request->TerrId') dwt
                                                       ,(SELECT distinct terr_id,doctor_id,doctor_name,sum(nvl(visit1,0)) pv1,sum(nvl(visit2,0)) pv2,sum(nvl(visit3,0))pv3,sum(nvl(visit4,0))pv4 
                                                       FROM MIS.TERRITORY_WISE_DOCTOR_PLAN where TERR_ID = '$request->TerrId'
                                                       group by terr_id,doctor_id,doctor_name ) c

            WHERE dwt.terr_id = tl.mpo_terr_id
            and dwt.doctor_id = di.doctor_id
            and UPPER(WEEK1) = '$request->Vday'
            --AND NVL(VISIT1,0)+NVL(VISIT2,0)+NVL(VISIT3,0)+NVL(VISIT4,0) > 0
            AND dwt.TERR_ID = '$request->TerrId'
            and c.terr_id = dwt.TERR_ID
            and c.doctor_id = dwt.doctor_id
            and twdp.terr_id(+) = dwt.terr_id
            and twdp.doctor_id(+) = dwt.doctor_id
            ORDER BY DOCTOR_ID ");
            return response()->json($resp_data);


            //return response()->json($request->all());
        }
    }


    public function dayWiseDocPlanUpdate(Request $request){

            $data = $request->usdata;
            $systime = Carbon\Carbon::now();
            $status = 'YES';
            $uid = Auth::user()->user_id;

            DB::insert('insert into TERR_WISE_DOC_VISIT_REARRANGE
                (DOCTOR_ID, DOCTOR_NAME, TERR_ID, EMP_ID, EMP_NAME,WEEK1,VISIT1,WEEK2,VISIT2,WEEK3,VISIT3,WEEK4,VISIT4,WEEK,CHECK_VAL,CREATE_DATE,UPDATE_STATUS,CREATE_USER)                  
                values (?, ?, ?,?, ?, ?,?, ?, ?,?, ?, ?,?, ?, ?, ?, ?, ?)',
            [$data['doctor_id'], $data['doctor_name'], $data['terr_id'], $data['emp_id'], $data['emp_name'],
                $data['weekday'], $data['week-1'], $data['weekday'], $data['week-2'], $data['weekday'],
                $data['week-3'], $data['weekday'], $data['week-4'], strtoupper($data['week']), $data['check'],$systime,$status,$uid
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




      // return response()->json($data['week']);
       // return response()->json(['success' => 'Change Successfully.']);
    }

}