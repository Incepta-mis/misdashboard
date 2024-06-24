<?php

/*
   Developer:Md.Raqib Hasan
   Employee Code:1012064
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComparativeAnalysisReportController extends Controller
{
    public function index(){

        $year = DB::select("select max(sales_year) syear
                            from MIS.YEARLY_SALES_ANALYSIS_WEB");

        $depot_sales = DB::select("select sales_year,sales_type,sales_desc,sales_person,
                                   nvl(jan,0) jan,nvl(feb,0) feb,nvl(mar,0) mar,nvl(apr,0) apr,nvl(may,0) may,
                                   nvl(jun,0) jun,nvl(jul,0) jul,nvl(aug,0) aug,nvl(sep,0) sep,nvl(oct,0) oct,nvl(nov,0) nov
                                    ,nvl(dec,0) dec,sl
                                    from mis.yearly_sales_analysis_web
                                    where sales_type = 'DEPOT SALES'
                                    order by sl");

        $institute_sales = DB::select("select sales_year,sales_type,sales_desc,sales_person,
                                      nvl(jan,0) jan,nvl(feb,0) feb,nvl(mar,0) mar,nvl(apr,0) apr,nvl(may,0) may,
                                   nvl(jun,0) jun,nvl(jul,0) jul,nvl(aug,0) aug,nvl(sep,0) sep,nvl(oct,0) oct,nvl(nov,0) nov
                                    ,nvl(dec,0) dec,sl
                                    from mis.yearly_sales_analysis_web
                                    where sales_type = 'INSTITUTION SALES'
                                    order by sl");

        $export_sales = DB::select("select sales_year,sales_type,sales_desc,sales_person,
                                   nvl(jan,0) jan,nvl(feb,0) feb,nvl(mar,0) mar,nvl(apr,0) apr,nvl(may,0) may,
                                   nvl(jun,0) jun,nvl(jul,0) jul,nvl(aug,0) aug,nvl(sep,0) sep,nvl(oct,0) oct,nvl(nov,0) nov
                                    ,nvl(dec,0) dec,sl
                                    from mis.yearly_sales_analysis_web
                                    where sales_type = 'EXPORT SALES'
                                    order by sl");

        $export_service = DB::select("select sales_year,sales_type,sales_desc,sales_person,
                                   nvl(jan,0) jan,nvl(feb,0) feb,nvl(mar,0) mar,nvl(apr,0) apr,nvl(may,0) may,
                                   nvl(jun,0) jun,nvl(jul,0) jul,nvl(aug,0) aug,nvl(sep,0) sep,nvl(oct,0) oct,nvl(nov,0) nov
                                    ,nvl(dec,0) dec,sl
                                    from mis.yearly_sales_analysis_web
                                    where sales_type = 'EXPORT_SERVICE'
                                    order by sl");

        $toll = DB::select("select sales_year,sales_type,sales_desc,sales_person,
                                   nvl(jan,0) jan,nvl(feb,0) feb,nvl(mar,0) mar,nvl(apr,0) apr,nvl(may,0) may,
                                   nvl(jun,0) jun,nvl(jul,0) jul,nvl(aug,0) aug,nvl(sep,0) sep,nvl(oct,0) oct,nvl(nov,0) nov
                                    ,nvl(dec,0) dec,sl
                                    from mis.yearly_sales_analysis_web
                                    where sales_type = 'TOLL_MFG'
                                    order by sl");

        $company = DB::select("select sales_year,sales_type,sales_desc,sales_person,jan,feb,mar,apr,may,jun,jul,aug,sep,oct,nov,dec
                                from mis.yearly_sales_analysis_web
                                where sales_type = 'COMPANY'
                                order by sales_year desc,sl");

        return view('comp_analysis_of_sales.caos_index',
            compact('depot_sales','institute_sales','export_sales','export_service','toll','year','company'));
    }

}
