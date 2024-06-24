<?php

namespace App\Http\Controllers;

use App\TgpDbQueries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class TgpRepController extends Controller
{  
   //first loading the view	
   public function team_growth_percent(){

      // $currentYear = date('Y');

      //09.10.2018...max year
      $maxyear=DB::select("SELECT max(TO_NUMBER(Y.SALES_YEAR)) SALES_YEAR
        FROM MIS.YEAR_WISE_SUMMARY_DATA Y where not sales_year='Growth'");


      $currentYear=(int)$maxyear[0]->sales_year;

      $user = Auth::user()->user_id;

        $data_full_partial = DB::select("select count(*) cnt from mis.dashboard_users_info 
                            where  sales_report='ALL'
                            AND
                            user_id =?
                          ", [$user]);

        $status_full_partial='';
        if($data_full_partial[0]->cnt){
            $status_full_partial='full';
        }else{
            $status_full_partial='partial';
        }

      

        return view('reports_layout.team_growth_percent')
            ->with('gtotal',DB::select(TgpDbQueries::query29_summary_total($currentYear)))
            ->with('gtotal1',DB::select(TgpDbQueries::query29_summary_total01($currentYear)))
            ->with('mon_excl_da_gwth',DB::select(TgpDbQueries::query42_team_growth_percent_2_dataMONEXCLCUMU()))
            ->with('mon_incl_da_gwth',DB::select(TgpDbQueries::query43_team_growth_percent_2_dataMONINCLCUMU()))
            ->with('maxyear',$currentYear)
            ->with('maxyearminus1',$currentYear-1)
            ->with('maxyearminus2',$currentYear-2)
            ->with('full_partial',$data_full_partial)
            ->with('status_admin',$status_full_partial);
    }


   //return response data
   public function team_growth_percent_data_upd(Request $request){

        if($request->ajax())
        {
             // $currentYear = date('Y');
            //09.10.2018...max year
            $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");



            $currentYear=(int)$maxyear[0]->sales_year;

             $DataList = [];
            $queryData =DB::select(TgpDbQueries::query1_team_growth_percent_data());

            $DataList[] = $queryData;

            /* Second  */

            $queryData =DB::select(TgpDbQueries::query2_team_growth_percent_2_data());

            $DataList[] = $queryData;

            /* three  */

            $queryData =DB::select(TgpDbQueries::query3_team_growth_percent_dataAG());

            $DataList[] = $queryData;

            /* four  */

            $queryData =DB::select(TgpDbQueries::query4_team_growth_percent_dataOX());

            $DataList[] = $queryData;

            /* five  */

            $queryData =DB::select(TgpDbQueries::query5_team_growth_percent_2_dataOX());

            $DataList[] = $queryData;

            /* Six  */

            $queryData =DB::select(TgpDbQueries::query6_team_growth_percent_dataOPX());

            $DataList[] = $queryData;

            /* Seven  */

            $queryData =DB::select(TgpDbQueries::query7_team_growth_percent_dataCL());

            $DataList[] = $queryData;

            /* Eight  */

            $queryData =DB::select(TgpDbQueries::query8_team_growth_percent_2_dataCL());

            $DataList[] = $queryData;

            /* Nine  */

            $queryData =DB::select(TgpDbQueries::query9_team_growth_percent_dataKL());

            $DataList[] = $queryData;

            /* Ten  */

            $queryData =DB::select(TgpDbQueries::query10_team_growth_percent_2_dataKL());

            $DataList[] = $queryData;

            /* Eleven  */

            $queryData =DB::select(TgpDbQueries::query11_team_growth_percent_dataZY());

            $DataList[] = $queryData;

            /* Twelve  */

            $queryData =DB::select(TgpDbQueries::query12_team_growth_percent_2_dataZY());

            $DataList[] = $queryData;

            /* Thirteen  */

            $queryData =DB::select(TgpDbQueries::query13_team_growth_percent_dataAH());

            $DataList[] = $queryData;

            /* Fourteen  */

            $queryData =DB::select(TgpDbQueries::query14_team_growth_percent_2_dataAH());

            $DataList[] = $queryData;

            /* Fifteen  */

            $queryData =DB::select(TgpDbQueries::query15_team_growth_percent_dataTSO());

            $DataList[] = $queryData;

            /* Sixteen  */

            $queryData =DB::select(TgpDbQueries::query16_team_growth_percent_2_dataTSO());

            $DataList[] = $queryData;

            /* Seventeen  */

        $queryData =DB::select(TgpDbQueries::query17_team_growth_percent_dataSK());

        $DataList[] = $queryData;

            /* Eighteen  */

         $queryData =DB::select(TgpDbQueries::query18_team_growth_percent_2_dataSK());
            $DataList[] = $queryData;

            /* Nineteen  */

            $queryData =DB::select(TgpDbQueries::query19_team_growth_percent_dataSP());

            $DataList[] = $queryData;

            /* Twenty */

            $queryData =DB::select(TgpDbQueries::query20_team_growth_percent_2_dataSP());

            $DataList[] = $queryData;

            /* twenty one */

            $queryData =DB::select(TgpDbQueries::query21_team_growth_percent_dataGN());

            $DataList[] = $queryData;

            //twenty two

            $queryData =DB::select(TgpDbQueries::query22_team_growth_percent_2_dataGN());

            $DataList[] = $queryData;

            //twenty three

           

            //ned to change query largest to smallest 6.4.2019
            $queryData =DB::select(TgpDbQueries::query23_summary_data($currentYear));

            $DataList[] = $queryData;

            //twenty four

            $queryData =DB::select(TgpDbQueries::query24_summary_data2($currentYear));
            $DataList[] = $queryData;

            //twenty five

            $queryData =DB::select(TgpDbQueries::query25_summary_data3($currentYear));

            $DataList[] = $queryData;

            //twenty six

            $queryData =DB::select(TgpDbQueries::query26_summary_data4($currentYear));

            $DataList[] = $queryData;

            //twenty seven

            $queryData =DB::select(TgpDbQueries::query27_summary_data5($currentYear));

            $DataList[] = $queryData;

            //twenty eight

            $queryData =DB::select(TgpDbQueries::query28_summary_data6($currentYear));

            $DataList[] = $queryData;

            //thirty

            $queryData =DB::select(TgpDbQueries::query30_summary_data($currentYear));

            $DataList[] = $queryData;


            //thirty one

            $queryData =DB::select(TgpDbQueries::query31_summary_data());

            $DataList[] = $queryData;

            //thirty two

            $queryData =DB::select(TgpDbQueries::query32_summary_data($currentYear));

            $DataList[] = $queryData;


            //thirty three

            $queryData =DB::select(TgpDbQueries::query33_summary_data());

            $DataList[] = $queryData;

            ////34
            $queryData =DB::select(TgpDbQueries::query34_team_growth_percent_dataAV());
            $DataList[] = $queryData;


            ////35
            $queryData =DB::select(TgpDbQueries::query35_team_growth_percent_2_dataAV());
            $DataList[] = $queryData;

            ////36
            $queryData =DB::select(TgpDbQueries::query36_team_growth_percent_dataKLInter());
            $DataList[] = $queryData;

            ////37
            $queryData =DB::select(TgpDbQueries::query37_team_growth_percent_2_dataKLInter());
            $DataList[] = $queryData;


            //38
            $queryData =DB::select(TgpDbQueries::query38_team_growth_percent_dataMONINCL());
            $DataList[] = $queryData;

            //39
            $queryData =DB::select(TgpDbQueries::query39_team_growth_percent_2_dataMONINCL());
            $DataList[] = $queryData;

            //40
            $queryData =DB::select(TgpDbQueries::query40_team_growth_percent_dataMONEXCL());
            $DataList[] = $queryData;

            //41
            $queryData =DB::select(TgpDbQueries::query41_team_growth_percent_2_dataMONEXCL());
            $DataList[] = $queryData;


            //42
//            $queryData =DB::select(TgpDbQueries::query42_team_growth_percent_2_dataMONEXCLCUMU());
//            $DataList[] = $queryData;

////43
            $queryData =DB::select(TgpDbQueries::query43_team_growth_percent_dataHygiene());
            $DataList[] = $queryData;

            ////44
            $queryData =DB::select(TgpDbQueries::query44_team_growth_percent_2_dataHygiene());
            $DataList[] = $queryData;

            //45
            $queryData =DB::select(TgpDbQueries::query45_team_growth_percent_data_herbalNutricare());
            $DataList[] = $queryData;

            ////46
            $queryData =DB::select(TgpDbQueries::query46_team_growth_percent_2_data_herbalNutricare());
            $DataList[] = $queryData;

            return response($DataList);
        }
    }
 
}
