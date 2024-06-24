<?php

namespace App;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class FcmService{

    protected $FCM_KEY = 'AAAAD6zzrVs:APA91bG0mq7F4I4uqdz2ebfidXMdkJl6jPT6aEWLKPt9BZUM28d8y42UrIaddH8yXUxt7PXqNHqmWL0otqbiB-6e17UnX6fgEyYpciUq3cjdMHCX4q81f45vwgrNppE2T0neaTuhKgKc';
    protected $TITLE;
    protected $MESSAGE;
    protected $TOKENS;
    protected $URL = 'https://fcm.googleapis.com/fcm/send';
    protected $PROXY = '192.168.6.100:3128';

    public function __construct($title,$message,$tokens)
    {
        $this->TITLE = $title;
        $this->MESSAGE = $message;
        $this->TOKENS = $tokens;
    }

    public function send_notice(){

        $fields = [
            'notification' => [
                'body' => $this->MESSAGE,
                'title' => $this->TITLE,
                'click_action' => 'SHOW_DETAILS',
                'sound' => 'default'
            ],
            'registration_ids' => $this->TOKENS,
            'priority' => 'high',
            'android_channel_id' => 'quizChannel'
        ];

        $headers = [
            'Authorization' =>'key=' . $this->FCM_KEY,
            'Content-Type' => 'application/json'
        ];

        $client = new Client();
        $response = $client->post($this->URL,[
           'verify' => false,
           // 'proxy' => $this->PROXY,
           'headers' => $headers,
           'json' => $fields
        ]);

        //Log::info($response->getBody());
        return $response->getBody();
    }

}