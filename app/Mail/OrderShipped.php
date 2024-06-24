<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;


class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $userData;


    public function __construct($userData)
    {
        $this->userData = $userData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Log::info("lon in order=");
        Log::info(  $this->userData);
       /* return $this->subject('Subject')
            ->markdown('Attendance.Mail');*/


        $user_email= $this->userData['user_email'];

        return $this->from($user_email)->subject('Regarding Attendance Status Daily - Absenteeism Reporting')
            ->markdown('Attendence.Mail')->with([
                'user_name' => $this->userData['user_name'],
                'user_designation' => $this->userData['user_designation'],
                'user_email' => $this->userData['user_email'],
                'user_dept' => $this->userData['user_dept'],
                'uid' => $this->userData['uid'],

                'emp_id' => $this->userData['emp_id'],
                'emp_name' => $this->userData['emp_name'],
                'emp_dept' => $this->userData['emp_dept'],
                'emp_deg' => $this->userData['emp_deg'],
                'emp_sec' => $this->userData['emp_sec'],
                'wc' => $this->userData['wc'],
                'date_from' => $this->userData['date_from'],
                'date_to' => $this->userData['date_to'],
                'status' => $this->userData['status'],
                'reason_type' => $this->userData['reason_type'],
                'reason_by_emp' => $this->userData['reason_by_emp'],
                'reason_acceptability' => $this->userData['reason_acceptability'],
                'emp_type' => $this->userData['emp_type'],
                'absence_days' => $this->userData['absence_days'],
            ]);

    }
}




