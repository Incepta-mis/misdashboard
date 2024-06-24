<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 10/13/2019
 * Time: 11:35 AM
 */

namespace App\Http\Controllers\ExpoDatabase;


use App\ExpoDatabaseTable\ExpoCountryWiseProducts;
use App\ExpoDatabaseTable\ExpoInfo;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class ExpoDatabaseController extends Controller
{
    private $line_path = '';

    public function index()
    {

        $data = DB::select("
        select distinct  export_country,plant_id plant_id,product_code,product_name, finish_product_code,pack_size,
        (export_country ||' - '|| product_code ||' - '||product_name||' - '|| finish_product_code ||' - '|| product_name ||' - '|| product_generic ||' - '||
        pack_size ||' - '|| company_agent_name ||' - '|| contact_name  ||' - '|| address ) details
        from 
        mis.expo_country_wise_products
        order by export_country
        ");

        $uid = Auth::user()->user_id;

        return view('expo_database.expo', ['expo_data' => $data, 'uid' => $uid]);
    }

    public function getExpoEntryData(Request $request)
    {

//        return response()->json($request->lovCode);

        $lovArray = explode(",", $request->lovCode);
        $plant_id = trim($lovArray[0]);
        $product_code = trim($lovArray[1]);
        $product_name = trim($lovArray[2]);
        $export_country = trim($lovArray[3]);
        $pack_size = trim($lovArray[4]);

//               return response()->json($pack_size);

        $data = DB::select("
        select *
        from v_expolov
        where plant_id = '$plant_id'
        and product_code = '$product_code'
        and product_name = '$product_name'
        and export_country = '$export_country'
        and pack_size = (q'[$pack_size]')
        ");
        return response()->json($data);

    }

    //country wise product update table update product code
    public static function countryWiseProductCodeUpdate($local_pcode, $brand_name, $exp_country, $com_agent, $finish_product, $sys_time, $uid)
    {
        ExpoCountryWiseProducts::where('product_code', $local_pcode)
            ->where('product_name', $brand_name)
            ->where('export_country', $exp_country)
            ->where('company_agent_name', $com_agent)
            ->update([
                'finish_product_code' => $finish_product,
                'updated_at' => $sys_time,
                'update_user' => $uid
            ]);
    }

    public static function checkNonCtdFiles($request, $nonctd_api_source, $non_fp_spec, $non_manufacturer, $non_stability)
    {
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            $filesInputNames = explode(",", $request->fileArrayName);
            $length = count($files);
            for ($i = 0; $i < $length; $i++) {
                $filenameWithExt = $files[$i]->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $files[$i]->getClientOriginalExtension();
                $fileNameToStore = $filename . '.' . $extension;

//                Log::info($filesInputNames[$i]);
//                Log::info($files[$i]->getClientOriginalName());

                switch ($filesInputNames[$i]) {

                    case 'non_api_source':
                        $nonctd_api_source = '/IRA_PDF/NONCTD/' . $files[$i]->getClientOriginalName();
                        $files[$i]->move(public_path() . '/IRA_PDF/NONCTD/', $files[$i]->getClientOriginalName());
                        break;
                    case 'non_fp_spec':
                        $non_fp_spec = '/IRA_PDF/NONCTD/' . $files[$i]->getClientOriginalName();
                        $files[$i]->move(public_path() . '/IRA_PDF/NONCTD/', $files[$i]->getClientOriginalName());
                        break;
                    case 'non_manufacturer':
                        $non_manufacturer = '/IRA_PDF/NONCTD/' . $files[$i]->getClientOriginalName();
                        $files[$i]->move(public_path() . '/IRA_PDF/NONCTD/', $files[$i]->getClientOriginalName());
                        break;
                    case 'non_stability':
                        $non_stability = '/IRA_PDF/NONCTD/' . $files[$i]->getClientOriginalName();
                        $files[$i]->move(public_path() . '/IRA_PDF/NONCTD/', $files[$i]->getClientOriginalName());
                        break;
                }

            }
            return array($nonctd_api_source, $non_fp_spec, $non_manufacturer, $non_stability);
        }
    }

    public static function checkCtdFiles($request, $ctd_api_source, $ctd_fp_spec, $ctd_manufacturer, $ctd_stability)
    {
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            $filesInputNames = explode(",", $request->fileArrayName);
            $length = count($files);
            for ($i = 0; $i < $length; $i++) {
                $filenameWithExt = $files[$i]->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $files[$i]->getClientOriginalExtension();
                $fileNameToStore = $filename . '.' . $extension;
                switch ($filesInputNames[$i]) {
                    case 'api_source':
                        $ctd_api_source = '/IRA_PDF/CTD/' . $files[$i]->getClientOriginalName();
                        $files[$i]->move(public_path() . '/IRA_PDF/CTD/', $files[$i]->getClientOriginalName());
                        break;
                    case 'fp_spec':
                        $ctd_fp_spec = '/IRA_PDF/CTD/' . $files[$i]->getClientOriginalName();
                        $files[$i]->move(public_path() . '/IRA_PDF/CTD/', $files[$i]->getClientOriginalName());
                        break;
                    case 'manufacturer':
                        $ctd_manufacturer = '/IRA_PDF/CTD/' . $files[$i]->getClientOriginalName();
                        $files[$i]->move(public_path() . '/IRA_PDF/CTD/', $files[$i]->getClientOriginalName());
                        break;
                    case 'stability':
                        $ctd_stability = '/IRA_PDF/CTD/' . $files[$i]->getClientOriginalName();
                        $files[$i]->move(public_path() . '/IRA_PDF/CTD/', $files[$i]->getClientOriginalName());
                        break;
                }
            }
            return array($ctd_api_source, $ctd_fp_spec, $ctd_manufacturer, $ctd_stability);
        }
    }

    public static function checkReuseCtdFiles($request, $reuse_ctd_api_source, $reuse_ctd_fp_spec, $reuse_ctd_manufacturer, $reuse_ctd_stability)
    {
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            $filesInputNames = explode(",", $request->fileArrayName);
            $length = count($files);
            for ($i = 0; $i < $length; $i++) {
                $filenameWithExt = $files[$i]->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $files[$i]->getClientOriginalExtension();
                $fileNameToStore = $filename . '.' . $extension;
                switch ($filesInputNames[$i]) {
                    case 'reuse_api_source':
                        $reuse_ctd_api_source = '/IRA_PDF/REUSE_CTD/' . $files[$i]->getClientOriginalName();
                        $files[$i]->move(public_path() . '/IRA_PDF/REUSE_CTD/', $files[$i]->getClientOriginalName());
                        break;
                    case 'reuse_fp_spec':
                        $reuse_ctd_fp_spec = '/IRA_PDF/REUSE_CTD/' . $files[$i]->getClientOriginalName();
                        $files[$i]->move(public_path() . '/IRA_PDF/REUSE_CTD/', $files[$i]->getClientOriginalName());
                        break;
                    case 'reuse_manufacturer':
                        $reuse_ctd_manufacturer = '/IRA_PDF/REUSE_CTD/' . $files[$i]->getClientOriginalName();
                        $files[$i]->move(public_path() . '/IRA_PDF/REUSE_CTD/', $files[$i]->getClientOriginalName());
                        break;
                    case 'reuse_stability':
                        $reuse_ctd_stability = '/IRA_PDF/REUSE_CTD/' . $files[$i]->getClientOriginalName();
                        $files[$i]->move(public_path() . '/IRA_PDF/REUSE_CTD/', $files[$i]->getClientOriginalName());
                        break;
                }
            }
            return array($reuse_ctd_api_source, $reuse_ctd_fp_spec, $reuse_ctd_manufacturer, $reuse_ctd_stability);
        }
    }

    public function getExpoEntryInfo(Request $request)
    {


//        return response()->json($request->all());



        if (!empty($request->fi_code)) {
            $data = DB::select("select *
            from mis.expo_info
            where finish_product_code = '$request->fi_code' order by line_id desc");
        } else {
            $data = DB::select("select *
             from mis.expo_info
             where export_country = '$request->exp_country'
             and product_code = '$request->local_pcode'
             and expo_product_name = '$request->expo_product_name'
             and brand_name = '$request->brand_name'");
        }


        if ($data) {
            return response()->json($data);
        } else {
            return response()->json(['error' => 'No data found!']);
        }
    }

    public function upload(Request $request)
    {

        if ($request->hasFile('ctd_data')) {
            $ctd_data = $request->hasFile('ctd_data');
            return response()->json($ctd_data);
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
//            $fileNameToStore = $filename.'-'.time().'.'.$extension;
            $fileNameToStore = $filename . $extension;

            if (
                $request->file_name == 'fp_spec' || $request->file_name == 'api_source' ||
                $request->file_name == 'manufacturer' || $request->file_name == 'stability'
            ) {
                $file->move(public_path() . '/IRA_PDF/CTD/', $fileNameToStore);
                $path = public_path() . '/IRA_PDF/CTD/' . $fileNameToStore;
                $f_path = '\public' . '/IRA_PDF/CTD/' . $fileNameToStore;

                $file_name = $request->file_name;

                return response()->json(["file_name" => $file_name, "file" => $f_path]);
            }

            else if (
                $request->file_name == 'reuse_fp_spec' || $request->file_name == 'reuse_api_source' ||
                $request->file_name == 'reuse_manufacturer' || $request->file_name == 'reuse_stability'
            ) {
                $file->move(public_path() . '/IRA_PDF/REUSE_CTD/', $fileNameToStore);
                $path = public_path() . '/IRA_PDF/REUSE_CTD/' . $fileNameToStore;
                $f_path = '\public' . '/IRA_PDF/REUSE_CTD/' . $fileNameToStore;

                $file_name = $request->file_name;

                return response()->json(["file_name" => $file_name, "file" => $f_path]);
            }

            else {
                $file->move(public_path() . '/IRA_PDF/NONTCTD/', $fileNameToStore);
                $path = public_path() . '/IRA_PDF/NONTCTD/' . $fileNameToStore;
                $f_path = '\public' . '/IRA_PDF/NONTCTD/' . $fileNameToStore;

                $file_name = $request->file_name;

                return response()->json(["file_name" => $file_name, "file" => $f_path]);
            }


        }

    }



    //stage -1 IRA
    public function getIRAStage1Data(Request $request)
    {
        $uid = Auth::user()->user_id;
        $DataArray = json_decode($request->DataArray);

        Log::info($DataArray);


        $im_submitted_date = Carbon::parse($DataArray[0]->sub_to_im_date)->format('Y-m-d');
        $type_of_dossier = "";
        if (empty($DataArray[0]->type_of_dossier)) {
            $type_of_dossier = "";
        } else {
            $type_of_dossier = $DataArray[0]->type_of_dossier;
        }
        $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

        //NON CTD Working
        if ($type_of_dossier == 'NON_CTD') {
            $nonctd_api_source = "";
            $non_fp_spec = "";
            $non_manufacturer = "";
            $non_stability = "";
            $v_local_pcode = $DataArray[0]->local_pcode;
            $v_exp_country = $DataArray[0]->exp_country;
            $v_ex_product_name = $DataArray[0]->expo_product_name;
            $v_ex_pack_size = $DataArray[0]->pack_size;
            $v_exist = DB::select(" select count(*) cnt from MIS.EXPO_INFO where product_code = ? and brand_name = ? and export_country = ? and pack_size = ?", [$v_local_pcode, $v_ex_product_name, $v_exp_country, $v_ex_pack_size]);


            if ($v_exist[0]->cnt > 0) {
                $uid = Auth::user()->user_id;
                $DataArray = json_decode($request->DataArray);
                $im_submitted_date = Carbon::parse($DataArray[0]->sub_to_im_date)->format('Y-m-d');
                $sequence = DB::getSequence();
                $line_id = $sequence->nextValue('MIS.SEQ_EXPO_INFO');
                if ($DataArray[0]->status == 'Edit') {
                    $MAX_line_id = DB::select("select max(line_id) line_id from mis.expo_info where product_code = ? and brand_name = ? and export_country = ? and expo_product_name = ? ", [$DataArray[0]->local_pcode, $DataArray[0]->brand_name, $DataArray[0]->exp_country, $DataArray[0]->expo_product_name]);
                    $filesName = ExpoDatabaseController::checkNonCtdFiles($request, $nonctd_api_source, $non_fp_spec, $non_manufacturer, $non_stability);
                    $rs = ExpoInfo::where('product_code', $DataArray[0]->local_pcode)
                        ->where('export_country', $DataArray[0]->exp_country)
                        ->where('line_id', $MAX_line_id[0]->line_id)
                        ->update([
                            'status' => $DataArray[0]->status,
                            'im_team' => $DataArray[0]->im_team,
                            'finish_product_code' => $DataArray[0]->finish_product,
                            'submitted_to_im' => $im_submitted_date,
                            'sub_name' => $DataArray[0]->sub_name,
                            'sub_by_ira' => $DataArray[0]->sub_by_ira,
                            'dossier_type' => $DataArray[0]->type_of_dossier,
                            'nonctd_api_source' => $filesName[0],
                            'nonctd_fp_spec' => $filesName[1],
                            'nonctd_manufacturer' => $filesName[2],
                            'nonctd_stability' => $filesName[3],
                            'api_type' => '',
                            'ctd_api_source' => '',
                            'ctd_fp_spec' => '',
                            'ctd_manufacturer' => '',
                            'ctd_stability' => '',
                            'pv' => '',
                            'impurity_of_fp' => '',
                            'ctdp_match' => '',
                            'ctd_study' => '',
                            'updated_at' => $sys_time,
                            'update_user' => $uid
                        ]);
                    if ($rs) {
                        //update Expo Country wise finish product column
                        if (!empty($DataArray[0]->finish_product)) {
                            ExpoDatabaseController::countryWiseProductCodeUpdate($DataArray[0]->local_pcode, $DataArray[0]->brand_name,
                                $DataArray[0]->exp_country, $DataArray[0]->com_agent, $DataArray[0]->finish_product, $sys_time, $uid);
                        }
                        return response()->json(["success" => "Record Update Successfully"]);
                    } else {
                        return response()->json(["error" => "Record Not Saved, Please contact administrator",]);
                    }
                }
                else if ($DataArray[0]->status == 'Renew') {

                    $filesName = ExpoDatabaseController::checkNonCtdFiles($request, $nonctd_api_source, $non_fp_spec, $non_manufacturer, $non_stability);


                    $insertLineId = DB::select(" select line_id from ( select line_id,product_code,current_status from mis.expo_info where finish_product_code = ? order by line_id desc ) where rownum <= 1", [$DataArray[0]->finish_product]);

                    $fiCode = DB::select(" select count(*) cnt from mis.expo_info where line_id = ? and current_status = 'REG' ", [$insertLineId[0]->line_id]);


                    if ($fiCode[0]->cnt > 0) {

                        $rs = DB::table('MIS.EXPO_INFO')->insert(
                            [
                                'line_id' => $line_id,
                                'status' => $DataArray[0]->status,
                                'renew_status' => 'YES',
                                'plant_id' => $DataArray[0]->plant_id,
                                'finish_product_code' => $DataArray[0]->finish_product,
                                'product_code' => $DataArray[0]->local_pcode,
                                'brand_name' => $DataArray[0]->brand_name,
                                'export_country' => $DataArray[0]->exp_country,
                                'expo_product_name' => $DataArray[0]->expo_product_name,
                                'product_generic' => $DataArray[0]->gen_name,
                                'pack_size' => $DataArray[0]->pack_size,
                                'company_agent_name' => $DataArray[0]->com_agent,
                                'contact_name' => $DataArray[0]->contact_name,
                                'address' => $DataArray[0]->address,
                                'im_team' => $DataArray[0]->im_team,
                                'submitted_to_im' => $im_submitted_date,
                                'sub_name' => $DataArray[0]->sub_name,
                                'sub_by_ira' => $DataArray[0]->sub_by_ira,
                                'dossier_type' => $type_of_dossier,
                                'nonctd_api_source' => $filesName[0],
                                'nonctd_fp_spec' => $filesName[1],
                                'nonctd_manufacturer' => $filesName[2],
                                'nonctd_stability' => $filesName[3],
                                'create_user' => $uid,
                                'form_status' => 'RE-NEW'
                            ]
                        );
                        if ($rs) {
                            return response()->json(["success" => "Record Save Successfully"]);
                        } else {
                            return response()->json(["error" => "Record Not Saved, Please contact administrator",]);
                        }
                    } else {
                        return response()->json(["error" => "Current Status Not Approved or Already Renew or Renew Only Possible If Finish Product Code"]);
                    }
                } else {
                    return response()->json(["error" => "Already Inserted"]);
                }
            }
            else {

                // Insert Data with non CTD
                $filesName = ExpoDatabaseController::checkNonCtdFiles($request, $nonctd_api_source, $non_fp_spec, $non_manufacturer, $non_stability);
                $v_local_pcode = $DataArray[0]->local_pcode;
                $v_exp_country = $DataArray[0]->exp_country;
                $v_ex_product_name = $DataArray[0]->expo_product_name;
                $v_ex_pack_size = $DataArray[0]->pack_size;

                $v_exist = DB::select(" select count(*) cnt from MIS.EXPO_INFO where product_code = ? and brand_name = ? and export_country = ? and pack_size = ?", [$v_local_pcode, $v_ex_product_name, $v_exp_country, $v_ex_pack_size]);

                if ($v_exist[0]->cnt > 0) {
                    return response()->json(["error" => "Record Not Saved, Already Inserted.",]);
                } else {
                    $sequence = DB::getSequence();
                    $line_id = $sequence->nextValue('MIS.SEQ_EXPO_INFO');
                    $rs = DB::table('MIS.EXPO_INFO')->insert(
                        [
                            'line_id' => $line_id,
                            'status' => $DataArray[0]->status,
                            'plant_id' => $DataArray[0]->plant_id,
                            'finish_product_code' => $DataArray[0]->finish_product,
                            'product_code' => $DataArray[0]->local_pcode,
                            'brand_name' => $DataArray[0]->brand_name,
                            'export_country' => $DataArray[0]->exp_country,
                            'expo_product_name' => $DataArray[0]->expo_product_name,
                            'product_generic' => $DataArray[0]->gen_name,
                            'pack_size' => $DataArray[0]->pack_size,
                            'company_agent_name' => $DataArray[0]->com_agent,
                            'contact_name' => $DataArray[0]->contact_name,
                            'address' => $DataArray[0]->address,
                            'im_team' => $DataArray[0]->im_team,
                            'submitted_to_im' => $im_submitted_date,
                            'sub_name' => $DataArray[0]->sub_name,
                            'sub_by_ira' => $DataArray[0]->sub_by_ira,
                            'dossier_type' => $type_of_dossier,
                            'nonctd_api_source' => $filesName[0],
                            'nonctd_fp_spec' => $filesName[1],
                            'nonctd_manufacturer' => $filesName[2],
                            'nonctd_stability' => $filesName[3],
                            'create_user' => $uid,
                            'form_status' => 'NEW'
                        ]
                    );
                    if ($rs) {
                        return response()->json(["success" => "Record Save Successfully"]);
                    } else {
                        return response()->json(["error" => "Record Not Saved, Already Inserted.",]);
                    }
                }
            }
        }
        //END NON CTD

        //CTD Working
        else if ($type_of_dossier == 'CTD') {
            $ctd_api_source = "";
            $ctd_fp_spec = "";
            $ctd_manufacturer = "";
            $ctd_stability = "";
            //            $fiCode = DB::select("select count(*) cnt from MIS.EXPO_INFO where finish_product_code = ?", [$DataArray[0]->finish_product]);
            $v_local_pcode = $DataArray[0]->local_pcode;
            $v_exp_country = $DataArray[0]->exp_country;
            $v_ex_product_name = $DataArray[0]->expo_product_name;
            $v_ex_pack_size = $DataArray[0]->pack_size;
            $v_exist = DB::select(" select count(*) cnt from MIS.EXPO_INFO where product_code = ? and brand_name = ? and export_country = ? and pack_size = ?", [$v_local_pcode, $v_ex_product_name, $v_exp_country, $v_ex_pack_size]);
//            $v_exist = DB::select(" select count(*) cnt from MIS.EXPO_INFO where product_code = ? and brand_name = ? and export_country = ? ", [$v_local_pcode, $v_ex_product_name, $v_exp_country]);

            if ($v_exist[0]->cnt > 0) {
                $uid = Auth::user()->user_id;
                $DataArray = json_decode($request->DataArray);
                $im_submitted_date = Carbon::parse($DataArray[0]->sub_to_im_date)->format('Y-m-d');
                $sequence = DB::getSequence();
                $line_id = $sequence->nextValue('MIS.SEQ_EXPO_INFO');
                if ($DataArray[0]->status == 'Edit') {

                    $MAX_line_id = DB::select("select max(line_id) line_id from MIS.EXPO_INFO where product_code = ? and brand_name = ? and export_country = ? ", [$v_local_pcode, $v_ex_product_name, $v_exp_country]);

                    $filesName = ExpoDatabaseController::checkCtdFiles($request, $ctd_api_source, $ctd_fp_spec, $ctd_manufacturer, $ctd_stability);
                    $rs = ExpoInfo::where('product_code', $DataArray[0]->local_pcode)
                        ->where('export_country', $DataArray[0]->exp_country)
                        ->where('line_id', $MAX_line_id[0]->line_id)
                        ->update([
                            'status' => $DataArray[0]->status,
                            'im_team' => $DataArray[0]->im_team,
                            'submitted_to_im' => $im_submitted_date,
                            'sub_name' => $DataArray[0]->sub_name,
                            'sub_by_ira' => $DataArray[0]->sub_by_ira,
                            'dossier_type' => $DataArray[0]->type_of_dossier,
                            'api_type' => $DataArray[0]->api_type,
                            'ctd_api_source' => $filesName[0],
                            'ctd_fp_spec' => $filesName[1],
                            'ctd_manufacturer' => $filesName[2],
                            'ctd_stability' => $filesName[3],
                            'nonctd_api_source' => '',
                            'nonctd_fp_spec' => '',
                            'nonctd_manufacturer' => '',
                            'nonctd_stability' => '',
                            'pv' => $DataArray[0]->type_pv,
                            'impurity_of_fp' => $DataArray[0]->impurity,
                            'ctdp_match' => $DataArray[0]->type_cdp,
                            'ctd_study' => $DataArray[0]->beStudy,
                            'updated_at' => $sys_time,
                            'update_user' => $uid
                        ]);
                    if ($rs) {
                        return response()->json(["success" => "Record Update Successfully"]);
                    } else {
                        return response()->json(["error" => "Record Not Saved, Please contact administrator",]);
                    }

                }
                else if ($DataArray[0]->status == 'Renew') {

                    $filesName = ExpoDatabaseController::checkCtdFiles($request, $ctd_api_source, $ctd_fp_spec, $ctd_manufacturer, $ctd_stability);

            //                    $fiCode = DB::select("select count(*) cnt from MIS.EXPO_INFO
            //                                where finish_product_code = ?
            //                                and current_status = 'Approved'
            //                                and current_status not in ('Rejected,Pending') ", [$DataArray[0]->finish_product]);

                    $insertLineId = DB::select(" select line_id from ( select line_id,product_code,current_status from mis.expo_info where finish_product_code = ? order by line_id desc ) where rownum <= 1", [$DataArray[0]->finish_product]);

                    $fiCode = DB::select(" select count(*) cnt from mis.expo_info where line_id = ? and current_status = 'REG' ", [$insertLineId[0]->line_id]);


                    if ($fiCode[0]->cnt > 0) {
                        $rs = DB::table('MIS.EXPO_INFO')->insert(
                            [
                                'line_id' => $line_id,
                                'status' => $DataArray[0]->status,
                                'plant_id' => $DataArray[0]->plant_id,
                                'finish_product_code' => $DataArray[0]->finish_product,
                                'product_code' => $DataArray[0]->local_pcode,
                                'brand_name' => $DataArray[0]->brand_name,
                                'export_country' => $DataArray[0]->exp_country,
                                'expo_product_name' => $DataArray[0]->expo_product_name,
                                'product_generic' => $DataArray[0]->gen_name,
                                'pack_size' => $DataArray[0]->pack_size,
                                'company_agent_name' => $DataArray[0]->com_agent,
                                'contact_name' => $DataArray[0]->contact_name,
                                'address' => $DataArray[0]->address,
                                'im_team' => $DataArray[0]->im_team,
                                'submitted_to_im' => $im_submitted_date,
                                'sub_name' => $DataArray[0]->sub_name,
                                'sub_by_ira' => $DataArray[0]->sub_by_ira,
                                'dossier_type' => $DataArray[0]->type_of_dossier,
                                'api_type' => $DataArray[0]->api_type,
                                'ctd_api_source' => $filesName[0],
                                'ctd_fp_spec' => $filesName[1],
                                'ctd_manufacturer' => $filesName[2],
                                'ctd_stability' => $filesName[3],
                                'pv' => $DataArray[0]->type_pv,
                                'impurity_of_fp' => $DataArray[0]->impurity,
                                'ctdp_match' => $DataArray[0]->type_cdp,
                                'ctd_study' => $DataArray[0]->beStudy,
                                'create_user' => $uid,
                                'form_status' => 'RE-NEW'
                            ]
                        );
                        if ($rs) {
                            return response()->json(["success" => "Record Save Successfully"]);
                        } else {
                            return response()->json(["error" => "Record Not Saved, Please contact administrator",]);
                        }
                    } else {
                        return response()->json(["error" => "Current Status Not Approved or Already Renew or Renew Only Possible If Finish Product Code"]);
                    }
                } else {
                    return response()->json(["error" => "Already Inserted"]);
                }
            } else {


                $filesName = ExpoDatabaseController::checkCtdFiles($request, $ctd_api_source, $ctd_fp_spec, $ctd_manufacturer, $ctd_stability);
                $v_local_pcode = $DataArray[0]->local_pcode;
                $v_exp_country = $DataArray[0]->exp_country;
                $v_ex_product_name = $DataArray[0]->expo_product_name;
                $v_ex_pack_size = $DataArray[0]->pack_size;
                $v_exist = DB::select(" select count(*) cnt from MIS.EXPO_INFO where product_code = ? and brand_name = ? and export_country = ? and pack_size = ?", [$v_local_pcode, $v_ex_product_name, $v_exp_country, $v_ex_pack_size]);
//                $v_exist = DB::select(" select count(*) cnt from MIS.EXPO_INFO where product_code = ? and brand_name = ? and export_country = ? ", [$v_local_pcode, $v_ex_product_name, $v_exp_country]);

                if ($v_exist[0]->cnt > 0) {
                    return response()->json(["error" => "Record Not Saved, Already Inserted"]);
                } else {

                    $sequence = DB::getSequence();
                    $line_id = $sequence->nextValue('MIS.SEQ_EXPO_INFO');


                    $rs = DB::table('MIS.EXPO_INFO')->insert(
                        [
                            'line_id' => $line_id,
                            'status' => $DataArray[0]->status,
                            'plant_id' => $DataArray[0]->plant_id,
                            'finish_product_code' => $DataArray[0]->finish_product,
                            'product_code' => $DataArray[0]->local_pcode,
                            'brand_name' => $DataArray[0]->brand_name,
                            'export_country' => $DataArray[0]->exp_country,
                            'expo_product_name' => $DataArray[0]->expo_product_name,
                            'product_generic' => $DataArray[0]->gen_name,
                            'pack_size' => $DataArray[0]->pack_size,
                            'company_agent_name' => $DataArray[0]->com_agent,
                            'contact_name' => $DataArray[0]->contact_name,
                            'address' => $DataArray[0]->address,
                            'im_team' => $DataArray[0]->im_team,
                            'submitted_to_im' => $im_submitted_date,
                            'sub_name' => $DataArray[0]->sub_name,
                            'sub_by_ira' => $DataArray[0]->sub_by_ira,
                            'dossier_type' => $DataArray[0]->type_of_dossier,
                            'api_type' => $DataArray[0]->api_type,
                            'ctd_api_source' => $filesName[0],
                            'ctd_fp_spec' => $filesName[1],
                            'ctd_manufacturer' => $filesName[2],
                            'ctd_stability' => $filesName[3],
                            'pv' => $DataArray[0]->type_pv,
                            'impurity_of_fp' => $DataArray[0]->impurity,
                            'ctdp_match' => $DataArray[0]->type_cdp,
                            'ctd_study' => $DataArray[0]->beStudy,
                            'create_user' => $uid,
                            'form_status' => 'NEW'
                        ]
                    );
                    if ($rs) {
                        return response()->json(["success" => "Record Save Successfully"]);
                    } else {
                        return response()->json(["error" => "Record Not Saved, Please contact administrator",]);
                    }
                }

            }
        }
        //CTD Working END

        //RE-Used CTD Working
        else if ($type_of_dossier == 'REUSED_CTD') {
            $reuse_ctd_api_source = "";
            $reuse_ctd_fp_spec = "";
            $reuse_ctd_manufacturer = "";
            $reuse_ctd_stability = "";
            //            $fiCode = DB::select("select count(*) cnt from MIS.EXPO_INFO where finish_product_code = ?", [$DataArray[0]->finish_product]);
            $v_local_pcode = $DataArray[0]->local_pcode;
            $v_exp_country = $DataArray[0]->exp_country;
            $v_ex_product_name = $DataArray[0]->expo_product_name;
            $v_ex_pack_size = $DataArray[0]->pack_size;
            $v_exist = DB::select(" select count(*) cnt from MIS.EXPO_INFO where product_code = ? and brand_name = ? and export_country = ? and pack_size = ?", [$v_local_pcode, $v_ex_product_name, $v_exp_country, $v_ex_pack_size]);
//            $v_exist = DB::select(" select count(*) cnt from MIS.EXPO_INFO where product_code = ? and brand_name = ? and export_country = ? ", [$v_local_pcode, $v_ex_product_name, $v_exp_country]);

            if ($v_exist[0]->cnt > 0) {
                $uid = Auth::user()->user_id;
                $DataArray = json_decode($request->DataArray);
                $im_submitted_date = Carbon::parse($DataArray[0]->sub_to_im_date)->format('Y-m-d');
                $sequence = DB::getSequence();
                $line_id = $sequence->nextValue('MIS.SEQ_EXPO_INFO');
                if ($DataArray[0]->status == 'Edit') {

                    $MAX_line_id = DB::select("select max(line_id) line_id from MIS.EXPO_INFO where product_code = ? and brand_name = ? and export_country = ? ", [$v_local_pcode, $v_ex_product_name, $v_exp_country]);

                    $filesName = ExpoDatabaseController::checkReuseCtdFiles($request, $reuse_ctd_api_source, $reuse_ctd_fp_spec, $reuse_ctd_manufacturer, $reuse_ctd_stability);
                    $rs = ExpoInfo::where('product_code', $DataArray[0]->local_pcode)
                        ->where('export_country', $DataArray[0]->exp_country)
                        ->where('line_id', $MAX_line_id[0]->line_id)
                        ->update([
                            'status' => $DataArray[0]->status,
                            'im_team' => $DataArray[0]->im_team,
                            'submitted_to_im' => $im_submitted_date,
                            'sub_name' => $DataArray[0]->sub_name,
                            'sub_by_ira' => $DataArray[0]->sub_by_ira,
                            'dossier_type' => $DataArray[0]->type_of_dossier,
                            'reuse_api_type' => $DataArray[0]->reuse_api_type,
                            'ctd_api_source' => '',
                            'ctd_fp_spec' => '',
                            'ctd_manufacturer' => '',
                            'ctd_stability' => '',
                            'reuse_ctd_api_source' => $filesName[0],
                            'reuse_ctd_fp_spec' => $filesName[1],
                            'reuse_ctd_manufacturer' => $filesName[2],
                            'reuse_ctd_stability' => $filesName[3],
                            'nonctd_api_source' => '',
                            'nonctd_fp_spec' => '',
                            'nonctd_manufacturer' => '',
                            'nonctd_stability' => '',
                            'reuse_pv' => $DataArray[0]->reuse_type_pv,
                            'reuse_impurity_of_fp' => $DataArray[0]->reuse_impurity,
                            'reuse_ctdp_match' => $DataArray[0]->reuse_type_cdp,
                            'reuse_ctd_study' => $DataArray[0]->reuse_beStudy,
                            'updated_at' => $sys_time,
                            'update_user' => $uid
                        ]);
                    if ($rs) {
                        return response()->json(["success" => "Record Update Successfully"]);
                    } else {
                        return response()->json(["error" => "Record Not Saved, Please contact administrator",]);
                    }

                }
                else if ($DataArray[0]->status == 'Renew') {

                    $filesName = ExpoDatabaseController::checkReuseCtdFiles($request, $reuse_ctd_api_source, $reuse_ctd_fp_spec, $reuse_ctd_manufacturer, $reuse_ctd_stability);

                                //                    $fiCode = DB::select("select count(*) cnt from MIS.EXPO_INFO
                                //                                where finish_product_code = ?
                                //                                and current_status = 'Approved'
                                //                                and current_status not in ('Rejected,Pending') ", [$DataArray[0]->finish_product]);

                    $insertLineId = DB::select(" select line_id from ( select line_id,product_code,current_status from mis.expo_info where finish_product_code = ? order by line_id desc ) where rownum <= 1", [$DataArray[0]->finish_product]);

                    $fiCode = DB::select(" select count(*) cnt from mis.expo_info where line_id = ? and current_status = 'REG' ", [$insertLineId[0]->line_id]);


                    if ($fiCode[0]->cnt > 0) {
                        $rs = DB::table('MIS.EXPO_INFO')->insert(
                            [
                                'line_id' => $line_id,
                                'status' => $DataArray[0]->status,
                                'plant_id' => $DataArray[0]->plant_id,
                                'finish_product_code' => $DataArray[0]->finish_product,
                                'product_code' => $DataArray[0]->local_pcode,
                                'brand_name' => $DataArray[0]->brand_name,
                                'export_country' => $DataArray[0]->exp_country,
                                'expo_product_name' => $DataArray[0]->expo_product_name,
                                'product_generic' => $DataArray[0]->gen_name,
                                'pack_size' => $DataArray[0]->pack_size,
                                'company_agent_name' => $DataArray[0]->com_agent,
                                'contact_name' => $DataArray[0]->contact_name,
                                'address' => $DataArray[0]->address,
                                'im_team' => $DataArray[0]->im_team,
                                'submitted_to_im' => $im_submitted_date,
                                'sub_name' => $DataArray[0]->sub_name,
                                'sub_by_ira' => $DataArray[0]->sub_by_ira,
                                'dossier_type' => $DataArray[0]->type_of_dossier,
                                'reuse_api_type' => $DataArray[0]->api_type,
                                'reuse_ctd_api_source' => $filesName[0],
                                'reuse_ctd_fp_spec' => $filesName[1],
                                'reuse_ctd_manufacturer' => $filesName[2],
                                'reuse_ctd_stability' => $filesName[3],
                                'reuse_pv' => $DataArray[0]->reuse_pv,
                                'reuse_impurity_of_fp' => $DataArray[0]->reuse_impurity_of_fp,
                                'reuse_ctdp_match' => $DataArray[0]->reuse_ctdp_match,
                                'reuse_ctd_study' => $DataArray[0]->reuse_ctd_study,
                                'create_user' => $uid,
                                'form_status' => 'RE-NEW'
                            ]
                        );
                        if ($rs) {
                            return response()->json(["success" => "Record Save Successfully"]);
                        } else {
                            return response()->json(["error" => "Record Not Saved, Please contact administrator",]);
                        }
                    } else {
                        return response()->json(["error" => "Current Status Not Approved or Already Renew or Renew Only Possible If Finish Product Code"]);
                    }
                } else {
                    return response()->json(["error" => "Already Inserted"]);
                }
            }

            else {


                $filesName = ExpoDatabaseController::checkReuseCtdFiles($request, $reuse_ctd_api_source, $reuse_ctd_fp_spec, $reuse_ctd_manufacturer, $reuse_ctd_stability);
                $v_local_pcode = $DataArray[0]->local_pcode;
                $v_exp_country = $DataArray[0]->exp_country;
                $v_ex_product_name = $DataArray[0]->expo_product_name;
                $v_ex_pack_size = $DataArray[0]->pack_size;
                $v_exist = DB::select(" select count(*) cnt from MIS.EXPO_INFO where product_code = ? and brand_name = ? and export_country = ? and pack_size = ?", [$v_local_pcode, $v_ex_product_name, $v_exp_country, $v_ex_pack_size]);
//                $v_exist = DB::select(" select count(*) cnt from MIS.EXPO_INFO where product_code = ? and brand_name = ? and export_country = ? ", [$v_local_pcode, $v_ex_product_name, $v_exp_country]);



                if ($v_exist[0]->cnt > 0) {
                    return response()->json(["error" => "Record Not Saved, Already Inserted"]);
                } else {

                    $sequence = DB::getSequence();
                    $line_id = $sequence->nextValue('MIS.SEQ_EXPO_INFO');


                    $rs = DB::table('MIS.EXPO_INFO')->insert(
                        [
                            'line_id' => $line_id,
                            'status' => $DataArray[0]->status,
                            'plant_id' => $DataArray[0]->plant_id,
                            'finish_product_code' => $DataArray[0]->finish_product,
                            'product_code' => $DataArray[0]->local_pcode,
                            'brand_name' => $DataArray[0]->brand_name,
                            'export_country' => $DataArray[0]->exp_country,
                            'expo_product_name' => $DataArray[0]->expo_product_name,
                            'product_generic' => $DataArray[0]->gen_name,
                            'pack_size' => $DataArray[0]->pack_size,
                            'company_agent_name' => $DataArray[0]->com_agent,
                            'contact_name' => $DataArray[0]->contact_name,
                            'address' => $DataArray[0]->address,
                            'im_team' => $DataArray[0]->im_team,
                            'submitted_to_im' => $im_submitted_date,
                            'sub_name' => $DataArray[0]->sub_name,
                            'sub_by_ira' => $DataArray[0]->sub_by_ira,
                            'dossier_type' => $DataArray[0]->type_of_dossier,
                            'reuse_api_type' => $DataArray[0]->reuse_api_type,
                            'reuse_ctd_api_source' => $filesName[0],
                            'reuse_ctd_fp_spec' => $filesName[1],
                            'reuse_ctd_manufacturer' => $filesName[2],
                            'reuse_ctd_stability' => $filesName[3],
                            'reuse_pv' => $DataArray[0]->reuse_type_pv,
                            'reuse_impurity_of_fp' => $DataArray[0]->reuse_impurity,
                            'reuse_ctdp_match' => $DataArray[0]->reuse_type_cdp,
                            'reuse_ctd_study' => $DataArray[0]->reuse_beStudy,
                            'create_user' => $uid,
                            'form_status' => 'NEW'
                        ]
                    );
                    if ($rs) {
                        return response()->json(["success" => "Record Save Successfully"]);
                    } else {
                        return response()->json(["error" => "Record Not Saved, Please contact administrator",]);
                    }
                }

            }
        }
        //Re-Used END CTD Working

        // without CTD and NON-CTD files
        else {
            $sequence = DB::getSequence();
            $line_id = $sequence->nextValue('MIS.SEQ_EXPO_INFO');
            $fiCode = DB::select("select count(*) cnt from MIS.EXPO_INFO where finish_product_code = ?", [$DataArray[0]->finish_product]);
            //Finish Product code Exist
            if ($fiCode[0]->cnt > 0) {
                $uid = Auth::user()->user_id;
                $DataArray = json_decode($request->DataArray);
                $im_submitted_date = Carbon::parse($DataArray[0]->sub_to_im_date)->format('Y-m-d');
                if ($DataArray[0]->status == 'Edit') {

                    $MAX_line_id = DB::select("select max(line_id) line_id from MIS.EXPO_INFO where finish_product_code = ? ", [$DataArray[0]->finish_product]);
                    $rs = ExpoInfo::where('finish_product_code', $DataArray[0]->finish_product)
                        ->where('line_id', $MAX_line_id[0]->line_id)
                        ->update([
                            'status' => $DataArray[0]->status,
                            'im_team' => $DataArray[0]->im_team,
                            'submitted_to_im' => $im_submitted_date,
                            'sub_name' => $DataArray[0]->sub_name,
                            'sub_by_ira' => $DataArray[0]->sub_by_ira,
                            'dossier_type' => $DataArray[0]->type_of_dossier,
                            'api_type' => '',
                            'ctd_api_source' => '',
                            'ctd_fp_spec' => '',
                            'ctd_manufacturer' => '',
                            'ctd_stability' => '',
                            'nonctd_api_source' => '',
                            'nonctd_fp_spec' => '',
                            'nonctd_manufacturer' => '',
                            'nonctd_stability' => '',
                            'pv' => '',
                            'impurity_of_fp' => '',
                            'ctdp_match' => '',
                            'ctd_study' => '',
                            'updated_at' => $sys_time,
                            'update_user' => $uid
                        ]);
                    if ($rs) {
                        return response()->json(["success" => "Record Update Successfully"]);
                    } else {
                        return response()->json(["error" => "Record Not Saved, Please contact administrator",]);
                    }

                }
                else if ($DataArray[0]->status == 'Renew') {
                    //                    $fiCode = DB::select("select count(*) cnt from MIS.EXPO_INFO
                    //                                where finish_product_code = ?
                    //                                and current_status = 'Approved'
                    //                                and current_status not in ('Rejected,Pending') ", [$DataArray[0]->finish_product]);

                    $insertLineId = DB::select(" select line_id from ( select line_id,product_code,current_status from mis.expo_info where finish_product_code = ? order by line_id desc ) where rownum <= 1", [$DataArray[0]->finish_product]);

                    $fiCode = DB::select(" select count(*) cnt from mis.expo_info where line_id = ? and current_status = 'REG' ", [$insertLineId[0]->line_id]);


                    if ($fiCode[0]->cnt > 0) {
                        $rs = DB::table('MIS.EXPO_INFO')->insert(
                            [
                                'line_id' => $line_id,
                                'status' => $DataArray[0]->status,
                                'renew_status' => 'YES',
                                'plant_id' => $DataArray[0]->plant_id,
                                'finish_product_code' => $DataArray[0]->finish_product,
                                'product_code' => $DataArray[0]->local_pcode,
                                'brand_name' => $DataArray[0]->brand_name,
                                'export_country' => $DataArray[0]->exp_country,
                                'expo_product_name' => $DataArray[0]->expo_product_name,
                                'product_generic' => $DataArray[0]->gen_name,
                                'pack_size' => $DataArray[0]->pack_size,
                                'company_agent_name' => $DataArray[0]->com_agent,
                                'contact_name' => $DataArray[0]->contact_name,
                                'address' => $DataArray[0]->address,
                                'im_team' => $DataArray[0]->im_team,
                                'submitted_to_im' => $im_submitted_date,
                                'sub_name' => $DataArray[0]->sub_name,
                                'sub_by_ira' => $DataArray[0]->sub_by_ira,
                                'dossier_type' => $type_of_dossier,
                                'create_user' => $uid,
                                'form_status' => 'RE-NEW'
                            ]
                        );
                        if ($rs) {
                            return response()->json(["success" => "Record Save Successfully"]);
                        } else {
                            return response()->json(["error" => "Record Not Saved, Please contact administrator",]);
                        }

                    } else {
                        return response()->json(["error" => "Current Status Not Approved or Already Renew or Renew Only Possible If Finish Product Code"]);
                    }
                } else {
                    return response()->json(["error" => "Already Inserted"]);
                }
            } // Finish Product code Empty
            else {
                $cnt_status = DB::select(" select count(*) cnt from MIS.EXPO_INFO where product_code = ? and brand_name = ? and export_country = ? and expo_product_name = ? ", [$DataArray[0]->local_pcode, $DataArray[0]->brand_name, $DataArray[0]->exp_country, $DataArray[0]->expo_product_name]);
                $lines = DB::select(" select max(line_id) line_id from mis.expo_info where product_code = ? and brand_name = ? and export_country = ? and expo_product_name = ? ", [$DataArray[0]->local_pcode, $DataArray[0]->brand_name, $DataArray[0]->exp_country, $DataArray[0]->expo_product_name]);


                if ($DataArray[0]->status == 'Renew') {

                    $fiCode = DB::select("select count(*) cnt from MIS.EXPO_INFO
                                where finish_product_code = ?
                                and current_status = 'Approved'
                                 and current_status not in ('Rejected,Pending')", [$DataArray[0]->finish_product]);
                    if ($fiCode[0]->cnt > 0) {
                        $rs = DB::table('MIS.EXPO_INFO')->insert(
                            [
                                'line_id' => $line_id,
                                'status' => $DataArray[0]->status,
                                'renew_status' => 'YES',
                                'plant_id' => $DataArray[0]->plant_id,
                                'finish_product_code' => $DataArray[0]->finish_product,
                                'product_code' => $DataArray[0]->local_pcode,
                                'brand_name' => $DataArray[0]->brand_name,
                                'export_country' => $DataArray[0]->exp_country,
                                'expo_product_name' => $DataArray[0]->expo_product_name,
                                'product_generic' => $DataArray[0]->gen_name,
                                'pack_size' => $DataArray[0]->pack_size,
                                'company_agent_name' => $DataArray[0]->com_agent,
                                'contact_name' => $DataArray[0]->contact_name,
                                'address' => $DataArray[0]->address,
                                'im_team' => $DataArray[0]->im_team,
                                'submitted_to_im' => $im_submitted_date,
                                'sub_name' => $DataArray[0]->sub_name,
                                'sub_by_ira' => $DataArray[0]->sub_by_ira,
                                'dossier_type' => $type_of_dossier,
                                'create_user' => $uid,
                                'form_status' => 'RE-NEW'
                            ]
                        );
                        if ($rs) {
                            return response()->json(["success" => "Record Save Successfully"]);
                        } else {
                            return response()->json(["error" => "Record Not Saved"]);
                        }
                    } else {
                        return response()->json(["error" => "Current Status Not Approved or Already Renew or Renew Only Possible If Finish Product Code"]);
                    }

                } // Update
                else if ($DataArray[0]->status == 'Edit') {
                    if ($cnt_status[0]->cnt > 0) {
                        $rs = ExpoInfo::where('line_id', $lines[0]->line_id)
                            ->update([
                                'status' => $DataArray[0]->status,
                                'finish_product_code' => $DataArray[0]->finish_product,
                                'im_team' => $DataArray[0]->im_team,
                                'submitted_to_im' => $im_submitted_date,
                                'sub_name' => $DataArray[0]->sub_name,
                                'sub_by_ira' => $DataArray[0]->sub_by_ira,
                                'dossier_type' => $DataArray[0]->type_of_dossier,
                                'api_type' => '',
                                'ctd_api_source' => '',
                                'ctd_fp_spec' => '',
                                'ctd_manufacturer' => '',
                                'ctd_stability' => '',
                                'nonctd_api_source' => '',
                                'nonctd_fp_spec' => '',
                                'nonctd_manufacturer' => '',
                                'nonctd_stability' => '',
                                'pv' => '',
                                'impurity_of_fp' => '',
                                'ctdp_match' => '',
                                'ctd_study' => '',
                                'updated_at' => $sys_time,
                                'update_user' => $uid
                            ]);
                        if ($rs) {
                            //update Expo Country wise finish product column
                            if (!empty($DataArray[0]->finish_product)) {
                                ExpoDatabaseController::countryWiseProductCodeUpdate($DataArray[0]->local_pcode, $DataArray[0]->brand_name,
                                    $DataArray[0]->exp_country, $DataArray[0]->com_agent, $DataArray[0]->finish_product, $sys_time, $uid);
                            }
                            return response()->json(["success" => "Record Update Successfully"]);
                        } else {
                            return response()->json(["error" => "Record Not Saved"]);
                        }


                    }
                }
                else {

                    $cnt_status = DB::select(" select count(*) cnt from MIS.EXPO_INFO where product_code = ? and brand_name = ? and export_country = ? and expo_product_name = ? ", [$DataArray[0]->local_pcode, $DataArray[0]->brand_name, $DataArray[0]->exp_country, $DataArray[0]->expo_product_name]);

//                    //Log::info($cnt_status);

                    if ($cnt_status[0]->cnt > 0) {
                        return response()->json(["error" => "Already Inserted."]);
                    } else {
                        //insert
                        $rs = DB::table('MIS.EXPO_INFO')->insert(
                            [
                                'line_id' => $line_id,
                                'status' => $DataArray[0]->status,
                                'plant_id' => $DataArray[0]->plant_id,
                                'finish_product_code' => $DataArray[0]->finish_product,
                                'product_code' => $DataArray[0]->local_pcode,
                                'brand_name' => $DataArray[0]->brand_name,
                                'export_country' => $DataArray[0]->exp_country,
                                'expo_product_name' => $DataArray[0]->expo_product_name,
                                'product_generic' => $DataArray[0]->gen_name,
                                'pack_size' => $DataArray[0]->pack_size,
                                'company_agent_name' => $DataArray[0]->com_agent,
                                'contact_name' => $DataArray[0]->contact_name,
                                'address' => $DataArray[0]->address,
                                'im_team' => $DataArray[0]->im_team,
                                'submitted_to_im' => $im_submitted_date,
                                'sub_name' => $DataArray[0]->sub_name,
                                'sub_by_ira' => $DataArray[0]->sub_by_ira,
                                'dossier_type' => $type_of_dossier,
                                'create_user' => $uid,
                                'form_status' => 'NEW'
                            ]
                        );
                        if ($rs) {
                            return response()->json(["success" => "Record Insert Successfully"]);
                        } else {
                            return response()->json(["error" => "Record Not Saved, Please contact administrator"]);
                        }
                    }


                }
            }
        }



    }

    //stage -1 IM
    public function getStage1IM(Request $request)
    {
        $data = DB::select("
        select *
        from v_expolov
        where finish_product_code = '$request->finish_product'

        ");
        return response()->json($data);
    }

    //stage -1 IM Update
    public function updateStage1IM(Request $request)
    {

        $uid = Auth::user()->user_id;
        $sys_time = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');
        if(!empty($request->sub_to_agent_date)){
            $sub_to_agent_date = Carbon::parse($request->sub_to_agent_date)->format('Y-m-d');
        }else{
            $sub_to_agent_date = '';
        }

        if(!empty($request->sub_to_regulatory)){
            $sub_to_regulatory = Carbon::parse($request->sub_to_regulatory)->format('Y-m-d');
        }else{
            $sub_to_regulatory = '';
        }

        $v_local_pcode = $request->productCode;
        $v_ex_product_name = $request->brand_name;
        $v_exp_country = $request->exp_country;

        if (!empty($request->fi_code)) {
            $MAX_line_id = $MAX_line_id = DB::select("select max(line_id) line_id from MIS.EXPO_INFO where finish_product_code = ? ", [$request->fi_code]);
            $rs = ExpoInfo::where('finish_product_code', $request->fi_code)
                ->where('line_id', $MAX_line_id[0]->line_id)
                ->update([
                    'finish_product_code' => $request->fi_code,
                    'name_of_the_company_agent' => $request->name_of_comp_agent,
                    'submitted_to_agent' => $sub_to_agent_date,
                    'submitted_to_regularity' => $sub_to_regulatory,
                    'update_user_im_stage1' => $uid,
                    'update_date_im_stage1' => $sys_time
                ]);
            if ($rs) {
                return response()->json(["success" => "Record Update Successfully"]);
            } else {
                return response()->json(["error" => "Record Not Saved, Please contact administrator",]);
            }
        } else {
            $v_exist = DB::select(" select count(*) cnt
            from MIS.EXPO_INFO where product_code = ? 
            and brand_name = ? and export_country = ? ", [$v_local_pcode, $v_ex_product_name, $v_exp_country]);

            if ($v_exist[0]->cnt > 0) {

                $MAX_line_id = DB::select("select max(line_id) line_id from mis.expo_info where product_code = ? and brand_name = ? and export_country = ? ", [$v_local_pcode, $v_ex_product_name, $v_exp_country]);
                $rs = ExpoInfo::where('line_id', $MAX_line_id[0]->line_id)
                    ->update([
                        'name_of_the_company_agent' => $request->name_of_comp_agent,
                        'submitted_to_agent' => $sub_to_agent_date,
                        'submitted_to_regularity' => $sub_to_regulatory,
                        'update_user_im_stage1' => $uid,
                        'update_date_im_stage1' => $sys_time
                    ]);
                if ($rs) {
                    return response()->json(["success" => "Record Update Successfully"]);
                } else {
                    return response()->json(["error" => "Record Not Saved, Please contact administrator",]);
                }
            }
        }

    }

//stage -2 IRA Update
    public function updateStage2IRA(Request $request)
    {


        $uid = Auth::user()->user_id;
        $sys_time = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');
        $v_local_pcode = $request->lcpcode;
        $v_ex_product_name = $request->brand_name;
        $v_exp_country = $request->exp_country;

        if(!empty($request->ipdgdate)){
            $ipdgdate = Carbon::parse($request->ipdgdate)->format('Y-m-d');
        }else{
            $ipdgdate = '';
        }

        if(!empty($request->dgdateclose)){
            $dgdateclose = Carbon::parse($request->dgdateclose)->format('Y-m-d');
        }else{
            $dgdateclose = '';
        }


        if (!empty($request->fi_code)) {
            $MAX_line_id = DB::select("select max(line_id) line_id from MIS.EXPO_INFO where finish_product_code = ? ", [$request->fi_code]);

            $rs = ExpoInfo::where('finish_product_code', $request->fi_code)
                ->where('line_id', $MAX_line_id[0]->line_id)
                ->update([
                    'finish_product_code' => $request->fi_code,
                    'in_process_def_gen' => $request->ipdg,
                    'in_process_dg_date' => $ipdgdate,
                    'dg_date_close' => $dgdateclose,
                    'dg_comments' => $request->dg_comments,
                    'def_gen_close' => $request->def_gen_close,
                    'inprocess' => $request->inprocess,
                    'update_user_ira_stage2' => $uid,
                    'update_date_ira_stage2' => $sys_time
                ]);

                if($request->inprocess == 'YES'){
                    ExpoInfo::where('finish_product_code', $request->fi_code)
                        ->where('line_id', $MAX_line_id[0]->line_id)
                        ->update([
                            'current_status' => 'In-Process',
                        ]);
                }

            if ($rs) {
                return response()->json(["success" => "Record Update Successfully"]);
            } else {
                return response()->json(["error" => "Record Not Saved, Please contact administrator",]);
            }
        } else {


            $v_exist = DB::select(" select count(*) cnt
            from MIS.EXPO_INFO where product_code = ? 
            and brand_name = ? and export_country = ? ", [$v_local_pcode, $v_ex_product_name, $v_exp_country]);


            if ($v_exist[0]->cnt > 0) {
                $MAX_line_id = DB::select("select max(line_id) line_id from mis.expo_info where product_code = ? and brand_name = ? and export_country = ? ", [$v_local_pcode, $v_ex_product_name, $v_exp_country]);
                $rs = ExpoInfo::where('line_id', $MAX_line_id[0]->line_id)
                    ->update([
                        'in_process_def_gen' => $request->ipdg,
                        'in_process_dg_date' => $ipdgdate,
                        'dg_date_close' => $dgdateclose,
                        'dg_comments' => $request->dg_comments,
                        'def_gen_close' => $request->def_gen_close,
                        'inprocess'     => $request->inprocess,
                        'update_user_ira_stage2' => $uid,
                        'update_date_ira_stage2' => $sys_time
                    ]);

                // Log::info($rs);

                if($request->inprocess == 'YES'){
                    ExpoInfo::where('line_id', $MAX_line_id[0]->line_id)
                        ->update([
                            'current_status' => 'In-Process',
                        ]);
                }


                if ($rs) {
                    return response()->json(["success" => "Record Update Successfully"]);
                } else {
                    return response()->json(["error" => "Record Not Saved, Please contact administrator",]);
                }
            }else{
                return response()->json(["error" => "Record Not Saved, Please contact administrator",]); 
            }
        }


    }

    //stage -2 IM Update
    public function UPDATE_STAGE2_IM(Request $request)
    {

        $box = $request->all();
        $myValue = array();
        parse_str($box['data'], $myValue);


//        Log::info($myValue);

        $fi_code = $box['fi_code'];
        $v_local_pcode = $box['lcpcode'];
        $v_ex_product_name = $box['brand_name'];
        $v_exp_country = $box['exp_country'];
        $v_regShelfLifeProductOthers = $box['regShelfLifeProductOthers'];

//        Log::info($fi_code);
//        Log::info($v_local_pcode);
//        Log::info($v_ex_product_name);
//        Log::info($v_exp_country);

        $uid = Auth::user()->user_id;
        $sys_time = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');
        $line_path = "";
        $destinationPath = public_path() . '/IRA_PDF/RegistrationCertificate/';
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            $filenameWithExt = $files[0]->getClientOriginalName();
            foreach ($files as $file) {//this statement will loop through all files.
                $file_name = $file->getClientOriginalName(); //Get file original name//Log::info($file);
                $file->move($destinationPath, $file_name); // move files to destination folder
            }
            $line_path = '/IRA_PDF/RegistrationCertificate/' . $filenameWithExt;
        }

        $mah_date = '';
        $wfr_date = '';
        $approval_date = '';
        $expiry_date = '';
        $rejection_date = '';
        $launched_date = '';
        $variation_date = '';
        $var_granted_refused_date = '';
        $var_granted_refused = '';
        $reg_number = '';
        $im_2_remarks = '';
        $curr_status = '';

        if(!empty($myValue['mah_date'])){
            $mah_date = Carbon::parse($myValue['mah_date'])->format('Y-m-d');
        }
        if (!empty($myValue['wfr_date'])){
            $wfr_date = Carbon::parse($myValue['wfr_date'])->format('Y-m-d');
        }
        if (!empty($myValue['approval_date'])){
            $approval_date = Carbon::parse($myValue['approval_date'])->format('Y-m-d');
        }
        if (!empty($myValue['expiry_date'])){
            $expiry_date = Carbon::parse($myValue['expiry_date'])->format('Y-m-d');
        }
        if (!empty($myValue['rejection_date'])){
            $rejection_date = Carbon::parse($myValue['rejection_date'])->format('Y-m-d');
        }
        if (!empty($myValue['launched_date'])){
            $launched_date = Carbon::parse($myValue['launched_date'])->format('Y-m-d');
        }
        if (!empty($myValue['variation_date'])){
            $variation_date = Carbon::parse($myValue['variation_date'])->format('Y-m-d');
        }
        if (!empty($myValue['variation_date'])){
            $var_granted_refused_date = Carbon::parse($myValue['var_granted_refused_date'])->format('Y-m-d');
        }

        if (!empty($myValue['var_granted_refused'])){
            $var_granted_refused = $myValue['var_granted_refused'];
        }
        if (!empty($myValue['reg_number'])){
            $reg_number = $myValue['reg_number'];
        }
        if (!empty($myValue['curr_status'])){
            $curr_status = $myValue['curr_status'];
        }


        $regSelfLifeProd = null;
        if($myValue['reg_shelf_life_product'] == 'other'){
            $regSelfLifeProd =$v_regShelfLifeProductOthers;
        }else{
            $regSelfLifeProd = $myValue['reg_shelf_life_product'];
        }



        if (!empty($fi_code)) {
            $MAX_line_id = DB::select("select max(line_id) line_id from MIS.EXPO_INFO where finish_product_code = ? ", [$fi_code]);
            $rs = ExpoInfo::where('line_id', $MAX_line_id[0]->line_id)
                ->update([
                    'dropped_by_agent_mah' => $mah_date,
                    'withdrawal_form_ra_date' => $wfr_date,
                    'approval_date' => $approval_date,
                    'registration_number' => $reg_number,
                    'expiry_renewal_date' => $expiry_date,
//                    'registration_certificate' => $myValue['reg_certificate'],
                    'reg_cert_path' => $line_path,
                    'rejection_date' => $rejection_date,
                    'reg_shelf_life_product' => $regSelfLifeProd,
                    'launched_date' => $launched_date,
                    'variation_date' => $variation_date,
                    'variation_granted_refused' => $var_granted_refused,
                    'variation_granted_Refused_date' => $var_granted_refused_date,
                    'im_2_remarks' => $im_2_remarks,
                    'current_status' => $curr_status,
                    'update_user_im_stage2' => $uid,
                    'update_date_im_stage2' => $sys_time
                ]);
            if ($rs) {
                return response()->json(["success" => "Record Update Successfully"]);
            } else {
                return response()->json(["error" => "Record Not Saved, Please contact administrator",]);
            }
        } else {

            $v_exist = DB::select(" select count(*) cnt
            from MIS.EXPO_INFO where product_code = ? 
            and brand_name = ? and export_country = ? ", [$v_local_pcode, $v_ex_product_name, $v_exp_country]);
            if ($v_exist[0]->cnt > 0) {
                $MAX_line_id = DB::select("select max(line_id) line_id from mis.expo_info where product_code = ? and brand_name = ? and export_country = ? ", [$v_local_pcode, $v_ex_product_name, $v_exp_country]);
                $rs = ExpoInfo::where('finish_product_code', $fi_code)
                    ->where('line_id', $MAX_line_id[0]->line_id)
                    ->update([
                        'dropped_by_agent_mah' => $mah_date,
                        'withdrawal_form_ra_date' => $wfr_date,
                        'approval_date' => $approval_date,
                        'registration_number' => $reg_number,
                        'expiry_renewal_date' => $expiry_date,
//                        'registration_certificate' => $myValue['reg_certificate'],
                        'reg_cert_path' => $line_path,
                        'rejection_date' => $rejection_date,
                        'reg_shelf_life_product' => $regSelfLifeProd,
                        'launched_date' => $launched_date,
                        'variation_date' => $variation_date,
                        'variation_granted_refused' => $var_granted_refused,
                        'variation_granted_Refused_date' => $var_granted_refused_date,
                        'im_2_remarks' => $im_2_remarks,
                        'current_status' => $curr_status,
                        'update_user_im_stage2' => $uid,
                        'update_date_im_stage2' => $sys_time
                    ]);
                if ($rs) {
                    return response()->json(["success" => "Record Update Successfully"]);
                } else {
                    return response()->json(["error" => "Record Not Saved, Please contact administrator",]);
                }
            }
        }
    }

    //stage - 3 IRA update
    public function UPDATE_STAGE3_IRA(Request $request){

        $box = $request->all();
        $myValue = array();
        parse_str($box['data'], $myValue);


//        Log::info($myValue);

        $fi_code = $box['fi_code'];
        $v_local_pcode = $box['lcpcode'];
        $v_ex_product_name = $box['brand_name'];
        $v_exp_country = $box['exp_country'];

//
//        Log::info($fi_code);
//        Log::info($v_local_pcode);
//        Log::info($v_ex_product_name);
//        Log::info($v_exp_country);

        $uid = Auth::user()->user_id;
        $sys_time = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');

        if (!empty($fi_code)) {
            $MAX_line_id = DB::select("select max(line_id) line_id from MIS.EXPO_INFO where finish_product_code = ? ", [$fi_code]);
            $rs = ExpoInfo::where('line_id', $MAX_line_id[0]->line_id)
                ->update([

                    'SPL_INSTRUCTION' => $myValue['spl_instruction'],
                    'POST_MARKETING_COMMITMENTS' => $myValue['pmc'],
                    'TIME_REQ_FOR_REG' => $myValue['time_req_for_reg'],
                    'REMARKS_BY_IRA' => $myValue['remarks_by_ira'],
                    'update_user_ira_stage3' => $uid,
                    'update_date_ira_stage3' => $sys_time
                ]);
            if ($rs) {
                return response()->json(["success" => "Record Update Successfully"]);
            } else {
                return response()->json(["error" => "Record Not Saved, Please contact administrator",]);
            }
        } else {

            $v_exist = DB::select(" select count(*) cnt
            from MIS.EXPO_INFO where product_code = ? 
            and brand_name = ? and export_country = ? ", [$v_local_pcode, $v_ex_product_name, $v_exp_country]);
            if ($v_exist[0]->cnt > 0) {
                $MAX_line_id = DB::select("select max(line_id) line_id from mis.expo_info where product_code = ? and brand_name = ? and export_country = ? ", [$v_local_pcode, $v_ex_product_name, $v_exp_country]);
                $rs = ExpoInfo::where('finish_product_code', $fi_code)
                    ->where('line_id', $MAX_line_id[0]->line_id)
                    ->update([
                        'SPL_INSTRUCTION' => $myValue['spl_instruction'],
                        'POST_MARKETING_COMMITMENTS' => $myValue['pmc'],
                        'TIME_REQ_FOR_REG' => $myValue['time_req_for_reg'],
                        'REMARKS_BY_IRA' => $myValue['remarks_by_ira'],
                        'update_user_ira_stage3' => $uid,
                        'update_date_ira_stage3' => $sys_time
                    ]);
                if ($rs) {
                    return response()->json(["success" => "Record Update Successfully"]);
                } else {
                    return response()->json(["error" => "Record Not Saved, Please contact administrator",]);
                }
            }
        }


    }


}
