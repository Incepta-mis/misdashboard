<?php


namespace App\Http\Controllers\visaAirTicketAndHotelInfo;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class VisaAndAirTicketController extends Controller
{
    /*Main Method*/
    public function viewAirTicket(Request $request)
    {

        $allEmployee = DB::select("select distinct EMPLOYEE_NAME,EMPLOYEE_CODE from MIS.VISA_AIR_TICKET_INFO order by EMPLOYEE_CODE");

        $allEmp = DB::select("select distinct emp_id,sur_name from hrms.emp_information@WEB_TO_HRMS
                            order by emp_id");


        $companyData = DB::select("select distinct com_id,com_name,sap_com_id from hrms.company_info@WEB_TO_HRMS where sap_com_id='1000' ");

        return view('visaAirTicketAndHotel.visaAndAirTicket', ['companyData' => $companyData,'allEmp' => $allEmp,'allEmployee' => $allEmployee]);
    }

    public function getEmpInfo(Request $request){
        $emp_id = $request->employee_id;


      /*  $allEmpData = DB::select("SELECT DISTINCT dgi.DESIG_NAME,dgi.DESIG_ID,imf.EMP_ID,imf.SUR_NAME,dpi.dept_id,dpi.dept_name,pi.plant_id,pi.plant_name FROM  hrms.emp_information@WEB_TO_HRMS imf,
       hrms.dept_information@WEB_TO_HRMS dpi, hrms.plant_info@WEB_TO_HRMS pi , hrms.EMP_DESIGNATION@WEB_TO_HRMS dgi  where imf.DEPT_ID = dpi.DEPT_ID  and  pi.plant_id = imf.plant_id 
       and  dgi.DESIG_ID = imf.DESIG_ID  and imf.EMP_ID='$emp_id'");
*/



        $allEmpData = DB::select("SELECT DISTINCT mis.get_emp_desig('$emp_id') desig_name,dgi.DESIG_ID,imf.EMP_ID,imf.SUR_NAME,dpi.dept_id,dpi.dept_name,pi.plant_id,pi.plant_name FROM  hrms.emp_information@WEB_TO_HRMS imf,
       hrms.dept_information@WEB_TO_HRMS dpi, hrms.plant_info@WEB_TO_HRMS pi , hrms.EMP_DESIGNATION@WEB_TO_HRMS dgi  where imf.DEPT_ID = dpi.DEPT_ID  and  pi.plant_id = imf.plant_id 
       and  dgi.DESIG_ID = imf.DESIG_ID  and imf.EMP_ID='$emp_id'");


        return response()->json(
            ['allEmpData' => $allEmpData]
        );
    }



    public function saveAirTicketData(Request $request)
    {

        $uid = Auth::user()->user_id;
        $date = Carbon::now()->format('Y-m-d H:m:s');
        $dataList = json_decode($request->dataListObject, true);


        $dataList['create_user'] = $uid;
        $dataList['create_date'] = $date;

         $employee_code =$dataList['employee_code'];

        $companyData = DB::select("select distinct EMPLOYEE_CODE from MIS.VISA_AIR_TICKET_INFO where EMPLOYEE_CODE='$employee_code'");

        if($companyData){

            return response()->json(['result'=>'exists']);
        }


        $status = DB::table('MIS.VISA_AIR_TICKET_INFO')->insert($dataList);

        if ($status) {
            return response()->json(['result'=>'success']);
        } else {
            return response()->json(['result'=>'error']);

        }
    }


      public function getDataTableData(Request $request)
    {

        $emp_code = $request->employee_code;
        $allEmployeedata = DB::select("select distinct * from MIS.VISA_AIR_TICKET_INFO where EMPLOYEE_CODE='$emp_code' order by EMPLOYEE_CODE");

        if ($allEmployeedata) {
            return response()->json(['result'=>$allEmployeedata]);
        } else {
            return response()->json(['result'=>'error']);

        }
    }


    public function updateAirTicketData(Request $request)
    {


        $table_id = $request->id;
        $decoded_data = json_decode($request->itemArray);

        $gl = $decoded_data->gl;
        $cc = $decoded_data->cc;
        $td_no = $decoded_data->td_no;
        $td_date = $decoded_data->td_date;
        $destination = $decoded_data->destination;
        $estimation_cost = $decoded_data->estimation_cost;
        $departure_date = $decoded_data->departure_date;
        $arrival_date = $decoded_data->arrival_date;
        $carrier = $decoded_data->carrier;
        $sector = $decoded_data->sector;
        $classes = $decoded_data->classes;
        $airline_names = $decoded_data->airline_names;
        $agency = $decoded_data->agency;
        $invoice_no = $decoded_data->invoice_no;
        $invoice_date = $decoded_data->invoice_date;
        $ticket_cost = $decoded_data->ticket_cost;
        $visa_cost = $decoded_data->visa_cost;
        $hotel_cost = $decoded_data->hotel_cost;
        $tax_cost = $decoded_data->tax_cost;
        $total_amount = $decoded_data->total_amount;
        $payment_date = $decoded_data->payment_date;
        $payment_amount = $decoded_data->payment_amount;
        $due_amount = $decoded_data->due_amount;
        $payment_status=$decoded_data->payment_status;
        $bill_ref = $decoded_data->bill_ref;
        $remarks = $decoded_data->remarks;



        $uid = Auth::user()->user_id;
        $date = Carbon::now()->format('Y-m-d H:m:s');


       /* $departure_date = $decoded_data->departure_date;
        $arrival_date = $decoded_data->arrival_date;
        $carrier = $decoded_data->carrier;
        $sector = $decoded_data->sector;
        $classes = $decoded_data->classes;
        $airline_names = $decoded_data->airline_names;
        $agency = $decoded_data->agency;
        $invoice_no = $decoded_data->invoice_no;
        $invoice_date = $decoded_data->invoice_date;
        $ticket_cost = $decoded_data->ticket_cost;
        $visa_cost = $decoded_data->visa_cost;
        $hotel_cost = $decoded_data->hotel_cost;
        $tax_cost = $decoded_data->tax_cost;
        $total_amount = $decoded_data->total_amount;
        $payment_date = $decoded_data->payment_date;
        $payment_amount = $decoded_data->payment_amount;
        $due_amount = $decoded_data->due_amount;
        $bill_ref = $decoded_data->bill_ref;
        $remarks = $decoded_data->remarks;*/





            $result =  DB::UPDATE("
                        UPDATE MIS.VISA_AIR_TICKET_INFO
                        SET
                            GL = '$gl',
                            CC = '$cc',
                            TD_NO = '$td_no',
                            TD_DATE = '$td_date',
                            DESTINATION = '$destination',
                            ESTIMATION_COST = '$estimation_cost',
                            DEPARTURE_DATE = '$departure_date',
                            ARRIVAL_DATE = '$arrival_date',
                            CARRIER = '$carrier',
                            SECTOR = '$sector',
                            CLASSES = '$classes',
                            AIRLINE_NAMES = '$airline_names',
                            AGENCY = '$agency',
                            INVOICE_NO = '$invoice_no',
                            INVOICE_DATE = '$invoice_date',
                            TICKET_COST = '$ticket_cost',
                            VISA_COST = '$visa_cost',
                            HOTEL_COST = '$hotel_cost',
                            TAX_COST = '$tax_cost',
                            TOTAL_AMOUNT = '$total_amount',
                            PAYMENT_DATE = '$payment_date',
                            PAYMENT_AMOUNT = '$payment_amount',
                            DUE_AMOUNT = '$due_amount',
                            PAYMENT_STATUS = '$payment_status',
                            BILL_REF = '$bill_ref',
                            REMARKS = '$remarks',
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
    public function deleteAirTicketData(Request $request){

        $id = $request->id;
        $company_code = $request->company_code;

        if($id != ""){
            $result =  DB::DELETE('DELETE FROM MIS.VISA_AIR_TICKET_INFO WHERE ID = ?',[$id]);
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