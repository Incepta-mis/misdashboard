<?php
/**
 * Created by PhpStorm.
 * User: raqib
 * Date: 5/27/2018
 * Time: 9:40 AM
 */

namespace App;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class Mobi_service
{
    protected $URI_SINGLE = 'https://api.mobireach.com.bd/SendTextMessage';
    protected $URI_MULTI = 'https://api.mobireach.com.bd/SendTextMultiMessage';
    protected $URI_STATUS = 'https://api.mobireach.com.bd/GetMessageStatus';
    protected $USER_NAME = 'inceptamsfa';
    protected $PASSWORD = 'Incepta@msfa15';
    protected $FROM = 'INCEPTAMSFA';
    protected $HTTP_PROXY = '192.168.6.100:3128';
    protected $result;

    public function __construct(){
    }

    public function sendMultiMessage($to,$message){

        try{
                Log::info($to);
                foreach ($to as $t){
                $paramArray = [
                    'Username' => $this->USER_NAME,
                    'Password' => $this->PASSWORD,
                    'From' => $this->FROM,
                    'To' => $t,
                    'Message' => $message
                ];
                $client = new Client();
                $result = $client->post($this->URI_SINGLE,[
                   'verify'=>false,
                   // 'proxy'=>$this->HTTP_PROXY,
                   'form_params'=>$paramArray
                ]);
                // Log::info("Result: ".$result);
              }
        }
        catch (ClientException $e){
            Log::info($e->getMessage());
            $result = $e->getMessage();
        }
        catch (RequestException $e){
            Log::info($e->getMessage());
            $result = $e->getMessage();
        }

        return $result->getBody()->getContents();
    }

    public function sendMessage($to,$message){

        try{
            $paramArray = [
                'Username' => $this->USER_NAME,
                'Password' => $this->PASSWORD,
                'From' => $this->FROM,
                'To' => $to,
                'Message' => $message
            ];
            $client = new Client();
            $result = $client->post($this->URI_SINGLE,[
                'verify'=>false,
                // 'proxy'=>$this->HTTP_PROXY,
                'form_params'=>$paramArray
            ]);

            return $result->getBody()->getContents();

        }
        catch (ClientException $e){
            Log::info('Client'.$e->getMessage());
            $result = $e->getMessage();
        }
        catch (RequestException $e){
            Log::info('Request'.$e->getMessage());
            $result = $e->getMessage();
        }

        return $result;

    }

}