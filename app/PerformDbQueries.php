<?php


namespace App;

use DB;
use Auth;


class PerformDbQueries
{
   ////////////////////////////AST_GYR/////////////////////////

   public static function query1_year5_teamperform_data(){
//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'AST-GYR'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')
//            ORDER BY to_date(MONTH,'MON')";
//       return "SELECT
//            TEAM,TO_CHAR( SALES_MONTH,'Mon') as MONTH,TO_CHAR( SALES_MONTH,'YYYY') as Year,YR_TGTVAL,
//               YR_SOLDVAL, YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'AST_GYR'
//            and to_char(trunc(SALES_MONTH,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')
//            ORDER BY to_date(SALES_MONTH,'MON')";
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);

       // sales_year='".$max_year."' 

       $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;


       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'AST-GYR'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'AST-GYR'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }



   }

   public static function query2_year4_teamperform_data(){
//       return "SELECT
//            TEAM,TO_CHAR( MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,YR_TGTVAL,
//               YR_SOLDVAL, YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'AST-GYR'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-1
//            ORDER BY to_date(MONTH,'MON')";
//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'AST-GYR'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-1
//            ORDER BY to_date(MONTH,'MON')";
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);

       // sales_year='".$max_year."' 

       $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'AST-GYR'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus1."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'AST-GYR'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus1."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }

   }

   public static function query3_year3_teamperform_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);

       // sales_year='".$max_year."' 

       $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'AST-GYR'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus2."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'AST-GYR'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus2."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }


//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'AST-GYR'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-2
//            ORDER BY to_date(MONTH,'MON')";
//       return "SELECT
//            TEAM,TO_CHAR( MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,YR_TGTVAL,
//               YR_SOLDVAL, YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'AST-GYR'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-2
//            ORDER BY to_date(MONTH,'MON')";
   }

//
//   public static function query4_year2_teamperform_data(){
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'AST-GYR'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'AST-GYR'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
////            ORDER BY to_date(MONTH,'MON')";
////       return "SELECT
////            TEAM,TO_CHAR( MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,YR_TGTVAL,
////               YR_SOLDVAL, YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'AST-GYR'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
////            ORDER BY to_date(MONTH,'MON')";
//   }
//
//   public static function query5_year1_teamperform_data(){
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'AST-GYR'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'AST-GYR'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
////            ORDER BY to_date(MONTH,'MON')";
////       return "SELECT
////            TEAM,TO_CHAR( MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,YR_TGTVAL,
////               YR_SOLDVAL, YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'AST-GYR'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
////            ORDER BY to_date(MONTH,'MON')";
//   }

   
    ////////////////////////////opr_xen/////////////////////////
   public static function query6_year5_oprxen_teamperform_data(){
//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'OPR-XEN'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')
//            ORDER BY to_date(MONTH,'MON')";
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);

       // sales_year='".$max_year."' 

       $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'OPR-XEN'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'OPR-XEN'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }

//       return "SELECT
//            TEAM,TO_CHAR( MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,YR_TGTVAL,
//               YR_SOLDVAL, YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'OPR_XEN'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')
//            ORDER BY to_date(MONTH,'MON')";
   }

   public static function query7_year4_oprxen_teamperform_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);

           // sales_year='".$max_year."' 

       $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'OPR-XEN'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus1."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'OPR-XEN'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus1."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }

//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'OPR-XEN'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-1
//            ORDER BY to_date(MONTH,'MON')";
//       return "SELECT
//            TEAM,TO_CHAR( MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,YR_TGTVAL,
//               YR_SOLDVAL, YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'OPR_XEN'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-1
//            ORDER BY to_date(MONTH,'MON')";
   }

   public static function query8_year3_oprxen_teamperform_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);
       // sales_year='".$max_year."' 

       $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;


       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'OPR-XEN'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus2."'
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'OPR-XEN'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus2."'
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }


