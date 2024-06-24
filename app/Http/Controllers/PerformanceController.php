<?php

namespace App\Http\Controllers;
use App\PerformDbQueries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerformanceController extends Controller
{
   


    public function performance_report_view(){

        
        $result = DB::table('MIS.COMPANY_WISE_SALES_SUMMARY')->select(DB::raw('max(sales_year) as sales_year'))->first();

        $currentYear = date('Y');

        // $kinetix_r=DB::select("SELECT Y.P_GROUP, Y.SYEAR, Y.SYEAR1,Y.SYEAR2,
        // Y.SYEAR1G, Y.SALES_YEAR FROM MIS.YEAR_WISE_SUMMARY_DATA Y 
        // where Y.P_GROUP='KINETIX-Inter Company Sales (Hospicare)' 
        // and Y.sales_year='$currentYear'");

//        var_dump(kinetix_r);

        // return view('sale_report_layout.perform_report',compact('result','kinetix_r'));
         return view('sale_report_layout.perform_report',compact('result'));
//        dd($result);
    }

    public function resp_perform_table_data(Request $request){

        if($request->ajax())
        {
            /*ast_gyr 1  */
            

            $DataList = [];
            $queryData =DB::select(PerformDbQueries::query1_year5_teamperform_data());

            $DataList[] = $queryData;

            /* Second  */

            $queryData =DB::select(PerformDbQueries::query2_year4_teamperform_data());

            $DataList[] = $queryData;

            /* 3rd  */

            $queryData =DB::select(PerformDbQueries::query3_year3_teamperform_data());

            $DataList[] = $queryData;


            /* 4th  */

//            $queryData =DB::select(PerformDbQueries::query4_year2_teamperform_data());
//
//            $DataList[] = $queryData;
//
//            /* 5th  */
//
//            $queryData =DB::select(PerformDbQueries::query5_year1_teamperform_data());
//
//            $DataList[] = $queryData;

                ////------------------OPR XEN-------------------------------


            /* 6th opr_xen  */

            $queryData =DB::select(PerformDbQueries::query6_year5_oprxen_teamperform_data());

            $DataList[] = $queryData;


            /* 7th opr_xen  */

            $queryData =DB::select(PerformDbQueries::query7_year4_oprxen_teamperform_data());

            $DataList[] = $queryData;

            /* 8th opr_xen  */

            $queryData =DB::select(PerformDbQueries::query8_year3_oprxen_teamperform_data());

            $DataList[] = $queryData;

            /* 9th opr_xen  */

//            $queryData =DB::select(PerformDbQueries::query9_year2_oprxen_teamperform_data());
//
//            $DataList[] = $queryData;
//
//            /* 10th opr_xen  */
//
//            $queryData =DB::select(PerformDbQueries::query10_year1_oprxen_teamperform_data());
//
//            $DataList[] = $queryData;




            //////////////////////////////Total special done///////////////////////
             /* 11th opr_xen  */

            $queryData =DB::select(PerformDbQueries::query11_year5_special_teamperform_data());

            $DataList[] = $queryData;


            /* 12th opr_xen  */

            $queryData =DB::select(PerformDbQueries::query12_year4_special_teamperform_data());

            $DataList[] = $queryData;

            /* 13rd opr_xen  */

            $queryData =DB::select(PerformDbQueries::query13_year3_special_teamperform_data());

            $DataList[] = $queryData;

            /* 14th opr_xen  */

//            $queryData =DB::select(PerformDbQueries::query14_year2_special_teamperform_data());
//
//            $DataList[] = $queryData;
//
//            /* 15th opr_xen  */
//
//            $queryData =DB::select(PerformDbQueries::query15_year1_special_teamperform_data());
//
//            $DataList[] = $queryData;


            //////////////////////////////cellbiotic team///////////////////////
             /* 16th cellbiotic  */

            $queryData =DB::select(PerformDbQueries::query16_year5_cellbiotic_teamperform_data());

            $DataList[] = $queryData;


            /* 17th cellbiotic  */

            $queryData =DB::select(PerformDbQueries::query17_year4_cellbiotic_teamperform_data());

            $DataList[] = $queryData;

            /* 18rd cellbiotic  */

            $queryData =DB::select(PerformDbQueries::query18_year3_cellbiotic_teamperform_data());

            $DataList[] = $queryData;

            /* 19th cellbiotic  */
//
//            $queryData =DB::select(PerformDbQueries::query19_year2_cellbiotic_teamperform_data());
//
//            $DataList[] = $queryData;
//
//            /* 20th cellbiotic  */
//
//            $queryData =DB::select(PerformDbQueries::query20_year1_cellbiotic_teamperform_data());
//
//            $DataList[] = $queryData;

            //////////////////////////////Kinetix team///////////////////////
             /* 21th Kinetix  */

            $queryData =DB::select(PerformDbQueries::query21_year5_kinetix_teamperform_data());

            $DataList[] = $queryData;


            /* 22th Kinetix  */

            $queryData =DB::select(PerformDbQueries::query22_year4_kinetix_teamperform_data());

            $DataList[] = $queryData;

            /* 23rd Kinetix  */

            $queryData =DB::select(PerformDbQueries::query23_year3_kinetix_teamperform_data());

            $DataList[] = $queryData;

            /* 24th Kinetix  */

//            $queryData =DB::select(PerformDbQueries::query24_year2_kinetix_teamperform_data());
//
//            $DataList[] = $queryData;
//
//            /* 25th Kinetix  */
//
//            $queryData =DB::select(PerformDbQueries::query25_year1_kinetix_teamperform_data());
//
//            $DataList[] = $queryData;

            //////////////////////////////zymos team///////////////////////
             /* 26th zymos  */

            $queryData =DB::select(PerformDbQueries::query26_year5_zymos_teamperform_data());

            $DataList[] = $queryData;


            /* 27th zymos  */

            $queryData =DB::select(PerformDbQueries::query27_year4_zymos_teamperform_data());

            $DataList[] = $queryData;

            /* 28rd zymos  */

            $queryData =DB::select(PerformDbQueries::query28_year3_zymos_teamperform_data());

            $DataList[] = $queryData;

            /* 29th zymos  */

//            $queryData =DB::select(PerformDbQueries::query29_year2_zymos_teamperform_data());
//
//            $DataList[] = $queryData;
//
//            /* 30th zymos  */
//
//            $queryData =DB::select(PerformDbQueries::query30_year1_zymos_teamperform_data());
//
//            $DataList[] = $queryData;

            //////////////////////////////total general///////////////////////
             /* 31th general  */

            $queryData =DB::select(PerformDbQueries::query31_year5_totgeneral_teamperform_data());

            $DataList[] = $queryData;


            /* 32th general  */

            $queryData =DB::select(PerformDbQueries::query32_year4_totgeneral_teamperform_data());

            $DataList[] = $queryData;

            /* 33rd general  */

            $queryData =DB::select(PerformDbQueries::query33_year3_totgeneral_teamperform_data());

            $DataList[] = $queryData;

            /* 34th general  */

//            $queryData =DB::select(PerformDbQueries::query34_year2_totgeneral_teamperform_data());
//
//            $DataList[] = $queryData;
//
//            /* 35th general  */
//
//            $queryData =DB::select(PerformDbQueries::query35_year1_totgeneral_teamperform_data());
//
//            $DataList[] = $queryData;


            //////////////////////////////ihhl mpo///////////////////////
             /* 36th IHHL_MPO  */

//            $queryData =DB::select(PerformDbQueries::query36_year5_ihhl_mpo_teamperform_data());
//
//            $DataList[] = $queryData;


            /* 37th ihhl mpo  */

//            $queryData =DB::select(PerformDbQueries::query37_year4_ihhl_mpo_teamperform_data());
//
//            $DataList[] = $queryData;

            /* 38rd IHHL_MPO  */
//
//            $queryData =DB::select(PerformDbQueries::query38_year3_ihhl_mpo_teamperform_data());
//
//            $DataList[] = $queryData;

            /* 39th IHHL_MPO  */

//            $queryData =DB::select(PerformDbQueries::query39_year2_ihhl_mpo_teamperform_data());
//
//            $DataList[] = $queryData;
//
//            /* 40th IHHL_MPO  */
//
//            $queryData =DB::select(PerformDbQueries::query40_year1_ihhl_mpo_teamperform_data());
//
//            $DataList[] = $queryData;

            //////////////////////////////ihhl tso///////////////////////
             /* 41th IHHL_TSO  */

//            $queryData =DB::select(PerformDbQueries::query41_year5_ihhl_tso_teamperform_data());
//
//            $DataList[] = $queryData;
//
//
//            /* 42th IHHL_TSO  */
//
//            $queryData =DB::select(PerformDbQueries::query42_year4_ihhl_tso_teamperform_data());
//
//            $DataList[] = $queryData;
//
//            /* 43rd IHHL_TSO  */
//
//            $queryData =DB::select(PerformDbQueries::query43_year3_ihhl_tso_teamperform_data());
//
//            $DataList[] = $queryData;

            /* 44th IHHL_TSO  */

//            $queryData =DB::select(PerformDbQueries::query44_year2_ihhl_tso_teamperform_data());
//
//            $DataList[] = $queryData;
//
//            /* 45th IHHL_TSO  */
//
//            $queryData =DB::select(PerformDbQueries::query45_year1_ihhl_tso_teamperform_data());
//
//            $DataList[] = $queryData;



            //////////////////////////////total ihhl///////////////////////
             /* 46th total ihhl  */

            $queryData =DB::select(PerformDbQueries::query46_year5_tot_ihhl_teamperform_data());

            $DataList[] = $queryData;


            /* 47th total ihhl  */

            $queryData =DB::select(PerformDbQueries::query47_year4_tot_ihhl_teamperform_data());

            $DataList[] = $queryData;

            /* 48rd total ihhl */

            $queryData =DB::select(PerformDbQueries::query48_year3_tot_ihhl_teamperform_data());

            $DataList[] = $queryData;

            /* 49th total ihhl*/
//
//            $queryData =DB::select(PerformDbQueries::query49_year2_tot_ihhl_teamperform_data());
//
//            $DataList[] = $queryData;
//
//            /* 50th total ihhl*/
//
//            $queryData =DB::select(PerformDbQueries::query50_year1_tot_ihhl_teamperform_data());
//
//            $DataList[] = $queryData;

            //////////////////////////////ihnl///////////////////////
             /* 51th total ihhl  */

            $queryData =DB::select(PerformDbQueries::query51_year5_ihnl_teamperform_data());

            $DataList[] = $queryData;


            /* 52th total ihhl  */

            $queryData =DB::select(PerformDbQueries::query52_year4_ihnl_teamperform_data());

            $DataList[] = $queryData;

            /* 53rd total ihhl */

            $queryData =DB::select(PerformDbQueries::query53_year3_ihnl_teamperform_data());

            $DataList[] = $queryData;

            /*54th total ihhl*/

//            $queryData =DB::select(PerformDbQueries::query54_year2_ihnl_teamperform_data());
//
//            $DataList[] = $queryData;
//
//            /* 55th total ihhl*/
//
//            $queryData =DB::select(PerformDbQueries::query55_year1_ihnl_teamperform_data());
//
//            $DataList[] = $queryData;

            //////////////////////////////ianh///////////////////////
             /* 56th ahvd*/

            $queryData =DB::select(PerformDbQueries::query56_year5_ahvd_teamperform_data());

            $DataList[] = $queryData;


            /* 57th ahvd*/

            $queryData =DB::select(PerformDbQueries::query57_year4_ahvd_teamperform_data());

            $DataList[] = $queryData;

            /* 58rd ahvd*/

            $queryData =DB::select(PerformDbQueries::query58_year3_ahvd_teamperform_data());

            $DataList[] = $queryData;

            /*59th ianh*/

//            $queryData =DB::select(PerformDbQueries::query59_year2_ianh_teamperform_data());
//
//            $DataList[] = $queryData;
//
//            /* 60th ianh*/
//
//            $queryData =DB::select(PerformDbQueries::query60_year1_ianh_teamperform_data());
//
//            $DataList[] = $queryData;


            //////////////////////////////institute///////////////////////
             /* 61th inst*/

            $queryData =DB::select(PerformDbQueries::query61_year5_inst_teamperform_data());

            $DataList[] = $queryData;


            /* 62th total ihhl  */

            $queryData =DB::select(PerformDbQueries::query62_year4_inst_teamperform_data());

            $DataList[] = $queryData;

            /* 63rd total ihhl */

            $queryData =DB::select(PerformDbQueries::query63_year3_inst_teamperform_data());

            $DataList[] = $queryData;

            /*64th total ihhl*/

//            $queryData =DB::select(PerformDbQueries::query64_year2_inst_teamperform_data());
//
//            $DataList[] = $queryData;
//
//            /* 65th total ihhl*/
//
//            $queryData =DB::select(PerformDbQueries::query65_year1_inst_teamperform_data());
//
//            $DataList[] = $queryData;

             /* 66th company wise*/

            $queryData =DB::select(PerformDbQueries::query66_company_wise_sales_summery_data());

            $DataList[] = $queryData;

            /* 67th company wise*/

            $queryData =DB::select(PerformDbQueries::query67_company_wise_sales_summery_data());

            $DataList[] = $queryData;


            ////new//////////////

            /////////////////////////////ihnl///////////////////////
            /* 68th total ihhl  */

            $queryData =DB::select(PerformDbQueries::query68_year5_tot_depo_sale_teamperform_data());

            $DataList[] = $queryData;


            /* 69th total ihhl  */

            $queryData =DB::select(PerformDbQueries::query69_year4_tot_depo_sale_teamperform_data());

            $DataList[] = $queryData;

            /*70th total ihhl */

            $queryData =DB::select(PerformDbQueries::query70_year3_tot_depo_sale_teamperform_data());

            $DataList[] = $queryData;

            /* 71th company wise*/

            $queryData =DB::select(PerformDbQueries::query71_company_wise_sales_summery_data());

            $DataList[] = $queryData;

            //ivl start-- added on 12/02/2020

            /*First */

            $queryData =DB::select(PerformDbQueries::query_ivl_year5_teamperform_data());

            $DataList[] = $queryData;

            /*Second */
            $queryData =DB::select(PerformDbQueries::query2_ivl_year4_teamperform_data());

            $DataList[] = $queryData;
            /*Third */
            $queryData =DB::select(PerformDbQueries::query3_ivl_year3_teamperform_data());

            $DataList[] = $queryData;

            //ivl end
           

            return response($DataList);
        }
    }

    public function dhk_grp_mkt_report_view(Request $request){
        
        $month = DB::table('MIS.DHK_GRP_MKT_WISE_SALES')->select('report_month','twd','wd')->distinct()->first();
        $prd_out_on = DB::table('MIS.DHK_GRP_MKT_WISE_SALES')->select('report_upto')->distinct()->first();
        $reprot_d = DB::table('MIS.DHK_GRP_MKT_WISE_SALES')->select('report_date')->distinct()->first();
        
        $datas=DB::select("select * from MIS.DHK_GRP_MKT_WISE_SALES order by grand_total desc");


         return view('sale_report_layout.dhk_grp_mkt_product_rep',compact('datas','month','prd_out_on','reprot_d'));
    }

    public function national_qty_trg_arh_report_view(Request $request){
        
        $month = DB::table('MIS.NATIONAL_TARGET_SALES_ACHVM')->select('report_upto','report_date','report_month','twd','wd')->distinct()->first();
        
        return view('sale_report_layout.national_qty_trg_arch',compact('month'));
    }
    public function national_qty_trg_arh_data(Request $request){

        if($request->ajax())
        {
            // $queryData =DB::select("select p_group,p_name,pack_s,n_tgt_qty,n_sales_qty, Round(achievement,2) as achievement FROM MIS.NATIONAL_TARGET_SALES_ACHVM
            //             order by p_group");
            $queryData =DB::select("select p_group,p_name,pack_s,Round(n_tgt_qty,2) as n_tgt_qty,n_sales_qty, Round(achievement,2) as achievement FROM MIS.NATIONAL_TARGET_SALES_ACHVM
                        order by p_group,p_name");
            
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($queryData),
                "iTotalDisplayRecords" => count($queryData),
                "aaData" => $queryData);
            return response()->json($results);
        }
    }

    
}
