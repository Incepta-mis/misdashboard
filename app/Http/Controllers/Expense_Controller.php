<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Expense;
use Input;
use Validator;
use File;

class Expense_Controller extends Controller
{

    public function expense_verify_approve_view(){


        $login_terr_id=Auth::user()->terr_id;

        if ((Auth::user()->desig)=='RM'|| (Auth::user()->desig)=='ASM'){


            $datas=DB::select("select distinct rm_terr_id
                        from
                        (select  emp_id,d.terr_id,d.am_terr_id,d.rm_terr_id,asm_id,dsm_id,nsm_id,gm_id
                        from (

                            select distinct emp_id,terr_id,substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                               substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id
                               from MIS.EXP_EXPENSE_M) d,(select * from MIS.RM_GM_INFO) rm
                               where d.rm_terr_id = rm.rm_terr_id
                        ) ss
                        where rm_terr_id = ?",[$login_terr_id]);


            // $expense_months=DB::select("SELECT distinct to_char(E.EXP_MONTH,'Mon-RR') as month ,to_char(E.EXP_MONTH,'MM')
            //                     FROM MIS.EXP_EXPENSE_M E 
            //                     order by to_char(E.EXP_MONTH,'MM')");

            //03.12.2018

            // $expense_months=DB::select("SELECT distinct to_char(E.EXP_MONTH,'Mon-RR') as month,to_char(E.EXP_MONTH,'MM'),to_char(E.EXP_MONTH,'RR')
            //         FROM MIS.EXP_EXPENSE_M E 
            //         order by to_char(E.EXP_MONTH,'RR') desc,to_char(E.EXP_MONTH,'MM') desc");

            //only want to show first 2 data---25.6.2019

              $expense_months=DB::select("select * from (SELECT distinct to_char(E.EXP_MONTH,'Mon-RR') as month,to_char(E.EXP_MONTH,'MM'),to_char(E.EXP_MONTH,'RR')
                    FROM MIS.EXP_EXPENSE_M E 
                    order by to_char(E.EXP_MONTH,'RR') desc,to_char(E.EXP_MONTH,'MM') desc ) where rownum<3 ");


            
            return view('expense.expense_verify_approve',compact('datas','expense_months'));

        }else if ((Auth::user()->desig)=='HO'){


            $datas=DB::select("select distinct rm_terr_id from mis.rm_gm_info order by rm_terr_id");


            // $expense_months=DB::select("SELECT distinct to_char(E.EXP_MONTH,'Mon-RR') as month ,to_char(E.EXP_MONTH,'MM')
            //                     FROM MIS.EXP_EXPENSE_M E 
            //                     order by to_char(E.EXP_MONTH,'MM')");

            //03.12.2018

            $expense_months=DB::select("SELECT distinct to_char(E.EXP_MONTH,'Mon-RR') as month,to_char(E.EXP_MONTH,'MM'),to_char(E.EXP_MONTH,'RR')
                    FROM MIS.EXP_EXPENSE_M E 
                    order by to_char(E.EXP_MONTH,'RR') desc,to_char(E.EXP_MONTH,'MM') desc");

            return view('expense.expense_verify_approve',compact('datas','expense_months'));

        }


    }

    public function expense_am_view(){

        $login_terr_id=Auth::user()->terr_id;

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        if (Auth::user()->desig === 'AM'||Auth::user()->desig === 'Sr. AM') {

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

            $expense_months=DB::select("select * from (SELECT distinct to_char(E.EXP_MONTH,'Mon-RR') as month,to_char(E.EXP_MONTH,'MM'),to_char(E.EXP_MONTH,'RR')
                    FROM MIS.EXP_EXPENSE_M E 
                    order by to_char(E.EXP_MONTH,'RR') desc,to_char(E.EXP_MONTH,'MM') desc ) where rownum<3 ");

            return view('expense.expense_verify_am')->with(['expense_months' => $expense_months, 'rm_terr' => $rm_terr, 'am_terr' => $am_terr, 'mpo_terr' => $mpo_terr]);


        }


    }

    public function expense_mpo_view(){

        $login_terr_id=Auth::user()->terr_id;

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        if(Auth::user()->desig=='MPO' || Auth::user()->desig=='Sr. MPO'){


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

            $expense_months=DB::select("
                    select * from (SELECT distinct to_char(E.EXP_MONTH,'Mon-RR') as month,to_char(E.EXP_MONTH,'MM'),to_char(E.EXP_MONTH,'RR')
                    FROM MIS.EXP_EXPENSE_M E 
                    order by to_char(E.EXP_MONTH,'RR') desc,to_char(E.EXP_MONTH,'MM') desc ) where rownum<4 ");


            return view('expense.expense_mpo_view')->with(['expense_months' => $expense_months, 'rm_terr' => $rm_terr, 'am_terr' => $am_terr, 'mpo_terr' => $mpo_terr]);

        }

        if (Auth::user()->desig === 'AM'||Auth::user()->desig === 'Sr. AM') {


            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and am_emp_id = ?", [$uid]);

            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and am_emp_id  =?", [$uid]);

            $mpo_terr =DB::select("select distinct am_terr_id mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and am_emp_id  =?", [$uid]);

            $expense_months=DB::select("select * from (SELECT distinct to_char(E.EXP_MONTH,'Mon-RR') as month,to_char(E.EXP_MONTH,'MM'),to_char(E.EXP_MONTH,'RR')
                    FROM MIS.EXP_EXPENSE_M E 
                    order by to_char(E.EXP_MONTH,'RR') desc,to_char(E.EXP_MONTH,'MM') desc ) where rownum<3 ");


            return view('expense.expense_mpo_view')->with(['expense_months' => $expense_months, 'rm_terr' => $rm_terr, 'am_terr' => $am_terr, 'mpo_terr' => $mpo_terr]);

        }


    }

    //post the form..... after click on submit

    public function expense_verify_approve_view_post(Request $request){

        $empty_msg_table='notemptytable';
        if($request->ajax()){
            $expense_month=$request->e_month;


//            if (Auth::user()->desig=='MPO'){
//                $emp_id=Auth::user()->user_id;
//            }else{
//                $emp_id=$request->e_emp_id;
//            }

            $terr_id=$request->e_terr_id;

            if (Auth::user()->desig=='AM'||Auth::user()->desig=='Sr. AM'||Auth::user()->desig=='RM'||Auth::user()->desig=='ASM'||Auth::user()->desig=='DSM'||Auth::user()->desig=='SM'||Auth::user()->desig=='NSM'||Auth::user()->desig=='GM'){

                $am_terr_id=$request->e_am_terr_id;
                $rm_terr_id=$request->e_rm_terr_id;

                $searchdatas_empty=DB::select("select  EXP_ID,EXP_DID,(nvl(additional_amount,0)) as additional_amount,(nvl(DAILY_ALLOWANCE,0) + nvl(CITY_FARE_ALLOWANCE,0)+nvl(TA_AMOUNT,0)+nvl(OE_AMOUNT,0)+nvl(additional_amount,0)) as total,update_status,nvl(ta_IMAGE_status,'No Image') as ta_IMAGE_status,nvl(oe_IMAGE_status,'No Image') as oe_IMAGE_status,emp_id,terr_id,am_terr_id,rm_terr_id,m_month, depot_name,emp_name,DESIG,to_date(EXP_DATE) as EXP_DATE,TOUR_TYPE,TOUR_DETAILS,nvl(DAILY_ALLOWANCE,0) as DAILY_ALLOWANCE,
                    CITY_FARE_ALLOWANCE_TYPE,nvl(CITY_FARE_ALLOWANCE,0) as CITY_FARE_ALLOWANCE,TA_DESCRIPTION,nvl(TA_AMOUNT,0) as TA_AMOUNT,TA_IMAGE, OE_DESCRIPTION, nvl(OE_AMOUNT,0) as OE_AMOUNT,OE_IMAGE,
                    VERIFIED_BY, VERIFIED_DATE, (nvl(VERIFIED_STATUS,null)) as VERIFIED_STATUS,APPROVED_BY,APPROVED_DATE, APPROVED_STATUS
                    from(
                   SELECT m.DEPOT_NAME,m.EMP_NAME, m.DESIG,m.terr_id,d.EXP_ID,d.EXP_DATE,d.TOUR_TYPE,d.TOUR_DETAILS,d.DAILY_ALLOWANCE,
                     d.EXP_DID, d.CITY_FARE_ALLOWANCE_TYPE,d.CITY_FARE_ALLOWANCE,d.TA_DESCRIPTION,d.TA_AMOUNT,d.TA_IMAGE,d.TA_IMAGE_status, d.OE_DESCRIPTION, d.OE_AMOUNT,
                     d.additional_amount,d.update_status,d.oe_IMAGE_status,d.OE_IMAGE,to_char(m.EXP_MONTH,'Mon-YY') as m_month,m.EMP_ID,
                     substr(m.terr_id,1,instr(m.terr_id,'-',1,1))||trunc(substr(m.terr_id,instr(m.terr_id,'-',-1,1)+1),-1) am_terr_id,
                     substr(m.terr_id,1,instr(m.terr_id,'-'))||'00' rm_terr_id,
                     m.STATUS, m.VERIFIED_BY, m.VERIFIED_DATE, m.VERIFIED_STATUS,m.APPROVED_BY,m.APPROVED_DATE, m.APPROVED_STATUS
                     FROM MIS.EXP_EXPENSE_M m,
                    MIS.EXP_EXPENSE_D_APPR d
                    where d.exp_id=m.exp_id )

                    where m_month=?
                    and terr_id=?
                    and am_terr_id=?
                    and rm_terr_id=? order by exp_date asc",[$expense_month,$terr_id,$am_terr_id,$rm_terr_id]);

                if(empty($searchdatas_empty)){
                    $empty_msg_table='emptytable';
                }else{
                    $empty_msg_table='notemptytable';
                }

                $searchdatas=DB::select("select  EXP_ID,EXP_DID,(nvl(additional_amount,0)) as additional_amount,(nvl(DAILY_ALLOWANCE,0) + nvl(CITY_FARE_ALLOWANCE,0)+nvl(TA_AMOUNT,0)+nvl(OE_AMOUNT,0)+nvl(additional_amount,0)) as total,update_status,nvl(ta_IMAGE_status,'No Image') as ta_IMAGE_status,nvl(oe_IMAGE_status,'No Image') as oe_IMAGE_status,emp_id,terr_id,am_terr_id,rm_terr_id,m_month, depot_name,emp_name,DESIG,to_date(EXP_DATE) as EXP_DATE,TOUR_TYPE,TOUR_DETAILS,nvl(DAILY_ALLOWANCE,0) as DAILY_ALLOWANCE,
                    CITY_FARE_ALLOWANCE_TYPE,nvl(CITY_FARE_ALLOWANCE,0) as CITY_FARE_ALLOWANCE,TA_DESCRIPTION,nvl(TA_AMOUNT,0) as TA_AMOUNT,TA_IMAGE, OE_DESCRIPTION, nvl(OE_AMOUNT,0) as OE_AMOUNT,OE_IMAGE,
                    VERIFIED_BY, VERIFIED_DATE, (nvl(VERIFIED_STATUS,null)) as VERIFIED_STATUS,APPROVED_BY,APPROVED_DATE, APPROVED_STATUS
                    from(
                   SELECT m.DEPOT_NAME,m.EMP_NAME, m.DESIG,m.terr_id,d.EXP_ID,d.EXP_DATE,d.TOUR_TYPE,d.TOUR_DETAILS,d.DAILY_ALLOWANCE,
                     d.EXP_DID, d.CITY_FARE_ALLOWANCE_TYPE,d.CITY_FARE_ALLOWANCE,d.TA_DESCRIPTION,d.TA_AMOUNT,d.TA_IMAGE,d.TA_IMAGE_status, d.OE_DESCRIPTION, d.OE_AMOUNT,
                     d.additional_amount,d.update_status,d.oe_IMAGE_status,d.OE_IMAGE,to_char(m.EXP_MONTH,'Mon-YY') as m_month,m.EMP_ID,
                     substr(m.terr_id,1,instr(m.terr_id,'-',1,1))||trunc(substr(m.terr_id,instr(m.terr_id,'-',-1,1)+1),-1) am_terr_id,
                     substr(m.terr_id,1,instr(m.terr_id,'-'))||'00' rm_terr_id,
                     m.STATUS, m.VERIFIED_BY, m.VERIFIED_DATE, m.VERIFIED_STATUS,m.APPROVED_BY,m.APPROVED_DATE, m.APPROVED_STATUS
                     FROM MIS.EXP_EXPENSE_M m,
                    MIS.EXP_EXPENSE_D_APPR d
                    where d.exp_id=m.exp_id )

                    where m_month=?
                    and terr_id=?
                    and am_terr_id=?
                    and rm_terr_id=?
                      --and APPROVED_STATUS is NULL
                      order by exp_date asc",[$expense_month,$terr_id,$am_terr_id,$rm_terr_id]);






            }elseif (Auth::user()->desig=='MPO' || Auth::user()->desig=='Sr. MPO'){

                $searchdatas=DB::select("select  EXP_ID,EXP_DID,(nvl(additional_amount,0)) as additional_amount,(nvl(DAILY_ALLOWANCE,0) + nvl(CITY_FARE_ALLOWANCE,0)+nvl(TA_AMOUNT,0)+nvl(OE_AMOUNT,0)+nvl(additional_amount,0)) as total,update_status,nvl(ta_IMAGE_status,'No Image') as ta_IMAGE_status,nvl(oe_IMAGE_status,'No Image') as oe_IMAGE_status,emp_id,terr_id,am_terr_id,rm_terr_id,m_month, depot_name,emp_name,DESIG,to_date(EXP_DATE) as EXP_DATE,TOUR_TYPE,TOUR_DETAILS,nvl(DAILY_ALLOWANCE,0) as DAILY_ALLOWANCE,
                    CITY_FARE_ALLOWANCE_TYPE,nvl(CITY_FARE_ALLOWANCE,0) as CITY_FARE_ALLOWANCE,TA_DESCRIPTION,nvl(TA_AMOUNT,0) as TA_AMOUNT,TA_IMAGE, OE_DESCRIPTION, nvl(OE_AMOUNT,0) as OE_AMOUNT,OE_IMAGE,
                    VERIFIED_BY, VERIFIED_DATE, VERIFIED_STATUS,APPROVED_BY,APPROVED_DATE, APPROVED_STATUS
                    from(
                   SELECT m.DEPOT_NAME,m.EMP_NAME, m.DESIG,m.terr_id,d.EXP_ID,d.EXP_DATE,d.TOUR_TYPE,d.TOUR_DETAILS,d.DAILY_ALLOWANCE,
                     d.EXP_DID, d.CITY_FARE_ALLOWANCE_TYPE,d.CITY_FARE_ALLOWANCE,d.TA_DESCRIPTION,d.TA_AMOUNT,d.TA_IMAGE,d.TA_IMAGE_status, d.OE_DESCRIPTION, d.OE_AMOUNT,
                     d.additional_amount,d.update_status,d.oe_IMAGE_status,d.OE_IMAGE,to_char(m.EXP_MONTH,'Mon-YY') as m_month,m.EMP_ID,
                     substr(m.terr_id,1,instr(m.terr_id,'-',1,1))||trunc(substr(m.terr_id,instr(m.terr_id,'-',-1,1)+1),-1) am_terr_id,
                     substr(m.terr_id,1,instr(m.terr_id,'-'))||'00' rm_terr_id,
                     m.STATUS, m.VERIFIED_BY, m.VERIFIED_DATE, m.VERIFIED_STATUS,m.APPROVED_BY,m.APPROVED_DATE, m.APPROVED_STATUS
                     FROM MIS.EXP_EXPENSE_M m,
                    MIS.EXP_EXPENSE_D_APPR d
                    where d.exp_id=m.exp_id )
                    
                    where m_month=?
                    and terr_id=? 
                    --and VERIFIED_STATUS is NULL 
                    order by exp_date asc",[$expense_month,$terr_id]);




            }elseif (Auth::user()->desig=='HO'){


                $searchdatas=DB::select("select  EXP_ID,EXP_DID,(nvl(additional_amount,0)) as additional_amount,(nvl(DAILY_ALLOWANCE,0) + nvl(CITY_FARE_ALLOWANCE,0)+nvl(TA_AMOUNT,0)+nvl(OE_AMOUNT,0)+nvl(additional_amount,0)) as total,update_status,nvl(ta_IMAGE_status,'No Image') as ta_IMAGE_status,nvl(oe_IMAGE_status,'No Image') as oe_IMAGE_status,emp_id,terr_id,am_terr_id,rm_terr_id,m_month, depot_name,emp_name,DESIG,to_date(EXP_DATE) as EXP_DATE,TOUR_TYPE,TOUR_DETAILS,nvl(DAILY_ALLOWANCE,0) as DAILY_ALLOWANCE,
                    CITY_FARE_ALLOWANCE_TYPE,nvl(CITY_FARE_ALLOWANCE,0) as CITY_FARE_ALLOWANCE,TA_DESCRIPTION,nvl(TA_AMOUNT,0) as TA_AMOUNT,TA_IMAGE, OE_DESCRIPTION, nvl(OE_AMOUNT,0) as OE_AMOUNT,OE_IMAGE,
                    VERIFIED_BY, VERIFIED_DATE, (nvl(VERIFIED_STATUS,null)) as VERIFIED_STATUS,APPROVED_BY,APPROVED_DATE, APPROVED_STATUS
                    from(
                   SELECT m.DEPOT_NAME,m.EMP_NAME, m.DESIG,m.terr_id,d.EXP_ID,d.EXP_DATE,d.TOUR_TYPE,d.TOUR_DETAILS,d.DAILY_ALLOWANCE,
                     d.EXP_DID, d.CITY_FARE_ALLOWANCE_TYPE,d.CITY_FARE_ALLOWANCE,d.TA_DESCRIPTION,d.TA_AMOUNT,d.TA_IMAGE,d.TA_IMAGE_status, d.OE_DESCRIPTION, d.OE_AMOUNT,
                     d.additional_amount,d.update_status,d.oe_IMAGE_status,d.OE_IMAGE,to_char(m.EXP_MONTH,'Mon-YY') as m_month,m.EMP_ID,
                     substr(m.terr_id,1,instr(m.terr_id,'-',1,1))||trunc(substr(m.terr_id,instr(m.terr_id,'-',-1,1)+1),-1) am_terr_id,
                     substr(m.terr_id,1,instr(m.terr_id,'-'))||'00' rm_terr_id,
                     m.STATUS, m.VERIFIED_BY, m.VERIFIED_DATE, m.VERIFIED_STATUS,m.APPROVED_BY,m.APPROVED_DATE, m.APPROVED_STATUS
                     FROM MIS.EXP_EXPENSE_M m,
                    MIS.EXP_EXPENSE_D_APPR d
                    where d.exp_id=m.exp_id )

                    where m_month=?
                    and terr_id=? order by exp_date asc",[$expense_month,$terr_id]);





            }


            ////////////////////////////////
            if(empty($searchdatas)){
                $id=0;
                $verified_st=0;
                $veri_user_id=0;
                $name_verified_st=0;
                $approved_st=0;
                $app_user_id=0;
                $name_approved_st=0;

                $allowance_typ=0;
                $tour_typ_amnt=0;

            }else if($searchdatas){
                foreach ($searchdatas as $sd) {
                    if ($sd->oe_image_status === 'No Image') {

                        $img_addr = '\\192.168.1.13\ExpenseImage\\';
                        $destinationPath = '\\' . $img_addr . $sd->exp_did . '\\otherExpenseImage.jpg';//its refers proj/public/up_file directry

                        if (file_exists($destinationPath)) {
                            //$img_addr = '/202.84.43.214:5023/ExpenseImage/';
                            if(substr($request->ip(),0,3) === '192'){
                                $img_addr = '/192.168.1.13:5023/ExpenseImage/';
                            }else{
                                $img_addr = '/202.84.43.214:5023/ExpenseImage/';
                            }
                            $destinationPath = 'http:/' . $img_addr . $sd->exp_did . '/otherExpenseImage.jpg';
                            $sd->oe_image = $destinationPath;
                        } else {
                            $sd->oe_image = 'NF';
                        }
                    }

                    if ($sd->ta_image_status === 'No Image') {

                        $img_addr = '\\192.168.1.13\ExpenseImage\\';
                        $destinationPath = '\\' . $img_addr . $sd->exp_did . '\\travelAllowanceImage.jpg';//its refers proj/public/up_file directry

                        if (file_exists($destinationPath)) {
                            //$img_addr = '/202.84.43.214:5023/ExpenseImage/';
                            if(substr($request->ip(),0,3) === '192'){
                                $img_addr = '/192.168.1.13:5023/ExpenseImage/';
                            }else{
                                $img_addr = '/202.84.43.214:5023/ExpenseImage/';
                            }
                            $destinationPath = 'http:/' . $img_addr . $sd->exp_did . '/travelAllowanceImage.jpg';
                            $sd->ta_image = $destinationPath;
                        } else {
                            $sd->ta_image = 'NF';
                        }
                    }

                }


                $id=$searchdatas[0]->exp_id;
                $verified_st=DB::select("SELECT EXP_ID,verified_by,VERIFIED_STATUS,to_char(VERIFIED_DATE,'DD-MON-RR')VERIFIED_DATE 
                                          FROM MIS.EXP_EXPENSE_M where exp_id=?",[$id]);
                $veri_user_id=$verified_st[0]->verified_by;

                if(empty($veri_user_id)){
                    $name_verified_st=null;
                }else{
                    $name_verified_st=DB::select("SELECT name FROM MIS.dashboard_users_info where user_id=?",[$veri_user_id]);
                }

                $approved_st=DB::select("SELECT EXP_ID,approved_by,APPROVED_STATUS,to_char(APPROVED_DATE,'DD-MON-RR')APPROVED_DATE FROM MIS.EXP_EXPENSE_M where exp_id=?",[$id]);
                $app_user_id=$approved_st[0]->approved_by;

                if(empty($app_user_id)){
                    $name_approved_st=null;
                }else{
                    $name_approved_st=DB::select("SELECT name FROM MIS.dashboard_users_info where user_id=?",[$app_user_id]);
                    
                }

                //add by 23.11.2017

                $desig=$searchdatas[0]->desig;

                $allowance_typ=DB::select("SELECT r.ALLOWANCE_TYPE_ID as ALLOWANCE_TYPE_ID,r.ALLOWANCE_TYPE_DESC as ALLOWANCE_TYPE_DESC, c.Amount as amount
                            FROM MIS.EXP_ALLOWANCE_TYPE r
                            INNER JOIN MIS.EXPENSE_TYPE c ON r.ALLOWANCE_TYPE_DESC = c.EXPENSE_TYPE
                            where c.desig=?",[$desig]);

                $tour_typ_amnt=DB::select("SELECT c.desig as desig,c.expense_TYPE as expense_TYPE, c.Amount as amount
                                FROM MIS.EXP_TOUR_TYPE r INNER JOIN MIS.EXPENSE_TYPE c ON r.tour_TYPE_DESC = c.EXPENSE_TYPE where desig=?",[$desig]);



                //add by 23.11.2017

            }
            /////////////////////////////

            if (Auth::user()->desig=='HO'){
                $summary_tour=DB::select("select tour_type,count(*) as countr
                                from MIS.EXP_EXPENSE_M m,
                                MIS.EXP_EXPENSE_D_APPR d
                                where m.exp_id = d.exp_id
                                and m.terr_id = ?
                                and to_char(m.EXP_MONTH,'Mon-YY') = ?
                                group by tour_type",[$terr_id,$expense_month]);
            }
            else{
                $summary_tour=DB::select("select tour_type,count(*) as countr
                                from MIS.EXP_EXPENSE_M m,
                                MIS.EXP_EXPENSE_D_APPR d
                                where m.exp_id = d.exp_id
                                and m.terr_id = ?
                                and to_char(m.EXP_MONTH,'Mon-YY') = ?
                                group by tour_type",[$terr_id,$expense_month]);
            }

            return response()->json([
                "expense"=>$searchdatas,
                "verified_st"=>$verified_st,
                "exp_idid"=>$id,
                "veri_name"=>$name_verified_st,
                "sum_tour_type"=>$summary_tour,
                "approved_st" => $approved_st,
                "app_name"=>$name_approved_st,
                'table_empty_statusapp'=>$empty_msg_table,
                'g_allowance_typ'=>$allowance_typ,
                'g_tour_typ'=>$tour_typ_amnt
            ]);
        }
    }


    public function getexpense_modal_view(Request $request){

        if($request->ajax())
        {
            $id=$request->id;
            $citytype=$request->citytype;

            $emon = $request->month;


            $desig=$request->desigid;

            if(Auth::user()->desig=='HO'){
                $expenses= DB::select("SELECT d.* ,
                                    m.emp_name,
                                    m.desig,
                                    m.terr_id,
                                    m.depot_name
                                   FROM MIS.EXP_EXPENSE_D_APPR d,
                                   (select distinct emp_id,emp_name,desig,depot_name,terr_id from MIS.EXP_EXPENSE_M where exp_month = to_date('$emon','Mon-RR'))  m
                                   WHERE m.emp_id=d.emp_id 
                                   AND d.exp_did= ?",[$id]);
                $qry = "SELECT d.* ,
                                    m.emp_name,
                                    m.desig,
                                    m.terr_id,
                                    m.depot_name
                                   FROM MIS.EXP_EXPENSE_D_APPR d,
                                   (select distinct emp_id,emp_name,desig,depot_name,terr_id from MIS.EXP_EXPENSE_M where exp_month = to_date('$emon','Mon-RR'))  m
                                   WHERE m.emp_id=d.emp_id 
                                   AND d.exp_did= $id";
            }else{
                $expenses= DB::select("SELECT d.* ,
                                    m.emp_name,
                                    m.desig,
                                    m.terr_id,
                                    m.depot_name
                                   FROM MIS.EXP_EXPENSE_D d,
                                   (select distinct emp_id,emp_name,desig,depot_name,terr_id from MIS.EXP_EXPENSE_M where exp_month = to_date('$emon','Mon-RR'))  m
                                   WHERE m.emp_id=d.emp_id 
                                   AND d.exp_did= ?",[$id]);
                $qry = "SELECT d.* ,
                                    m.emp_name,
                                    m.desig,
                                    m.terr_id,
                                    m.depot_name
                                   FROM MIS.EXP_EXPENSE_D d,
                                   (select distinct emp_id,emp_name,desig,depot_name,terr_id from MIS.EXP_EXPENSE_M where exp_month = to_date('$emon','Mon-RR'))  m
                                   WHERE m.emp_id=d.emp_id 
                                   AND d.exp_did= $id";
            }

            $tour_type=DB::select("select distinct TOUR_TYPE_DESC FROM MIS.EXP_TOUR_TYPE");

            $allowance_typ=DB::select("SELECT ALLOWANCE_TYPE_ID, ALLOWANCE_TYPE_DESC FROM MIS.EXP_ALLOWANCE_TYPE");

            $expense_type_amunt=DB::select("SELECT EMP_EXP_ID, DESIG, EXPENSE_TYPE, AMOUNT, CONDITION_TYPE, CREATE_DATE, VALID
            FROM MIS.EXPENSE_TYPE where upper(desig)=upper(?) and expense_type=?",[$desig,$citytype]);


            return response()->json(
                [
                    'expenses'=>$expenses,
                    'tour_type'=>$tour_type,
                    'allowance_typ'=>$allowance_typ,
                    'expense_ty_max'=>$expense_type_amunt,
                    'qry'=>$qry
                ]);
        }
    }

    public function postexpense_modal_view(Request $request){

        if($request->ajax()){


            $taimgstatus=$request->taimgstate_id;
            $oeimgstatus=$request->oeimgstate_id;
            $updatestatus=$request->upstate_id;

            $galleryId=$request->udid;
//                    $destinationPath = '\\\192.168.1.221\ExpenseImage\\';
            $destinationPath =public_path('../ExpenseImage/');

            $path =$destinationPath.$galleryId;

            if (!empty(Input::file('ta_image')) && empty(Input::file('oe_image')) ){
                $mm="ta is not empty oe empty";

                $ta_file=Input::file('ta_image');
                $ta_extension = Input::file('ta_image')->getClientOriginalExtension(); // getting image extension
//                $ta_filename = 'travelAllowanceImage'. '.' . $ta_extension; // renameing image
                $ta_filename = 'travelAllowanceImage'. '.' . 'jpg'; // renameing image

                if($updatestatus=='yes'){

                    $upload_success = $ta_file->move($path, $ta_filename);
                    $taimgstatus='yes';
                    $updatestatus='yes';
                }else{
//                        $destinationPath = '\\192.168.1.15\ExpenseImage';//its refers proj/public/up_file directry


                    File::makeDirectory($path, $mode = 0777, true, true);
                    $taimgstatus='yes';
                    $updatestatus='yes';
                    $upload_success = $ta_file->move($path, $ta_filename);
                }

            }elseif( !empty(Input::file('oe_image')) && empty(Input::file('ta_image'))  ){
                $mm="oe is not empty ta empty";

                $oe_file=Input::file('oe_image');
                $oe_extension = Input::file('oe_image')->getClientOriginalExtension(); // getting image extension
//                $oe_filename = 'otherExpenseImage'.'.'.$oe_extension; // renameing image
                $oe_filename = 'otherExpenseImage'.'.'.'jpg'; // renameing image


                if($updatestatus=='yes'){

                    $upload_success = $oe_file->move($path, $oe_filename);
                    $oeimgstatus='yes';
                    $updatestatus='yes';
                }else{
//                        $destinationPath = '\\192.168.1.15\ExpenseImage';//its refers proj/public/up_file directry


                    File::makeDirectory($path, $mode = 0777, true, true);
                    $oeimgstatus='yes';
                    $updatestatus='yes';
                    $upload_success = $oe_file->move($path, $oe_filename);
                }


            }elseif( !empty(Input::file('ta_image')) && !empty( Input::file('oe_image'))  ){
                $mm="ta oe not empty";

                $ta_file=Input::file('ta_image');
                $ta_extension = Input::file('ta_image')->getClientOriginalExtension(); // getting image extension
//                $ta_filename = 'travelAllowanceImage'. '.' . $ta_extension; // renameing image
                $ta_filename = 'travelAllowanceImage'. '.' . 'jpg';

                $oe_file=Input::file('oe_image');
                $oe_extension = Input::file('oe_image')->getClientOriginalExtension(); // getting image extension
//                $oe_filename = 'otherExpenseImage'. '.' . $oe_extension; // renameing image
                $oe_filename = 'otherExpenseImage'.'.'.'jpg';

                if($updatestatus=='yes'){

                    $upload_success = $ta_file->move($path, $ta_filename);
                    $upload_success1 = $oe_file->move($path, $oe_filename);

                    $taimgstatus='yes';
                    $oeimgstatus='yes';
                    $updatestatus='yes';

                }else{
//                        $destinationPath = '\\192.168.1.15\ExpenseImage';//its refers proj/public/up_file directry


                    File::makeDirectory($path, $mode = 0777, true, true);
                    $taimgstatus='yes';
                    $oeimgstatus='yes';
                    $updatestatus='yes';

                    $upload_success = $ta_file->move($path, $ta_filename);
                    $upload_success1 = $oe_file->move($path, $oe_filename);
                }


            }else{
                $mm="ta oe empty";
            }




////////////////////////////////////////////////////////////////////////////////////////

            if (Auth::user()->desig=='HO'){

                DB::table('mis.exp_expense_d_appr')
                    ->where('exp_did', $request->udid)
                    ->update(
                        [
                            'tour_type' => $request->tour_type,
                            'tour_details'=>$request->tour_details,
                            'daily_allowance'=>$request->daily_allowance,
                            'city_fare_allowance_type'=>$request->allowance_typ,
                            'city_fare_allowance'=>$request->city_all,

                            'ta_amount'=>$request->ta_amnt,
                            'ta_description'=>$request->ta_des,

                            'ta_image_status'=>$taimgstatus,
                            'oe_image_status'=>$oeimgstatus,

                            'update_status'=>$updatestatus,

                            'oe_amount'=>$request->oe_amnt,
                            'oe_description'=>$request->oe_des,
                            'additional_amount'=>$request->add_amnt,

                            'update_by'=>Auth::user()->user_id,


                        ]);
            }else{

                DB::table('mis.exp_expense_d_appr')
                    ->where('exp_did', $request->udid)
                    ->update(
                        [
                            'tour_type' => $request->tour_type,
                            'tour_details'=>$request->tour_details,
                            'daily_allowance'=>$request->daily_allowance,
                            'city_fare_allowance_type'=>$request->allowance_typ,
                            'city_fare_allowance'=>$request->city_all,

                            'ta_amount'=>$request->ta_amnt,
                            'ta_description'=>$request->ta_des,

                            'ta_image_status'=>$taimgstatus,
                            'oe_image_status'=>$oeimgstatus,

                            'update_status'=>$updatestatus,

                            'oe_amount'=>$request->oe_amnt,
                            'oe_description'=>$request->oe_des,
                            'additional_amount'=>$request->add_amnt,

                            'update_by'=>Auth::user()->user_id,


                        ]);
            }



            return response()->json([

                'message'=>'Updated Successfully',
                'mm'=>$mm,
                'path'=>$path

            ]);
////////////////////////////////////////////////////////////////////////////////

        }
    }

    //just select single row
    public function single_expense_row_replace(Request $request){


        $g_exp_did=$request->id;

        if($request->ajax()) {

            if(Auth::user()->desig=='HO'){
                $searchdatas = DB::select("select  EXP_ID,EXP_DID,(nvl(additional_amount,0)) as additional_amount,(nvl(DAILY_ALLOWANCE,0) + nvl(CITY_FARE_ALLOWANCE,0)+nvl(TA_AMOUNT,0)+nvl(OE_AMOUNT,0)+nvl(additional_amount,0)) as total,update_status,nvl(ta_IMAGE_status,'No Image') as ta_IMAGE_status,nvl(oe_IMAGE_status,'No Image') as oe_IMAGE_status,emp_id,terr_id,am_terr_id,rm_terr_id,m_month, depot_name,emp_name,DESIG,to_date(EXP_DATE) as EXP_DATE,TOUR_TYPE,TOUR_DETAILS,nvl(DAILY_ALLOWANCE,0) as DAILY_ALLOWANCE,
                    CITY_FARE_ALLOWANCE_TYPE,nvl(CITY_FARE_ALLOWANCE,0) as CITY_FARE_ALLOWANCE,TA_DESCRIPTION,nvl(TA_AMOUNT,0) as TA_AMOUNT,TA_IMAGE, OE_DESCRIPTION, nvl(OE_AMOUNT,0) as OE_AMOUNT,OE_IMAGE,
                    VERIFIED_BY, VERIFIED_DATE, VERIFIED_STATUS,APPROVED_BY,APPROVED_DATE, APPROVED_STATUS
                    from(
                   SELECT m.DEPOT_NAME,m.EMP_NAME, m.DESIG,m.terr_id,d.EXP_ID,d.EXP_DATE,d.TOUR_TYPE,d.TOUR_DETAILS,d.DAILY_ALLOWANCE,
                     d.EXP_DID, d.CITY_FARE_ALLOWANCE_TYPE,d.CITY_FARE_ALLOWANCE,d.TA_DESCRIPTION,d.TA_AMOUNT,d.TA_IMAGE,d.TA_IMAGE_status, d.OE_DESCRIPTION, d.OE_AMOUNT,
                     d.additional_amount,d.update_status,d.oe_IMAGE_status,d.OE_IMAGE,to_char(m.EXP_MONTH,'Mon-YY') as m_month,m.EMP_ID,
                     substr(m.terr_id,1,instr(m.terr_id,'-',1,1))||trunc(substr(m.terr_id,instr(m.terr_id,'-',-1,1)+1),-1) am_terr_id,
                     substr(m.terr_id,1,instr(m.terr_id,'-'))||'00' rm_terr_id,
                     m.STATUS, m.VERIFIED_BY, m.VERIFIED_DATE, m.VERIFIED_STATUS,m.APPROVED_BY,m.APPROVED_DATE, m.APPROVED_STATUS
                     FROM MIS.EXP_EXPENSE_M m,
                    MIS.EXP_EXPENSE_D_APPR d
                    where d.exp_id=m.exp_id )

                    where exp_did=?", [$g_exp_did]);
            }else{
                $searchdatas = DB::select("select  EXP_ID,EXP_DID,(nvl(additional_amount,0)) as additional_amount,(nvl(DAILY_ALLOWANCE,0) + nvl(CITY_FARE_ALLOWANCE,0)+nvl(TA_AMOUNT,0)+nvl(OE_AMOUNT,0)+nvl(additional_amount,0)) as total,update_status,nvl(ta_IMAGE_status,'No Image') as ta_IMAGE_status,nvl(oe_IMAGE_status,'No Image') as oe_IMAGE_status,emp_id,terr_id,am_terr_id,rm_terr_id,m_month, depot_name,emp_name,DESIG,to_date(EXP_DATE) as EXP_DATE,TOUR_TYPE,TOUR_DETAILS,nvl(DAILY_ALLOWANCE,0) as DAILY_ALLOWANCE,
                    CITY_FARE_ALLOWANCE_TYPE,nvl(CITY_FARE_ALLOWANCE,0) as CITY_FARE_ALLOWANCE,TA_DESCRIPTION,nvl(TA_AMOUNT,0) as TA_AMOUNT,TA_IMAGE, OE_DESCRIPTION, nvl(OE_AMOUNT,0) as OE_AMOUNT,OE_IMAGE,
                    VERIFIED_BY, VERIFIED_DATE, VERIFIED_STATUS,APPROVED_BY,APPROVED_DATE, APPROVED_STATUS
                    from(
                   SELECT m.DEPOT_NAME,m.EMP_NAME, m.DESIG,m.terr_id,d.EXP_ID,d.EXP_DATE,d.TOUR_TYPE,d.TOUR_DETAILS,d.DAILY_ALLOWANCE,
                     d.EXP_DID, d.CITY_FARE_ALLOWANCE_TYPE,d.CITY_FARE_ALLOWANCE,d.TA_DESCRIPTION,d.TA_AMOUNT,d.TA_IMAGE,d.TA_IMAGE_status, d.OE_DESCRIPTION, d.OE_AMOUNT,
                     d.additional_amount,d.update_status,d.oe_IMAGE_status,d.OE_IMAGE,to_char(m.EXP_MONTH,'Mon-YY') as m_month,m.EMP_ID,
                     substr(m.terr_id,1,instr(m.terr_id,'-',1,1))||trunc(substr(m.terr_id,instr(m.terr_id,'-',-1,1)+1),-1) am_terr_id,
                     substr(m.terr_id,1,instr(m.terr_id,'-'))||'00' rm_terr_id,
                     m.STATUS, m.VERIFIED_BY, m.VERIFIED_DATE, m.VERIFIED_STATUS,m.APPROVED_BY,m.APPROVED_DATE, m.APPROVED_STATUS
                     FROM MIS.EXP_EXPENSE_M m,
                    MIS.EXP_EXPENSE_D d
                    where d.exp_id=m.exp_id )

                    where exp_did=?", [$g_exp_did]);
            }



        }

        //hq so so-hq count tour_tye after edit
        $emp_id=(int)$request->empid;
        $expense_month=$request->month_dy;
        if (Auth::user()->desig=='HO'){
            $summary_tour=DB::select("select tour_type,count(*) as countr
                                from MIS.EXP_EXPENSE_M m,
                                MIS.EXP_EXPENSE_D_APPR d
                                where m.exp_id = d.exp_id
                                and m.emp_id = ?
                                and to_char(m.EXP_MONTH,'Mon-YY') = ?
                                group by tour_type",[$emp_id,$expense_month]);
        }
        else{
            $summary_tour=DB::select("select tour_type,count(*) as countr
                                from MIS.EXP_EXPENSE_M m,
                                MIS.EXP_EXPENSE_D d
                                where m.exp_id = d.exp_id
                                and m.emp_id = ?
                                and to_char(m.EXP_MONTH,'Mon-YY') = ?
                                group by tour_type",[$emp_id,$expense_month]);
        }


        return response()->json([
            "expense"=>$searchdatas,
            "sum_tour_type"=>$summary_tour

        ]);
    }

    public function showimage($uid,$imagetype){


        if(Auth::user()->desig=='HO'){
            $up_status=DB::select("SELECT UPDATE_STATUS FROM MIS.EXP_EXPENSE_D_APPR where EXP_DID=?",[$uid]);
        }else{
            $up_status=DB::select("SELECT UPDATE_STATUS FROM MIS.EXP_EXPENSE_D_APPR where EXP_DID=?",[$uid]);
        }
        $up_status=$up_status[0]->update_status;

        return view('expense.showimge',compact('uid','imagetype','up_status'));

    }

    public function  ExistImgExpense(Request $request,$uid,$imagetype){
        if($request->ajax()){

//            $mmurl='/'+$uid+'/'+'otherExpenseImage.jpg';
//            $destinationPath = '\\192.168.1.13\ExpenseImage\\';//its refers proj/public/up_file directry
//            $galleryId = $uid.'\\'.$imagetype;
//
//            $path =$destinationPath.$galleryId;

//                                http://192.168.1.13:5023/ExpenseImage/exp10095321515347939231/otherExpenseImage.jpg
//            http://localhost/misdashboard/expense/showimage/exp10049001517056055856/otherExpenseImage.jpg

//                                var urlparam = '/'+data.expense[index]['exp_did']+'/'+'otherExpenseImage.jpg';

            $destinationPath = '\\'.'\\192.168.1.13\ExpenseImage\\';//its refers proj/public/up_file directry
            $galleryId = $uid.'\\'.$imagetype;

            $path =$destinationPath.$galleryId;
//                                var mainurl = "{{route(" getImageExist")}}"+urlparam;

//            \\192.168.1.13\ExpenseImage\exp10029291512124994248



            $pp=' ';
            if(file_exists($path)){
//                dd('File is exists.');
                $pp='fileexist';
            }else{
//                dd('File is not exists.');
                $pp='nofileexist';
            }


                 return response()->json(
                     [
                         'exp_ip_id'=>$uid,
                         'exp_oeor'=>$imagetype,
                         'urldata'=>$path,
                         'pp'=>$pp
                     ]);
        }
    }

    public function getDailyAllowance(Request $request){

        if($request->ajax()){
            $tour_type=$request->tour_type;
            $user_desig=$request->user_desig;

            $daily_all=DB::select("SELECT EMP_EXP_ID, DESIG, EXPENSE_TYPE, AMOUNT, CONDITION_TYPE, CREATE_DATE, VALID
            FROM MIS.EXPENSE_TYPE where desig=? and expense_type=?",[$user_desig,$tour_type]);

            return response()->json(
                [
                    'tour_type'=>$tour_type,
                    'daily_all'=>$daily_all
                ]);
        }
    }

    public function getCityAllowance(Request $request){

        if($request->ajax()){
            $city_allw=$request->city_allw;
            $desig=$request->desig;

            $daily_all=DB::select("SELECT EMP_EXP_ID, DESIG, EXPENSE_TYPE, AMOUNT, CONDITION_TYPE, CREATE_DATE, VALID
            FROM MIS.EXPENSE_TYPE where desig=? and expense_type=?",[$desig,$city_allw]);
            return response()->json(
                [
                    'city_all'=>$city_allw,
                    'daily_all'=>$daily_all
                ]);
        }
    }


    public function getAMTerr(Request $request){
        if($request->ajax()){

            $rm_id=$request->rm_id;
            $desig=$request->desig;

            if($desig=='RM'||$desig=='ASM'){
                $daily_all=DB::select("select distinct am_terr_id,substr(am_terr_id,instr(am_terr_id,'-')+1) as am_order
                        from
                        (select  emp_id,d.terr_id,d.am_terr_id,d.rm_terr_id,asm_id,dsm_id,nsm_id,gm_id
                        from (

                            select distinct emp_id,terr_id,substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                               substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id
                               from MIS.EXP_EXPENSE_M) d,(select * from MIS.RM_GM_INFO) rm
                               where d.rm_terr_id = rm.rm_terr_id
                        ) ss
                        where rm_terr_id =? order by  SUBSTR(am_TERR_ID,1,INSTR(am_TERR_ID,'-')),TO_NUMBER(SUBSTR(am_TERR_ID,instr(am_terr_id,'-', -1)+1)) asc",[$rm_id]);

                

                // if rm name is empty then asm_name...24.06.2019
                
                $rm_name=DB::select("select NVL(RM_NAME,ASM_NAME) RM_NAME  
                                  from MIS.RM_GM_INFO 
                                  where RM_TERR_ID=?",[$rm_id]);

            }else if($desig=='HO'){

                $daily_all=DB::select("select distinct substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
            substr(substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),instr(substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),'-')+1) as am_order
            from MIS.EXP_EXPENSE_M where substr(terr_id,1,instr(terr_id,'-'))||'00' =?
            order by SUBSTR(am_TERR_ID,1,INSTR(am_TERR_ID,'-')),TO_NUMBER(SUBSTR(am_TERR_ID,instr(am_terr_id,'-', -1)+1)) asc",[$rm_id]);

          // if rm name is empty then asm_name...24.06.2019
                
                $rm_name=DB::select("select NVL(RM_NAME,ASM_NAME) RM_NAME  
                                  from MIS.RM_GM_INFO 
                                  where RM_TERR_ID=?",[$rm_id]);

            }

            return response()->json(
                [
                    'rm_data'=>$daily_all,
                    'rm_name'=>$rm_name
                ]);
        }
    }


    public function getEmpId(Request $request){
        if($request->ajax()){

            $rm_id=$request->rm_id;
            $am_id=$request->am_id;
            $desig=$request->desig;
            $emon = $request->exp_mon;

            if($desig=='AM'||$desig=='Sr. AM'){
                $daily_all=DB::select("select distinct emp_id,terr_id,approved_status
                                from
                                (select  emp_id,d.terr_id,d.am_terr_id,d.rm_terr_id,asm_id,dsm_id,nsm_id,gm_id,approved_status
                                from (
                                                        
                                select distinct emp_id,terr_id,substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                                       substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,approved_status
                                       from MIS.EXP_EXPENSE_M where exp_month = to_date('$emon','Mon-RR') and desig not in ('AM','Sr. AM')) d,(select * from MIS.RM_GM_INFO) rm
                                       where d.rm_terr_id = rm.rm_terr_id
                                ) ss
                                where rm_terr_id = ?
                                and am_terr_id = ?",[$rm_id,$am_id]);


                $am_name = DB::select("SELECT distinct am_name as name,to_char(emp_month,'MON-yy') as mm,emp_month mmonth,am_terr_id,rm_terr_id from hrtms.hr_terr_list@web_to_hrtms
                                where am_terr_id =?
                                and rm_terr_id=?
                                and to_char(emp_month,'Mon-YY')=?",[$am_id,$rm_id,$emon]);

            }

            else if($desig=='RM'||$desig=='ASM'){
                $daily_all=DB::select("select distinct emp_id,terr_id,approved_status
                                from
                                (select  emp_id,d.terr_id,d.am_terr_id,d.rm_terr_id,asm_id,dsm_id,nsm_id,gm_id,approved_status
                                from (

                                select distinct emp_id,terr_id,substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                                       substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,approved_status
                                       from MIS.EXP_EXPENSE_M where exp_month = to_date('$emon','Mon-RR') ) d,(select * from MIS.RM_GM_INFO) rm
                                       where d.rm_terr_id = rm.rm_terr_id
                                ) ss
                                where rm_terr_id = ?
                                and am_terr_id = ?",[$rm_id,$am_id]);


                $am_name = DB::select("SELECT distinct am_name as name,to_char(emp_month,'MON-yy') as mm,emp_month mmonth,am_terr_id,rm_terr_id from hrtms.hr_terr_list@web_to_hrtms
                                where am_terr_id =?
                                and rm_terr_id=?
                                and to_char(emp_month,'Mon-YY')=?",[$am_id,$rm_id,$emon]);

            }



            else if($desig=='HO') {

                if ($am_id == 'ALL') {

                    $daily_all = DB::select("select distinct emp_id,terr_id,approved_status from MIS.EXP_EXPENSE_M
                          where substr(terr_id,1,instr(terr_id,'-'))||'00' = '$rm_id'
                         and exp_month = to_date('$emon','Mon-RR')");



                    $am_name = DB::select("SELECT distinct am_name as name,to_char(emp_month,'MON-yy') as mm,emp_month mmonth,am_terr_id,rm_terr_id from hrtms.hr_terr_list@web_to_hrtms
                                where  rm_terr_id=?
                                and to_char(emp_month,'Mon-YY')=?",[$rm_id,$emon]);

                }
                else{

                    $daily_all = DB::select("select distinct emp_id,terr_id,approved_status from MIS.EXP_EXPENSE_M
                          where substr(terr_id,1,instr(terr_id,'-'))||'00' = '$rm_id'
                and substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) = '$am_id' and exp_month = to_date('$emon','Mon-RR')");



                    $am_name = DB::select("SELECT distinct am_name as name,to_char(emp_month,'MON-yy') as mm,emp_month mmonth,am_terr_id,rm_terr_id from hrtms.hr_terr_list@web_to_hrtms
                                where am_terr_id =?
                                and rm_terr_id=?
                                and to_char(emp_month,'Mon-YY')=?",[$am_id,$rm_id,$emon]);

                }

               
            }

            return response()->json(
                [
                    'am_data'=>$daily_all,
                    'am_name'=>$am_name,
                    'desig'=>$desig,
                    'qry'=>"select distinct emp_id,terr_id,approved_status from MIS.EXP_EXPENSE_M
                          where substr(terr_id,1,instr(terr_id,'-'))||'00' = '$rm_id'
                and substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) = '$am_id' and exp_month = to_date('$emon','Mon-RR')"
                ]);
        }
    }

    public function finalSubmit(Request $request){
        if($request->ajax()){

            $exp_id=$request->exp_id;

            if($request->status=='approve'){
                $up=DB::table('mis.exp_expense_m')
                    ->where('exp_id', $exp_id)
                    ->update(
                        [
                            'APPROVED_BY' => Auth::user()->user_id,
                            'APPROVED_DATE'=>\Carbon\Carbon::now(),
                            'APPROVED_STATUS'=>$request->app_state



                        ]);
            }else if($request->status=='verify'){

                $up=DB::table('mis.exp_expense_m')
                    ->where('exp_id', $exp_id)
                    ->update(
                        [
                            'VERIFIED_BY' => Auth::user()->user_id,
                            'VERIFIED_DATE'=>\Carbon\Carbon::now(),
                            'VERIFIED_STATUS'=>$request->veri_state



                        ]);
            }

            return response()->json($up);
        }
    }

    public function DeleteExpense(Request $request)
    {
        if ($request->ajax()){
            DB::table('MIS.EXP_EXPENSE_D')->where('EXP_DID',$request->uid)->delete();

            //hq so so-hq count tour_tye after remove
            $emp_id=(int)$request->empid;
            $expense_month=$request->month_dy;
            if (Auth::user()->desig=='HO'){
                $summary_tour=DB::select("select tour_type,count(*) as countr
                                from MIS.EXP_EXPENSE_M m,
                                MIS.EXP_EXPENSE_D_APPR d
                                where m.exp_id = d.exp_id
                                and m.emp_id = ?
                                and to_char(m.EXP_MONTH,'Mon-YY') = ?
                                group by tour_type",[$emp_id,$expense_month]);
            }
            else{
                $summary_tour=DB::select("select tour_type,count(*) as countr
                                from MIS.EXP_EXPENSE_M m,
                                MIS.EXP_EXPENSE_D d
                                where m.exp_id = d.exp_id
                                and m.emp_id = ?
                                and to_char(m.EXP_MONTH,'Mon-YY') = ?
                                group by tour_type",[$emp_id,$expense_month]);
            }


            return response()->json([
                "uid"=>$request->uid,
                "sum_tour_type"=>$summary_tour

            ]);

//            return response()->json($request->uid);
        }

    }








}
