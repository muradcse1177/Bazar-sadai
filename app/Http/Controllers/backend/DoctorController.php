<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    public function doctorServiceArea(Request $request){
        $service_area = DB::table('rider_service_area')
            ->where('user_id',Cookie::get('user_id'))
            ->first();
        $dr_status = DB::table('dr_dtatus')
            ->where('dr_id',Cookie::get('user_id'))
            ->first();
        if(empty($service_area)){
            return view('backend.doctorProfile');
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
            return view('backend.doctorProfile',['name' => $rows,'users'=>$users,'dr_status'=> $dr_status->status]);
        }

    }
    public function insertDoctorServiceArea(Request $request){
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
    public function myPatientList(){
        $rows = DB::table('dr_apportionment')
            ->select('*','dr_apportionment.id as a_id','a.phone as dr_phone','b.phone as p_phone','a.name as dr_name')
            ->join('users as a','a.id','=','dr_apportionment.dr_id')
            ->join('users as b','b.id','=','dr_apportionment.user_id')
            ->paginate('20');
        return view('backend.myPatientList',['drReports' => $rows]);
    }
    public function myPatientListByDate(Request $request){
        $rows = DB::table('dr_apportionment')
            ->select('*','dr_apportionment.id as a_id','a.phone as dr_phone','b.phone as p_phone','a.name as dr_name')
            ->join('users as a','a.id','=','dr_apportionment.dr_id')
            ->join('users as b','b.id','=','dr_apportionment.user_id')
            ->whereBetween('date',array($request->from_date,$request->to_date))
            ->paginate('20');
        //dd($rows);
        return view('backend.myPatientList',['drReports' => $rows,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
    }
    public function changeLocalDoctorStatus(Request $request){
        try{
            $rows = DB::table('dr_dtatus')
                ->where('dr_id', Cookie::get('user_id'))
                ->get();
            if($rows->count()>0){
                $result = DB::table('dr_dtatus')
                    ->where('dr_id', Cookie::get('user_id'))
                    ->update([
                        'status' => $request->id,
                    ]);
                if($result){
                    $msg=1;
                }
                else{
                    $msg=0;
                }
            }
            else{
                $result = DB::table('dr_dtatus')->insert([
                    'dr_id' => Cookie::get('user_id'),
                    'status' => $request->id,
                ]);
                if($result){
                    $msg=1;
                }
                else{
                    $msg=0;
                }
            }
            return response()->json(array('data'=>$msg));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
}
