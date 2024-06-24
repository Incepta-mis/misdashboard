<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 1/26/2020
 * Time: 1:10 PM
 */

namespace App\Http\Controllers\Neocare;

use App\Mobi_service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

class Hopital_Wise_Chemist_Controller extends Controller
{
    public function index()
    {

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;
        $tid = Auth::user()->terr_id;




                                     if (Auth::user()->desig === 'HO') {

                                        $rm_terr = DB::select("   
                                                    select distinct rm_terr_id rm_terr_id, rm_emp_id, rm_name
                                                    from hrtms.hr_terr_list@web_to_hrtms
                                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                                    and p_group = 'HYGIENE'
                                                    order by rm_terr_id
                                        ");



                                        return view('Neocare.hospital_wise_chemist_entry')->with(['rm_terr' => $rm_terr]);
                                    }




        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {

            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
            from hrtms.hr_terr_list@web_to_hrtms
            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
            and rm_emp_id = ?", [$uid]);

            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )
                                and am_terr_id not like '%500%'   
                                order by am_terr_id");


            return view('Neocare.hospital_wise_chemist_entry')->with(['rm_terr' => $rm_terr, 'am_terr' => $am_terr ]);
        }




        if (Auth::user()->desig === 'AM') {

            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and am_emp_id = ?", [$uid]);

            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and am_emp_id  =?", [$uid]);

            $mpo_terr = DB::select("select distinct mpo_terr_id mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and am_emp_id  =?", [$uid]);

            return view('Neocare.hospital_wise_chemist_entry')->with([ 'rm_terr' => $rm_terr, 'am_terr' => $am_terr, 'mpo_terr' => $mpo_terr]);


        }

        if (Auth::user()->desig === 'TSO'||Auth::user()->desig === 'Sr. TSO'||Auth::user()->desig === 'MPO'|| Auth::user() ->desig == 'Sr. MPO') {

            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and mpo_emp_id = ?", [$uid]);

            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and mpo_emp_id  =?", [$uid]);

            $mpo_terr = DB::select("select distinct mpo_terr_id mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and mpo_emp_id  =?", [$uid]);

            $market = DB::select(" select distinct market_name from mis.neo_hospital_wise_chemist
                    where terr_id =?", [$tid]);


            return view('Neocare.hospital_wise_chemist_entry')->with([ 'rm_terr' => $rm_terr, 'am_terr' => $am_terr, 'mpo_terr' => $mpo_terr,'market' =>$market]);


        }

    }

    public function insert_row_nc(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR HH24:MI:SS' ");
        $systime = DB::select("
        select sysdate from dual
        ");

        $uid = Auth::user()->user_id;
        $uname = Auth::user()->name;

        if ($request->ajax()) {

            $verinfo = json_decode($request->insertdata);

            try{

                foreach ($verinfo as $data) {


                    $insert=  DB::insert("
    
                   INSERT INTO MIS.NEO_HOSPITAL_WISE_CHEMIST ( TERR_ID, MARKET_NAME, DAY, HOSPITAL_NAME, CHEMIST_CODE, CHEMIST_NAME, PRESENT_SALES, CREATE_USER, CREATE_DATE)
                    VALUES   (?,?,?,?,?,?,?,?,?)
                    ", [
                    $data->terr, $data->market,$data->day,$data->hospital,$data->chemist,$data->chname,$data->psale,$uid,$systime[0]->sysdate]);
                }

                if($insert) {
                    return response()->json(['success' => 'Data has been recorded Successfully']);
                }
                else{
                    return response()->json(['error' => 'Failed to save data']);
                }

            } catch (Oci8Exception $e) {
                return response()->json(['error' => 'Failed to save data']);
            }


        }


    }

    public function delete_row_hwc(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR HH24:MI:SS' ");
        $systime = DB::select("
        select sysdate from dual
        ");

        $uid = Auth::user()->user_id;
        $uname = Auth::user()->name;

        if ($request->ajax()) {

            $verinfo = json_decode($request->insertdata);

            try{

                foreach ($verinfo as $data) {

                    $insert=  DB::insert("
                        delete from  mis.neo_hospital_wise_chemist
                        where 
                        terr_id = ?
                        and market_name =?
                        and day =?
                        and  hospital_name = ?
                        and  chemist_code =?
                        and  chemist_name =?
                        and   present_sales =?
                    ", [
                        $data->terr, $data->market,$data->day,$data->hospital,$data->chemist,$data->chname,$data->psale]);
                }

                if($insert) {
                    return response()->json(['success' => 'Data has been deleted Successfully']);
                }
                else{
                    return response()->json(['error' => 'Failed to delete data']);
                }

            } catch (Oci8Exception $e) {
                return response()->json(['error' => 'Failed to delete data']);
            }


        }


    }

    public function regwMpoTerrList(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {

            if ($request->amTerr == 'ALL') {

                $resp_data = DB::Select("select DISTINCT tl.mpo_terr_id mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms tl
                                    where tl.rm_terr_id = '$request->rmTerrId'
                                    and tl.emp_month = trunc(sysdate,'MM')                                    
                                    order by TO_NUMBER(SUBSTR( tl.mpo_terr_id,instr( tl.mpo_terr_id,'-', -1)+1))");


            } else {


                $resp_data = DB::Select("select DISTINCT tl.mpo_terr_id mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms tl
                                    where tl.rm_terr_id = '$request->rmTerrId'
                                    and tl.am_terr_id =    '$request->amTerr'
                                    and tl.emp_month = trunc(sysdate,'MM')                                    
                                    order by TO_NUMBER(SUBSTR( tl.mpo_terr_id,instr( tl.mpo_terr_id,'-', -1)+1))");
            }


            return response()->json($resp_data);
        }
    }

    public function market_retrieve (Request $request)
    {
        if ($request->ajax()) {
            DB::statement("alter session set nls_date_format = 'DD-MON-RR' ");

            $market = DB::select("
                    select distinct market_name from mis.neo_hospital_wise_chemist
                    where terr_id = '$request->mpo_terr'
            ");

            return response()->json($market);
        }
    }

    public function hospital_retrieve (Request $request)
    {
        if ($request->ajax()) {
            DB::statement("alter session set nls_date_format = 'DD-MON-RR' ");

            $hospital = DB::select("                  
            select distinct hospital_name from mis.neo_hospital_wise_chemist
            where market_name = '$request->market'
            ");

            return response()->json($hospital);
        }
    }

    public function chemist_retrieve (Request $request)
    {
        if ($request->ajax()) {
            DB::statement("alter session set nls_date_format = 'DD-MON-RR' ");

            $chemist = DB::select("
                  
          select distinct chemist_code,chemist_name from mis.neo_hospital_wise_chemist
            where hospital_name = '$request->hospital'
            ");

            return response()->json($chemist);
        }
    }

    public function display_hwc_data (Request $request)
    {
        if ($request->ajax()) {
            DB::statement("alter session set nls_date_format = 'DD-MON-RR' ");

            $hwc_data = DB::select("
                select  terr_id, market_name, day, hospital_name, chemist_code, chemist_name, present_sales 
                from mis.neo_hospital_wise_chemist
                where  terr_id = '$request->mpo_terr'
                and market_name = '$request->market'
                and hospital_name = '$request->hospital'
                and chemist_code = '$request->chemist_code'
            ");

            return response()->json($hwc_data);
        }
    }

    public function sample_entry_view()
    {

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;
        $tid = Auth::user()->terr_id;

        if (Auth::user()->desig === 'HO')  {

            $rm_terr = DB::select("   
                                                    select distinct rm_terr_id rm_terr_id, rm_emp_id, rm_name
                                                    from hrtms.hr_terr_list@web_to_hrtms
                                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                                    and p_group = 'HYGIENE'
                                                    order by rm_terr_id
                                        ");

            $day = DB::select("
            (select to_char(sysdate,'DY') dd from dual)
            ");



            return view('Neocare.sample_information_entry')->with(['rm_terr' => $rm_terr,'day' => $day]);
        }

        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {

            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
            from hrtms.hr_terr_list@web_to_hrtms
            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
            and rm_emp_id = ?", [$uid]);

            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )
                                and am_terr_id not like '%500%'   
                                order by am_terr_id");

            $day = DB::select("
            (select to_char(sysdate,'DY') dd from dual)
            ");


            return view('Neocare.sample_information_entry')->with(['rm_terr' => $rm_terr, 'am_terr' => $am_terr,'day' => $day ]);
        }


        if (Auth::user()->desig === 'AM') {

            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and am_emp_id = ?", [$uid]);

            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and am_emp_id  =?", [$uid]);

            $mpo_terr = DB::select("select distinct mpo_terr_id mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and am_emp_id  =?", [$uid]);

            $day = DB::select("
            (select to_char(sysdate,'DY') dd from dual)
            ");

            return view('Neocare.sample_information_entry')->with([ 'rm_terr' => $rm_terr, 'am_terr' => $am_terr, 'mpo_terr' => $mpo_terr,'day' => $day]);


        }

        if (Auth::user()->desig === 'TSO'||Auth::user()->desig === 'Sr. TSO'||Auth::user()->desig === 'MPO'|| Auth::user() ->desig == 'Sr. MPO') {

            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and mpo_emp_id = ?", [$uid]);

            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and mpo_emp_id  =?", [$uid]);

            $mpo_terr = DB::select("select distinct mpo_terr_id mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and mpo_emp_id  =?", [$uid]);

            $market = DB::select(" select distinct market_name from mis.neo_hospital_wise_chemist
                    where terr_id =?", [$tid]);

            $day = DB::select("
            (select to_char(sysdate,'DY') dd from dual)
            ");


            return view('Neocare.sample_information_entry')->with([ 'rm_terr' => $rm_terr, 'am_terr' => $am_terr, 'mpo_terr' => $mpo_terr,'day' => $day,'market' =>$market]);


        }

    }

    public function multiple_row_retrieve (Request $request)
    {
        if ($request->ajax()) {
            DB::statement("alter session set nls_date_format = 'DD-MON-RR' ");

            $hwc_data = DB::select("
                
                    select * from mis.neo_hospital_wise_chemist 
                    where terr_id = '$request->mpo_terr'
                    and day = '$request->day'
                           
            ");

            return response()->json($hwc_data);
        }
    }

    public function insert_row_sample(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR HH24:MI:SS' ");
        $systime = DB::select("
        select sysdate from dual
        ");

        $uid = Auth::user()->user_id;
        $uname = Auth::user()->name;

        if ($request->ajax()) {

            $verinfo = json_decode($request->insertdata);
            $mtext = 'Dear Parents, Congratulations for the new baby! We hope your parenthood would be filled with lots of love & cuddles. All the very best from NeoCare Baby Diaper.For home delivery or query please contact- 0967-8669669 ';

            try{

                foreach ($verinfo as $data) {

                    $insert=  DB::insert("
    
                    INSERT INTO MIS.NEO_SAMPLE_INFORMATION ( TERR_ID, MARKET_NAME, DAY, HOSPITAL_NAME, CHEMIST_CODE, CHEMIST_NAME,PRESENT_SALES, CUSTOMER_NAME,CONTACT_NO,MPO_EMP_ID, SAMPLE_DATE, CREATE_USER, CREATE_DATE)
                    
                    VALUES   (?,?,?,?,?,?,?,?,?,?,?,?,?)
                    ", [
                        $data->terr, $data->market,$data->day,$data->hospital_name,$data->chemist_code,$data->chemist_name,$data->pr_sales,$data->customer_name,
                        $data->contact,$data->mpo_id,$systime[0]->sysdate,$uid,$systime[0]->sysdate]);
                }

//                DB::insert('insert into mis.sms_send_status_log
//             select * from mis.sms_send_status');
//
//                DB::delete('delete from mis.sms_send_status');

                $totalSentSms = 0;
                $api = new Mobi_service();
                foreach ($verinfo as $n) {
                    //Log::info($g->cno);
                    $status = $api->sendMessage('88'.$n->contact, trim($mtext));
                    $totalSentSms++;
                }
                $status = [
                    'triggerd_from' => 'CustomerInfoRepController|sendSingleSMS',
                    'status_text' => 'Y',
                    'sms_count' => $totalSentSms,
                    'sms_group' => 'N/A',
                    'create_user' => Auth::user()->user_id,
                    'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d ')
                ];

//                DB::table('mis.sms_send_status')->insert($status);

                if($insert) {
                    return response()->json(['success' => 'Data has been recorded Successfully']);
                }
                else{
                    return response()->json(['error' => 'Failed to save data']);
                }

            } catch (Oci8Exception $e) {
                return response()->json(['error' => 'Failed to save data']);
            }


        }


    }

    public function delete_row_sample_info(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR HH24:MI:SS' ");
        $systime = DB::select("
        select sysdate from dual
        ");

        $uid = Auth::user()->user_id;
        $uname = Auth::user()->name;

        if ($request->ajax()) {

            $verinfo = json_decode($request->insertdata);

            try{

                foreach ($verinfo as $data) {

                    $insert=  DB::insert("
                        delete from  mis.neo_sample_information
                where 
                terr_id = ?
                and market_name =?
                and day =?
                and  hospital_name = ?
                and  chemist_code =?
                and  chemist_name =?
                and   present_sales =?
                and   customer_name = ?
                and contact_no =?
                    ", [
                        $data->terr, $data->market,$data->day,$data->hospital,$data->chemist,$data->chname,$data->psale,$data->csn,$data->contact]);
                }

                if($insert) {
                    return response()->json(['success' => 'Data has been deleted Successfully']);
                }
                else{
                    return response()->json(['error' => 'Failed to delete data']);
                }

            } catch (Oci8Exception $e) {
                return response()->json(['error' => 'Failed to delete data']);
            }


        }


    }

    public function display_sample_data (Request $request)
    {
        if ($request->ajax()) {
            DB::statement("alter session set nls_date_format = 'DD-MON-RR' ");

            $hwc_data = DB::select("
                select  *
                from mis.NEO_SAMPLE_INFORMATION
                where  terr_id = '$request->mpo_terr'
                and market_name = '$request->market'
                and hospital_name = '$request->hospital'
            
            ");

            return response()->json($hwc_data);
        }
    }

    public function sample_info_report_view()
    {

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;
        $tid = Auth::user()->terr_id;




        if (Auth::user()->desig === 'HO')  {

            $rm_terr = DB::select("   
                                                    select distinct rm_terr_id rm_terr_id, rm_emp_id, rm_name
                                                    from hrtms.hr_terr_list@web_to_hrtms
                                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                                    and p_group = 'HYGIENE'
                                                    order by rm_terr_id
                                        ");

            $day = DB::select("
            (select to_char(sysdate,'DY') dd from dual)
            ");



            return view('Neocare.sample_information_report')->with(['rm_terr' => $rm_terr,'day' => $day]);
        }




        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {

            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
            from hrtms.hr_terr_list@web_to_hrtms
            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
            and rm_emp_id = ?", [$uid]);

            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )
                                and am_terr_id not like '%500%'   
                                order by am_terr_id");


            return view('Neocare.sample_information_report')->with(['rm_terr' => $rm_terr, 'am_terr' => $am_terr ]);
        }




        if (Auth::user()->desig === 'AM') {

            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and am_emp_id = ?", [$uid]);

            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and am_emp_id  =?", [$uid]);

            $mpo_terr = DB::select("select distinct mpo_terr_id mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and am_emp_id  =?", [$uid]);

            return view('Neocare.sample_information_report')->with([ 'rm_terr' => $rm_terr, 'am_terr' => $am_terr, 'mpo_terr' => $mpo_terr]);


        }

        if (Auth::user()->desig === 'TSO'||Auth::user()->desig === 'Sr. TSO'||Auth::user()->desig === 'MPO'|| Auth::user() ->desig == 'Sr. MPO') {

            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and mpo_emp_id = ?", [$uid]);

            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and mpo_emp_id  =?", [$uid]);

            $mpo_terr = DB::select("select distinct mpo_terr_id mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and mpo_emp_id  =?", [$uid]);


            return view('Neocare.sample_information_report')->with([ 'rm_terr' => $rm_terr, 'am_terr' => $am_terr, 'mpo_terr' => $mpo_terr]);


        }

    }

    public function sample_report_data (Request $request)
    {
        if ($request->ajax()) {
            DB::statement("alter session set nls_date_format = 'DD-MON-RR' ");

            $hwc_data = DB::select("
            select * from
            (
            select   nsi.*,'ALL' all_data,substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
            substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id
            from mis.neo_sample_information nsi
            where  to_date(sample_date) BETWEEN  TO_DATE ('$request->input_day_from', 'yyyy/mm/dd')
            AND TO_DATE ('$request->input_day_to', 'yyyy/mm/dd')
            )
            where '$request->mpo_terr'= case when '$request->mpo_terr'= 'ALL' then all_data else terr_id end
            AND '$request->am_terr' = case when '$request->am_terr' = 'ALL' then all_data else am_terr_id end
            ");

//

            return response()->json($hwc_data);
        }
    }

    public function hwc_report_view()
    {

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;
        $tid = Auth::user()->terr_id;




        if (Auth::user()->desig === 'HO')  {

            $rm_terr = DB::select("   
                                                    select distinct rm_terr_id rm_terr_id, rm_emp_id, rm_name
                                                    from hrtms.hr_terr_list@web_to_hrtms
                                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                                    and p_group = 'HYGIENE'
                                                    order by rm_terr_id
                                        ");

            $day = DB::select("
            (select to_char(sysdate,'DY') dd from dual)
            ");



            return view('Neocare.hwc_report')->with(['rm_terr' => $rm_terr,'day' => $day]);
        }


        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {

            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
            from hrtms.hr_terr_list@web_to_hrtms
            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
            and rm_emp_id = ?", [$uid]);

            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )
                                and am_terr_id not like '%500%'   
                                order by am_terr_id");


            return view('Neocare.hwc_report')->with(['rm_terr' => $rm_terr, 'am_terr' => $am_terr ]);
        }




        if (Auth::user()->desig === 'AM') {

            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and am_emp_id = ?", [$uid]);

            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and am_emp_id  =?", [$uid]);

            $mpo_terr = DB::select("select distinct mpo_terr_id mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and am_emp_id  =?", [$uid]);

            return view('Neocare.hwc_report')->with([ 'rm_terr' => $rm_terr, 'am_terr' => $am_terr, 'mpo_terr' => $mpo_terr]);


        }

        if (Auth::user()->desig === 'TSO'||Auth::user()->desig === 'Sr. TSO'||Auth::user()->desig === 'MPO'|| Auth::user() ->desig == 'Sr. MPO') {

            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and mpo_emp_id = ?", [$uid]);

            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and mpo_emp_id  =?", [$uid]);

            $mpo_terr = DB::select("select distinct mpo_terr_id mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and mpo_emp_id  =?", [$uid]);

            $market = DB::select(" select distinct market_name from mis.neo_hospital_wise_chemist
                    where terr_id =?", [$tid]);


            return view('Neocare.hwc_report')->with([ 'rm_terr' => $rm_terr, 'am_terr' => $am_terr, 'mpo_terr' => $mpo_terr,'market' =>$market]);



        }

    }

    public function display_hwc_report_data (Request $request)
    {
        if ($request->ajax()) {
            DB::statement("alter session set nls_date_format = 'DD-MON-RR' ");

            $hwc_data = DB::select("
                 select * from
                (           
                select  hwc.*,'ALL' all_data
                from mis.neo_hospital_wise_chemist hwc      
                )
                where  terr_id = '$request->mpo_terr'
                AND  '$request->market'= case when '$request->market' = 'ALL' then all_data else market_name end
                AND '$request->hospital' = case when '$request->hospital' = 'ALL' then all_data else hospital_name end
        
            ");

            return response()->json($hwc_data);
        }
    }

}