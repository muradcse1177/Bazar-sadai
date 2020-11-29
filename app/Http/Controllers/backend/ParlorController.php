<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class ParlorController extends Controller
{
    public function parlorProfile  (Request  $request){
        try{
            $id = Cookie::get('user_id');
            $user_info = DB::table('users')
                ->select('user_type.name as desig', 'users.*')
                ->join('user_type', 'user_type.id', '=', 'users.user_type')
                ->where('users.id', $id)
                ->where('users.status', 1)
                ->first();
            $users['info'] = $user_info;
            $washing = DB::table('parlor_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','parlor_order.name as v_name')
                ->join('users as a', 'a.id', '=', 'parlor_order.user_id')
                ->join('users as b', 'b.id', '=', 'parlor_order.parlor_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->where('b.id', $id)
                ->orderBy('parlor_order.id','desc')
                ->paginate(20);
            return view('backend.parlorProfile ',['washings' =>$washing,'users'=> $users]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
}
