<?php


namespace App\Http\Controllers\Travel;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class TravelEmpMailController extends Controller
{

    public function generateEmpTravelPdf(Request $request){

        $user = $request->session()->get('empTravels');

        $employeeApprovedData = DB::select('select * from mis.travel_intl_req_appr where id = ?', [$user[0]->id]);

        $documentNo = $employeeApprovedData[0]->document_no;
        $empName = $employeeApprovedData[0]->emp_name;
        $empId = $employeeApprovedData[0]->emp_id;

        $empMasterData = DB::select('select * from mis.travel_emp_master where emp_id = ?', [$empId]);

        $empEmail = $empMasterData[0]->email;
        $empMobile = $empMasterData[0]->mobile_no;


//        $randVal = rand(1,999);


        $pdf = \PDF::loadView('travel.emails.intl.pdfFile.empTravels' ,compact('user','empEmail','empMobile'));
        $pdf->getDomPDF()->set_option('enable_html5_parser', true);
        $path = public_path('travelDocuments/international');
        $fileName =  'empTravels_'.$documentNo.'.pdf' ;
        $pdf->save($path . '/' . $fileName);

        $filePath = 'travelDocuments/international' . '/' . $fileName;

        DB::insert('insert into mis.travel_intl_documents (emp_id, document_no,file_path) values (?, ?, ?)',
            [$empId, $documentNo,$filePath]);

        $email_data = array(
            'url_link' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/intlReqHO/' . $empId . '/' . $documentNo,
            'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/intlReqHO/' . $empId . '/' . $documentNo,
            'empName' => $empName
        );


        Mail::send(['text' => 'travel.emails.intl.travel_emp_dtl'], $email_data, function ($message)
            use ( $path, $fileName, $empMasterData)
        {
            $message->to('rahnuma@inceptapharma.com', 'Rahnuma Momotaj')
                ->subject('International Travel Request');
            $message->from($empMasterData[0]->email, $empMasterData[0]->name);
            //Full path with the pdf name
            $message->attach($path . '/' . $fileName);
        });

        Mail::send(['text' => 'travel.emails.intl.travel_emp_dtl'], $email_data, function ($message)
            use ( $path, $fileName, $empMasterData)
        {
            $message->to('rabbi@inceptapharma.com', 'Kazi Md Akhai Rabbi')
                ->subject('International Travel Request');
            $message->from($empMasterData[0]->email, $empMasterData[0]->name);
            //Full path with the pdf name
            $message->attach($path . '/' . $fileName);
        });


    }
}