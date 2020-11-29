<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class TankCleanerController extends Controller
{
    public function tankCleanerProfile  (Request  $request){
        try{
            $id = Cookie::get('user_id');
            $user_info = DB::table('users')
                ->select('user_type.name as desig', 'users.*')
                ->join('user_type', 'user_type.id', '=', 'users.user_type')
                ->where('users.id', $id)
                ->where('users.status', 1)
                ->first();
            $users['info'] = $user_info;
            $washing = DB::table('cleaning_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','cleaning_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'cleaning_order.user_id')
                ->join('users as b', 'b.id', '=', 'cleaning_order.cleaner_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->where('b.id',$id )
                ->where('cleaning_order.type','ট্যাংক' )
                ->orderBy('cleaning_order.id','desc')
                ->paginate(20);
            return view('backend.tankCleanerProfile ',['washings' =>$washing,'users'=> $users]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
}
