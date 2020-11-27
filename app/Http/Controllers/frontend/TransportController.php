<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class TransportController extends Controller
{
    public function transportService(){
        return view('frontend.transportServicePage');
    }
    public function getAllFromAddressById(Request $request){
        try{
            $rows = DB::table('transport_tickets')
                ->where('transport_id', $request->id)
                ->distinct()
                ->get('from_address');

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getAllToAddress(Request $request){
        try{

            $rows = DB::table('transport_tickets')
                ->where('from_address', $request->id)
                ->where('transport_id', $request->transport_id)
                ->distinct()
                ->get('to_address');
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getAllTransport(Request $request){
        try{

            $rows = DB::table('transport_tickets')
                ->join('transports_caoch', 'transport_tickets.coach_id', '=', 'transports_caoch.id')
                ->where('from_address', $request->from_address)
                ->where('to_address', $request->to_address)
                ->where('transport_tickets.transport_id', $request->transport_id)
                ->where('transport_tickets.status', 1)
                ->distinct()
                ->get('transports_caoch.coach_name');
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getAllTransportType(Request $request){
        try{
            //dd($request);
            $rows = DB::table('transport_tickets')
                ->join('transport_types', 'transport_tickets.transport_id', '=', 'transport_types.tranport_id')
                ->join('transports_caoch', 'transports_caoch.id', '=', 'transport_tickets.coach_id')
                ->where('transports_caoch.coach_name', $request->transportName)
                ->where('from_address', $request->from_address)
                ->where('to_address', $request->to_address)
                ->where('transport_tickets.transport_id', $request->transport_id)
                ->where('transport_tickets.status', 1)
                ->distinct()
                ->get('transport_types.type');
           // dd($rows);
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getAllTransportTime(Request $request){
        try{
            //dd($request);
            $rows = DB::table('transport_tickets')
                ->join('transport_types as a', 'transport_tickets.transport_id', '=', 'a.tranport_id')
                ->join('transport_types as b', 'transport_tickets.type_id', '=', 'b.id')
                ->join('transports_caoch', 'transports_caoch.id', '=', 'transport_tickets.coach_id')
                ->where('transports_caoch.coach_name', $request->transportName)
                ->where('b.type', $request->transportType)
                ->where('from_address', $request->from_address)
                ->where('to_address', $request->to_address)
                ->where('transport_tickets.transport_id', $request->transport_id)
                ->where('transport_tickets.status', 1)
                ->distinct()
                ->get('transport_tickets.time');
           // dd($rows);
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getTransportPrice(Request $request){
        try{
            //dd($request);
            $rows = DB::table('transport_tickets')
                ->join('transport_types', 'transport_tickets.transport_id', '=', 'transport_types.tranport_id')
                ->join('transports_caoch', 'transports_caoch.id', '=', 'transport_tickets.coach_id')
                ->where('transports_caoch.coach_name', $request->transportName)
                ->where('from_address', $request->from_address)
                ->where('to_address', $request->to_address)
                ->where('transport_types.type', $request->transportType)
                ->where('transport_tickets.transport_id', $request->transport_id)
                ->where('transport_tickets.time', $request->transportTime)
                ->where('transport_tickets.status', 1)
                ->first();
            $ticket_price = $rows->price*$request->adult;
           //dd($rows);
            return response()->json(array('data'=>$ticket_price));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertTransport(Request $request){
        try{
            if($request) {
                if($request->ticketGroup)
                    $transport= $request->ticketGroup;
                if($request->paribahanGroup)
                    $transport= $request->paribahanGroup;
                //dd($request);
                $rows = DB::table('transport_tickets')
                    ->join('transport_types', 'transport_tickets.transport_id', '=', 'transport_types.tranport_id')
                    ->join('transports_caoch', 'transports_caoch.id', '=', 'transport_tickets.coach_id')
                    ->where('transports_caoch.coach_name', $request->transportName)
                    ->where('from_address', $request->from_address)
                    ->where('to_address', $request->to_address)
                    ->where('transport_types.type', $request->transportType)
                    ->where('transport_tickets.transport_id', $request->ticketGroup)
                    ->where('transport_tickets.time', $request->transportTime)
                    ->where('transport_tickets.status', 1)
                    ->first();
                //dd($rows);
                $ticket_price = $rows->price*$request->adult;
                $result = DB::table('ticket_booking')->insert([
                    'user_id' => Cookie::get('user_id'),
                    'type' => $request->type,
                    'transport' => $transport,
                    'from_address' => $request->from_address,
                    'to_address' => $request->to_address	,
                    'adult' => $request->adult	,
                    'child' => $request->child	,
                    'date' => $request->date	,
                    'transport_name' => $request->transportName	,
                    'transport_type' => $request->transportType	,
                    'transport_time' => $request->transportTime	,
                    'price' => $ticket_price,
                ]);
                if ($result) {
                    return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                } else {
                    return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                }
            }
            else{
                return back()->with('errorMessage', 'ফর্ম পুরন করুন।');
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function price(){
        $rows = DB::table('medicine_lists')
            //->limit(10)
           ->get();
        foreach ($rows as $row){
            if (strpos($row->price, '৳') !== false) {
                $priceArr = explode("৳",$row->price);
                $price = (int)$priceArr[1];
            }
            if($row->price = null)
                $price = '';
            $result = DB::table('medicine_list_price')->insert([
                'name' => $row->name	,
                'strength' => $row->strength	,
                'genre' => $row->genre	,
                'type' => $row->type	,
                'company' => $row->company	,
                'price' => $price ,
            ]);
        }
        return 'ok';
    }
    public function serviceArea(){
        return view('frontend.serviceArea');
    }
    public function insertServiceArea(Request $request){
        $addressGroup = $request->addressGroup;
        if ($addressGroup == 1) {
            $add_part1 = $request->div_id;
            $add_part2 = $request->disid;
            $add_part3 = $request->upzid;
            $add_part4 = $request->uniid;
        }
        if ($addressGroup == 2) {
            $add_part1 = $request->div_id;
            $add_part2 = $request->c_disid;
            $add_part3 = $request->c_upzid;
            $add_part4 = $request->c_uniid;
        }
        if ($addressGroup == 3) {
            $add_part1 = $request->naming1;
            $add_part2 = $request->naming2;
            $add_part3 = $request->naming3;
            $add_part4 = $request->naming4;
        }
        $rows = DB::table('service_area')
            ->where('user_id', Cookie::get('user_id'))
            ->distinct()->get()->count();
        if ($rows > 0) {
            $result = DB::table('service_area')
                ->where('user_id', Cookie::get('user_id'))
                ->update([
                    'address_type' => $addressGroup,
                    'add_part1' => $add_part1,
                    'add_part2' => $add_part2,
                    'add_part3' => $add_part3,
                    'add_part4' => $add_part4,
                ]);
            if ($result) {
                return redirect('transportService')->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
            } else {
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }
        }
        else{
            $result = DB::table('service_area')->insert([
                'user_id' => Cookie::get('user_id'),
                'address_type' => $addressGroup,
                'add_part1' => $add_part1,
                'add_part2' => $add_part2,
                'add_part3' => $add_part3,
                'add_part4' => $add_part4,
            ]);
            if ($result) {
                return redirect('transportService')->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
            } else {
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }
        }
    }
    public function getAddressGroupMotor(Request $request){
        try{
            if(Cookie::get('user_id') == null){
                $addressType =0;
                $rows =0;
                $cost=0;
            }
            else {
                $rows = DB::table('service_area')
                    ->where('user_id', Cookie::get('user_id'))
                    ->first();
                if(empty($rows)){
                    $addressType =1;
                    $rows =1;
                    $cost =1;
                }
                else if($rows->address_type == 3){
                    $addressType =3;
                    $rows =3;
                    $cost=3;
                }
                else{
                    $addressType = $rows->address_type;
                    if ($addressType == 1) {
                        $rows = DB::table('upazillas')
                            ->where('div_id', $rows->add_part1)
                            ->where('dis_id', $rows->add_part2)
                            ->where('status', 1)
                            ->get();
                    }
                    if ($addressType == 2) {
                        $rows = DB::table('city_corporations')
                            ->where('div_id', $rows->add_part1)
                            ->where('city_id', $rows->add_part2)
                            ->where('status', 1)
                            ->get();
                    }
                    $cost = DB::table('transport_cost')
                        ->where('transport_type','Motorcycle')
                        ->first();
                }
            }
            return response()->json(array('addressType' => $addressType, 'data' => $rows, 'cost' => $cost));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertMotorcycleRide(Request $request){
        $user = DB::table('service_area')
            ->where('user_id',Cookie::get('user_id'))
            ->first();
        $rider = DB::table('rider_service_area')
            ->join('users','users.id','=','rider_service_area.user_id')
            ->where('rider_service_area.add_part1',$user->add_part1)
            ->where('rider_service_area.add_part2',$user->add_part2)
            ->where('rider_service_area.add_part3',$request->upzid)
            ->where('rider_service_area.add_part4',$request->uniid)
            ->where('rider_service_area.address_type',$request->addressType)
            ->where('users.working_status',1)
            ->where('users.status',1)
            ->where('users.user_type',17)
            ->first();
        if(empty($rider)){
            return back()->with('errorMessage', 'কোন রাইডার পাওয়া যায়নি।');
        }
        else{
            if($request->addressType ==1){
                $add_part3 = $request->upzid;
                $add_part4 = $request->uniid;
                $add_partp3 = $request->upzidp;
                $add_partp4 = $request->uniidp;
            }
            if($request->addressType ==2){
                $add_part3 = $request->c_upzid;
                $add_part4 = $request->c_uniid;
                $add_partp3 = $request->c_upzidp;
                $add_partp4 = $request->c_uniidp;
            }
            $row = DB::table('transport_cost')
                ->where('transport_type','Motorcycle')
                ->first();
            $distance = $request->distanceMotor;
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
            $result = DB::table('ride_booking')->insert([
                'user_id' => Cookie::get('user_id'),
                'transport' => $request->transport,
                'address_type' => $request->addressType,
                'add_part3' => $add_part3,
                'add_part4' => $add_part4,
                'add_partp3' => $add_partp3,
                'add_partp4' => $add_partp4,
                'customer_distance' => $request->distanceMotor,
                'cutomer_cost' => $cost,
                'rider_id' => $rider->id,
                'date' => date('y-m-d'),
            ]);
            if ($result) {
                $upresult =DB::table('users')
                    ->where('id', $rider->user_id)
                    ->update([
                        'working_status' => 2,
                    ]);
                if($upresult){
                    return back()->with('successMessage', 'আপনার রাইডারঃ '.$rider->name." ফোনঃ ".$rider->phone);
                }
                else {
                    return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                }
            }
            else {
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }
        }
    }
    public function getAddressGroupPrivate(Request $request){
        try{
            if(Cookie::get('user_id') == null){
                $addressType =0;
                $rows =0;
                $cost=0;
                $type=0;
            }
            else {
                $rows = DB::table('service_area')
                    ->where('user_id', Cookie::get('user_id'))
                    ->first();
                if(empty($rows)){
                    $addressType =1;
                    $rows =1;
                    $cost =1;
                    $type=1;
                }
                else if($rows->address_type == 3){
                    $addressType =3;
                    $rows =3;
                    $cost=3;
                    $type=3;
                }
                else{
                    $addressType = $rows->address_type;
                    if ($addressType == 1) {
                        $rows = DB::table('upazillas')
                            ->where('div_id', $rows->add_part1)
                            ->where('dis_id', $rows->add_part2)
                            ->where('status', 1)
                            ->get();
                    }
                    if ($addressType == 2) {
                        $rows = DB::table('city_corporations')
                            ->where('div_id', $rows->add_part1)
                            ->where('city_id', $rows->add_part2)
                            ->where('status', 1)
                            ->get();
                    }
                    $cost = DB::table('transport_cost')
                        ->where('transport_type',$request->type)
                        ->first();
                    $type=$request->type;
                }
            }
            return response()->json(array('addressType' => $addressType, 'data' => $rows, 'cost' => $cost ,'transport' => $type));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertPrivateRide(Request $request){
        if($request->transport == 'Private Car')
            $user_type = 18;
        if($request->transport == 'Micro Bus')
            $user_type = 19;
        if($request->transport == 'Ambulance')
            $user_type = 20;
        $user = DB::table('service_area')
            ->where('user_id',Cookie::get('user_id'))
            ->first();
        $rider = DB::table('rider_service_area')
            ->join('users','users.id','=','rider_service_area.user_id')
            ->where('rider_service_area.add_part1',$user->add_part1)
            ->where('rider_service_area.add_part2',$user->add_part2)
            ->where('rider_service_area.address_type',$request->addressType)
            ->where('users.working_status',1)
            ->where('users.status',1)
            ->where('users.user_type',$user_type)
            ->first();
        if(empty($rider)){
            return back()->with('errorMessage', 'কোন রাইডার পাওয়া যায়নি।');
        }
        else{
            if($request->addressType ==1){
                $add_part3 = $request->upzidPri;
                $add_part4 = $request->uniidPri;
            }
            if($request->addressType ==2){
                $add_part3 = $request->c_upzidPri;
                $add_part4 = $request->c_uniidPri;
            }
            if($request->addressGroup ==1){
                $add_partp1 = $request->div_id;
                $add_partp2 = $request->disid;
                $add_partp3 = $request->upzidPostPri;
                $add_partp4 = $request->uniidPostPri;
            }
            if($request->addressGroup ==2){
                $add_partp1 = $request->div_id;
                $add_partp2 = $request->c_disid;
                $add_partp3 = $request->c_upzidPostPri;
                $add_partp4 = $request->c_uniidPostPri;
            }
            $row = DB::table('transport_cost')
                ->where('transport_type',$request->transport)
                ->first();
            $distance = $request->distancePrivate;
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
            $result = DB::table('ride_booking')->insert([
                'user_id' => Cookie::get('user_id'),
                'transport' => $request->transport,
                'address_type' => $request->addressType,
                'add_part3' => $add_part3,
                'add_part4' => $add_part4,
                'address_typep' => $request->addressGroup,
                'add_partp1' => $add_partp1,
                'add_partp2' => $add_partp2,
                'add_partp3' => $add_partp3,
                'add_partp4' => $add_partp4,
                'customer_distance' => $request->distancePrivate,
                'cutomer_cost' => $cost,
                'rider_id' => $rider->id,
                'date' => date('y-m-d'),
            ]);
            if ($result) {
                $upresult =DB::table('users')
                    ->where('id', $rider->user_id)
                    ->update([
                        'working_status' => 2,
                    ]);
                if($upresult){
                    return back()->with('successMessage', 'আপনার রাইডারঃ '.$rider->name." ফোনঃ ".$rider->phone);
                }
                else {
                    return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                }
            }
            else {
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }
        }

    }
    public function courier(){
        return view('frontend.courier');
    }
    public function serviceAreaCourier(){
        return view('frontend.serviceAreaCourier');
    }
    public function insertServiceAreaCourier(Request $request){
        $addressGroup = $request->addressGroup;
        if ($addressGroup == 1) {
            $add_part1 = $request->div_id;
            $add_part2 = $request->disid;
            $add_part3 = $request->upzid;
            $add_part4 = $request->uniid;
        }
        if ($addressGroup == 2) {
            $add_part1 = $request->div_id;
            $add_part2 = $request->c_disid;
            $add_part3 = $request->c_upzid;
            $add_part4 = $request->c_uniid;
        }
        if ($addressGroup == 3) {
            $add_part1 = $request->naming1;
            $add_part2 = $request->naming2;
            $add_part3 = $request->naming3;
            $add_part4 = $request->naming4;
        }
        $rows = DB::table('service_area')
            ->where('user_id', Cookie::get('user_id'))
            ->distinct()->get()->count();
        if ($rows > 0) {
            $result = DB::table('service_area')
                ->where('user_id', Cookie::get('user_id'))
                ->update([
                    'address_type' => $addressGroup,
                    'add_part1' => $add_part1,
                    'add_part2' => $add_part2,
                    'add_part3' => $add_part3,
                    'add_part4' => $add_part4,
                ]);
            if ($result) {
                return redirect('courier')->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
            } else {
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }
        }
        else{
            $result = DB::table('service_area')->insert([
                'user_id' => Cookie::get('user_id'),
                'address_type' => $addressGroup,
                'add_part1' => $add_part1,
                'add_part2' => $add_part2,
                'add_part3' => $add_part3,
                'add_part4' => $add_part4,
            ]);
            if ($result) {
                return redirect('courier')->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
            } else {
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }
        }
    }
    public function getAllCourierWeight(Request $request){
        try{
            $rows = DB::table('courier_settings')
                ->where('type', $request->id)
                ->distinct()
                ->get('weight');
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getAllCourierCost(Request $request){
        try{
            $rows = DB::table('courier_settings')
                ->where('type', $request->type)
                ->where('weight', $request->weight)
                ->where('f_country', $request->id)
                ->first();
            return response()->json(array('data'=>$rows->cost));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getAllCourierCostBd(Request $request){
        try{
            $rows = DB::table('courier_settings')
                ->where('type', $request->type)
                ->where('weight', $request->weight)
                ->where('country', $request->id)
                ->first();
            return response()->json(array('data'=>$rows->cost));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertCourierBooking(Request $request){
        $addressGroup = $request->addressGroup;
        if ($addressGroup == 1) {
            $add_part1 = $request->div_id;
            $add_part2 = $request->disid;
            $add_part3 = $request->upzid;
            $add_part4 = $request->uniid;
            $add_part5 = $request->wardid;
            $f_country =1;
        }
        if ($addressGroup == 2) {
            $add_part1 = $request->div_id;
            $add_part2 = $request->c_disid;
            $add_part3 = $request->c_upzid;
            $add_part4 = $request->c_uniid;
            $add_part5 = $request->c_wardid;
            $f_country =1;
        }
        if ($addressGroup == 3) {
            $add_part1 = $request->naming1;
            $add_part2 = $request->naming2;
            $add_part3 = $request->naming3;
            $add_part4 = $request->naming4;
            $add_part5 = $request->naming5;
            $f_country =$request->f_country;
        }

        $result = DB::table('courier_booking')->insert([
            'user_id' => Cookie::get('user_id'),
            'date' => Date('Y-m-d'),
            'type' => $request->type,
            'weight' => $request->weight,
            'country' => $request->country,
            'f_country' => $f_country,
            'address_type' => $addressGroup,
            'add_part1' => $add_part1,
            'add_part2' => $add_part2,
            'add_part3' => $add_part3,
            'add_part4' => $add_part4,
            'add_part5' => $add_part5,
            'address' => $request->address,
            'cost' => $request->lastPrice,
        ]);
        if ($result) {
            return redirect('courier')->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
        } else {
            return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
        }

    }
}
