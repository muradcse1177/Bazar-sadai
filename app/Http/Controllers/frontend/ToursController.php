<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ToursController extends Controller
{
    public function serviceSubCategoryToursNTravel($id){
        $tours_sub_cats = DB::table('subcategories')
            ->where('cat_id', $id)
            ->where('type', 2)
            ->where('status', 1)
            ->orderBy('id', 'ASC')->get();
        return view('frontend.serviceSubCategoryTours', ['tours_sub_cats' => $tours_sub_cats]);
    }
    public function getAllToursListFront(Request $request){
        $rows = DB::table('subcategories')
            ->where('cat_id',12)
            ->get();
        return response()->json(array('data'=>$rows));
    }
    public function searchTourNTravels(Request $request){
        $rows = DB::table('toor_booking1')
            ->where('bookingName',$request->bookingName)
            ->where('country',$request->country)
            ->where('place',$request->place)
            ->paginate(20);
        if(count($rows)<1){
            return back()->with('errorMessage', 'বুকিং পাওয়া যায়নি।');
        }
        return view('frontend.searchTourNTravels', ['results' => $rows]);
    }
    public function bookingHotel(Request $request){
        $rows = DB::table('toor_booking2')
            ->select('*','toor_booking2.id as t_id','toor_booking2.description  as facilities' )
            ->join('toor_booking1','toor_booking2.name_id','=','toor_booking1.id')
            ->where('toor_booking2.name_id',$request->id)
            ->paginate(20);
        return view('frontend.bookingHotel', ['results' => $rows]);
    }
    public function bookingHNT(Request $request){
        return view('frontend.bookingHNT');
    }
    public function getHNTPrice(Request $request){
        $rows = DB::table('toor_booking2')
            ->where('id',$request->d_id)
            ->first();
        $price = $request->id * $rows->price * $request->days;
        return response()->json(array('data'=>$price));
    }
    public function insertBookingHNTOnOnline(Request $request){
        $status = $request->status;
        $type = 'Tours N Travel Booking';
        $msg = $request->msg;
        $tx_id = $request->tx_id;
        $bank_tx_id = $request->bank_tx_id;
        $amount = $request->amount;
        $bank_status = $request->bank_status;
        $sp_code = $request->sp_code;
        $sp_code_des = $request->sp_code_des;
        $sp_payment_option = $request->sp_payment_option;
        $date = date('Y-m-d');
        if($status == 'Failed'){
            return redirect('serviceCategory')->with('errorMessage', 'আবার চেষ্টা করুন।');;
            return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
        }
        else {
            $result = DB::table('payment_info')->insert([
                'user_id' => Cookie::get('user_id'),
                'status' => $status,
                'type' => $type,
                'msg' => $msg,
                'tx_id' => $tx_id,
                'bank_tx_id' => $bank_tx_id,
                'amount' => $amount,
                'bank_status' => $bank_status,
                'sp_code' => $sp_code,
                'sp_code_des' => $sp_code_des,
                'sp_payment_option' => $sp_payment_option,
            ]);
            if ($result) {
                $sessRequest = json_encode(Session::get('bookingNHT'));
                $sessRequest = json_decode($sessRequest);
                $rows = DB::table('toor_booking2')
                    ->where('id', $sessRequest->main_id)
                    ->first();
                $date1 = $sessRequest->startDate;
                $date2 = "$sessRequest->endDate";
                $diff = abs(strtotime($date2) - strtotime($date1));
                $years = floor($diff / (365 * 60 * 60 * 24));
                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                $price = (int)$days * $sessRequest->number * $rows->price;
                $result = DB::table('bookingtnt')->insert([
                    'tx_id' => $tx_id,
                    'pack_id' => $sessRequest->main_id,
                    'user_id' => Cookie::get('user_id'),
                    'room_no' => $sessRequest->number,
                    'startDate' => $sessRequest->startDate,
                    'endDate' => $sessRequest->endDate,
                    'date' => Date('Y-m-d'),
                    'price' => $price,
                ]);
                if ($result) {
                    return redirect()->to('myToursNTravels')->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                } else {
                    return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                }
            } else {
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }
        }
    }
    public function insertBookingHNTOnCash(){
        $tx_id = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(16/strlen($x)) )),1,16);
        $sessRequest = json_encode(Session::get('bookingNHT'));
        $sessRequest = json_decode($sessRequest);
        $rows = DB::table('toor_booking2')
            ->where('id',$sessRequest->main_id)
            ->first();
        $date1 =  $sessRequest->startDate;
        $date2 = "$sessRequest->endDate";
        $diff = abs(strtotime($date2) - strtotime($date1));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        $price = (int) $days*$sessRequest->number*$rows->price;
        $result = DB::table('bookingtnt')->insert([
            'tx_id' => $tx_id,
            'pack_id' => $sessRequest->main_id,
            'user_id' => Cookie::get('user_id'),
            'room_no' => $sessRequest->number,
            'startDate' => $sessRequest->startDate,
            'endDate' => $sessRequest->endDate,
            'date' => Date('Y-m-d'),
            'price' => $price,
        ]);
        if($result){
            return redirect()->to('myToursNTravels')->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
        }
        else{
            return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
        }
    }
    public function bookingTourPackage(Request $request){
        $rows = DB::table('toor_booking2')
            ->select('*','toor_booking2.id as t_id','toor_booking2.description  as facilities' )
            ->join('toor_booking1','toor_booking2.name_id','=','toor_booking1.id')
            ->where('toor_booking2.name_id',$request->id)
            ->paginate(20);
        return view('frontend.bookingTourPackage', ['results' => $rows]);
    }
    public function insertTourPackagePayOnline(Request $request){
        $sessRequest = json_encode(Session::get('bookingTourPackage'));
        $sessRequest = json_decode($sessRequest);
        if(@$sessRequest->cod ==1){
            $tx_id = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(16/strlen($x)) )),1,16);
        }
        else{
            $tx_id = $request->tx_id;
            $status = $request->status;
            $type = 'Tours N Travel Booking';
            $msg = $request->msg;
            $bank_tx_id = $request->bank_tx_id;
            $amount = $request->amount;
            $bank_status = $request->bank_status;
            $sp_code = $request->sp_code;
            $sp_code_des = $request->sp_code_des;
            $sp_payment_option = $request->sp_payment_option;
            $date = date('Y-m-d');
            if($status == 'Failed'){
                return redirect('serviceCategory')->with('errorMessage', 'আবার চেষ্টা করুন।');;
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }
            else {
                $result = DB::table('payment_info')->insert([
                    'user_id' => Cookie::get('user_id'),
                    'status' => $status,
                    'type' => $type,
                    'msg' => $msg,
                    'tx_id' => $tx_id,
                    'bank_tx_id' => $bank_tx_id,
                    'amount' => $amount,
                    'bank_status' => $bank_status,
                    'sp_code' => $sp_code,
                    'sp_code_des' => $sp_code_des,
                    'sp_payment_option' => $sp_payment_option,
                ]);
            }
        }
        $result = DB::table('bookingtnt')->insert([
            'tx_id' => $tx_id,
            'pack_id' => $sessRequest->main_id,
            'user_id' => Cookie::get('user_id'),
            'room_no' => 1,
            'startDate' =>  Date('Y-m-d'),
            'endDate' =>  Date('Y-m-d'),
            'date' => Date('Y-m-d'),
            'price' => $sessRequest->price,
        ]);
        if ($result) {
            return redirect()->to('myToursNTravels')->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
        } else {
            return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
        }
    }
}
