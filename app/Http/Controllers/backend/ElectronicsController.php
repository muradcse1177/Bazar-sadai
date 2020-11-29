<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class ElectronicsController extends Controller
{
    public function electronicsProfile  (Request  $request){
        try{
            $id = Cookie::get('user_id');
            $user_info = DB::table('users')
                ->select('user_type.name as desig', 'users.*')
                ->join('user_type', 'user_type.id', '=', 'users.user_type')
                ->where('users.id', $id)
                ->where('users.status', 1)
                ->first();
            $users['info'] = $user_info;
            $washing = DB::table('various_servicing_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','various_servicing_order.name as v_name')
                ->join('users as a', 'a.id', '=', 'various_servicing_order.user_id')
                ->join('users as b', 'b.id', '=', 'various_servicing_order.worker')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->where('b.id', $id)
                ->where('various_servicing_order.type', 'ইলেক্ট্রনিক্স')
                ->orderBy('various_servicing_order.id','desc')
                ->paginate(20);
            return view('backend.electronicsProfile ',['washings' =>$washing,'users'=> $users]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
}
