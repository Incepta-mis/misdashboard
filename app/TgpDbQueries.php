<?php

namespace App;
use DB;
use Auth;


class TgpDbQueries
{
   public static function query1_team_growth_percent_data (){
       // $currentYear = date('Y');
       //09.10.2018...max year
      $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


      $currentYear=(int)$maxyear[0]->sales_year;

       return "SELECT 
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH, ROUND(SYEAR,2) SYEAR , 
                ROUND(SYEAR1,2) SYEAR1, ROUND(SYEAR2,2) SYEAR2                                   
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'ASTER-GYRUS' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";
   }

   public static function query2_team_growth_percent_2_data(){
        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;

        return "SELECT 
                 SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH, SYEAR1G,SYEAR2G                                 
                 FROM MIS.TEAM_WISE_SALES_GROWTH
                 WHERE trim(SALES_GROUP) in 'ASTER-GYRUS' and sales_year='$currentYear'
                 ORDER BY to_date(SALES_MONTH,'Mon')";
   }

    public static function query3_team_growth_percent_dataAG(){

         // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
         return "SELECT TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH, SYEAR1_SPG,SYEAR2_SPG ,TOT_SY1SY2
                FROM MIS.TEAM_WISE_SALES_GROWTH 
                WHERE trim(SALES_GROUP) in 'ASTER-GYRUS' 
                and SYEAR1_SPG is not null
                and SYEAR2_SPG is not null
                and TOT_SY1SY2 is not null and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }

    public static function query4_team_growth_percent_dataOX(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                 SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH, ROUND(SYEAR,2) SYEAR, 
                 ROUND(SYEAR1,2) SYEAR1, ROUND(SYEAR2,2) SYEAR2 
                 FROM MIS.TEAM_WISE_SALES_GROWTH 
                 WHERE trim(SALES_GROUP) in 'OPERON-XENOVISION' and sales_year='$currentYear'
                 ORDER BY to_date(SALES_MONTH,'Mon')";
    }

    public static function query5_team_growth_percent_2_dataOX(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH, SYEAR1G,SYEAR2G
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'OPERON-XENOVISION' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";

    }

    public static function query6_team_growth_percent_dataOPX(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH, SYEAR1_SPG,SYEAR2_SPG ,TOT_SY1SY2
                FROM MIS.TEAM_WISE_SALES_GROWTH t
                WHERE trim(SALES_GROUP) in 'OPERON-XENOVISION' and sales_year='$currentYear'
                and SYEAR1_SPG is not null
                and SYEAR2_SPG is not null
                and TOT_SY1SY2 is not null
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }

    public static function query7_team_growth_percent_dataCL(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");

        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH,ROUND(SYEAR,2) SYEAR, 
                 ROUND(SYEAR1,2) SYEAR1, ROUND(SYEAR2,2) SYEAR2 
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'CELLBIOTIC' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";

    }

    public static function query8_team_growth_percent_2_dataCL(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH, SYEAR1G,SYEAR2G
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'CELLBIOTIC' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }

    public static function query9_team_growth_percent_dataKL(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH,ROUND(SYEAR,2) SYEAR, 
                 ROUND(SYEAR1,2) SYEAR1, ROUND(SYEAR2,2) SYEAR2 
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'KINETIX' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }

    public static function query10_team_growth_percent_2_dataKL(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH, SYEAR1G,SYEAR2G
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'KINETIX' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }

    ///////////////////////////////////KINETIX_INTER/////////////////////////

    public static function query36_team_growth_percent_dataKLInter(){

        // $currentYear = date('Y');
        //09.10.2018...max year
       $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH,ROUND(SYEAR,2) SYEAR, 
                 ROUND(SYEAR1,2) SYEAR1, ROUND(SYEAR2,2) SYEAR2 
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'INTER_COMPANY_HOSPICARE' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }

    public static function query37_team_growth_percent_2_dataKLInter(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH, SYEAR1G, 
                case SYEAR2G 
                when -100 then round(0,2) else round(SYEAR2G,2) end SYEAR2G
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'INTER_COMPANY_HOSPICARE' and sales_year='$currentYear'
                and SYEAR1_SPG is not null
                and SYEAR2_SPG is not null
                and TOT_SY1SY2 is not null
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }


