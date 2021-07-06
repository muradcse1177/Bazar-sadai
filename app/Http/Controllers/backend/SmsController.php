<?php

namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SmsController extends Controller
{
    public function sms(){
        return view('backend.sms');
    }
    public function smsSend(Request $request){
        $url = "http://66.45.237.70/api.php";
        $number=$request->phone;
        $text=$request->msg;
        $data= array(
            'username'=>"01929877307",
            'password'=>"murad1107053",
            'number'=>"$number",
            'message'=>"$text"
        );

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        $p = explode("|",$smsresult);
        $sendstatus = $p[0];
        if($sendstatus){
            $phones = explode(',',$request->phone);
            foreach ($phones as $phone){
                $result = DB::table('smslog')->insert([
                    'number' => $phone,
                    'msg' => $request->msg,
                ]);
            }
            if ($result) {
                return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
            } else {
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }
        }
    }
}