//       return "SELECT
//            TEAM,TO_CHAR( MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,YR_TGTVAL,
//               YR_SOLDVAL, YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'OPR_XEN'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-2
//            ORDER BY to_date(MONTH,'MON')";
//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'OPR-XEN'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-2
//            ORDER BY to_date(MONTH,'MON')";
   }

//   public static function query9_year2_oprxen_teamperform_data(){
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'OPR-XEN'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'OPR-XEN'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
////            ORDER BY to_date(MONTH,'MON')";
////       return "SELECT
////            TEAM,TO_CHAR( MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,YR_TGTVAL,
////               YR_SOLDVAL, YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'OPR_XEN'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
////            ORDER BY to_date(MONTH,'MON')";
//   }
//
//   public static function query10_year1_oprxen_teamperform_data(){
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'OPR-XEN'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'OPR-XEN'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
////            ORDER BY to_date(MONTH,'MON')";
////       return "SELECT
////            TEAM,TO_CHAR( MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,YR_TGTVAL,
////               YR_SOLDVAL, YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'OPR_XEN'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
////            ORDER BY to_date(MONTH,'MON')";
//   }


    ////////////////////////////total special/////////////////////////
   public static function query11_year5_special_teamperform_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);

       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;
       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'TOT-SPECIAL'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year."'
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'TOT-SPECIAL'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year."'
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }


//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'TOT-SPECIAL'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')
//            ORDER BY to_date(MONTH,'MON')";
   }

   public static function query12_year4_special_teamperform_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);

       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'TOT-SPECIAL'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus1."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'TOT-SPECIAL'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus1."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }


//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'TOT-SPECIAL'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-1
//            ORDER BY to_date(MONTH,'MON')";
   }

   public static function query13_year3_special_teamperform_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);

       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'TOT-SPECIAL'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus2."'
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";

       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'TOT-SPECIAL'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus2."'
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";

       }

//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'TOT-SPECIAL'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-2
//            ORDER BY to_date(MONTH,'MON')";
   }

//   public static function query14_year2_special_teamperform_data(){
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'TOT-SPECIAL'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'TOT-SPECIAL'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
////            ORDER BY to_date(MONTH,'MON')";
//   }
//
//   public static function query15_year1_special_teamperform_data(){
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'TOT-SPECIAL'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'TOT-SPECIAL'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
////            ORDER BY to_date(MONTH,'MON')";
//   }

     ////////////////////////////cell biotic/////////////////////////
   public static function query16_year5_cellbiotic_teamperform_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);

       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'CELLBIOTIC'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'CELLBIOTIC'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }

//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'CELLBIOTIC'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')
//            ORDER BY to_date(MONTH,'MON')";
   }


   public static function query17_year4_cellbiotic_teamperform_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);

       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'CELLBIOTIC'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus1."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'CELLBIOTIC'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus1."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }

//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'CELLBIOTIC'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-1
//            ORDER BY to_date(MONTH,'MON')";
   }

   public static function query18_year3_cellbiotic_teamperform_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);

       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'CELLBIOTIC'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus2."'
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'CELLBIOTIC'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus2."'
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }


//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'CELLBIOTIC'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-2
//            ORDER BY to_date(MONTH,'MON')";
   }

//   public static function query19_year2_cellbiotic_teamperform_data(){
//
//
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'CELLBIOTIC'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'CELLBIOTIC'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
////            ORDER BY to_date(MONTH,'MON')";
//   }
//
//   public static function query20_year1_cellbiotic_teamperform_data(){
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'CELLBIOTIC'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'CELLBIOTIC'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
////            ORDER BY to_date(MONTH,'MON')";
//   }
     ////////////////////////////KINETIX/////////////////////////
   
   
   public static function query21_year5_kinetix_teamperform_data(){

       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);

       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'KINETIX'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'KINETIX'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }

