<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransportController extends Controller
{
    public function ticketRoute(){
        $rows = DB::table('transport_tickets')
            ->select('*','transport_tickets.id as tid')
            ->join('transports', 'transports.id', '=', 'transport_tickets.transport_id')
            ->join('transports_caoch', 'transports_caoch.id', '=', 'transport_tickets.coach_id')
            ->join('transport_types', 'transport_types.id', '=', 'transport_tickets.type_id')
            ->where('transport_tickets.status', 1)
            ->Paginate(10);
        //dd($rows);
        return view('backend.ticketRoutePage', ['transports_tickets' => $rows]);
    }
    public function coachPage(){
        $rows = DB::table('transports_caoch')
            ->join('transports', 'transports.id', '=', 'transports_caoch.transport_id')
            ->where('transports_caoch.status', 1)
            ->orderBy('transports_caoch.id', 'DESC')->Paginate(10);
        return view('backend.coachPage', ['transports_caoches' => $rows]);
    }
    public function getCoachList(Request $request){
        try{
            $rows = DB::table('transports_caoch')->where('id', $request->id)->first();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getCoachListById(Request $request){
        try{
            $rows = DB::table('transports_caoch')
                ->where('transport_id', $request->id)
                ->where('status', 1)
                ->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertCoach(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('transports_caoch')
                        ->where('id', $request->id)
                        ->update([
                            'transport_id' => $request->transport_id,
                            'coach_name' => $request->coach,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('transports_caoch')->select('id')->where([
                        ['transport_id', '=', $request->transport_id],
                        ['coach_name', '=', $request->coach]
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন কোচ লিখুন।');
                    } else {
                        $result = DB::table('transports_caoch')->insert([
                            'transport_id' => $request->transport_id,
                            'coach_name' => $request->coach,
                        ]);
                        if ($result) {
                            return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                        } else {
                            return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                        }
                    }
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

    public function deleteCoach (Request $request){
        try{

            if($request->id) {
                $result =DB::table('transports_caoch')
                    ->where('id', $request->id)
                    ->update([
                        'status' =>  0,
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
    public function getAllTransportList(Request $request){
        try{
            $rows = DB::table('transports')->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getTransportTypeList(Request $request){
        try{
            $rows = DB::table('transport_types')->where('tranport_id', $request->id)->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertTicketRoute(Request $request){
        try{
            if($request) {
               //dd($request);
                if($request->id) {
                    $result =DB::table('transport_tickets')
                        ->where('id', $request->id)
                        ->update([
                            'transport_id' => $request->transport_id,
                            'from_address' => $request->from_address,
                            'to_address' => $request->to_address,
                            'coach_id' => $request->coach_id,
                            'type_id' => $request->type_id,
                            'price' =>  $request->price,
                            'time' =>  $request->time,
                            'status' => $request->status,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('transport_tickets')->select('id')->where([
                        ['transport_id', '=', $request->transport_id],
                        ['from_address', '=', $request->from_address],
                        ['to_address', '=', $request->to_address],
                        ['coach_id', '=', $request->coach_id],
                        ['type_id' ,'=' ,$request->type_id],
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন রুট লিখুন।');
                    } else {
                        $result = DB::table('transport_tickets')->insert([
                            'transport_id' => $request->transport_id,
                            'from_address' => $request->from_address,
                            'to_address'=> $request->to_address,
                            'coach_id' => $request->coach_id,
                            'type_id' => $request->type_id,
                            'price' => $request->price,
                            'time' =>  $request->time,
                            'status' => $request->status,
                        ]);
                        if ($result) {
                            return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                        } else {
                            return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                        }
                    }
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
    public function getTicketRouteList(Request $request){
        try{
            $rows = DB::table('transport_tickets')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }

    public function deleteTransportsTickets (Request $request){
        try{

            if($request->id) {
                $result =DB::table('transport_tickets')
                    ->where('id', $request->id)
                    ->update([
                        'status' =>  0,
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
    public function transportCost(){
        $rows = DB::table('transport_cost')
            ->Paginate(10);
        return view('backend.transportCost', ['costs' => $rows]);
    }
    public function insertTransportCost(Request $request){
        try{
            if($request) {
                //dd($request);
                if($request->id) {
                    $result =DB::table('transport_cost')
                        ->where('id', $request->id)
                        ->update([
                            'transport_type' => $request->transport,
                            'minCost' => $request->minCost,
                            'km1' => $request->km1,
                            'km2' => $request->km2,
                            'km3' => $request->km3,
                            'km4' =>  $request->km4,
                            'km5' =>  $request->km5,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('transport_cost')->select('id')->where([
                        ['transport_type', '=', $request->transport],
                    ])->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুনভাবে লিখুন।');
                    } else {
                        $result = DB::table('transport_cost')->insert([
                            'transport_type' => $request->transport,
                            'minCost' => $request->minCost,
                            'km1' => $request->km1,
                            'km2' => $request->km2,
                            'km3' => $request->km3,
                            'km4' =>  $request->km4,
                            'km5' =>  $request->km5,
                        ]);
                        if ($result) {
                            return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                        } else {
                            return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                        }
                    }
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
    public function getTransportCostList(Request $request){
        try{
            $rows = DB::table('transport_cost')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteTransportCost (Request $request){
        try{
            if($request->id) {
                $result =DB::table('transport_cost')
                    ->where('id', $request->id)
                    ->delete();
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
    public function courierType(){
        $rows = DB::table('courier_type')
            ->Paginate(10);
        return view('backend.courierType', ['courierTypes' => $rows]);
    }
    public function insertCourierType(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('courier_type')
                        ->where('id', $request->id)
                        ->update([
                            'name' =>  $request->name,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('courier_type')->select('name')->where([
                        ['name', '=', $request->name]
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন বিভাগ লিখুন।');
                    } else {
                        $result = DB::table('courier_type')->insert([
                            'name' => $request->name
                        ]);
                        if ($result) {
                            return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                        } else {
                            return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                        }
                    }
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
    public function getCourierTypeList(Request $request){
        try{
            $rows = DB::table('courier_type')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteCourierType (Request $request){
        try{
            if($request->id) {
                $result =DB::table('courier_type')
                    ->where('id', $request->id)
                    ->delete();
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
    public function courierSettings(){
        $rows = DB::table('courier_settings')
            ->select('*','courier_settings.id as c_id','courier_type.name as c_name')
            ->join('courier_type','courier_type.id','=','courier_settings.type')
            ->join('naming1s','naming1s.id','=','courier_settings.f_country')
            ->Paginate(20);
        return view('backend.courierSettings', ['courierSettings' => $rows]);
    }
    public function getAllCourierType(Request $request){
        try{
            $rows = DB::table('courier_type')
                ->where('status', 1)
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getAllNaming1Country(Request $request){
        try{
            $rows = DB::table('naming1s')->where('status', 1)->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertCourierSettings(Request $request){
        try{
            if($request) {
                if($request->id) {
                    if(!$request->f_country)
                        $f_country = 1;
                    else
                        $f_country = $request->f_country;
                    $result =DB::table('courier_settings')
                        ->where('id', $request->id)
                        ->update([
                            'type' =>  $request->c_type,
                            'country' =>  $request->country,
                            'f_country' =>  $f_country,
                            'weight' =>  $request->weight,
                            'cost' =>  $request->cost,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    if(!$request->f_country)
                        $f_country = 1;
                    else
                        $f_country = $request->f_country;
                    $result = DB::table('courier_settings')->insert([
                        'type' =>  $request->c_type,
                        'country' =>  $request->country,
                        'f_country' => $f_country,
                        'weight' =>  $request->weight,
                        'cost' =>  $request->cost,
                    ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
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
    public function getCourierSettingList(Request $request){
        try{
            $rows = DB::table('courier_settings')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteCourierSetting (Request $request){
        try{
            if($request->id) {
                $result =DB::table('courier_settings')
                    ->where('id', $request->id)
                    ->delete();
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
}
