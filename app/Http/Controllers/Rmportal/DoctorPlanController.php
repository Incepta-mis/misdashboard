<?php

namespace App\Http\Controllers\Rmportal;

use App\Doctor_Information;
use App\DOCTOR_WISE_ITEM_UTILIZATION;
use App\Doctor_Wise_Territory;
use App\Http\Controllers\Controller;
use App\TERRITORY_WISE_DOCTOR_PLAN;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class DoctorPlanController extends Controller
{
    /* DOCTOR PLAN VIEW  */
    /**
     * @return $this
     */
    public function index()
    {

        $doc_speciality = DB::select('select distinct code,details
                                        from MIS.DASH_DOC_SPECIALITY
                                        order by DETAILS asc');

        $doc_position = DB::select('Select distinct position
                                     from mis.dash_doc_position
                                     order by position asc');

        return view('rm_portal.doctor_plan_view')->with(['doc_sp' => $doc_speciality, 'doc_desig' => $doc_position]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchDoctor(Request $request)
    {
        $input = $request->json()->all();

        if ($input['type'] == 'ID') {

            $docID = $input['docid'];
            $doctor_info = DB::select("select *
                                            from(                                            
                                            select title,doctor_id,doctor_name name,position designation,spec_code,sex,qualification,doctor_status,m_terr_id terr_id,
                                                   substr(m_terr_id,1,instr(m_terr_id,'-'))||'00' rm_terr_id,
                                                   substr(m_terr_id,1,instr(m_terr_id,'-',1,1))||trunc(substr(m_terr_id,instr(m_terr_id,'-',-1,1)+1),-1) am_terr_id,
                                                        hospital_address hospital_addr,chember_address,mailing_address,week_end_address,region,mobile
                                            from doctor_info.doctor_information@Web_To_Sample_Msd
                                            ) where doctor_id = '$docID'");

            if (count($doctor_info) == 0) {
                $doctor_info = DB::select("Select max(doctor_id)+1 doctor_id from doctor_info.doctor_information@Web_To_Sample_Msd");
            }

            return response()->json(['results' => $doctor_info]);

        } elseif ($input['type'] == 'NAME') {

            $docName = $input['doc_name'];
            $doctor_List = DB::select("select *
                                            from(                                            
                                            select title,doctor_id,doctor_name name,position designation,spec_code,sex,qualification,doctor_status,m_terr_id terr_id,
                                                   substr(m_terr_id,1,instr(m_terr_id,'-'))||'00' rm_terr_id,
                                                   substr(m_terr_id,1,instr(m_terr_id,'-',1,1))||trunc(substr(m_terr_id,instr(m_terr_id,'-',-1,1)+1),-1) am_terr_id,
                                                   hospital_address hospital_addr,chember_address,mailing_address,week_end_address,region,mobile
                                            from doctor_info.doctor_information@Web_To_Sample_Msd
                                            ) where upper(name) like '%$docName%' and rownum <= 60");

            return response()->json(['results' => $doctor_List]);
        }
        elseif ($input['type'] == 'NEW'){
            $doctor_List = DB::select("Select nvl(max(doctor_id),0)+1 doctor_id from doctor_info.doctor_information@Web_To_Sample_Msd");
            return response()->json(['results' => $doctor_List]);
        }
        elseif ($input['type'] =='MTRID'){
            $mrid = DB::select('Select nvl(max(dwt_id),0)+1 mid from mis.DOCTOR_WISE_TERRITORY');
            return response()->json(['results' => $mrid]);
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_terr_details(Request $request){
        $doctor = $request->json()->all();
        $desig = Auth::user()->desig;
        //Territory Data
        if($desig == 'HO' ||$desig == 'All'){

            $territoryData = DB::select("select dwt_id as rid,dwt.doctor_id as id,di.doctor_name as name,in_favour_of as ifo,terr_id as terr,hm.mpo_emp_id as eid,
                                            hm.mpo_name as ename,'' edesig,visiting_address as vaddr,guest,patient,valid,doctor_category as cata,1 as r, 1 as d,1 as h                                       
                                            from MIS.DOCTOR_WISE_TERRITORY dwt,doctor_info.doctor_information@web_to_sample_msd di,(select distinct emp_month,mpo_terr_id,mpo_emp_id,mpo_name from hrtms.hr_terr_list@web_to_hrtms) hm
                                            where DWT.DOCTOR_ID = di.doctor_id 
                                            and dwt.terr_id = hm.mpo_terr_id(+)
                                            and hm.emp_month = trunc(sysdate,'MM')
                                            and dwt.doctor_id = ?
                                            and valid = 'YES'",[$doctor['doctor_id']]);

        }else{

            $paramter = '';
            if(Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM'){
                $paramter = "SUBSTR(dwt.TERR_ID,1,INSTR(dwt.TERR_ID,'-'))||'00'";
            }
            elseif (Auth::user()->desig === 'AM' || Auth::user()->desig == 'Sr. AM'){
                $paramter = "substr(dwt.terr_id,1,instr(dwt.terr_id,'-',1,1))||trunc(substr(dwt.terr_id,instr(dwt.terr_id,'-',-1,1)+1),-1)";
            }
            elseif(Auth::user()->desig == 'MPO' || Auth::user()->desig == 'Sr. MPO'){
                $paramter = "dwt.terr_id";
            }

            $territoryData = DB::select("select dwt_id as rid,dwt.doctor_id as id,di.doctor_name as name,in_favour_of as ifo,terr_id as terr,hm.mpo_emp_id as eid,
                                            hm.mpo_name as ename,'' edesig,visiting_address as vaddr,guest,patient,valid,doctor_category as cata,1 as r, 1 as d,1 as h                                       
                                            from MIS.DOCTOR_WISE_TERRITORY dwt,doctor_info.doctor_information@web_to_sample_msd di,(select distinct emp_month,mpo_terr_id,mpo_emp_id,mpo_name from hrtms.hr_terr_list@web_to_hrtms) hm
                                            where DWT.DOCTOR_ID = di.doctor_id 
                                            and dwt.terr_id = hm.mpo_terr_id(+)
                                            and hm.emp_month = trunc(sysdate,'MM')
                                            and dwt.doctor_id = ?
                                            and $paramter = ?
                                            and valid = 'YES'",[$doctor['doctor_id'],Auth::user()->terr_id]);
        }

        return response()->json(['terrResults'=>$territoryData]);
    }

    public function get_plan_details(Request $request){
        $doctor = $request->json()->all();
        //Plan Data
        // $planData = DB::select("select doctor_id as id,doctor_name as name,terr_id as tid,emp_id as eid,emp_name as ename,week1 as wone,visit1 as vone,
        //                        week2 as wtwo,visit2 as vtwo,week3 as wthree,visit3 as vthree,week4 as wfour,visit4 as vfour
        //                         from(
        //                         SELECT twd.DOCTOR_ID, di.DOCTOR_NAME, TERR_ID, hm.mpo_EMP_ID emp_id, hm.mpo_NAME emp_name, WEEK1,VISIT1,WEEK2,VISIT2,WEEK3,VISIT3,
        //                                 WEEK4,VISIT4,
        //                                case when week1 = 'Saturday' then 1 
        //                                     when week1 = 'Sunday' then 2
        //                                     when week1 = 'Monday' then 3
        //                                     when week1 = 'Tuesday' then 4
        //                                     when week1 = 'Wednesday' then 5
        //                                     when week1 = 'Thursday' then 6
        //                                     when week1 = 'Friday' then 7 
        //                                 end seq
        //                         FROM MIS.TERRITORY_WISE_DOCTOR_PLAN twd,doctor_info.doctor_information@web_to_sample_msd di,hrtms.hr_terr_list@web_to_hrtms hm
        //                         where TWD.DOCTOR_ID = di.doctor_id
        //                         and TWD.TERR_ID = hm.mpo_terr_id
        //                         and hm.emp_month = trunc(sysdate,'MM')
        //                         order by seq
        //                         ) where DOCTOR_ID = ? and TERR_ID = ?",[$doctor['id'],$doctor['terr']]);


        $planData = DB::select("select doctor_id as id,doctor_name as name,terr_id as tid,emp_id as eid,emp_name as ename,week1 as wone,visit1 as vone,
        week2 as wtwo,visit2 as vtwo,week3 as wthree,visit3 as vthree,week4 as wfour,visit4 as vfour
        from(
        SELECT twd.DOCTOR_ID, di.DOCTOR_NAME, TERR_ID,  hm.emp_id, hm.emp_name, WEEK1,VISIT1,WEEK2,VISIT2,WEEK3,VISIT3,
                WEEK4,VISIT4,
               case when week1 = 'Saturday' then 1 
                    when week1 = 'Sunday' then 2
                    when week1 = 'Monday' then 3
                    when week1 = 'Tuesday' then 4
                    when week1 = 'Wednesday' then 5
                    when week1 = 'Thursday' then 6
                    when week1 = 'Friday' then 7 
                end seq
        FROM MIS.TERRITORY_WISE_DOCTOR_PLAN twd,doctor_info.doctor_information@web_to_sample_msd di,
        (select distinct mpo_terr_id, mpo_EMP_ID emp_id, mpo_NAME emp_name
        from hrtms.hr_terr_list@web_to_hrtms hm
        where emp_month = trunc(sysdate,'MM') ) hm
        
        where TWD.DOCTOR_ID = di.doctor_id
        and TWD.TERR_ID = hm.mpo_terr_id
        
        order by seq
        ) where DOCTOR_ID = ? and TERR_ID = ?",[$doctor['id'],$doctor['terr']]);





        //Plan Count
        $planCount = DB::select('select sum(nvl(visit1,0))+sum(nvl(visit2,0))+ sum(nvl(visit3,0))+sum(nvl(visit4,0)) vcount
                                FROM MIS.TERRITORY_WISE_DOCTOR_PLAN
                                where DOCTOR_ID = ? and TERR_ID = ?',[$doctor['id'],$doctor['terr']]);

        return response()->json(['planResults'=>$planData,'pc'=>$planCount[0]->vcount]);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_doc_brand_details(Request $request){
        $rdata = $request->json()->all();

        if($rdata['type'] == 'B'){
            $brands = DOCTOR_WISE_ITEM_UTILIZATION::select('brand_name as brand')
                ->distinct()
                ->where(['doctor_id'=>$rdata['id'],'terr_id'=>$rdata['terr']])
                ->get();
            $allTerrWiseBrands = DOCTOR_WISE_ITEM_UTILIZATION::select('brand_name as brand')
                ->distinct()
                ->where(['doctor_id'=>$rdata['id']])
                ->get();
            return response()->json(['brandResults'=>$brands,'allTerrWiseBrands'=>$allTerrWiseBrands]);
        }
        elseif ($rdata['type'] == 'D'){
            $brandData = DB::select("select distinct terr_id as terr,dwiu.doctor_id as id,di.doctor_name as name,brand_name as brand,
                                        exposer_qty as exp_qty,0 as r, 1 as d,1 as h 
                                        from MIS.DOCTOR_WISE_ITEM_UTILIZATION dwiu,doctor_info.doctor_information@web_to_sample_msd di
                                        where DWIU.DOCTOR_ID = di.doctor_id
                                        and dwiu.terr_id = ? and dwiu.doctor_id = ? and dwiu.BRAND_NAME = decode('".$rdata['brand']."','All',Brand_name,'".$rdata['brand']."')
                                        order by brand_name",
                [$rdata['terr'],$rdata['id']]);

            return response()->json(['brandResults'=>$brandData]);
        }elseif ($rdata['type'] == 'C'){
            $planData = DB::select('select sum(nvl(visit1,0))+sum(nvl(visit2,0))+ sum(nvl(visit3,0))+sum(nvl(visit4,0)) vcount
                                FROM MIS.TERRITORY_WISE_DOCTOR_PLAN
                                where DOCTOR_ID = ? and TERR_ID = ?',[$rdata['id'],$rdata['terr']]);

            if($planData[0]->vcount !== null){
                return response()->json(['response'=>$planData[0]->vcount]);
            }else{
                return response()->json(['response'=>'PNF']);
            }
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_terr_list()
    {

        $rm_asm_terr = Auth::user()->terr_id;

        $territoryList = DB::select("select distinct MPO_TERR_ID, MPO_EMP_ID,MPO_NAME,DESIG,region_name RM_BASE
                            from hrtms.hr_terr_list@web_to_hrtms htl,(select region_id,region_name 
                            from msfa.region_info@web_to_imsfa where region_id = '$rm_asm_terr' )
                            where emp_month = trunc(sysdate,'MM') 
                            and rm_terr_id = '$rm_asm_terr'
                            order by TO_NUMBER(SUBSTR(mpo_terr_id,instr(mpo_terr_id,'-', -1)+1)),mpo_emp_id");

        return response()->json(['result' => $territoryList]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_items_data(Request $request){
        $reqdata = $request->json()->all();
        if($reqdata['type'] == 'TBRAND'){
            $brands = DB::select("select distinct brand,0 as s_qty,0 as val,'N' as stat  
                                    from MSFA.SAMPLE_INFO@WEB_TO_IMSFA
                                    where brand is not null
                                    and brand like '".$reqdata['letter']."%'
                                    and type2 in ('CC','COMM.PACK')
                                    order by brand");
            return response()->json(['results'=>$brands]);
        }
        elseif ($reqdata['type'] == 'BITEMS'){
            $items = DB::select("select brand,item_id as id,item_name as name,0 as val,'N' as stat 
                                from MSFA.SAMPLE_INFO@WEB_TO_IMSFA
                                where brand = '".$reqdata['brand']."' 
                                and type2 in ('CC','COMM.PACK')
                                and brand is not null");

            return response()->json(['results'=>$items]);
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveDoctor(Request $request)
    {

        set_time_limit(0);

        //Log::info('Doctor Plan Controller | save doctor | '.Auth::user()->user_id);

        $data = $request->json()->all();

        $message = '';
        $doc_id = 0;
        if ($data !== null) {

            //$doctor = Doctor_Information::find($data['id']);

            //modified on 18 February 2018
            $doctor = DB::select('
                  Select * from doctor_info.doctor_information@Web_To_Sample_Msd
                  where doctor_id = ?',[$data['id']]);

            $doctor_name = strtoupper(trim($data['name']));
            $doctor_qlf = strtoupper(trim($data['qual']));
            $hosp_addr = strtoupper(trim($data['haddr']));
            $cham_addr = strtoupper(trim($data['caddr']));
            $othr_addr = strtoupper(trim($data['oaddr']));
            $main_addr = strtoupper(trim($data['maddr']));
            $region = strtoupper(trim($data['region']));

            if (count($doctor) > 0) {

                //after doctor_status m_terr_id   = ?,$data['mterr']  changed on 14.91.20

                if(strlen(Auth::user()->terr_id) > 5 || explode('-',Auth::user()->terr_id)[0] == 'HV'){
                    DB::update('
                    update doctor_info.DOCTOR_INFORMATION@Web_To_Sample_Msd
                       set doctor_name = ?,
                           title       = ?,
                           position    = ?,
                           spec_code   = ?,
                           sex         = ?,
                           mobile      = ?,
                           qualification = ?,
                           doctor_status = ?,
                           hospital_address = ?,
                           chember_address = ?,
                           mailing_address = ?,
                           update_user = ?,
                           update_date = ?,
                           region = ?,
                           m_terr_id = ?
                    where doctor_id = ?',
                        [
                            $doctor_name, $data['title'], $data['desig'], $data['scode'], $data['sex'], $data['cno'], $doctor_qlf,
                            $data['dstatus'], $hosp_addr,  $cham_addr, $othr_addr, Auth::user()->user_id,
                            Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s'),$region, $data['mterr'], $data['id']
                        ]
                    );
                }else{
                    DB::update('
                    update doctor_info.DOCTOR_INFORMATION@Web_To_Sample_Msd
                       set doctor_name = ?,
                           title       = ?,
                           position    = ?,
                           spec_code   = ?,
                           sex         = ?,
                           mobile      = ?,
                           qualification = ?,
                           doctor_status = ?,
                           hospital_address = ?,
                           chember_address = ?,
                           mailing_address = ?,
                           update_user = ?,
                           update_date = ?,
                           region = ?
                    where doctor_id = ?',
                        [
                            $doctor_name, $data['title'], $data['desig'], $data['scode'], $data['sex'], $data['cno'], $doctor_qlf,
                            $data['dstatus'], $hosp_addr,  $cham_addr, $othr_addr, Auth::user()->user_id,
                            Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s'),$region, $data['id']
                        ]
                    );
                }

            } else {

                $doc_id = DB::select('Select max(doctor_id)+1 doctor_id 
                                           from doctor_info.doctor_information@Web_To_Sample_Msd');

                // create new doctor record
                $doctorRecord = [
                    'DOCTOR_ID' => $doc_id[0]->doctor_id,
                    'DOCTOR_NAME' => $doctor_name,
                    'TITLE' => $data['title'],
                    'DESIGNATION' => $data['desig'],
                    'SPEC_CODE' => $data['scode'],
                    'SPEC_CODE_DESC' => $data['sdesc'],
                    'SEX' => $data['sex'],
                    'CONTACT_NO' => $data['cno'],
                    'QUALIFICATION' => $doctor_qlf,
                    'DOCTOR_STATUS' => $data['dstatus'],
                    'M_TERR_ID' => $data['mterr'],
                    'HOSPITAL_ADDRESS' => $hosp_addr,
                    'CHEMBER_ADDRESS' => $cham_addr,
                    'OTHERS_ADDRESS' => $othr_addr,
                    'MAIN_ADDRESS' => $main_addr,
                    'CREATE_DATE' => Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s'),
                    'CREATE_USER' => Auth::user()->user_id,
                    'REGION' => $region
                ];

                Doctor_Information::insert($doctorRecord);
            }
            $message = 'Success';
        } else {
            $message = 'Error';
        }

        if($doc_id !== 0){
            return response()->json(['response' => $message,'doc_id'=>$doc_id[0]->doctor_id]);
        }
        else{
            return response()->json(['response' => $message,'doc_id'=>'0']);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveTerritory(Request $request){


        //Log::info('Doctor Plan Controller | save territory | '.Auth::user()->user_id);
        $terrData = $request->json()->all();

        $message = '';

        try{
            foreach($terrData as $td){

                $tdata = Doctor_Wise_Territory::where(['dwt_id'=>$td['rid'],'doctor_id'=>$td['id']])->get();
                if(count($tdata) > 0){


                    if(strtoupper($td['valid']) === 'NO'){

                        //Log::info('Doctor Plan Controller | Valid NO Delete | '.Auth::user()->user_id .'|'.$td['terr'].'|'.$td['id']);

                        //insert before deleting row
                        DB::table('mis.invalid_doctor_terr')->insert([
                            'DOCTOR_ID' => $td['id'],
                            'DOCTOR_NAME' => $td['name'],
                            'TERR_ID' => $td['terr'],
                            'EMP_ID' => $td['eid'],
                            'EMP_NAME' => $td['ename'],
                            'VALID' => $td['valid'],
                            'UPDATE_DATE' => Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s'),
                            'UPDATE_USER' => Auth::user()->user_id
                        ]);

                        //delete from territory
                        DB::delete('delete from mis.Doctor_Wise_Territory where TERR_ID = ? and DOCTOR_ID = ?',
                            [$td['terr'],$td['id']]);

                        DB::delete('delete from DOCTOR_INFO.DOCTOR_TERR@WEB_TO_SAMPLE_MSD where TERR_ID = ? and DOCTOR_ID = ?',
                            [$td['terr'],$td['id']]);

                        // //delete from plan
                        DB::delete('Delete from mis.territory_wise_doctor_plan 
                          where TERR_ID = ? and DOCTOR_ID = ?',
                            [$td['terr'],$td['id']]);
                        // //delete from brand
                        DB::delete('Delete from mis.DOCTOR_WISE_ITEM_UTILIZATION 
                          where TERR_ID = ? and DOCTOR_ID = ?',
                            [$td['terr'],$td['id']]);
                    }else{

                        $udata = [
                            'IN_FAVOUR_OF' => $td['ifo'],
                            'EMP_ID' => $td['eid'],
                            'EMP_NAME' => $td['ename'],
                            'VISITING_ADDRESS' => $td['vaddr'],
                            'GUEST' => $td['guest'],
                            'PATIENT' => $td['patient'],
                            'VALID' => $td['valid'],
                            'DOCTOR_CATEGORY' => $td['cata'],
                            'UPDATE_DATE' => Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s'),
                            'UPDATE_USER' => Auth::user()->user_id
                        ];

                        Doctor_Wise_Territory::where('dwt_id', $td['rid'])
                            ->where('doctor_id', $td['id'])
                            ->where('terr_id', $td['terr'])
                            ->update($udata);
                    }

                    $message = 'Success';
                }
                else{
                    $idata = [
                        'DWT_ID' => $td['rid'],
                        'DOCTOR_ID' => $td['id'],
                        'DOCTOR_NAME' => $td['name'],
                        'IN_FAVOUR_OF' => $td['ifo'],
                        'TERR_ID' => $td['terr'],
                        'EMP_ID' => $td['eid'],
                        'EMP_NAME' => $td['ename'],
                        'VISITING_ADDRESS' => $td['vaddr'],
                        'GUEST' => $td['guest'],
                        'PATIENT' => $td['patient'],
                        'VALID' => $td['valid'],
                        'DOCTOR_CATEGORY' => $td['cata'],
                        'CREATE_DATE' => Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s'),
                        'CREATE_USER' => Auth::user()->user_id
                    ];

                    Doctor_Wise_Territory::insert($idata);

                    if(strtoupper($td['valid']) === 'NO'){
                        //Log::info('Doctor Plan Controller | insert Valid NO Delete | '.Auth::user()->user_id .'|'.$td['terr'].'|'.$td['id']);
                        //delete from territory
                        DB::delete('delete from mis.Doctor_Wise_Territory where upper(valid) = ?',['NO']);
                    }


                    $message = 'Success';
                }

            }


            $inserted_rows = DB::insert($this->query_insert_plan());
            //Log::info('Total Plan Rows Inserted --> '.$inserted_rows);
        }catch (Exception $ex){
            //Log::info($terrData);
            //Log::info($ex->getMessage());
        }

        //$inserted_rows = DB::insert($this->query_insert_plan());
        //Log::info('Total Plan Rows Inserted --> '.$inserted_rows);


        return response()->json(['response' => $message]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function savePlan(Request $request){
        //Log::info('Doctor Plan Controller | save plan | '.Auth::user()->user_id);
        $planData = $request->json()->all();

        $message = '';
        foreach ($planData as $pdata){
            $pd = DB::select('Select * from mis.TERRITORY_WISE_DOCTOR_PLAN 
                              where DOCTOR_ID = ? 
                              and TERR_ID = ? 
                              and WEEK1 = ?',
                [$pdata['id'],$pdata['tid'],$pdata['wone']]);
            if(count($pd)>0){
                $udata = [
                    'TERR_ID' => $pdata['tid'],
                    'EMP_ID' => $pdata['eid'],
                    'EMP_NAME' => $pdata['ename'],
                    'WEEK1' => $pdata['wone'],
                    'VISIT1' => $pdata['vone'],
                    'WEEK2' => $pdata['wtwo'],
                    'VISIT2' => $pdata['vtwo'],
                    'WEEK3' => $pdata['wthree'],
                    'VISIT3' => $pdata['vthree'],
                    'WEEK4' => $pdata['wfour'],
                    'VISIT4' => $pdata['vfour'],
                    'UPDATE_DATE' => Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s'),
                    'UPDATE_USER' => Auth::user()->user_id
                ];

                TERRITORY_WISE_DOCTOR_PLAN::where('doctor_id', $pdata['id'])
                    ->where('terr_id', $pdata['tid'])
                    ->where('week1', $pdata['wone'])
                    ->update($udata);

                $message = 'Success';
            }else{
                $idata = [
                    'DOCTOR_ID' => $pdata['id'],
                    'DOCTOR_NAME' => $pdata['name'],
                    'TERR_ID' => $pdata['tid'],
                    'EMP_ID' => $pdata['eid'],
                    'EMP_NAME' => $pdata['ename'],
                    'WEEK1' => $pdata['wone'],
                    'VISIT1' => $pdata['vone'],
                    'WEEK2' => $pdata['wtwo'],
                    'VISIT2' => $pdata['vtwo'],
                    'WEEK3' => $pdata['wthree'],
                    'VISIT3' => $pdata['vthree'],
                    'WEEK4' => $pdata['wfour'],
                    'VISIT4' => $pdata['vfour'],
                    'CREATE_DATE' => Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s'),
                    'CREATE_USER' => Auth::user()->user_id
                ];

                TERRITORY_WISE_DOCTOR_PLAN::insert($idata);
                $message = 'Success';
            }
        }

        //Plan Count
        $planCount = DB::select('select sum(nvl(visit1,0))+sum(nvl(visit2,0))+ sum(nvl(visit3,0))+sum(nvl(visit4,0)) vcount
                                FROM MIS.TERRITORY_WISE_DOCTOR_PLAN
                                where DOCTOR_ID = ? and TERR_ID = ?',[$planData[0]['id'],$planData[0]['tid']]);

        //update exposer_qty after plan change

        $pd = DB::select('Select * from mis.DOCTOR_WISE_ITEM_UTILIZATION 
                              where DOCTOR_ID = ? 
                              and TERR_ID = ?',
            [$planData[0]['id'],$planData[0]['tid']]);

        if(count($pd)>0){

            //Log::info('Doctor plan updated | change exp_qty | doctor id '.$planData[0]['id'].'| Terr '.$planData[0]['tid']);

            DB::update(
                'update mis.DOCTOR_WISE_ITEM_UTILIZATION
                 set exposer_qty = ?
                 where doctor_id = ?
                 and terr_id = ?
                ',
                [$planCount[0]->vcount,$planData[0]['id'],$planData[0]['tid']]
            );
        }

        return response()->json(['response'=>$message,'pc'=>$planCount[0]->vcount]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveBrand(Request $request){
        //Log::info('Doctor Plan Controller | save brand | '.Auth::user()->user_id);
        $ReqData = $request->json()->all();
        $brandData = $ReqData['finalBrands'];
        $allTerrWiseBrands = $ReqData['allTerrWiseBrands'];
        $assignedBrands = [];
        foreach ($brandData as $data){
            array_push($assignedBrands,$data['brand']);
        }
        $existingBrands = $ReqData['mBrands'];
        $allBrands = array_merge($assignedBrands,$allTerrWiseBrands);

        $message = '';
        $flag = 0;
        $sameGroupBrand = [];
        foreach ($allBrands as $bdata){
            $pd = DB::select("select * from product_info@web_to_sample_msd where brand_name = ? AND TH_GROUP = 'PPI'", [$bdata]);
            if(count($pd)>0){
                $flag++;
                array_push($sameGroupBrand,$bdata);
            }
        }
        $sameGroupBrand = array_unique($sameGroupBrand);
        $brands = DOCTOR_WISE_ITEM_UTILIZATION::select('brand_name as brand')
            ->distinct()
            ->where(['doctor_id'=>$brandData[0]['id'],'terr_id'=>$brandData[0]['terr']])
            ->get();

        if($flag > 1){
            return response()->json(['response'=>'Error','brands'=>$brands,'sameBrand'=>implode(",",$sameGroupBrand),
            'flag'=>$flag]);
        }else{
            foreach ($brandData as $bdata){
                $pd = DB::select('Select * from mis.DOCTOR_WISE_ITEM_UTILIZATION
                                  where DOCTOR_ID = ?
                                  and TERR_ID = ?
                                  and brand_name = ?',
                    [$bdata['id'],$bdata['terr'],$bdata['brand']]);

                if(count($pd)>0){
                    $udata = [
                        'exposer_qty' => $bdata['exp_qty'],
                        'UPDATE_DATE' => Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s'),
                        'UPDATE_USER' => Auth::user()->user_id
                    ];

                    DOCTOR_WISE_ITEM_UTILIZATION::where('doctor_id', $bdata['id'])
                        ->where('terr_id', $bdata['terr'])
                        ->where('brand_name', $bdata['brand'])
                        ->update($udata);

                    $message = 'Success';
                }else{
                    $idata = [
                        'TERR_ID' => $bdata['terr'],
                        'DOCTOR_ID' => $bdata['id'],
                        'DOCTOR_NAME' => $bdata['name'],
                        'BRAND_NAME' => $bdata['brand'],
                        'EXPOSER_QTY' => $bdata['exp_qty'],
                        'CREATE_DATE' => Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s'),
                        'CREATE_USER' => Auth::user()->user_id
                    ];

                    DOCTOR_WISE_ITEM_UTILIZATION::insert($idata);
                    $message = 'Success';
                }
            }
            return response()->json(['response'=>$message,'brands'=>$brands,'flag'=>$flag]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteBrand(Request $request){
        $rdata = $request->json()->all();
        $brandT = $rdata['brand'];

        $pd = DB::select("Select * from mis.DOCTOR_WISE_ITEM_UTILIZATION where DOCTOR_ID = ? and TERR_ID = ?  
                          and brand_name = decode('".$brandT."','All', BRAND_NAME,'".$brandT."')",
            [$rdata['id'],$rdata['terr']]);

        $message = '';
        if(count($pd )> 0){

            DB::delete("Delete from mis.DOCTOR_WISE_ITEM_UTILIZATION 
                          where TERR_ID = ? and DOCTOR_ID = ? and BRAND_NAME = decode('".$brandT."','All', BRAND_NAME,'".$brandT."') ",
                [$rdata['terr'],$rdata['id']]);


            foreach ($pd as $di){

                $idata = [
                    'TERR_ID' => $di->terr_id,
                    'DOCTOR_ID' => $di->doctor_id,
                    'DOCTOR_NAME' => $di->doctor_name,
                    'BRAND_NAME' => $di->brand_name,
                    'ITEM_ID' => $di->item_id,
                    'ITEM_NAME' => $di->item_name,
                    'EXPOSER_QTY' => $di->exposer_qty,
                    'DELETE_STATUS' => 'YES',
                    'CREATE_DATE' => Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s'),
                    'CREATE_USER' => Auth::user()->user_id,
                    'UPDATE_DATE' => Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s'),
                    'UPDATE_USER' => 'MIS',
                    'INTERFACE' => 'DOCTORS_MAINTENANCE'
                ];

                DB::table('MIS.ITEM_WISE_DOCTOR_ASSIGN')
                    ->insert($idata);

            }

            $message = 'Success';

            $brands = DOCTOR_WISE_ITEM_UTILIZATION::select('brand_name as brand')
                ->distinct()
                ->where(['doctor_id'=>$rdata['id'],'terr_id'=>$rdata['terr']])
                ->get();

            $allTerrWiseBrands = DOCTOR_WISE_ITEM_UTILIZATION::select('brand_name as brand')
                ->distinct()
                ->where(['doctor_id'=>$rdata['id']])
                ->get();


        }
        return response()->json(['response'=>$message,'brands'=>$brands,'allTerrWiseBrands'=>$allTerrWiseBrands]);

    }

    public function query_insert_plan(){
        return "insert into mis.territory_wise_doctor_plan(doctor_id,doctor_name,terr_id,emp_id,emp_name,week1,visit1,week2,visit2,week3,visit3,week4,visit4)
                select di.doctor_id,di.doctor_name,terr_id,emp_id,emp_name,week1,visit1,week2,visit2,week3,visit3,week4,visit4
                from
                (select distinct doctor_id,terr_id
                from mis.doctor_wise_territory
                minus
                select distinct doctor_id,terr_id 
                from mis.territory_wise_doctor_plan) dwt,doctor_info.doctor_information@web_to_sample_msd di,
                     (select distinct mpo_terr_id,mpo_emp_id emp_id,mpo_name emp_name from hrtms.hr_terr_list@web_to_hrtms where emp_month = trunc(sysdate,'MM'))tl,
                (select 'Saturday' week1,0 visit1,'Saturday' week2,0 visit2,'Saturday' week3,0 visit3,'Saturday' week4,0 visit4 from dual
                union all
                select 'Sunday' week1,0 visit1,'Sunday' week2,0 visit2,'Sunday' week3,0 visit3,'Sunday' week4,0 visit4 from dual
                union all
                select 'Monday' week1,0 visit1,'Monday' week2,0 visit2,'Monday' week3,0 visit3,'Monday' week4,0 visit4 from dual
                union all
                select 'Tuesday' week1,0 visit1,'Tuesday' week2,0 visit2,'Tuesday' week3,0 visit3,'Tuesday' week4,0 visit4 from dual
                union all
                select 'Wednesday' week1,0 visit1,'Wednesday' week2,0 visit2,'Wednesday' week3,0 visit3,'Wednesday' week4,0 visit4 from dual
                union all
                select 'Thursday' week1,0 visit1,'Thursday' week2,0 visit2,'Thursday' week3,0 visit3,'Thursday' week4,0 visit4 from dual
                union all
                select 'Friday' week1,0 visit1,'Friday' week2,0 visit2,'Friday' week3,0 visit3,'Friday' week4,0 visit4 from dual) vday
                where dwt.doctor_id = di.doctor_id
                and dwt.terr_id = tl.mpo_terr_id
                ";
    }

}
