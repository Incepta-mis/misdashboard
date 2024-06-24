<?php

namespace App\Http\Controllers\ExpoDatabase\Reports;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

class GenericReportForSCMController extends Controller
{
    public function index(){
        $noOfCountry = DB::select("
            select count( distinct initcap(export_country)  ) no_of_country
            from mis.expo_info
            where export_country not in (
            'CMSD',
            'CPH',
            'DGDP',
            'DGFP',
            'EDCL-CBHC',
            'Institution',
            'UNDP',
            'UNFPA',
            'UNICEF',
            'WHO PQ',
            'Sri Lanka (DHS)',
            'Sri Lanka (SPC)',
            'Jordan (KAUH)'
            )
            order by export_country asc
        ");

        $noOfBrand = DB::select("
            select count(BRAND_NAME) brand_name
            from mis.expo_info
            order by export_country asc
        ");

        $cstatus = DB::select("
        select current_status,status,case current_status
                        when 'Registered' then 1
                        when 'Permitted' then 2
                        when 'In-Process' then 3
                        when 'Dropped' then 4
                        when 'Rejected' then 5
                        when 'Withdrawl' then 6
                        end  sl
                        
        from(
        
        select current_status,nvl(count(*),0) status
        from(            
            select export_country,expo_product_name,to_char(submitted_to_im,'DD-MON-RR') submission_date,
                case  inprocess when 'YES' THEN
                                                                           (                                                                                                                                         
                                                                                case when submitted_to_regularity is not null then 'In-Process'
                                                                                when submitted_to_agent is not null then 'In-Process'
                                                                                when submitted_to_im is not null then 'In-Process'                                                                                                                                                     
                                                                                else 'inprocess-No,But date is null'
                                                                                end  
                                                                           ) 
                                                        ELSE 
                                                                          (
                                                                              CASE  current_status 
                                                                              when 'REG'  then 'Registered'
                                                                              when 'PERMITTED'  then 'Permitted'
                                                                              when 'REJ'  then 'Rejected'
                                                                              when 'WFRD' then 'Withdrawl' 
                                                                              when 'DBAM' then 'Dropped'                                              
                                                                              when 'null' then 'inprocess-Yes,current_status is null' 
                                                                              when 'Select Status' then decode( nvl(inprocess,'null') ,'YES','In-Process' ,'NO','NO' ,'null','No Data Found','undefined')                                                            
                                                                              end  
                                                                          ) 
                                                        
                                                        end  current_status, 
                approval_date registration_date,expiry_renewal_date
            from mis.expo_info
        )            
        group by current_status
        )order by sl
    ");


        $allCountry = DB::select("
            select distinct export_country
            from mis.expo_country_wise_products
            order by export_country                
        ");

        $allGeneric = DB::select("
            select distinct product_generic
            from mis.expo_country_wise_products
            order by product_generic                
        ");


        return view('expo_database.Reports.im_team_w_scm_report',[
            'allCountry'=>$allCountry,
            'noOfCountry' => $noOfCountry,
            'noOfBrand' => $noOfBrand,
            'cstatus' => $cstatus,
            'allGeneric' => $allGeneric,

        ]);
    }

    public function getImTeamName(Request $request){
        $result = DB::select(" select distinct im_team from mis.expo_info where product_generic = '$request->generic_name' ");
        return response()->json($result);
    }


    public function ImScmGetExpoCountry(Request $request){

        try {
            $expo_country = DB::select("
            select distinct export_country
            from mis.expo_info
            where  export_country not in (
            'CMSD',
            'CPH',
            'DGDP',
            'DGFP',
            'EDCL-CBHC',
            'Institution',
            'UNDP',
            'UNFPA',
            'UNICEF',
            'WHO PQ',
            'Sri Lanka (DHS)',
            'Sri Lanka (SPC)',
            'Jordan (KAUH)'
            )  
            and im_team = decode('$request->im_team','All',im_team,'$request->im_team')        
            and product_generic = '$request->generic_name'
            order by export_country asc
        ");
        } catch (Oci8Exception $e) {
            Log::info($e->getMessage());
        }

        return response()->json(['expoCountryData'=>$expo_country]);
    }

    public function ImScmGetExpoProduct(Request $request){
        try {
            $expoProductName = DB::select("
            select distinct expo_product_name
            from mis.expo_info
            where export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')
            and im_team = decode('$request->im_team','All',im_team,'$request->im_team')           
            and product_generic = '$request->generic_name'           
            order by expo_product_name asc");
        } catch (Oci8Exception $e) {
            Log::info($e->getMessage());
        }

        return response()->json(['expoProductName'=>$expoProductName]);
    }

    public function ImScmGetProductStatus(Request $request){
        try {

            /*$pStatus = DB::select("
                select *
                from mis.expo_info
                where expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name')             
                and im_team = decode('$request->im_team','All',im_team,'$request->im_team')        
                and export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')
                and product_generic = '$request->generic_name'   
            ");*/

            // $pStatus = DB::select("
            //     select *
            //     from mis.expo_info g1
            //     where g1.expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name')          
            //     and g1.im_team = decode('$request->im_team','All',im_team,'$request->im_team')       
            //     and g1.export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')
            //     and g1.product_generic = '$request->generic_name'
            //     and g1.line_id = ( SELECT MAX( g2.line_id )
            //                   FROM mis.expo_info g2
            //                   WHERE g1.expo_product_name = g2.expo_product_name ) 
            // ");

            if($request->product_name == 'All'){
                $st = ['In-Process','Registered','Permitted','Dropped','Withdrawl','Rejected'];
                return response()->json($st);
            }else if($pStatus[0]->inprocess == 'YES'){
                $st = ['In-Process','Registered','Permitted','Dropped','Withdrawl','Rejected'];
                return response()->json($st);
            }else{
                $st = ['Registered','Dropped','Permitted','Withdrawl','Rejected'];
                return response()->json($st); 
            }

        } catch (Oci8Exception $e) {
            Log::info($e->getMessage());
        }
    }






    public function getSCMReportOnIMDB(Request $request){

        $pStatus = DB::select("
                select *
                from mis.expo_info g1
                where g1.expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name')          
                and g1.im_team = decode('$request->im_team','All',im_team,'$request->im_team')       
                and g1.export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')
                and g1.product_generic = '$request->generic_name'
                and g1.line_id = ( SELECT MAX( g2.line_id )
                              FROM mis.expo_info g2
                              WHERE g1.expo_product_name = g2.expo_product_name ) 
            ");

            return response()->json($pStatus);

    }

}