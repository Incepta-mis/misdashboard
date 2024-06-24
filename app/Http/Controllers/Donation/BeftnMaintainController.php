<?php

namespace App\Http\Controllers\Donation;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class BeftnMaintainController extends Controller
{
    public function index()
    {
        $beneficiary = DB::select("select distinct BENEFICIARY_ID  from donation_beftn_master order by BENEFICIARY_ID asc");
        $territory = DB::select("select distinct territory_code  from donation_beftn_master order by territory_code asc");

        $data = array();
        $data['beneficiary'] = $beneficiary;
        $data['territory'] = $territory;

        return view('donation.beftn_maintain')->with('display_data',$data);
    }
    public function uploadDataFromExcel()
    {   $date = Carbon::now()->format('Y-m-d H:m:s');
        $uid = Auth::user()->user_id;
        $file_name = Input::file('upload_file');

        //validation
        $rules = array('upload_file' => 'required'); //'required'
        $msg = array('upload_file.required' => 'This field is required');
        $validator_empty = Validator::make(array('upload_file' => $file_name), $rules, $msg);

        if ($validator_empty->fails()) {
             $notification = array(
                'message' => 'Please upload a file!',
                'alert-type' => 'error'
            );
            return Redirect::to('donation/beftn_maintain')->withErrors($validator_empty)->with($notification);
        }else if ($validator_empty->passes()) {
            $ext = strtolower($file_name->getClientOriginalExtension());
            $validator = Validator::make(
                array('ext' => $ext),
                array('ext' => 'in:xls,xlsx')
            );
            if ($validator->fails()) {
                // send back to the page with the input data and errors
                $notification = array(
                    'message' => 'Please Upload excel file!',
                    'alert-type' => 'error'
                );
                return Redirect::to('donation/beftn_maintain')->withErrors($validator)->with($notification);
            } else if ($validator->passes()) {
                $data = Excel::load($file_name, function ($reader) {
                })->get();

                // dd($data);

                if (!empty($data) && $data->count()) {
                    foreach ($data as $key => $value) {

                        $uniqueData[] = [
                            'territory_code' => trim($value->territory_code),
                            'beneficiary_id' => trim($value->beneficiary_id)
                        ];


                        $insert[] = [
                            'territory_code' => trim($value->territory_code),
                            'beneficiary_id' => trim($value->beneficiary_id),
                            'd_name' => trim($value->d_name),
                            'beneficiary_id' => trim($value->beneficiary_id),
                            'beneficiary_name' => trim($value->beneficiary_name),
                            'beneficiary_contact_number' => trim($value->beneficiary_contact_number),
                            'beneficiary_bank_account_name' => trim($value->beneficiary_bank_account_name),
                            'bank_account_no' => trim($value->bank_account_no),
                            'bank_name' => trim($value->bank_name),
                            'bank_branch_name' => trim($value->bank_branch_name),
                            'routing_number' => trim($value->routing_number),

                            'account_holder_address' => trim($value->account_holder_address),
                            'rm_terr_id' => trim($value->rm_terr_id),
                            'rm_name' => trim($value->rm_name),
                            'dsm_name' => trim($value->dsm_name),

                            'remarks' => trim($value->remarks),
                            'created_by' => $uid
                            
                        ];
                    }

                    if (!empty($insert)) {
                        $count = count($insert);
                        $unique = array_map("unserialize", array_unique(array_map("serialize", $uniqueData)));
                        if($count > count($unique)){
                            $notification = array(
                                'message' => 'Duplicate data found in the excel file!',
                                'alert-type' => 'error'
                            );
                            return Redirect::to('donation/beftn_maintain')->with($notification);
                        }else{
                            
                                try {


                                    foreach($insert as $d){
                                        
                                        DB::table('donation_beftn_master')->updateOrInsert(
                                            ['beneficiary_id' => $d["beneficiary_id"]    ,
                                            'territory_code' => $d["territory_code"]
                                        ], 
                                            [
                                                'd_name' => $d["d_name"],  
                                                'beneficiary_id' => $d["beneficiary_id"], 
                                                'beneficiary_name' => $d["beneficiary_name"], 
                                                'beneficiary_contact_number' => $d["beneficiary_contact_number"], 
                                                'beneficiary_bank_account_name' => $d["beneficiary_bank_account_name"], 
                                                'bank_account_no' => $d["bank_account_no"], 
                                                'bank_name' =>  $d["bank_name"],
                                                'bank_branch_name' => $d["bank_branch_name"], 
                                                'routing_number' => $d["routing_number"], 
                                                'account_holder_address' => $d["account_holder_address"], 
                                                'rm_terr_id' => $d["rm_terr_id"],
                                                'rm_name' => $d["rm_name"], 
                                                'dsm_name' => $d["dsm_name"], 
                                                'remarks' => $d["remarks"], 
                                                'created_by' => $uid,
                                                'created_at' => $date
                                            ] 
                                            );

                                    }


                                    $notification = array(
                                        'message' => 'File Uploaded successfully! ',
                                        'alert-type' => 'success'
                                    );
                                    return Redirect::to('donation/beftn_maintain')->with($notification);

                                } catch (\Exception $ee) {

                                    // dd($ee->getMessage());

                                    DB::rollBack();
                                    $notification = array(
                                        'message' => 'Database Error!',
                                        'alert-type' => 'error'
                                    );
                                    return Redirect::to('donation/beftn_maintain')->with($notification);
                                }
                            
                        }
                    }else{
                        $notification = array(
                            'message' => 'upload excel column format not valid!',
                            'alert-type' => 'error'
                        );
                        return Redirect::to('donation/beftn_maintain')->with($notification);
                    }

                }
            }
        }
    }
    public function beftn_info(Request $request){

        $qryData = DB::select("select * from 
        (select a.*, 'ALL' all_data
        from
        donation_beftn_master a
        )
        where  
        '$request->terr_id' = case when '$request->terr_id' = 'ALL' then all_data else territory_code end
        and  '$request->ben_id' = case when '$request->ben_id' = 'ALL' then all_data else to_char(beneficiary_id)  end");
        return response()->json($qryData);
    }
   
    public function downloadFile(){
        // dd('test it');
        $file = storage_path("donation\Beftn_master.xlsx");

          return response()->download($file);
    }
 
}