    ////////////////////////////////////////////////////////////////

    public static function query11_team_growth_percent_dataZY(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH,ROUND(SYEAR,2) SYEAR, 
                 ROUND(SYEAR1,2) SYEAR1, ROUND(SYEAR2,2) SYEAR2 
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'ZYMOS(INCL. HERBAL & NUTICARE)' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }

    public static function query12_team_growth_percent_2_dataZY(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH, SYEAR1G,SYEAR2G
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'ZYMOS(INCL. HERBAL & NUTICARE)' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }


    //////////////////////////////month wise excl inc diaper animal//////////////////////////////////

    public static function query38_team_growth_percent_dataMONINCL(){

       // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH,ROUND(SYEAR,2) SYEAR, 
                 ROUND(SYEAR1,2) SYEAR1, ROUND(SYEAR2,2) SYEAR2 
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'MONTH(INCL. DIAPER & ANIMAL)' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }

    public static function query39_team_growth_percent_2_dataMONINCL(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");

        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH, SYEAR1G,SYEAR2G
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'MONTH(INCL. DIAPER & ANIMAL)' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }

    public static function query40_team_growth_percent_dataMONEXCL(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH,ROUND(SYEAR,2) SYEAR, 
                 ROUND(SYEAR1,2) SYEAR1, ROUND(SYEAR2,2) SYEAR2 
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'MONTH(EXCL. DIAPER & ANIMAL)' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }

    public static function query41_team_growth_percent_2_dataMONEXCL(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH, SYEAR1G,SYEAR2G
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'MONTH(EXCL. DIAPER & ANIMAL)' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }


    ////////////////////////////////////////////////////////////////



    public static function query13_team_growth_percent_dataAH(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH,ROUND(SYEAR,2) SYEAR, 
                 ROUND(SYEAR1,2) SYEAR1, ROUND(SYEAR2,2) SYEAR2
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'ANIMAL HEALTH' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }

    public static function query14_team_growth_percent_2_dataAH(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH, SYEAR1G,SYEAR2G
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'ANIMAL HEALTH' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }

    //////////////////////animal vaccine////////////////////////////////////////////////////

    public static function query34_team_growth_percent_dataAV(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH,ROUND(SYEAR,2) SYEAR, 
                 ROUND(SYEAR1,2) SYEAR1, ROUND(SYEAR2,2) SYEAR2
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'ANIMAL VACCINE' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }

    public static function query35_team_growth_percent_2_dataAV(){

        // $currentYear = date('Y');
        //09.10.2018...max year
       $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;

// var_dump($maxyear);
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH, SYEAR1G,SYEAR2G
                FROM MIS.TEAM_WISE_SALES_GROWTH 
                WHERE trim(SALES_GROUP) in 'ANIMAL VACCINE' and sales_year='$currentYear'
                and SYEAR1_SPG is not null
                and SYEAR2_SPG is not null
                and TOT_SY1SY2 is not null
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }



    /////////////////////////////////////////animal vaccine end/////////////////////

    public static function query15_team_growth_percent_dataTSO(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH,ROUND(SYEAR,2) SYEAR, 
                 ROUND(SYEAR1,2) SYEAR1, ROUND(SYEAR2,2) SYEAR2
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'HYGIENE (DIAPER)' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }

    public static function query16_team_growth_percent_2_dataTSO(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH, SYEAR1G,SYEAR2G
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'HYGIENE (DIAPER)' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }

    public static function query17_team_growth_percent_dataSK(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH,ROUND(SYEAR,2) SYEAR, 
                 ROUND(SYEAR1,2) SYEAR1, ROUND(SYEAR2,2) SYEAR2
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'SKIN PRODUCTS' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }

