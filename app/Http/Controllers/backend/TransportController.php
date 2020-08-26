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
                        return back()->with('errorMessage', ' নতুন বিভাগ লিখুন।');
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

}
