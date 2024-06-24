<?php

namespace App\Http\Controllers;

use App\Expense_summary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use DB;
use PdfReport;
use App\Employee_expense;
use Maatwebsite\Excel\Excel;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;
use Illuminate\Support\Facades\Session;

class Expense_Report_Controller extends Controller
{

      //field expense
    public function get_field_expense_view()
    {

        $proc_month = DB::select("select trunc(sysdate,'MM') exp_month,to_char(sysdate,'MON-RR') mon
                                    from dual
                                    union all
                                    select trunc(trunc(sysdate,'MM')-1,'MM') exp_month,to_char(trunc(sysdate,'MM')-1,'MON-RR') mon
                                    from dual
                                    union all
                                    select trunc(trunc(trunc(sysdate,'MM')-1,'MM')-1,'MM') exp_month,to_char(trunc(trunc(sysdate,'MM')-1,'MM')-1,'MON-RR') mon
                                    from dual");


        // $exp_month = DB::select("Select distinct exp_month, to_char(exp_month,'MON-RR') mon
        //                           from mis.expense_employee");

         $exp_month = DB::select("Select trunc(sysdate,'MM') exp_month,to_char(sysdate,'MON-RR') mon
                                    from dual
                                    union all
                                    select trunc(trunc(sysdate,'MM')-1,'MM') exp_month,to_char(trunc(sysdate,'MM')-1,'MON-RR') mon
                                    from dual
                                    union all
                                    select trunc(trunc(trunc(sysdate,'MM')-1,'MM')-1,'MM') exp_month,to_char(trunc(trunc(sysdate,'MM')-1,'MM')-1,'MON-RR') mon
                                    from dual");

        return view('expense.field_expense_view')
            ->with('months', $exp_month)->with('pmonths',$proc_month);
    }

    public function process_emp_exp_data(Request $request){

//        $dt = Carbon::parse($request['exp_mon'])->format('Y-m-d');
        $status = '';
        $result = '';

        if($request['p_type'] == 'expense')
        {
            $procedure = 'MIS.PRO_EXPENSE_EMPLOYEE';
            $bindings = [
                'expense_month' => $request['exp_mon']
            ];

            try{
                $result = DB::executeProcedure($procedure,$bindings);
                $status = 'done';
            }catch (Oci8Exception $e){
                $status = $e->getMessage();
            }
        }
        elseif ($request['p_type'] == 'summary')
        {
            $procedure = 'MIS.PRO_EXPENSE_SUMMARY';
            $bindings = [
                'expense_month' => $request['exp_mon']
            ];

            try{
                $result = DB::executeProcedure($procedure,$bindings);
                $status = 'done';
            }catch (Oci8Exception $e){
                $status = $e->getMessage();
            }

        }

        return response()->json(['message_status'=>$status,'result'=>$result]);
    }

    public function display_expense_report(Request $request)
    {
        if($request->input('r_type') == 'expense') {
            $checkval = $request->input('cgroup');

            $month = $request->input('exp_mon');

            if ($checkval[0] == 'pdf') {

                $depot = Employee_expense::distinct()
                    ->select(['d_id', 'depot_name'])
                    ->where('exp_month', $request->input('exp_mon'))
                    ->get();

                $gm_pgroup = Employee_expense::distinct()
                    ->select(['d_id', 'depot_name', 'gm_id', 'p_group'])
                    ->where('exp_month', $request->input('exp_mon'))
                    ->orderBy('d_id','asc')
                    ->orderBy('gm_id','asc')
                    ->get();

                $rm_asm_info = Employee_expense::select(['d_id', 'depot_name', 'gm_id', 'P_GROUP', 'base', 'RM_ASM_EMP_ID', 'RM_ASM_NAME',
                    'rm_asm_id', 'DESIG', 'desig_sl', 'EXP_APP', 'EXP_REC', 'DEDUCTION', 'SERIAL'])
                    ->where('exp_month', $request->input('exp_mon'))
                    ->orderBy('d_id', 'asc')
                    ->orderBy('serial', 'asc')
                    ->get();

                $mpo_info = Employee_expense::select(['d_id', 'depot_name', 'gm_id', 'P_GROUP', 'base', 'rm_asm_id', 'EMP_ID', 'emp_NAME',
                    'terr_id', 'DESIG', 'desig_sl', 'EXP_APP', 'EXP_REC', 'DEDUCTION', 'SERIAL'])
                    ->where('exp_month', $request->input('exp_mon'))
                    ->orderBy('d_id', 'asc')
                    ->orderBy('serial', 'asc')
                    ->get();

                $pdf = \PDF::loadView('expense.pdf_layout.expense', ['depot_data' => $depot, 'gm_wise_pgrp' => $gm_pgroup,
                    'rm_asm' => $rm_asm_info, 'mpo_info' => $mpo_info,'exp_mon' => $request->input('exp_mon')]);

                return $pdf->stream('Field_expense.pdf');


            }


            else {

                $depot_sales = Employee_expense::distinct()
                    ->select(['d_id', 'depot_name'])
                    ->where('exp_month', $request->input('exp_mon'))
                    ->whereNotIn('p_group', array('ANIMAL HEALTH & VACCINE DIVISION','HOSPICARE','HYGIENE'))
                    ->get();

                $depot_msd = Employee_expense::distinct()
                    ->select(['d_id', 'depot_name'])
                    ->where('exp_month', $request->input('exp_mon'))
                    ->whereIn('p_group', array('ANIMAL HEALTH & VACCINE DIVISION','HOSPICARE','HYGIENE'))
                    ->get();

                $gm_pgroup = Employee_expense::distinct()
                    ->select(['d_id', 'depot_name', 'gm_id', 'p_group'])
                    ->where('exp_month', $request->input('exp_mon'))
                    ->orderBy('d_id','asc')
                    ->orderBy('gm_id','asc')
                    ->get();

                $gm_pgroup_sales = DB::select("
                                select distinct d_id, depot_name, gm_id, p_group
                                from mis.expense_employee
                                where exp_month = '$month'
                                and p_group not in ( 'ANIMAL HEALTH & VACCINE DIVISION','HOSPICARE','HYGIENE')
                                    ");

                $gm_pgroup_msd = DB::select("
                                select distinct d_id, depot_name, gm_id, p_group
                                from mis.expense_employee
                                where exp_month = '$month'
                                and p_group  in ( 'ANIMAL HEALTH & VACCINE DIVISION','HOSPICARE','HYGIENE')
                                    ");

                $rm_asm_info = Employee_expense::select(['d_id', 'depot_name', 'gm_id', 'P_GROUP', 'base', 'RM_ASM_EMP_ID', 'RM_ASM_NAME',
                    'rm_asm_id', 'DESIG', 'desig_sl', 'EXP_APP', 'EXP_REC', 'DEDUCTION', 'SERIAL'])
                    ->where('exp_month', $request->input('exp_mon'))
                    ->orderBy('d_id', 'asc')
                    ->orderBy('serial', 'asc')
                    ->get();

                $mpo_info = Employee_expense::select(['d_id', 'depot_name', 'gm_id', 'P_GROUP', 'base', 'rm_asm_id', 'EMP_ID', 'emp_NAME',
                    'terr_id', 'DESIG', 'desig_sl', 'EXP_APP', 'EXP_REC', 'DEDUCTION', 'SERIAL'])
                    ->where('exp_month', $request->input('exp_mon'))
                    ->orderBy('d_id', 'asc')
                    ->orderBy('serial', 'asc')
                    ->get();

                $mpo_info_msd = Employee_expense::select(['d_id', 'depot_name', 'gm_id', 'P_GROUP', 'base', 'rm_asm_id', 'EMP_ID', 'emp_NAME',
                    'terr_id', 'DESIG', 'desig_sl', 'EXP_APP', 'EXP_REC', 'DEDUCTION', 'SERIAL'])
                    ->where('exp_month', $request->input('exp_mon'))
                    ->whereIn('p_group', array('ANIMAL HEALTH & VACCINE DIVISION','HOSPICARE','HYGIENE'))
                    ->orderBy('d_id', 'asc')
                    ->orderBy('serial', 'asc')
                    ->get();

                $mpo_info_sales = Employee_expense::select(['d_id', 'depot_name', 'gm_id', 'P_GROUP', 'base', 'rm_asm_id', 'EMP_ID', 'emp_NAME',
                    'terr_id', 'DESIG', 'desig_sl', 'EXP_APP', 'EXP_REC', 'DEDUCTION', 'SERIAL'])
                    ->where('exp_month', $request->input('exp_mon'))
                    ->whereNotIn('p_group', array('ANIMAL HEALTH & VACCINE DIVISION','HOSPICARE','HYGIENE'))
                    ->orderBy('d_id', 'asc')
                    ->orderBy('serial', 'asc')
                    ->get();

                if($request->input('d_type') == 'SALES'){

                    $data = ['depot_data' => $depot_sales, 'gm_wise_pgrp' => $gm_pgroup_sales,
                        'rm_asm' => $rm_asm_info, 'mpo_info' => $mpo_info_sales,'exp_mon' => $request->input('exp_mon')];

                }
                else{

                    $data = ['depot_data' => $depot_msd, 'gm_wise_pgrp' => $gm_pgroup_msd,
                        'rm_asm' => $rm_asm_info, 'mpo_info' => $mpo_info_msd,'exp_mon' => $request->input('exp_mon')];

                }

                \Excel::create('Field Expense', function ($excel) use ($data) {

                    $excel->sheet('Expense Data', function ($sheet) use ($data) {
                        $sheet->loadView('expense.excel_layout.expensev', $data);
                        $sheet->setWidth(array(
                            'A' => 5,
                            'B' => 20,
                            'D' => 30,
                            'F' => 10,
                            'G' => 10,
                            'H' => 14,
                            'I' => 14
                        ));
                    });

                })->export('xls');

            }
        }

        elseif ($request->input('r_type') == 'summary'){

            $checkval = $request->input('cgroup');
            if($checkval[0] == 'pdf'){

                $sum_data = Expense_summary::select(['depot_name','gm1_noe', 'gm2_noe', 'gm_ast_noe',
                    'gm_gyr_noe', 'gm_op_noe', 'gm_xeno_noe',
                    'gm_oth_noe', 'total_noe', 'gm1_noe_value',
                    'gm2_noe_value', 'gm_ast_noe_value', 'gm_gyr_noe_value',
                    'gm_op_noe__value', 'gm_xeno_noe_value', 'gm_oth_noe_value',
                    'total_noe_value', 'total_noe_prev_value', 'incr_decr'])
                    ->where('exp_month',$request['exp_mon'])
                    ->orderBy('depot_name','asc')
                    ->get();

                $month = $request->input('exp_mon');
                $total_sum = DB::select("select s1,s2,s3,s4,s5,s6,s7,s8,s9,s10,s11,s12,s13,s14
                                    from(
                                    select sum(nvl(gm1_noe,0)) s1,sum(nvl(gm2_noe,0)) s2,sum(nvl(gm_ast_noe,0)) s3,sum(nvl(gm_gyr_noe,0)) s4,sum(nvl(gm_op_noe,0)) s5,sum(nvl(gm_oth_noe,0)) s6,
                                           sum(nvl(total_noe,0)) s7,sum(nvl(gm1_noe_value,0)) s8,sum(nvl(gm2_noe_value,0)) s9,sum(nvl(gm_ast_noe_value,0)) s10,sum(nvl(gm_gyr_noe_value,0)) s11,
                                           sum(nvl(gm_op_noe__value,0)) s12,sum(nvl(gm_oth_noe_value,0)) s13, sum(nvl(total_noe_value,0)) s14
                                    from MIS.EXPENSE_SUMMARY
                                    where exp_month = '$month'
                                    )");

                $pdf = \PDF::loadView('expense.pdf_layout.summary', ['sdata' => $sum_data, 'tdata' => $total_sum,'exp_mon' => $request->input('exp_mon')]);

                return $pdf->setPaper('a4','landscape')->stream('Field_exp_summary.pdf');

            }

            else{

                    $month = $request->input('exp_mon');

                $sum_data = DB::select("
                                                   
                                        select       
                                        depot_id, depot_name, data_type,gm1_general ,gm1_hvc  , gm2_agl , gm2_opexen ,gm3_ahv ,gm3_hygiene ,gm3_hosp,
                                        gm1_general_val ,gm1_hvc_val,gm2_agl_val,gm2_opexen_val ,gm3_ahv_val ,gm3_hygiene_val, gm3_hosp_val                       
                                        from expense_summary_depot
                                        where exp_month = '$month'
                                        and data_type = 'DEPOT DETAILS'
                                        order by  depot_id
                
                ");


                $total_sum = DB::select("
                                select       
                                    depot_id, depot_name, data_type,gm1_general ,gm1_hvc  , gm2_agl , gm2_opexen ,gm3_ahv ,gm3_hygiene ,gm3_hosp,
                                    gm1_general_val ,gm1_hvc_val,gm2_agl_val,gm2_opexen_val ,gm3_ahv_val ,gm3_hygiene_val, gm3_hosp_val
                                    from expense_summary_depot
                                where exp_month = '$month'
                                and data_type = 'DEPOT TOTAL'
                                    ");
                $pdt = DB::select("
                                select       
                                 depot_id, depot_name, data_type,gm1_general ,gm1_hvc  , gm2_agl , gm2_opexen ,gm3_ahv ,gm3_hygiene ,gm3_hosp,
                                gm1_general_val ,gm1_hvc_val,gm2_agl_val,gm2_opexen_val ,gm3_ahv_val ,gm3_hygiene_val, gm3_hosp_val                      
                                from expense_summary_depot
                                where exp_month = '$month'
                                and data_type = 'PREVIOUS DEPOT TOTAL'
                                    ");

                $dincr = DB::select("
                                select       
                                 depot_id, depot_name, data_type,gm1_general ,gm1_hvc  , gm2_agl , gm2_opexen ,gm3_ahv ,gm3_hygiene ,gm3_hosp,
                                gm1_general_val ,gm1_hvc_val,gm2_agl_val,gm2_opexen_val ,gm3_ahv_val ,gm3_hygiene_val, gm3_hosp_val                       
                                from expense_summary_depot
                                where exp_month = '$month'
                                and data_type = 'DEPOT INCR_DCR'
                                    ");

                $depot_total = DB::select("
                                select 
                                nvl(gm1_general_val,0) +  nvl(gm1_hvc_val,0)  +  nvl(gm2_agl_val,0) + nvl(gm2_opexen_val,0) +  nvl(gm3_ahv_val,0) + nvl(gm3_hygiene_val,0) +  nvl(gm3_hosp_val,0) as depot_total
                                from expense_summary_depot
                                where exp_month = '$month'
                                and data_type = 'DEPOT TOTAL'
                                    ");

                $depot_total_sales = DB::select("
                                select 
                                nvl(gm1_general_val,0) +  nvl(gm1_hvc_val,0) +  nvl(gm2_agl_val,0) + nvl(gm2_opexen_val,0)   as depot_total
                                from expense_summary_depot
                                where exp_month = '$month'
                                and data_type = 'DEPOT TOTAL'
                                    ");

                $depot_total_msd = DB::select("
                                select 
                                 nvl(gm3_hosp_val,0) +  nvl(gm3_ahv_val,0) + nvl(gm3_hygiene_val,0) as depot_total
                                from expense_summary_depot
                                where exp_month = '$month'
                                and data_type = 'DEPOT TOTAL'
                                    ");



                if($request->input('d_type') == 'SALES'){

                    $data = ['sdata' => $sum_data, 'tdata' => $total_sum,'pdt' => $pdt, 'incr' => $dincr,'depot_total' => $depot_total_sales,'exp_mon' => $request->input('exp_mon')];

                    \Excel::create('Field Expense Summary', function ($excel) use ($data) {

                        $excel->sheet('Summary Data', function ($sheet) use ($data) {
                            $sheet->loadView('expense.excel_layout.summary_v3_Sales', $data);
                            $sheet->setWidth(array(
                                'A' => 20
                            ));
                        });

                    })->export('xls');

                }
                else{

                    $data = ['sdata' => $sum_data, 'tdata' => $total_sum,'pdt' => $pdt, 'incr' => $dincr,'depot_total' => $depot_total_msd,'exp_mon' => $request->input('exp_mon')];

                    \Excel::create('Field Expense Summary', function ($excel) use ($data) {

                        $excel->sheet('Summary Data', function ($sheet) use ($data) {
                            $sheet->loadView('expense.excel_layout.summary_v3_MSD', $data);
                            $sheet->setWidth(array(
                                'A' => 20
                            ));
                        });

                    })->export('xls');


                }



            }

        }

    }

    //Expense Verify/Approve Report 5/12/17

    public function get_eva_report_view()
    {

        $expense_month = DB::select("Select distinct exp_month, to_char(exp_month,'MON-RR') mon
                                     from mis.exp_expense_m
                                     order by exp_month desc");

        $region = null;

        if (Auth::user()->desig == 'RM' || Auth::user()->desig == 'ASM') {

            $uid = Auth::user()->user_id;
            $ctype = '';
            if(Auth::user()->desig == 'RM'){
                $ctype = 'rm_emp_id';
            }
            elseif(Auth::user()->desig == 'ASM'){
                $ctype = 'asm_emp_id';
            }

            $region = DB::select("Select rm_terr_id
                                  from mis.rm_gm_info
                                  where $ctype = $uid ");

        } elseif (Auth::user()->desig == 'HO' || Auth::user()->desig == 'All') {

            $region = DB::select("select distinct substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id
                            from mis.exp_expense_m                         
                            order by rm_terr_id");
        }

        return view('expense.eva_view')->with(['exp_month' => $expense_month, 'regions' => $region]);
    }

    public function process_report_output(Request $request)
    {

        if (Auth::user()->desig == 'RM' || Auth::user()->desig == 'ASM') {

            $exp_mont = $request->input('emonth');
            $region = $request->input('region');
            $validStat = $request->input('vstat');
            $reportType = $request->input('cgroup');

            $rdata = DB::select("select exp_month,depot_name,rm_terr_id,emp_id eid,emp_name,desig,team,terr_id terr,verified_status,approved_status,total_amount
                                from(
                                select exp_month,depot_name,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,em.emp_id,emp_name,desig,team,em.terr_id,
                                       case when verified_status is null then 'NO' else 'YES' end verified_status,case when approved_status is null then 'NO' else 'YES' end approved_status,
                                       sum(nvl(daily_allowance,0) + nvl(ta_amount,0) + nvl(city_fare_allowance,0) + nvl(oe_amount,0)+ nvl(additional_amount,0)) total_amount        
                                from mis.exp_expense_m em,mis.exp_expense_d_appr ed
                                where exp_month = '$exp_mont'
                                and em.exp_id = ed.exp_id
                                and substr(terr_id,1,instr(terr_id,'-'))||'00'  = '$region'
                                group by exp_month,depot_name,substr(terr_id,1,instr(terr_id,'-'))||'00',em.emp_id,emp_name,desig,team,em.terr_id,
                                         case when verified_status is null then 'NO' else 'YES' end,case when approved_status is null then 'NO' else 'YES' end
                                )where nvl2('$validStat',verified_status,0) = nvl2('$validStat','$validStat',0)
                                ");

            

                $data = ['rdata' => $rdata, 'emonth' => $exp_mont, 'region' => $region];

                if ($reportType[0] == 'pdf') {

                    $pdf = \PDF::loadView('expense.pdf_layout.eva_rp', $data);
                    return $pdf->stream('ExpenseVerifyAppv.pdf');

                } else {

                    if (count($rdata) > 0) {

                    \Excel::create('Expense Verify-Approve', function ($excel) use ($data) {
                        $excel->sheet('Verify-Approve Data', function ($sheet) use ($data) {
                            $sheet->loadView('expense.excel_layout.eva_rx', $data);
                        });
                    })->export('xls');

                    } else {
                        Session::flash('message', 'No data available for month ' . Carbon::parse($exp_mont)->format('F-Y') . ' region ' . $region);
                        return redirect()->back();
                    }
                }
                
            

        } elseif (Auth::user()->desig == 'HO' || Auth::user()->desig == 'All') {

            $exp_mont = $request->input('emonth');
            $region = $request->input('region');
            $validStat = $request->input('vstat');
            $validStatA = $request->input('astat');

            $reportType = $request->input('cgroup');

            $rdata = DB::select("select exp_month,depot_name,rm_terr_id,emp_id eid,emp_name,desig,team,terr_id terr,verified_status,approved_status,total_amount
                                from(
                                select exp_month,depot_name,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,em.emp_id,emp_name,desig,team,em.terr_id,
                                       case when verified_status is null then 'NO' else 'YES' end verified_status,case when approved_status is null then 'NO' else 'YES' end approved_status,
                                       sum(nvl(daily_allowance,0) + nvl(ta_amount,0) + nvl(city_fare_allowance,0) + nvl(oe_amount,0)+ nvl(additional_amount,0)) total_amount        
                                from mis.exp_expense_m em,mis.exp_expense_d_appr ed
                                where exp_month = '$exp_mont'
                                and em.exp_id = ed.exp_id
                                and substr(terr_id,1,instr(terr_id,'-'))||'00'  = '$region'
                                group by exp_month,depot_name,substr(terr_id,1,instr(terr_id,'-'))||'00',em.emp_id,emp_name,desig,team,em.terr_id,
                                         case when verified_status is null then 'NO' else 'YES' end,case when approved_status is null then 'NO' else 'YES' end
                                )where nvl2('$validStat',verified_status,0) = nvl2('$validStat','$validStat',0)
                                and nvl2('$validStatA',approved_status,0) = nvl2('$validStatA','$validStatA',0)
                                ");


                $data = ['rdata' => $rdata, 'emonth' => $exp_mont, 'region' => $region];

                if ($reportType[0] == 'pdf') {

                    $pdf = \PDF::loadView('expense.pdf_layout.eva_rp', $data);
                    return $pdf->stream('ExpenseVerifyAppv.pdf');

                } else {

                    if (count($rdata) > 0) {

                    \Excel::create('Expense Verify-Approve', function ($excel) use ($data) {
                        $excel->sheet('Verify-Approve Data', function ($sheet) use ($data) {
                            $sheet->loadView('expense.excel_layout.eva_rx', $data);
                        });
                    })->export('xls');

                    } else {
                            Session::flash('message', 'No data available for month ' . Carbon::parse($exp_mont)->format('F-Y') . ' and region ' . $region);
                            return redirect()->back();
                    }
                }
            

        }

    }


//... Masroor..
    public function regwTerrListEX(){

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;



        if( Auth::user()->desig === 'All' || Auth::user()->desig === 'HO' ) {

            $month_name = DB::select("select to_char(add_months(dt,l),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 3)
                                    select *
                                      from (select trunc(add_months(sysdate, -3)) dt from dual), data
                                     order by dt, l
                                     )");




            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO)   
                                    order by rm_terr_id");


            return view('expense/regwise_terr_list_exp')->with(['rm_terr'=>$rm_terr,'month_name'=>$month_name]);
        }

        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {

            $month_name = DB::select("select to_char(add_months(dt,l),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 2)
                                    select *
                                      from (select trunc(add_months(sysdate, -2)) dt from dual), data
                                     order by dt, l
                                     )");

            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )   
                                order by am_terr_id");



            return view('expense/regwise_terr_list_exp')->with(['am_terr'=>$am_terr,'month_name'=>$month_name]);
        }

        if( Auth::user()->desig === 'GM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  GM_EMP_ID in ($uid) )   
                                order by rm_terr_id");

            $month_name = DB::select("select to_char(add_months(dt,l),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 2)
                                    select *
                                      from (select trunc(add_months(sysdate, -2)) dt from dual), data
                                     order by dt, l
                                     )");

            return view('expense/regwise_terr_list_exp')->with(['rm_terr'=>$rm_terr,'month_name'=>$month_name]);
        }

        if( Auth::user()->desig === 'NSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  NSM_EMP_ID in ($uid) )   
                                order by rm_terr_id");

            $month_name = DB::select("select to_char(add_months(dt,l),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 2)
                                    select *
                                      from (select trunc(add_months(sysdate, -2)) dt from dual), data
                                     order by dt, l
                                     )");


            return view('expense/regwise_terr_list_exp')->with(['rm_terr'=>$rm_terr,'month_name'=>$month_name]);
        }

        if( Auth::user()->desig === 'SM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  SM_EMP_ID in ($uid) )   
                                order by rm_terr_id");

            $month_name = DB::select("select to_char(add_months(dt,l),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 2)
                                    select *
                                      from (select trunc(add_months(sysdate, -2)) dt from dual), data
                                     order by dt, l
                                     )");

            return view('expense/regwise_terr_list_exp')->with(['rm_terr'=>$rm_terr,'month_name'=>$month_name]);
        }

        if( Auth::user()->desig === 'DSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  DSM_EMP_ID in ($uid) )   
                                order by rm_terr_id");

            $month_name = DB::select("select to_char(add_months(dt,l),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 2)
                                    select *
                                      from (select trunc(add_months(sysdate, -2)) dt from dual), data
                                     order by dt, l
                                     )");

            return view('expense/regwise_terr_list_exp')->with(['rm_terr'=>$rm_terr,'month_name'=>$month_name]);
        }



    }

    public function regwTerrListGmRm(Request $request)
    {
        $uid = Auth::user()->user_id;
        $emonth = $request->input('empMonth');

        if(Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM'){
            $gmrmTerr = DB::select("select DISTINCT tl.rm_terr_id rm_terr
                                from hrtms.hr_terr_list@web_to_hrtms tl,(select rm_terr_id from RM_GM_INFO
                                                                         where RM_EMP_ID ||ASM_EMP_ID in ('$uid')) lei
                                where tl.rm_terr_id = lei.rm_terr_id
                                and to_char(tl.emp_month,'MON-RR') ='$emonth' order by tl.rm_terr_id asc");
        }

        if(Auth::user()->desig === 'GM') {
            $gmrmTerr = DB::select("select DISTINCT tl.rm_terr_id rm_terr
                                from hrtms.hr_terr_list@web_to_hrtms tl,(select rm_terr_id from RM_GM_INFO
                                                                         where gm_emp_id in ('$uid')) lei
                                where tl.rm_terr_id = lei.rm_terr_id
                                and to_char(tl.emp_month,'MON-RR') ='$emonth' order by tl.rm_terr_id asc");
        }

        if(Auth::user()->desig === 'NSM') {
            $gmrmTerr = DB::select("select DISTINCT tl.rm_terr_id rm_terr
                                from hrtms.hr_terr_list@web_to_hrtms tl,(select rm_terr_id from RM_GM_INFO
                                                                         where nsm_emp_id in ('$uid')) lei
                                where tl.rm_terr_id = lei.rm_terr_id
                                and to_char(tl.emp_month,'MON-RR') ='$emonth' order by tl.rm_terr_id asc");
        }

        if(Auth::user()->desig === 'SM') {
            $gmrmTerr = DB::select("select DISTINCT tl.rm_terr_id rm_terr
                                from hrtms.hr_terr_list@web_to_hrtms tl,(select rm_terr_id from RM_GM_INFO
                                                                         where sm_emp_id in ('$uid')) lei
                                where tl.rm_terr_id = lei.rm_terr_id
                                and to_char(tl.emp_month,'MON-RR') ='$emonth' order by tl.rm_terr_id asc");
        }

        if(Auth::user()->desig === 'DSM') {
            $gmrmTerr = DB::select("select DISTINCT tl.rm_terr_id rm_terr
                                from hrtms.hr_terr_list@web_to_hrtms tl,(select rm_terr_id from RM_GM_INFO
                                                                         where dsm_emp_id in ('$uid')) lei
                                where tl.rm_terr_id = lei.rm_terr_id
                                and to_char(tl.emp_month,'MON-RR') ='$emonth' order by tl.rm_terr_id asc");
        }

        if( Auth::user()->desig === 'All' || Auth::user()->desig === 'HO') {
            $gmrmTerr = DB::Select("select distinct rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_char(emp_month,'MON-RR') = '$emonth'
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO ) order by rm_terr_id");
        }

        return response()->json($gmrmTerr);
    }

    public function regWTerrAmList(Request $request){
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;
        if($request->ajax()){
            if( Auth::user()->desig === 'GM') {
                $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  GM_EMP_ID in ('$uid') )  
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
                                    order by am_terr_id");
            }

            if( Auth::user()->desig === 'NSM') {
                $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  NSM_EMP_ID in ('$uid') )  
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
                                    order by am_terr_id");
            }

            if( Auth::user()->desig === 'SM') {
                $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  SM_EMP_ID in ('$uid') )  
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
                                    order by am_terr_id");
            }

            if( Auth::user()->desig === 'DSM') {
                $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  NSM_EMP_ID in ('$uid') )  
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
                                    order by am_terr_id");
            }

            if( Auth::user()->desig === 'All' || Auth::user()->desig === 'HO') {
                $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO )  
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
                                    order by am_terr_id");
            }
        }

        return response()->json($resp_data);
    }

    public function searchEmployeeCode(Request $request){
         DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        if($request->ajax()) {

            $resp_data = DB::Select("select distinct emp_id,terr_id
                        from mis.exp_expense_m
                        where substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) = '$request->amTerr'
                        and to_char(exp_month,'MON-RR') = '$request->emonth'
                        order by emp_id");
            return response()->json($resp_data);
        }
    }

    public function actualVsCorrected(Request $request){
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        if($request->ajax()) {
//            $resp_data = DB::Select("select act_exp.exp_date,act_exp.tour_type,act_exp.daily_allowance,act_exp.ta_amount,act_exp.city_fare_allowance_type,
//                                   act_exp.city_fare_allowance,act_exp.other_amount,appr_exp.tour_type a_tour_type,appr_exp.daily_allowance a_daily_allowance,appr_exp.ta_amount a_ta_amount,
//                                   appr_exp.city_fare_allowance_type a_city_fare_allowance_type,appr_exp.city_fare_allowance a_city_fare_allowance,appr_exp.other_amount a_other_amount,additional_amount
//                            from
//                            (select exp_date,tour_type,daily_allowance,ta_amount,city_fare_allowance_type,city_fare_allowance,oe_amount other_amount
//                            from msfa.expense_m@web_to_imsfa m,msfa.expense_d@web_to_imsfa d
//                            where m.exp_id = d.exp_id
//                            and to_char(m.exp_month,'MON-RR') = '$request->empMonth'
//                            and m.emp_id = '$request->empCode') act_exp,(select exp_date,tour_type,daily_allowance,ta_amount,city_fare_allowance_type,
//                                                                                     city_fare_allowance,oe_amount other_amount,additional_amount
//                                                                              from mis.exp_expense_m em,mis.exp_expense_d ed
//                                                                              where em.exp_id = ed.exp_id
//                                                                              and to_char(em.exp_month,'MON-RR') = '$request->empMonth'
//                                                                              and em.emp_id = '$request->empCode') appr_exp
//                            where act_exp.exp_date = appr_exp.exp_date(+)
//                            order by act_exp.exp_date");
            $resp_data = DB::select("
            select act_exp.exp_date,act_exp.tour_type,act_exp.daily_allowance,act_exp.ta_amount,act_exp.city_fare_allowance_type,
                                   act_exp.city_fare_allowance,act_exp.other_amount,
                                   verify_exp.tour_type a_tour_type,verify_exp.daily_allowance a_daily_allowance,verify_exp.ta_amount a_ta_amount,
                                   verify_exp.city_fare_allowance_type a_city_fare_allowance_type,verify_exp.city_fare_allowance a_city_fare_allowance,verify_exp.other_amount a_other_amount,verify_exp.additional_amount a_additional_amount,                                   
                                   appr_exp.tour_type b_tour_type,appr_exp.daily_allowance b_daily_allowance,appr_exp.ta_amount b_ta_amount,
                                   appr_exp.city_fare_allowance_type b_city_fare_allowance_type,appr_exp.city_fare_allowance b_city_fare_allowance,appr_exp.other_amount b_other_amount,appr_exp.additional_amount b_additional_amount
                            from
                            (select exp_date,tour_type,daily_allowance,ta_amount,city_fare_allowance_type,city_fare_allowance,oe_amount other_amount
                            from msfa.expense_m@web_to_imsfa m,msfa.expense_d@web_to_imsfa d
                            where m.exp_id = d.exp_id
                            and to_char(m.exp_month,'MON-RR') = '$request->empMonth'                            
                            and m.emp_id = '$request->empCode') act_exp,(select exp_date,tour_type,daily_allowance,ta_amount,city_fare_allowance_type,
                                                                                     city_fare_allowance,oe_amount other_amount,additional_amount
                                                                              from mis.exp_expense_m em,mis.exp_expense_d ed
                                                                              where em.exp_id = ed.exp_id
                                                                              and to_char(em.exp_month,'MON-RR') = '$request->empMonth'
                                                                              and em.emp_id = '$request->empCode') verify_exp
                                                              ,(select exp_date,tour_type,daily_allowance,ta_amount,city_fare_allowance_type,
                                                                                     city_fare_allowance,oe_amount other_amount,additional_amount
                                                                              from mis.exp_expense_m em,mis.exp_expense_d_appr ed
                                                                              where em.exp_id = ed.exp_id
                                                                              and to_char(em.exp_month,'MON-RR') = '$request->empMonth'
                                                                              and em.emp_id = '$request->empCode') appr_exp                
                                                                              
                                                                              
where act_exp.exp_date = verify_exp.exp_date(+)
and act_exp.exp_date = appr_exp.exp_date(+)
order by act_exp.exp_date
            ");
            return response()->json($resp_data);
        }
    }
 //... Masroor..

}
