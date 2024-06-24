<?php

/**
 * Developer: Md. Raqib Hasan
 * Emp.Code: 1012064
 * For: Issuing of Batch Document
 */

namespace App\Http\Controllers\ibatchdoc;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use PHPExcel_Worksheet_Drawing;
use setasign\Fpdi\Fpdi;


class IssuingBatchDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // static $path_z = '//192.168.5.6/Master_Controlled_Documents';
    // static $path_d = '//192.168.20.4/Master_Controlled_Documents';
    static $imgpath = 'public/site_resource/images/ibd_img/';

    public function index()
    {
        $plant = DB::select('Select emp_plant||unit emp_plant from mis.dashboard_users_info where user_id = ?',[Auth::user()->user_id]);
        $folder_path = DB::select('Select  substr(folder_path, instr(folder_path,\'/\', -1) + 1) folder_path 
            from mis.ibd_folder_info where plant_id||unit = ?',[$plant[0]->emp_plant]);

        return view('issuing_batch_doc.ibdoc_home')->with(['folder_pt' => $folder_path]);
    }

    public function getInitialFolders()
    {
        try{
//            $selectedFolder = ['Active-SCAs', 'Active-MARs', 'Active-BPRs', 'Active-BMRs'];
//
//            $dir    = "//192.168.36.41/Donation query";
//            $folders = scandir($dir, 1);

//
//            dd($folders);


            $folders = scandir($this->getPlantWisePath(), 1);




            // \\192.168.36.20\Shared Folder\ADS

            // Log::info("Masroor");
            // Log::info($this->getPlantWisePath());
            // Log::info($folders);



//            dd($this->getPlantWisePath());

            $results = [];
            sort($folders);

            foreach ($folders as $folder) {
                //Log::info(substr($folder,strpos($folder,'.')));
//                if (in_array($folder, $selectedFolder)) {
                if($folder !== '..' && $folder !== '.'){
                    if (substr($folder, strrpos($folder, '.') + 1) === 'pdf') {
                        $results[] = ['text' => $folder . '|' . url($this::$imgpath . 'pdf1.png'),
                            'order' => 1];
                    } else {
                        $results[] = ['text' => $folder . '|' . url($this::$imgpath . 'folder2.png') . '|...',
                            'order' => 2];
                    }
                }
//                }
            }

            return response()->json($results);
        }catch(\Exception $ex){
            return response()->json($ex->getMessage());
        }

    }

    public function handleClick(Request $request)
    {
        $results = [];
        $path = $this->getPlantWisePath();

        if ($request->type === 'd') {
            $results = scandir($path . '/' . $request->text, 1);
            if (count($results) > 1) {
                $results = $this->filterResults($results, $path . '/' . $request->text);
            }
        } else {
            $request[]['status'] = 'Files handle later';
        }
        return response()->json($results);
    }

    public function filterResults($arr, $path = '')
    {
        $results = [];
        foreach ($arr as $a) {
            if (!in_array($a, ['..', '.'])) {
                //Log::info(strpos($a,'.'));
                $index = strrpos($a, '.');
                if ($index) {
                    if (substr($a, $index + 1) === 'pdf') {

                        $path = substr($path,-1) !== '/' ? $path.'/':$path;
//                        Log::info($path);
                        $filepath = $path . $a;
                        $results[] = ['text' => $a . '|' . url($this::$imgpath . 'pdf1.png') . '||' . $filepath,
                            'order' => 1];
                    }
                } else {
                    $results[] = ['text' => $a . '|' . url($this::$imgpath . 'folder2.png') . '|...',
                        'order' => 2];
                }
            }
        }

        usort($results, function ($item1, $item2) {
            return $item2['order'] > $item1['order'];
        });

        //Log::info($results);
        return $results;
    }

    public function navigateback(Request $request)
    {
        $path = $path = $this->getPlantWisePath();
        $navs = explode("/", $request->text);

        //Log::info($request->text);

        $navs = array_filter($navs, function ($val) {
            return !is_null($val) && $val !== '';
        });

//        $selectedFolder = ['Active-SCAs', 'Active-MARs', 'Active-BPRs', 'Active-BMRs'];
        $results = [];

        if (count($navs) === 1) {
            $folders = scandir($path, 1);
            sort($folders);
            foreach ($folders as $folder) {
                //Log::info(substr($folder,strpos($folder,'.')));
//                if (in_array($folder, $selectedFolder)) {
                if($folder !== '..' && $folder !== '.') {
                    if (substr($folder, strrpos($folder, '.') + 1) === 'pdf') {
                        $results[] = ['text' => $folder . '|' . url($this::$imgpath . 'pdf1.png'), 'order' => 1];
                    } else {
                        $results[] = ['text' => $folder . '|' . url($this::$imgpath . 'folder2.png') . '|...',
                            'order' => 2];
                    }
                }
//                }
            }

            return response()->json(['result' => $results, 'url' => [], 'root' => 'Y']);
        } else {
//            Log::info($navs);
            array_pop($navs);
            $results = scandir($path . '/' . implode($navs, '/'), 1);
            if (count($results) > 1) {
                $results = $this->filterResults($results, $path . '/' . implode($navs, '/'));
            }

            //Log::info($results);
            return response()->json(['result' => $results, 'url' => implode($navs, '/'), 'root' => 'F']);
        }

    }

    public function saveprint_log(Request $request)
    {
        try {
            $data = [
                'PRINT_DT' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                'FILE_NAME' => substr($request->document, strrpos($request->document, '/') + 1),
                'PRINTED_BY' => Auth::user()->user_id,
                'PAGES' => $request->page,
                'PRINT_TYPE' => $request->print_type == 'I' ? 'Initial' : 'Reprint',
                'REASON' => $request->reason,
                'BATCH' => $request->batch
            ];

            $status = DB::table('mis.ibd_print_log')->insert($data);
            $username = DB::select('select name from mis.dashboard_users_info where user_id = ?',[Auth::user()->user_id]);

            $data['NAME'] = $username[0]->name;
            $uri = '';
            if($status){
                $uri = $this->fetchAndConvert($request->document,$data);
            }

            return response()->json(['status' => $status,'uri'=>$uri]);

        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['status' => -1, 'error' => $e->getMessage()]);
        }
    }

    public function fetchAndConvert($filepath,$evals)
    {
        $localPath = '';
        $status = '';
        $fileName = '';

        //Log::info($evals);

        try {
            $fileName = substr($filepath, strrpos($filepath, '/') + 1);
            $localPath = public_path('/ibd_documents/' .$evals['PRINTED_BY'].'_'. $fileName);

            $status = File::copy($filepath, $localPath);
            //Log::info($status);

            $this->process($localPath, $fileName,$evals);

            if(File::exists(public_path('ibd_documents/'.$evals['PRINTED_BY'].'_'.$fileName))){
                File::delete(public_path('ibd_documents/'.$evals['PRINTED_BY'].'_'.$fileName));
            }

        } catch (\Exception $ex) {
            Log::info($ex->getMessage());
        }

        return $status ? url('public/ibd_documents/processed/'. $evals['PRINTED_BY'].'_'.$fileName) : '';

    }

    public function process($filePath, $fileName,$evals)
    {
        $pdf = new Fpdi();

        $pageCount = $pdf->setSourceFile($filePath);

        Log::info($pageCount);
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            // import a page
            $templateId = $pdf->importPage($pageNo);
            //set text at end of page
            $pdf->SetAutoPageBreak(true, 1);

            // get the size of the imported page
            $size = $pdf->getTemplateSize($templateId);
//            Log::info($size);

            $pdf->AddPage($size['orientation'], $size);
            // use the imported page
            $pdf->useTemplate($templateId);

            $pdf->SetFont('Helvetica','B',8);
//            $pdf->setFontSize(10);
//            $pdf->SetTextColor(205, 92, 92);
//            $pdf->SetFillColor(209, 238, 238);
//            if ($pageNo == 1) {
            $type = $evals['PRINT_TYPE'] === 'Initial' ? 'issued' : 'reprinted';
            $x = $size['orientation'] === 'L' ? 30 : 10;
            $w = $size['orientation'] === 'L' ? 39 : 20;

            $pdf->SetXY($x, $size['height']-13);
            $pdf->cell($size['width']-$w,6,
                'This page is '.$type .' by '.$evals['NAME'] .'; Employee ID: '.$evals['PRINTED_BY'] .
                ' on '.strtoupper(Carbon::parse($evals['PRINT_DT'])->format('j-M-y')).
                ' at '.strtoupper(Carbon::parse($evals['PRINT_DT'])->format('H:i')).
                ' for Batch '.$evals['BATCH'],
                0,1,'',false);
//                $pdf->Write(8, $evals['NAME'] .' ; '.$evals['PRINTED_BY'] .' ; '.$evals['PRINT_DT']);
//            }
        }

        if(File::exists(public_path('ibd_documents/processed/'.$evals['PRINTED_BY'].'_'.$fileName))){
            File::delete(public_path('ibd_documents/processed/'.$evals['PRINTED_BY'].'_'.$fileName));
        }

        $pdf->Output(public_path('ibd_documents/processed/'.$evals['PRINTED_BY'].'_'.$fileName), 'F');
    }

    //report view
    public function display_view()
    {

        $files = DB::select('Select distinct file_name from mis.ibd_print_log');
        $names = DB::select('Select distinct b.name name, a.printed_by code 
                             from mis.ibd_print_log a,mis.dashboard_users_info b
                             where a.printed_by = b.user_id');
        $types = DB::select('Select distinct print_type from mis.ibd_print_log');




        return view('issuing_batch_doc.ibdoc_display_log', compact('files', 'names', 'types'));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return void
     */
    public function show_log(Request $request)
    {

        //Log::info($request->param);
        DB::setDateFormat('DD-MON-RR');

        try {
            $parameters = [];
            parse_str($request->param, $parameters);
            //Log::info($parameters);

            $time_from = '';
            $time_to = '';
            if ($parameters['time_from']) {
                $time_from = $this->getFormattedTime($parameters['time_from']);
            }

            if ($parameters['time_to']) {
                $time_to = $this->getFormattedTime($parameters['time_to']);
            }

            $response = DB::select("select to_char(print_dt,'DD-MON-RR')||','||to_char(print_dt,'hh24:mi') print_dt,file_name,name,print_type,reason,batch
                                from MIS.IBD_PRINT_LOG a,mis.dashboard_users_info b
                                where a.printed_by = b.user_id(+) 
                                and to_date(print_dt,'DD-MON-RR') between to_date(?,'DD-MON-RR') and to_date(?,'DD-MON-RR') 
                                and nvl2(?,to_char(print_dt,'hh:mi am'),print_dt) between nvl2(?,?,print_dt) and nvl2(?,?,print_dt)
                                and file_name = decode(?,'All',file_name,?)
                                and printed_by = decode(?,'All',printed_by,?)
                                and print_type = decode(?,'All',print_type,?)",
                [strtoupper($parameters['date_from']), strtoupper($parameters['date_to']),
                    $time_from,$time_from,$time_from,$time_to,$time_to,
                    $parameters['file'], $parameters['file'], $parameters['by'], $parameters['by'],
                    $parameters['type'], $parameters['type']]);

            return response()->json($response);
        } catch (\Exception $ex) {
            Log::info($ex->getMessage());
        }


    }

    public function getFormattedTime($time)
    {
        $times = substr($time, 0, strpos($time, ':'));
        $_time = strlen($times) > 1 ? $time : '0' . $time;
        //Log::info($_time);

        return $_time;
    }

    public function generate_excel($para){
        //Log::info($para);
        DB::setDateFormat('DD-MON-RR');

        try {
            $parameters = [];
            parse_str($para, $parameters);
            //Log::info($parameters);

            $time_from = '';
            $time_to = '';
            if ($parameters['time_from']) {
                $time_from = $this->getFormattedTime($parameters['time_from']);
            }

            if ($parameters['time_to']) {
                $time_to = $this->getFormattedTime($parameters['time_to']);
            }

            $data_pr = DB::select("select to_char(print_dt,'DD-MON-RR')||','||to_char(print_dt,'hh24:mi') print_dt,file_name,name,print_type,reason
                                from MIS.IBD_PRINT_LOG a,mis.dashboard_users_info b
                                where a.printed_by = b.user_id(+) 
                                and to_date(print_dt,'DD-MON-RR') between to_date(?,'DD-MON-RR') and to_date(?,'DD-MON-RR') 
                                and nvl2(?,to_char(print_dt,'hh:mi am'),print_dt) between nvl2(?,?,print_dt) and nvl2(?,?,print_dt)
                                and file_name = decode(?,'All',file_name,?)
                                and printed_by = decode(?,'All',printed_by,?)
                                and print_type = decode(?,'All',print_type,?)
                                order by print_dt desc",
                [strtoupper($parameters['date_from']), strtoupper($parameters['date_to']),
                    $time_from,$time_from,$time_from,$time_to,$time_to,
                    $parameters['file'], $parameters['file'], $parameters['by'], $parameters['by'],
                    $parameters['type'], $parameters['type']]);

            $data = ['pdata' => $data_pr];

            \Excel::create('Batch Document Print report', function ($excel) use ($data) {

                $excel->sheet('print report', function ($sheet) use ($data) {
                    $sheet->loadView('issuing_batch_doc.report_layout.pr_excel', $data);
                    $sheet->setWidth(array(
                        'A' => 20,
                        'B' => 30,
                        'C' => 20,
                        'D' => 20,
                        'E' => 30
                    ));

                    $objDrawing = new PHPExcel_Worksheet_Drawing;
                    $objDrawing->setPath(public_path('site_resource/images/incepta.png'));
                    $objDrawing->setCoordinates('A1');
                    $objDrawing->setWidth(100);
                    $objDrawing->setWorksheet($sheet);
                });

            })->export('xls');
        } catch (\Exception $ex) {
            Log::info($ex->getMessage());
        }
    }

    public function getPlantWisePath(){
        $path = null;
        $plant = DB::select('Select emp_plant||unit emp_plant 
        from mis.dashboard_users_info where user_id = ?',[Auth::user()->user_id]);

        $folder_path = DB::select('Select folder_path 
        from mis.ibd_folder_info where plant_id||unit = ?',[$plant[0]->emp_plant]);

//        dd($folder_path);

        return $folder_path[0]->folder_path;
    }

}


