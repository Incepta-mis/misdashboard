<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 29/10/2020
 * Time: 1:19 PM
 */


namespace App\Http\Controllers\Scientific_Seminar;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;
use Illuminate\Support\Facades\Mail;


class Scientific_Seminar_Bill_Controller extends Controller
{
    public function index()
    {

        $uid = Auth::user()->user_id;

        $month_name = DB::select("select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 1)
                                    select *
                                      from (select trunc(add_months(sysdate, -1)) dt from dual), data
                                     order by dt, l
                                     )
                                     ");

        $program_team = DB::select("
               select distinct prog_team_name from mis.ss_program_team
        ");

        $program_type = DB::select("
               select pt_name from mis.ss_program_type where pt_status = 'VALID'
        ");

        $program_no = DB::select("

                select prog_no
                from(
                select prog_no
                from mis.ss_program_app
                where create_user = '$uid'
                and bill_no is null
               and ssd_checked_date is not null
                minus
                select prog_no
                from mis.ss_program_app
                where create_user = '$uid'
                and bill_no is not null)
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

//        if (Auth::user()->desig === 'DSM' || Auth::user()->desig === 'SM') {
//
//            $bill_no = DB::select("
//                    select bill_no
//                    from
//                    (select rm_terr_id,bill_no
//                    from mis.ss_program_app
//                    where bill_no is not null
//                    and rm_checked_date is not null
//                    and dsm_checked_date is null) ssp,(select rm_terr_id from mis.rm_gm_info
//                    where case when dsm_emp_id is null then sm_emp_id else dsm_emp_id end = '$uid') ei
//                    where ssp.rm_terr_id = ei.rm_terr_id
//                    order by bill_no
//            ");
//
//            return view('scientific.scientific_seminar_bill')->with(['month_name' => $month_name,
//                'pteam' => $program_team, 'ptype' => $program_type, 'program_no' => $program_no,
//                'brand_name' => $brand_name, 'budget_details' => $budget_details, 'cost_details' => $cost_details, 'bill_no' => $bill_no]);
//
//
//        }

        if (Auth::user()->urole == '3' || Auth::user()->urole == '4') {

            $bill_no = DB::select("
                    select bill_no
                    from mis.ss_program_app
                    where 
                     gm_msd_checked_date is not null
                      and ssd_checked_date is  null
                    and ss_prog = 'BILL' 
                    order by bill_no
            ");

            return view('scientific.scientific_seminar_bill')->with(['month_name' => $month_name,
                'pteam' => $program_team, 'ptype' => $program_type, 'program_no' => $program_no,
                'brand_name' => $brand_name, 'budget_details' => $budget_details, 'cost_details' => $cost_details, 'bill_no' => $bill_no]);

        }

        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {

            $program_no = DB::select("
                             select prog_no
                from(
                
                (
                select prog_no
                from mis.ss_program_app
                where create_user = '$uid'
                and bill_no is null
                and ssd_checked_date is not null
                               
                union
                               
                select distinct prog_no 
                from 
                (select am_terr_id,prog_no 
                from mis.ss_program_app
                where ssd_checked_date is not null and ss_prog = 'PROPOSAL') ssp,(select am_terr_id from hrtms.hr_terr_list@web_to_hrtms 
                where case when rm_emp_id is null then asm_emp_id else rm_emp_id end = '$uid' and emp_month = trunc(sysdate,'MM')) ei
                where ssp.am_terr_id = ei.am_terr_id
                               
                )
                minus
                select prog_no
                from mis.ss_program_app
                where create_user = '$uid'
                and bill_no is not null)
                                
                                
                               
        ");

            $bill_no = DB::select("
                   select distinct bill_no 
                        from 
                        (select am_terr_id,bill_no 
                        from mis.ss_program_app
                        where am_checked_date is not null
                        and rm_checked_date is null and ss_prog = 'BILL') ssp,(select am_terr_id from hrtms.hr_terr_list@web_to_hrtms 
                        where case when rm_emp_id is null then asm_emp_id else rm_emp_id end = '$uid' and emp_month = trunc(sysdate,'MM')) ei
                        where ssp.am_terr_id = ei.am_terr_id
                        
                        union 
                        
                        select bill_no
                        from mis.ss_program_app
                        where create_user = '$uid'
                        and rm_checked_date is null
                        and ss_prog = 'BILL' 
                         order by bill_no
            ");

            return view('scientific.scientific_seminar_bill')->with(['month_name' => $month_name,
                'pteam' => $program_team, 'ptype' => $program_type, 'program_no' => $program_no,
                'brand_name' => $brand_name, 'budget_details' => $budget_details, 'cost_details' => $cost_details, 'bill_no' => $bill_no]);


        }

        if (Auth::user()->desig === 'AM'||Auth::user()->desig === 'Sr. AM') {

            $bill_no = DB::select("
                            select bill_no
                            from mis.ss_program_app
                            where create_user = '$uid'
                            and am_checked_date is null
                            and ss_prog = 'BILL' 
                            ");

            return view('scientific.scientific_seminar_bill')->with(['month_name' => $month_name,
                'pteam' => $program_team, 'ptype' => $program_type, 'program_no' => $program_no,
                'brand_name' => $brand_name, 'budget_details' => $budget_details, 'cost_details' => $cost_details, 'bill_no' => $bill_no]);

        }

        if ($uid == '1002858') {

            $bill_no = DB::select("
                            select bill_no 
                            from mis.ss_program_app
                            where  ss_prog = 'BILL' 
                            and prog_team = 'HUMAN VACCINE'
                            and msd_manager_checked_date is null
                           and ms_checked_date is not null
                           and group_head_checked_date is null 
                            ");

            return view('scientific.scientific_seminar_bill')->with(['month_name' => $month_name,
                'pteam' => $program_team, 'ptype' => $program_type, 'program_no' => $program_no,
                'brand_name' => $brand_name, 'budget_details' => $budget_details, 'cost_details' => $cost_details, 'bill_no' => $bill_no]);

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
            )
                            ");

//            dd(count($type));

        if (count($type) > 0) {

            if ($type[0]->emp_type == 'MEDICAL SERVICE') {

                $bill_no = DB::select("
                            select bill_no 
                            from mis.ss_program_app
                            where  ss_prog = 'BILL' 
                            and rm_checked_date is not null
                            and ms_checked_date is null
                            and PROG_TEAM  ! = 'AHVD'
                            ");

                return view('scientific.scientific_seminar_bill')->with(['month_name' => $month_name,
                    'pteam' => $program_team, 'ptype' => $program_type, 'program_no' => $program_no,
                    'brand_name' => $brand_name, 'budget_details' => $budget_details, 'cost_details' => $cost_details, 'bill_no' => $bill_no]);

            }

            if ($type[0]->emp_type == 'MSD') {

                $bill_no = DB::select("
                            select bill_no 
                            from mis.ss_program_app
                            where  ss_prog = 'BILL' 
                            and prog_team = 'SPECIAL'
                            and msd_manager_checked_date is null
                           and ms_checked_date is not null
                           and group_head_checked_date is null 
                            ");

                return view('scientific.scientific_seminar_bill')->with(['month_name' => $month_name,
                    'pteam' => $program_team, 'ptype' => $program_type, 'program_no' => $program_no,
                    'brand_name' => $brand_name, 'budget_details' => $budget_details, 'cost_details' => $cost_details, 'bill_no' => $bill_no]);

            }

            if ($type[0]->emp_type == 'GROUP HEAD') {


                $bill_no = DB::select("
                           
                        select bill_no
                        from 
                        (select prog_team,bill_no 
                        from mis.ss_program_app
                        where bill_no is not null 
                        and case when prog_team in ('SPECIAL','HUMAN VACCINE') then msd_manager_checked_date else ms_checked_date end is not null
                        and group_head_checked_date is null
                        and prog_team <> 'AHVD'
                        union all
                        select prog_team,bill_no 
                        from mis.ss_program_app
                        where bill_no is not null 
                        
                        and group_head_checked_date is null
                        and prog_team = 'AHVD') pa,(select prog_team_name from mis.ss_program_team 
                        where group_head_id = '$uid') pt
                        where pa.prog_team = pt.prog_team_name 
                           
                            ");

                return view('scientific.scientific_seminar_bill')->with(['month_name' => $month_name,
                    'pteam' => $program_team, 'ptype' => $program_type, 'program_no' => $program_no,
                    'brand_name' => $brand_name, 'budget_details' => $budget_details, 'cost_details' => $cost_details, 'bill_no' => $bill_no]);

            }


//            if ($type[0]->emp_type == 'GM SALES') {
//
//                $bill_no = DB::select("
//                    select bill_no
//                    from
//                    (select rm_terr_id,bill_no
//                    from mis.ss_program_app
//                    where bill_no is not null
//                    and group_head_checked_date is not null
//                    and gm_sales_checked_date is null) ssp,(select rm_terr_id from mis.rm_gm_info where gm_emp_id = '$uid') ei
//                    where ssp.rm_terr_id = ei.rm_terr_id
//                    order by bill_no
//                            ");
//
//                return view('scientific.scientific_seminar_bill')->with(['month_name' => $month_name,
//                    'pteam' => $program_team, 'ptype' => $program_type, 'program_no' => $program_no,
//                    'brand_name' => $brand_name, 'budget_details' => $budget_details, 'cost_details' => $cost_details, 'bill_no' => $bill_no]);
//
//            }


            if ($type[0]->emp_type == 'GM MSD') {

                $bill_no = DB::select("
                                select bill_no
                                from 
                                (select prog_team,bill_no 
                                from mis.ss_program_app
                                where bill_no is not null
                                and prog_team <> 'AHVD' 
                                and group_head_checked_date is not null
                                and gm_msd_checked_date is null
                                union all
                                select prog_team,bill_no 
                                from mis.ss_program_app
                                where bill_no is not null
                                and prog_team = 'AHVD' 
                                and group_head_checked_date is not null
                                and gm_msd_checked_date is null) pa,(select distinct prog_team_name from mis.ss_program_team 
                                where gm_id = '$uid') pt
                                where pa.prog_team = pt.prog_team_name
                                order by bill_no
                            ");

                return view('scientific.scientific_seminar_bill')->with(['month_name' => $month_name,
                    'pteam' => $program_team, 'ptype' => $program_type, 'program_no' => $program_no,
                    'brand_name' => $brand_name, 'budget_details' => $budget_details, 'cost_details' => $cost_details, 'bill_no' => $bill_no]);

            }


        }

    if (Auth::user()->urole === '1' ) {

        $bill_no = DB::select("
                            select bill_no
                            from mis.ss_program_app
                            where bill_no is not null
                            ");

        return view('scientific.scientific_seminar_bill')->with(['month_name' => $month_name,
            'pteam' => $program_team, 'ptype' => $program_type, 'program_no' => $program_no,
            'brand_name' => $brand_name, 'budget_details' => $budget_details, 'cost_details' => $cost_details, 'bill_no' => $bill_no]);


    }

//        else {

//            $bill_no = DB::select("
//                            select bill_no
//                            from mis.ss_program_app
//                            where bill_no is not null
//                            ");
//
//            return view('scientific.scientific_seminar_bill')->with(['month_name' => $month_name,
//                'pteam' => $program_team, 'ptype' => $program_type, 'program_no' => $program_no,
//                'brand_name' => $brand_name, 'budget_details' => $budget_details, 'cost_details' => $cost_details, 'bill_no' => $bill_no]);
//
//        }

    }

    public function create_program(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $terr_id = Auth::user()->terr_id;
        $desig = Auth::user()->desig;


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

        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM'){

            $emp_info = DB::select("
                select distinct gm_name,sm_name,dsm_name,rm_terr_id,
                case when rm_emp_id is null then asm_name else rm_name end rm_asm_name
                from hrtms.hr_terr_list@web_to_hrtms
                where to_char(emp_month,'MON-RR') = '$request->mon'
                and rm_terr_id = '$terr_id'
        ");

            $am = DB::Select("select distinct am_terr_id am_terr_id, am_name
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO )  
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$terr_id'
                                    and am_terr_id not like '%-500%'
                                    order by am_terr_id");

            return response()->json(['designation' =>$desig,'emp_info' => $emp_info, 'am' => $am, 'budget_details' => $budget_details, 'cost_details' => $cost_details]);


        }

        if (Auth::user()->desig === 'AM'||Auth::user()->desig === 'Sr. AM'){

            $emp_info = DB::select("
                            select distinct gm_name,sm_name,dsm_name,rm_terr_id,case when rm_emp_id is null then asm_name else rm_name end rm_asm_name,
                            am_terr_id,am_name
                            from hrtms.hr_terr_list@web_to_hrtms
                            where to_char(emp_month,'MON-RR') = '$request->mon'
                            and p_group IN ('ANIMAL HEALTH & VACCINE DIVISION','HVC')
                            and am_terr_id = '$terr_id'
        ");

            $am = DB::Select("
                        select distinct tl.mpo_terr_id mpo_terr_id,mpo_name,p_group,d_id,depot_name
                        from hrtms.hr_terr_list@web_to_hrtms tl,
                        (select d_id depot_id,name depot_name  from msfa.depot@web_to_imsfa) di 
                        where tl.am_terr_id = '$terr_id'
                        and tl.emp_month = trunc(sysdate,'MM')   
                        and di.depot_id = tl.d_id                                 
                        order by to_number(substr( tl.mpo_terr_id,instr( tl.mpo_terr_id,'-', -1)+1))
                                    ");

            return response()->json(['designation' =>$desig,'emp_info' => $emp_info, 'am' => $am, 'budget_details' => $budget_details, 'cost_details' => $cost_details]);


        }

    }

    public function program_bill(Request $request)
    {

//        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        $terr_id = Auth::user()->terr_id;

        $program_info = DB::select("
                 select to_char(sysdate,'MON-RR') bill_month,SPA.* from MIS.SS_PROGRAM_APP SPA
                where prog_no = '$request->program'
                and ss_prog ='PROPOSAL'
               
        ");


        $budget_details = DB::select("
                select * from MIS.SS_BUDGET_DETAILS
                where prog_no = '$request->program'
        ");

        $cost_details = DB::select("              
                select * from MIS.SS_COST_DETAILS
                where prog_no = '$request->program'
        ");

        return response()->json(['program_info' => $program_info, 'budget_details' => $budget_details, 'cost_details' => $cost_details]);
    }

    public function am_change(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {

            $resp_data = DB::Select("
                                select distinct tl.mpo_terr_id mpo_terr_id,mpo_name,p_group,d_id,depot_name
                                from hrtms.hr_terr_list@web_to_hrtms tl,
                                (select d_id depot_id,name depot_name  from msfa.depot@web_to_imsfa) di 
                                where tl.rm_terr_id = '$request->rmTerrId'
                                and tl.am_terr_id =    '$request->amTerr'
                                and tl.emp_month = trunc(sysdate,'MM')   
                                and di.depot_id = tl.d_id                                 
                                order by to_number(substr( tl.mpo_terr_id,instr( tl.mpo_terr_id,'-', -1)+1))                                    
                                    ");

            return response()->json($resp_data);
        }
    }

    public function update_button()
    {

        $resp = DB::Select("select (select max(req_id)+1 from mis.ss_program) req_id,(select distinct substr(prog_no,1,instr(prog_no,'-',1,1))||
       (select max(substr(prog_no,instr(prog_no,'-',-1,1)+1))+1 from mis.ss_program where ss_prog = 'PROPOSAL') 
        from mis.ss_program where ss_prog = 'PROPOSAL') prog_no 
from dual");

        return response()->json($resp);

    }

    public function save_button_direct_bill(Request $request)
    {

        $uid = Auth::user()->user_id;
        $systime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
        $timing = Carbon::parse($request->timing)->format('Y/m/d H:i:s');
        $insert_proc = '';
        $insert_program_data = '';
        $insert_data_budget = '';
        $insert_data_cost = '';
        $resp = '';
        $flag = true;
        $cost_center = array();

        if ($request->ajax()) {

            $insert_budget_data = json_decode($request->insertBudget);

            foreach ($insert_budget_data as $insert_budget) {

                $bud_data = DB::Select("select ava_bud_amt from
                        MIS.SCIENTIFIC_SEMINAR_EXPENSE_RM
                        where expense_month = '$request->mon'
                        and gl = '$insert_budget->gl'
                        and cost_center_id = '$insert_budget->cc'
                                    ");

                if (count($bud_data) > 0){

                    if($insert_budget->amount > $bud_data[0]->ava_bud_amt ){
                        $flag = false;
                        $cost_center[] = $insert_budget->team ;
                    }
                }

                else{
                    $flag = false;
                    $cost_center[] = $insert_budget->team ;
                }


            }

            try {

                if($flag){

                $resp = DB::Select("
                select req_id,bill_no
                from(
                select (select max(nvl(req_id,0))+1 from mis.ss_program where substr(month_of_prog,-2,2) = substr('$request->mon',-2,2) ) req_id,
                (select distinct substr(bill_no,1,instr(bill_no,'-',1,1)-1)||'-'||       
                (select max(to_number(substr(bill_no,instr(bill_no,'-',-1,1)+1)))+1 from mis.ss_program where ss_prog = 'BILL'
                and substr(month_of_prog,-2,2) = substr('$request->mon',-2,2)) 
                from mis.ss_program where ss_prog = 'BILL'and substr(month_of_prog,-2,2) = substr('$request->mon',-2,2)) bill_no 
                from dual
                union all
                select (select nvl(max(req_id),0)+1 from mis.ss_program) req_id,'SSBN'||(select substr('$request->mon',-2,2)||'-1' from dual) bill_no
                from dual
                where not exists (select ss_prog from mis.ss_program where ss_prog = 'BILL' and substr(month_of_prog,-2,2) = substr('$request->mon',-2,2))
                ) where bill_no is not null
");

                $insert_program_data = DB::insert('

            insert into MIS.SS_PROGRAM (
            MONTH_OF_PROG,
            REQ_ID,
            BILL_NO,
            SS_PROG,
            GM_NAME,
            SM_NAME,
            DSM_NAME,
            RM_TERR_ID,
            RM_NAME,
            AM_TERR_ID,
            AM_NAME,
            MPO_TERR_ID,
            MPO_NAME ,
            MPO_TEAM,
            DEPOT_ID,
            DEPOT_NAME,
            CONTACT_PERSON,
            MOBILE,
            PROG_TEAM,
            PROGRAM_TYPE,
            PROGRAM_VENUE,

            ADVANCE_BUDGET,
            NOP_PROPOSED,
            COST_PER_HEAD,
            CREATE_USER,
            create_date,
            PROG_DATE_TIME,
            BRAND_NAME,
            NOP_ATTENDED,
            PROGRAM_FEEDBACK,
            ACTUAL_EXPENDITURE,
              PROGRAM_DETAILS,
            PM
            )
            values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
                    [$request->mon, $resp[0]->req_id, $resp[0]->bill_no, 'BILL', $request->gm, $request->sm, $request->dsm, $request->rm_terr, $request->rm_name,
                        $request->am_terr, $request->am_name, $request->mpo_terr, $request->mpo_name,
                        $request->mpo_team, $request->depot_id, $request->depot_name,
                        $request->cp, $request->mobile, $request->program_team, $request->program_type, $request->program_venue,
                        $request->advance_budget, $request->nop, $request->cph, $uid, $systime, $timing, $request->brand_name,
                        $request->nop_attended, $request->program_feedback, $request->actual_expending,$request->iad,$request->pmr]
                );

                $insert_budget_data = json_decode($request->insertBudget);

                foreach ($insert_budget_data as $insert_budget) {
                    $insert_data_budget = DB::INSERT("insert into mis.SS_BUDGET_DETAILS (   BILL_NO ,
            CC_TEAM_NAME,
            GL ,
            COST_CENTER_ID ,
            BILL_AMT,CREATE_USER,CREATE_DATE)
            values (?,?,?,?,?,?,?)",
                        [$resp[0]->bill_no, $insert_budget->team, $insert_budget->gl,
                            $insert_budget->cc, $insert_budget->amount, $uid, $systime]);
                }

                $insert_cost_data = json_decode($request->insertCost);

                foreach ($insert_cost_data as $insert_cost) {
                    $insert_data_cost = DB::INSERT("insert into mis.SS_COST_DETAILS ( BILL_NO ,
            CI_NAME,BILL_AMT,CREATE_USER,CREATE_DATE)
            values (?,?,?,?,?)",
                        [$resp[0]->bill_no, $insert_cost->item, $insert_cost->cost_amount, $uid, $systime]);
                }

            }

            } catch (Oci8Exception $e) {
                $insert_proc = $e->getMessage();
            }

            return response()->json(['exception_catch' => $insert_proc, 'program' => $insert_program_data
                , 'budget' => $insert_data_budget, 'cost' => $insert_data_cost, 'program_no' => $resp,'flag' => $flag , 'cc' => $cost_center ]);
        }

    }

    public function save_button_program_bill(Request $request)
    {

        $uid = Auth::user()->user_id;
        $systime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
        $timing = Carbon::parse($request->timing)->format('Y/m/d H:i:s');
        $insert_proc = '';
        $insert_program_data = '';
        $insert_data_budget = '';
        $insert_data_cost = '';
        $resp = '';
        $flag = true;
        $cost_center = array();
        $program_no = '';

        if ($request->ajax()) {

            $insert_budget_data = json_decode($request->insertBudget);

            foreach ($insert_budget_data as $insert_budget) {

                $bud_data = DB::Select("select ava_bud_amt from
                        MIS.SCIENTIFIC_SEMINAR_EXPENSE_RM
                        where expense_month = '$request->mon'
                        and gl = '$insert_budget->gl'
                        and cost_center_id = '$insert_budget->cc'
                                    ");

                if (count($bud_data) > 0){

                    if($insert_budget->amount > $bud_data[0]->ava_bud_amt ){
                        $flag = false;
                        $cost_center[] = $insert_budget->team ;
                    }
                }

                else{
                    $flag = false;
                    $cost_center[] = $insert_budget->team ;
                }

            }

            try {
                if($flag){

                $resp = DB::Select("
                
                select req_id,bill_no
                from(
                select (select max(nvl(req_id,0))+1 from mis.ss_program where substr(month_of_prog,-2,2) = substr('$request->mon',-2,2) ) req_id,
                (select distinct substr(bill_no,1,instr(bill_no,'-',1,1)-1)||'-'||       
                (select max(to_number(substr(bill_no,instr(bill_no,'-',-1,1)+1)))+1 from mis.ss_program where ss_prog = 'BILL'
                and substr(month_of_prog,-2,2) = substr('$request->mon',-2,2)) 
                from mis.ss_program where ss_prog = 'BILL'and substr(month_of_prog,-2,2) = substr('$request->mon',-2,2)) bill_no 
                from dual
                union all
                select (select nvl(max(req_id),0)+1 from mis.ss_program) req_id,'SSBN'||(select substr('$request->mon',-2,2)||'-1' from dual) bill_no
                from dual
                where not exists (select ss_prog from mis.ss_program where ss_prog = 'BILL' and substr(month_of_prog,-2,2) = substr('$request->mon',-2,2))
                ) where bill_no is not null

                ");

                $bill_no = $resp[0]->bill_no;

                $insert_program_data = DB::insert('

            insert into MIS.SS_PROGRAM (
            MONTH_OF_PROG,
            REQ_ID,
            BILL_NO,
            SS_PROG,
            GM_NAME,
            SM_NAME,
            DSM_NAME,
            RM_TERR_ID,
            RM_NAME,
            AM_TERR_ID,
            AM_NAME,
            MPO_TERR_ID,
            MPO_NAME ,
            MPO_TEAM,
            DEPOT_ID,
            DEPOT_NAME,
            CONTACT_PERSON,
            MOBILE,
            PROG_TEAM,
            PROGRAM_TYPE,
            PROGRAM_VENUE,

            ADVANCE_BUDGET,
            NOP_PROPOSED,
            COST_PER_HEAD,
            CREATE_USER,
            create_date,
            PROG_DATE_TIME,
            BRAND_NAME,
            NOP_ATTENDED,
            PROGRAM_FEEDBACK,
            ACTUAL_EXPENDITURE,
            PROG_NO,
            PAYABLE_REFUNDABLE,
             PROGRAM_DETAILS,
            PM
        
            )
            values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
                    [$request->mon, $resp[0]->req_id, $resp[0]->bill_no, 'BILL', $request->gm, $request->sm, $request->dsm, $request->rm_terr, $request->rm_name,
                        $request->am_terr, $request->am_name, $request->mpo_terr, $request->mpo_name,
                        $request->mpo_team, $request->depot_id, $request->depot_name,
                        $request->cp, $request->mobile, $request->program_team, $request->program_type, $request->program_venue,
                        $request->advance_budget, $request->nop, $request->cph, $uid, $systime, $timing, $request->brand_name,
                        $request->nop_attended, $request->program_feedback, $request->actual_expending, $request->program_no, $request->payable,
                        $request->iad,$request->pmr]
                );


                $insert_budget_data = json_decode($request->insertBudget);

                foreach ($insert_budget_data as $insert_budget) {

                    $insert_data_budget = DB::update("
                                update mis.SS_BUDGET_DETAILS
                                set 
                                BILL_NO = ?,
                                BILL_AMT = ?
                                where PROG_NO = ?
                                and   GL = ?
                                and COST_CENTER_ID = ?
                                            ", [$bill_no,
                        $insert_budget->amount,
                        $request->program_no, $insert_budget->gl, $insert_budget->cc]);

                }

                $insert_cost_data = json_decode($request->insertCost);

                foreach ($insert_cost_data as $insert_cost) {

                    $insert_data_cost = DB::update("
                                update mis.SS_COST_DETAILS
                                set 
                                BILL_NO = '$bill_no',
                                BILL_AMT = '$insert_cost->cost_amount'
                                where PROG_NO = '$request->program_no'
                                and CI_NAME = '$insert_cost->item'
                                            ");

                }

                    $program_no = DB::select("
                select prog_no
                from(
                select prog_no
                from mis.ss_program_app
                where create_user = '$uid'
                and bill_no is null
                minus
                select prog_no
                from mis.ss_program_app
                where create_user = '$uid'
                and bill_no is not null)
        ");

            }

            } catch (Oci8Exception $e) {
                $insert_proc = $e->getMessage();
            }

            return response()->json(['prog_no' => $program_no,'exception_catch' => $insert_proc, 'program' => $insert_program_data
                , 'budget' => $insert_data_budget, 'cost' => $insert_data_cost, 'program_no' => $resp , 'flag' => $flag , 'cc' => $cost_center ]);
        }

    }

    public function verify_data_show(Request $request)
    {

        $program_info = DB::select("
                select * from MIS.ss_program_app
                where bill_no = '$request->bill'
               
        ");

        $budget_details = DB::select("
                select * from MIS.ss_budget_details_app
                where bill_no = '$request->bill'
        ");

        $cost_details = DB::select("              
                select * from MIS.ss_cost_details_app
                where bill_no = '$request->bill'
        ");

        return response()->json(['program_info' => $program_info, 'budget_details' => $budget_details, 'cost_details' => $cost_details]);

    }

    public function verify_update(Request $request)
    {

        $systime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
        $timing = Carbon::parse($request->timing)->format('Y/m/d H:i:s');

        $uid = Auth::user()->user_id;

        $update_verification_column = '';

        $data_mail = [];

        $data_mail = DB::SELECT("
              select rm_terr_id, rm_name, program_venue, prog_team,bill_no
           from 
           MIS.SS_PROGRAM_APP
           where bill_no= '$request->bill'
                                and ss_prog ='BILL'
            ");

//            dd($data_mail);

        if (Auth::user()->urole == '3' || Auth::user()->urole == '4'){

            $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set ssd_emp_id = '$uid',
                                ssd_checked_date = (select sysdate from dual)
                                where bill_no = '$request->bill'
                                and ss_prog ='BILL'
                    ");
        }



        if (Auth::user()->desig === 'DSM') {

            $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set dsm_emp_id= '$uid',
                                prog_date_time = '$timing',
                                dsm_checked_date= (select sysdate from dual)
                                where bill_no= '$request->bill'
                                 and ss_prog ='BILL'
                    ");

        }

        if (Auth::user()->desig === 'SM') {

            $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set sm_emp_id= '$uid',
                                prog_date_time = '$timing',
                                sm_checked_date= (select sysdate from dual)
                                where bill_no= '$request->bill'
                                 and ss_prog ='BILL'
                    ");

        }

        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {

            $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set rm_emp_id= '$uid',
                                rm_checked_date= (select sysdate from dual),
                                prog_date_time = '$timing'
                                where bill_no= '$request->bill'
                                and ss_prog ='BILL'
                    ");

            $program_team = DB::select("
                                select prog_team from mis.ss_program_app  where bill_no= '$request->bill'
                                and ss_prog ='BILL'
            
            ");

            if($program_team[0]->prog_team == 'AHVD'){


            }

            else{

                $medical_service_emp = DB::SELECT("
                               select distinct email from MIS.SS_MEDICAL_SERVICE_EMP
                    ");
                $array = [];
                $max = sizeof($medical_service_emp);

                for ($x = 0; $x < $max; $x++) {
                    $array[$x] = $medical_service_emp[$x]->email;
                }


                $imploded_email = implode(",", $array);
//        dd($imploded_email);

                if(!empty($data_mail)){
//            $data = array('data_mail',$data_mail);

                    Mail::send(['html' => 'scientific.bill_mail'],['data_mail' => $data_mail ], function ($message) use ($imploded_email) {
//                Log::info($data_mail);
                        $message->to(explode(',', $imploded_email));
                        $message->subject("Scientific Seminar Bill Verfication");
                        $message->from('missoft@inceptapharma.com', 'MIS');
                    });

                }


            }

        }

        if (Auth::user()->desig === 'AM' ||Auth::user()->desig === 'Sr. AM') {

            $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set am_emp_id= '$uid',
                                am_checked_date= (select sysdate from dual),
                                prog_date_time = '$timing'
                                where bill_no= '$request->bill'
                                and ss_prog ='BILL'
                    ");

        }

        if ($uid == '1002858') {

            $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set msd_manager_emp_id = '$uid',
                                prog_date_time = '$timing',
                                msd_manager_checked_date = (select sysdate from dual)
                                where bill_no = '$request->bill'
                                and ss_prog ='BILL'
                    ");

            $medical_service_emp = DB::SELECT("
                    select distinct group_head_email from mis.ss_program_team
                    where prog_team_name = '$request->program_team' 
                    ");


            $array = [];
            $max = sizeof($medical_service_emp);

            for ($x = 0; $x < $max; $x++) {
                $array[$x] = $medical_service_emp[$x]->group_head_email;
            }

            $imploded_email = implode(",", $array);

            if(!empty($data_mail)){

                Mail::send(['html' => 'scientific.proposal_mail'],['data_mail' => $data_mail ], function ($message) use ($imploded_email) {

                    $message->to(explode(',', $imploded_email));
                    $message->subject("Scientific Seminar Proposal Verfication");
                    $message->from('missoft@inceptapharma.com', 'MIS');
                });

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
            )
                            ");

//            dd(count($type));

        if (count($type) > 0) {

            if ($type[0]->emp_type == 'MEDICAL SERVICE') {

                $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set ms_emp_id= '$uid',
                                prog_date_time = '$timing',
                                ms_checked_date= (select sysdate from dual)
                                where bill_no= '$request->bill'
                                and ss_prog ='BILL'
                    ");



                if($request->program_team == 'SPECIAL'){

                    $medical_service_emp = DB::SELECT("
                    select distinct email as group_head_email from mis.ss_msd_emp
                
                    ");

                }

                else if($request->program_team == 'HUMAN VACCINE'){

                    $medical_service_emp = DB::SELECT("
                     select 'farhana@inceptapharma.com' group_head_email from dual
                
                    ");

                }

                else{

                    $medical_service_emp = DB::SELECT("
                    select distinct group_head_email from mis.ss_program_team
                    where prog_team_name = '$request->program_team' 
                    ");
                }



                $array = [];
                $max = sizeof($medical_service_emp);

                for ($x = 0; $x < $max; $x++) {
                    $array[$x] = $medical_service_emp[$x]->group_head_email;
                }

                $imploded_email = implode(",", $array);
//        dd($imploded_email);

                if(!empty($data_mail)){
//            $data = array('data_mail',$data_mail);

                    Mail::send(['html' => 'scientific.bill_mail'],['data_mail' => $data_mail ], function ($message) use ($imploded_email) {
                        $message->to(explode(',', $imploded_email));
                        $message->subject("Scientific Seminar Bill Verfication");
                        $message->from('missoft@inceptapharma.com', 'MIS');
                    });

                }


            }

            if ($type[0]->emp_type == 'MSD') {

                $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set msd_manager_emp_id = '$uid',
                                prog_date_time = '$timing',
                                msd_manager_checked_date = (select sysdate from dual)
                                where bill_no = '$request->bill'
                                and ss_prog ='BILL'
                    ");

                $medical_service_emp = DB::SELECT("
                    select distinct group_head_email from mis.ss_program_team
                    where prog_team_name = '$request->program_team' 
                    ");


                $array = [];
                $max = sizeof($medical_service_emp);

                for ($x = 0; $x < $max; $x++) {
                    $array[$x] = $medical_service_emp[$x]->group_head_email;
                }

                $imploded_email = implode(",", $array);
//        dd($imploded_email);

                if(!empty($data_mail)){
//            $data = array('data_mail',$data_mail);

                    Mail::send(['html' => 'scientific.proposal_mail'],['data_mail' => $data_mail ], function ($message) use ($imploded_email) {
//                Log::info($data_mail);
                        $message->to(explode(',', $imploded_email));
                        $message->subject("Scientific Seminar Proposal Verfication");
                        $message->from('missoft@inceptapharma.com', 'MIS');
                    });

                }

            }

            if ($type[0]->emp_type == 'GROUP HEAD') {

                $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set GROUP_HEAD_EMP_ID = '$uid',
                                prog_date_time = '$timing',
                                GROUP_HEAD_CHECKED_DATE = (select sysdate from dual)
                                where bill_no= '$request->bill'
                                and ss_prog ='BILL'
                    ");

                $medical_service_emp = DB::SELECT("
                    select distinct gm_email from mis.ss_program_team
                    where prog_team_name = '$request->program_team' 
                    ");
                $array = [];
                $max = sizeof($medical_service_emp);

                for ($x = 0; $x < $max; $x++) {
                    $array[$x] = $medical_service_emp[$x]->gm_email;
                }

                $imploded_email = implode(",", $array);
//        dd($imploded_email);

                if(!empty($data_mail)){
//            $data = array('data_mail',$data_mail);

                    Mail::send(['html' => 'scientific.bill_mail'],['data_mail' => $data_mail ], function ($message) use ($imploded_email) {
//                Log::info($data_mail);
                        $message->to(explode(',', $imploded_email));
                        $message->subject("Scientific Seminar Bill Verfication");
                        $message->from('missoft@inceptapharma.com', 'MIS');
                    });

                }

            }

            if ($type[0]->emp_type == 'GM SALES') {

                $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set GM_SALES_EMP_ID = '$uid',
                                GM_SALES_CHECKED_DATE = (select sysdate from dual)
                                where bill_no= '$request->bill'
                                and ss_prog ='BILL'
                    ");

            }


            if ($type[0]->emp_type == 'GM MSD') {

                $update_verification_column = DB::UPDATE("
                                update mis.ss_program_app
                                set GM_MSD_EMP_ID = '$uid',
                                GM_MSD_CHECKED_DATE = (select sysdate from dual)
                                where bill_no= '$request->bill'
                                and ss_prog ='BILL'
                    ");

            }


        }

        return response()->json(['cost' => $update_verification_column]);

    }

    public function delete_button(Request $request)
    {
        $uid = Auth::user()->user_id;

        $program = DB::select("
         select prog_no from mis.ss_program_app where bill_no = '$request->req_no'
                    and ss_prog = 'BILL'
        ");


        if($program[0]->prog_no == null){

            $insert_action = DB::delete("
                    insert into mis.ss_program_delete
                                (
                                REQ_ID,        
                                MONTH_OF_PROG,   
                                SS_PROG,          
                                PROG_TEAM,         
                                PROG_NO   ,       
                                BILL_NO    ,      
                                PROGRAM_DETAILS, 
                                PROGRAM_TYPE    ,          
                                PROGRAM_VENUE    ,      
                                NOP_PROPOSED      ,      
                                NOP_ATTENDED       ,      
                                PROG_DATE_TIME      ,      
                                PROGRAM_FEEDBACK     ,     
                                BRAND_NAME            ,    
                                ADVANCE_BUDGET         ,
                                COST_PER_HEAD             ,
                                ADVANCE_RECEIVED          ,
                                ACTUAL_EXPENDITURE        ,
                                PAYABLE_REFUNDABLE        ,
                                GM_NAME                 , 
                                SM_NAME              ,
                                DSM_NAME              ,   
                                RM_TERR_ID             ,  
                                RM_NAME                ,
                                AM_TERR_ID              ,
                                AM_NAME                 ,
                                MPO_TERR_ID            ,
                                MPO_NAME             ,
                                DEPOT_ID            ,
                                DEPOT_NAME           ,  
                                MPO_TEAM              ,  
                                CONTACT_PERSON         ,  
                                MOBILE                  , 
                                CREATE_USER              ,
                                CREATE_DATE           ,
                                AM_EMP_ID              , 
                                AM_CHECKED_DATE      ,
                                RM_EMP_ID             , 
                                RM_CHECKED_DATE        ,
                                DSM_EMP_ID              , 
                                DSM_CHECKED_DATE         ,
                                SM_EMP_ID                ,
                                SM_CHECKED_DATE        ,
                                MS_EMP_ID               ,
                                MS_CHECKED_DATE          , 
                                MSD_MANAGER_EMP_ID        ,
                                MSD_MANAGER_CHECKED_DATE  ,
                                GROUP_HEAD_EMP_ID        ,
                                GROUP_HEAD_CHECKED_DATE   ,
                                GM_SALES_EMP_ID           ,
                                GM_SALES_CHECKED_DATE    ,
                                GM_MSD_EMP_ID            ,
                                GM_MSD_CHECKED_DATE     ,
                                SSD_EMP_ID              ,
                                SSD_CHECKED_DATE         ,
                                PM            ,
                                DELETE_USER_ID          ,
                                DELETE_DATE             
                                )
                    
                    select d.*,'$uid',(select sysdate from dual)
                    from mis.ss_program_app d
                    where bill_no = '$request->req_no'
                    and ss_prog ='BILL'
                 ");

            DB::delete("delete from mis.ss_budget_details_app    where bill_no = '$request->req_no'
                   ");

            DB::delete("delete from mis.ss_cost_details_app    where bill_no = '$request->req_no'
                     ");


            $delete_action = DB::delete("delete from mis.ss_program_app    where bill_no = '$request->req_no'
                    and ss_prog ='BILL'  ");

        }

        else{

            $insert_action = DB::delete("
                    insert into mis.ss_program_delete
                                (
                                REQ_ID,        
                                MONTH_OF_PROG,   
                                SS_PROG,          
                                PROG_TEAM,         
                                PROG_NO   ,       
                                BILL_NO    ,      
                                PROGRAM_DETAILS, 
                                PROGRAM_TYPE    ,          
                                PROGRAM_VENUE    ,      
                                NOP_PROPOSED      ,      
                                NOP_ATTENDED       ,      
                                PROG_DATE_TIME      ,      
                                PROGRAM_FEEDBACK     ,     
                                BRAND_NAME            ,    
                                ADVANCE_BUDGET         ,
                                COST_PER_HEAD             ,
                                ADVANCE_RECEIVED          ,
                                ACTUAL_EXPENDITURE        ,
                                PAYABLE_REFUNDABLE        ,
                                GM_NAME                 , 
                                SM_NAME              ,
                                DSM_NAME              ,   
                                RM_TERR_ID             ,  
                                RM_NAME                ,
                                AM_TERR_ID              ,
                                AM_NAME                 ,
                                MPO_TERR_ID            ,
                                MPO_NAME             ,
                                DEPOT_ID            ,
                                DEPOT_NAME           ,  
                                MPO_TEAM              ,  
                                CONTACT_PERSON         ,  
                                MOBILE                  , 
                                CREATE_USER              ,
                                CREATE_DATE           ,
                                AM_EMP_ID              , 
                                AM_CHECKED_DATE      ,
                                RM_EMP_ID             , 
                                RM_CHECKED_DATE        ,
                                DSM_EMP_ID              , 
                                DSM_CHECKED_DATE         ,
                                SM_EMP_ID                ,
                                SM_CHECKED_DATE        ,
                                MS_EMP_ID               ,
                                MS_CHECKED_DATE          , 
                                MSD_MANAGER_EMP_ID        ,
                                MSD_MANAGER_CHECKED_DATE  ,
                                GROUP_HEAD_EMP_ID        ,
                                GROUP_HEAD_CHECKED_DATE   ,
                                GM_SALES_EMP_ID           ,
                                GM_SALES_CHECKED_DATE    ,
                                GM_MSD_EMP_ID            ,
                                GM_MSD_CHECKED_DATE     ,
                                SSD_EMP_ID              ,
                                SSD_CHECKED_DATE         ,
                                PM            ,
                                DELETE_USER_ID          ,
                                DELETE_DATE             
                                )
                    
                    select d.*,'$uid',(select sysdate from dual)
                    from mis.ss_program_app d
                    where bill_no = '$request->req_no'
                    and ss_prog ='BILL'
                 ");

            DB::update("update mis.ss_budget_details_app set bill_no='',bill_amt =''  where bill_no = '$request->req_no'
                   ");

            DB::update("update  mis.ss_cost_details_app  set bill_no='',bill_amt =''  where bill_no = '$request->req_no'
                     ");

            $delete_action = DB::delete("delete from mis.ss_program_app    where bill_no = '$request->req_no'
                    and ss_prog ='BILL'  ");

        }



        return response()->json($delete_action);

    }

}