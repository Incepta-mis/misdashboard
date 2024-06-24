<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

trait DailyAttendance
{
    function prepare_and_mail($to_cc, $atn_data, $wdate,$processType)
    {

        File::cleanDirectory(public_path('daily_attn_mail/'));
        $collection = collect($atn_data);

        $processedFiles = [];

        foreach ($to_cc as $tc) {

            $filtered = null;
            $type = null;
            $unique = null;
            if($tc->department != 'ALL' && $tc->section !== 'ALL'){
                $type = 'N';
                $filtered = $collection->filter(function ($value, $key) use ($tc) {
                    return $value->department === $tc->department && $value->section === $tc->section;
                });
            }
            else if($tc->department != 'ALL' && $tc->section == 'ALL'){
                $type = 'A';
                $filtered = $collection->filter(function ($value, $key) use ($tc) {
                    return $value->department === $tc->department;
                });
                $unique = $filtered->unique('section_name');
                //Log::info('Inside dept,All');
                //Log::info($unique);

            }
            else{
                $type = 'A';
                $filtered = $collection;
                $unique = $collection->unique('section_name');
                //Log::info('Inside All,All');
                //Log::info($unique);
            }

            $pdf = \SPDF::loadView('_damail._pdf_template.attendance_pdf',
                ['rheader' => $tc, 'rdata' => $filtered, 'wdate'=> $wdate, 'type'=>$type,'unique_rows'=>$unique]);

            $filepath = public_path('daily_attn_mail/') . $tc->department . '_'.$tc->section . '_' . $wdate . '.pdf';
            $pdf->setPaper('a4', 'portrait')
                ->save($filepath);

            $pdfurl = 'public/daily_attn_mail/'. $tc->department . '_'.$tc->section . '_' . $wdate . '.pdf';

            $processedFiles[] = [
                'mail_to'=>$tc->mail_to,
                'mail_cc'=>$tc->mail_cc,
                'mail_bcc'=>$tc->mail_bcc,
                'f_name'=>$tc->department . '_'.$tc->section . '_' . $wdate,
                'filepath'=>$filepath,
                'url'=>$pdfurl,
                'c_date'=>Carbon::now()->format('d-M-Y H:i:s a'),
                'dept'=>$tc->department,
                'sect'=>$tc->section
            ];

            if($processType == 'PS'){
               $this->send_mail($tc->mail_to,$tc->mail_cc,$tc->mail_bcc,$filepath,$tc->department,$tc->section);
            }
        }

        if($processedFiles){
            DB::table('mis.dept_wise_mail_log')->delete();
            DB::table('mis.dept_wise_mail_log')->insert($processedFiles);
        }

        return $processedFiles;
    }

    function send_mail($to, $cc, $bcc, $file,$dept,$sec)
    {
        Mail::send(['html' => '_damail._mail_template.attendance_mail'], ['dept'=>$dept,'sec'=>$sec]
            , function ($message) use ($to, $cc, $bcc, $file) {
                $message->from('hr@inceptapharma.com');
                $message->to(explode(',',$to));
                if($cc){
                    $message->cc(explode(',',$cc));
                }
                if($bcc){
                    $message->bcc(explode(',',$bcc));
                }
                $message->subject('Daily Attendance Mail');
                $message->attach($file,  [
                    'as' => 'daily_attendance.pdf',
                    'mime' => 'application/pdf',
                ]);

            });
    }
}