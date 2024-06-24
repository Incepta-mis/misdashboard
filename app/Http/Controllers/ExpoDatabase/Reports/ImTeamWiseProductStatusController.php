<?php


namespace App\Http\Controllers\ExpoDatabase\Reports;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

class ImTeamWiseProductStatusController extends Controller
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


        return view('expo_database.Reports.im_team_w_product_status',[
            'allCountry'=>$allCountry,
            'noOfCountry' => $noOfCountry,
            'noOfBrand' => $noOfBrand,
            'cstatus' => $cstatus,

        ]);
    }

    public function ImGetExpoCountry(Request $request){

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
            order by export_country asc
        ");
        } catch (Oci8Exception $e) {
            Log::info($e->getMessage());
        }

        return response()->json(['expoCountryData'=>$expo_country]);
    }

    public function ImGetExpoProduct(Request $request){

        try {
            $expoProductName = DB::select("
            select distinct expo_product_name
            from mis.expo_info
            where export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')
            and im_team = decode('$request->im_team','All',im_team,'$request->im_team')           
            order by expo_product_name asc");
        } catch (Oci8Exception $e) {
            Log::info($e->getMessage());
        }

        return response()->json(['expoProductName'=>$expoProductName]);
    }

    public function ImGetProductStatus(Request $request){
        try {

            $pStatus = DB::select("
                select *
                from mis.expo_info
                where expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name')
            ");

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

    public function getIMStatusResult(Request $request){


        $curr_status = $request->im_status;
       /* $curr_status = '';

        if($request->im_status == 'Registered'){
            $curr_status = 'REG';
        }else if($request->im_status == 'Dropped'){
            $curr_status = 'DBAM';
        }else if($request->im_status == 'withdraw'){
            $curr_status = 'WFRD';
        }else if($request->im_status == 'Rejected'){
            $curr_status = 'REJ';
        }else if($request->im_status == 'In-Process'){
            $curr_status = 'In-Process';
        }*/



        try {

            if($curr_status == 'All'){
                $rs = DB::select("
            select im_team,export_country,expo_product_name,inprocess,current_status,to_char(dated,'DD-MON-RR') \"DATE\"
            from
            (
            select im_team,export_country,expo_product_name,inprocess,
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
                                                                  end  
                                                              ) 
                                            
                                            end  current_status,  
            
                                                                                                        case current_status
                                                                                                         when 'REG' then  approval_date
                                                                                                         when 'PERMITTED' then  permitted_date
                                                                                                         when 'REJ' then  rejection_date
                                                                                                         when 'WFRD' then  withdrawal_form_ra_date
                                                                                                         when 'DBAM' then  dropped_by_agent_mah 
                                                                                                         when 'In-Process'  then  coalesce(dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)                                                                      
                                                                                                         end \"DATED\"                   
            from mis.expo_info
            where export_country = decode('$request->expo_country','All',export_country,'$request->expo_country') 
            and expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name')
            and im_team = decode('$request->im_team','All',im_team,'$request->im_team')  
            --and nvl2('$curr_status',current_status,0)=nvl2('$curr_status','$curr_status',0)
            )
            
            order by export_country,expo_product_name
            
            ");
            }else{
                $rs = DB::select("
            select im_team,export_country,expo_product_name,inprocess,current_status,to_char(dated,'DD-MON-RR') \"DATE\"
            from
            (
            select im_team,export_country,expo_product_name,inprocess,
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
                                                                  end  
                                                              ) 
                                            
                                            end  current_status,  
            
                                                                                                        case current_status
                                                                                                         when 'REG' then  approval_date
                                                                                                         when 'PERMITTED' then  permitted_date
                                                                                                         when 'REJ' then  rejection_date
                                                                                                         when 'WFRD' then  withdrawal_form_ra_date
                                                                                                         when 'DBAM' then  dropped_by_agent_mah 
                                                                                                         when 'In-Process'  then  coalesce(dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)                                                                      
                                                                                                         end \"DATED\"                   
            from mis.expo_info
            where export_country = decode('$request->expo_country','All',export_country,'$request->expo_country') 
            and expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name')
            and im_team = decode('$request->im_team','All',im_team,'$request->im_team')  
            --and nvl2('$curr_status',current_status,0)=nvl2('$curr_status','$curr_status',0)
            )
            where current_status = '$curr_status'
            order by export_country,expo_product_name
            
            ");
            }




            $ssStatus = DB::select("
            select current_status,count(*) status
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
                                                                          end  
                                                                      ) 
                                                    
                                                    end  current_status,   
                    approval_date registration_date,expiry_renewal_date
                from mis.expo_info
                where export_country = decode('$request->expo_country','All',export_country,'$request->expo_country') 
                and expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name')
                and im_team = decode('$request->im_team','All',im_team,'$request->im_team')              
            )
            group by current_status
            order by current_status asc
        ");


            $noOfCountry = DB::select("
            select count( distinct initcap(export_country)  ) no_of_country
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
            and export_country = decode('$request->expo_country','All',export_country,'$request->expo_country') 
            and expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name')
            and im_team = decode('$request->im_team','All',im_team,'$request->im_team')  
            order by export_country asc
        ");

            $noOfBrand = DB::select("
            select count(BRAND_NAME) brand_name
            from mis.expo_info
            where export_country = decode('$request->expo_country','All',export_country,'$request->expo_country') 
            and expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name')
            and im_team = decode('$request->im_team','All',im_team,'$request->im_team')  
            order by export_country asc
        ");

            return response()->json([
                'rs'=>$rs,
                'ssStatus'=>$ssStatus,
                'noOfCountry' => $noOfCountry,
                'noOfBrand' => $noOfBrand,
            ]);
        }catch (Oci8Exception $e) {
            Log::info($e->getMessage());
        }

    }








    public function cwps(){
        return view('expo_database.Reports.countryWiseProductStatus');
    }

    // public function countryWiseProductStatus(Request $request){
    //     $curr_status = '';

    //     if($request->im_status == 'Registered'){
    //         $curr_status = 'REG';
    //     }else if($request->im_status == 'Dropped'){
    //         $curr_status = 'DBAM';
    //     }else if($request->im_status == 'withdraw'){
    //         $curr_status = 'WFRD';
    //     }else if($request->im_status == 'Rejected'){
    //         $curr_status = 'REJ';
    //     }else if($request->im_status == 'In-Process'){
    //         $curr_status = 'In-Process';
    //     }



    //     try {

    //         $rs = DB::select("
    //         select im_team,export_country,current_status,count(current_status) no_of_product
    //         from
    //         (
    //         select im_team,export_country,case current_status
    //                                                                           when 'REG'  then 'Registered'
    //                                                                           when 'REJ'  then 'Rejected'
    //                                                                           when 'WFRD' then 'Withdrawl' 
    //                                                                           when 'WFRD' then 'Dropped'
    //                                                                           when 'In-Process' then 'In-Process'
    //                                                                           end current_status                    
    //         from mis.expo_info
    //         where export_country = decode('$request->expo_country','All',export_country,'$request->expo_country') 
    //         and expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name')
    //         and im_team = '$request->im_team'
    //         and nvl2('$curr_status',current_status,0)=nvl2('$curr_status','$curr_status',0)
    //         )
    //         group by im_team,export_country, current_status
    //         order by export_country
            
    //         ");

    //         return response()->json($rs);
    //     }catch (Oci8Exception $e) {
    //         Log::info($e->getMessage());
    //     }

    // }

    public function countryWiseProductStatus(Request $request){
        $curr_status = '';

        if($request->im_status == 'Registered'){
            $curr_status = 'REG';
        }else if($request->im_status == 'Dropped'){
            $curr_status = 'DBAM';
        }else if($request->im_status == 'withdraw'){
            $curr_status = 'WFRD';
        }else if($request->im_status == 'Rejected'){
            $curr_status = 'REJ';
        }else if($request->im_status == 'In-Process'){
            $curr_status = 'In-Process';
        }else if($request->im_status == ''){
            $curr_status = '';
        }else if($request->im_status == 'Select Status'){
            $xs = DB::select("
            select case inprocess 
            when 'YES' then 'In-Process' 
            when 'NO' then 'NO' 
            when null then 'No Data Found'
            end inprocess   
            from mis.expo_info 
            where export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')  
            and expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name')");

            $curr_status = $xs[0]->inprocess;
        }



        try {


            $rs = DB::select("
                select im_team,export_country,current_status,count(current_status) no_of_product
                from
                (
    
                    select im_team,expo_product_name,export_country,case nvl(current_status,'null') 
                                                  when 'null' then 'No Data Found'    
                                                  when 'Select Status' then decode( nvl(inprocess,'null') ,'YES','In-Process' ,'NO','NO' ,'null','No Data Found','undefined')                                                                                        
                                                  when 'REG'  then 'Registered'
                                                  when 'REJ'  then 'Rejected'
                                                  when 'WFRD' then 'Withdrawl' 
                                                  when 'DBAM' then 'Dropped By Agent'
                                                  when 'In-Process' then 'In-Process'                                             
                                                  end current_status,case nvl(current_status,'null') 
                                                                                                                     when 'REG' then  approval_date
                                                                                                                     when 'REJ' then  rejection_date
                                                                                                                     when 'WFRD' then  withdrawal_form_ra_date
                                                                                                                     when 'DBAM' then  dropped_by_agent_mah 
                                                                                                                     when 'In-Process'  then  coalesce(dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)
                                                                                                                     when 'Select Status' then coalesce(dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)
                                                                                                                     when 'null' then coalesce(dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)                                                                   
                                                                                                                     end DATED    
    from mis.expo_info
    where export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')
    and expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name') 
    and im_team = '$request->im_team'
    and nvl2('$curr_status',current_status,0)=nvl2('$curr_status','$curr_status',0)   
    
                )
                group by im_team,export_country, current_status
                order by export_country

            ");

            return response()->json($rs);
        }catch (Oci8Exception $e) {
            Log::info($e->getMessage());
        }

    }

    public function pcs(){

        $rs = DB::select("select distinct export_country from mis.expo_info");
        return view('expo_database.Reports.productCurrentStatus',['rs'=>$rs]);
    }

     /**
     * get certificate of product
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View|mixed
     */
    public function regCertificate(){

        $rs = DB::select("select distinct export_country from mis.expo_info");
        return view('expo_database.Reports.regCertificateOfProduct',['rs'=>$rs]);
    }

    public function getRegCertificateOfProduct(Request $request){
        try {
            $rs = DB::select("
            select export_country,expo_product_name,REG_CERT_PATH,to_char(submitted_to_regularity,'DD-MON-RR') submitted_to_regularity,to_char(in_process_dg_date,'DD-MON-RR') in_process_dg_date,
            to_char(dg_date_close,'DD-MON-RR') dg_date_close,to_char(approval_date,'DD-MON-RR') approval_date,
            to_char(dropped_by_agent_mah,'DD-MON-RR') dropped_by_agent_mah,to_char(withdrawal_form_ra_date,'DD-MON-RR') withdrawal_form_ra_date,to_char(rejection_date,'DD-MON-RR') rejection_date
            from mis.expo_info
            where export_country = decode('$request->expo_country','All',export_country,'$request->expo_country') 
            and expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name')           
            order by expo_product_name asc");
        } catch (Oci8Exception $e) {
            Log::info($e->getMessage());
        }

        return response()->json($rs);
    }

    public function CountryWiseGetExpoProduct(Request $request){
        try {
            $expoProductName = DB::select("
            select distinct expo_product_name
            from mis.expo_info
            where export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')            
            order by expo_product_name asc");
        } catch (Oci8Exception $e) {
            Log::info($e->getMessage());
        }

        return response()->json(['expoProductName'=>$expoProductName]);
    }

    public function getCWPSResult(Request $request){
        try {
            $rs = DB::select("
            select export_country,expo_product_name,to_char(submitted_to_im,'DD-MON-RR') submitted_to_im,to_char(submitted_to_agent,'DD-MON-RR') submitted_to_agent,
            to_char(submitted_to_regularity,'DD-MON-RR') submitted_to_regularity,to_char(in_process_dg_date,'DD-MON-RR') in_process_dg_date,
            to_char(dg_date_close,'DD-MON-RR') dg_date_close,to_char(approval_date,'DD-MON-RR') approval_date,to_char(permitted_date,'DD-MON-RR') permitted_date,
            to_char(dropped_by_agent_mah,'DD-MON-RR') dropped_by_agent_mah,to_char(withdrawal_form_ra_date,'DD-MON-RR') withdrawal_form_ra_date,
            to_char(rejection_date,'DD-MON-RR') rejection_date, to_char(launched_date,'DD-MON-RR') launched_date, 
            to_char(launched_date,'DD-MON-RR') variation_date, to_char(variation_granted_refused_date,'DD-MON-RR') vg_refused_date
            from mis.expo_info
            where export_country = decode('$request->expo_country','All',export_country,'$request->expo_country') 
            and expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name')           
            order by expo_product_name asc");
        } catch (Oci8Exception $e) {
            Log::info($e->getMessage());
        }

        return response()->json($rs);
    }


        public function qaps(){
        $rs = DB::select("select distinct product_code from mis.expo_info order by product_code asc");
        return view('expo_database.Reports.QAProductStatus',['rs'=>$rs]);

    }

    public function prodBulkCodeWiseProductName(Request $request){


        try {
            $products = DB::select("
            select distinct expo_product_name
            from mis.expo_info
            where product_code = decode('$request->prod_bulk_code','All',product_code,'$request->prod_bulk_code')                        
            order by expo_product_name asc");
        } catch (Oci8Exception $e) {
            Log::info($e->getMessage());
        }

        return response()->json(['products'=>$products]);

    }


    public function pcodeWiseCountry(Request $request){

        try {
            $countries = DB::select("
            select distinct export_country
            from mis.expo_info
            where product_code = decode('$request->prod_bulk_code','All',product_code,'$request->prod_bulk_code')   
            and expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name')                     
            order by export_country asc");
        } catch (Oci8Exception $e) {
            Log::info($e->getMessage());
        }

        return response()->json(['countries'=>$countries]);
    }

    public function getQAWPSResult(Request $request){
        try {
            $rs = DB::select("
            select product_code,expo_product_name,export_country,to_char(submitted_to_im,'DD-MON-RR') submitted_to_im,to_char(submitted_to_agent,'DD-MON-RR') submitted_to_agent,
            to_char(submitted_to_regularity,'DD-MON-RR') submitted_to_regularity,to_char(in_process_dg_date,'DD-MON-RR') in_process_dg_date,
            to_char(dg_date_close,'DD-MON-RR') dg_date_close,to_char(approval_date,'DD-MON-RR') approval_date,
            to_char(dropped_by_agent_mah,'DD-MON-RR') dropped_by_agent_mah,to_char(withdrawal_form_ra_date,'DD-MON-RR') withdrawal_form_ra_date,to_char(rejection_date,'DD-MON-RR') rejection_date,to_char(launched_date,'DD-MON-RR') launched_date
            from mis.expo_info
            where export_country = decode('$request->expo_country','All',export_country,'$request->expo_country') 
            and product_code = decode('$request->prod_bulk_code','All',product_code,'$request->prod_bulk_code')   
            and expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name')                     
            order by product_code,expo_product_name,export_country  asc");

            return response()->json($rs);
        } catch (Oci8Exception $e) {
            Log::info($e->getMessage());
        }

    }

    // public function qapsCurrent(){
    //     $rs = DB::select("select distinct product_code from mis.expo_info order by product_code asc");
    //     return view('expo_database.Reports.QAProductStatusCurrent',['rs'=>$rs]);
    // }


    public function qapsCurrent(){
        $rs = DB::select("select distinct product_code from mis.expo_info order by product_code asc");

        $status = DB::select("
        select * from
        (
        select current_status,count(*) cnt
        from
        (
        select product_code,export_country,expo_product_name ,inprocess,renew_status,
                                                            case  inprocess when 'YES' THEN
                                                                               (                                                                                                                                         
                                                                                    case when submitted_to_regularity is not null then 'Sub To NRA'
                                                                                    when submitted_to_agent is not null then 'Sub To AGENT'  
                                                                                    when submitted_to_im is not null then 'Sub To IM'                                                                                                                                                     
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
                                                                                  end  
                                                                              ) 
                                                            
                                                            end  current_status   
                                                            
                                                             
                                                                                                      
        from mis.expo_info  
        )
        --where current_status is not null
        --and current_status != 'inprocess-No,But date is null'
        group by current_status
        ) 
        pivot (max(cnt)
        for current_status in
            ('Dropped' as \"Dropped\", 'Sub To IM' as \"Sub_To_IM\", 'Sub To AGENT' as \"Sub_To_AGENT\",
             'Sub To NRA' as \"Sub_To_NRA\",'Withdrawl' as \"Withdrawl\",'Registered' as \"Registered\",'Permitted' as \"Permitted\",'Rejected' as \"Rejected\") 
        )
        ");

        return view('expo_database.Reports.QAProductStatusCurrent',['rs'=>$rs,'status'=>$status]);
    }

    public function getQAWPSCurrentResult(Request $request){
        try {
            

            $rs = DB::select("
            
            select row_number() over (order by product_code) as srno,product_code,export_country,expo_product_name ,inprocess,
                                                                case  inprocess when 'YES' THEN
                                                                                   (                                                                                                                                         
                                                                                        case when submitted_to_regularity is not null then 'Sub To NRA'
                                                                                        when submitted_to_agent is not null then 'Sub To AGENT'  
                                                                                        when submitted_to_im is not null then 'Sub To IM'                                                                                                                                                     
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
                                                                                      end  
                                                                                  ) 
                                                                
                                                                end  current_status ,   
                                                                
                                                                CASE  inprocess when 'YES' THEN
                                                                 
                                                                   ( coalesce(to_char(submitted_to_regularity,'DD-MON-RR'),to_char(submitted_to_agent,'DD-MON-RR'),to_char(submitted_to_im,'DD-MON-RR')))
                                                                                   
                                                                ELSE 
                                                                        (
                                                                          CASE  current_status 
                                                                            when 'REG' then  to_char(approval_date,'DD-MON-RR')
                                                                            when 'PERMITTED' then  to_char(permitted_date,'DD-MON-RR')
                                                                            when 'REJ' then to_char(rejection_date,'DD-MON-RR')
                                                                            when 'WFRD' then  to_char(withdrawal_form_ra_date,'DD-MON-RR')
                                                                            when 'DBAM' then  to_char(dropped_by_agent_mah ,'DD-MON-RR')  
                                                                            when  null then 'inprocess-Yes,current_status is null'                                                                               
                                                                          end  
                                                                        )       
                                                                
                                                                end  \"DATE\"  ,launched_date     
                                                                                                          
            from mis.expo_info
            where export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')
            and product_code = decode('$request->prod_bulk_code','All',product_code,'$request->prod_bulk_code')
            and expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name')
            order by product_code,expo_product_name,export_country  asc
            
            
            ");

            $status = DB::select("
            select * from
            (
            select current_status, count(*) cnt
            from
            (
            select product_code,export_country,expo_product_name ,inprocess,renew_status,
                                                                case  inprocess when 'YES' THEN
                                                                                   (                                                                                                                                         
                                                                                        case when submitted_to_regularity is not null then 'Sub To NRA'
                                                                                        when submitted_to_agent is not null then 'Sub To AGENT'  
                                                                                        when submitted_to_im is not null then 'Sub To IM'                                                                                                                                                     
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
                                                                                      end  
                                                                                  ) 
                                                                
                                                                end  current_status   
                                                                
                                                                 
                                                                                                          
            from mis.expo_info  
                    
             where export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')
             and product_code = decode('$request->prod_bulk_code','All',product_code,'$request->prod_bulk_code')
             and brand_name = decode('$request->product_name','All',brand_name,'$request->product_name')
            
        
            )
            
            group by current_status
            ) 
            pivot (max(cnt)
            for current_status in
                ('Dropped' as \"Dropped\", 'Sub To IM' as \"Sub_To_IM\", 'Sub To AGENT' as \"Sub_To_AGENT\",
                 'Sub To NRA' as \"Sub_To_NRA\",'Withdrawl' as \"Withdrawl\",'Registered' as \"Registered\",'Permitted' as \"Permitted\",'Rejected' as \"Rejected\") 
            )
            ");

            return response()->json([
                'rs'=>$rs,
                'ssStatus'=>$status,
            ]);


        } catch (Oci8Exception $e) {
            Log::info($e->getMessage());
        }

    }


    // public function getQAWPSCurrentResult(Request $request){
    //     try {
    //         $rs = DB::select("
    //         select row_number() over (order by product_code) as srno,product_code,export_country,expo_product_name ,case current_status
    //                                           when 'REG'  then 'Registered'
    //                                           when 'REJ'  then 'Rejected'
    //                                           when 'WFRD' then 'Withdrawl' 
    //                                           when 'WFRD' then 'Dropped'
    //                                           when 'In-Process' then 
    //                                                                 (                                                                                                                                         
    //                                                                    case when submitted_to_regularity is not null then 'Sub To NRA'
    //                                                                         when submitted_to_agent is not null then 'Sub To AGENT'                                                                                                                                                 
    //                                                                         else null
    //                                                                    end
                                                                       
    //                                                                 )                                                                                                
    //                                           end current_status, case current_status
    //                                                                  when 'REG' then  to_char(approval_date,'DD-MON-RR')
    //                                                                  when 'REJ' then to_char(rejection_date,'DD-MON-RR')
    //                                                                  when 'WFRD' then  to_char(withdrawal_form_ra_date,'DD-MON-RR')
    //                                                                  when 'DBAM' then  to_char(dropped_by_agent_mah ,'DD-MON-RR')
    //                                                                  when 'In-Process'  then  coalesce(to_char(submitted_to_regularity,'DD-MON-RR'),to_char(submitted_to_agent,'DD-MON-RR'))                                                                      
    //                                                                  end \"DATE\"   ,launched_date              
    //         from mis.expo_info
    //         where export_country = decode('$request->expo_country','All',export_country,'$request->expo_country') 
    //         and product_code = decode('$request->prod_bulk_code','All',product_code,'$request->prod_bulk_code')   
    //         and expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name')                     
    //         order by product_code,expo_product_name,export_country  asc");

    //         return response()->json($rs);
    //     } catch (Oci8Exception $e) {
    //         Log::info($e->getMessage());
    //     }

    // }

    public function ers(){
        DB::statement("alter session set nls_date_format = 'DD-MON-RRRR'");
        $rs = DB::select("select distinct export_country from mis.expo_info");
        // $ys = DB::select("select distinct to_char(to_date('01-jan-2006','dd-mon-rrrr') + rownum -1,'rrrr') year from all_objects where rownum <= to_date(sysdate,'dd-mon-rrrr')-to_date('01-jan-2006','dd-mon-rrrr')+1 order by year");
        $ys = DB::select("select distinct to_char(expiry_renewal_date,'RRRR') year
        from mis.expo_info
        where to_char(expiry_renewal_date,'RRRR') is not null
        order by to_char(expiry_renewal_date,'RRRR')");
        return view('expo_database.Reports.expiry_renewal',['rs'=>$rs,'ys'=>$ys]);
    }

    public function getErsResult(Request $request){
        try {

            if($request->year == 'All'){
                $rs = DB::select("
                    select year,to_char(expiry_renewal_date,'DD-MON-RR') expiry_date ,expo_product_name,export_country,current_status,dated,registered_date
                    from(
                        select to_char(expiry_renewal_date,'RRRR') YEAR,expiry_renewal_date,expo_product_name,export_country,
                            case nvl(current_status,'null')
                                when 'null' then 'No Data Found'    
                                when 'Select Status' then decode( nvl(inprocess,'null') ,'YES','In-Process' ,'NO','NO' ,'null','No Data Found','undefined')
                                when 'REG' then 'Registered'
                                when 'REJ' then 'Rejected'
                                when 'WFRD' then 'Withdrawl'
                                when 'DBAM' then 'Dropped By Agent'
                                when 'In-Process' then 'In-Process'
                            end current_status,
                            case nvl(current_status,'null')
                                when 'REG' then  coalesce(approval_date,dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)
                                when 'REJ' then  coalesce(rejection_date,dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)
                                when 'WFRD' then  coalesce(withdrawal_form_ra_date,dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)
                                when 'DBAM' then  coalesce(dropped_by_agent_mah,dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)
                                when 'In-Process' then coalesce(dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)
                                when 'Select Status' then coalesce(dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)
                                when 'null' then coalesce(dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)
                                when '' then coalesce(dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)
                            end DATED,to_char(approval_date,'DD-MON-RR') registered_date
                        from mis.expo_info                         
                        where export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')                
                        and expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name')       
                    )
                    --where current_status  in ('No Data Found','undefined','null')
                    order by expiry_renewal_date,expo_product_name,export_country asc
                ");
            }else{
                $rs = DB::select("
                select  year,to_char(expiry_renewal_date,'DD-MON-RR') expiry_date ,expo_product_name,export_country,current_status,dated,registered_date
                from(
                    select to_char(expiry_renewal_date,'RRRR') YEAR,expiry_renewal_date,expo_product_name,export_country,
                        case nvl(current_status,'null')
                            when 'null' then 'No Data Found'    
                            when 'Select Status' then decode( nvl(inprocess,'null') ,'YES','In-Process' ,'NO','NO' ,'null','No Data Found','undefined')
                            when 'REG' then 'Registered'
                            when 'REJ' then 'Rejected'
                            when 'WFRD' then 'Withdrawl'
                            when 'DBAM' then 'Dropped By Agent'
                            when 'In-Process' then 'In-Process'
                        end current_status,
                        case nvl(current_status,'null')
                            when 'REG' then  coalesce(approval_date,dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)
                            when 'REJ' then  coalesce(rejection_date,dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)
                            when 'WFRD' then  coalesce(withdrawal_form_ra_date,dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)
                            when 'DBAM' then  coalesce(dropped_by_agent_mah,dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)
                            when 'In-Process' then coalesce(dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)
                            when 'Select Status' then coalesce(dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)
                            when 'null' then coalesce(dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)
                            when '' then coalesce(dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)
                        end DATED,to_char(approval_date,'DD-MON-RR') registered_date
                    from mis.expo_info         
                    where to_char(expiry_renewal_date,'RRRR') = '$request->year'
                    and export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')                
                    and expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name')       
                )
                --where current_status  in ('No Data Found','undefined','null')
                order by expiry_renewal_date,expo_product_name,export_country asc
                ");
            }

            return response()->json($rs);
        } catch (Oci8Exception $e) {
            Log::info($e->getMessage());
        }

    }

    // public function getErsResult(Request $request){
    //     try {
    //         $rs = DB::select("
    //         select  row_number() over (order by export_country) as srno, export_country,expo_product_name,form_status,to_char(expiry_renewal_date,'DD-MON-RR') expiry_renewal_date
    //         from mis.expo_info
    //         where export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')                
    //         and expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name')                     
    //         and nvl2('$request->p_status',form_status,0) = nvl2('$request->p_status','$request->p_status',0)                     
    //         order by export_country,expo_product_name  asc");

    //         return response()->json($rs);
    //     } catch (Oci8Exception $e) {
    //         Log::info($e->getMessage());
    //     }

    // }

    public function cwbarcharts(){
        $rs = DB::select("
            select distinct export_country , count(product_name) no_prod
            from mis.expo_country_wise_products
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
            group by export_country
            order by export_country asc
        ");

        // $cstatus = DB::select("
        //     select current_status,status,case current_status
        //                     when 'Registered' then 1
        //                     when 'In-Process' then 2
        //                     when 'Dropped By Agent' then 3
        //                     when 'Rejected' then 4
        //                     when 'Withdrawl' then 5
        //                     end  sl
                            
        //     from(
            
        //     select current_status,nvl(count(*),0) status
        //     from(            
        //         select export_country,expo_product_name,to_char(submitted_to_im,'DD-MON-RR') submission_date,
        //             case nvl(current_status,'null') 
                                 
        //               when 'Select Status' then decode( nvl(inprocess,'null') ,'YES','In-Process' ,'NO','NO' ,'null','No Data Found','undefined')                                                                
        //               when 'REG'  then 'Registered'
        //               when 'REJ'  then 'Rejected'
        //               when 'WFRD' then 'Withdrawl' 
        //               when 'DBAM' then 'Dropped By Agent'
        //               when 'In-Process' then 'In-Process'                                             
        //             end current_status, 
        //             approval_date registration_date,expiry_renewal_date
        //         from mis.expo_info
        //     )            
        //     group by current_status
        //     )order by sl
        // ");


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
                                                                                    case 
                                                                                    when submitted_to_regularity is not null then 'In-Process'
                                                                                    when submitted_to_agent is not null then 'In-Process'  
                                                                                    when submitted_to_im is not null then 'In-Process'                                                                                                                                                     
                                                                                    else 'inprocess-No,But date is null'
                                                                                    end  
                                                                               ) 
                                                            ELSE 
                                                                              (
                                                                                  CASE  current_status
                                                                                  when 'PERMITTED' then 'Permitted'  
                                                                                  when 'REG'  then 'Registered'
                                                                                  when 'REJ'  then 'Rejected'
                                                                                  when 'WFRD' then 'Withdrawl' 
                                                                                  when 'DBAM' then 'Dropped'                                              
                                                                                  when 'null' then 'inprocess-Yes,current_status is null'               
                                                                                  end  
                                                                              ) 
                                                            
                                                            end  current_status, 
                    approval_date registration_date,expiry_renewal_date
                from mis.expo_info
               
            )            
            group by current_status
            )order by sl
        ");
        
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

        return view('expo_database.Reports.countryWiseProductCountBar', [
            'rs' => $rs,
            'cstatus' => $cstatus,
            'noOfBrand' => $noOfBrand,
            'noOfCountry' => $noOfCountry,
        ]);
    }

    // public function yearWiseStatus(){

    //     DB::statement("alter session set nls_date_format = 'DD-MON-RRRR'");
    //     $rs = DB::select("select distinct to_char(to_date('01-jan-2006','dd-mon-rrrr') + rownum -1,'rrrr') year 
    //                       from all_objects where rownum <= to_date(sysdate,'dd-mon-rrrr')-to_date('01-jan-2006','dd-mon-rrrr')+1 order by year");

    //     $status = DB::select("
    //     select * from
    //     (
    //     select current_status,count(*) cnt
    //     from
    //     (
    //     select product_code,export_country,expo_product_name ,inprocess,renew_status,
    //                                                         case  inprocess when 'YES' THEN
    //                                                                             (                                                                                                                                         
    //                                                                                 case
    //                                                                                 when dg_date_close is not null then 'Defi_Close'
    //                                                                                 when in_process_dg_date is not null then 'Defi_Gen'
    //                                                                                 when submitted_to_regularity is not null then 'Sub To NRA'
    //                                                                                 when submitted_to_agent is not null then 'Sub To AGENT'  
    //                                                                                 when submitted_to_im is not null then 'Sub To IM'                                                                                                                                                     
    //                                                                                 else 'inprocess-No,But date is null'
    //                                                                                 end  
    //                                                                             ) 
    //                                                         ELSE 
    //                                                                         (
    //                                                                             CASE  current_status 
    //                                                                             when 'REG'  then 'Registered'
    //                                                                             when 'REJ'  then 'Rejected'
    //                                                                             when 'WFRD' then 'Withdrawl' 
    //                                                                             when 'DBAM' then 'Dropped'                                              
    //                                                                             when 'null' then 'inprocess-Yes,current_status is null'               
    //                                                                             end  
    //                                                                         ) 
                                                            
    //                                                         end  current_status   
                                                            
                                                            
                                                                                                    
    //     from mis.expo_info  
    //     )
    //     --where current_status is not null
    //     --and current_status != 'inprocess-No,But date is null'
    //     group by current_status
    //     ) 
    //     pivot (max(cnt)
    //     for current_status in
    //         ('Dropped' as \"Dropped\", 'Sub To IM' as \"Sub_To_IM\", 'Sub To AGENT' as \"Sub_To_AGENT\", 'Defi_Close' as \"Defi_Close\", 'Defi_Gen' as \"Defi_Gen\",
    //         'Sub To NRA' as \"Sub_To_NRA\",'Withdrawl' as \"Withdrawl\",'Registered' as \"Registered\",'Rejected' as \"Rejected\") 
    //     )
    //     ");


    //     return view('expo_database.Reports.yearWiseStatus',['rs'=>$rs, 'status'=>$status]);
    // }


    public function yearWiseStatus(){

        DB::statement("alter session set nls_date_format = 'DD-MON-RRRR'");
        $rs = DB::select("select distinct to_char(to_date('01-jan-2006','dd-mon-rrrr') + rownum -1,'rrrr') year 
                          from all_objects where rownum <= to_date(sysdate,'dd-mon-rrrr')-to_date('01-jan-2006','dd-mon-rrrr')+1 order by year");

        $status = DB::select("
        select * from
        (
        select current_status,count(*) cnt
        from
        (
        select product_code,export_country,expo_product_name ,inprocess,renew_status,
                                                            case  inprocess when 'YES' THEN
                                                                                (                                                                                                                                         
                                                                                    case
                                                                                    when dg_date_close is not null then 'Defi_Close'
                                                                                    when in_process_dg_date is not null then 'Defi_Gen'
                                                                                    when submitted_to_regularity is not null then 'Sub To NRA'
                                                                                    when submitted_to_agent is not null then 'Sub To AGENT'  
                                                                                    when submitted_to_im is not null then 'Sub To IM'                                                                                                                                                     
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
                                                                                end  
                                                                            ) 
                                                            
                                                            end  current_status   
                                                            
                                                            
                                                                                                    
        from mis.expo_info  
        )
        --where current_status is not null
        --and current_status != 'inprocess-No,But date is null'
        group by current_status
        ) 
        pivot (max(cnt)
        for current_status in
            ('Dropped' as \"Dropped\", 'Sub To IM' as \"Sub_To_IM\", 'Sub To AGENT' as \"Sub_To_AGENT\", 'Defi_Close' as \"Defi_Close\", 'Defi_Gen' as \"Defi_Gen\",
            'Sub To NRA' as \"Sub_To_NRA\",'Withdrawl' as \"Withdrawl\",'Registered' as \"Registered\",'Permitted' as \"Permitted\",'Rejected' as \"Rejected\") 
        )
        ");


        return view('expo_database.Reports.yearWiseStatus',['rs'=>$rs, 'status'=>$status]);
    }

    public function getYearWiseExpoCountry(Request $request){

        try {
            $countries = DB::select("
            select distinct export_country
            from mis.expo_info
            where expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name')                     
            order by export_country asc");
        } catch (Oci8Exception $e) {
            Log::info($e->getMessage());
        }

        return response()->json(['countries'=>$countries]);
    }

    public function getYearWiseExpoTeam(Request $request){

        try {
            $imTeamName = DB::select("
            select distinct im_team
            from mis.expo_info
            where export_country = decode('$request->expo_country','$request->expo_country',export_country,'$request->expo_country')
        ");
        } catch (Oci8Exception $e) {
            Log::info($e->getMessage());
        }

        return response()->json(['imTeamName'=>$imTeamName]);
    }

    public function getYearWiseProductName(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RRRR'");
        try {

            if ($request->im_status == 'All') {
                $expoProductName = DB::select("
                    select distinct expo_product_name
                    from mis.expo_info
                    where current_status = decode('$request->im_status','All',current_status,'$request->im_status')
                ");
            } else {
                if ($request->year == 'All') {

                    $expoProductName = DB::select("
                select *
                from
                (
                    select distinct expo_product_name,case current_status
                                             when 'REG' then  approval_date
                                             when 'PERMITTED' then  permitted_date
                                             when 'REJ' then  rejection_date
                                             when 'WFRD' then  withdrawal_form_ra_date
                                             when 'DBAM' then  dropped_by_agent_mah 
                                             when 'In-Process'  then  coalesce(dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)                                                                      
                                             end \"date\"   
                    from mis.expo_info
                    where expo_product_name in (select distinct  
                        case 
                         when (case  inprocess when 'YES' THEN
                (                                                                                                                                         
                        case 
                            when dg_date_close is not null then 'Defi_Close'
                            when in_process_dg_date is not null then 'Defi_Gen'
                            when submitted_to_regularity is not null then 'Sub To NRA'
                            when submitted_to_agent is not null then 'Sub To AGENT'  
                            when submitted_to_im is not null then 'Sub To IM'                                                                                                                                                     
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
                    end  
                ) 

        end  )  = '$request->im_status' then  expo_product_name                                                                      
                        end expo_product_name    
                    from mis.expo_info
                    )
                )
            ");
                } else {
                    $expoProductName = DB::select("
                select *
                from
                (
                    select distinct  expo_product_name,case current_status
                                             when 'REG' then  approval_date
                                             when 'PERMITTED' then  permitted_date
                                             when 'REJ' then  rejection_date
                                             when 'WFRD' then  withdrawal_form_ra_date
                                             when 'DBAM' then  dropped_by_agent_mah 
                                             when 'In-Process'  then  coalesce(dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)                                                                      
                                             end \"date\"   
                    from mis.expo_info
                    where expo_product_name in (select distinct  
                        case 
                         when (case  inprocess when 'YES' THEN
                (                                                                                                                                         
                        case 
                            when dg_date_close is not null then 'Defi_Close'
                            when in_process_dg_date is not null then 'Defi_Gen'
                            when submitted_to_regularity is not null then 'Sub To NRA'
                            when submitted_to_agent is not null then 'Sub To AGENT'  
                            when submitted_to_im is not null then 'Sub To IM'                                                                                                                                                     
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
                    end  
                ) 

        end  )  = '$request->im_status' then  expo_product_name                                                                      
                        end expo_product_name    
                    from mis.expo_info
                    )
                )
                where to_char(to_date(\"date\",'DD-MON-RRRR'),'RRRR') = '$request->year'
            ");
                }

            }

            return response()->json(['expoProductName' => $expoProductName]);

        } catch (Oci8Exception $e) {
            Log::info($e->getMessage());
        }

    }


    public function getYearWiseExpoResult(Request $request){

        DB::statement("alter session set nls_date_format = 'DD-MON-RRRR'");

        try {


            if($request->year == 'All'){
                $rs = DB::select("
            
                        select  year, current_status, expo_product_name,company_agent_name,export_country,im_team,to_char(to_date(\"date\",'DD-MON-RR'),'DD-MON-RR') status_date
                        from
                        (
                        select 'All' year,product_code,im_team,export_country,expo_product_name ,inprocess,renew_status,company_agent_name,inprocess,
                                case  inprocess when 'YES' THEN
                                        (                                                                                                                                         
                                                case 
                                                    when dg_date_close is not null then 'Defi_Close'
                                                    when in_process_dg_date is not null then 'Defi_Gen'
                                                    when submitted_to_regularity is not null then 'Sub To NRA'
                                                    when submitted_to_agent is not null then 'Sub To AGENT'  
                                                    when submitted_to_im is not null then 'Sub To IM'                                                                                                                                                     
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
                                            end  
                                        ) 

                                end  current_status , 
                                approval_date registration_date,expiry_renewal_date ,
                                case current_status
                                when 'REG' then  approval_date
                                when 'PERMITTED' then  permitted_date
                                when 'REJ' then  rejection_date
                                when 'WFRD' then  withdrawal_form_ra_date
                                when 'DBAM' then  dropped_by_agent_mah 
                                when 'In-Process'  then  coalesce(dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)                                                                      
                                end \"date\"      
                                                                        
                        from mis.expo_info                 
                        )
                        where  current_status = decode('$request->im_status','All',current_status,'$request->im_status')  
                        and export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')                
                        and expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name') 
                        and im_team = decode('$request->im_team','All',im_team,'$request->im_team')
                ");    

                $status = DB::select("
                    select * from
                                (
                    select current_status, count(*) cnt
                    from
                    (
                        select  year, current_status, expo_product_name,company_agent_name,export_country,im_team,to_char(to_date(\"date\",'DD-MON-RR'),'DD-MON-RR') status_date
                        from
                        (
                        select 'All' year,product_code,im_team,export_country,expo_product_name ,inprocess,renew_status,company_agent_name,inprocess,
                                case  inprocess when 'YES' THEN
                                        (                                                                                                                                         
                                                case 
                                                    when dg_date_close is not null then 'Defi_Close'
                                                    when in_process_dg_date is not null then 'Defi_Gen'
                                                    when submitted_to_regularity is not null then 'Sub To NRA'
                                                    when submitted_to_agent is not null then 'Sub To AGENT'  
                                                    when submitted_to_im is not null then 'Sub To IM'                                                                                                                                                     
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
                                            end  
                                        ) 

                                end  current_status , 
                                approval_date registration_date,expiry_renewal_date ,
                                case current_status
                                when 'REG' then  approval_date
                                when 'REJ' then  rejection_date
                                when 'WFRD' then  withdrawal_form_ra_date
                                when 'DBAM' then  dropped_by_agent_mah 
                                when 'In-Process'  then  coalesce(dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)                                                                      
                                end \"date\"                                    
                        from mis.expo_info  
                        ) 
                        where  current_status = decode('$request->im_status','All',current_status,'$request->im_status')                                                 
                        and export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')                
                        and expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name') 
                        and im_team = decode('$request->im_team','All',im_team,'$request->im_team')
                    )           
                    group by current_status
                    )
                    pivot (max(cnt)
                                for current_status in
                                    ('Dropped' as \"Dropped\", 'Sub To IM' as \"Sub_To_IM\", 'Sub To AGENT' as \"Sub_To_AGENT\", 'Defi_Close' as \"Defi_Close\",'Defi_Gen' as \"Defi_Gen\",
                                    'Sub To NRA' as \"Sub_To_NRA\",'Withdrawl' as \"Withdrawl\",'Registered' as \"Registered\", 'Permitted' as \"Permitted\",'Rejected' as \"Rejected\") 
                                )

                ");

            }else{
                $rs = DB::select("
            
                    select  year, current_status, expo_product_name,company_agent_name,export_country,im_team,to_char(to_date(\"date\",'DD-MON-RR'),'DD-MON-RR') status_date
                    from
                    (
                    select '$request->year' year,product_code,im_team,export_country,expo_product_name ,inprocess,renew_status,company_agent_name,
                            
                                                  CASE  current_status 
                                                  when 'REG'  then 'Registered'
                                                  when 'PERMITTED'  then 'Permitted'
                                                  when 'REJ'  then 'Rejected'
                                                  when 'WFRD' then 'Withdrawl' 
                                                  when 'DBAM' then 'Dropped'                                              
                                                  when 'In-Process' then 
                                                                case when dg_date_close is not null then 'Defi_Close'
                                                                    when in_process_dg_date is not null then 'Defi_Gen'
                                                                    when submitted_to_regularity is not null then 'Sub To NRA'
                                                                    when submitted_to_agent is not null then 'Sub To AGENT'
                                                                    when submitted_to_im is not null then 'Sub To NRA'                                                                            
                                                                    else null
                                                                end            
                                                  end  current_status,
                                        
                    
                            case current_status
                                 when 'REG' then  approval_date
                                 when 'PERMITTED' then  permitted_date
                                 when 'REJ' then  rejection_date
                                 when 'WFRD' then  withdrawal_form_ra_date
                                 when 'DBAM' then  dropped_by_agent_mah 
                                 when 'In-Process'  then  coalesce(dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)                                                                      
                            end \"date\"      
                            
                             
                                                                      
                    from mis.expo_info 
                    
                    )
                    where  current_status = decode('$request->im_status','All',current_status,'$request->im_status')                          
                    and to_char(to_date(\"date\",'DD-MON-RRRR'),'RRRR') = '$request->year' 
                    and export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')                
                    and expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name') 
                    and im_team = decode('$request->im_team','All',im_team,'$request->im_team')
            
                ");


                $status = DB::select("
                    select * from
                                (
                    select current_status, count(*) cnt
                    from
                    (
                        select  year, submitted_to_im,current_status, expo_product_name,company_agent_name,export_country,im_team,to_char(to_date(\"date\",'DD-MON-RR'),'DD-MON-RR') status_date
                        from
                        (
                        select 'All' year,submitted_to_im,product_code,im_team,export_country,expo_product_name ,inprocess,renew_status,company_agent_name,inprocess,
                                case  inprocess when 'YES' THEN
                                        (                                                                                                                                         
                                                case 
                                                    when dg_date_close is not null then 'Defi_Close'
                                                    when in_process_dg_date is not null then 'Defi_Gen'
                                                    when submitted_to_regularity is not null then 'Sub To NRA'
                                                    when submitted_to_agent is not null then 'Sub To AGENT'  
                                                    when submitted_to_im is not null then 'Sub To IM'                                                                                                                                                     
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
                                            end  
                                        ) 

                                end  current_status , 
                                approval_date registration_date,expiry_renewal_date ,
                                case current_status
                                when 'REG' then  approval_date
                                when 'PERMITTED' then  permitted_date
                                when 'REJ' then  rejection_date
                                when 'WFRD' then  withdrawal_form_ra_date
                                when 'DBAM' then  dropped_by_agent_mah 
                                when 'In-Process'  then  coalesce(dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)                                                                      
                                end \"date\"                                    
                        from mis.expo_info  
                        ) 
                        where  current_status = decode('$request->im_status','All',current_status,'$request->im_status')                          
                        and to_char(to_date(\"date\",'DD-MON-RRRR'),'RRRR') =  '$request->year' 
                        and export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')                
                        and expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name') 
                        and im_team = decode('$request->im_team','All',im_team,'$request->im_team')
                    )           
                    group by current_status
                    )
                    pivot (max(cnt)
                    for current_status in
                        ('Dropped' as \"Dropped\", 'Sub To IM' as \"Sub_To_IM\", 'Sub To AGENT' as \"Sub_To_AGENT\", 'Defi_Close' as \"Defi_Close\", 'Defi_Gen' as \"Defi_Gen\",
                        'Sub To NRA' as \"Sub_To_NRA\",'Withdrawl' as \"Withdrawl\",'Registered' as \"Registered\", 'Permitted' as \"Permitted\", 'Rejected' as \"Rejected\") 
                    )

                ");
            }


            // return response()->json($rs);
            return response()->json([
                'rs'=>$rs,
                'ssStatus'=>$status,
            ]);
        } catch (Oci8Exception $e) {
            Log::info($e->getMessage());
        }
    }

}