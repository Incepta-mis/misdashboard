<?php

namespace App\Http\Controllers\Scientific_Seminar;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ProposalBillApprovalController extends Controller
{
    public function index()
    {
        $uid = Auth::user()->user_id;

        $program_team = DB::select("
               select distinct prog_team_name from mis.ss_program_team order by  prog_team_name
        ");

        $program_type = DB::select("
               select pt_name from mis.ss_program_type where pt_status = 'VALID' order by pt_name
        ");

        $brand_name = DB::select("
            select distinct brand_name
            from sample_new.product_info@web_to_sample_msd
            where brand_name is not null
        ");

        $budget_details = DB::select("
                select cc_team_name,gl,cost_center_id
                from mis.ss_budget_cost_center
                order by cc_team_id
        ");

        $cost_details = DB::select("              
                select ci_name
                from mis.ss_cost_info
                order by ci_id
        ");

        $program_no = DB::select("
                        select prog_no 
from mis.ss_program_app ssp,(select distinct prog_team_name,'GROUP HEAD' emp_type from mis.ss_program_team 
                                 where group_head_id = $uid
                                 union all
                                 select distinct prog_team_name,'GM MSD' emp_type from mis.ss_program_team 
                                 where gm_id = $uid
                                 union all
                                 select distinct prog_team_name,'GM SALES' emp_type from mis.ss_program_team 
                                 where gm_sales_id = $uid
                                 )  ssei
where ssp.prog_team = ssei.prog_team_name 
and ss_prog = 'PROPOSAL'
and case when emp_type = 'GM MSD' then gm_sales_checked_date else
    case when emp_type = 'GM SALES' then group_head_checked_date else
    case when emp_type = 'GROUP HEAD' and prog_team in ('SPECIAL','HUMAN VACCINE') then msd_manager_checked_date else 
    case when emp_type = 'GROUP HEAD' and prog_team in ('AHVD') then rm_checked_date else
    ms_checked_date end end end end is not null
and case when emp_type = 'GM MSD' then gm_msd_checked_date else
    case when emp_type = 'GM SALES' then gm_sales_checked_date else
    case when emp_type = 'GROUP HEAD' then group_head_checked_date else null end end end is null
");

        $bill_no = DB::select("select bill_no 
from mis.ss_program_app ssp,(select distinct prog_team_name,'GROUP HEAD' emp_type from mis.ss_program_team 
                             where group_head_id = $uid
                             union all
                             select distinct prog_team_name,'GM MSD' emp_type from mis.ss_program_team 
                             where gm_id = $uid) ssei
where ssp.prog_team = ssei.prog_team_name 
and bill_no is not null 
and case when emp_type = 'GM MSD' then group_head_checked_date else
    case when emp_type = 'GROUP HEAD' and prog_team in ('SPECIAL','HUMAN VACCINE') then msd_manager_checked_date else 
    case when emp_type = 'GROUP HEAD' and prog_team in ('AHVD') then rm_checked_date else
    ms_checked_date end end end is not null
and case when emp_type = 'GM MSD' then gm_msd_checked_date else
    case when emp_type = 'GROUP HEAD' then group_head_checked_date else null end end is null
");
        return view('scientific.proposal_bill_approval')->with(['program_no' => $program_no,'pteam' => $program_team,'ptype' => $program_type,
            'brand_name' => $brand_name, 'bill_no'=>$bill_no,'budget_details' => $budget_details, 'cost_details' => $cost_details]);
    }
    public function getProposalDetailInfo(Request $request){
        $uid = Auth::user()->user_id;
        $prog_no = $request->bill;

        $data = DB::select("select prog_no,bill_no,rm_name,program_details,program_venue,prog_date_time,brand_name,nop_proposed,nop_attended,cost_per_head,advance_budget,actual_expenditure
from(    
select 'ALL' all_data,prog_team,prog_no,bill_no,rm_name,program_details,program_venue,prog_date_time,brand_name,nop_proposed,nop_attended,cost_per_head,advance_budget,actual_expenditure
from mis.ss_program_app ssp,(select distinct prog_team_name,'GROUP HEAD' emp_type from mis.ss_program_team 
                                 where group_head_id = $uid
                                 union all
                                 select distinct prog_team_name,'GM MSD' emp_type from mis.ss_program_team 
                                 where gm_id = $uid
                                 union all
                                 select distinct prog_team_name,'GM SALES' emp_type from mis.ss_program_team 
                                 where gm_sales_id = $uid
                                 )  ssei
where ssp.prog_team = ssei.prog_team_name 
and ss_prog = 'PROPOSAL'
and case when emp_type = 'GM MSD' then gm_sales_checked_date else
    case when emp_type = 'GM SALES' then group_head_checked_date else
    case when emp_type = 'GROUP HEAD' and prog_team in ('SPECIAL','HUMAN VACCINE') then msd_manager_checked_date else 
    case when emp_type = 'GROUP HEAD' and prog_team in ('AHVD') then rm_checked_date else
    ms_checked_date end end end end is not null
and case when emp_type = 'GM MSD' then gm_msd_checked_date else
    case when emp_type = 'GM SALES' then gm_sales_checked_date else
    case when emp_type = 'GROUP HEAD' then group_head_checked_date else null end end end is null    
)where '$prog_no' = case when '$prog_no' = 'ALL' then all_data else prog_no end");

        return $data;
    }
    public function getBillDetailInfo(Request $request){
        $bill = $request->bill;
        $uid = Auth::user()->user_id;

        $data = DB::select("select prog_no,bill_no,rm_name,program_details,program_venue,prog_date_time,brand_name,nop_proposed,nop_attended,cost_per_head,advance_budget,actual_expenditure
from(
select 'ALL' all_data,prog_team,prog_no,bill_no,rm_name,program_details,program_venue,prog_date_time,brand_name,nop_proposed,nop_attended,cost_per_head,advance_budget,actual_expenditure 
from mis.ss_program_app ssp,(select distinct prog_team_name,'GROUP HEAD' emp_type from mis.ss_program_team 
                             where group_head_id = $uid
                             union all
                             select distinct prog_team_name,'GM MSD' emp_type from mis.ss_program_team 
                             where gm_id = $uid) ssei
where ssp.prog_team = ssei.prog_team_name 
and bill_no is not null 
and case when emp_type = 'GM MSD' then group_head_checked_date else
    case when emp_type = 'GROUP HEAD' and prog_team in ('SPECIAL','HUMAN VACCINE') then msd_manager_checked_date else 
    case when emp_type = 'GROUP HEAD' and prog_team in ('AHVD') then rm_checked_date else
    ms_checked_date end end end is not null
and case when emp_type = 'GM MSD' then gm_msd_checked_date else
    case when emp_type = 'GROUP HEAD' then group_head_checked_date else null end end is null
)where '$bill' = case when '$bill' = 'ALL' then all_data else bill_no end
");

        return $data;

    }
    public function verify_program_data(Request $request){

        $uid = Auth::user()->user_id;
        $update_verification_column = '';

        $verifYdata = $request->verifyData;
        $verifYdata = json_decode($verifYdata, true);

        $type = DB::select("
            select distinct emp_type
            from
            (
                select 'GROUP HEAD' emp_type
                from mis.ss_program_team
                where group_head_id = '$uid'
                union all
                select 'GM MSD' emp_type
                from mis.ss_program_team
                where GM_ID = '$uid'
                union all
                select 'MEDICAL SERVICE' emp_type
                from SS_MEDICAL_SERVICE_EMP
                where MS_EMP_ID = '$uid'
                union all
                  select 'MSD' emp_type 
                from SS_MSD_EMP
                where MSD_EMP_ID = '$uid'
                union all
                select 'GM SALES' emp_type
                from mis.rm_gm_info
                where gm_emp_id =  '$uid'
            )");

        if (count($type) > 0) {
            if ($type[0]->emp_type == 'MEDICAL SERVICE') {
                foreach ($verifYdata as $verify){
                    $progNo = $verify['prog_no'];
                    $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set ms_emp_id= '$uid',
                                ms_checked_date= (select sysdate from dual)
                                where PROG_NO= '$progNo'
                                and ss_prog ='PROPOSAL'
                    ");
                }
            }
            if ($type[0]->emp_type == 'MSD') {
                foreach ($verifYdata as $verify){
                    $progNo = $verify['prog_no'];
                    $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set msd_manager_emp_id = '$uid',
                                msd_manager_checked_date = (select sysdate from dual)
                                where prog_no= '$progNo'
                                and ss_prog ='PROPOSAL'
                    ");
                }
            }

            if ($type[0]->emp_type == 'GROUP HEAD') {
                foreach ($verifYdata as $verify){
                    $progNo = $verify['prog_no'];
                    $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set GROUP_HEAD_EMP_ID = '$uid',
                                GROUP_HEAD_CHECKED_DATE = (select sysdate from dual)
                                where PROG_NO= '$progNo'
                                and ss_prog ='PROPOSAL'
                    ");
                }
            }
            if ($type[0]->emp_type == 'GM SALES') {
                foreach ($verifYdata as $verify){
                    $progNo = $verify['prog_no'];
                    $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set GM_SALES_EMP_ID = '$uid',
                                GM_SALES_CHECKED_DATE = (select sysdate from dual)
                                where PROG_NO= '$progNo'
                                and ss_prog ='PROPOSAL'
                    ");
                }
            }
            if ($type[0]->emp_type == 'GM MSD') {
                foreach ($verifYdata as $verify){
                    $progNo = $verify['prog_no'];
                    $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set GM_MSD_EMP_ID = '$uid',
                                GM_MSD_CHECKED_DATE = (select sysdate from dual)
                                where PROG_NO= '$progNo'
                                and ss_prog ='PROPOSAL'
                    ");
                }
            }
        }

        if (Auth::user()->urole == '3' || Auth::user()->urole == '4'){
            foreach ($verifYdata as $verify){
                $progNo = $verify['prog_no'];
                $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set ssd_emp_id = '$uid',
                                ssd_checked_date = (select sysdate from dual)
                                where PROG_NO= '$progNo'
                                and ss_prog ='PROPOSAL'
                    ");
            }
        }
        if (Auth::user()->desig === 'DSM') {
            foreach ($verifYdata as $verify){
                $progNo = $verify['prog_no'];
                $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set dsm_emp_id= '$uid',
                                dsm_checked_date= (select sysdate from dual)
                                where PROG_NO= '$progNo'
                                and ss_prog ='PROPOSAL'
                    ");
            }
        }
        if (Auth::user()->desig === 'SM') {
            foreach ($verifYdata as $verify){
                $progNo = $verify['prog_no'];
                $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set sm_emp_id= '$uid',
                                sm_checked_date= (select sysdate from dual)
                                where PROG_NO= '$progNo'
                                and ss_prog ='PROPOSAL'
                    ");
            }
        }
        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
            foreach ($verifYdata as $verify){
                $progNo = $verify['prog_no'];
                $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set rm_emp_id= '$uid',
                                rm_checked_date= (select sysdate from dual)
                                where PROG_NO= '$progNo'
                                and ss_prog ='PROPOSAL'
                    ");
            }
        }
        if (Auth::user()->desig === 'AM') {
            foreach ($verifYdata as $verify){
                $progNo = $verify['prog_no'];
                $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set am_emp_id= '$uid',
                                am_checked_date= (select sysdate from dual)
                                where PROG_NO= '$progNo'
                                and ss_prog ='PROPOSAL'
                    ");
            }
        }
        return response()->json(['cost' => $update_verification_column]);
    }
    public function verify_bill_data(Request $request){

        $uid = Auth::user()->user_id;
        $update_verification_column = '';

        $verifYdata = $request->verifybilldata;
        $verifYdata = json_decode($verifYdata, true);

        if (Auth::user()->urole == '3' || Auth::user()->urole == '4'){
            foreach ($verifYdata as $verify){
                $billNo = $verify['bill_no'];
                $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set ssd_emp_id = '$uid',
                                ssd_checked_date = (select sysdate from dual)
                                where bill_no = '$billNo'
                                and ss_prog ='BILL'
                    ");
            }
        }
        if (Auth::user()->desig === 'DSM') {
            foreach ($verifYdata as $verify){
                $billNo = $verify['bill_no'];
                $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set dsm_emp_id= '$uid',
                                dsm_checked_date= (select sysdate from dual)
                                where bill_no= '$billNo'
                                and ss_prog ='BILL'
                    ");
            }
        }
        if (Auth::user()->desig === 'SM') {
            foreach ($verifYdata as $verify){
                $billNo = $verify['bill_no'];
                $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set sm_emp_id= '$uid',
                                sm_checked_date= (select sysdate from dual)
                                where bill_no= '$billNo'
                                 and ss_prog ='BILL'
                    ");
            }
        }
        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
            foreach ($verifYdata as $verify){
                $billNo = $verify['bill_no'];
                $timing = Carbon::parse($verify['prog_date_time'])->format('m/d/Y H:i:s A');
                $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set rm_emp_id= '$uid',
                                rm_checked_date= (select sysdate from dual),
                                prog_date_time = '$timing'
                                where bill_no= '$billNo'
                                and ss_prog ='BILL'
                    ");
            }
        }
        if (Auth::user()->desig === 'AM') {
            foreach ($verifYdata as $verify){
                $billNo = $verify['bill_no'];
                $timing = Carbon::parse($verify['prog_date_time'])->format('m/d/Y H:i:s A');
                $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set am_emp_id= '$uid',
                                am_checked_date= (select sysdate from dual),
                                prog_date_time = '$timing'
                                where bill_no= '$billNo'
                                and ss_prog ='BILL'
                    ");
            }
        }
        $type = DB::select("
            select distinct emp_type
            from
            (
            select 'GROUP HEAD' emp_type
            from mis.ss_program_team
            where group_head_id = '$uid'
            union all
            select 'GM MSD' emp_type
            from mis.ss_program_team
            where GM_ID = '$uid'
            union all
            select 'MEDICAL SERVICE' emp_type
            from SS_MEDICAL_SERVICE_EMP
            where MS_EMP_ID = '$uid'
            union all
            select 'MSD' emp_type 
            from SS_MSD_EMP
            where MSD_EMP_ID = '$uid'
            union all
            select 'GM SALES' emp_type
            from mis.rm_gm_info
            where gm_emp_id =  '$uid'
            )");

        if (count($type) > 0) {
            if ($type[0]->emp_type == 'MEDICAL SERVICE') {
                foreach ($verifYdata as $verify){
                    $billNo = $verify['bill_no'];
                    $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set ms_emp_id= '$uid',
                                ms_checked_date= (select sysdate from dual)
                                where bill_no= '$billNo'
                                and ss_prog ='BILL'
                    ");
                }
            }
            if ($type[0]->emp_type == 'MSD') {
                foreach ($verifYdata as $verify){
                    $billNo = $verify['bill_no'];
                    $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set msd_manager_emp_id = '$uid',
                                msd_manager_checked_date = (select sysdate from dual)
                                where bill_no = '$billNo'
                                and ss_prog ='BILL'
                    ");
                }
            }
            if ($type[0]->emp_type == 'GROUP HEAD') {
                foreach ($verifYdata as $verify){
                    $billNo = $verify['bill_no'];
                    $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set GROUP_HEAD_EMP_ID = '$uid',
                                GROUP_HEAD_CHECKED_DATE = (select sysdate from dual)
                                where bill_no= '$billNo'
                                and ss_prog ='BILL'
                    ");
                }
            }
            if ($type[0]->emp_type == 'GM SALES') {
                foreach ($verifYdata as $verify){
                    $billNo = $verify['bill_no'];
                    $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set GM_SALES_EMP_ID = '$uid',
                                GM_SALES_CHECKED_DATE = (select sysdate from dual)
                                where bill_no= '$billNo'
                                and ss_prog ='BILL'
                    ");
                }
            }

            if ($type[0]->emp_type == 'GM MSD') {
                foreach ($verifYdata as $verify){
                    $billNo = $verify['bill_no'];
                    $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set GM_MSD_EMP_ID = '$uid',
                                GM_MSD_CHECKED_DATE = (select sysdate from dual)
                                where bill_no= '$billNo'
                                and ss_prog ='BILL'
                    ");
                }
            }
        }
        return response()->json(['cost' => $update_verification_column]);
    }
}
