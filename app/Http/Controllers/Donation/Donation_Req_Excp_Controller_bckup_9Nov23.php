<?php

namespace App\Http\Controllers\Donation;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class Donation_Req_Excp_Controller extends Controller
{
    public function __construct()
    {}

    public function index()
    {
        return view('donation.donation_requisition_exception_v2');
    }

    public function getInitialData()
    {
        DB::setDateFormat('DD-MON-RR');

        $donation_type = DB::select("select type_name ,gl,main_cost_center_name,
                                       case when type is null then 'SALES' else type end type,
                                       type_name||case when main_cost_center_name = 'MSD' then ' (MARKETING)' else ' ('||main_cost_center_name||')'  end type_mct
                                     from mis.donation_type_master
                                     order by MAIN_COST_CENTER_NAME desc,type_name 
                                     ");

        $beneficiary = DB::select("select dbt_description,COST_CENTER_TYPE
                            from mis.donation_beneficiary_type_d
                            order by dbt_id
                            
                            ");

        $purpose = DB::select("select distinct purpose_name
                    from mis.donation_purpose_master
                    ORDER BY purpose_name DESC
                  ");

        $frequency = DB::select("select df_description
                    from mis.donation_frequency
                    order by df_id");

        $depot = DB::select("select d_id,name 
                             from msfa.depot@web_to_imsfa");

        $month_name = DB::select("select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
                                  from
                                    (
                                    with data as (select level l from dual connect by level <= 3)
                                    select *
                                      from (select trunc(add_months(sysdate, -2)) dt from dual), data
                                     order by dt, l
                                     )
                                   ");

        $dataArray = [
            'dtype' => $donation_type,
            'benf' => $beneficiary,
            'purpose' => $purpose,
            'freq' => $frequency,
            'pmonth' => $month_name,
            'depot' => $depot
        ];

        return response()->json($dataArray);
    }

    public function getAmTerrByDepot(Request $request){
        DB::setDateFormat('DD-MON-RR');
        return response()->json(DB::select("select distinct am_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where d_id = ?
                                and emp_month = to_date(trunc(sysdate,'MM'),'DD-MON-RR')
                                order by am_terr_id",[explode('|',$request->depot)[0]]));
    }


    public function getDoctorInfoTerrById(Request $request)
    {
        DB::setDateFormat('DD-MON-RR');

        $dter = null;
        $dcn = null;

        if($request->doc_id && !$request->doc_terr){
            $dter = DB::select("select terr_id,hr.mpo_emp_id eid,upper(hr.mpo_name) ename
                            from MIS.DOCTOR_WISE_TERRITORY msfa,hrtms.hr_terr_list@web_to_hrtms hr
                            where msfa.terr_id = hr.mpo_terr_id
                            and hr.emp_month = to_date(trunc(sysdate,'MM'),'DD-MON-RR')
                            and msfa.doctor_id = ?
                            union all
                            select terr_id, null eid,' ' ename                          
                            from doctor_info.DOCTOR_FOR_REGION@web_to_sample_msd
                            where doctor_id = ?", [$request->doc_id,$request->doc_id]);

        }elseif ($request->doc_id && $request->doc_terr){
            $dcn = DB::select("select distinct dc.doctor_id,dc.doctor_name,no_of_patient,nvl(mobile,phone) mobile,nvl(hospital_address,chember_address) address,
                                    case when dt.in_favour_of is null then dc.doctor_name else dt.in_favour_of end in_favour_of,s.details speciality
                                    from doctor_info.doctor_information@web_to_sample_msd dc,MIS.DOCTOR_WISE_TERRITORY dt  ,p4aug.speciality_code@web_to_sample_msd s
                                    where dc.doctor_id = ?
                                    and dt.terr_id = ?  
                                    and dc.spec_code = s.code(+)
                                    and dt.valid = 'YES'
                                    and dc.doctor_id = dt.doctor_id
                                    union all 
                                    select doctor_id,doctor_name,no_of_patient,mobile,address,in_favour_of,speciality
                                    from(                         
                                    select doctor_id,doctor_name,null no_of_patient,' ' mobile,' ' address,' ' in_favour_of,' ' speciality,terr_id                         
                                    from doctor_info.DOCTOR_FOR_REGION@web_to_sample_msd
                                    )
                                    where doctor_id = ?
                                    and terr_id = ? ", [$request->doc_id,explode('|',$request->doc_terr)[0],
                                $request->doc_id,explode('|',$request->doc_terr)[0]]);
        }

        $response = ['dinfo' => $dcn, 'dterr' => $dter];
        return response()->json($response);
    }

    public function getDoctorNameWiseTerr(Request $request)
    {
        DB::setDateFormat('DD-MON-RR');

        $dterr = DB::select("select distinct terr_id,hr.mpo_emp_id eid,upper(hr.mpo_name) ename
                                from msfa.doctor_terr@WEB_TO_IMSFA msfa,hrtms.hr_terr_list@web_to_hrtms hr
                                where msfa.terr_id = hr.mpo_terr_id
                                and hr.emp_month = to_date(trunc(sysdate,'MM'),'DD-MON-RR')
                                and hr.am_terr_id = ?
                                and hr.mpo_emp_id is not null
                                order by terr_id", [$request->amterr]);
        return response()->json($dterr);

    }

    public function getGbrInformation(Request $request)
    {
        DB::setDateFormat('DD-MON-RR');
        $dtype = explode('|', $request->dtype);
        //Log::info($dtype);
        //Log::info($request->terr);

        $response = [
            'type' => $dtype[0],
            'val' => []
        ];
        if ($dtype[3] == 'BRAND RESEARCH') {
            $scn = DB::select("
                select cost_center_id,sub_cost_center_id,sub_cost_center_name cost_center_name
                                from
                           (select distinct dscc.cost_center_id cost_center_id,dscc.sub_cost_center_id sub_cost_center_id,dscc.sub_cost_center_name sub_cost_center_name,dcc.cost_center_group
                                from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
                                where department = 'MSD'
                                and budget_type = 'DONATION'
                                and dcc.cost_center_id = dscc.cost_center_id
                                and sub_cost_center_type = 'BRAND') ccd,(select distinct p_group,substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' region
                               from hrtms.hr_terr_list@web_to_hrtms ht
                               where to_char(ht.emp_month,'DD-MON-YY') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                               and mpo_terr_id = ?
                               and p_group <> 'GENERAL'
                           union all
                           select case when l = 1 then 'CELLBIOTIC' else case when l = 2 then 'KINETIX' else
                                  case when l = 3 then 'ZYMOS' else null end end end p_group,substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' region
                           from hrtms.hr_terr_list@web_to_hrtms ht,(select level l from dual connect by level <=3)
                           where to_char(ht.emp_month,'DD-MON-YY')= to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                           and mpo_terr_id = ?
                           and p_group = 'GENERAL') tgr
                          where cost_center_group = tgr.p_group
                          union all 
                          select  1000101008 cost_center_id, 1000101008034 sub_cost_center_id, 'PANTONIX(KINETIX)' cost_center_name
                          from dual
                ",[$request->terr,$request->terr]);
            $response['val'] = $scn;
        } else if ($dtype[3] == 'REGION DEVELOPMENT') {
             $scn = DB::select("

                    select distinct cost_center_id,sub_cost_center_id,sub_cost_center_name cost_center_name
                    from
                    (select distinct dscc.cost_center_id cost_center_id,dscc.sub_cost_center_id sub_cost_center_id,
                    dscc.sub_cost_center_name sub_cost_center_name,cost_center_region,cost_center_region_name,cost_center_group,
                    case when cost_center_group in ('CELLBIOTIC','KINETIX','ZYMOS') then 'GENERAL' else cost_center_group end cc_group
                    from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
                    where department = 'SALES'
                    and budget_type = 'DONATION'
                    and dcc.cost_center_id = dscc.cost_center_id
                    and sub_cost_center_type = 'REGION') ccd,(select distinct substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' terr_region  
                    from hrtms.hr_terr_list@web_to_hrtms ht
                    where to_char(ht.emp_month,'DD-MON-YY')= to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                    and mpo_terr_id = ?) tgr
                    where cost_center_region = tgr.terr_region 
                    union all 
                    select cost_center_id,sub_cost_center_id,sub_cost_center_name cost_center_name
                    from mis.donation_sub_cost_center
                    where cost_center_region = ?              
                ",[$request->terr,$request->terr]);
            $response['val'] = $scn;
        }
        else if ($dtype[3] == 'BRAND RESEARCH SALES') {
            $scn = DB::select("
                 select cost_center_id,sub_cost_center_id,sub_cost_center_name cost_center_name
                    from
                    (select distinct dscc.cost_center_id cost_center_id,dscc.sub_cost_center_id sub_cost_center_id,
                    dscc.sub_cost_center_name sub_cost_center_name,dcc.cost_center_group,
                    substr(sub_cost_center_name,instr(sub_cost_center_name,'(')+1,instr(sub_cost_center_name,')')- instr(sub_cost_center_name,'(')-1 ) scc 
                    from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
                    where department = 'SALES'
                    and budget_type = 'DONATION'
                    and dcc.cost_center_id = dscc.cost_center_id
                    and sub_cost_center_type = 'BRAND') ccd,(select distinct p_group,substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' region  
                    from hrtms.hr_terr_list@web_to_hrtms ht
                    where to_char(ht.emp_month,'DD-MON-YY') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                    and mpo_terr_id = ? and p_group <> 'GENERAL'
                    union all
                    select case when l = 1 then 'CELLBIOTIC' else case when l = 2 then 'KINETIX' else
                    case when l = 3 then 'ZYMOS' else null end end end p_group,substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' region  
                    from hrtms.hr_terr_list@web_to_hrtms ht,(select level l from dual connect by level <=3)
                    where to_char(ht.emp_month,'DD-MON-YY')= to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                    and mpo_terr_id = ? and p_group = 'GENERAL') tgr                   
                    where 
                    scc = tgr.p_group
                       ORDER BY cost_center_name
                ",[$request->terr,$request->terr]);
            $response['val'] = $scn;
        }

        else if ($dtype[0] == 'SALES') {
            $scn = DB::select("
                            select cost_center_id,cost_center_description cost_center_name
                            from
                            (select distinct cost_center_id,cost_center_description,cost_center_group
from mis.donation_cost_center
where budget_type = 'DONATION' and department = 'SALES' and cost_center_id not in (1000101014,1000101015,1000100109) ) dcc,(select distinct case when p_group in ('ASTER','GYRUS','LUCENT') then 'ASTER-GYRUS' else
                                                                    case when p_group = 'OPERON-XENOVISION' then 'OPERON-XENOVISION' else
                                                                    case when p_group in ('CELLBIOTIC','KINETIX','ZYMOS','GENERAL') then 'GENERAL' else 
                                                                    case when p_group = 'ANIMAL HEALTH & VACCINE DIVISION'then p_group else null end end end end p_group
                                                             from hrtms.hr_terr_list@web_to_hrtms ht
                                                             where to_char(ht.emp_month,'DD-MON-YY')= (select to_char(trunc(sysdate,'mm'),'DD-MON-YY')  from dual)
                                                             and mpo_terr_id = ?) hpg
                            where dcc.cost_center_group = hpg.p_group
                            ",[$request->terr]);
            $response['val'] = $scn;
        }
        return response()->json($response);
    }

    public function save_requisitions(Request $request){
        $req_id = [];
        //insert requisitions and hold req_id
        foreach ($request->req as $r){
            $mpoInfo = explode('|',$r['mpo_terr']);
            $depot = explode('|',$request->depot);
            $d_type = explode('|',$r['exp_type']);
            $gbr = explode('|',$r['gbr_name'] ? $r['gbr_name'] : '|||');
            $beneficiary = explode('|',$request->benif);

            $record = [
               'REQ_ID' => $this->getMaxReqId(),
               'REQ_DATE' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
               'EMP_ID' => $mpoInfo[1],
               'EMP_NAME' => $mpoInfo[2],
               'TERR_ID' => $mpoInfo[0],
               'D_ID' => $depot[0],
               'D_NAME' => $depot[1],
               'DONATION_TYPE' => $d_type[3],
               'GROUP_BRAND_REGION_NAME' => $gbr[1],
               'GL' => $d_type[1],
               'COST_CENTER_ID' => $gbr[0],
               'SUB_COST_CENTER_ID' => $gbr[2],
               'BENEFICIARY_TYPE' => $beneficiary[0],
               'PAYMENT_MODE' => $r['pay_mode'],
               'PURPOSE' => $request->purpose,
               'FREQUENCY' => $r['frequency'] ? $r['frequency'] : '',
               'PAYMENT_MONTH' => $request->month,
               'PROPOSED_AMOUNT' => $r['proposed_amt'],
               'DOCTOR_ID' => $r['doc_id'],
               'DOCTOR_NAME' => strtoupper($r['doc_name']),
               'NO_OF_PATIENT' => $r['no_patient'],
               'CONTACT_NO' => $r['mobile'],
               'IN_FAVOUR_OF' => strtoupper($r['ifav']),
               'IN_FAVOUR_OF_MAIN' => strtoupper($r['ifav']),
               'ADDRESS' => $r['address'],
               'SPECIALITY' => $r['spec'],
               'COMMITMENT' => 'DRE',
               'STATUS' => 'YES',
               'CREATE_USER' => Auth::user()->user_id,
               'CREATE_DATE' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
            ];

            if($beneficiary[0]=='ASSOCIATION'){

                $record['GL'] = '52010085';
                $record['DONATION_TYPE'] = 'RESEARCH EXPENSE';

            }

            if($beneficiary[0]=='CHEMIST'){

                $record['GL'] = '52011200';

//                $cost = DB::select('select cost_center_id from MIS.donation_cost_center where cost_center_group =?',[$beneficiary[1]]);
//                    $record['COST_CENTER_ID'] = $cost[0]->cost_center_id;
//                    $record['SUB_COST_CENTER_ID'] = null;
            }

            if($beneficiary[0]=='COMBINED'){
                $cc = DB::select('select cost_center_id from MIS.donation_cost_center where cost_center_group =? and budget_type = ?',['COMMON','DONATION']);
                    $record['COST_CENTER_ID'] = $cc[0]->cost_center_id;
                    $record['SUB_COST_CENTER_ID'] = null; 
            }
            if ($request->purpose =='CANCELLATION PREVIOUS YEAR' ){
                $record['GL'] = '15940040';
            }

            if($d_type[0] === 'SALES' && $d_type[3] != 'BRAND RESEARCH SALES'){
                $record['GROUP_BRAND_REGION_NAME'] = null;
            }

            $status = DB::table('MIS.DONATION_REQUISITION')->insert($record);
            if($status){
                $req_id[] = $record['REQ_ID'];
            }

        }

        //update based on stored req_id
        foreach ($req_id as $rq){     
            try{
                $procedureName = 'mis.pro_terr_wise_am_rm_name';
                $bindings = [
                    'pmonth'  => $request->month,
                    'exp_rid'  => $rq,
                    'entry_emp_id'  => Auth::user()->user_id,
                    'entry_emp_name'  => Auth::user()->name
                ];

                $pstat = DB::executeProcedure($procedureName, $bindings);
                //Log::info($pstat);
            }catch(Exception $exception){
                Log::info($exception->getMessage());
            }        
        }

        return response()->json(['message'=>'success']);
    }

    public function getMaxReqId(){
         $max_id = DB::select('select nvl(max(req_id),0)+1 req_id
                            from MIS.DONATION_REQUISITION');

         return $max_id[0]->req_id;
    }

    public function checkDoctorExpenseEligibility(Request $request){
        //Log::info($request->all());
        DB::setDateFormat('DD-MON-RR');
        $status = DB::select("select count(*) req_npm
                    from(
                    select distinct payment_month,frequency,
                           case when frequency = 'MONTHLY' then add_months(to_date(payment_month,'MON-RR'),1) else
                           case when frequency = 'BI-MONTHLY' then add_months(to_char(to_date(payment_month,'MON-RR'),'DD-MON-RR'),2) else
                           case when frequency = 'QUARTERLY' then add_months(to_char(to_date(payment_month,'MON-RR'),'DD-MON-RR'),3) else
                           case when frequency = 'HALF YEARLY' then add_months(to_char(to_date(payment_month,'MON-RR'),'DD-MON-RR'),6) else
                           case when frequency = 'YEARLY' then add_months(to_char(to_date(payment_month,'MON-RR'),'DD-MON-RR'),12) else null end end end end end np_month
                    from mis.DONATION_REQ_CORRECTION
                    where donation_type in ('BRAND RESEARCH','REGION DEVELOPMENT','BRAND RESEARCH SALES')
                    and to_date(payment_month,'MON-RR') between add_months(to_char(to_date(?,'MON-RR'),'DD-MON-RR'),-11) and to_date(?,'MON-RR')
                    and terr_id = ?
                    and doctor_id = ?
                    and donation_type = ?
                    and sub_cost_center_id = ?
                    )where np_month > to_date(?,'MON-RR')
                    ",[$request['pay_month'],$request['pay_month'],$request['terr_id'],$request['doc_id'],$request['d_type'],$request['gbr_name'],$request['pay_month']]);

        return response()->json(['status'=>$status[0]->req_npm]);
    }
}
