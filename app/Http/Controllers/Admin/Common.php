<?php

namespace App\Http\Controllers\Admin;

use App\AdminLogs;
use App\Admin;
use App\Http\Controllers\Controller;
use App\Log;
use App\Transaction;
use App\Settings;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Common extends Controller
{
    //get date format
    public static function DateFormat($date)
    {
        return date("Y-m-d H:i:s", strtotime($date));
    }

    //get dezsms total points via api
    public static function DezsmsPoints()
    {
        $settingInfo = Settings::where("keyname", "setting")->first();
        if (!empty($settingInfo->is_sms_active) && !empty($settingInfo->sms_userid) && !empty($settingInfo->sms_sender_name) && !empty($settingInfo->sms_api_key)) {
            $apiUrl = "https://www.dezsms.com/json_dezsmsnewapi_totalpoints.php";
            $response = Curl::to($apiUrl)
                ->withData([
                    'key' => $settingInfo->sms_api_key,
                    'usermobile' => $settingInfo->sms_userid
                ])->post();
            $jsdecode = json_decode($response, true);
        } else {
            $jsdecode = ["status" => "error", "message" => "Credentials are missing"];
        }
        return $jsdecode;
    }

    //send sms to dezsms
    public static function SendSms($to, $sms_msg)
    {
        $settingInfo = Settings::where("keyname", "setting")->first();
        if (
            !empty($to) &&
            !empty($sms_msg) &&
            !empty($settingInfo->is_sms_active) &&
            !empty($settingInfo->sms_userid) &&
            !empty($settingInfo->sms_sender_name) &&
            !empty($settingInfo->sms_api_key)
        ) {
            $apiUrl = "https://www.dezsms.com/json_dezsmsnewapi.php";

            $response = Curl::to($apiUrl)
                ->withData([
                    'key' => $settingInfo->sms_api_key,
                    'dezsmsid' => $settingInfo->sms_userid,
                    'senderid' => $settingInfo->sms_sender_name,
                    'msg' => $sms_msg,
                    'number' => $to
                ])->post();
            $jsdecode = json_decode($response, true);
            $status = $jsdecode[0]['status'];
            $message = self::DezsmsErrorMsg($status);
            $jsdecode = ["status" => $status, "message" => $message];
        } else {
            $jsdecode = ["status" => "404", "message" => "Credentials are missing"];
        }
        return $jsdecode;
    }

    //get Dezsms error text message via code
    public static function DezsmsErrorMsg($Error)
    {
        if ($Error == 100) {
            $txt = "SMS has been sent successfully";
        } else if ($Error == 101) {
            $txt = "This is Invalid user";
        } else if ($Error == 102) {
            $txt = "Invalid authentication key!";
        } else if ($Error == 103) {
            $txt = "Mobile number OR Message is required!";
        } else if ($Error == 104) {
            $txt = "You can send upto 200 maximum mobile numbers at once.";
        } else if ($Error == 105) {
            $txt = "SMS Sending failed.Please contact with your SMS provider.";
        } else if ($Error == 106) {
            $txt = "Arabic text should not be greater than 258";
        } else if ($Error == 107) {
            $txt = "English text should not be greater than 526";
        } else if ($Error == 108) {
            $txt = "Your account is not activeted";
        } else if ($Error == 109) {
            $txt = "Your account has been expired.";
        } else if ($Error == 110) {
            $txt = "SMS point is not enough to send sms";
        } else if ($Error == 111) {
            $txt = "Invalid Mobile number";
        }
        return $txt;
    }

    //recaptcha verification
    public static function VerifyCaptcha($response)
    {
        $google_url = "https://www.google.com/recaptcha/api/siteverify";
        $secret = '6LeMueQUAAAAACXA8eAOD1JMWjvjZnGMwiRpX06p';
        $url = $google_url . "?secret=" . $secret . "&response=" . $response;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_TIMEOUT, 15);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        $curlData = curl_exec($curl);

        curl_close($curl);

        $res = json_decode($curlData, TRUE);
        if ($res['success'] == 'true')
            return TRUE;
        else
            return FALSE;
    }

    //validate kuwait mobile number
    public static function checkMobile($mobile)
    {
        $flag = 0;
        if (!empty($mobile) && preg_match('/[0-9 ]+/i', $mobile) == true) {
            $mobileval = substr($mobile, 0, -7);
            if ($mobileval == 5 || $mobileval == 6 || $mobileval == 9) {
                $flag = 1;
            }
        }
        return $flag;
    }

    //save vendor logs
    public static function saveVendorsLogs($key_name, $key_id, $message, $created_by = NULL)
    {
        $logs = new VendorsLogs;
        $logs->key_name = $key_name;
        $logs->key_id = $key_id;
        $logs->message = $message;
        $logs->created_by = $created_by;
        $logs->save();
    }

    //show created by Name\
    public static function createdByName($id)
    {
        $admin = Admin::find($id);
        if (!empty($admin->name)) {
            $name = $admin->name;
        } else {
            $name = "ID =" . $id;
        }
        return $name;
    }

    /////////////////////////////////////////My Fatoorah ////////////////////////////////

    public static function InitiatePayments($payMode, $amount)
    {
        if (empty($payMode)) {
            $token = Config::get('services.myfatoorah.token_test'); #token value to be placed here;
            $basURL = Config::get('services.myfatoorah.baseUrl_test');
        } else {
            $token = Config::get('services.myfatoorah.token_test'); #token value to be placed here;
            $basURL = Config::get('services.myfatoorah.baseUrl_test');
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$basURL/v2/InitiatePayment",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"InvoiceAmount\": " . $amount . ",\"CurrencyIso\": \"KWD\"}",
            CURLOPT_HTTPHEADER => array("Authorization: Bearer $token", "Content-Type: application/json"),
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $json = json_decode((string)$response, true);
        }

    }

    //send payment
    ###########Send Payment (Offline)###########
    public static function SendPayment($payMode = 0, $orders)
    {

        if (empty($orders)) {
            return json_encode(['IsSuccess' => false, 'Message' => 'You have passed empty order values.'], true);
        }
        //name
        if (!empty($orders['name'])) {
            $name = $orders['name'];
        } else {
            $name = 'No Name';
        }
        if (!empty($orders['mobile'])) {
            $mobile = $orders['mobile'];
        } else {
            $mobile = '00000000';
        }
        if (!empty($orders['email'])) {
            $email = $orders['email'];
        } else {
            $email = 'noemail@nodimain.com';
        }
        if (!empty($orders['cust_ref'])) {
            $cust_ref = $orders['cust_ref'];
        } else {
            $cust_ref = 'No Ref';
        }
        if (!empty($orders['civilid'])) {
            $civilid = $orders['civilid'];
        } else {
            $civilid = 'No Civil ID';
        }
        if (!empty($orders['block'])) {
            $block = $orders['block'];
        } else {
            $block = 'No Block';
        }
        if (!empty($orders['street'])) {
            $street = $orders['street'];
        } else {
            $street = 'No Street';
        }
        if (!empty($orders['house'])) {
            $house = $orders['house'];
        } else {
            $house = 'No House';
        }
        if (!empty($orders['customField'])) {
            $customField = $orders['customField'];
        } else {
            $customField = 'No Custom Field';
        }
        if (!empty($orders['amount'])) {
            $amount = $orders['amount'];
        } else {
            $amount = 0;
        }


        if (empty($payMode)) {
            $token = Config::get('services.myfatoorah.token_test'); #token value to be placed here;
            $basURL = Config::get('services.myfatoorah.baseUrl_test');
        } else {
            $token = Config::get('services.myfatoorah.token_test'); #token value to be placed here;
            $basURL = Config::get('services.myfatoorah.baseUrl_test');
        }

        $CallBackUrl = url('api/CallBackUrl');
        $ErrorUrl = url('api/ErrorUrl');

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$basURL/v2/SendPayment",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"NotificationOption\":\"ALL\",\"CustomerName\": \"$name\",\"DisplayCurrencyIso\": \"KWD\", \"MobileCountryCode\":\"+965\",\"CustomerMobile\": \"$mobile\",\"CustomerEmail\": \"$email\",\"InvoiceValue\": $amount,\"CallBackUrl\": \"$CallBackUrl\",\"ErrorUrl\": \"$ErrorUrl\",\"Language\": \"en\",\"CustomerReference\" :\"$cust_ref\",\"CustomerCivilId\":$civilid,\"UserDefinedField\": \"$customField\",\"ExpireDate\": \"\",\"CustomerAddress\" :{\"Block\":\"$block\",\"Street\":\"$street\",\"HouseBuildingNo\":\"$house\",\"Address\":\"\",\"AddressInstructions\":\"\"},\"InvoiceItems\": [{\"ItemName\": \"Item Purchasing\",\"Quantity\": 1,\"UnitPrice\": $amount}]}",
            CURLOPT_HTTPHEADER => array("Authorization: Bearer $token", "Content-Type: application/json"),

        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            //echo "cURL Error #:" . $err;
            return json_encode(['IsSuccess' => false, 'Message' => 'Error found while processing the payment.'], true);
        } else {
            //echo "$response '<br />'";
            return $response;
        }

    }

    //get payment status
    public static function callBackPayment($payMode = 0, $paymentId)
    {

        if (empty($payMode)) {
            $token = Config::get('services.myfatoorah.token_test'); #token value to be placed here;
            $basURL = Config::get('services.myfatoorah.baseUrl_test');
        } else {
            $token = Config::get('services.myfatoorah.token_test'); #token value to be placed here;
            $basURL = Config::get('services.myfatoorah.baseUrl_test');
        }


        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $basURL . "/v2/GetPaymentStatus");
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "{\"Key\":\"$paymentId\",\"KeyType\":\"paymentid\"}");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $token", "Content-Type: application/json"));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $info = curl_getinfo($curl);

        curl_close($curl);
        if ($err) {
            //echo "cURL Error #:" . $err;
            return json_encode(['IsSuccess' => false, 'Message' => 'Error found while processing the payment.'], true);
        } else {
            //echo "$response '<br />'";
            return $response;
        }

    }

    /////////////////////////////////////////End My Fatoorah ////////////////////////////
    /////////////////////////////send push notification///////////////////////////////
    public static function sendMobilePush($token, $title, $message, $type = 'regular')
    {
        $settingInfo = Settings::where("keyname", "setting")->first();

        $data = array
        (
            'subtitle' => $title,
            'tickerText' => $title,
            'message' => $message,
            'vibrate' => 1,
            'sound' => 1,
            'largeIcon' => 'large_icon',
            'smallIcon' => 'small_icon',
            'type' => $type

        );
        // Optional push notification options (such as iOS notification fields)

        $options = array(
            'notification' => array(
                'badge' => 1,
                'sound' => "ping.aiff",
                'title' => $title,
                'body' => $message

            )
        );


        // Insert your Secret API Key here
        $apiKey = $settingInfo->pushy_api_token;

        // Default post data to provided options or empty array
        $post = $options ?: array();

        // Set notification payload and recipients
        $post['to'] = $token;
        $post['data'] = $data;
        $post['content_available'] = TRUE;

        // Set Content-Type header since we're sending JSON
        $headers = array(
            'Content-Type: application/json'
        );

        // Initialize curl handle
        $ch = curl_init();

        // Set URL to Pushy endpoint
        curl_setopt($ch, CURLOPT_URL, 'https://api.pushy.me/push?api_key=' . $apiKey);

        // Set request method to POST
        curl_setopt($ch, CURLOPT_POST, true);

        // Set our custom headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Get the response back as string instead of printing it
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Set post data as JSON
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post, JSON_UNESCAPED_UNICODE));

        // Actually send the push
        $result = curl_exec($ch);

        // Display errors
        if (curl_errno($ch)) {
            echo curl_error($ch);
        }

        // Close curl handle
        curl_close($ch);
        //return json_encode($result);

    }

    //////////////////////////////////////////////////////////////////////////////////////











    //save admin logs
    public static function saveLogs($key_name, $key_id, $message, $created_by = NULL)
    {
        $logs = new Log();
        $logs->key_name = $key_name;
        $logs->key_id = $key_id;
        $logs->message = $message;
        $logs->created_by = $created_by;
        $logs->save();
    }

    // upload new image
    public static function uploadImage($request, $fieldName, $resourceName, $image_big_w, $image_big_h, $image_thumb_w, $image_thumb_h)
    {
        $imageName = "";

        if ($request->hasfile($fieldName)) {
            $imageName = $resourceName . '-' . $fieldName . '-' . md5(time()) . '.' . $request->$fieldName->getClientOriginalExtension();
            $request->$fieldName->move(public_path('uploads/' . $resourceName), $imageName);

            // if the dimensions of big image is set, resize it
            if($image_big_w != 0 && $image_big_h != 0) {
                $imgbig = Image::make(public_path('uploads/' . $resourceName . '/' . $imageName));
                $imgbig->resize($image_big_w, $image_big_h); //Fixed w,h
                $imgbig->save(public_path('uploads/' . $resourceName . '/' . $imageName));
            }

            // if the dimensions of thumb image is set, resize it
            if($image_thumb_w != 0 && $image_thumb_h != 0) {
                $imgthumb = Image::make(public_path('uploads/' . $resourceName . '/' . $imageName));
                $imgthumb->resize($image_thumb_w, $image_thumb_h); //Fixed w,h
                $imgthumb->save(public_path('uploads/' . $resourceName . '/thumb/' . $imageName));
            }
        }

        return $imageName;
    }


