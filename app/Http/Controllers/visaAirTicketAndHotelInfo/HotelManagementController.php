<?php


namespace App\Http\Controllers\visaAirTicketAndHotelInfo;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class HotelManagementController extends Controller
{
    /*Main Method*/
    public function viewHotelManagement(Request $request)
    {

        $allguest = DB::select("select distinct GUEST_NAME,REFERENCE from MIS.HOTEL_INFO_SYSTEM order by GUEST_NAME");

        $allEmp = DB::select("select distinct emp_id,sur_name from hrms.emp_information@WEB_TO_HRMS
                            where com_id=1 order by emp_id");

        $companyData = DB::select("select distinct com_id,com_name,sap_com_id from hrms.company_info@WEB_TO_HRMS where sap_com_id='1000' ");

        return view('visaAirTicketAndHotel.hotelManagement', ['companyData' => $companyData,'allEmp' => $allEmp,'allEmployee' => $allguest]);
    }

    public function saveHotelInfoSystem(Request $request)
    {

        $uid = Auth::user()->user_id;
        $date = Carbon::now()->format('Y-m-d H:m:s');
        $dataList = json_decode($request->dataListObject, true);


        $dataList['create_user'] = $uid;
        $dataList['create_date'] = $date;

        $status = DB::table('MIS.HOTEL_INFO_SYSTEM')->insert($dataList);

        if ($status) {
            return response()->json(['result'=>'success']);
        } else {
            return response()->json(['result'=>'error']);

        }
    }



    public function getDataTableData(Request $request)
    {
        $guest_name = $request->guest_name;
        $allGuest = DB::select("select  * from MIS.HOTEL_INFO_SYSTEM where guest_name='$guest_name' order by guest_name");

        if ($allGuest) {
            return response()->json(['result'=>$allGuest]);
        } else {
            return response()->json(['result'=>'error']);

        }
    }



    public function getEmpInfo(Request $request){
        $emp_id = $request->employee_id;

        $allEmpData = DB::select("SELECT DISTINCT dgi.DESIG_NAME,dgi.DESIG_ID,imf.EMP_ID,imf.SUR_NAME,dpi.dept_id,dpi.dept_name,pi.plant_id,pi.plant_name FROM  hrms.emp_information@WEB_TO_HRMS imf,
       hrms.dept_information@WEB_TO_HRMS dpi, hrms.plant_info@WEB_TO_HRMS pi , hrms.EMP_DESIGNATION@WEB_TO_HRMS dgi  where imf.DEPT_ID = dpi.DEPT_ID  and  pi.plant_id = imf.plant_id 
       and  dgi.DESIG_ID = imf.DESIG_ID  and imf.EMP_ID='$emp_id' AND imf.com_id=1");

        return response()->json(
            ['allEmpData' => $allEmpData]
        );
    }



    public function updateHotelManagementData(Request $request)
    {

        $table_id = $request->id;
        $decoded_data = json_decode($request->itemArray);

        $GUEST_NAME = $decoded_data->edit_guest_name;
        $REFERENCE = $decoded_data->edit_reference;
        $COUNTRY = $decoded_data->edit_country;
        $HOTEL_NAME = $decoded_data->edit_hotel_name;
        $CHECK_IN_DATE = $decoded_data->edit_check_in;
        $CHECK_OUT_DATE = $decoded_data->edit_check_out;
        $ROOM_TYPE = $decoded_data->edit_room_type;
        $DURATION_OF_STAY = $decoded_data->edit_duration;
        $PAYMENT_BY = $decoded_data->edit_payment_by;
        $INVOICE_NO = $decoded_data->edit_invoice_no;
        $INVOICE_DATE = $decoded_data->edit_invoice_date;
        $INVOICE_AMOUNT = $decoded_data->edit_invoice_amount;
        $PAYMENT_DATE = $decoded_data->edit_payment_date;
        $PAYMENT_AMOUNT = $decoded_data->edit_payment_amount;
        $PAYMENT_STATUS = $decoded_data->edit_payment_status;
        $REMARKS = $decoded_data->edit_remarks;


        $uid = Auth::user()->user_id;
        $date = Carbon::now()->format('Y-m-d H:m:s');


            $result =  DB::UPDATE("
                        UPDATE MIS.HOTEL_INFO_SYSTEM
                        SET
                            GUEST_NAME = '$GUEST_NAME',
                            REFERENCE = '$REFERENCE',
                            COUNTRY = '$COUNTRY',
                            HOTEL_NAME = '$HOTEL_NAME',
                            CHECK_IN_DATE = '$CHECK_IN_DATE',
                            CHECK_OUT_DATE = '$CHECK_OUT_DATE',
                            ROOM_TYPE = '$ROOM_TYPE',
                            DURATION_OF_STAY = '$DURATION_OF_STAY',
                            PAYMENT_BY = '$PAYMENT_BY',
                            INVOICE_NO = '$INVOICE_NO',
                            INVOICE_DATE = '$INVOICE_DATE',
                            INVOICE_AMOUNT = '$INVOICE_AMOUNT',
                            PAYMENT_DATE = '$PAYMENT_DATE',
                            PAYMENT_AMOUNT = '$PAYMENT_AMOUNT',
                            PAYMENT_STATUS = '$PAYMENT_STATUS',
                            REMARKS = '$REMARKS',
                            UPDATE_DATE = '$date',
                            UPDATE_USER = '$uid'
                        WHERE ID = '$table_id'
                        ");


            if($result){
                return response()->json(['result'=> 'success']);
            }else{
                return response()->json(['result'=> "error"]);
            }



    }


    //delete and update emp ext data
    public function deleteHotelManagementData(Request $request){

        $id = $request->id;


        if($id != ""){
            $result =  DB::DELETE('DELETE FROM MIS.HOTEL_INFO_SYSTEM WHERE ID = ?',[$id]);
            if($result){

                return response()->json(['status'=> 'success']);

            }else{
                return response()->json(['status'=> 'false']);
            }

        }else{
            return response()->json(['status'=> 2]);
        }
    }

}