//
//       return "SELECT
//           TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'KINETIX'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')
//            ORDER BY to_date(MONTH,'MON')";
   }


   public static function query22_year4_kinetix_teamperform_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);

       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'KINETIX'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus1."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'KINETIX'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus1."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }


//       return "SELECT
//           TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'KINETIX'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-1
//            ORDER BY to_date(MONTH,'MON')";
   }

   public static function query23_year3_kinetix_teamperform_data(){

       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);

       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'KINETIX'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus2."'
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'KINETIX'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus2."'
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }


//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'KINETIX'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-2
//            ORDER BY to_date(MONTH,'MON')";
   }

//   public static function query24_year2_kinetix_teamperform_data(){
//
//
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'KINETIX'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'KINETIX'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
////            ORDER BY to_date(MONTH,'MON')";
//   }
//
//   public static function query25_year1_kinetix_teamperform_data(){
//
//
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'KINETIX'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'KINETIX'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
////            ORDER BY to_date(MONTH,'MON')";
//   }

       ////////////////////////////zymos/////////////////////////
   
   
   public static function query26_year5_zymos_teamperform_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);
       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'ZYMOS'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'ZYMOS'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }



//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'ZYMOS'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')
//            ORDER BY to_date(MONTH,'MON')";
   }


   public static function query27_year4_zymos_teamperform_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);
       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'ZYMOS'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus1."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'ZYMOS'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus1."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }



//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'ZYMOS'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-1
//            ORDER BY to_date(MONTH,'MON')";
   }

   public static function query28_year3_zymos_teamperform_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);
       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'ZYMOS'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus2."'
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";

       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'ZYMOS'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus2."'
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";

       }


//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'ZYMOS'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-2
//            ORDER BY to_date(MONTH,'MON')";
   }

//   public static function query29_year2_zymos_teamperform_data(){
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'ZYMOS'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'ZYMOS'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
////            ORDER BY to_date(MONTH,'MON')";
//   }
//
//   public static function query30_year1_zymos_teamperform_data(){
//
//
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'ZYMOS'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'ZYMOS'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
////            ORDER BY to_date(MONTH,'MON')";
//   }

       ////////////////////////////total general/////////////////////////
   
   
   public static function query31_year5_totgeneral_teamperform_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);
       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;
       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'TOT-GENERAL'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'TOT-GENERAL'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }




//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'TOT-GENERAL'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')
//            ORDER BY to_date(MONTH,'MON')";
   }


   public static function query32_year4_totgeneral_teamperform_data(){

       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);
       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'TOT-GENERAL'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus1."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'TOT-GENERAL'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus1."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }


//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'TOT-GENERAL'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-1
//            ORDER BY to_date(MONTH,'MON')";
   }

   public static function query33_year3_totgeneral_teamperform_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);
       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){

           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'TOT-GENERAL'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus2."'
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{

           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'TOT-GENERAL'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus2."'
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }

//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'TOT-GENERAL'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-2
//            ORDER BY to_date(MONTH,'MON')";
   }

//   public static function query34_year2_totgeneral_teamperform_data(){
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'TOT-GENERAL'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'TOT-GENERAL'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
////            ORDER BY to_date(MONTH,'MON')";
//   }
//
//   public static function query35_year1_totgeneral_teamperform_data(){
//
//
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'TOT-GENERAL'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'TOT-GENERAL'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
////            ORDER BY to_date(MONTH,'MON')";
//   }

    ////////////////////////////ihhl mpo/////////////////////////
   
   
//   public static function query36_year5_ihhl_mpo_teamperform_data(){
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'IHHL-MPO'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')
////            ORDER BY to_date(MONTH,'MON')";
//
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'IHHL-MPO'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
//   }
//
//
//   public static function query37_year4_ihhl_mpo_teamperform_data(){
//
//
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'IHHL-MPO'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-1
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'IHHL-MPO'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-1
////            ORDER BY to_date(MONTH,'MON')";
//   }
//
//   public static function query38_year3_ihhl_mpo_teamperform_data(){
//
//
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'IHHL-MPO'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-2
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'IHHL-MPO'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-2
////            ORDER BY to_date(MONTH,'MON')";
//   }

