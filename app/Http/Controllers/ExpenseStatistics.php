<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseStatistics extends Controller
{
    /**
     * @return $this
     */
    public function index(){

        $exp_month = DB::select("select trunc(sysdate,'MM') acmon,to_char(sysdate,'MON-RR') mon
                                    from dual
                                    union all
                                    select trunc(trunc(sysdate,'MM')-1,'MM') acmon,to_char(trunc(sysdate,'MM')-1,'MON-RR') mon
                                    from dual
                                    union all
                                    select trunc(trunc(trunc(sysdate,'MM')-1,'MM')-1,'MM') acmon,to_char(trunc(trunc(sysdate,'MM')-1,'MM')-1,'MON-RR') mon
                                    from dual");

        return view('expense.expense_stat')->with(['expense_months'=>$exp_month]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_expense_stat(Request $request){

        $input = $request->json()->all();
        $exp_month = $input['exp_mon'];

        $results = DB::select("select to_char(ese.exp_month,'MON-RR') em,ese.region_id rid,nvl(exp_send_emp_id,0) es_eid,nvl(exp_approv_emp_id,0) ea_eid,nvl(exp_report_emp_id,0) er_eid
                                from
                                (select exp_month,region_id,count(emp_id) exp_send_emp_id
                                from (
                                select distinct exp_month,substr(terr_id,1,instr(terr_id,'-'))||'00' region_id,em.emp_id
                                from msfa.expense_m@web_to_imsfa em,msfa.expense_d@web_to_imsfa ed
                                where exp_month = '$exp_month'
                                and em.exp_id = ed.exp_id) group by exp_month,region_id) ese,(select exp_month,region_id,count(emp_id) exp_approv_emp_id
                                                                                              from (
                                                                                              select distinct exp_month,substr(terr_id,1,instr(terr_id,'-'))||'00' region_id,em.emp_id
                                                                                              from mis.exp_expense_m em,mis.exp_expense_d ed
                                                                                              where exp_month = '$exp_month'
                                                                                              and em.approved_date is not null
                                                                                              and em.exp_id = ed.exp_id) group by exp_month,region_id) eae,
                                (select exp_month,substr(terr_id,1,instr(terr_id,'-'))||'00' region_id,
                                        count(emp_id) exp_report_emp_id
                                from mis.expense_employee
                                where exp_month = '$exp_month'
                                group by exp_month,substr(terr_id,1,instr(terr_id,'-'))||'00') ere
                                where ese.exp_month = eae.exp_month(+)
                                and ese.region_id = eae.region_id(+)
                                and ese.exp_month = ere.exp_month(+)
                                and ese.region_id = ere.region_id(+)
                                order by ese.region_id
                                ");

        if(count($results) > 0){
            return response()->json(['results'=>$results]);
        }
        else{
            return response()->json(['results'=>'Expense not available for month '.$exp_month]);
        }

    }
}