//    public static function MoveImageDropzone($images, $fieldName, $resourceName, $image_big_w, $image_big_h, $image_thumb_w, $image_thumb_h)
//    {
//        $imageName = "";
//
//        if ($request->hasfile($fieldName)) {
//            $imageName = $resourceName . '-' . $fieldName . '-' . md5(time()) . '.' . $request->$fieldName->getClientOriginalExtension();
//            $request->$fieldName->move(public_path('uploads/' . $resourceName), $imageName);
//
//            // if the dimensions of big image is set, resize it
//            if($image_big_w != 0 && $image_big_h != 0) {
//                $imgbig = Image::make(public_path('uploads/' . $resourceName . '/' . $imageName));
//                $imgbig->resize($image_big_w, $image_big_h); //Fixed w,h
//                $imgbig->save(public_path('uploads/' . $resourceName . '/' . $imageName));
//            }
//
//            // if the dimensions of thumb image is set, resize it
//            if($image_thumb_w != 0 && $image_thumb_h != 0) {
//                $imgthumb = Image::make(public_path('uploads/' . $resourceName . '/' . $imageName));
//                $imgthumb->resize($image_thumb_w, $image_thumb_h); //Fixed w,h
//                $imgthumb->save(public_path('uploads/' . $resourceName . '/thumb/' . $imageName));
//            }
//        }
//
//        return $imageName;
//    }

    // edit image
    public static function editImage($request, $fieldName, $resourceName, $image_big_w, $image_big_h, $image_thumb_w, $image_thumb_h, $resource)
    {
        $imageName = "";

        if ($request->hasfile($fieldName)) {
            //delete image from folder
            if (!empty($resource->$fieldName)) {
                $web_image_path = "/uploads/" . $resourceName . '/' . $resource->$fieldName;
                $web_image_paththumb = "/uploads/" . $resourceName . "/thumb/" . $resource->$fieldName;
                if (File::exists(public_path($web_image_path))) {
                    File::delete(public_path($web_image_path));
                }
                if (File::exists(public_path($web_image_paththumb))) {
                    File::delete(public_path($web_image_paththumb));
                }
            }

            $imageName = $resourceName . '-' . $fieldName . '-' . md5(time()) . '.' . $request->$fieldName->getClientOriginalExtension();
            $request->$fieldName->move(public_path('uploads/' . $resourceName), $imageName);

            // if the dimensions of big image is set, resize it
            if($image_big_w != 0 && $image_big_h != 0) {
                $imgbig = Image::make(public_path('uploads/' . $resourceName . '/' . $imageName));
                $imgbig->resize($image_big_w, $image_big_h); //Fixed w,h
                $imgbig->save(public_path('uploads/' . $resourceName . '/' . $imageName));
            }

            // if the dimensions of thumb image is set, resize it
            if($image_thumb_w != 0 && $image_thumb_h != 0) {
                $imgthumb = Image::make(public_path('uploads/' . $resourceName . '/' . $imageName));
                $imgthumb->resize($image_thumb_w, $image_thumb_h); //Fixed w,h
                $imgthumb->save(public_path('uploads/' . $resourceName . '/thumb/' . $imageName));
            }
        }
        else {
            $imageName = $resource->$fieldName;
        }

        return $imageName;
    }

    // delete image
    public static function deleteImage($fieldName, $resourceName, $resource)
    {
        if (!empty($resource->$fieldName)) {
            $web_image_path = "/uploads/" . $resourceName . "/" . $resource->$fieldName;
            $web_image_paththumb = "/uploads/" . $resourceName . "/thumb/" . $resource->$fieldName;

            if (File::exists(public_path($web_image_path))) {
                File::delete(public_path($web_image_path));
            }
            if (File::exists(public_path($web_image_paththumb))) {
                File::delete(public_path($web_image_paththumb));
            }
        }

        $resource->$fieldName = '';
        $resource->save();
    }

    //create slug
    public static function createSlug($modelName, $title, $id=0)
    {
        $model = '\App\\' . $modelName;

        // Normalize the title
        $slug = Str::slug($title, '-');

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $model::select('slug')->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();

        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('slug', $slug)){
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 1000; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }

    ///////////////////////////////////////////////KNET INTEGRATION HELPER , DON'T EDIT//////////////////////////

    public static function knetPaymentProcessing($orderid,$ordertrackid,$totalprice,$uid=0,$strLang="en"){
        $ResponseUrl = url('/knet-response');
        $ErrorUrl    = url('/knet-status');

        //check pay status type
        $gateway = env('GATEWAY');
        if($gateway == "test"){
            $TRANSPORTAL_ID      = config('services.knet_test.TRANSPORTAL_ID');
            $TRANSPORTAL_PASS    = config('services.knet_test.TRANSPORTAL_PASS');
            $CURRENCY_CODE       = config('services.knet_test.CURRENCY_CODE');
            $LANGID              = config('services.knet_test.LANGID');
            $ACTION              = config('services.knet_test.ACTION'); // 1 for purchase
            $TERM_RESOURCE_KEY   = config('services.knet_test.TERM_RESOURCE_KEY');
            $PAYMENT_REQUEST_URL = config('services.knet_test.PAYMENT_REQUEST_URL');
        }
        else{
            $TRANSPORTAL_ID      = config('services.knet_live.TRANSPORTAL_ID');
            $TRANSPORTAL_PASS    = config('services.knet_live.TRANSPORTAL_PASS');
            $CURRENCY_CODE       = config('services.knet_live.CURRENCY_CODE');
            $LANGID              = config('services.knet_live.LANGID');
            $ACTION              = config('services.knet_live.ACTION'); // 1 for purchase
            $TERM_RESOURCE_KEY   = config('services.knet_live.TERM_RESOURCE_KEY');
            $PAYMENT_REQUEST_URL = config('services.knet_live.PAYMENT_REQUEST_URL');
        }

        //check resource key exists or not
        if(empty($TERM_RESOURCE_KEY)){
            return ["status"=>0,"message"=>"TERM RESOURCE KEY is missing","payurl"=>""];
        }
        if(empty($TRANSPORTAL_ID)){
            return ["status"=>0,"message"=>"TRANSPORTAL ID is missing","payurl"=>""];
        }
        if(empty($TRANSPORTAL_PASS)){
            return ["status"=>0,"message"=>"TRANSPORTAL PASS is missing","payurl"=>""];
        }

        $today = date('Y-m-d');

        try{
            $ReqTranportalId       = "id=".$TRANSPORTAL_ID;
            $ReqTranportalPassword = "password=".$TRANSPORTAL_PASS;
            $ReqCurrency           = "currencycode=".$CURRENCY_CODE;
            $ReqLangid             = "langid=".$LANGID;
            $ReqAction             = "action=".$ACTION;
            $ReqAmount             = "amt=".$totalprice;
            $ReqTrackId            = "trackid=".$ordertrackid;
            $ReqResponseUrl        = "responseURL=".$ResponseUrl; // knet_response_directpay
            $ReqErrorUrl           = "errorURL=".$ErrorUrl;
            $ReqUdf1               = "udf1=".$ordertrackid;
            $ReqUdf2               = "udf2=".$today;
            $ReqUdf3               = "udf3=".$strLang;
            $ReqUdf4               = "udf4=".$uid;
            $ReqUdf5               = "udf5=";

            /* Now merchant sets all the inputs in one string for encrypt and then passing to the Payment Gateway URL */
            $param=$ReqTranportalId."&".$ReqTranportalPassword."&".$ReqAction."&".$ReqLangid."&".$ReqCurrency."&".$ReqAmount."&".$ReqResponseUrl."&".$ReqErrorUrl."&".$ReqTrackId."&".$ReqUdf1."&".$ReqUdf2."&".$ReqUdf3."&".$ReqUdf4."&".$ReqUdf5;
            //echo $param; echo "<hr>";
            $param=self::encryptAES($param,$TERM_RESOURCE_KEY)."&tranportalId=".$TRANSPORTAL_ID."&responseURL=".$ResponseUrl."&errorURL=".$ErrorUrl;

            //create the transaction
            $transaction = new Transaction();
            $transaction->order_id = $orderid;
            $transaction->presult  = 'INITIALIZED';
            $transaction->payment_status = 'notpaid';
            $transaction->postdate = date("md");
            $transaction->trackid  = $ordertrackid;
            $transaction->amount  = $totalprice;
            $transaction->pay_type  = "KNET";
            $transaction->save();

            $payredirectUrl = $PAYMENT_REQUEST_URL.$param;

            return ["status"=>1,"message"=>"Initialized successfully","payurl"=>$payredirectUrl];
        }
        catch (\Exception $e) {
            return ["status"=>0,"message"=>$e->getMessage(),"payurl"=>""];
        }
    }


    ////////////////////// Encryption Method for AES Algorithm ////////////
    public static function encryptAES($str,$key) {
        $str         = self::pkcs5_pad($str);
        $encrypted   = openssl_encrypt($str, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $key);
        $encrypted   = base64_decode($encrypted);
        $encrypted   = unpack('C*', ($encrypted));
        $encrypted   = self::byteArray2Hex($encrypted);
        $encrypted   = urlencode($encrypted);
        return $encrypted;
    }

    public static function pkcs5_pad($text) {
        $blocksize = 16;
        $pad       = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    public static function byteArray2Hex($byteArray) {
        $chars = array_map("chr", $byteArray);
        $bin   = join($chars);
        return bin2hex($bin);
    }
    ////////////////////////////////////////////////////////////////////////



    /////////////// Decryption Method for AES Algorithm /////////////////////////
    public static function decrypt($code,$key) {
        $code      = self::hex2ByteArray(trim($code));
        $code      = self::byteArray2String($code);
        $iv        = $key;
        $code      = base64_encode($code);
        $decrypted = openssl_decrypt($code, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
        return self::pkcs5_unpad($decrypted);
    }

    public static function hex2ByteArray($hexString) {
        $string = hex2bin($hexString);
        return unpack('C*', $string);
    }

    public static function byteArray2String($byteArray) {
        $chars = array_map("chr", $byteArray);
        return join($chars);
    }

    public static function pkcs5_unpad($text) {
        $pad = ord($text[strlen($text)-1]);
        if($pad > strlen($text)){
            return false;
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
            return false;
        }
        return substr($text, 0, -1 * $pad);
    }
    /////////////////////////////////////////////////////////////////////////////




    // split data
    public static function splitData($trandata) {
        $splitData=[];
        $data = explode ( "&", $trandata );
        foreach ( $data as $value ) {
            $temp = explode ( "=", $value );
            if ( !isset($temp[1])) {
                $temp[1] = "";
            }
            $splitData [$temp [0]] = $temp [1];
        }
        return $splitData;
    }

    ///////////////////////////////////////////////END KNET INTEGRATION HELPER , DON'T EDIT/////////////////////////


}