//   public static function query39_year2_ihhl_mpo_teamperform_data(){
//
//
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'IHHL-MPO'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'IHHL-MPO'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
////            ORDER BY to_date(MONTH,'MON')";
//   }
//
//   public static function query40_year1_ihhl_mpo_teamperform_data(){
//
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'IHHL-MPO'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'IHHL-MPO'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
////            ORDER BY to_date(MONTH,'MON')";
//   }

    ////////////////////////////ihhl tso/////////////////////////
   
   
//   public static function query41_year5_ihhl_tso_teamperform_data(){
//
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'IHHL-TSO'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
////       return "SELECT
////          TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'IHHL-TSO'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')
////            ORDER BY to_date(MONTH,'MON')";
//   }
//
//
//   public static function query42_year4_ihhl_tso_teamperform_data(){
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'IHHL-TSO'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-1
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'IHHL-TSO'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-1
////            ORDER BY to_date(MONTH,'MON')";
//   }
//
//   public static function query43_year3_ihhl_tso_teamperform_data(){
//
//
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'IHHL-TSO'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-2
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'IHHL-TSO'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-2
////            ORDER BY to_date(MONTH,'MON')";
//   }

//   public static function query44_year2_ihhl_tso_teamperform_data(){
//
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'IHHL-TSO'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
//
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'IHHL-TSO'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
////            ORDER BY to_date(MONTH,'MON')";
//   }
//
//   public static function query45_year1_ihhl_tso_teamperform_data(){
//
//
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'IHHL-TSO'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'IHHL-TSO'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
////            ORDER BY to_date(MONTH,'MON')";
//   }

   ////////////////////////////total ihhl/////////////////////////
//                          HYGIENE_DIAPER
   
   public static function query46_year5_tot_ihhl_teamperform_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);
       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'HYGIENE_DIAPER'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'HYGIENE_DIAPER'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }


//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'TOT-IHHL'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')
//            ORDER BY to_date(MONTH,'MON')";
   }


   public static function query47_year4_tot_ihhl_teamperform_data(){

       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);
       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'HYGIENE_DIAPER'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus1."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";

       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'HYGIENE_DIAPER'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus1."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";

       }

//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'TOT-IHHL'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-1
//            ORDER BY to_date(MONTH,'MON')";
   }

   public static function query48_year3_tot_ihhl_teamperform_data(){

       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);
       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'HYGIENE_DIAPER'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus2."'
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'HYGIENE_DIAPER'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus2."'
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }


//       return "SELECT
//           TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'TOT-IHHL'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-2
//            ORDER BY to_date(MONTH,'MON')";
   }

//   public static function query49_year2_tot_ihhl_teamperform_data(){
//
//
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'TOT-IHHL'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'TOT-IHHL'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
////            ORDER BY to_date(MONTH,'MON')";
//   }
//
//   public static function query50_year1_tot_ihhl_teamperform_data(){
//
//
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'TOT-IHHL'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'TOT-IHHL'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
////            ORDER BY to_date(MONTH,'MON')";
//   }

   ////////////////////////////ihnl/////////////////////////
   
   
   public static function query51_year5_ihnl_teamperform_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);
       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'IHNL'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'IHNL'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }



//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'IHNL'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')
//            ORDER BY to_date(MONTH,'MON')";
   }


   public static function query52_year4_ihnl_teamperform_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);
       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'IHNL'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus1."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'IHNL'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus1."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }



//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'IHNL'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-1
//            ORDER BY to_date(MONTH,'MON')";
   }

   public static function query53_year3_ihnl_teamperform_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);
       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'IHNL'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus2."'
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'IHNL'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus2."'
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }


//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'IHNL'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-2
//            ORDER BY to_date(MONTH,'MON')";
   }

