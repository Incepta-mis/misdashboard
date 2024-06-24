<?php


namespace App\Http\Controllers\Travel;


use App\Http\Controllers\Controller;
use App\Model\Travel\TravelLocalAdjustment;
use App\Model\Travel\TravelLocalAdjustmentDetails;
use App\Model\Travel\TravelLocalAdvanceApproved;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

class LocalTravelAdjustmentController extends Controller
{
    public function index()
    {
        return view('travel.local.adjustmentForm');
    }

    public function getMyLocalAdjustmentDocumentNO(Request $request)
    {
        $document_no = DB::select("select distinct la.document_no 
        from mis.travel_local_advance la
        where la.emp_id = '$request->emp_id'
        minus
        select distinct document_no
        from mis.travel_local_adjustment
        where emp_id = '$request->emp_id'
        and adjustment_details ='YES'");
        return response()->json($document_no);
    }

    public function getMyLocalAdvanceData(Request $request)
    {
        $travels = DB::select(" select * from mis.travel_local_advance where emp_id = '$request->emp_id' and document_no = '$request->document_no' ");
        return response()->json($travels);
    }

    public function storeAdjustment(Request $request)
    {
        $uid = Auth::user()->user_id;
        $input = $request->all();
        $location = '';
        $amount = 0;
        $empReporters = DB::select(" select distinct sup_emp_id,dept_head_emp_id from mis.travel_emp_master where emp_id = '$uid' ");

        for ($i = 0; $i <= count($input['accommodation']); $i++) {
            if (empty($input['accommodation'][$i]) || !is_numeric($input['accommodation'][$i])) continue;
            $location = $location . ' #' . $input['from_loc'][$i] . '->' . $input['to_loc'][$i] . ' ( ' . $input['from_time'][$i] . ' -> ' . $input['to_time'][$i] . ') ';
            $amount = $amount + $input['linetotal'][$i];

            $data = [
                'id' => $input['id'][$i],
                'document_no' => $input['document_no'],
                'emp_id' => $input['emp_id'][$i],
                'emp_name' => $input['emp_name'][$i],
                'grade' => $input['grade'][$i],
                'desig_name' => $input['desig_name'][$i],
                'dept_name' => $input['dept_name'][$i],
                'purpose' => $input['purpose'][$i],
                'cost_center_id' => $input['cost_center_id'][$i],
                'cost_center_name' => $input['cost_center_name'][$i],
                'gl_code' => $input['gl_code'][$i],
                'from_loc' => $input['from_loc'][$i],
                'to_loc' => $input['to_loc'][$i],
                'destination' => $input['destination'][$i],
                'from_time' => Carbon::createFromFormat('d/m/Y, H:i:s A', strtoupper($input['from_time'][$i]))->toDateTimeString(),
                'to_time' => Carbon::createFromFormat('d/m/Y, H:i:s A', strtoupper($input['to_time'][$i]))->toDateTimeString(),
                'days' => $input['days'][$i],
                'accommodation' => $input['accommodation'][$i],
                'meals' => $input['meals'][$i],
                'incidentals' => $input['incidentals'][$i],
                'da' => $input['da'][$i],
                'means_of_transport' => $input['means_of_transport'][$i],
                'transport' => $input['transport'][$i],
                'others' => $input['others'][$i],
                'linetotal' => $input['linetotal'][$i],
                'created_at' => Carbon::now(),
                'create_user' => $input['emp_id'][$i]
            ];

//            dd($data);

            $processexist = TravelLocalAdjustment::select('*')
                ->where('id', $input['id'][$i])
                ->where('to_loc', $input['to_loc'][$i])
                ->first();
            if ($processexist == null)//if doesn't exist: create
            {
                $processes = TravelLocalAdjustment::create($data);
            } else //if exist: update
            {
                $processes = TravelLocalAdjustment::where('id', $input['id'][$i])
                    ->where('to_loc', $input['to_loc'][$i])
                    ->update($data);
            }

        }

        $request->session()->flash('alert-success', 'Travel record added successfully!');
        return redirect()->route("local.adjustment");
    }

    // Local Travel Adjustment Details
    public function adjustmentDetailsIndex()
    {
        return view('travel.local.adjustmentFormDetails');
    }

    public function getAdjustDocumentNo(Request $request)
    {
        $document_no = DB::select("select distinct document_no
        from mis.travel_local_adjustment
        where emp_id = '$request->emp_id'
        and adjustment_details is null");
        return response()->json($document_no);
    }


    public function getAdjustment(Request $request)
    {
        $adjustment = TravelLocalAdjustment::where('emp_id', $request->emp_id)
            ->where('document_no', $request->document_no)->get();
        return response()->json($adjustment);
    }

    public function storeAdjustmentDetails(Request $request)
    {
//        dd($request->all());


        $uid = Auth::user()->user_id;
        $input = $request->all();
        $location = '';
        $amount = 0;
        $empReporters = DB::select(" select distinct sup_emp_id,dept_head_emp_id from mis.travel_emp_master where emp_id = '$uid' ");


        $this->validate($request, [
            'filename' => 'required|mimes:pdf|max:4096'
        ]);

        if ($request->hasfile('filename')) {

            $uniqueFileName = uniqid() . '_' . $request->filename->getClientOriginalName();

            $file = $request->filename->move(public_path('travelDocuments/local'), $uniqueFileName);

            if ($file) {
                $dataFile = [
                    'document_no' => $input['document_no'],
                    'attachment' => $uniqueFileName
                ];
                $insertFile = DB::table('MIS.TRAVEL_LOCAL_ADJUST_DOCUMENT')->insert($dataFile);
                if ($insertFile) {
                    for ($j = 0; $j < count($input['id']); $j++) {
                        DB::table('mis.travel_local_adjustment')
                            ->where('id', $input['id'][$j])
                            ->update(['adjustment_details' => 'YES']);
                    }

                    for ($i = 0; $i <= count($input['date']); $i++) {
                        if (empty($input['date'][$i])) continue;
                        $amount = $amount + $input['linetotal'][$i];

                        $data = [
                            'id' => $input['idx'][$i],
                            'document_no' => $input['document_no'],
                            'days' => Carbon::createFromFormat('d/m/Y', strtoupper($input['date'][$i])),
                            'accommodation' => $input['accommodation'][$i],
                            'breakfast' => $input['accommodation'][$i],
                            'launch' => $input['launch'][$i],
                            'dinner' => $input['dinner'][$i],
                            'snacks' => $input['snacks'][$i],
                            'rw_to_bus' => $input['rw_to_bus'][$i],
                            'bus_to_rw' => $input['bus_to_rw'][$i],
                            'lc' => $input['lc'][$i],
                            'da' => $input['da'][$i],
                            'transport' => $input['transport'][$i],
                            'tips' => $input['tips'][$i],
                            'miscellaneous' => $input['miscellaneous'][$i],
                            'linetotal' => $input['linetotal'][$i],
                            'remarks' => $input['remarks'][$i],
                            'created_at' => Carbon::now(),
                            'create_user' => $uid
                        ];

                        try {
                            $travels = TravelLocalAdjustmentDetails::create($data);
                        } catch (Oci8Exception $exceptione) {
                            dd($exceptione->getMessage());
                        }
                    }

                    $sequence = DB::getSequence();
                    $id = $sequence->nextValue('MIS.TRAVEL_LOCAL_ID_SEQ');

                    $empData = DB::select(" select distinct emp_id,emp_name, listagg ((' #'|| from_loc || '->' || to_loc || ' ( ' ||to_char(from_time,'DD/MM/RRRR HH24:MI:SS AM') ||'->'|| to_char(to_time,'DD/MM/RRRR HH24:MI:SS AM ') ||')'), ' ') within group (order by (' #'|| from_loc || '->' || to_loc || ' ( ' ||to_char(from_time,'DD/MM/RRRR HH24:MI:SS AM') ||'->'|| to_char(to_time,'DD/MM/RRRR HH24:MI:SS AM ') ||')')) location from mis.travel_local_adjustment where document_no = '10101125804' group by emp_id,emp_name ");

                    $dataApproved = [
                        'id' => $id,
                        'document_no' => $input['document_no'],
                        'emp_id' => $empData[0]->emp_id,
                        'emp_name' => $empData[0]->emp_name,
                        'location' => $empData[0]->location,
                        'amount' => $amount,
                        'sup_id' => $empReporters[0]->sup_emp_id,
                        'dept_head_id' => $empReporters[0]->dept_head_emp_id,
                        'created_at' => Carbon::now(),
                        'create_user' => $uid,
                        'status' => 'Adjustment'
                    ];
                    TravelLocalAdvanceApproved::create($dataApproved);

                    return redirect()->back()->with('alert-danger', 'Travel Details Save Successfully.');
                }

            }

        }
    }

}