<?php

namespace App\Http\Controllers;

use App\Mobi_service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerInfoRepController extends Controller
{
    public function customerinforeportview()
    {
        DB::setDateFormat('DD-MON-RR');
        $uid = Auth::user()->user_id;

        $rm_terr = null;
        $am_terr = null;
        $mpo_terr = null;
        if (Auth::user()->desig == 'HO') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO)  and  p_group = 'HYGIENE'   
                                    order by rm_terr_id");
            $am_terr = [];
            $mpo_terr = [];

        } elseif (Auth::user()->desig === 'TSO' || Auth::user()->desig === 'Sr. TSO') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')  
                                and  p_group = 'HYGIENE'
                                and mpo_emp_id = ?", [$uid]);

            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and  p_group = 'HYGIENE'
                                    and mpo_emp_id  =?", [$uid]);

            $mpo_terr = DB::select("select distinct mpo_terr_id mpo_terr_id,mpo_emp_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and  p_group = 'HYGIENE'
                                    and mpo_emp_id  =?", [$uid]);

        } elseif (Auth::user()->desig === 'AM' || Auth::user()->desig === 'Sr. AM') {

            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and  p_group = 'HYGIENE'
                                and am_emp_id = ?", [$uid]);

            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and  p_group = 'HYGIENE'
                                    and am_emp_id  =?", [$uid]);
            $mpo_terr = DB::select("select distinct mpo_terr_id mpo_terr_id,mpo_emp_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and  p_group = 'HYGIENE'
                                    and am_emp_id  =?", [$uid]);
        } elseif (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO)  and  p_group = 'HYGIENE'   
                                    order by rm_terr_id");
            $am_terr = [];
            $mpo_terr = [];

        }