//   public static function query54_year2_ihnl_teamperform_data(){
//
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'IHNL'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'IHNL'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
////            ORDER BY to_date(MONTH,'MON')";
//   }
//
//   public static function query55_year1_ihnl_teamperform_data(){
//
//
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'IHNL'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
//
////       return "SELECT
////           TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'IHNL'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
////            ORDER BY to_date(MONTH,'MON')";
//   }

   ////////////////////////////ahvd/////////////////////////
   
   
   public static function query56_year5_ahvd_teamperform_data(){

       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);
       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'AHVD'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";

       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'AHVD'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";

       }

//       return "SELECT
//           TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'IANH'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')
//            ORDER BY to_date(MONTH,'MON')";
   }


   public static function query57_year4_ahvd_teamperform_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);
       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'AHVD'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus1."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";

       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'AHVD'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus1."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";

       }


//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'IANH'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-1
//            ORDER BY to_date(MONTH,'MON')";
   }

   public static function query58_year3_ahvd_teamperform_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);
       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'AHVD'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus2."'
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'AHVD'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus2."'
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }



//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'IANH'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-2
//            ORDER BY to_date(MONTH,'MON')";
   }

//   public static function query59_year2_ianh_teamperform_data(){
//
//
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'IANH'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'IANH'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
////            ORDER BY to_date(MONTH,'MON')";
//   }
//
//   public static function query60_year1_ianh_teamperform_data(){
//
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'IANH'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'IANH'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
////            ORDER BY to_date(MONTH,'MON')";
//   }

   ////////////////////////////institute/////////////////////////
   
   
   public static function query61_year5_inst_teamperform_data(){

       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);
       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'INSTITUTION'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'INSTITUTION'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }

       
//       return "SELECT 
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE 
//            WHERE trim(TEAM) in 'INSTITUTION'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')
//            ORDER BY to_date(MONTH,'MON')";
   }

   public static function query62_year4_inst_teamperform_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);

       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;
            
       if($data[0]->cnt){
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'INSTITUTION'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus1."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'INSTITUTION'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus1."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }



//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'INSTITUTION'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-1
//            ORDER BY to_date(MONTH,'MON')";
   }

   public static function query63_year3_inst_teamperform_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);
       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){

           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'INSTITUTION'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus2."'
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }
       else{
           return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'INSTITUTION'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus2."'
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
       }


//       return "SELECT
//            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
//            WHERE trim(TEAM) in 'INSTITUTION'
//            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-2
//            ORDER BY to_date(MONTH,'MON')";
   }

//   public static function query64_year2_inst_teamperform_data(){
//
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'INSTITUTION'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'INSTITUTION'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-3
////            ORDER BY to_date(MONTH,'MON')";
//   }
//
//   public static function query65_year1_inst_teamperform_data(){
//
//       return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
//               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
//            from
//            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
//              from dual
//            connect by level <= 12
//            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
//            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
//                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
//            from mis.year_wise_team_performance
//            where trim(team) in 'INSTITUTION'
//                   and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
//            order by to_date(month,'MON')) ys
//            where ym.months = ys.month(+)
//            order by mon";
//
////       return "SELECT
////            TEAM,TO_CHAR(MONTH,'Mon') as MONTH,TO_CHAR( MONTH,'YYYY') as Year,Round(YR_TGTVAL,2) as YR_TGTVAL,
////               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
////            FROM MIS.YEAR_WISE_TEAM_PERFORMANCE
////            WHERE trim(TEAM) in 'INSTITUTION'
////            and to_char(trunc(month,'MON'),'RR') = to_char(trunc(sysdate,'MON'),'RR')-4
////            ORDER BY to_date(MONTH,'MON')";
//   }

