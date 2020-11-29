<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class CookerController extends Controller
{
    public function cookerProfile  (){
        try{
            $id = Cookie::get('user_id');
            $user_info = DB::table('users')
                ->select('user_type.name as desig', 'users.*')
                ->join('user_type', 'user_type.id', '=', 'users.user_type')
                ->where('users.id', $id)
                ->where('users.status', 1)
                ->first();
            $users['info'] = $user_info;
            $cooking = DB::table('cooking_booking')
                ->select('*','a.name as u_name','a.phone as  u_phone')
                ->join('users as a', 'a.id', '=', 'cooking_booking.user_id')
                ->join('users as b', 'b.id', '=', 'cooking_booking.cooker_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->where('b.id', $id)
                ->paginate(20);
            return view('backend.cookerProfile',['cookings' =>$cooking, 'users'=> $users]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
}