//        var_dump($rm_terr);
        return view('Neocare.customer_info_rep', compact('rm_terr', 'am_terr', 'mpo_terr'));
    }

    public function customerinforeport(Request $request)
    {
        DB::setDateFormat('DD-MM-RR');
        //Log::info($request->all());
        $data = [];
        parse_str($request->formdata, $data);
//        Log::info(Carbon::parse($data['datefrom'])->isoformat('d-M-y'));
        //Log::info($data);

        $output =
            DB::select("
                        select *
                        from(
                        select dui.terr_id,dui.user_id,dui.name, nci.name pname,baby_name,age,sample_size,contact_no,nci.email,
                        case when terr_id <> 'NA' then 
                        substr(dui.terr_id,1,instr(dui.terr_id,'-',1,1))||trunc(substr(dui.terr_id,instr(dui.terr_id,'-',-1,1)+1),-1)
                        else 'NA' end    am_terr_id,
                        case when terr_id <> 'NA' then substr(dui.terr_id,1,instr(dui.terr_id,'-'))||'00' 
                        else 'HYGH1-00' end rm_terr_id,nci.create_user,nci.create_date 
                        from mis.neo_customer_info nci,mis.dashboard_users_info dui
                        where nci.create_user = dui.user_id 
                        and p_group = 'HYGIENE'
                        )
                        where  create_user = decode(?,'all',create_user,?)
                        and rm_terr_id = ?
                        and am_terr_id = decode(?,'all',am_terr_id,?)
                        and to_date (create_date ,'DD-MM-RR') between to_date(?,'DD-MM-RR') and to_date(?,'DD-MM-RR')", [$data['terr_id'],
                        $data['terr_id'],
                        $data['rm_terr_id'],
                        $data['am_terr_id'],
                        $data['am_terr_id'],
                        $data['datefrom'],
                        $data['dateto']]

            );

        //Log::info($output);
        return response()->json($output);

    }

    public function getramterr(Request $request)
    {
        DB::setDateFormat('DD-MON-RR');
        $resp_data = DB::Select("select distinct am_terr_id am_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MM'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO )  
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rm_terr'
                                    and am_terr_id not like '%-500%' 
                                    and p_group = 'HYGIENE'
                                    order by am_terr_id");
        return response()->json($resp_data);
    }

    public function getmpoterr(Request $request)
    {
        DB::setDateFormat('DD-MON-RR');
        $resp_data = null;
        if ($request->am_terr == 'all') {
            $resp_data = DB::select('select distinct USER_ID mpo_emp_id,TERR_ID mpo_terr_id
                                from mis.dashboard_users_info 
                                where P_group = ? 
                                
                                order by TERR_ID', ["HYGIENE"]);
        } else {


            $resp_data = DB::Select("select DISTINCT tl.mpo_terr_id mpo_terr_id,tl.mpo_emp_id mpo_emp_id
                                    from hrtms.hr_terr_list@web_to_hrtms tl
                                    where tl.am_terr_id = '$request->am_terr'
                                    and tl.emp_month = trunc(sysdate,'MM')    
                                    and tl.am_terr_id not like '%-500%' 
                                    and tl.p_group = 'HYGIENE'                                
                                    order by TO_NUMBER(SUBSTR( tl.mpo_terr_id,instr( tl.mpo_terr_id,'-', -1)+1))");
        }
        return response()->json($resp_data);
    }
	
	 ////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////Send SMS Portion///////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////
    public function neosms()
    {
        DB::setDateFormat('DD-MON-RR');
        $uid = Auth::user()->user_id;

        $rm_terr = null;
        $am_terr = null;
        $mpo_terr = null;

        $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO)  and  p_group = 'HYGIENE'   
                                    order by rm_terr_id");

        $sample = DB::select("select sample_size size1
                                from MIS.NEO_SAMPLE_SIZE");

        $am_terr = [];
        $mpo_terr = [];
        return view('Neocare.Neo_sms_portion', compact('rm_terr', 'am_terr', 'mpo_terr', 'sample'));

    }

    public function customersmsdata(Request $request)
    {
        DB::setDateFormat('DD-MM-RR');
        //Log::info($request->all());
        $data = [];
        parse_str($request->formdata, $data);

        //Log::info($data);

        $output =
            DB::select("select *
                        from(
                            select dui.terr_id,dui.user_id,dui.name, nci.name pname,baby_name,age,sample_size,contact_no,nci.email,
                               case when terr_id <> 'NA' then 
                                  substr(dui.terr_id,1,instr(dui.terr_id,'-',1,1))||trunc(substr(dui.terr_id,instr(dui.terr_id,'-',-1,1)+1),-1)
                               else 'NA' end    am_terr_id,
                               case when terr_id <> 'NA' then substr(dui.terr_id,1,instr(dui.terr_id,'-'))||'00' 
                               else 'HYGH-00' end rm_terr_id,nci.create_user,nci.create_date 
                        from mis.neo_customer_info nci,mis.dashboard_users_info dui
                        where nci.create_user = dui.user_id 
                        and p_group = 'HYGIENE'
                        )
                        where  create_user = decode(?,'all',create_user,?)
                        and rm_terr_id = ?
                        and am_terr_id = decode(?,'all',am_terr_id,?)
                        and to_date (create_date ,'DD-MM-RR') between to_date(?,'DD-MM-RR') and to_date(?,'DD-MM-RR')",
                [$data['terr_id'],
                    $data['terr_id'],
                    $data['rm_terr_id'],
                    $data['am_terr_id'],
                    $data['am_terr_id'],
                    $data['datefrom'],
                    $data['dateto']]);

        //Log::info($output);
        return response()->json($output);

    }
    
    public function reportview1(Request $request)
    {
        DB::setDateFormat('DD-MM-RR');
        //Log::info($request->all());
        $data = [];
        parse_str($request->formdata, $data);
        //Log::info($data);

        $output2 =
            DB::select("select distinct terr_id,user_id,uname name, pname,baby_name,age,sample_size,contact_no,email from(
                        select  dui.terr_id,dui.user_id,dui.name uname, nci.name pname,baby_name,age,sample_size,contact_no,nci.email,
                           case when terr_id <> 'NA' then 
                              substr(dui.terr_id,1,instr(dui.terr_id,'-',1,1))||trunc(substr(dui.terr_id,instr(dui.terr_id,'-',-1,1)+1),-1)
                           else 'NA' end    am_terr_id,
                           case when terr_id <> 'NA' then substr(dui.terr_id,1,instr(dui.terr_id,'-'))||'00' 
                           else 'HYGH-00' end rm_terr_id,nci.create_user,nci.create_date 
                    from mis.neo_customer_info nci,mis.dashboard_users_info dui
                    where nci.create_user = dui.user_id 
                    and p_group = 'HYGIENE'
                    )
                    where  create_user = decode(?,'all',create_user,?)
                    and rm_terr_id = ?
                    and am_terr_id = decode(?,'all',am_terr_id,?)
                    and to_date (create_date ,'DD-MM-RR') between to_date(?,'DD-MM-RR') and to_date(?,'DD-MM-RR')
                    and sample_size = ?
                    and age between ? and ?",
                [$data['terr_id'],
                    $data['terr_id'],
                    $data['rm_terr_id'],
                    $data['am_terr_id'],
                    $data['am_terr_id'],
                    $data['datefrom'],
                    $data['dateto'],
                    $data['size'],
                    $data['from'],
                    $data['to']]);

        //Log::info($output2);
        return response()->json($output2);
    }

    public function save_group(Request $request)
    {
//         Log::info($request->all());
        if ($request->tab_data) {
            $existingRecord = [];
            $grp_id = $this->getMaxReqId();
            foreach (json_decode(json_encode($request->tab_data)) as $td) {

                $existing = DB::select('Select * from mis.neo_sms_group where contact_no = ?', [$td->contact_no]);

                //Log::info($existing);
                //Log::info($td->contact_no);
                if (count($existing)) {
                    $existingRecord[] = $existing;
                } else {
                    $row = [
                        'group_id' => $grp_id,
                        'group_name' => $request->gname ? $request->gname : 'NG',
                        'terr_id' => $td->terr_id,
                        'emp_id' => $td->user_id,
                        'emp_name' => $td->name,
                        'parent_name' => $td->pname,
                        'baby_name' => $td->baby_name,
                        'age' => $td->age,
                        'sample_size' => $td->sample_size,
                        'contact_no' => $td->contact_no,
                        'email' => $td->email,
                        'create_user' => Auth::user()->user_id,
                        'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
                    ];

                    try {
                        DB::table('mis.neo_sms_group')->insert($row);
                    } catch (\Exception $ex) {
                        Log::info('Group Create Error');
                        Log::info($ex->getMessage());
                    }
                }
            }

            $response = [
                'status' => 'I',
                'drecord' => $existingRecord
            ];
            return response()->json($response);
        }
    }

    public function getMaxReqId()
    {
        $max_id = DB::select('select nvl(max(group_id),0)+1 g_id
                            from mis.neo_sms_group');

        return $max_id[0]->g_id;
    }

    public function getGroupList(Request $request)
    {
        if ($request->ajax()) {
            $groupList = DB::select("select id,text||' - '||'Total Records ('||rowsd||')' text
                                    from(
                                    Select distinct group_id id,group_name text,count(*) rowsd 
                                    from mis.neo_sms_group
                                    group by group_id,group_name 
                                    order by group_id)");

            return response()->json(['results' => $groupList]);
        }
    }

    public function sendSmsToCustomer(Request $request)
    {
//        Log::info($request->all());
        try {
            DB::insert('insert into mis.sms_send_status_log 
             select * from mis.sms_send_status');

            DB::delete('delete from mis.sms_send_status');

            $groups = DB::select("select distinct group_id,contact_no cno
                                    from mis.neo_sms_group
                                    where group_id in (" . implode(',', $request->sgroup) . ")
                                    order by group_id
                                    ");

            $totalSentSms = 0;
            $api = new Mobi_service();
            foreach ($groups as $g) {
                //Log::info($g->cno);
                $status = $api->sendMessage('88'.$g->cno, trim($request->mtext).'/'.$g->cno);
                $totalSentSms++;
            }

            $status = [
                'triggerd_from' => 'C:CustomerInfoRepController|M:sendSmsToCustomer',
                'status_text' => 'Y',
                'sms_count' => $totalSentSms,
                'sms_group' => 'Neo Sms Group:' . implode(',', $request->sgroup),
                'create_user' => Auth::user()->user_id,
                'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
            ];

            DB::table('mis.sms_send_status')->insert($status);

        } catch (\Exception $ex) {
            Log::info($ex->getMessage());
            $status = [
                'triggerd_from' => 'C:CustomerInfoRepController|M:sendSmsToCustomer',
                'status_text' => 'N',
                'status_text2' => 'Error Occured',
                'sms_count' => $totalSentSms,
                'sms_group' => 'Neo Sms Group:' . implode(',', $request->sgroup),
                'create_user' => Auth::user()->user_id,
                'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
            ];

            DB::table('mis.sms_send_status')->insert($status);
        }


        // Log::info($groups);
        return response()->json($request->all());
    }

    public function check_sms_send_stat()
    {
        $status = DB::select('Select distinct status_text st,status_text2 st2,sms_count sc 
                             from mis.sms_send_status');
        return response()->json([
                'status' => $status[0]->st, 'count' => $status[0]->sc, 'error' => $status[0]->st2
            ]);
    }

     //single/multi message added on 27-apr-20
    public function sendSingleSMS(Request $request){

        try{
            DB::insert('insert into mis.sms_send_status_log 
             select * from mis.sms_send_status');

            DB::delete('delete from mis.sms_send_status');

            $numbers = explode(',',trim($request->sms_numb));

            $totalSentSms = 0;
            $api = new Mobi_service();
            foreach ($numbers as $n) {
                //Log::info($g->cno);
                $status = $api->sendMessage('88'.$n, trim($request->mtext).'/'.$n);
                $totalSentSms++;
            }

            $status = [
                'triggerd_from' => 'C:CustomerInfoRepController|M:sendSingleSMS',
                'status_text' => 'Y',
                'sms_count' => $totalSentSms,
                'sms_group' => 'N/A',
                'create_user' => Auth::user()->user_id,
                'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
            ];

            DB::table('mis.sms_send_status')->insert($status);

        }catch (\Exception $ex){
            Log::info($ex->getMessage());
            $status = [
                'triggerd_from' => 'C:CustomerInfoRepController|M:sendSingleSMS',
                'status_text' => 'N',
                'status_text2' => 'Error Occured',
                'sms_count' => $totalSentSms,
                'sms_group' => 'N/A',
                'create_user' => Auth::user()->user_id,
                'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
            ];

            DB::table('mis.sms_send_status')->insert($status);
        }

        return response()->json(['status'=>'success']);
    }


}

