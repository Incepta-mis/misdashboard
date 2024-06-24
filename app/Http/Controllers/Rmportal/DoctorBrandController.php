<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 08/01/18
 * Time: 15:30
 */

namespace App\Http\Controllers\Rmportal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Input;
use Validator;
use File;

class DoctorBrandController extends Controller
{

    public function index()
    {
        return view('autocomplete');
    }

    public function searchResponse(Request $request)
    {
        $query = $request->get('term', '');
        $doctable = '';
        if ($request->type == 'doctorname') {
            $doctable = \DB::table('mis.doctor_wise_item_utilization')
                ->distinct()->select('doctor_name', 'doctor_id')
                ->where('doctor_name', 'LIKE', strtoupper('%' . $query . '%'))
                ->where('terr_id', '=', $request->mpoTerr);
        }
        if ($request->type == 'doctorid') {
            $doctable = DB::table('mis.doctor_wise_item_utilization')
                ->distinct()->select('doctor_name', 'doctor_id')
                ->where('doctor_id', 'LIKE', strtoupper('%' . $query . '%'))
                ->where('terr_id', '=', $request->mpoTerr);
        }
        $doctable = $doctable->get();

        $data = array();
        if ($request->type == 'doctorname') {
            foreach ($doctable as $val) {
                $data[] = array('doc_name' => $val->doctor_id . ' | ' . $val->doctor_name);
            }
        }
        if ($request->type == 'doctorid') {
            foreach ($doctable as $val) {
                $data[] = array('doc_id' => $val->doctor_id . ' | ' . $val->doctor_name);
            }
        }

        if (count($data))
            return $data;
        else
            return ['doc_name' => '', 'doc_id' => ''];
    }


    public function brandCountDoc(Request $request){
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        if ($request->ajax()) {

            $bname = $request->brandName;

            // $resp_data = DB::Select("select brand_name ||'('|| count(brand_name)||')' brand_name
            //                         from doctor_wise_item_utilization
            //                         WHERE terr_id = '$request->mpoId'
            //                         and doctor_id = '$request->docId'
            //                         and brand_name =  decode('$bname','All',brand_name,'$bname')
            //                         group by brand_name");

                 $resp_data = DB::Select("select distinct brand_name brand_name
                                    from doctor_wise_item_utilization
                                    WHERE terr_id = '$request->mpoId'
                                    and doctor_id = '$request->docId'
                                    and brand_name =  decode('$bname','All',brand_name,'$bname')
                                    order by brand_name");

            return response()->json($resp_data);
            // return response()->json($request->all());
        }
    }


    public function regwMpoTerrList(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {

            $resp_data = DB::Select("select DISTINCT tl.mpo_terr_id mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms tl
                                    where tl.rm_terr_id = '$request->rmTerrId'
                                    and tl.am_terr_id = '$request->amTerr'
                                    and tl.emp_month = trunc(sysdate,'MM')                                    
                                    order by TO_NUMBER(SUBSTR( tl.mpo_terr_id,instr( tl.mpo_terr_id,'-', -1)+1))");

            return response()->json($resp_data);
            
        }
    }


    public function doctorBrandNameBasedOnId(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        if ($request->ajax()) {

            $resp_data = DB::Select("select DISTINCT brand_name
                                    from doctor_wise_item_utilization
                                    WHERE terr_id = '$request->mpoTerr'
                                    and doctor_id = '$request->docId'");

            return response()->json($resp_data);

        }
    }

    public function doctorBrandNameBasedOnName(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        if ($request->ajax()) {

            $resp_data = DB::Select("select DISTINCT brand_name
                                    from doctor_wise_item_utilization
                                    WHERE terr_id = '$request->mpoTerr'
                                    and doctor_id = '$request->docId'");

            return response()->json($resp_data);
            // return response()->json($request->all());
        }
    }

    public function regTerrDocList(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        if ($request->ajax()) {

            $bname = $request->brandName;

            // $resp_data = DB::Select("select terr_id,doctor_id,doctor_name,brand_name,item_id,item_name,exposer_qty
            //                         from doctor_wise_item_utilization
            //                         WHERE terr_id = '$request->mpoId'
            //                         and doctor_id = '$request->docId'
            //                         and brand_name =  decode('$bname','All',brand_name,'$bname')");

                 $resp_data = DB::Select("select distinct terr_id,doctor_id,doctor_name,brand_name,exposer_qty
                                    from doctor_wise_item_utilization
                                    WHERE terr_id = '$request->mpoId'
                                    and doctor_id = '$request->docId'
                                    and brand_name =  decode('$bname','All',brand_name,'$bname')");

            return response()->json($resp_data);
            // return response()->json($request->all());
        }
    }


    function mpoTerrwiseBranddoc(Request $request){
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        if ($request->ajax()) {

            // $resp_data = DB::Select("select a.terr_id,b.doctor_id,b.doctor_name,a.exposer_qty,a.brand_name
            //                             from
            //                             (select  terr_id,doctor_id, doctor_name,exposer_qty,  listagg (brand_name , ',')
            //                             WITHIN GROUP (ORDER BY brand_name) brand_name 
            //                             from(
            //                             select terr_id,doctor_id,doctor_name,brand_name || '(' || count(brand_name) ||')' brand_name,exposer_qty
            //                             from mis.doctor_wise_item_utilization
            //                             WHERE terr_id = ?
            //                             group by terr_id,doctor_id,doctor_name,brand_name,exposer_qty
            //                             )GROUP BY  terr_id,doctor_id,doctor_name,exposer_qty) a, (select distinct doctor_id, doctor_name from doctor_info.doctor_information@web_to_sample_msd) b
            //                             where a.doctor_id = b.doctor_id
            //                             order by b.doctor_id",[$request->mpoTerr]);

             $resp_data = DB::Select("select a.terr_id,b.doctor_id,b.doctor_name,a.exposer_qty,a.brand_name
                                        from
                                        (select  terr_id,doctor_id, exposer_qty,  listagg (brand_name , ',')
                                        WITHIN GROUP (ORDER BY brand_name) brand_name
                                        from(
                                        select DISTINCT terr_id,doctor_id,brand_name,exposer_qty
                                        from mis.doctor_wise_item_utilization
                                        WHERE terr_id = ?
                                        group by terr_id,doctor_id,brand_name,exposer_qty
                                        )GROUP BY  terr_id,doctor_id,exposer_qty) a,
                                         (select distinct doctor_id, doctor_name from doctor_info.doctor_information@web_to_sample_msd where nvl(doctor_status,'AA') != 'DELETE') b
                                        where a.doctor_id = b.doctor_id
                                        order by b.doctor_id",[$request->mpoTerr]);

            return response()->json($resp_data);

        }

    }

}