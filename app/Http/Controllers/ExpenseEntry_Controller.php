<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Expense;
use Input;
use Validator;
use File;

class ExpenseEntry_Controller extends Controller
{


    /**************************************
     * ****************Expense Entry Form
     */


    //get the entry form view
    public function expense_entry_view(){

        $datas=DB::select("select distinct rm_terr_id from mis.rm_gm_info order by rm_terr_id");


        $expense_months=DB::select("SELECT distinct to_char(E.EXP_MONTH,'Mon-RR') as month ,to_char(E.EXP_MONTH,'MM')
                                FROM MIS.EXP_EXPENSE_M E 
                                order by to_char(E.EXP_MONTH,'MM')");

        return view('expense.expense_entry.expense_entryform',compact('datas','expense_months'));

    }

    //post the form
    public function expense_entry_search_post(Request $request){


        if($request->ajax()){
            $expense_month=$request->e_month;

            $emp_id=$request->e_emp_id;

            $searchdatas=DB::select("select  EXP_ID,EXP_DID,team,(nvl(additional_amount,0)) as additional_amount,(nvl(DAILY_ALLOWANCE,0) + nvl(CITY_FARE_ALLOWANCE,0)+nvl(TA_AMOUNT,0)+nvl(OE_AMOUNT,0)+nvl(additional_amount,0)) as total,update_status,nvl(ta_IMAGE_status,'No Image') as ta_IMAGE_status,nvl(oe_IMAGE_status,'No Image') as oe_IMAGE_status,emp_id,terr_id,am_terr_id,rm_terr_id,m_month, depot_name,emp_name,DESIG,to_date(EXP_DATE) as EXP_DATE,TOUR_TYPE,TOUR_DETAILS,nvl(DAILY_ALLOWANCE,0) as DAILY_ALLOWANCE,
                CITY_FARE_ALLOWANCE_TYPE,nvl(CITY_FARE_ALLOWANCE,0) as CITY_FARE_ALLOWANCE,TA_DESCRIPTION,nvl(TA_AMOUNT,0) as TA_AMOUNT,TA_IMAGE, OE_DESCRIPTION, nvl(OE_AMOUNT,0) as OE_AMOUNT,OE_IMAGE,
                VERIFIED_BY, VERIFIED_DATE, (nvl(VERIFIED_STATUS,null)) as VERIFIED_STATUS,APPROVED_BY,APPROVED_DATE, APPROVED_STATUS
                from(
               SELECT m.DEPOT_NAME,m.EMP_NAME,m.team, m.DESIG,m.terr_id,m.EXP_ID,d.EXP_DATE,d.TOUR_TYPE,d.TOUR_DETAILS,d.DAILY_ALLOWANCE,
                 d.EXP_DID, d.CITY_FARE_ALLOWANCE_TYPE,d.CITY_FARE_ALLOWANCE,d.TA_DESCRIPTION,d.TA_AMOUNT,d.TA_IMAGE,d.TA_IMAGE_status, d.OE_DESCRIPTION, d.OE_AMOUNT,
                 d.additional_amount,d.update_status,d.oe_IMAGE_status,d.OE_IMAGE,to_char(m.EXP_MONTH,'Mon-YY') as m_month,m.EMP_ID,
                 substr(m.terr_id,1,instr(m.terr_id,'-',1,1))||trunc(substr(m.terr_id,instr(m.terr_id,'-',-1,1)+1),-1) am_terr_id,
                 substr(m.terr_id,1,instr(m.terr_id,'-'))||'00' rm_terr_id,
                 m.STATUS, m.VERIFIED_BY, m.VERIFIED_DATE, m.VERIFIED_STATUS,m.APPROVED_BY,m.APPROVED_DATE, m.APPROVED_STATUS
                 FROM MIS.EXP_EXPENSE_M m,
                MIS.EXP_EXPENSE_D d
                where d.exp_id(+)=m.exp_id )
                where m_month=?
                and EMP_ID=?",[$expense_month,$emp_id]);

            $desigg=$searchdatas[0]->desig;

            $tour_type=DB::select("SELECT r.TOUR_TYPE_DESC as TOUR_TYPE_DESC, c.Amount as amount
                        FROM MIS.EXP_TOUR_TYPE r
                        INNER JOIN MIS.EXPENSE_TYPE c ON r.TOUR_TYPE_DESC = c.EXPENSE_TYPE
                        where c.desig=?",[$desigg]);

            $allow_type=DB::select("SELECT r.ALLOWANCE_TYPE_DESC as ALLOWANCE_TYPE_DESC, c.Amount as amount
                            FROM MIS.EXP_ALLOWANCE_TYPE r
                            INNER JOIN MIS.EXPENSE_TYPE c ON r.ALLOWANCE_TYPE_DESC = c.EXPENSE_TYPE
                            where c.desig=?",[$desigg]);

//            var_dump($searchdatas);
            return response()->json([
                "expense"=>$searchdatas,
                "table_tour_type"=>$tour_type,
                "table_allow_type"=>$allow_type
            ]);
        }
    }

//    public function getEmpbyMonth(Request $request){
//
//        if ($request->ajax()){
//
//            $exp_month=$request->exp_mnt;
//            $expense_months=DB::select("SELECT distinct exp_id ,terr_id
//                                  FROM MIS.EXP_EXPENSE_M E
//                                  where to_char(E.EXP_MONTH,'Mon-RR')=?",[$exp_month]);
//
//            return response()->json($expense_months);
//        }
//
//    }
}
