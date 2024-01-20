<?php

namespace App\Http\Controllers;

use App\Mail\SendGrid;
use App\Services\Sms;
use App\Settings;
use GuzzleHttp\Client;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function DeletePhotos($name, $path)
    {
        if ($name && File::exists(public_path('/uploads/'.$path . $name))) {
            File::delete(public_path('/uploads/'.$path . $name));
        }
    }

    public function apiResponse($status,$keyVal)
    {
        $arrayResponse=[];
        $arrayResponse['status']=$status;
        foreach ($keyVal as $key=>$value) {
            $arrayResponse[$key]=$value;
        }
        return response()->json($arrayResponse, $status);
    }


    protected function sendOtp($otp, $mobile , $email , $type) {
        try {
            if ( $email == null and $type == 'email' )
                $type = 'sms';

            if ( $type == 'sms' ) {
                $sms = new Sms();
                $sms = $sms->getConfig();
                
                $client = new Client(); //GuzzleHttp\Client

                $res = $client->get('http://smsbox.com/smsgateway/services/messaging.asmx/Http_SendSMS', [
                    'headers' => [
                        'Content-Type' => 'application/x-www-form-urlencoded'
                    ],
                    'query' => [
                        'username' => $sms['username'],
                        'password' => $sms['password'],
                        'customerid' => $sms['customerId'],
                        'sendertext' => $sms['sendertext'],
                        'messagebody' => $otp,
                        'recipientnumbers' => \Illuminate\Support\Str::startsWith($mobile, '965') ? $mobile : '965' . $mobile,
                        'defdate' => "",
                        'isblink' => false,
                        'isflash' => false,
                    ],
                ]);
                $xml = $res->getBody()->getContents();
                $xmldata = simplexml_load_string($xml);
                $jsondata = json_encode($xmldata);
                $json = json_decode($jsondata, true);
                \Illuminate\Support\Facades\Log::info('send otp sms: '. $otp . '  '. $mobile . '  '.$email . '  ' .$type , [$json]  );
                return $json['Message'];
            } else {
                if ( intval($otp) == $otp )
                    $otp = trans('webMessage.you_have_reqtest_fp' , ['code' => $otp] );
                $settings = Settings::where("keyname", "setting")->first();
                Mail::to($email)->send(new SendGrid([
                    'dear' => trans('webMessage.dearuser'),
                    'footer' => trans('webMessage.email_footer'),
                    'message' => $otp ,
                    'subject' => trans('webMessage.resetforgotpassword'),
                    'email_from' => $settings->from_email,
                    'email_from_name' => $settings->from_name
                ]));
                \Illuminate\Support\Facades\Log::info('send otp email: '. $otp . '  '. $mobile . '  '.$email . '  ' .$type  );
                return "ok";
            }
        } catch ( \Exception $exception){
            // dd($exception);
            \Illuminate\Support\Facades\Log::info('send otp Exception: '. $otp . '  '. $mobile . '  '.$email . '  ' .$type , [$exception->getMessage()]  );
            return  $exception->getMessage();
        }
    }
}
