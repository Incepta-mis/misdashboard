<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Exportsales;
use App\Instsales;
use Input;
use DB;
use Validator;
use Session;
use Redirect;
use Carbon\Carbon;

class Data_upload_Controller extends Controller
{
    //

    public function export_sales_data_view()
    {       
        $upload_excel_info=DB::select("SELECT *
                                FROM MIS.UPLOAD_EXPORT_SALES_DATA U where sales_year=to_char(sysdate,'RRRR') and
                                to_char(U.sales_month,'MON')=to_char(trunc(trunc(sysdate,'MM')-1,'MM'),'MON')");
        // var_dump($upload_excel_info);
        return view('dataupload/export_salesdata',compact('upload_excel_info'));
    }

    public function postExportSales()
    {

        $file = Input::file('export_sales_data_name');

        $rules = array('export_sales_data_name' => 'required'); //'required'
        $msg = array('export_sales_data_name.required' => 'This field is required');
        $validatorempty = Validator::make(array('export_sales_data_name' => $file), $rules, $msg);

        if ($validatorempty->fails()) {

            return Redirect::to('dataupload/up_export_sales_data')->withErrors($validatorempty);

        } else if ($validatorempty->passes()) {
            /////////////////////////////////////////////////////////////////////////


            $ext = strtolower($file->getClientOriginalExtension());

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

                return Redirect::to('dataupload/up_export_sales_data')->withErrors($validator)->with($notification);

            }else if ($validator->passes()) {


                $headers = $this->getHeader(Input::file('export_sales_data_name'));


                //--------------------header check
//                    echo "inside ok";
                // if ($headers[0] == 'sales_year' && $headers[1] == 'sales_month') {
                if ($headers[0] == 'sales_year' && $headers[1] == 'sales_month' && $headers[2] == 'sales_cata' && $headers[3] == 'company' && $headers[4] == 'sales_person' && $headers[5] == 'sales_bdt' && $headers[6] == 'sales_usd') {

                    $ff = Excel::selectSheetsByIndex(0)->load(Input::file('export_sales_data_name'))->all()->first()->toArray();

                    $newYear = $ff['sales_month'];
                    $mon = \Carbon\Carbon::parse($newYear)->format('d/m/Y ');

//                    $yy = DB::select("SELECT count(*) cnt
//                                      FROM mis.upload_export_sales_data
//                                      WHERE sales_month= to_date('$mon','DD-MM-RR')");
                    $dd=DB::delete("delete from mis.upload_export_sales_data
                                      WHERE sales_month= to_date('$mon','DD-MM-RR')");

//                    $yc = $yy[0]->cnt;
//
//                    if ($yc == 0) {

//                    $tt=0;

                    Excel::load(Input::file('export_sales_data_name'), function ($reader) {

                            $reader->each(function ($sheet) {

                                try {

                                    Exportsales::Create($sheet->toArray());
//                                    $tt++;

                                } catch (\Exception $e) {

                                    dd($e->getMessage());
                                }


                            });


                        });

                        $upload_excel_info=DB::select("SELECT *
                                FROM MIS.UPLOAD_EXPORT_SALES_DATA U where sales_year=to_char(sysdate,'RRRR') and
                                to_char(U.sales_month,'MON')=to_char(trunc(trunc(sysdate,'MM')-1,'MM'),'MON')");


                        $notification = array(
                            'message' => 'File Uploaded successfully!',
                            'alert-type' => 'success',
                            'up_data'=>$upload_excel_info
                        );

                        return back()->with($notification)->with($upload_excel_info);


//                    }
//                    else
//                        {
//                        $notification = array(
//                            'message' => 'This file already uploaded!',
//                            'alert-type' => 'error'
//                        );
//
//                        return Redirect::to('dataupload/up_export_sales_data')->with($notification);
//                    }


                }else {
                    $notification = array(
                        'message' => 'upload excel column format not valid!',
                        'alert-type' => 'error'
                    );

                    return Redirect::to('dataupload/up_export_sales_data')->with($notification);

                }


//--------------------header check end


            }
            //////////////////////////////////////////
        }


    }

    public function inst_sales_data_view()
    {
        return view('dataupload/inst_salesdata');
    }

    public function postInstSales()
    {

        $file = Input::file('export_sales_data_name');

        $rules = array('export_sales_data_name' => 'required'); //'required'
        $msg = array('export_sales_data_name.required' => 'This field is required');
        $validatorempty = Validator::make(array('export_sales_data_name' => $file), $rules, $msg);

        if ($validatorempty->fails()) {

            return Redirect::to('dataupload/inst_sales_data')->withErrors($validatorempty);

        } else if ($validatorempty->passes()) {



            $ext = strtolower($file->getClientOriginalExtension());

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

                return Redirect::to('dataupload/inst_sales_data')->withErrors($validator)->with($notification);

            } else if ($validator->passes()) {


                $headers = $this->getHeader(Input::file('export_sales_data_name'));

                if ($headers[0] == 'sales_year' && $headers[1] == 'sales_month') {

                    $ff = Excel::selectSheetsByIndex(0)->load(Input::file('export_sales_data_name'))->all()->first()->toArray();

                    $newYear = $ff['sales_month'];
                    $mon = \Carbon\Carbon::parse($newYear)->format('d/m/Y ');

//                    $yy = DB::select("SELECT count(*) cnt
//                                      FROM mis.upload_inst_sales_data
//                                      WHERE sales_month= to_date('$mon','DD-MM-RR')");
                    $dd=DB::delete("delete from mis.upload_inst_sales_data
                                      WHERE sales_month= to_date('$mon','DD-MM-RR')");

//                    $yy = DB::select("SELECT count(*) cnt
//                                      FROM mis.upload_inst_sales_data
//                                      WHERE sales_month= to_date('$mon','DD-MM-RR')");
//
//                    $yc = $yy[0]->cnt;
//
//                    if ($yc == 0) {

                        Excel::load(Input::file('export_sales_data_name'), function ($reader) {

                            $reader->each(function ($sheet) {

                                try {

                                    Instsales::Create($sheet->toArray());

                                } catch (\Exception $e) {

                                    dd($e->getMessage());
                                }


                            });


                        });

                                        $yy = DB::select("SELECT count(*) cnt
                                      FROM mis.upload_inst_sales_data
                                      WHERE sales_month= to_date('$mon','DD-MM-RR')");

                    $yc = $yy[0]->cnt;

                        $notification = array(
                            'message' => 'File Uploaded successfully! '.$yc.' rows inserted',
                            'alert-type' => 'success'
                        );

                        return Redirect::to('dataupload/inst_sales_data')->with($notification);


//                    }
//                    else
//                    {
//                        $notification = array(
//                            'message' => 'This file already uploaded!',
//                            'alert-type' => 'error'
//                        );
//
//                        return Redirect::to('dataupload/inst_sales_data')->with($notification);
//                    }


                } else {
                    $notification = array(
                        'message' => 'upload excel column format not valid!',
                        'alert-type' => 'error'
                    );

                    return Redirect::to('dataupload/inst_sales_data')->with($notification);

                }





            }

        }


    }

    public function getHeader($file)
    {
        return ((((Excel::load($file))->all())->first())->keys())->toArray();
    }

    public function getSaleM($file)
    {
        return (((Excel::load($file))->all())->first());
    }

}