//          Company Wise Sales Summary

   public static function query66_company_wise_sales_summery_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);
       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){

           return "select sales_month,IPL_GENERAL, IPL_INSTITUTE,IPL_ANIMAL_HEALTH,IPL_TOTAL, IVL_HUMAN,IVL_ANIMAL,IVL_INSTITUTE,IVL_TOTAL, 
                IHHL_DIAPER,IHHL_INFUSION,IHHL_TOTAL, IHNL_TOTAL,TOTAL
                from(
                SELECT to_date(SALES_MONTH,'MON-RR') months,substr(sales_month,0,3) sales_month,IPL_GENERAL, 
                IPL_INSTITUTE,IPL_ANIMAL_HEALTH,IPL_TOTAL, 
                IVL_HUMAN,IVL_ANIMAL,IVL_INSTITUTE,IVL_TOTAL, 
                IHHL_DIAPER,IHHL_INFUSION,IHHL_TOTAL, IHNL_TOTAL,TOTAL
                FROM MIS.COMPANY_WISE_SALES_SUMMARY 
                where SALES_YEAR=(Select max(D.sales_year) from MIS.COMPANY_WISE_SALES_SUMMARY D)
                order by months asc)";
       }
       else{

           return "select sales_month,IPL_GENERAL, IPL_INSTITUTE,IPL_ANIMAL_HEALTH,IPL_TOTAL, IVL_HUMAN,IVL_ANIMAL,IVL_INSTITUTE,IVL_TOTAL, 
                IHHL_DIAPER,IHHL_INFUSION,IHHL_TOTAL, IHNL_TOTAL,TOTAL
                from(
                SELECT to_date(SALES_MONTH,'MON-RR') months,substr(sales_month,0,3) sales_month,IPL_GENERAL, 
                IPL_INSTITUTE,IPL_ANIMAL_HEALTH,IPL_TOTAL, 
                IVL_HUMAN,IVL_ANIMAL,IVL_INSTITUTE,IVL_TOTAL, 
                IHHL_DIAPER,IHHL_INFUSION,IHHL_TOTAL, IHNL_TOTAL,TOTAL
                FROM MIS.COM_WISE_SALES_SUMM_WB03_B04 
                where SALES_YEAR=(Select max(D.sales_year) from MIS.COMPANY_WISE_SALES_SUMMARY D)
                order by months asc)";
       }
   }

   public static function query67_company_wise_sales_summery_data(){
       $user = Auth::user()->user_id;
       $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);
       // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

       if($data[0]->cnt){
           return "select sales_month,IPL_GENERAL, IPL_INSTITUTE,IPL_ANIMAL_HEALTH,IPL_TOTAL, IVL_HUMAN,IVL_ANIMAL,IVL_INSTITUTE,IVL_TOTAL, 
            IHHL_DIAPER,IHHL_INFUSION,IHHL_TOTAL, IHNL_TOTAL,TOTAL
            from(
            SELECT to_date(SALES_MONTH,'MON-RR') months,substr(sales_month,0,3) sales_month,IPL_GENERAL, 
            IPL_INSTITUTE,IPL_ANIMAL_HEALTH,IPL_TOTAL, 
            IVL_HUMAN,IVL_ANIMAL,IVL_INSTITUTE,IVL_TOTAL, 
            IHHL_DIAPER,IHHL_INFUSION,IHHL_TOTAL, IHNL_TOTAL,TOTAL
            FROM MIS.COMPANY_WISE_SALES_SUMMARY 
            where SALES_YEAR=(Select max(D.sales_year)-1 from MIS.COMPANY_WISE_SALES_SUMMARY D)
            order by months asc)";
       }
       else{
           return "select sales_month,IPL_GENERAL, IPL_INSTITUTE,IPL_ANIMAL_HEALTH,IPL_TOTAL, IVL_HUMAN,IVL_ANIMAL,IVL_INSTITUTE,IVL_TOTAL, 
            IHHL_DIAPER,IHHL_INFUSION,IHHL_TOTAL, IHNL_TOTAL,TOTAL
            from(
            SELECT to_date(SALES_MONTH,'MON-RR') months,substr(sales_month,0,3) sales_month,IPL_GENERAL, 
            IPL_INSTITUTE,IPL_ANIMAL_HEALTH,IPL_TOTAL, 
            IVL_HUMAN,IVL_ANIMAL,IVL_INSTITUTE,IVL_TOTAL, 
            IHHL_DIAPER,IHHL_INFUSION,IHHL_TOTAL, IHNL_TOTAL,TOTAL
            FROM MIS.COM_WISE_SALES_SUMM_WB03_B04 
            where SALES_YEAR=(Select max(D.sales_year)-1 from MIS.COMPANY_WISE_SALES_SUMMARY D)
            order by months asc)";
       }


   }
    public static function query71_company_wise_sales_summery_data(){
        $user = Auth::user()->user_id;
        $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);
        // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;


        if($data[0]->cnt){
            return "select sales_month,IPL_GENERAL, IPL_INSTITUTE,IPL_ANIMAL_HEALTH,IPL_TOTAL, IVL_HUMAN,IVL_ANIMAL,IVL_INSTITUTE,IVL_TOTAL, 
            IHHL_DIAPER,IHHL_INFUSION,IHHL_TOTAL, IHNL_TOTAL,TOTAL
            from(
            SELECT to_date(SALES_MONTH,'MON-RR') months,substr(sales_month,0,3) sales_month,IPL_GENERAL, 
            IPL_INSTITUTE,IPL_ANIMAL_HEALTH,IPL_TOTAL, 
            IVL_HUMAN,IVL_ANIMAL,IVL_INSTITUTE,IVL_TOTAL, 
            IHHL_DIAPER,IHHL_INFUSION,IHHL_TOTAL, IHNL_TOTAL,TOTAL
            FROM MIS.COMPANY_WISE_SALES_SUMMARY 
            where SALES_YEAR=(Select max(D.sales_year)-2 from MIS.COMPANY_WISE_SALES_SUMMARY D)
            order by months asc)";
        }
        else{
            return "select sales_month,IPL_GENERAL, IPL_INSTITUTE,IPL_ANIMAL_HEALTH,IPL_TOTAL, IVL_HUMAN,IVL_ANIMAL,IVL_INSTITUTE,IVL_TOTAL, 
            IHHL_DIAPER,IHHL_INFUSION,IHHL_TOTAL, IHNL_TOTAL,TOTAL
            from(
            SELECT to_date(SALES_MONTH,'MON-RR') months,substr(sales_month,0,3) sales_month,IPL_GENERAL, 
            IPL_INSTITUTE,IPL_ANIMAL_HEALTH,IPL_TOTAL, 
            IVL_HUMAN,IVL_ANIMAL,IVL_INSTITUTE,IVL_TOTAL, 
            IHHL_DIAPER,IHHL_INFUSION,IHHL_TOTAL, IHNL_TOTAL,TOTAL
            FROM MIS.COM_WISE_SALES_SUMM_WB03_B04 
            where SALES_YEAR=(Select max(D.sales_year)-2 from MIS.COMPANY_WISE_SALES_SUMMARY D)
            order by months asc)";
        }

    }


   /////////////////////////////////////////////////////////////////new///


    ////////////////////////////TOTal -DEPOt-SALes/////////////////////////


    public static function query68_year5_tot_depo_sale_teamperform_data(){
        $user = Auth::user()->user_id;
        $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);
        // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

        if($data[0]->cnt){
            return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'TOT-DEPO-SAL'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
        }
        else{
            return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'TOT-DEPO-SAL'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
        }



    }

    public static function query69_year4_tot_depo_sale_teamperform_data(){

        $user = Auth::user()->user_id;
        $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);
        // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;

        if($data[0]->cnt){
            return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'TOT-DEPO-SAL'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus1."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
        }
        else{
            return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'TOT-DEPO-SAL'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus1."' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
        }


    }

    public static function query70_year3_tot_depo_sale_teamperform_data(){
        $user = Auth::user()->user_id;
        $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ",[$user]);
        // '".$max_year."'
        $maxyear=DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

            $max_year=$maxyear[0]->max_year;
            $max_year_minus1=$maxyear[0]->max_year_minus1;
            $max_year_minus2=$maxyear[0]->max_year_minus2;
            
        if($data[0]->cnt){
            return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'TOT-DEPO-SAL'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus2."'
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
        }
        else{
            return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'TOT-DEPO-SAL'
                   and to_char(trunc(month,'MON'),'RRRR') = '".$max_year_minus2."'
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
        }


    }


    ////////////////////////////

