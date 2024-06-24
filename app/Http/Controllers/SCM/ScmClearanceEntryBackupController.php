<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 7/1/2018
 * Time: 11:45 AM
 */

namespace App\Http\Controllers\SCM;


use App\Http\Controllers\Controller;
use App\ScmClearance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function MongoDB\BSON\toJSON;

class ScmClearanceEntryBackupController extends Controller
{
    public function index()
    {
        return view('scm_portal/clearance_entry');
    }

    public function blkListNo(Request $request)
    {
        if ($request->ajax()) {
            $resp_data = DB::Select("select distinct blocklist_no
                                    from mis.scm_blocklist_material");
            return response()->json($resp_data);
            //return response()->json($request->all());
        }
    }

    public function materialName(Request $request)
    {
        if ($request->ajax()) {
            $resp_data = DB::Select("select distinct  material_name
                                    from mis.scm_blocklist_material
                                    where BLOCKLIST_NO = '$request->blkl'");
            return response()->json($resp_data);
        }
    }

    public function manufacturerName(Request $request)
    {
        if ($request->ajax()) {
            $resp_data = DB::Select("select distinct  manufacturer_name
                            from mis.scm_blocklist_material
                            where material_name = '$request->smatname'
                            and blocklist_no='$request->tbkln'");
            return response()->json($resp_data);
        }
    }

    public function getQuantity(Request $request){
        if ($request->ajax()) {
            $resp_data = DB::Select("select DISTINCT qty
            from mis.scm_blocklist_material
            where blocklist_no = ?
            and material_name  = ? ",[trim($request->_bkl_no),trim($request->_mName)]);
            return response()->json($resp_data);
        }
    }

    public function getAvailQuantity(Request $request){
        if ($request->ajax()) {
            $resp_data = DB::Select("select ( sum(qty)-sum(sqty) - SCM_AVL_MATQTY ('$request->_bkl_no','$request->_mName') ) qty from
                                    (
                                        select DISTINCT qty ,0 sqty
                                        from mis.scm_blocklist_material
                                        where blocklist_no = ?
                                        and material_name  = ?
                                        union all
                                        select  0,sum(qty) qty
                                        from mis.SCM_CLEARANCE
                                        where blocklist_no = ?
                                        and material_name  = ? 
                                    )",[trim($request->_bkl_no),trim($request->_mName),trim($request->_bkl_no),trim($request->_mName)]);
            return response()->json($resp_data);
        }
    }




    public function getCurrencyRate(Request $request){
        if ($request->ajax()) {
            $resp_data = DB::select("select DISTINCT decode(nvl(air_price,0),0,decode(nvl(road_price,0),0,sea_price,road_price),air_price) rate,currency
                    from mis.scm_blocklist_material
                    where blocklist_no = ?
                    and material_name  = ?", [trim($request->_bkl_no), trim($request->_mName)]);
            return response()->json($resp_data);
        }
    }





    public function clearanceReportData(Request $request)
    {
        try {
            if ($request->ajax()) {

                $uid = Auth::user()->user_id;
                $lc_no = $request->lc_no;
                if(!empty($request->lc_dt)){
                    $lc_dt = Carbon::createFromFormat('d/m/Y', $request->lc_dt)->toDateString();
                }else {
                    $lc_dt = '';
                }

                $inv_no = $request->inv_no;
                $inv_dt = Carbon::createFromFormat('d/m/Y', $request->inv_dt)->toDateString();
                $crtf_dt = Carbon::createFromFormat('d/m/Y', $request->crtf_dt)->toDateString();

                $i = 1;
                foreach ($request->cr_data as $data) {
                    $sl = $i++;
                    $list = json_decode($data);

                    $clr = new ScmClearance();
                    $clr->lc_no = $lc_no;
                    $clr->lc_date = $lc_dt;
                    $clr->inv_no = $inv_no;
                    $clr->inv_date = $inv_dt;
                    $clr->crtf_date = $crtf_dt;
                    $clr->plant = substr($list->bkln_list, 0, 4);

                    $clr->sl = $sl;
                    $clr->blocklist_no = $list->bkln_list;
                    $clr->material_name = $list->nof_mat;
                    $clr->manufacturer_name = $list->manufact;
                    $clr->qty = $list->mat_qty;
                    $clr->uom = $list->mat_uom;
                    $clr->create_user = $uid;

                    $clr->rate = $list->rate;
                    $clr->currency = $list->currency;
                    $clr->save();

                }

           // return response()->json($request->all());

                return response()->json(['success' => 'Records Save Successfully.']);
            }
        } catch (Exception $e) {
            return $request->messages();
        }

    }



}