    public static function query18_team_growth_percent_2_dataSK(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH, SYEAR1G,SYEAR2G
                FROM MIS.TEAM_WISE_SALES_GROWTH t
                WHERE trim(SALES_GROUP) in 'SKIN PRODUCTS' and sales_year='$currentYear'
                and SYEAR1_SPG is not null
                and SYEAR2_SPG is not null
                and TOT_SY1SY2 is not null
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }

    public static function query19_team_growth_percent_dataSP(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH,ROUND(SYEAR,2) SYEAR, 
                 ROUND(SYEAR1,2) SYEAR1, ROUND(SYEAR2,2) SYEAR2
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'SPECIAL-TEAM' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }

    public static function query20_team_growth_percent_2_dataSP(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH, SYEAR1G,SYEAR2G
                FROM MIS.TEAM_WISE_SALES_GROWTH t
                WHERE trim(SALES_GROUP) in 'SPECIAL-TEAM' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";

    }

    public static function query21_team_growth_percent_dataGN(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH, SYEAR,
                   SYEAR1, SYEAR2
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'GENERAL-TEAM' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }

    public static function query22_team_growth_percent_2_dataGN(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH, SYEAR1G,SYEAR2G
                FROM MIS.TEAM_WISE_SALES_GROWTH t
                WHERE trim(SALES_GROUP) in 'GENERAL-TEAM' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }
    //Team wise total depot sales---------last 3 years------need to order from largest to smallest by default using current year sale
    public static function query23_summary_data($year){


//        return "select upper(p_group) p_group, round(syear,2) syear, round(syear1,2) syear1, round(syear2,2) syear2
//                from mis.year_wise_summary_data where sales_year='$year' order by p_group";

        return "select upper(p_group) p_group, round(syear,2) syear, round(syear1,2) syear1, round(syear2,2) syear2
                from mis.year_wise_summary_data where sales_year='$year' order by syear2 desc";


    }
    //Team wise total depot sales---------growth% last 2 years------need to order from largest to smallest by default using current year sale
    public static function query24_summary_data2($year){


        // return "select upper(p_group) p_group,round(syear1g,2) syear1g, round(syear2g,2) syear2g
        //         from mis.year_wise_summary_data where sales_year='$year' order by p_group";

                // for handling -100
//                return "select upper(p_group) p_group,
//                        case syear1g
//                        when -100 then round(0,2)
//                        else round(syear1g,2)
//                        end
//                        syear1g,
//                        case syear2g
//                        when -100 then round(0,2)
//                        else round(syear2g,2) end syear2g
//                        from mis.year_wise_summary_data
//
//                        where sales_year='$year' order by p_group";


        return "select upper(p_group) p_group,
                        case syear1g 
                        when -100 then round(0,2)
                        else round(syear1g,2) 
                        end
                        syear1g, 
                        case syear2g
                        when -100 then round(0,2)
                        else round(syear2g,2) end syear2g,
                        round(syear2,2) syear2
                        from mis.year_wise_summary_data 

                        where sales_year='$year' order by syear2 desc";

    }
//Team wise total depot sales---2019---2018---growth---------thats jan to dec current year
    public static function query25_summary_data3($year){


//        return "select upper(p_group) p_group,round(jan,2) jan, round(feb,2) feb, round(mar,2) mar, round(apr,2) apr, round(may,2) may, round(jun,2) jun,round(jul,2) jul,round(aug,2) aug,
//                round(sep,2) sep,round(oct,2) oct,round(nov,2) nov,round(dec,2) dec,round(tot,2) tot
//                from mis.year_wise_summary_data where sales_year='$year' order by p_group";
        return "select upper(p_group) p_group,round(jan,2) jan, round(feb,2) feb, round(mar,2) mar, round(apr,2) apr, round(may,2) may, round(jun,2) jun,round(jul,2) jul,round(aug,2) aug,
                round(sep,2) sep,round(oct,2) oct,round(nov,2) nov,round(dec,2) dec,round(tot,2) tot
                from mis.year_wise_summary_data where sales_year='$year' order by syear2 desc";

    }
    //Team wise total institute & export sales-------------current yr...current-1...currentyr-2
    public static function  query26_summary_data4($year){
        $user = Auth::user()->user_id;

        $data = DB::select("select count(*) cnt from mis.dashboard_users_info 
                            where  sales_report='ALL'
                            AND
                            user_id =?
                          ", [$user]);
        if($data[0]->cnt){
            return "select upper(p_group) p_group, round(syear,2) syear, 
                round(syear1,2) syear1, round(syear2,2) syear2
                from MIS.YEAR_WISE_SUMMARY_DATA_IEUS where sales_year='$year' 
                order by p_group";
        }
        else{
            return "select upper(p_group) p_group, round(syear,2) syear, 
                round(syear1,2) syear1, round(syear2,2) syear2
                from MIS.YEARW_SUMM_DATA_IEUS_WB03_B04 where sales_year='$year' 
                order by p_group";
        }

//                order by p_group';
//
//        return "select upper(p_group) p_group, round(syear,2) syear, round(syear1,2) syear1, round(syear2,2) syear2
//                from mis.year_wise_summary_data where sales_year='$year' order by p_group";
    }
    //Team wise total institute & export sales----------2nd table........growth
    public static function  query27_summary_data5($year){
        $user = Auth::user()->user_id;

        $data = DB::select("select count(*) cnt from mis.dashboard_users_info 
                            where  sales_report='ALL'
                            AND
                            user_id =?
                          ", [$user]);
       if($data[0]->cnt){
           // return "select upper(p_group) p_group,round(syear1g,2) syear1g, round(syear2g,2) syear2g
           //      from mis.YEAR_WISE_SUMMARY_DATA_IEUS where sales_year='$year' 
           //      order by p_group";

                return "select upper(p_group) p_group,
                case syear1g 
                when -100 then round(0,2) else round(syear1g,2) end syear1g,round(syear2g,2) syear2g
                from mis.YEAR_WISE_SUMMARY_DATA_IEUS where sales_year='$year' 
                order by p_group";
       }
       else{
           // return "select upper(p_group) p_group,round(syear1g,2) syear1g, round(syear2g,2) syear2g
           //      from mis.YEARW_SUMM_DATA_IEUS_WB03_B04 where sales_year='$year' 
           //      order by p_group";
                return "select upper(p_group) p_group,
                case syear1g 
                when -100 then round(0,2) else round(syear1g,2) end syear1g,round(syear2g,2) syear2g
                from mis.YEARW_SUMM_DATA_IEUS_WB03_B04 where sales_year='$year' 
                order by p_group";

       }

    }

    //Team wise total institute & export sales---------2019 or current year table----------------

    public static function query28_summary_data6($year){
        $user = Auth::user()->user_id;

        $data = DB::select("select count(*) cnt from mis.dashboard_users_info 
                            where  sales_report='ALL'
                            AND
                            user_id =?
                          ", [$user]);
        if($data[0]->cnt){
            return "select upper(p_group) p_group,round(jan,2) jan, round(feb,2) feb, round(mar,2) mar, round(apr,2) apr, round(may,2) may, round(jun,2) jun,round(jul,2) jul,round(aug,2) aug,
                round(sep,2) sep,round(oct,2) oct,round(nov,2) nov,round(dec,2) dec,round(tot,2) tot
                from mis.YEAR_WISE_SUMMARY_DATA_IEUS where sales_year='$year' 
                order by p_group";
        }
        else{
            return "select upper(p_group) p_group,round(jan,2) jan, round(feb,2) feb, round(mar,2) mar, round(apr,2) apr, round(may,2) may, round(jun,2) jun,round(jul,2) jul,round(aug,2) aug,
                round(sep,2) sep,round(oct,2) oct,round(nov,2) nov,round(dec,2) dec,round(tot,2) tot
                from mis.YEARW_SUMM_DATA_IEUS_WB03_B04 where sales_year='$year' 
                order by p_group";
        }

    }

    public static function query29_summary_total($year){
        $user = Auth::user()->user_id;

        $data = DB::select("select count(*) cnt from mis.dashboard_users_info 
                            where  sales_report='ALL'
                            AND
                            user_id =?
                          ", [$user]);
        if($data[0]->cnt){
            return "select round(sum(one),2) syear,round(sum(two),2) SYEAR2g,round(sum(three),2) SYEAR1g,round(sum(four),2) SYEAR2,
               round(sum(five),2) SYEAR1,round(sum(six),2) JAN,round(sum(seven),2) feb,round(sum(eight),2) mar,
               round(sum(nine),2) apr,round(sum(ten),2) may,round(sum(eleven),2) jun,round(sum(twelve),2) jul,
               round(sum(thirteen),2) aug,round(sum(fourteen),2) sep,round(sum(fifteen),2) oct,round(sum(sixteen),2) nov,
               round(sum(seventeen),2) dec,round(sum(eighteen),2) tot
        from(
        select sum(SYEAR) one,sum(SYEAR2g) two,sum(SYEAR1g) three,sum(SYEAR2) four,sum(SYEAR1) five,sum(JAN) six,sum(FEB) seven,
               sum(MAR) eight,sum(apr) nine,sum(may) ten,sum(jun) eleven,sum(jul) twelve,sum(aug) thirteen,sum(sep) fourteen,sum(oct) fifteen,sum(nov) sixteen,
               sum(dec) seventeen,sum(tot) eighteen
        from MIS.YEAR_WISE_SUMMARY_DATA where sales_year='$year'
        union all
        select sum(SYEAR) one,sum(SYEAR2g) two,sum(SYEAR1g) three,sum(SYEAR2) four,sum(SYEAR1) five,sum(JAN) six,sum(FEB) seven,
               sum(MAR) eight,sum(apr) nine,sum(may) ten,sum(jun) eleven,sum(jul) twelve,sum(aug) thirteen,sum(sep) fourteen,sum(oct) fifteen,sum(nov) sixteen,
               sum(dec) seventeen,sum(tot) eighteen
        from MIS.YEAR_WISE_SUMMARY_DATA_IEUS where sales_year='$year')";
        }
        else{
            return "select round(sum(one),2) syear,round(sum(two),2) SYEAR2g,round(sum(three),2) SYEAR1g,round(sum(four),2) SYEAR2,
               round(sum(five),2) SYEAR1,round(sum(six),2) JAN,round(sum(seven),2) feb,round(sum(eight),2) mar,
               round(sum(nine),2) apr,round(sum(ten),2) may,round(sum(eleven),2) jun,round(sum(twelve),2) jul,
               round(sum(thirteen),2) aug,round(sum(fourteen),2) sep,round(sum(fifteen),2) oct,round(sum(sixteen),2) nov,
               round(sum(seventeen),2) dec,round(sum(eighteen),2) tot
        from(
        select sum(SYEAR) one,sum(SYEAR2g) two,sum(SYEAR1g) three,sum(SYEAR2) four,sum(SYEAR1) five,sum(JAN) six,sum(FEB) seven,
               sum(MAR) eight,sum(apr) nine,sum(may) ten,sum(jun) eleven,sum(jul) twelve,sum(aug) thirteen,sum(sep) fourteen,sum(oct) fifteen,sum(nov) sixteen,
               sum(dec) seventeen,sum(tot) eighteen
        from MIS.YEAR_WISE_SUMMARY_DATA where sales_year='$year'
        union all
        select sum(SYEAR) one,sum(SYEAR2g) two,sum(SYEAR1g) three,sum(SYEAR2) four,sum(SYEAR1) five,sum(JAN) six,sum(FEB) seven,
               sum(MAR) eight,sum(apr) nine,sum(may) ten,sum(jun) eleven,sum(jul) twelve,sum(aug) thirteen,sum(sep) fourteen,sum(oct) fifteen,sum(nov) sixteen,
               sum(dec) seventeen,sum(tot) eighteen
        from MIS.YEARW_SUMM_DATA_IEUS_WB03_B04 where sales_year='$year')";
        }

    }


    public static function query29_summary_total01($year){


        $yearold=$year-1;
        $user = Auth::user()->user_id;

        $data = DB::select("select count(*) cnt from mis.dashboard_users_info 
                            where  sales_report='ALL'
                            AND
                            user_id =?
                          ", [$user]);
        if($data[0]->cnt){
            return "select round(sum(one),2) syear,round(sum(two),2) SYEAR2g,round(sum(three),2) SYEAR1g,round(sum(four),2) SYEAR2,
               round(sum(five),2) SYEAR1,round(sum(six),2) JAN,round(sum(seven),2) feb,round(sum(eight),2) mar,
               round(sum(nine),2) apr,round(sum(ten),2) may,round(sum(eleven),2) jun,round(sum(twelve),2) jul,
               round(sum(thirteen),2) aug,round(sum(fourteen),2) sep,round(sum(fifteen),2) oct,round(sum(sixteen),2) nov,
               round(sum(seventeen),2) dec,round(sum(eighteen),2) tot
        from(
        select sum(SYEAR) one,sum(SYEAR2g) two,sum(SYEAR1g) three,sum(SYEAR2) four,sum(SYEAR1) five,sum(JAN) six,sum(FEB) seven,
               sum(MAR) eight,sum(apr) nine,sum(may) ten,sum(jun) eleven,sum(jul) twelve,sum(aug) thirteen,sum(sep) fourteen,sum(oct) fifteen,sum(nov) sixteen,
               sum(dec) seventeen,sum(tot) eighteen
        from MIS.YEAR_WISE_SUMMARY_DATA where sales_year='$yearold'
        union all
        select sum(SYEAR) one,sum(SYEAR2g) two,sum(SYEAR1g) three,sum(SYEAR2) four,sum(SYEAR1) five,sum(JAN) six,sum(FEB) seven,
               sum(MAR) eight,sum(apr) nine,sum(may) ten,sum(jun) eleven,sum(jul) twelve,sum(aug) thirteen,sum(sep) fourteen,sum(oct) fifteen,sum(nov) sixteen,
               sum(dec) seventeen,sum(tot) eighteen
        from MIS.YEAR_WISE_SUMMARY_DATA_IEUS where sales_year='$yearold')";
        }
        else{
            return "select round(sum(one),2) syear,round(sum(two),2) SYEAR2g,round(sum(three),2) SYEAR1g,round(sum(four),2) SYEAR2,
               round(sum(five),2) SYEAR1,round(sum(six),2) JAN,round(sum(seven),2) feb,round(sum(eight),2) mar,
               round(sum(nine),2) apr,round(sum(ten),2) may,round(sum(eleven),2) jun,round(sum(twelve),2) jul,
               round(sum(thirteen),2) aug,round(sum(fourteen),2) sep,round(sum(fifteen),2) oct,round(sum(sixteen),2) nov,
               round(sum(seventeen),2) dec,round(sum(eighteen),2) tot
        from(
        select sum(SYEAR) one,sum(SYEAR2g) two,sum(SYEAR1g) three,sum(SYEAR2) four,sum(SYEAR1) five,sum(JAN) six,sum(FEB) seven,
               sum(MAR) eight,sum(apr) nine,sum(may) ten,sum(jun) eleven,sum(jul) twelve,sum(aug) thirteen,sum(sep) fourteen,sum(oct) fifteen,sum(nov) sixteen,
               sum(dec) seventeen,sum(tot) eighteen
        from MIS.YEAR_WISE_SUMMARY_DATA where sales_year='$yearold'
        union all
        select sum(SYEAR) one,sum(SYEAR2g) two,sum(SYEAR1g) three,sum(SYEAR2) four,sum(SYEAR1) five,sum(JAN) six,sum(FEB) seven,
               sum(MAR) eight,sum(apr) nine,sum(may) ten,sum(jun) eleven,sum(jul) twelve,sum(aug) thirteen,sum(sep) fourteen,sum(oct) fifteen,sum(nov) sixteen,
               sum(dec) seventeen,sum(tot) eighteen
        from MIS.YEARW_SUMM_DATA_IEUS_WB03_B04 where sales_year='$yearold')";
        }


    }


    /////////////////
    public static function query42_team_growth_percent_2_dataMONEXCLCUMU(){
        // $currentYear = date('Y');
        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;

        return "select round(SYEAR,2) SYEAR,round(SYEAR1,2) SYEAR1,round(SYEAR2,2) SYEAR2,round(SYEAR1G,2) SYEAR1G,round(SYEAR2G,2) SYEAR2G from mis.team_wise_sales_growth where sales_group='MONTH_EXCL_DA_GROWTH' and sales_year='$currentYear' ";

    }

    public static function query43_team_growth_percent_2_dataMONINCLCUMU(){
       // $currentYear = date('Y');
        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;

        return "select round(SYEAR,2) SYEAR,round(SYEAR1,2) SYEAR1,round(SYEAR2,2) SYEAR2,round(SYEAR1G,2) SYEAR1G,round(SYEAR2G,2) SYEAR2G from mis.team_wise_sales_growth where sales_group='MONTH_INCL_DA_GROWTH'and sales_year='$currentYear' ";


    }


    ////////////////////////////////////////////////////////new query by fatema////////////////////////////
    //Team wise total depot sales------currentyear-1 --------jan to dec---6.4.2019
    public static function query30_summary_data($year){


        $yearold=$year-1;
//        return "select upper(p_group) p_group,round(jan,2) jan, round(feb,2) feb, round(mar,2) mar, round(apr,2) apr, round(may,2) may, round(jun,2) jun,round(jul,2) jul,round(aug,2) aug,
//                round(sep,2) sep,round(oct,2) oct,round(nov,2) nov,round(dec,2) dec,round(tot,2) tot
//                from mis.year_wise_summary_data where sales_year='$yearold' order by p_group";

        return "select upper(p_group) p_group,round(jan,2) jan, round(feb,2) feb, round(mar,2) mar, round(apr,2) apr, round(may,2) may, round(jun,2) jun,round(jul,2) jul,round(aug,2) aug,
                round(sep,2) sep,round(oct,2) oct,round(nov,2) nov,round(dec,2) dec,round(tot,2) tot
                from mis.year_wise_summary_data where sales_year='$yearold' and upper(p_group) !='SKIN PRODUCTS' order by syear2 desc";



    }
    //Team wise total depot sales------growth%--------jan to dec---6.4.2019
    public static function query31_summary_data(){

//        return "select upper(p_group) p_group,round(jan,2) jan, round(feb,2) feb, round(mar,2) mar, round(apr,2) apr, round(may,2) may, round(jun,2) jun,round(jul,2) jul,round(aug,2) aug,
//                round(sep,2) sep,round(oct,2) oct,round(nov,2) nov,round(dec,2) dec,round(tot,2) tot
//                from mis.year_wise_summary_data where sales_year='Growth' order by p_group";

        return "select upper(p_group) p_group,round(jan,2) jan, round(feb,2) feb, round(mar,2) mar, round(apr,2) apr, round(may,2) may, round(jun,2) jun,round(jul,2) jul,round(aug,2) aug,
                round(sep,2) sep,round(oct,2) oct,round(nov,2) nov,round(dec,2) dec,round(tot,2) tot
                from mis.year_wise_summary_data where sales_year='Growth' order by syear2 desc";

    }


    public static function query32_summary_data($year){

        $yearold=$year-1;
        $user = Auth::user()->user_id;

        $data = DB::select("select count(*) cnt from mis.dashboard_users_info 
                            where  sales_report='ALL'
                            AND
                            user_id =?
                          ", [$user]);
        if($data[0]->cnt){
            return "select upper(p_group) p_group,round(jan,2) jan, round(feb,2) feb, round(mar,2) mar, round(apr,2) apr, round(may,2) may, round(jun,2) jun,round(jul,2) jul,round(aug,2) aug,
                round(sep,2) sep,round(oct,2) oct,round(nov,2) nov,round(dec,2) dec,round(tot,2) tot
                from mis.YEAR_WISE_SUMMARY_DATA_IEUS where sales_year='$yearold' order by p_group";
        }
        else{
            return "select upper(p_group) p_group,round(jan,2) jan, round(feb,2) feb, round(mar,2) mar, round(apr,2) apr, round(may,2) may, round(jun,2) jun,round(jul,2) jul,round(aug,2) aug,
                round(sep,2) sep,round(oct,2) oct,round(nov,2) nov,round(dec,2) dec,round(tot,2) tot
                from mis.YEARW_SUMM_DATA_IEUS_WB03_B04 where sales_year='$yearold' order by p_group";
        }


    }
    //coln chnge

    public static function query33_summary_data(){
        $user = Auth::user()->user_id;

        $data = DB::select("select count(*) cnt from mis.dashboard_users_info 
                            where  sales_report='ALL'
                            AND
                            user_id =?
                          ", [$user]);
        if($data[0]->cnt){
            return "select upper(p_group) p_group,round(jan,2) jan, round(feb,2) feb, round(mar,2) mar, round(apr,2) apr, round(may,2) may, round(jun,2) jun,round(jul,2) jul,round(aug,2) aug,
                round(sep,2) sep,round(oct,2) oct,round(nov,2) nov,round(dec,2) dec,round(tot,2) tot
                from mis.YEAR_WISE_SUMMARY_DATA_IEUS where sales_year='Growth' order by p_group";
        }
        else{
            return "select upper(p_group) p_group,round(jan,2) jan, round(feb,2) feb, round(mar,2) mar, round(apr,2) apr, round(may,2) may, round(jun,2) jun,round(jul,2) jul,round(aug,2) aug,
                round(sep,2) sep,round(oct,2) oct,round(nov,2) nov,round(dec,2) dec,round(tot,2) tot
                from mis.YEARW_SUMM_DATA_IEUS_WB03_B04 where sales_year='Growth' order by p_group";
        }



    }
    ///////////////////////////////////HYGIENE/////////////////////////

    public static function query43_team_growth_percent_dataHygiene(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH,ROUND(SYEAR,2) SYEAR, 
                 ROUND(SYEAR1,2) SYEAR1, ROUND(SYEAR2,2) SYEAR2 
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'INTER_COMPANY_HYGIENE' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }

    public static function query44_team_growth_percent_2_dataHygiene(){

        // $currentYear = date('Y');
        //09.10.2018...max year
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH, SYEAR1G, 
                case SYEAR2G 
                when -100 then round(0,2) else round(SYEAR2G,2) end SYEAR2G
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'INTER_COMPANY_HYGIENE' and sales_year='$currentYear'
                and SYEAR1_SPG is not null
                and SYEAR2_SPG is not null
                and TOT_SY1SY2 is not null
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }


    //////////////////HERBAL NUTRICARE///////////////////////
    public static function query45_team_growth_percent_data_herbalNutricare(){
        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH,ROUND(SYEAR,2) SYEAR, 
                 ROUND(SYEAR1,2) SYEAR1, ROUND(SYEAR2,2) SYEAR2 
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'INTER_COMPANY_HERBAL_NUTRICARE' and sales_year='$currentYear'
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }

    public static function query46_team_growth_percent_2_data_herbalNutricare(){

        $maxyear=DB::select("SELECT max(Y.SALES_YEAR) SALES_YEAR
        FROM MIS.TEAM_WISE_SALES_GROWTH  Y");


        $currentYear=(int)$maxyear[0]->sales_year;
        return "SELECT
                SALES_GROUP,TO_CHAR( SALES_MONTH,'Mon') SALES_MONTH, SYEAR1G, 
                case SYEAR2G 
                when -100 then round(0,2) else round(SYEAR2G,2) end SYEAR2G
                FROM MIS.TEAM_WISE_SALES_GROWTH
                WHERE trim(SALES_GROUP) in 'INTER_COMPANY_HERBAL_NUTRICARE' and sales_year='$currentYear'
                and SYEAR1_SPG is not null
                and SYEAR2_SPG is not null
                and TOT_SY1SY2 is not null
                ORDER BY to_date(SALES_MONTH,'Mon')";
    }

}