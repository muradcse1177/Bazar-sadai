<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
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
}
