<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 3/21/2018
 * Time: 11:30 AM
 */

namespace App\Http\Controllers\Rmportal;


use App\Http\Controllers\Controller;
use App\TerrWiseDoctorDelete;
use Illuminate\Http\Request;
use App\TERR_WISE_DOC_TRANSFER;
use Auth;
use DB;
use Input;
use Validator;
use File;
use Carbon;




class DoctorsTerrChangeController extends Controller
{


    public function docwMpoTerrList(Request $request)
    {
        if ($request->ajax()) {
            $resp_data = DB::Select("select distinct terr_id mpo_terr_id
                                    from MIS.DOCTOR_WISE_TERRITORY
                                    where substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) = '$request->amTerr'
                                    order by terr_id");
            return response()->json($resp_data);
            //return response()->json($request->all());
        }
    }


    function mpoTerrWDoctors(Request $request){

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");


        $resp_data = DB::select("
                            SELECT dt.terr_id,di.doctor_id,di.doctor_name,
                            CASE WHEN hospital_address IS NULL THEN chember_address ELSE hospital_address END address
                            from mis.doctor_wise_territory dt JOIN doctor_info.doctor_information@WEB_TO_SAMPLE_MSD di
                            ON (dt.doctor_id = di.doctor_id)
                            where dt.terr_id = '$request->mpoTerrId'
                            and valid = 'YES'
                            order by di.doctor_id
                ");

        $am_data = DB::select("
                        select distinct am_terr_id am_terr_id
                        from hrtms.hr_terr_list@web_to_hrtms
                        where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                        and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerrId'
                        and am_terr_id not like '%-500%'
                        order by am_terr_id
                    ");


        //return response()->json($resp_data);
        return response()->json(['resp_data'=>$resp_data,'am_data'=>$am_data]);
        //return response()->json($request->all());
    }

    function TerrWDocTransfer(Request $request){
        $systime = Carbon\Carbon::now();

        if ($request->ajax()) {

            ini_set('max_execution_time', 600);

            $oldReg = $request->oldReg;
            $oldAMid = $request->oldAMid;
            $oldMPOid = $request->oldMPOid;
            $newAMid = $request->newAMid;
            $newMPOid = $request->newMPOid;


            foreach ($request->transData as $data) {
                if (TERR_WISE_DOC_TRANSFER::where('OLD_RM_TERR', $oldReg)
                        ->where('OLD_AM_TERR', $oldAMid)
                        ->where('OLD_MPO_TERR', $oldMPOid)
                        ->where('NEW_AM_TERR', $newAMid)
                        ->where('NEW_MPO_TERR', $newMPOid)
                        ->where('DOCTOR_ID', $data['doctor_id'])
                        ->count() > 0) {
                    return response()->json(['error' => 'Your request has been approved by Admin, please wait.']);
                } else {
                    $dataArray = [
                        'OLD_RM_TERR' => $oldReg,
                        'OLD_AM_TERR' => $oldAMid,
                        'OLD_MPO_TERR' => $oldMPOid,
                        'NEW_AM_TERR' => $newAMid,
                        'NEW_MPO_TERR' => $newMPOid,
                        'DOCTOR_ID' => $data['doctor_id'],
                        'DOCTOR_NAME' => $data['doctor_name'],
                        'CREATE_USER' => Auth::user()->user_id,
                        'CREATE_DATE' => $systime
                    ];
                    TERR_WISE_DOC_TRANSFER::insert($dataArray);
                }
            }
            return response()->json(['success' => 'Your request has been received and will be processed shortly.Please Wait for 2 hour.']);
        }
    }

    public function terrWiseDocDataDelete(Request $request)
    {
        // $systime = Carbon\Carbon::now();


        // if ($request->ajax()) {

        //     //ini_set('max_execution_time', 600);


        //     foreach ($request->deleteData as $data) {


        //         $t_id =  $data['terr_id'];
        //         $d_id =  $data['doctor_id'];


        //         if (TerrWiseDoctorDelete::where('TERR_ID', $t_id)
        //                 ->where('DOCTOR_ID', $d_id)
        //                 ->count() > 0) {
        //             return response()->json(['error' => 'Your request has been approved by Admin, 
        //             Please reload this page or press Display Report once a again']);
        //         }
        //         else{

        //             $dataArray = [
        //                 'TERR_ID' => $data['terr_id'],
        //                 'DOCTOR_ID' => $data['doctor_id'],
        //                 'DOCTOR_NAME' => $data['doctor_name'],
        //                 'CREATE_USER' => Auth::user()->user_id
        //             ];
        //             TerrWiseDoctorDelete::insert($dataArray);

        //             DB::DELETE("
        //                     delete from MIS.TERRITORY_WISE_DOCTOR_PLAN
        //                     where TERR_ID||DOCTOR_ID in(
        //                     SELECT   DISTINCT TERR_ID||DOCTOR_ID
        //                     FROM   MIS.TERR_WISE_DOCTOR_DELETE
        //                     where DELETE_STATUS = 'NO')
        //             ");

        //             DB::DELETE("
        //                     delete from MIS.DOCTOR_WISE_TERRITORY
        //                     where TERR_ID||DOCTOR_ID in(
        //                     SELECT   DISTINCT TERR_ID||DOCTOR_ID
        //                     FROM   MIS.TERR_WISE_DOCTOR_DELETE
        //                     where DELETE_STATUS = 'NO')
        //             ");

        //             DB::DELETE("
        //                     delete from MIS.DOCTOR_WISE_ITEM_UTILIZATION
        //                     where TERR_ID||DOCTOR_ID in(
        //                     SELECT   DISTINCT TERR_ID||DOCTOR_ID
        //                     FROM   MIS.TERR_WISE_DOCTOR_DELETE
        //                     where DELETE_STATUS = 'NO')
        //             ");


        //             DB::UPDATE("
        //                 update MIS.TERR_WISE_DOCTOR_DELETE
        //                 set DELETE_STATUS = 'YES',
        //                     UPDATE_DATE = ?,
        //                     UPDATE_USER = 'MIS'
        //                 where DELETE_STATUS = 'NO'
        //                 AND TERR_ID = ?
        //                 AND DOCTOR_ID = ?
        //             " , [$systime,$data['terr_id'],$data['doctor_id']]);

        //             return response()->json(['success' => 'Terr Wise Doctor deleted Successfully.']);
        //         }
        //     }

            
        // }


 $systime = Carbon\Carbon::now();
        
        if ($request->ajax()) {

            //ini_set('max_execution_time', 600);

            foreach ($request->deleteData as $data) {


                $t_id =  $data['terr_id'];
                $d_id =  $data['doctor_id'];


               $ct =  DB::select ("
                select count(*) cnt
                from mis.terr_wise_doctor_delete
                where terr_id = '$t_id'
                and doctor_id = '$d_id'
                                
                ");






//                if (TerrWiseDoctorDelete::where('TERR_ID', $t_id)
//                        ->where('DOCTOR_ID', $d_id)
//                        ->count() > 0) {
//                    return response()->json(['error' => 'Your request has been approved by Admin,
//                    Please reload this page or press Display Report once a again']);
//                }

                if($ct[0]->cnt > 0){
                    return response()->json(['error' => 'Your request has been approved by Admin, 
                    Please reload this page or press Display Report once a again']);
                }

                else{

                    $dataArray = [
                        'TERR_ID' => $data['terr_id'],
                        'DOCTOR_ID' => $data['doctor_id'],
                        'DOCTOR_NAME' => $data['doctor_name'],
                        'CREATE_USER' => Auth::user()->user_id
                    ];
                    TerrWiseDoctorDelete::insert($dataArray);

                    DB::insert("
                    insert into mis.terr_wise_doctor_delete_log(terr_id, doctor_id, doctor_name,delete_status, create_date, create_user,log_date)
                    select terr_id, doctor_id, doctor_name,delete_status, create_date, create_user,sysdate
                    from mis.terr_wise_doctor_delete
                    ");


                   DB::DELETE("
                           delete from MIS.TERRITORY_WISE_DOCTOR_PLAN
                           where TERR_ID||DOCTOR_ID in(
                           SELECT   DISTINCT TERR_ID||DOCTOR_ID
                           FROM   MIS.TERR_WISE_DOCTOR_DELETE
                           )
                   ");

                   DB::DELETE("
                           delete from MIS.DOCTOR_WISE_TERRITORY
                           where TERR_ID||DOCTOR_ID in(
                           SELECT   DISTINCT TERR_ID||DOCTOR_ID
                           FROM   MIS.TERR_WISE_DOCTOR_DELETE
                           )
                   ");

                   DB::DELETE("
                           delete from MIS.DOCTOR_WISE_ITEM_UTILIZATION
                           where TERR_ID||DOCTOR_ID in(
                           SELECT   DISTINCT TERR_ID||DOCTOR_ID
                           FROM   MIS.TERR_WISE_DOCTOR_DELETE
                           )
                   ");

                     DB::DELETE("delete from mis.terr_wise_doctor_delete");

                    // DB::UPDATE("
                    //     update MIS.TERR_WISE_DOCTOR_DELETE
                    //     set DELETE_STATUS = 'YES',
                    //         UPDATE_DATE = ?,
                    //         UPDATE_USER = 'MIS'
                    //     where DELETE_STATUS = 'NO'
                    //     AND TERR_ID = ?
                    //     AND DOCTOR_ID = ?
                    // " , [$systime,$data['terr_id'],$data['doctor_id']]);


                }
            }

            return response()->json(['success' => 'Terr Wise Doctor deleted Successfully.']);

            
        }

        
    }

}