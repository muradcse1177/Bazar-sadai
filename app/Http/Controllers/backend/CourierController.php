<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class CourierController extends Controller
{
    public function courierProfile(Request $request){
        $rows = DB::table('courier_booking')
            ->select('*','naming1s.name as n_name','courier_type.name as c_name','courier_status.status as c_status','courier_status.id as c_id','courier_status.c_id as cc_id')
            ->join('courier_type','courier_type.id','=','courier_booking.type')
            ->join('courier_status','courier_status.c_id','=','courier_booking.id')
            ->join('naming1s','naming1s.id','=','courier_booking.f_country')
            ->where('delivery_id',Cookie::get('user_id'))
            ->orderBy('courier_booking.id','desc')
            ->get();
        $booking =array();
        $i = 0;
        foreach ($rows as $couriers) {
            $service_area = DB::table('service_area')
                ->where('user_id',$couriers->user_id)
                ->first();
            $user = DB::table('users')
                ->where('id',$couriers->user_id)
                ->first();
            $address_type_service_area = $service_area->address_type;
            if($address_type_service_area==1){
                $add_part1 = DB::table('divisions')
                    ->where('id',$service_area->add_part1)
                    ->first();
                $add_part2 = DB::table('districts')
                    ->where('div_id',$service_area->add_part1)
                    ->where('id',$service_area->add_part2)
                    ->first();
                $add_part3 = DB::table('upazillas')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('id',$service_area->add_part3)
                    ->first();
                $add_part4 = DB::table('unions')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('upz_id',$service_area->add_part3)
                    ->where('id',$service_area->add_part4)
                    ->first();
            }
            if($address_type_service_area==2){
                $add_part1 = DB::table('divisions')
                    ->where('id',$service_area->add_part1)
                    ->first();
                $add_part2 = DB::table('cities')
                    ->where('div_id',$service_area->add_part1)
                    ->where('id',$service_area->add_part2)
                    ->first();
                $add_part3 = DB::table('city_corporations')
                    ->where('div_id',$service_area->add_part1)
                    ->where('city_id',$service_area->add_part2)
                    ->where('id',$service_area->add_part3)
                    ->first();
                $add_part4 = DB::table('thanas')
                    ->where('div_id',$service_area->add_part1)
                    ->where('city_id',$service_area->add_part2)
                    ->where('city_co_id',$service_area->add_part3)
                    ->where('id',$service_area->add_part4)
                    ->first();
            }
            if($address_type_service_area==3){
                $add_part1 = DB::table('naming1s')
                    ->where('id',$service_area->add_part1)
                    ->first();
                $add_part2 = DB::table('naming2s')
                    ->where('div_id',$service_area->add_part1)
                    ->where('id',$service_area->add_part2)
                    ->first();
                $add_part3 = DB::table('naming3s')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('id',$service_area->add_part3)
                    ->first();
                $add_part4 = DB::table('naming4')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('upz_id',$service_area->add_part3)
                    ->where('id',$service_area->add_part4)
                    ->first();
            }
            if($couriers->address_type==1){
                $add_part1C = DB::table('divisions')
                    ->where('id',$couriers->add_part1)
                    ->first();
                $add_part2C = DB::table('districts')
                    ->where('div_id',$couriers->add_part1)
                    ->where('id',$couriers->add_part2)
                    ->first();
                $add_part3C = DB::table('upazillas')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('id',$couriers->add_part3)
                    ->first();
                $add_part4C = DB::table('unions')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('id',$couriers->add_part4)
                    ->first();
                $add_part5C = DB::table('wards')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('uni_id',$couriers->add_part4)
                    ->where('id',$couriers->add_part5)
                    ->first();
            }
            if($couriers->address_type==2){
                $add_part1C = DB::table('divisions')
                    ->where('id',$couriers->add_part1)
                    ->first();
                $add_part2C = DB::table('cities')
                    ->where('div_id',$couriers->add_part1)
                    ->where('id',$couriers->add_part2)
                    ->first();
                $add_part3C = DB::table('city_corporations')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('id',$couriers->add_part3)
                    ->first();
                $add_part4C = DB::table('thanas')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('id',$couriers->add_part4)
                    ->first();
                $add_part5C = DB::table('c_wards')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('uni_id',$couriers->add_part4)
                    ->where('id',$couriers->add_part5)
                    ->first();
            }
            if($couriers->address_type==3){
                $add_part1C = DB::table('naming1s')
                    ->where('id',$couriers->add_part1)
                    ->first();
                $add_part2C = DB::table('naming2s')
                    ->where('div_id',$couriers->add_part1)
                    ->where('id',$couriers->add_part2)
                    ->first();
                $add_part3C = DB::table('naming3s')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('id',$couriers->add_part3)
                    ->first();
                $add_part4C = DB::table('naming4')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('id',$couriers->add_part4)
                    ->first();
                $add_part5C = DB::table('naming5s')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('uni_id',$couriers->add_part4)
                    ->where('id',$couriers->add_part5)
                    ->first();
            }
            $booking[$i]['date'] = $couriers->date;
            $booking[$i]['user'] = $user->name;
            $booking[$i]['user_phone'] = $user->phone;
            $booking[$i]['add_part1'] = $add_part1->name;
            $booking[$i]['add_part2'] = $add_part2->name;
            $booking[$i]['add_part3'] = $add_part3->name;
            $booking[$i]['add_part4'] = $add_part4->name;
            $booking[$i]['add_part1C'] = $add_part1C->name;
            $booking[$i]['add_part2C'] = $add_part2C->name;
            $booking[$i]['add_part3C'] = $add_part3C->name;
            $booking[$i]['add_part4C'] = $add_part4C->name;
            $booking[$i]['add_part5C'] = $add_part5C->name;
            $booking[$i]['address'] = $couriers->address;
            $booking[$i]['n_name'] = $couriers->n_name;
            $booking[$i]['cost'] = $couriers->cost;
            $booking[$i]['weight'] = $couriers->weight;
            $booking[$i]['tx_id'] = $couriers->tx_id;
            $booking[$i]['status'] = $couriers->c_status;
            $booking[$i]['id'] = $couriers->c_id;
            $booking[$i]['cc_id'] = $couriers->cc_id;
            $i++;

        }
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($booking);
        $perPage = 20;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $paginatedItems->setPath($request->url());
        return view('backend.courierProfile',['bookings' => $paginatedItems]);
    }
    public function changeCourierStatus(Request  $request){
        try{
            if($request->id) {
                $result =DB::table('courier_status')
                    ->where('id', $request->id)
                    ->update([
                        'status' =>  $request->statusA,
                    ]);
                if ($result) {
                    return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                } else {
                    return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                }
            }
            else{
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }

        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function changeCourierMessage(Request  $request){
        try{
            if($request->msg) {
                $result = DB::table('courier_status2')->insert([
                    'm_id'=> $request->msg,
                    'msg' =>  $request->message,
                    'date' =>  date('Y-m-d'),
                ]);
                if ($result) {
                    return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                } else {
                    return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                }
            }
            else{
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }

        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getCourierMessageAdmin(Request  $request){
        $output = array('list'=>'');
        $rows = DB::table('courier_status2')
            ->where('m_id',$request->id)
            ->orderBy('id','desc')
            ->get();
        foreach ($rows as $status){
            $output['list'] .= "
            <p>Date: $status->date</p>
            <p>Status: $status->msg</p>
            <img src='public/asset/images/uparrow.png' height='20' width='20'>
            ";
        }
        return response()->json(array('output'=>$output));
    }

}