////////////////////////////IVL-12/02/2020/////////////////////////

    public static function query_ivl_year5_teamperform_data()
    {

        $user = Auth::user()->user_id;
        $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ", [$user]);

        $maxyear = DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

        $max_year = $maxyear[0]->max_year;
        $max_year_minus1 = $maxyear[0]->max_year_minus1;
        $max_year_minus2 = $maxyear[0]->max_year_minus2;


        if ($data[0]->cnt) {
            return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'IVL'
                   and to_char(trunc(month,'MON'),'RRRR') = '" . $max_year . "' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
        } else {
            return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'IVL'
                   and to_char(trunc(month,'MON'),'RRRR') = '" . $max_year . "' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
        }

    }

    public static function query2_ivl_year4_teamperform_data()
    {
        $user = Auth::user()->user_id;
        $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ", [$user]);


        $maxyear = DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

        $max_year = $maxyear[0]->max_year;
        $max_year_minus1 = $maxyear[0]->max_year_minus1;
        $max_year_minus2 = $maxyear[0]->max_year_minus2;

        if ($data[0]->cnt) {
            return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'IVL'
                   and to_char(trunc(month,'MON'),'RRRR') = '" . $max_year_minus1 . "' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
        } else {
            return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'IVL'
                   and to_char(trunc(month,'MON'),'RRRR') = '" . $max_year_minus1 . "' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
        }

    }

    public static function query3_ivl_year3_teamperform_data()
    {
        $user = Auth::user()->user_id;
        $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                where sales_report='ALL'
                AND user_id=?
                ", [$user]);

        $maxyear = DB::select("select max(sales_year) max_year,max(sales_year-1) max_year_minus1,max(sales_year-2) max_year_minus2 from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04");

        $max_year = $maxyear[0]->max_year;
        $max_year_minus1 = $maxyear[0]->max_year_minus1;
        $max_year_minus2 = $maxyear[0]->max_year_minus2;

        if ($data[0]->cnt) {
            return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.year_wise_team_performance
            where trim(team) in 'IVL'
                   and to_char(trunc(month,'MON'),'RRRR') = '" . $max_year_minus2 . "' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
        } else {
            return "select months as month,team,year,Round(YR_TGTVAL,2) as YR_TGTVAL,
               Round(YR_SOLDVAL,2) as YR_SOLDVAL, Round(YR_ACHV,2) as YR_ACHV
            from
            (select to_char(add_months(sysdate, (level-1 )),'Mon') as months ,to_char(add_months(sysdate, (level-1 )),'MM') as mon
              from dual 
            connect by level <= 12
            order by to_char(add_months(sysdate, (level-1 )),'MM')) ym,
            (select team,to_char(month,'Mon') as month,to_char( month,'YYYY') as year,round(yr_tgtval,2) as yr_tgtval,
                   round(yr_soldval,2) as yr_soldval, round(yr_achv,2) as yr_achv
            from mis.YEAR_WISE_TEAM_PERFOR_WB03_B04
            where trim(team) in 'IVL'
                   and to_char(trunc(month,'MON'),'RRRR') = '" . $max_year_minus2 . "' 
            order by to_date(month,'MON')) ys
            where ym.months = ys.month(+)
            order by mon";
        }

    }
   
      


}