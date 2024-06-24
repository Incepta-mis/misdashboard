<?php


namespace App\Http\Controllers\ExpoDatabase\Reports;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

class MarketingInformationController
{
    public function index(){
        $p_code_bulk = DB::select("
            select distinct product_code
            from mis.expo_info
            order by product_code asc
        ");
        return view('expo_database.Reports.expo_marketing_aid',['p_code_bulk'=>$p_code_bulk]);
    }

    public function getExpoCountry(Request $request){

        $pCodeBulk = $request->p_code_bulk;

        try {
            $expo_country = DB::select("
            select distinct export_country
            from mis.expo_info
            where product_code = decode('$pCodeBulk','$pCodeBulk',product_code,'$pCodeBulk')
            order by export_country asc
        ");
        } catch (Oci8Exception $e) {

        }

        return response()->json(['expoCountryData'=>$expo_country]);
    }

    public function getExpoMarketingAID(Request $request){


        try {
            $data = DB::select("
                 select row_number() over (order by line_id) as srno,
                    line_id,product_code,brand_name product_name_dom, export_country,expo_product_name product_name_expo
                    ,finish_product_code product_code_export,to_char(dg_date_close,'DD-MON-RR')  submission_date,post_marketing_commitments,to_char(variation_date,'DD-MON-RR') variation_date
                    ,to_char(variation_granted_refused_date,'DD-MON-RR') variation_granted_refused_date, to_char(approval_date,'DD-MON-RR') approval_date
                    ,to_char(launched_date,'DD-MON-RR') launched_date, to_char(expiry_renewal_date,'DD-MON-RR') expiry_renewal_date, '' current_status
                    from mis.expo_info
                where product_code = decode('$request->p_code_bulk','All',product_code,'$request->p_code_bulk')
                and export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')
        ");

            return response()->json($data);

        } catch (Oci8Exception $e) {

        }
    }


    public function yearWiseStatus(){

        DB::statement("alter session set nls_date_format = 'DD-MON-RRRR'");
        $rs = DB::select("select distinct to_char(to_date('01-jan-2006','dd-mon-rrrr') + rownum -1,'rrrr') year from all_objects where rownum <= to_date(sysdate,'dd-mon-rrrr')-to_date('01-jan-2006','dd-mon-rrrr')+1 order by year");
        return view('expo_database.Reports.yearWiseStatus',['rs'=>$rs]);
    }

    public function getYearWiseProductName(Request $request){
        DB::statement("alter session set nls_date_format = 'DD-MON-RRRR'");
        try{
            $expoProductName =  DB::select("
            select *
            from
            (
                select expo_product_name,case current_status
                                         when 'REG' then  approval_date
                                         when 'REJ' then  rejection_date
                                         when 'WFRD' then  withdrawal_form_ra_date
                                         when 'DBAM' then  dropped_by_agent_mah 
                                         when 'In-Process'  then  coalesce(dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)                                                                      
                                         end \"date\"   
                from mis.expo_info
                where expo_product_name in (select distinct  
                    case 
                     when current_status = '$request->im_status' then  expo_product_name                                                                      
                    end expo_product_name    
                from mis.expo_info
                )
            )
            where to_char(to_date(\"date\",'DD-MON-RRRR'),'RRRR') = '$request->year'
            ");

            return response()->json(['expoProductName'=>$expoProductName]);

        }catch (Oci8Exception $e){
            Log::info($e->getMessage());
        }

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


    public function getYearWiseExpoResult(Request $request){

        DB::statement("alter session set nls_date_format = 'DD-MON-RRRR'");

        try {
            $rs = DB::select("
            
                select  row_number() over (order by year ) as srno, year, current_status, expo_product_name,company_agent_name,export_country,im_team
                from
                (
                select '$request->year' year, case current_status
                                                  when 'REG'  then 'Registered'
                                                  when 'REJ'  then 'Rejected'
                                                  when 'WFRD' then 'Withdrawl' 
                                                  when 'WFRD' then 'Dropped'
                                                  when 'In-Process' then 
                                                                        (                                                                                                                                         
                                                                           case when dg_date_close is not null then 'Defi. Close'
                                                                                when in_process_dg_date is not null then 'Defi. Gen'
                                                                                when submitted_to_regularity is not null then 'Sub To NRA'
                                                                                when submitted_to_agent is not null then 'Sub To AGENT'
                                                                                when submitted_to_im is not null then 'Sub To NRA'                                                                            
                                                                                else null
                                                                           end
                                                                           
                                                                        )                                                                                                
                                                  end current_status,
                expo_product_name,company_agent_name,export_country,im_team,case current_status
                                 when 'REG' then  approval_date
                                 when 'REJ' then  rejection_date
                                 when 'WFRD' then  withdrawal_form_ra_date
                                 when 'DBAM' then  dropped_by_agent_mah 
                                 when 'In-Process'  then  coalesce(dg_date_close,in_process_dg_date,submitted_to_regularity,submitted_to_agent,submitted_to_im)                                                                      
                                 end \"date\"   
                from mis.expo_info
                where expo_product_name in (select distinct  
                case 
                when current_status = '$request->im_status' then  expo_product_name                                                                      
                end expo_product_name    
                from mis.expo_info
                )
                )
                where to_char(to_date(\"date\",'DD-MON-RRRR'),'RRRR') = '$request->year'
                and export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')                
                and expo_product_name = decode('$request->product_name','All',expo_product_name,'$request->product_name') 
                and im_team = decode('$request->im_team','All',im_team,'$request->im_team') 
            
            ");

            return response()->json($rs);
        } catch (Oci8Exception $e) {
            Log::info($e->getMessage());
        }
    }


}