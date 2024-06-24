<?php

namespace App\Http\Controllers;

use App\Empcompratingmaslog;
use Illuminate\Http\Request;
use App\EmpCompetency;
use Auth;
use DB;
use App\Empcompratingmas;
use App\Empcompratingdet;
use Carbon\Carbon;
use Mail;
use App\Menu_Display;

class EmpCompetency_Controller extends Controller
{
    //
    public function get_rating_def_view(){
//        echo "rating def";$login_terr_id=Auth::user()->terr_id;

        $data_ratings=EmpCompetency::select('*')->where('valid','YES')->get();
        return view('emp_competency.get_rating_def',compact('data_ratings'));
    }


    //user manual
    public function get_user_manual_view(){
       return view('emp_competency.user_manual');
    }
    //get the view 'emp rating entry'
    public function get_emprating_entry(Request $request){

        $login_emp_id=Auth::user()->user_id;

        $user_infos=DB::select("select EMP_ID,DESIG_NAME, EMP_NAME, COMPANY_NAME,COMPANY_CODE,PLANT_ID,PLANT_NAME,DEPT_ID,DEPT_NAME,SUPERVISOR_EMP_ID,SUPERVISOR_EMP_NAME
                        from mis.employee_supervisor
                        where supervisor_emp_id  = ?
                        union all
                        select EMP_ID,DESIG_NAME, EMP_NAME, COMPANY_NAME,COMPANY_CODE,PLANT_ID,PLANT_NAME,DEPT_ID,DEPT_NAME,SUPERVISOR_EMP_ID,SUPERVISOR_EMP_NAME
                        from mis.employee_supervisor
                        where emp_id  = ?",[$login_emp_id,$login_emp_id]);

        // var_dump("test");
        $hh='notmatch';
        foreach($user_infos as $ui){
            if($ui->emp_id==$login_emp_id){
                $hh='match';
            }
        }

//         var_dump($hh);
        // return view('emp_competency.get_emprating_entry_form',compact('user_infos','hh'));

        //up 20.11.2018

        //for login user correct infortion like desig_name
        //11.3.2019 comment below coz we need 1st word upper
        // $login_moreinfo=DB::select(" select *
        //                                         from hrms.emp_information@web_to_hrms e,
        //                                         hrms.emp_designation@web_to_hrms f 
        //                                         where e.emp_id=?
        //                                         and e.desig_id=f.desig_id",[$login_emp_id]);

            $login_moreinfo=DB::select(" select e.*,f.*,initcap(f.desig_name) as design_nam_1st_upper
                                                from hrms.emp_information@web_to_hrms e,
                                                hrms.emp_designation@web_to_hrms f 
                                                where e.emp_id=?
                                                and e.desig_id=f.desig_id",[$login_emp_id]);

        $login_urright_desig=$login_moreinfo[0]->desig_name;


        return view('emp_competency.get_emprating_entry_form',compact('user_infos','hh','login_moreinfo'));

    }

    public function get_rating_data(Request $request){

        $logged_uid = $request['cemp'];

        $ccData = DB::select('select distinct ecompc_sl,ecompc
                                from mis.EMP_COMPETENCE_CATEGORY
                                order by ecompc_sl
                                ');

        $formData = DB::select("select ecompc,ecompc_desc,
                                master,well_developed,developing,to_be_developed,poor
                                from
                                (select ecompc,ecompc_desc,master,well_developed,developing,to_be_developed,poor
                                from(
                                select ecompc,ecompc_desc,eratc_type,ecompc_sl,ecompc_desc_sl
                                from mis.emp_competence_category ecc,mis.emp_rating_information eri
                                where upper(ecc.valid) = 'YES'
                                and upper(eri.valid) = 'YES'
                                ) pivot (sum(null) for eratc_type in ('MASTER' as master,'WELL DEVELOPED' as well_developed,'DEVELOPING' as developing,
                                'TO BE DEVELOPED' as to_be_developed,'POOR' as poor ))
                                order by ecompc_sl,ecompc_desc_sl),(select sap_com_id company_code,com_name company_name,emp_id,sur_name emp_name,di.dept_name,desig_name
                                from hrms.emp_information@web_to_hrms ei,hrms.company_info@web_to_hrms ci,
                                hrms.dept_information@web_to_hrms di,hrms.emp_designation@web_to_hrms ed
                                where ei.com_id = ci.com_id
                                and ei.dept_id = di.dept_id
                                and ei.desig_id = ed.desig_id
                                and ei.emp_id = '$logged_uid')");

        return response()->json(['form_data'=>$formData,'cc_data'=>$ccData]);

    }

//after click submit button
    public function display_srch_rating_entry(Request $request){
        if($request->ajax()){

            $emp_id=$request->u_emp;  //1013974
            $company_code=$request->u_comp_code;
            $login_user_emp_id=Auth::user()->user_id;
            $login_user_emp_name=Auth::user()->name;


            ////11/3/2019---------------------------------------
              $select_emp_mail=DB::select("select e.emp_id,e.email,initcap(e.sur_name) sur_name from hrms.emp_information@web_to_hrms e where e.emp_id=?",[$emp_id]);

            
            $dropdown_empmail=$select_emp_mail[0]->email;



            ////11/3/2019----------------------------------------------------------

            $super_new_old=DB::select("select * from (SELECT 
                        E.ECRM_ID,
                           E.EMP_ID, E.EMP_NAME, E.CREATE_USER_ID, 
                           E.CREATE_USER_NAME
                        FROM MIS.EMP_COMPETENCY_RATING_MASTER E
                        where EMP_ID=?) where CREATE_USER_ID=?",[$emp_id,$login_user_emp_id]);
//            $olddata_superviser_ecrmid='no_prev_edit_id';

            //11 -1013974 -FATEMA TOJ JOHORA -1005975 -md.ti

            $count_emp_id=DB::select("SELECT 
                        E.ECRM_ID,
                           E.EMP_ID, E.EMP_NAME, E.CREATE_USER_ID, E.rating_date,
                           E.CREATE_USER_NAME
                        FROM MIS.EMP_COMPETENCY_RATING_MASTER E
                        where EMP_ID=?",[$emp_id]);

            //2ta data 10-11

            $count_1st_display_infos=count($count_emp_id);

            if(!$super_new_old){
                $s_new_old_status='newdata_superviser';
                $olddata_superviser_ecrmid='no_prev_edit_id';
                $editsuperecrm_id='no_ecrm_idforedit';


            }else{
                $s_new_old_status='olddata_superviser';
                $olddata_superviser_ecrmid=$super_new_old;

                //get array
                $editsuperecrm_id=$super_new_old[0]->ecrm_id;
//                $editsuperArray
            }


            //new condi----------------------

            ///new condi end-----------------

            $first_display_infos=DB::select("select m.ecrm_id,m.rating_date,m.create_user_name,m.create_user_id,company_code,company_name,emp_id,emp_name,dept_name,ecompc,ecompc_desc,rmaster,well_developed,developing,to_be_developed,poor
            from mis.EMP_COMPETENCY_RATING_MASTER m,mis.EMP_COMPETENCY_RATING_DETAILS d
            where m.ECRM_ID = d.ecrm_id
            and company_code = ?
            and emp_id = ?",[$company_code,$emp_id]);


            //72 ta daata ---10--11

            //get the list of ecompc like 'leader'...
            $ccData = DB::select('select distinct ecompc_sl,ecompc
                                from mis.EMP_COMPETENCE_CATEGORY
                                order by ecompc_sl
                                ');
            $comparedate='';
            if(empty($first_display_infos)){
                //empty previously no rating for this employee
                $prevalue='no_prev';
//                $formData=$first_display_infos;
            }else{
                //empty previously rating done
                $prevalue='done_prev';


                //----------------------------for 6 month for supervisor n omwr date different



                if($count_1st_display_infos==2){
                    if($login_user_emp_id==$emp_id) {


                        for($k = 0; $k <= 1; $k++) {
                            if($count_emp_id[$k]->create_user_id == $count_emp_id[$k]->emp_id) {
//                                $add_month_db = Carbon::parse($first_display_infos[$k]->rating_date);
                                $add_month_db=Carbon::parse($count_emp_id[$k]->rating_date);
                            }
                        }


                    }else{

                        for($k=0;$k<=1;$k++){

                            if($count_emp_id[$k]->create_user_id!=$count_emp_id[$k]->emp_id){
                                $add_month_db=Carbon::parse($count_emp_id[$k]->rating_date);
                            }

                        }


                    }


                }else{

//                    for($k = 0; $k <= 1; $k++) {
//                        if($count_emp_id[$k]->create_user_id == $count_emp_id[$k]->emp_id) {
////                            $add_month_db = Carbon::parse($first_display_infos[$k]->rating_date);
//                            $add_month_db=Carbon::parse($count_emp_id[$k]->rating_date);
//                        }
//                    }


                    $add_month_db=Carbon::parse($first_display_infos[0]->rating_date);

                }


                ///////////////////////////////////for 6 ------------------------------------------






                $nowdate=Carbon::parse(Carbon::now());
                $comparedate=$add_month_db->diffInMonths($nowdate);
                $add_month=$add_month_db->addMonth(6);

            }
            $formData = DB::select("select (select nvl(max(ecrm_id),0)+1 from mis.emp_competency_rating_master) ecrm_id,ecompc,ecompc_desc,
                                master,well_developed,developing,to_be_developed,poor
                                from
                                (select ecompc,ecompc_desc,master,well_developed,developing,to_be_developed,poor
                                from(
                                select ecompc,ecompc_desc,eratc_type,ecompc_sl,ecompc_desc_sl
                                from mis.emp_competence_category ecc,mis.emp_rating_information eri
                                where upper(ecc.valid) = 'YES'
                                and upper(eri.valid) = 'YES'
                                ) pivot (sum(null) for eratc_type in ('MASTER' as master,'WELL DEVELOPED' as well_developed,'DEVELOPING' as developing,
                                'TO BE DEVELOPED' as to_be_developed,'Unable to Demonstrate' as poor ))
                                order by ecompc_sl,ecompc_desc_sl),(select sap_com_id company_code,com_name company_name,emp_id,sur_name emp_name,di.dept_name,desig_name
                                from hrms.emp_information@web_to_hrms ei,hrms.company_info@web_to_hrms ci,
                                hrms.dept_information@web_to_hrms di,hrms.emp_designation@web_to_hrms ed
                                where ei.com_id = ci.com_id
                                and ei.dept_id = di.dept_id
                                and ei.desig_id = ed.desig_id
                                and ei.emp_id = '$login_user_emp_id')");





            return response()->json(
                [
                    'first_display_infos'=>$first_display_infos,
                    'previousvalue'=>$prevalue,
                    'u_emp'=>$emp_id,
                    'company_code'=>$company_code,
                    'logged_id'=>$login_user_emp_id,
                    'logged_name'=>$login_user_emp_name,
                    'form_data'=>$formData,
                    'cc_data'=>$ccData,
                    'superedit_or_not'=>$s_new_old_status,
                    'count_emp_id'=>$count_emp_id,
                    'olddata_superviser_ecrmid'=>$olddata_superviser_ecrmid,
                    'editsuperecrm_id'=>$editsuperecrm_id,
                    'add_month'=>$comparedate,
                    'selected_emp_mail'=>$dropdown_empmail
//                    'count_1st_display_infos'=>$count_1st_display_infos,
////                    'kk_month'=>$add_month_db,
//                    'kk1_m1'=>Carbon::parse($count_emp_id[1]->rating_date),
//                    'kk2_m2'=>Carbon::parse($first_display_infos[0]->rating_date)
//                    'amon'=>$add_month,
//                    'nmon'=>$nowdate
                ]);
        }
    }


    //save the form of employee evaluation--------------------------

    public function postempevetuation(Request $request){
        if($request->ajax()){

//            DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

            $s_evalu_arr=$request->s_evalu_arr;
            $empinfo_arr=$request->empinfo_arr;

            $ecrm_id=$s_evalu_arr[0]['trecrm_id'];
            $trcompanyname=$empinfo_arr[0]['trcompanyname'];

//            echo Carbon::createFromFormat('Y-m-d', '1933-02-15')->format('d.m.Y') . PHP_EOL;
//            $rating_dat=\Carbon\Carbon::createFromFormat('d/m/Y', $empinfo_arr[0]['trrating_date']);
//            $rating_dat2 = explode(" ", $rating_dat);


            $rating_dat2=\Carbon\Carbon::parse($empinfo_arr[0]['trrating_date'])->format('Y-m-d');


            /////////////Next rating insert/////////////////////////////////

            $global_Nextstatus=$request->global_Nextstatus;

            if($global_Nextstatus=='nextrating'){
                $array_nr=DB::select('select * from mis.emp_competency_rating_master
                where emp_id=?',[$empinfo_arr[0]['trempid']]);

//                Empcompratingmaslog::insert($array_nr);


                for($k=0;$k<=2;$k++){
                    $ecrm_id_nr=$ecrm_id[k]->ecrm_id;

                    $array_nr=DB::select('select * from mis.emp_competency_rating_master
                where emp_id=?',[$empinfo_arr[0]['trempid']]);

//                    Empcompratingmaslog::insert($array_nr);
                }

                DB::table('MIS.emp_competency_rating_master')->where('emp_id',$empinfo_arr[0]['trempid'])->delete();


            }

            /////////////Next rating insert/////////////////////////////////

            /////save the emp_competency_rating_master single row
            $data = array(
                'ecrm_id' => $ecrm_id,
                'rating_date' =>$rating_dat2,
                'company_code' => $empinfo_arr[0]['trcompanycode'],
                'company_name' => $empinfo_arr[0]['trcompanyname'],
                'plant_id' => $empinfo_arr[0]['trplant_id'],
                'plant_name'=>$empinfo_arr[0]['trplant_name'],
                'emp_id'=>$empinfo_arr[0]['trempid'],
                'emp_name'=>$empinfo_arr[0]['trempname'],
                'dept_id'=>$empinfo_arr[0]['trdeptcode'],
                'dept_name'=>$empinfo_arr[0]['trdeptname'],
                'desig_name'=>$empinfo_arr[0]['trdesigname'],
                'create_user_id'=>$empinfo_arr[0]['trcreateuserid'],
                'create_user_name'=>$empinfo_arr[0]['trcreateusername'],
                'update_user'=>Auth::user()->user_id,
                'update_date'=>Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s')
            );


            Empcompratingmas::insert($data);

            ///save the emp_competency_rating_details multiple rows

            foreach($s_evalu_arr as $vv){
                $tabcolname='';
                $totalcol=' ';

                if($vv['trevaluation_val']=='nocheck'){
                    $totalcol='four';
                }else{
                    $totalcol='five';
                    if($vv['trevaluation_val']==1){
                        $tabcolname='POOR';
                    }else if($vv['trevaluation_val']==2){
                        $tabcolname='TO_BE_DEVELOPED';
                    }else if($vv['trevaluation_val']==3){
                        $tabcolname='DEVELOPING';
                    }else if($vv['trevaluation_val']==4){
                        $tabcolname='WELL_DEVELOPED';
                    }else if($vv['trevaluation_val']==5) {
                        $tabcolname = 'RMASTER';
                    }
                }

                if($totalcol=='four'){
                    $datarr = array(
                        'ecrm_id' => $ecrm_id,
                        'ecompc' =>$vv['trecompc'],
                        'ecompc_desc' =>$vv['trecompc_desc'],
                        'update_date'=>Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s')
                    );
                }else if($totalcol=='five'){
                    $datarr = array(
                        'ecrm_id' => $ecrm_id,
                        'ecompc' =>$vv['trecompc'],
                        'ecompc_desc' =>$vv['trecompc_desc'],
                        $tabcolname=>$vv['trevaluation_val'],
                        'update_date'=>Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s')
                    );
                }

//                var_dump($datarr);
                Empcompratingdet::insert($datarr);
            }


//            var_dump($s_evalu_arr);
            return response()->json([
                'eva_data'=>$s_evalu_arr,
                'empinfo_arr'=>$empinfo_arr,
                'ecrm_id'=>$ecrm_id,
                'company_name'=>$trcompanyname,
//                'employeeedate'=> $empinfo_arr[0]['trrating_date'],
//                'ttuu'=>$rating_dat2[0]
            ]);
        }
    }

    ///////////////////////////////////////

    public function getnewrateforsuper(Request $request){
    if($request->ajax()){

        $empinfo_arr=$request->empinfo_arr;



        $company_code= $empinfo_arr[0]['trcompanycode'];
        $emp_id= $empinfo_arr[0]['trempid'];


        ///save the emp_competency_rating_details multiple rows

        ////////////////////get data from details table using old_ecrmis from master

        $first_display_infos=DB::select("select m.ecrm_id,m.create_user_name,m.create_user_id,company_code,company_name,emp_id,emp_name,dept_name,ecompc,ecompc_desc,rmaster,well_developed,developing,to_be_developed,poor
            from mis.EMP_COMPETENCY_RATING_MASTER m,mis.EMP_COMPETENCY_RATING_DETAILS d
            where m.ECRM_ID = d.ecrm_id
            and company_code = ?
            and emp_id = ?",[$company_code,$emp_id]);

        $cc_datanewrate=DB::select('select distinct ecompc_sl,ecompc
                                from mis.EMP_COMPETENCE_CATEGORY
                                order by ecompc_sl
                                ');





        /////////////////////




//            var_dump($s_evalu_arr);
        return response()->json([
            'empinfo_arr' =>$empinfo_arr,
//            'ecrm_id' =>$ecrm_id,
            'Empdate'=>$empinfo_arr[0]['trrating_date'],
//            'user_ecrm_id_old'=>$ecrm_id_old,
            'first_display_infos'=>$first_display_infos,
            'cc_datanewrate'=>$cc_datanewrate

        ]);
    }
}

//////////////////////////////

    public function postnewratebys(Request $request){
        if($request->ajax()){
            $s_evalu_arr=$request->s_evalu_arr;
            $empinfo_arr=$request->empinfo_arr;

//            $ecrm_id=$s_evalu_arr[0]['trecrm_id'];
            $trcompanyname=$empinfo_arr[0]['trcompanyname'];


//            $rating_dat=\Carbon\Carbon::createFromFormat('d/m/Y', $empinfo_arr[0]['trrating_date']);
//            $rating_dat2 = explode(" ", $rating_dat);



            $rating_dat2=\Carbon\Carbon::parse($empinfo_arr[0]['trrating_date'])->format('Y-m-d');




            $emp_id=$empinfo_arr[0]['trempid'];
            $login_user_emp_id=Auth::user()->user_id;

            if($emp_id==$login_user_emp_id){
                //////////////////////-------Evatuated person-------------------/////////////////////////////////////////

                ///////////////////////////update details intially////////////

                $eva_user_id=DB::select("SELECT 
                        E.ECRM_ID,
                           E.EMP_ID, E.EMP_NAME, E.CREATE_USER_ID, 
                           E.CREATE_USER_NAME
                        FROM MIS.EMP_COMPETENCY_RATING_MASTER E
                        where EMP_ID=?",[$emp_id]);
                foreach($s_evalu_arr as $vv){
                    $tabcolname='';
                    $totalcol=' ';

                    if($vv['trevaluation_val']=='nocheck'){
                        $totalcol='four';
                    }else{
                        $totalcol='five';
                        if($vv['trevaluation_val']==1){
                            $tabcolname='POOR';
                        }else if($vv['trevaluation_val']==2){
                            $tabcolname='TO_BE_DEVELOPED';
                        }else if($vv['trevaluation_val']==3){
                            $tabcolname='DEVELOPING';
                        }else if($vv['trevaluation_val']==4){
                            $tabcolname='WELL_DEVELOPED';
                        }else if($vv['trevaluation_val']==5) {
                            $tabcolname = 'RMASTER';
                        }
                    }

                    if($totalcol=='four'){
                        $datarr = array(

                            'update_date'=>Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s')
                        );
                    }else if($totalcol=='five'){
                        $datarr = array(

                            $tabcolname=>$vv['trevaluation_val'],
                            'update_date'=>Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s')
                        );
                    }



                    $datarr_to_empty = array(
                        'rmaster' => '',
                        'well_developed' =>'',
                        'developing' =>'',
                        'to_be_developed' => '',
                        'poor' =>''
                    );


                    Empcompratingdet::where('ecrm_id',$eva_user_id[0]->ecrm_id)
                        ->where('ecompc',$vv['trecompc'])
                        ->where('ecompc_desc',$vv['trecompc_desc'])
                        ->update($datarr_to_empty);

                    Empcompratingdet::where('ecrm_id',$eva_user_id[0]->ecrm_id)
                        ->where('ecompc',$vv['trecompc'])
                        ->where('ecompc_desc',$vv['trecompc_desc'])
                        ->update($datarr);
                }

                $ecrm_id=$eva_user_id[0]->ecrm_id;

                /////////////////
                //////////////////////-------Evatuated person-------------------/////////////////////////////////////////
            }else{
                //////**********************************Supervisor**********************************///////////////////////////////////

                $super_new_old=DB::select("select * from (SELECT 
                        E.ECRM_ID,
                           E.EMP_ID, E.EMP_NAME, E.CREATE_USER_ID, 
                           E.CREATE_USER_NAME
                        FROM MIS.EMP_COMPETENCY_RATING_MASTER E
                        where EMP_ID=?) where CREATE_USER_ID=?",[$emp_id,$login_user_emp_id]);


                if(!$super_new_old){

                    $editsuperecrm_id='no_ecrm_idforedit';
                    $ecrm_id= DB::select("select nvl(max(ecrm_id),0)+1 as ecrm_id from mis.emp_competency_rating_master");
                    $ecrm_id=$ecrm_id[0]->ecrm_id;
                    ///////////////////////////////////////////////////////\
                    $data = array(
                        'ecrm_id' => $ecrm_id,
                        'rating_date' =>$rating_dat2,
//                        'rating_date' =>$rating_dat2[0],
                        'company_code' => $empinfo_arr[0]['trcompanycode'],
                        'company_name' => $empinfo_arr[0]['trcompanyname'],
                        'plant_id' => $empinfo_arr[0]['trplant_id'],
                        'plant_name'=>$empinfo_arr[0]['trplant_name'],
                        'emp_id'=>$empinfo_arr[0]['trempid'],
                        'emp_name'=>$empinfo_arr[0]['trempname'],
                        'dept_id'=>$empinfo_arr[0]['trdeptcode'],
                        'dept_name'=>$empinfo_arr[0]['trdeptname'],
                        'desig_name'=>$empinfo_arr[0]['trdesigname'],
                        'create_user_id'=>$empinfo_arr[0]['trcreateuserid'],
                        'create_user_name'=>$empinfo_arr[0]['trcreateusername'],
                        'update_user'=>Auth::user()->user_id,
                        'update_date'=>Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s')
                    );


                    Empcompratingmas::insert($data);

                    //////////////////////////////////////////////
                    ///////////////////////////save details intially////////////
                    foreach($s_evalu_arr as $vv){
                        $tabcolname='';
                        $totalcol=' ';

                        if($vv['trevaluation_val']=='nocheck'){
                            $totalcol='four';
                        }else{
                            $totalcol='five';
                            if($vv['trevaluation_val']==1){
                                $tabcolname='POOR';
                            }else if($vv['trevaluation_val']==2){
                                $tabcolname='TO_BE_DEVELOPED';
                            }else if($vv['trevaluation_val']==3){
                                $tabcolname='DEVELOPING';
                            }else if($vv['trevaluation_val']==4){
                                $tabcolname='WELL_DEVELOPED';
                            }else if($vv['trevaluation_val']==5) {
                                $tabcolname = 'RMASTER';
                            }
                        }


                        if($totalcol=='four'){
                            $datarr = array(
                                'ecrm_id' => $ecrm_id,
                                'ecompc' =>$vv['trecompc'],
                                'ecompc_desc' =>$vv['trecompc_desc'],
                                'update_date'=>Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s')
                            );
                        }else if($totalcol=='five'){
                            $datarr = array(
                                'ecrm_id' => $ecrm_id,
                                'ecompc' =>$vv['trecompc'],
                                'ecompc_desc' =>$vv['trecompc_desc'],
                                $tabcolname=>$vv['trevaluation_val'],
                                'update_date'=>Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s')
                            );
                        }

//                var_dump($datarr);
                        Empcompratingdet::insert($datarr);
                    }

                    /////////////////


                }else{
                    $s_new_old_status='olddata_superviser';

                    //get array
                    $editsuperecrm_id=$super_new_old[0]->ecrm_id;
                    $ecrm_id=$editsuperecrm_id;


                    ///////////////////////////update details intially////////////
                    foreach($s_evalu_arr as $vv){
                        $tabcolname='';
                        $totalcol=' ';

                        if($vv['trevaluation_val']=='nocheck'){
                            $totalcol='four';
                        }else{
                            $totalcol='five';
                            if($vv['trevaluation_val']==1){
                                $tabcolname='POOR';
                            }else if($vv['trevaluation_val']==2){
                                $tabcolname='TO_BE_DEVELOPED';
                            }else if($vv['trevaluation_val']==3){
                                $tabcolname='DEVELOPING';
                            }else if($vv['trevaluation_val']==4){
                                $tabcolname='WELL_DEVELOPED';
                            }else if($vv['trevaluation_val']==5) {
                                $tabcolname = 'RMASTER';
                            }
                        }

                        if($totalcol=='four'){
                            $datarr = array(

                                'update_date'=>Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s')
                            );
                        }else if($totalcol=='five'){
                            $datarr = array(

                                $tabcolname=>$vv['trevaluation_val'],
                                'update_date'=>Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s')
                            );
                        }



                        $datarr_to_empty = array(
                            'rmaster' => '',
                            'well_developed' =>'',
                            'developing' =>'',
                            'to_be_developed' => '',
                            'poor' =>''
                        );


                        Empcompratingdet::where('ecrm_id',$ecrm_id)
                            ->where('ecompc',$vv['trecompc'])
                            ->where('ecompc_desc',$vv['trecompc_desc'])
                            ->update($datarr_to_empty);

                        Empcompratingdet::where('ecrm_id',$ecrm_id)
                            ->where('ecompc',$vv['trecompc'])
                            ->where('ecompc_desc',$vv['trecompc_desc'])
                            ->update($datarr);
                    }

                    /////////////////


                }

                //////////////////////****************supervisor end*****************//////////////////////////////////////////
            }





            return response()->json([
                'eva_data'=>$s_evalu_arr,
                'empinfo_arr'=>$empinfo_arr,
                'ecrm_id'=>$ecrm_id,
                'company_name'=>$trcompanyname,
                'super_new_old'=>$ecrm_id
//                ,
//                'mastertable_status'=>$mastertable_status
            ]);
        }
    }


    ////////////////////////////
    public function getolderEditdata(Request $request){
        if($request->ajax()){

            $ecrm_id=$request->editolde_ecrmid;



//            $company_code= $empinfo_arr[0]['trcompanycode'];
//            $emp_id= $empinfo_arr[0]['trempid'];






            ///save the emp_competency_rating_details multiple rows

            ////////////////////get data from details table using old_ecrmis from master

//            $first_display_infos=DB::select("select m.ecrm_id,m.create_user_name,m.create_user_id,company_code,company_name,emp_id,emp_name,dept_name,ecompc,ecompc_desc,rmaster,well_developed,developing,to_be_developed,poor
//            from mis.EMP_COMPETENCY_RATING_MASTER m,mis.EMP_COMPETENCY_RATING_DETAILS d
//            where m.ECRM_ID = d.ecrm_id
//            and company_code = ?
//            and emp_id = ?",[$company_code,$emp_id]);

            $first_display_infos=DB::select(" select ecrm_id,ecompc,ecompc_desc,rmaster,well_developed,developing,to_be_developed,poor
                                  from mis.EMP_COMPETENCY_RATING_DETAILS 
                             where ecrm_id = ?",[$ecrm_id]);


            $cc_datanewrate=DB::select('select distinct ecompc_sl,ecompc
                                from mis.EMP_COMPETENCE_CATEGORY
                                order by ecompc_sl
                                ');





            /////////////////////




//            var_dump($s_evalu_arr);
            return response()->json([
//                'empinfo_arr' =>$empinfo_arr,
//            'ecrm_id' =>$ecrm_id,
//                'Empdate'=>$empinfo_arr[0]['trrating_date'],
//            'user_ecrm_id_old'=>$ecrm_id_old,
                'first_display_infos'=>$first_display_infos,
                'cc_datanewrate'=>$cc_datanewrate

            ]);
        }
    }


    ////////////////send mail to notify employee////////////
    public function notiEmpByMail(Request $request){

        if($request->ajax()){

            $select_emp_id=$request->selectempid;
            $login_emp_id=Auth::user()->user_id;
            $bodymail=$request->bodymail;

            $select_emp_mail=DB::select("select e.emp_id,e.email,initcap(e.sur_name) sur_name from hrms.emp_information@web_to_hrms e where e.emp_id=?",[$select_emp_id]);

            $login_emp_mail=DB::select("select e.emp_id,e.email,initcap(e.sur_name) sur_name from hrms.emp_information@web_to_hrms e where e.emp_id = ?",[$login_emp_id]);


            //for correct information for logged user

            //11.03.2019-comment following-------------

            // $login_moreinfo=DB::select(" select *
            //                                     from hrms.emp_information@web_to_hrms e,
            //                                     hrms.emp_designation@web_to_hrms f 
            //                                     where e.emp_id=?
            //                                     and e.desig_id=f.desig_id",[$login_emp_id]);

            


            $login_moreinfo=DB::select(" select e.*,f.*,initcap(f.desig_name) as desig_name_1st_upper
                                                from hrms.emp_information@web_to_hrms e,
                                                hrms.emp_designation@web_to_hrms f 
                                                where e.emp_id=?
                                                and e.desig_id=f.desig_id",[$login_emp_id]);


            // $login_urright_desig=$login_moreinfo[0]->desig_name;
            $login_urright_desig=$login_moreinfo[0]->desig_name_1st_upper;

             $data= array(
                'toname'=>$select_emp_mail[0]->sur_name,
                'tomail'=>$select_emp_mail[0]->email,
                'frmname'=>$login_emp_mail[0]->sur_name,
                'frmdesig_nam'=>$login_urright_desig,

                'mailbody'=>$bodymail
            );



            Mail::send(['html' =>'emp_competency.mail_emp.emp_mail_fulfil'], $data, function ($message) use($login_emp_mail,$select_emp_mail,$login_moreinfo) {
                $message->to($select_emp_mail[0]->email,$select_emp_mail[0]->email)
                    ->subject('Notification For Form Fillup of Employee Rating ');//mail er subject
                $message->from($login_emp_mail[0]->email,$login_moreinfo[0]->sur_name);///1005975 er name mane supervisor
            });


            return response()->json([
                'select_employeeid'=>$select_emp_id,
                'select_employee_mail'=>$select_emp_mail[0]->email,
                'login_employee_mail'=>$login_emp_mail[0]->email
            ]);
        }

    }


    //////////////////////--------sales report menu show or hide ----------------///////////////////////////////////////
    public function getMenushow(Request $request)
    {
        if($request->ajax()){
            $menu_data=Menu_Display::all();

            return response()->json([
                'menu_show_sta'=>$menu_data[0]->menu_show_sta
            ]);
        }

    }

    ////////--------sales report menu show or hide for 'data process'----------------////////////


    public function getMenushowbtn(Request $request)
    {
        if($request->ajax()){
            $menu_data=Menu_Display::all();



            if($menu_data[0]->menu_show_sta=='yes'){


                DB::table('mis.menu_display')->where('menu_show_sta','yes')->update(['menu_show_sta' =>'no']);
            }else{

                DB::table('mis.menu_display')->where('menu_show_sta','no')->update(['menu_show_sta' =>'yes']);
            }

            $menu_data=Menu_Display::all();


            return response()->json([
                'menu_show_sta'=>$menu_data[0]->menu_show_sta
            ]);
        }

    }





}
