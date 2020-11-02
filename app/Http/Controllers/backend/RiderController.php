<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class RiderController extends Controller
{
    public function myRiding(Request $request){
        $rows = DB::table('ride_booking')
            ->where('rider_id',Cookie::get('user_id'))
            ->get();
        $booking =array();
        $i = 0;
        foreach ($rows as $riding){
            $user_id = $riding->user_id;
            $address_type = $riding->address_type;
            $address_typep = $riding->address_type;
            $service_area = DB::table('service_area')
                ->where('user_id',$user_id)
                ->first();
            $user = DB::table('users')
                ->where('id', $user_id)
                ->first();
            if($address_type==1){
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
                    ->where('id',$riding->add_part3)
                    ->first();
                $add_part4 = DB::table('unions')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('upz_id',$riding->add_part3)
                    ->where('id',$riding->add_part4)
                    ->first();
            }
            if($address_type==2){
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
                    ->where('id',$riding->add_part3)
                    ->first();
                $add_part4 = DB::table('thanas')
                    ->where('div_id',$service_area->add_part1)
                    ->where('city_id',$service_area->add_part2)
                    ->where('city_co_id',$riding->add_part3)
                    ->where('id',$riding->add_part4)
                    ->first();
            }
            if($address_typep==1){
                $add_partp1 = DB::table('divisions')
                    ->where('id',$riding->add_partp1)
                    ->first();
                $add_partp2 = DB::table('districts')
                    ->where('div_id',$riding->add_partp1)
                    ->where('id',$riding->add_partp2)
                    ->first();
                $add_partp3 = DB::table('upazillas')
                    ->where('div_id',$riding->add_partp1)
                    ->where('dis_id',$riding->add_partp2)
                    ->where('id',$riding->add_partp3)
                    ->first();
                $add_partp4 = DB::table('unions')
                    ->where('div_id',$riding->add_partp1)
                    ->where('dis_id',$riding->add_partp2)
                    ->where('upz_id',$riding->add_partp3)
                    ->where('id',$riding->add_partp4)
                    ->first();
            }
            if($address_typep==2){
                $add_partp1 = DB::table('divisions')
                    ->where('id',$riding->add_partp1)
                    ->first();
                $add_partp2 = DB::table('cities')
                    ->where('div_id',$riding->add_partp1)
                    ->where('id',$riding->add_partp2)
                    ->first();
                $add_partp3 = DB::table('city_corporations')
                    ->where('div_id',$riding->add_partp1)
                    ->where('city_id',$riding->add_partp2)
                    ->where('id',$riding->add_partp3)
                    ->first();
                $add_partp4 = DB::table('thanas')
                    ->where('div_id',$riding->add_partp1)
                    ->where('city_id',$riding->add_partp2)
                    ->where('city_co_id',$riding->add_partp3)
                    ->where('id',$riding->add_partp4)
                    ->first();
            }
            if($riding->transport =='Motorcycle'){
                if($address_type==1){
                    $add_partp1 = DB::table('divisions')
                        ->where('id',$service_area->add_part1)
                        ->first();
                    $add_partp2 = DB::table('districts')
                        ->where('div_id',$service_area->add_part1)
                        ->where('id',$service_area->add_part2)
                        ->first();
                    $add_partp3 = DB::table('upazillas')
                        ->where('div_id',$service_area->add_part1)
                        ->where('dis_id',$service_area->add_part2)
                        ->where('id',$riding->add_partp3)
                        ->first();
                    $add_partp4 = DB::table('unions')
                        ->where('div_id',$service_area->add_part1)
                        ->where('dis_id',$service_area->add_part2)
                        ->where('upz_id',$riding->add_partp3)
                        ->where('id',$riding->add_partp4)
                        ->first();
                }
                if($address_type==2){
                    $add_partp1 = DB::table('divisions')
                        ->where('id',$service_area->add_part1)
                        ->first();
                    $add_partp2 = DB::table('cities')
                        ->where('div_id',$service_area->add_part1)
                        ->where('id',$service_area->add_part2)
                        ->first();
                    $add_partp3 = DB::table('city_corporations')
                        ->where('div_id',$service_area->add_part1)
                        ->where('city_id',$service_area->add_part2)
                        ->where('id',$riding->add_partp3)
                        ->first();
                    $add_partp4 = DB::table('thanas')
                        ->where('div_id',$service_area->add_part1)
                        ->where('city_id',$service_area->add_part2)
                        ->where('city_co_id',$riding->add_part3)
                        ->where('id',$riding->add_partp4)
                        ->first();
                }
            }
            $booking[$i]['id'] = $riding->id;
            $booking[$i]['date'] = $riding->date;
            $booking[$i]['transport'] = $riding->transport;
            $booking[$i]['user'] = $user->name;
            $booking[$i]['phone'] = $user->phone;
            $booking[$i]['add_part1'] = $add_part1->name;
            $booking[$i]['add_part2'] = $add_part2->name;
            $booking[$i]['add_part3'] = $add_part3->name;
            $booking[$i]['add_part4'] = $add_part4->name;
            $booking[$i]['add_partp1'] = @$add_partp1->name;
            $booking[$i]['add_partp2'] = @$add_partp2->name;
            $booking[$i]['add_partp3'] = @$add_partp3->name;
            $booking[$i]['add_partp4'] = @$add_partp4->name;
            $booking[$i]['c_distance'] = $riding->customer_distance;
            $booking[$i]['c_cost'] = $riding->cutomer_cost;
            $booking[$i]['r_distance'] = $riding->rider_distance;
            $booking[$i]['r_cost'] = $riding->rider_cost;
            $i++;
        }
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($booking);
        $perPage = 20;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $paginatedItems->setPath($request->url());
        return view('backend.myRiding',['bookings' => $paginatedItems]);
    }
    public function myRidingListByDate(Request $request){
        $rows = DB::table('ride_booking')
            ->where('rider_id',Cookie::get('user_id'))
            ->whereBetween('date',array($request->from_date,$request->to_date))
            ->get();
        $booking =array();
        $i = 0;
        foreach ($rows as $riding){
            $user_id = $riding->user_id;
            $address_type = $riding->address_type;
            $address_typep = $riding->address_type;
            $service_area = DB::table('service_area')
                ->where('user_id',$user_id)
                ->first();
            $user = DB::table('users')
                ->where('id', $user_id)
                ->first();
            if($address_type==1){
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
                    ->where('id',$riding->add_part3)
                    ->first();
                $add_part4 = DB::table('unions')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('upz_id',$riding->add_part3)
                    ->where('id',$riding->add_part4)
                    ->first();
            }
            if($address_type==2){
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
                    ->where('id',$riding->add_part3)
                    ->first();
                $add_part4 = DB::table('thanas')
                    ->where('div_id',$service_area->add_part1)
                    ->where('city_id',$service_area->add_part2)
                    ->where('city_co_id',$riding->add_part3)
                    ->where('id',$riding->add_part4)
                    ->first();
            }
            if($address_typep==1){
                $add_partp1 = DB::table('divisions')
                    ->where('id',$riding->add_partp1)
                    ->first();
                $add_partp2 = DB::table('districts')
                    ->where('div_id',$riding->add_partp1)
                    ->where('id',$riding->add_partp2)
                    ->first();
                $add_partp3 = DB::table('upazillas')
                    ->where('div_id',$riding->add_partp1)
                    ->where('dis_id',$riding->add_partp2)
                    ->where('id',$riding->add_partp3)
                    ->first();
                $add_partp4 = DB::table('unions')
                    ->where('div_id',$riding->add_partp1)
                    ->where('dis_id',$riding->add_partp2)
                    ->where('upz_id',$riding->add_partp3)
                    ->where('id',$riding->add_partp4)
                    ->first();
            }
            if($address_typep==2){
                $add_partp1 = DB::table('divisions')
                    ->where('id',$riding->add_partp1)
                    ->first();
                $add_partp2 = DB::table('cities')
                    ->where('div_id',$riding->add_partp1)
                    ->where('id',$riding->add_partp2)
                    ->first();
                $add_partp3 = DB::table('city_corporations')
                    ->where('div_id',$riding->add_partp1)
                    ->where('city_id',$riding->add_partp2)
                    ->where('id',$riding->add_partp3)
                    ->first();
                $add_partp4 = DB::table('thanas')
                    ->where('div_id',$riding->add_partp1)
                    ->where('city_id',$riding->add_partp2)
                    ->where('city_co_id',$riding->add_partp3)
                    ->where('id',$riding->add_partp4)
                    ->first();
            }
            if($riding->transport =='Motorcycle'){
                if($address_type==1){
                    $add_partp1 = DB::table('divisions')
                        ->where('id',$service_area->add_part1)
                        ->first();
                    $add_partp2 = DB::table('districts')
                        ->where('div_id',$service_area->add_part1)
                        ->where('id',$service_area->add_part2)
                        ->first();
                    $add_partp3 = DB::table('upazillas')
                        ->where('div_id',$service_area->add_part1)
                        ->where('dis_id',$service_area->add_part2)
                        ->where('id',$riding->add_partp3)
                        ->first();
                    $add_partp4 = DB::table('unions')
                        ->where('div_id',$service_area->add_part1)
                        ->where('dis_id',$service_area->add_part2)
                        ->where('upz_id',$riding->add_partp3)
                        ->where('id',$riding->add_partp4)
                        ->first();
                }
                if($address_type==2){
                    $add_partp1 = DB::table('divisions')
                        ->where('id',$service_area->add_part1)
                        ->first();
                    $add_partp2 = DB::table('cities')
                        ->where('div_id',$service_area->add_part1)
                        ->where('id',$service_area->add_part2)
                        ->first();
                    $add_partp3 = DB::table('city_corporations')
                        ->where('div_id',$service_area->add_part1)
                        ->where('city_id',$service_area->add_part2)
                        ->where('id',$riding->add_partp3)
                        ->first();
                    $add_partp4 = DB::table('thanas')
                        ->where('div_id',$service_area->add_part1)
                        ->where('city_id',$service_area->add_part2)
                        ->where('city_co_id',$riding->add_part3)
                        ->where('id',$riding->add_partp4)
                        ->first();
                }
            }
            $booking[$i]['id'] = $riding->id;
            $booking[$i]['date'] = $riding->date;
            $booking[$i]['transport'] = $riding->transport;
            $booking[$i]['user'] = $user->name;
            $booking[$i]['phone'] = $user->phone;
            $booking[$i]['add_part1'] = $add_part1->name;
            $booking[$i]['add_part2'] = $add_part2->name;
            $booking[$i]['add_part3'] = $add_part3->name;
            $booking[$i]['add_part4'] = $add_part4->name;
            $booking[$i]['add_partp1'] = @$add_partp1->name;
            $booking[$i]['add_partp2'] = @$add_partp2->name;
            $booking[$i]['add_partp3'] = @$add_partp3->name;
            $booking[$i]['add_partp4'] = @$add_partp4->name;
            $booking[$i]['c_distance'] = $riding->customer_distance;
            $booking[$i]['c_cost'] = $riding->cutomer_cost;
            $booking[$i]['r_distance'] = $riding->rider_distance;
            $booking[$i]['r_cost'] = $riding->rider_cost;
            $i++;
        }
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($booking);
        $perPage = 20;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $paginatedItems->setPath($request->url());
        return view('backend.myRiding',['bookings' => $paginatedItems,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
    }
    public function riderServiceArea(Request $request){
        $service_area = DB::table('rider_service_area')
            ->where('user_id',Cookie::get('user_id'))
            ->first();
        if(empty($service_area)){
            return view('backend.riderServiceArea');
        }
        else{
            if($service_area->address_type ==1){
                $rows = DB::table('unions')
                    ->select('divisions.name as divName',
                        'districts.name as disName','upazillas.name as upzName', 'unions.name as uniName')
                    ->join('upazillas', 'upazillas.id', '=', 'unions.upz_id')
                    ->join('districts', 'districts.id', '=', 'upazillas.dis_id')
                    ->join('divisions', 'divisions.id', '=', 'districts.div_id')
                    ->where('unions.status', 1)
                    ->where('unions.div_id', $service_area->add_part1)
                    ->where('unions.dis_id', $service_area->add_part2)
                    ->where('unions.upz_id', $service_area->add_part3)
                    ->where('unions.id', $service_area->add_part4)
                    ->first();
            }
            if($service_area->address_type ==2){
                $rows = DB::table('thanas')
                    ->select('divisions.name as divName',
                        'cities.name as disName','city_corporations.name as upzName', 'thanas.name as uniName')
                    ->join('city_corporations', 'city_corporations.id', '=', 'thanas.city_co_id')
                    ->join('cities', 'cities.id', '=', 'city_corporations.city_id')
                    ->join('divisions', 'divisions.id', '=', 'cities.div_id')
                    ->where('thanas.status', 1)
                    ->where('thanas.div_id', $service_area->add_part1)
                    ->where('thanas.city_id', $service_area->add_part2)
                    ->where('thanas.city_co_id', $service_area->add_part3)
                    ->where('thanas.id', $service_area->add_part4)
                    ->first();
            }
            $id = Cookie::get('user_id');
            $user_info = DB::table('users')
                ->select('user_type.name as desig', 'users.*')
                ->join('user_type', 'user_type.id', '=', 'users.user_type')
                ->where('users.id', $id)
                ->where('users.status', 1)
                ->first();
            $users['info'] = $user_info;
            return view('backend.riderServiceArea',['name' => $rows,'users'=>$users]);
        }

    }
    public function insertRiderServiceArea(Request $request){
        $addressGroup = $request->addressGroup;
        $add_part1 = $request->div_id;
        if ($addressGroup == 1) {
            $add_part2 = $request->disid;
            $add_part3 = $request->upzid;
            $add_part4 = $request->uniid;
        }
        if ($addressGroup == 2) {
            $add_part2 = $request->c_disid;
            $add_part3 = $request->c_upzid;
            $add_part4 = $request->c_uniid;
        }
        $rows = DB::table('rider_service_area')
            ->where('user_id', Cookie::get('user_id'))
            ->distinct()->get()->count();
        if ($rows > 0) {
            $result = DB::table('rider_service_area')
                ->where('user_id', Cookie::get('user_id'))
                ->update([
                    'address_type' => $addressGroup,
                    'add_part1' => $add_part1,
                    'add_part2' => $add_part2,
                    'add_part3' => $add_part3,
                    'add_part4' => $add_part4,
                ]);
            if ($result) {
                return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
            } else {
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }
        }
        else{
            $result = DB::table('rider_service_area')->insert([
                'user_id' => Cookie::get('user_id'),
                'address_type' => $addressGroup,
                'add_part1' => $add_part1,
                'add_part2' => $add_part2,
                'add_part3' => $add_part3,
                'add_part4' => $add_part4,
            ]);
            if ($result) {
                return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
            } else {
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }
        }
    }
    public function setRiderDistance(Request $request){
        $ride_info = DB::table('ride_booking')
            ->where('id',$request->id)
            ->first();
        $row = DB::table('transport_cost')
            ->where('transport_type',$ride_info->transport)
            ->first();
        $distance = $request->distance;
        $minCost = $row->minCost;
        if($distance<=10){
            $cost = $minCost + $distance*$row->km1;
        }
        elseif($distance>10 && $distance<=30){
            $cost = $minCost + $distance*$row->km2;
        }
        elseif($distance>30 && $distance<=50){
            $cost = $minCost + $distance*$row->km3;
        }
        elseif($distance>50 && $distance<=100){
            $cost = $minCost + $distance*$row->km4;
        }
        elseif($distance>100){
            $cost = $minCost + $distance*$row->km5;
        }
        $result = DB::table('ride_booking')
            ->where('id', $request->id)
            ->update([
                'rider_distance' => $request->distance,
                'rider_cost' => $cost,
            ]);
        if ($result) {
            return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
        } else {
            return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
        }
    }
}
