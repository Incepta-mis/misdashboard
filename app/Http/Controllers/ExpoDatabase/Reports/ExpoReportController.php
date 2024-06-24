<?php


namespace App\Http\Controllers\ExpoDatabase\Reports;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpoReportController extends Controller
{
    //
    public function country_count_page(){
        $rs = DB::select("
            select distinct initcap(export_country)  export_country
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

        return view('expo_database.Reports.exportUniqueCountryList', [
            'rs' => $rs,
            'noOfBrand' => $noOfBrand,
            'noOfCountry' => $noOfCountry,
        ]);
    }
    

    public function getExpoCountryByGroup(Request $request){
        /*$result = DB::select("
        select distinct export_country
        from(
                select export_country,case nvl(current_status,'null')
                    when 'null' then 'No Data Found'
                    when 'Select Status' then decode( nvl(current_status,'null') ,'YES','In-Process' ,'NO','NO' ,'null','No Data Found','undefined')
                    when 'REG'  then 'Registered'
                    when 'REJ'  then 'Rejected'
                    when 'WFRD' then 'Withdrawl'
                    when 'DBAM' then 'Dropped By Agent'
                    when 'In-Process' then 'In-Process'
                end current_status
                from
                    (
                        select distinct initcap(export_country) export_country,
                            case nvl(current_status,'null')
                                            when 'null' then 'No Data Found'
                                            when 'Select Status' then decode( nvl(inprocess,'null') ,'YES','In-Process' ,'NO','NO' ,'null','No Data Found','undefined')
                                            when 'REG'  then 'REG'
                                            when 'REJ'  then 'REJ'
                                            when 'WFRD' then 'WFRD'
                                            when 'DBAM' then 'DBAM'
                                            when 'In-Process' then 'In-Process'
                                        end current_status
                        from  mis.expo_info
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
                        and IM_TEAM = decode('$request->im_team','All',im_team,'$request->im_team')
                    )
                where current_status = decode('$request->current_status','All',current_status,'$request->current_status')
                )
            order by export_country asc
            ");*/

        $result = DB::select("
        select distinct export_country
        from(
                select export_country,current_status
                from                 
                    (
                        select distinct initcap(export_country) export_country,
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
                                                            
                                                            end  current_status
                        from  mis.expo_info
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
                        and IM_TEAM = decode('$request->im_team','All',im_team,'$request->im_team')
                        
                    )
                where current_status = decode('$request->current_status','All',current_status,'$request->current_status')
                )
            order by export_country asc
            ");

        if($request->current_status == 'All'){
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
            and IM_TEAM = decode('$request->im_team','All',im_team,'$request->im_team') 
            order by export_country asc
        ");
        }else{
            /* $noOfCountry = DB::select("

                 select count( distinct initcap(no_of_country)  ) no_of_country,case nvl(current_status,'null')
                                 when 'null' then 'No Data Found'
                                 when 'Select Status' then decode( nvl(current_status,'null') ,'YES','In-Process' ,'NO','NO' ,'null','No Data Found','undefined')
                                 when 'REG'  then 'Registered'
                                 when 'REJ'  then 'Rejected'
                                 when 'WFRD' then 'Withdrawl'
                                 when 'DBAM' then 'Dropped By Agent'
                                 when 'In-Process' then 'In-Process'
                             end current_status
                 from
                 (
                 select export_country no_of_country,
                 case nvl(current_status,'null')
                                 when 'null' then 'No Data Found'
                                 when 'Select Status' then decode( nvl(inprocess,'null') ,'YES','In-Process' ,'NO','NO' ,'null','No Data Found','undefined')
                                 when 'REG'  then 'REG'
                                 when 'REJ'  then 'REJ'
                                 when 'WFRD' then 'WFRD'
                                 when 'DBAM' then 'DBAM'
                                 when 'In-Process' then 'In-Process'
                             end current_status
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
                 and IM_TEAM = decode('$request->im_team','All',im_team,'$request->im_team')
                 )
                 where current_status = '$request->current_status'
                 group by current_status
         "); */
            $noOfCountry = DB::select("

                select count( distinct initcap(no_of_country)  ) no_of_country,current_status
                from
                (
                select export_country no_of_country,
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
                                                            
                                                            end  current_status 
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
                and IM_TEAM = decode('$request->im_team','All',im_team,'$request->im_team') 
                ) 
                where current_status = '$request->current_status' 
                group by current_status
        ");
        }


        if($request->current_status == 'All') {

            $noOfBrand = DB::select("
                    select count(BRAND_NAME) no_of_brand
                    from mis.expo_info
                    where IM_TEAM = decode('$request->im_team','All',im_team,'$request->im_team') 
                    /*and export_country not in (
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
                        )*/
                    order by export_country asc
                ");
        }else{
            /*$noOfBrand = DB::select("
                    select count(brand_name) no_of_brand,current_status
                    from
                    (
                        select brand_name, case nvl(current_status,'null')
                        when 'null' then 'No Data Found'
                        when 'Select Status' then decode( nvl(inprocess,'null') ,'YES','In-Process' ,'NO','NO' ,'null','No Data Found','undefined')
                        when 'REG' then 'REG'
                        when 'REJ' then 'REJ'
                        when 'WFRD' then 'WFRD'
                        when 'DBAM' then 'DBAM'
                        when 'In-Process' then 'In-Process'
                        end current_status
                        from mis.expo_info
                        where IM_TEAM = decode('$request->im_team','All',im_team,'$request->im_team')

                    )
                    where current_status = '$request->current_status'
                    group by current_status
                ");
                */
            $noOfBrand = DB::select("
                    select count(brand_name) no_of_brand,current_status
                        from
                        (
                            select brand_name, case  inprocess when 'YES' THEN
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
                                                                                    
                                                                                    end  current_status  
                            from mis.expo_info
                            where IM_TEAM = decode('$request->im_team','All',im_team,'$request->im_team') 
                            
                        )
                        where current_status = '$request->current_status'
                        group by current_status
                ");
        }

        return response()->json([
            'result'=>$result,
            'noOfBrand' => $noOfBrand,
            'noOfCountry' => $noOfCountry,

        ]);
    }




    public function subDateProdStatus_page()
    {

        /*$rs = DB::select("
            select export_country,expo_product_name,pack_size,to_char(submitted_to_im,'DD-MON-RR') submission_date,
            case nvl(current_status,'null')
            when 'null' then 'No Data Found'
            when 'Select Status' then decode( nvl(inprocess,'null') ,'YES','In-Process' ,'NO','NO' ,'null','No Data Found','undefined')
            when 'REG'  then 'Registered'
            when 'REJ'  then 'Rejected'
            when 'WFRD' then 'Withdrawl'
            when 'DBAM' then 'Dropped By Agent'
            when 'In-Process' then 'In-Process'
            end current_status,
            to_char(approval_date,'DD-MON-RR') registration_date,to_char(expiry_renewal_date,'DD-MON-RR') expiry_renewal_date
            from mis.expo_info
            order by export_country,expo_product_name,submitted_to_im asc
        ");*/
        $rs = DB::select("
            select export_country,expo_product_name,pack_size,to_char(submitted_to_im,'DD-MON-RR') submission_date,
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
            to_char(approval_date,'DD-MON-RR') registration_date,to_char(expiry_renewal_date,'DD-MON-RR') expiry_renewal_date
            from mis.expo_info
            order by export_country,expo_product_name,submitted_to_im asc
        ");

        $country = DB::select("
            select distinct export_country
            from mis.expo_info   
            order by export_country asc
        ");

        $products = DB::select("
            select distinct expo_product_name
            from mis.expo_info   
            order by expo_product_name asc
        ");

        /*  $cstatus = DB::select("
              select current_status,nvl(count(*),0) status
              from(
                  select export_country,expo_product_name,to_char(submitted_to_im,'DD-MON-RR') submission_date,
                      case nvl(current_status,'null')
                        when 'null' then 'No Data Found'
                        when 'Select Status' then decode( nvl(inprocess,'null') ,'YES','In-Process' ,'NO','NO' ,'null','No Data Found','undefined')
                        when 'REG'  then 'Registered'
                        when 'REJ'  then 'Rejected'
                        when 'WFRD' then 'Withdrawl'
                        when 'DBAM' then 'Dropped By Agent'
                        when 'In-Process' then 'In-Process'
                      end current_status,
                      approval_date registration_date,expiry_renewal_date
                  from mis.expo_info
              )
              group by current_status
              order by current_status
          ");*/

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



        return view('expo_database.Reports.subDateWiseProductStatus', [
            'rs' => $rs,
            'country' => $country,
            'products' => $products,
            'cstatus' => $cstatus,
        ]);
    }

    public function getSubDateWPStatus(Request $request)
    {


        $result = DB::select("
            select export_country,expo_product_name,pack_size,submission_date,current_status, 
                 registration_date, expiry_renewal_date
                    from(                        
                        select export_country,expo_product_name,pack_size,to_char(submitted_to_im,'DD-MON-RR') submission_date,case  inprocess when 'YES' THEN
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
                            to_char(approval_date,'DD-MON-RR') registration_date,to_char(expiry_renewal_date,'DD-MON-RR') expiry_renewal_date
                        from mis.expo_info
                        where export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')
                        and expo_product_name = decode('$request->expo_product_name','All',expo_product_name,'$request->expo_product_name')                            
                    ) 
            where current_status = decode('$request->current_status','All',current_status,'$request->current_status')
            order by export_country,expo_product_name,submission_date asc
        ");

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
                                                                                  when 'Select Status' then decode( nvl(inprocess,'null') ,'YES','In-Process' ,'NO','NO' ,'null','No Data Found','undefined')                                                            
                                                                                  end  
                                                                              ) 
                                                            
                                                            end  current_status, 
                    approval_date registration_date,expiry_renewal_date
                from mis.expo_info
                where export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')
                and expo_product_name = decode('$request->expo_product_name','All',expo_product_name,'$request->expo_product_name')
            )
            group by current_status
            order by current_status asc
        ");


        return response()->json([
            'result'=>$result,
            'ssStatus'=>$ssStatus,
        ]);
    }



    //
    public function yearWiseSubStatus(){

        DB::statement("alter session set nls_date_format = 'DD-MON-RRRR'");
        $rs = DB::select("select distinct to_char(to_date('01-jan-2006','dd-mon-rrrr') + rownum -1,'rrrr') year from all_objects where rownum <= to_date(sysdate,'dd-mon-rrrr')-to_date('01-jan-2006','dd-mon-rrrr')+1 order by year");
        $result = DB::select("
                    select year,export_country,expo_product_name,current_status,dated
                    from(
                        select to_char(submitted_to_im,'RRRR') YEAR,expo_product_name,export_country,
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
                            end DATED
                        from mis.expo_info    
                    )
                    where current_status not in ('No Data Found','undefined','null')
                    order by year,export_country,current_status asc        
        
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

        $cstatus = DB::select("
            select current_status,nvl(count(*),0) status
            from(            
                select export_country,expo_product_name,to_char(submitted_to_im,'DD-MON-RR') submission_date,
                    case nvl(current_status,'null') 
                      when 'null' then 'No Data Found'              
                      when 'Select Status' then decode( nvl(inprocess,'null') ,'YES','In-Process' ,'NO','NO' ,'null','No Data Found','undefined')                                                                
                      when 'REG'  then 'Registered'
                      when 'REJ'  then 'Rejected'
                      when 'WFRD' then 'Withdrawl' 
                      when 'DBAM' then 'Dropped By Agent'
                      when 'In-Process' then 'In-Process'                                             
                    end current_status, 
                    approval_date registration_date,expiry_renewal_date
                from mis.expo_info
            )            
            group by current_status
            order by current_status
        ");

        return view('expo_database.Reports.yearWiseSubStatus',[
            'rs'=>$rs,
            'result'=>$result,
            'noOfCountry' => $noOfCountry,
            'noOfBrand' => $noOfBrand,
            'cstatus' => $cstatus,

        ]);
    }
    public function getYearWiseSubmissionStatus(Request $request){

        $rs =  DB::select("
            select year,export_country,expo_product_name,current_status,dated
            from(
                select to_char(submitted_to_im,'RRRR') YEAR,expo_product_name,export_country,
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
                    end DATED
                from mis.expo_info    
                where to_char(submitted_to_im,'RRRR') = decode('$request->year','All',to_char(submitted_to_im,'RRRR'),'$request->year') 
                --and export_country = decode('All','All',export_country,'All') 
            )
            where current_status not in ('No Data Found','undefined','null')
            order by year,export_country,current_status asc
        
        ");

        $ssStatus = DB::select("
            select current_status,count(*) status
            from(
            
                select export_country,expo_product_name,to_char(submitted_to_im,'DD-MON-RR') submission_date,
                    case nvl(current_status,'null') 
                      when 'null' then 'No Data Found'              
                      when 'Select Status' then decode( nvl(inprocess,'null') ,'YES','In-Process' ,'NO','NO' ,'null','No Data Found','undefined')                                                                
                      when 'REG'  then 'Registered'
                      when 'REJ'  then 'Rejected'
                      when 'WFRD' then 'Withdrawl' 
                      when 'DBAM' then 'Dropped By Agent'
                      when 'In-Process' then 'In-Process'                                             
                    end current_status, 
                    approval_date registration_date,expiry_renewal_date
                from mis.expo_info
                where to_char(submitted_to_im,'RRRR') = decode('$request->year','All',to_char(submitted_to_im,'RRRR'),'$request->year')                
            )
            group by current_status
            order by current_status asc
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
            and to_char(submitted_to_im,'RRRR') = decode('$request->year','All',to_char(submitted_to_im,'RRRR'),'$request->year')
            order by export_country asc
        ");

        $noOfBrand = DB::select("
            select count(BRAND_NAME) brand_name
            from mis.expo_info
            where to_char(submitted_to_im,'RRRR') = decode('$request->year','All',to_char(submitted_to_im,'RRRR'),'$request->year')
            order by export_country asc
        ");

        return response()->json([
            'rs'=>$rs,
            'ssStatus'=>$ssStatus,
            'noOfCountry' => $noOfCountry,
            'noOfBrand' => $noOfBrand,
        ]);
    }


    public function bulkProdStatus(){

        DB::statement("alter session set nls_date_format = 'DD-MON-RRRR'");
        $rs = DB::select("select distinct to_char(to_date('01-jan-2006','dd-mon-rrrr') + rownum -1,'rrrr') year from all_objects where rownum <= to_date(sysdate,'dd-mon-rrrr')-to_date('01-jan-2006','dd-mon-rrrr')+1 order by year");
        /*$result =  DB::select("
            select to_char(submitted_to_im,'RRRR') YEAR,product_code,brand_name,expo_product_name,export_country,
                case nvl(current_status,'null')
                    when 'Select Status' then decode( nvl(inprocess,'null') ,'YES','In-Process' ,'NO','NO' ,'null','No Data Found','undefined')
                    when 'REG' then 'Registered'
                    when 'REJ' then 'Rejected'
                    when 'WFRD' then 'Withdrawl'
                    when 'DBAM' then 'Dropped By Agent'
                    when 'In-Process' then 'In-Process'
                end current_status
            from mis.expo_info
            order by year,export_country,brand_name
        ");*/

        $result =  DB::select("
            select to_char(submitted_to_im,'RRRR') YEAR,product_code,brand_name,expo_product_name,export_country,
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
                                                            
                                                            end  current_status
            from mis.expo_info    
            order by year,export_country,brand_name
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

        /*$cstatus = DB::select("
            select current_status,nvl(count(*),0) status
            from(
                select export_country,expo_product_name,to_char(submitted_to_im,'DD-MON-RR') submission_date,
                    case nvl(current_status,'null')
                      when 'Select Status' then decode( nvl(inprocess,'null') ,'YES','In-Process' ,'NO','NO' ,'null','No Data Found','undefined')
                      when 'REG'  then 'Registered'
                      when 'REJ'  then 'Rejected'
                      when 'WFRD' then 'Withdrawl'
                      when 'DBAM' then 'Dropped By Agent'
                      when 'In-Process' then 'In-Process'
                    end current_status,
                    approval_date registration_date,expiry_renewal_date
                from mis.expo_info
            )
            group by current_status
            order by current_status
        ");*/

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
                                                                                  when 'REJ'  then 'Rejected'
                                                                                  when 'PERMITTED'  then 'Permitted'
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


        return view('expo_database.Reports.bulkProdStatus',[
            'allCountry'=>$allCountry,
            'rs'=>$rs,
            'result'=>$result,
            'noOfCountry' => $noOfCountry,
            'noOfBrand' => $noOfBrand,
            'cstatus' => $cstatus,

        ]);
    }


    public function getQABulkProductStatus(Request $request){

        if($request->year == 'All' && $request->expo_country == 'All'){
            /*$rs =  DB::select("
            select to_char(submitted_to_im,'RRRR') YEAR,product_code,brand_name,expo_product_name,export_country,
                    case nvl(current_status,'null')
                        when 'null' then 'No Data Found'
                        when 'Select Status' then decode( nvl(inprocess,'null') ,'YES','In-Process' ,'NO','NO' ,'null','No Data Found','undefined')
                        when 'REG' then 'Registered'
                        when 'REJ' then 'Rejected'
                        when 'WFRD' then 'Withdrawl'
                        when 'DBAM' then 'Dropped By Agent'
                        when 'In-Process' then 'In-Process'
                        end current_status
                    from mis.expo_info
                    order by year,export_country,expo_product_name
            ");*/
            $rs =  DB::select("
            select to_char(submitted_to_im,'RRRR') YEAR,product_code,brand_name,expo_product_name,export_country,
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
                                                            
                    end  current_status      
                    from mis.expo_info                       
                    order by year,export_country,expo_product_name
            ");
        }else{
            /*$rs =  DB::select("
            select to_char(submitted_to_im,'RRRR') YEAR,product_code,brand_name,expo_product_name,export_country,
                    case nvl(current_status,'null')
                        when 'null' then 'No Data Found'
                        when 'Select Status' then decode( nvl(inprocess,'null') ,'YES','In-Process' ,'NO','NO' ,'null','No Data Found','undefined')
                        when 'REG' then 'Registered'
                        when 'REJ' then 'Rejected'
                        when 'WFRD' then 'Withdrawl'
                        when 'DBAM' then 'Dropped By Agent'
                        when 'In-Process' then 'In-Process'
                        end current_status
                    from mis.expo_info
                    where to_char(submitted_to_im,'RRRR') = decode('$request->year','All',to_char(submitted_to_im,'RRRR'),'$request->year')
                    and export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')
                    order by year,export_country,expo_product_name
            ");*/

            $rs =  DB::select("
            select to_char(submitted_to_im,'RRRR') YEAR,product_code,brand_name,expo_product_name,export_country,
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
                                                            
                    end  current_status          
                    from mis.expo_info    
                    where to_char(submitted_to_im,'RRRR') = decode('$request->year','All',to_char(submitted_to_im,'RRRR'),'$request->year') 
                    and export_country = decode('$request->expo_country','All',export_country,'$request->expo_country') 
                    order by year,export_country,expo_product_name
            ");
        }


        if($request->year == 'All' && $request->expo_country == 'All'){
            /*$ssStatus = DB::select("
            select current_status,count(*) status
            from(

                select export_country,expo_product_name,to_char(submitted_to_im,'DD-MON-RR') submission_date,
                    case nvl(current_status,'null')
                      when 'null' then 'No Data Found'
                      when 'Select Status' then decode( nvl(inprocess,'null') ,'YES','In-Process' ,'NO','NO' ,'null','No Data Found','undefined')
                      when 'REG'  then 'Registered'
                      when 'REJ'  then 'Rejected'
                      when 'WFRD' then 'Withdrawl'
                      when 'DBAM' then 'Dropped By Agent'
                      when 'In-Process' then 'In-Process'
                    end current_status,
                    approval_date registration_date,expiry_renewal_date
                from mis.expo_info
            )
            group by current_status
            order by current_status asc
        ");*/
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
                                                                                  when 'Select Status' then decode( nvl(inprocess,'null') ,'YES','In-Process' ,'NO','NO' ,'null','No Data Found','undefined')                                                            
                                                                                  end  
                                                                              ) 
                                                            
                    end  current_status ,
                    approval_date registration_date,expiry_renewal_date
                from mis.expo_info                
            )
            group by current_status
            order by current_status asc
        ");
        }else{
            /*$ssStatus = DB::select("
            select current_status,count(*) status
            from(

                select export_country,expo_product_name,to_char(submitted_to_im,'DD-MON-RR') submission_date,
                    case nvl(current_status,'null')
                      when 'null' then 'No Data Found'
                      when 'Select Status' then decode( nvl(inprocess,'null') ,'YES','In-Process' ,'NO','NO' ,'null','No Data Found','undefined')
                      when 'REG'  then 'Registered'
                      when 'REJ'  then 'Rejected'
                      when 'WFRD' then 'Withdrawl'
                      when 'DBAM' then 'Dropped By Agent'
                      when 'In-Process' then 'In-Process'
                    end current_status,
                    approval_date registration_date,expiry_renewal_date
                from mis.expo_info
                where to_char(submitted_to_im,'RRRR') = decode('$request->year','All',to_char(submitted_to_im,'RRRR'),'$request->year')
                and export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')
            )
            group by current_status
            order by current_status asc
        ");*/
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
                                                                                  when 'Select Status' then decode( nvl(inprocess,'null') ,'YES','In-Process' ,'NO','NO' ,'null','No Data Found','undefined')                                                            
                                                                                  end  
                                                                              ) 
                                                            
                    end  current_status ,
                    approval_date registration_date,expiry_renewal_date
                from mis.expo_info
                where to_char(submitted_to_im,'RRRR') = decode('$request->year','All',to_char(submitted_to_im,'RRRR'),'$request->year') 
                and export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')              
            )
            group by current_status
            order by current_status asc
        ");
        }


        if($request->year == 'All' && $request->expo_country == 'All'){
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
            order by export_country asc
        ");
        }else{
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
            and to_char(submitted_to_im,'RRRR') = decode('$request->year','All',to_char(submitted_to_im,'RRRR'),'$request->year')
            and export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')    
            order by export_country asc
            ");
        }

        if($request->year == 'All' && $request->expo_country == 'All'){
            $noOfBrand = DB::select("
            select count(BRAND_NAME) brand_name
            from mis.expo_info            
            order by export_country asc
        ");
        }else{
            $noOfBrand = DB::select("
            select count(BRAND_NAME) brand_name
            from mis.expo_info
            where to_char(submitted_to_im,'RRRR') = decode('$request->year','All',to_char(submitted_to_im,'RRRR'),'$request->year')
            and export_country = decode('$request->expo_country','All',export_country,'$request->expo_country')
            order by export_country asc
        ");

        }



        return response()->json([
            'rs'=>$rs,
            'ssStatus'=>$ssStatus,
            'noOfCountry' => $noOfCountry,
            'noOfBrand' => $noOfBrand,
        ]);
    }

}