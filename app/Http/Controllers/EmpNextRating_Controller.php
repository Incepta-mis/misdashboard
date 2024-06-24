<?php

namespace App\Http\Controllers;

use App\Empcompratingdet;
use Illuminate\Http\Request;

use App\EmpCompetency;
use Auth;
use DB;
use App\Empcompratingmaslog;
use App\Empcompratingdetlog;

use App\Empcompratingmas;


use Carbon\Carbon;

class EmpNextRating_Controller extends Controller
{
    //next rating initial rating
    public function getNextRateinfo(Request $request){


            if($request->ajax()){

            $ecrm_id= DB::select("select nvl(max(ecrm_id),0)+1 as ecrm_id from mis.emp_competency_rating_master");
            $max_ecrm_id=$ecrm_id[0]->ecrm_id;

             $login_user_emp_id=Auth::user()->user_id;
             $login_user_emp_name=Auth::user()->name;

                $company_code=$request->u_comp_code;
                $emp_id=$request->u_emp;

                $first_display_infos=DB::select("select m.ecrm_id,m.create_user_name,m.create_user_id,company_code,company_name,emp_id,emp_name,dept_name,ecompc,ecompc_desc,rmaster,well_developed,developing,to_be_developed,poor
            from mis.EMP_COMPETENCY_RATING_MASTER m,mis.EMP_COMPETENCY_RATING_DETAILS d
            where m.ECRM_ID = d.ecrm_id
            and company_code = ?
            and emp_id = ?",[$company_code,$emp_id]);



                //get the list of ecompc like 'leader'...
                $ccData = DB::select('select distinct ecompc_sl,ecompc
                                from mis.EMP_COMPETENCE_CATEGORY
                                order by ecompc_sl
                                ');

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
                                'TO BE DEVELOPED' as to_be_developed,'POOR' as poor ))
                                order by ecompc_sl,ecompc_desc_sl),(select sap_com_id company_code,com_name company_name,emp_id,sur_name emp_name,di.dept_name,desig_name
                                from hrms.emp_information@web_to_hrms ei,hrms.company_info@web_to_hrms ci,
                                hrms.dept_information@web_to_hrms di,hrms.emp_designation@web_to_hrms ed
                                where ei.com_id = ci.com_id
                                and ei.dept_id = di.dept_id
                                and ei.desig_id = ed.desig_id
                                and ei.emp_id = '$login_user_emp_id')");




                return response()->json(
                    [
                        'form_data'=>$formData,
                        'cc_data'=>$ccData,
                        'max_ecrm_id'=>$max_ecrm_id,
                        'previous_ecrm_id'=>$request->ecrm_id,
                        'first_display_infos'=>$first_display_infos
                    ]);
            }//ajax end
        }//function end


    //next rating initial or first insert

    //here 'master table' this user ecrm_id will be max+1...
    //then ecrom_id will insert into 'master_log' table and 'detals_log'..
    //......then this 'ecrm' will remove from 'master table' and rating_date will be today date


    

    public function postNextRateinfo(Request $request){
        if($request->ajax()){


            $s_evalu_arr=$request->s_evalu_arr;
            $empinfo_arr=$request->empinfo_arr;

            $ecrm_id=$s_evalu_arr[0]['trecrm_id'];
            $login_user_emp_id=Auth::user()->user_id;

            $max_ecrm=DB::select('SELECT max(E.ECRM_ID)+1 ECRM_ID FROM MIS.EMP_COMPETENCY_RATING_MASTER E');
//            $max_ecrm_id=$max_ecrm[0]['ECRM_ID'];

            $trcompanyname=$empinfo_arr[0]['trcompanyname'];


            $rating_dat=\Carbon\Carbon::createFromFormat('d/m/Y', $empinfo_arr[0]['trrating_date']);
            $rating_dat2 = explode(" ", $rating_dat);

            /////////////Next rating insert(LOG TABLE)/////////////////////////////////
            ////////----------(master LOG TABLE part)-------------------////////////////////////
            //select data from master table and make a array
//            $array_nr=DB::select('select * from mis.emp_competency_rating_master_t
//                where emp_id=? and CREATE_USER_ID=?',[$empinfo_arr[0]['trempid'],$empinfo_arr[0]['trempid']]);

            $array_nr=DB::select('select * from mis.emp_competency_rating_master
                where emp_id=? and CREATE_USER_ID=?',[$empinfo_arr[0]['trempid'],$login_user_emp_id]);




            $datamaster = array(
                'ecrm_id' => $array_nr[0]->ecrm_id,
                'rating_date' =>$array_nr[0]->rating_date,
                'company_code' => $array_nr[0]->company_code,
                'company_name' => $array_nr[0]->company_name,
                'plant_id' => $array_nr[0]->plant_id,
                'plant_name' => $array_nr[0]->plant_name,
                'emp_id' => $array_nr[0]->emp_id,
                'emp_name' => $array_nr[0]->emp_name,
                'dept_id' => $array_nr[0]->dept_id,
                'dept_name' => $array_nr[0]->dept_name,
                'desig_name' => $array_nr[0]->desig_name,
                'create_user_id' => $array_nr[0]->create_user_id,
                'create_user_name' => $array_nr[0]->create_user_name,
                'update_user' => $array_nr[0]->update_user,
                'update_date' => $array_nr[0]->update_date,

            );

            $datamasterlog = array(
                'ecrm_id' =>$max_ecrm[0]->ecrm_id,
                'rating_date' =>date("Y-m-d"),
                'company_code' => $array_nr[0]->company_code,
                'company_name' => $array_nr[0]->company_name,
                'plant_id' => $array_nr[0]->plant_id,
                'plant_name' => $array_nr[0]->plant_name,
                'emp_id' => $array_nr[0]->emp_id,
                'emp_name' => $array_nr[0]->emp_name,
                'dept_id' => $array_nr[0]->dept_id,
                'dept_name' => $array_nr[0]->dept_name,
                'desig_name' => $array_nr[0]->desig_name,
                'create_user_id' => $array_nr[0]->create_user_id,
                'create_user_name' => $array_nr[0]->create_user_name,
                'update_user' => $array_nr[0]->update_user,
                'update_date' => $array_nr[0]->update_date

            );


//          first insert new this data in master_log...............MASTER_LOG part

            Empcompratingmaslog::insert($datamaster);
            DB::table('MIS.emp_competency_rating_master')->where('ecrm_id',$array_nr[0]->ecrm_id)->delete();
            Empcompratingmas::insert($datamasterlog);

            ////////+++++++++(deatils LOG TABLE part)+++++++++++////////////////////////...............DETAILS_LOG part
            /////depend on this select details_log table from details table

            $array_nr_details=DB::select('select * from mis.emp_competency_rating_details
                where ECRM_ID=?',[$array_nr[0]->ecrm_id]);

            //loop throuh and insert into detailslog array


            foreach ($array_nr_details as $array_nr_details){

                $datamasterlogdetails = array(
                    'ecrm_id' => $array_nr_details->ecrm_id,
                    'ecompc' =>$array_nr_details->ecompc,
                    'ecompc_desc' => $array_nr_details->ecompc_desc,
                    'rmaster' => $array_nr_details->rmaster,
                    'well_developed' => $array_nr_details->well_developed,
                    'developing'=>$array_nr_details->developing,
                    'to_be_developed'=>$array_nr_details->to_be_developed,
                    'poor'=>$array_nr_details->poor,
                    'update_date'=>$array_nr_details->update_date
                );



                Empcompratingdetlog::insert($datamasterlogdetails);
                DB::table('MIS.emp_competency_rating_details')->where('ecrm_id',$array_nr_details->ecrm_id)->delete();



            }//endofforeach

            ////////++++++++++(master LOG TABLE part)+++++++++++++++////////////////////////

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
//                        'ecrm_id' => $ecrm_id,
                        'ecrm_id' =>$max_ecrm[0]->ecrm_id,
                        'ecompc' =>$vv['trecompc'],
                        'ecompc_desc' =>$vv['trecompc_desc'],
                        'update_date'=>Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s')
                    );
                }else if($totalcol=='five'){
                    $datarr = array(
//                        'ecrm_id' => $ecrm_id,
                        'ecrm_id' =>$max_ecrm[0]->ecrm_id,
                        'ecompc' =>$vv['trecompc'],
                        'ecompc_desc' =>$vv['trecompc_desc'],
                        $tabcolname=>$vv['trevaluation_val'],
                        'update_date'=>Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s')
                    );
                }

//                var_dump($datarr);
                //31.10 comment korlam
                Empcompratingdet::insert($datarr);
            }



//            var_dump($s_evalu_arr);
            return response()->json([
                'eva_data'=>$s_evalu_arr,
                'empinfo_arr'=>$empinfo_arr,
                'ecrm_id'=>$array_nr[0]->ecrm_id,
                'company_name'=>$trcompanyname,
                'array_nr'=>$array_nr,
//                'array_nr_details'=>$array_nr_details,
                'max_next_rating'=> $max_ecrm[0]->ecrm_id,
                'rating_dat2'=>$rating_dat2,
                'datamasterlog'=>$datamasterlog,
                'today_date'=>date("Y-d-m"),
//                'datamaster'=>$datamaster
            ]);
        }
    }


}
