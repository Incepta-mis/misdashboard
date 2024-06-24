<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 7/5/2018
 * Time: 11:43 AM
 * update: 13/10/2018
 */

namespace App\Http\Controllers\SCM;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScmIPLCCController extends Controller
{
    public function index(){
        return view('scm_portal/ipl_clearance_certificate');
    }

    public function getLcNo(Request $request){
        if ($request->ajax()) {
            $resp_data = DB::Select("select distinct lc_no
                                        from mis.scm_clearance order by lc_no desc");
            return response()->json($resp_data);

        }
    }

    public function getInvNo(Request $request){
        if ($request->ajax()) {
            $resp_data = DB::Select("select distinct inv_no
                                        from mis.scm_clearance order by inv_no desc
                                  ");
            return response()->json($resp_data);
        }
    }


    // public function CC_pdf(Request $request)
    // {

    //     $rs = DB::select("select distinct plant
    //     from mis.scm_clearance where inv_no = ?", [$request->inv_no]);


    //     if ($rs[0]->plant == 'I013' || $rs[0]->plant == 'I010') {
    //         if ($request->inv_no) {


    //             $inv_data = DB::select("select a.lc_no,a.lc_date,a.crtf_date,a.inv_no,a.inv_date,a.plant,a.sl,a.blocklist_no,a.material_name,a.manufacturer_name,a.qty,a.uom,a.created_at,a.company_full_name,a.company_ho_address,a.company_factory_address,
    //                                     b.blocklist_year,b.rate,b.currency 
    //                                     from
    //                                     (select c.lc_no,c.lc_date,c.crtf_date,c.inv_no,c.inv_date,c.plant,c.sl,
    //                                            c.blocklist_no,c.material_name,c.manufacturer_name,c.qty,c.uom,c.created_at,ci.company_full_name,
    //                                            ci.company_ho_address,ci.company_factory_address
    //                                     from mis.scm_clearance c, mis.scm_company_info ci
    //                                     where inv_no = ?
    //                                     and c.plant = ci.plant) a,  (select distinct m.blocklist_year,m.manufacturer_name,m.blocklist_no,m.plant,m.material_name,decode(nvl(m.air_price,0),0,decode(nvl(m.road_price,0),0,m.sea_price,m.road_price),m.air_price)rate,m.currency
    //                                                                 from mis.scm_blocklist_material m
    //                                                                 union 
    //                                                                 select distinct d.blocklist_year,d.manufacturer_name,d.blocklist_no,d.plant,d.material_name,decode(nvl(d.air_price,0),0,decode(nvl(d.road_price,0),0,d.sea_price,d.road_price),d.air_price)rate,d.currency
    //                                                                 from mis.scm_blk_mat_bk_2017_2019 d 
    //                                                                 ) b
    //                                     where a.plant = b.plant  
    //                                     and a.blocklist_no = b.blocklist_no 
    //                                     and a.manufacturer_name = b.manufacturer_name 
    //                                     and upper(a.material_name) = upper(b.material_name)" , [$request->inv_no]);

    //             $data = ['rs_data' => $inv_data];

    //             $pdf = \PDF::loadView('scm_portal/IPL_IVL_certificate', $data);
    //             return $pdf->stream('certificate.pdf');

    //         }

    //     }
    //     else if ($rs[0]->plant == 'I003' || $rs[0]->plant == 'I009' || $rs[0]->plant == 'I015') {
    //         if ($request->inv_no) {


    //             $inv_data = DB::select("select a.lc_no,a.lc_date,a.crtf_date,a.inv_no,a.inv_date,a.plant,a.sl,a.blocklist_no,a.material_name,a.manufacturer_name,a.qty,a.uom,a.created_at,a.company_full_name,a.company_ho_address,a.company_factory_address,
    //                                     b.blocklist_year,b.rate,b.currency 
    //                                     from
    //                                     (select c.lc_no,c.lc_date,c.crtf_date,c.inv_no,c.inv_date,c.plant,c.sl,
    //                                            c.blocklist_no,c.material_name,c.manufacturer_name,c.qty,c.uom,c.created_at,ci.company_full_name,
    //                                            ci.company_ho_address,ci.company_factory_address
    //                                     from mis.scm_clearance c, mis.scm_company_info ci
    //                                     where inv_no = ?
    //                                     and c.plant = ci.plant) a,  (select distinct m.blocklist_year,m.manufacturer_name,m.blocklist_no,m.plant,m.material_name,decode(nvl(m.air_price,0),0,decode(nvl(m.road_price,0),0,m.sea_price,m.road_price),m.air_price)rate,m.currency
    //                                                                 from mis.scm_blocklist_material m
    //                                                                 union 
    //                                                                 select distinct d.blocklist_year,d.manufacturer_name,d.blocklist_no,d.plant,d.material_name,decode(nvl(d.air_price,0),0,decode(nvl(d.road_price,0),0,d.sea_price,d.road_price),d.air_price)rate,d.currency
    //                                                                 from mis.scm_blk_mat_bk_2017_2019 d 
    //                                                                 ) b
    //                                     where a.plant = b.plant  
    //                                     and a.blocklist_no = b.blocklist_no 
    //                                     and a.manufacturer_name = b.manufacturer_name 
    //                                     and upper(a.material_name) = upper(b.material_name)" , [$request->inv_no]);
    //             $data = ['rs_data' => $inv_data];


    //             $pdf = \PDF::loadView('scm_portal/certificate', $data);
    //             return $pdf->stream('certificate.pdf');

    //         }

    //     }else if ($rs[0]->plant == 'I012' || $rs[0]->plant == 'I014') {

    //         if ($request->inv_no) {

    //             $inv_data = DB::select("select a.lc_no,a.lc_date,a.crtf_date,a.inv_no,a.inv_date,a.plant,a.sl,a.blocklist_no,a.material_name,a.manufacturer_name,a.qty,a.uom,a.created_at,a.company_full_name,a.company_ho_address,a.company_factory_address,
    //                                     b.blocklist_year,b.rate,b.currency 
    //                                     from
    //                                     (select c.lc_no,c.lc_date,c.crtf_date,c.inv_no,c.inv_date,c.plant,c.sl,
    //                                            c.blocklist_no,c.material_name,c.manufacturer_name,c.qty,c.uom,c.created_at,ci.company_full_name,
    //                                            ci.company_ho_address,ci.company_factory_address
    //                                     from mis.scm_clearance c, mis.scm_company_info ci
    //                                     where inv_no = ?
    //                                     and c.plant = ci.plant) a,  (select distinct m.blocklist_year,m.manufacturer_name, m.blocklist_no,m.plant,m.material_name,decode(nvl(m.air_price,0),0,decode(nvl(m.road_price,0),0,m.sea_price,m.road_price),m.air_price)rate,m.currency
    //                                                                 from mis.scm_blocklist_material m
    //                                                                 union 
    //                                                                 select distinct d.blocklist_year,d.manufacturer_name, d.blocklist_no,d.plant,d.material_name,decode(nvl(d.air_price,0),0,decode(nvl(d.road_price,0),0,d.sea_price,d.road_price),d.air_price)rate,d.currency
    //                                                                 from mis.scm_blk_mat_bk_2017_2019 d 
    //                                                                 ) b
    //                                     where a.plant = b.plant  
    //                                     and a.blocklist_no = b.blocklist_no 
    //                                     and a.manufacturer_name = b.manufacturer_name 
    //                                     and upper(a.material_name) = upper(b.material_name)" , [$request->inv_no]);
    //             $data = ['rs_data' => $inv_data];

    //             $pdf = \PDF::loadView('scm_portal/ihhl_ihnl_certificate', $data);
    //             return $pdf->stream('certificate.pdf');

    //         }



    //     }

    // }


    public function CC_pdf(Request $request)
    {

        $rs = DB::select("select distinct plant
        from mis.scm_clearance where inv_no = ?", [$request->inv_no]);


        if ($rs[0]->plant == 'I013' || $rs[0]->plant == 'I010') {
            if ($request->inv_no) {
//                $inv_data = DB::select("select c.lc_no,c.lc_date,c.crtf_date,c.inv_no,c.inv_date,c.plant,c.sl,c.plant,c.blocklist_no,c.material_name,c.manufacturer_name,c.qty,c.uom,c.created_at,ci.company_full_name,ci.company_ho_address,ci.company_factory_address,m.blocklist_year,decode(nvl(air_price,0),0,decode(nvl(road_price,0),0,sea_price,road_price),air_price)rate,m.currency
//                                    from mis.scm_clearance c, mis.scm_blocklist_material m , mis.scm_company_info ci
//                                    where inv_no = ?
//                                    and c.plant = ci.plant
//                                    and upper(c.material_name) = upper(m.material_name)
//                                     and ci.plant = m.plant
//                                     and c.manufacturer_name = m.manufacturer_name
//                                    and m.blocklist_no = c.blocklist_no
//                                    and c.plant = m.plant
//                                    order by c.sl", [$request->inv_no]);


                $inv_data = DB::select("select a.lc_no,a.lc_date,a.crtf_date,a.inv_no,a.inv_date,a.plant,a.sl,a.blocklist_no,a.material_name,a.manufacturer_name,a.qty,a.uom,a.created_at,a.company_full_name_new,a.company_ho_address,a.company_factory_address,
                                        b.blocklist_year,b.rate,b.currency 
                                        from
                                        (select c.lc_no,c.lc_date,c.crtf_date,c.inv_no,c.inv_date,c.plant,c.sl,
                                               c.blocklist_no,c.material_name,c.manufacturer_name,c.qty,c.uom,c.created_at,ci.company_full_name_new,
                                               ci.company_ho_address,ci.company_factory_address
                                        from mis.scm_clearance c, mis.scm_company_info ci
                                        where inv_no = ?
                                        and c.plant = ci.plant) a,  (select distinct m.blocklist_year,m.manufacturer_name,m.blocklist_no,m.plant,m.material_name,decode(nvl(m.air_price,0),0,decode(nvl(m.road_price,0),0,m.sea_price,m.road_price),m.air_price)rate,m.currency
                                                                    from mis.scm_blocklist_material m
                                                                    union 
                                                                    select distinct d.blocklist_year,d.manufacturer_name,d.blocklist_no,d.plant,d.material_name,decode(nvl(d.air_price,0),0,decode(nvl(d.road_price,0),0,d.sea_price,d.road_price),d.air_price)rate,d.currency
                                                                    from mis.scm_blk_mat_bk_2017_2019 d 
                                                                    ) b
                                        where a.plant = b.plant  
                                        and a.blocklist_no = b.blocklist_no 
                                        and a.manufacturer_name = b.manufacturer_name 
                                        and upper(a.material_name) = upper(b.material_name)" , [$request->inv_no]);

                $data = ['rs_data' => $inv_data];

//                dd($data);
//
//                exit;


                $pdf = \PDF::loadView('scm_portal/IPL_IVL_certificate', $data);
                return $pdf->stream('certificate.pdf');

            }

        }
        else if ($rs[0]->plant == 'I003' || $rs[0]->plant == 'I018'|| $rs[0]->plant == 'I009' || $rs[0]->plant == 'I015' || $rs[0]->plant == 'I017' || $rs[0]->plant == 'I014') {
            if ($request->inv_no) {
//                $inv_data = DB::select("select c.lc_no,c.lc_date,c.crtf_date,c.inv_no,c.inv_date,c.plant,c.sl,c.plant,c.blocklist_no,c.material_name,c.manufacturer_name,c.qty,c.uom,c.created_at,ci.company_full_name,ci.company_ho_address,ci.company_factory_address,m.blocklist_year,decode(nvl(air_price,0),0,decode(nvl(road_price,0),0,sea_price,road_price),air_price)rate,m.currency
//                                    from mis.scm_clearance c, mis.scm_blocklist_material m , mis.scm_company_info ci
//                                    where inv_no = ?
//                                    and c.plant = ci.plant
//                                    and upper(c.material_name) = upper(m.material_name)
//                                     and ci.plant = m.plant
//                                     and c.manufacturer_name = m.manufacturer_name
//                                    and m.blocklist_no = c.blocklist_no
//                                    and c.plant = m.plant
//                                    order by c.sl", [$request->inv_no]);

                $inv_data = DB::select("select a.lc_no,a.lc_date,a.crtf_date,a.inv_no,a.inv_date,a.plant,a.sl,a.blocklist_no,a.material_name,a.manufacturer_name,a.qty,a.uom,a.created_at,a.company_full_name_new,a.company_ho_address,a.company_factory_address,
                                        b.blocklist_year,b.rate,b.currency 
                                        from
                                        (select c.lc_no,c.lc_date,c.crtf_date,c.inv_no,c.inv_date,c.plant,c.sl,
                                               c.blocklist_no,c.material_name,c.manufacturer_name,c.qty,c.uom,c.created_at,ci.company_full_name_new,
                                               ci.company_ho_address,ci.company_factory_address
                                        from mis.scm_clearance c, mis.scm_company_info ci
                                        where inv_no = ?
                                        and c.plant = ci.plant) a,  (select distinct m.blocklist_year,m.manufacturer_name,m.blocklist_no,m.plant,m.material_name,decode(nvl(m.air_price,0),0,decode(nvl(m.road_price,0),0,m.sea_price,m.road_price),m.air_price)rate,m.currency
                                                                    from mis.scm_blocklist_material m
                                                                    union 
                                                                    select distinct d.blocklist_year,d.manufacturer_name,d.blocklist_no,d.plant,d.material_name,decode(nvl(d.air_price,0),0,decode(nvl(d.road_price,0),0,d.sea_price,d.road_price),d.air_price)rate,d.currency
                                                                    from mis.scm_blk_mat_bk_2017_2019 d 
                                                                    ) b
                                        where a.plant = b.plant  
                                        and a.blocklist_no = b.blocklist_no 
                                        and a.manufacturer_name = b.manufacturer_name 
                                        and upper(a.material_name) = upper(b.material_name)" , [$request->inv_no]);
                $data = ['rs_data' => $inv_data];

//                dd($inv_data);


                $pdf = \PDF::loadView('scm_portal/certificate', $data);
                return $pdf->stream('certificate.pdf');

            }

        }else if ($rs[0]->plant == 'I012' || $rs[0]->plant == 'I020' ) {

            if ($request->inv_no) {
//                $inv_data = DB::select("select c.lc_no,c.lc_date,c.crtf_date,c.inv_no,c.inv_date,c.plant,c.sl,c.plant,c.blocklist_no,c.material_name,c.manufacturer_name,c.qty,c.uom,c.created_at,ci.company_full_name,ci.company_ho_address,ci.company_factory_address,m.blocklist_year,decode(nvl(air_price,0),0,decode(nvl(road_price,0),0,sea_price,road_price),air_price)rate,m.currency
//                                    from mis.scm_clearance c, mis.scm_blocklist_material m , mis.scm_company_info ci
//                                    where inv_no = ?
//                                    and c.plant = ci.plant
//                                    and upper(c.material_name) = upper(m.material_name)
//                                     and ci.plant = m.plant
//                                    and m.blocklist_no = c.blocklist_no
//                                    and c.manufacturer_name = m.manufacturer_name
//                                    and c.plant = m.plant
//                                    order by c.sl", [$request->inv_no]);
                $inv_data = DB::select("select a.lc_no,a.lc_date,a.crtf_date,a.inv_no,a.inv_date,a.plant,a.sl,a.blocklist_no,a.material_name,a.manufacturer_name,a.qty,a.uom,a.created_at,a.company_full_name_new,a.company_ho_address,a.company_factory_address,
                                        b.blocklist_year,b.rate,b.currency 
                                        from
                                        (select c.lc_no,c.lc_date,c.crtf_date,c.inv_no,c.inv_date,c.plant,c.sl,
                                               c.blocklist_no,c.material_name,c.manufacturer_name,c.qty,c.uom,c.created_at,ci.company_full_name_new,
                                               ci.company_ho_address,ci.company_factory_address
                                        from mis.scm_clearance c, mis.scm_company_info ci
                                        where inv_no = ?
                                        and c.plant = ci.plant) a,  (select distinct m.blocklist_year,m.manufacturer_name, m.blocklist_no,m.plant,m.material_name,decode(nvl(m.air_price,0),0,decode(nvl(m.road_price,0),0,m.sea_price,m.road_price),m.air_price)rate,m.currency
                                                                    from mis.scm_blocklist_material m
                                                                    union 
                                                                    select distinct d.blocklist_year,d.manufacturer_name, d.blocklist_no,d.plant,d.material_name,decode(nvl(d.air_price,0),0,decode(nvl(d.road_price,0),0,d.sea_price,d.road_price),d.air_price)rate,d.currency
                                                                    from mis.scm_blk_mat_bk_2017_2019 d 
                                                                    ) b
                                        where a.plant = b.plant  
                                        and a.blocklist_no = b.blocklist_no 
                                        and a.manufacturer_name = b.manufacturer_name 
                                        and upper(a.material_name) = upper(b.material_name)" , [$request->inv_no]);
                $data = ['rs_data' => $inv_data];

                $pdf = \PDF::loadView('scm_portal/ihhl_ihnl_certificate', $data);
                return $pdf->stream('certificate.pdf');

            }



        }


//        return response()->json($request->all());
    }



}