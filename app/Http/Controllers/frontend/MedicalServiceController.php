<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use smasif\ShurjopayLaravelPackage\ShurjopayService;

class MedicalServiceController extends Controller
{
    public function doctorAppointmentForm(){
        return view('frontend.doctorAppointmentForm');
    }
    public function localDoctorAppointment(){
        return view('frontend.localDoctor');
    }
    public function searchDoctorListFront(Request $request){
        if($request->type =='Hospital') {
            $rows = DB::table('doctors')
                ->select('*','users.name as dr_name','hospitals.name as hos_name',
                    'doctors.address as dr_address','users.id as u_id')
                ->join('users', 'users.id', '=', 'doctors.doctor_id')
                ->join('hospitals', 'hospitals.id', '=', 'doctors.hos_name_id')
                ->join('med_departments', 'med_departments.id', '=', 'doctors.dept_name_id')
                ->where('doctors.status', 1)
                ->where('users.status', 1)
                ->where('doctors.dept_name_id', $request->department)
                ->get();
            if(count($rows)<1){
                return back()->with('errorMessage', 'ডাক্তার পাওয়া যায়নি।');
            }
        }
         if($request->type =='Chamber') {
            $rows = DB::table('dr_chamber')
                ->select('*','users.name as dr_name','dr_chamber.chamber_name as hos_name',
                    'dr_chamber.chamber_address as dr_address','users.id as u_id')
                ->join('users', 'users.id', '=', 'dr_chamber.dr_id')
                ->join('doctors', 'doctors.doctor_id', '=', 'dr_chamber.dr_id')
                ->join('med_departments', 'med_departments.id', '=', 'dr_chamber.dept_id')
                ->where('dr_chamber.status', 1)
                ->where('users.status', 1)
                ->where('dr_chamber.dept_id', $request->department)
                ->get();
            if(count($rows)<1){
                return back()->with('errorMessage', 'ডাক্তার পাওয়া যায়নি।');
            }
        }
        //dd($rows);
        return view('frontend.doctorSearch',['doctorLists' => $rows,'d_type'=>$request->type]);
    }
    public function searchLocalDoctorListFront(Request $request){
        $users = DB::table('users')
            ->where('id',  Cookie::get('user_id'))
            ->first();
        $rows = DB::table('doctors')
            ->select('*','users.name as dr_name','hospitals.name as hos_name',
                'doctors.address as dr_address','users.id as u_id')
            ->join('users', 'users.id', '=', 'doctors.doctor_id')
            ->join('hospitals', 'hospitals.id', '=', 'doctors.hos_name_id')
            ->join('med_departments', 'med_departments.id', '=', 'doctors.dept_name_id')
            ->join('rider_service_area', 'rider_service_area.user_id', '=', 'doctors.doctor_id')
            ->where('doctors.status', 1)
            ->where('users.status', 1)
            ->where('users.working_status', 1)
            ->where('doctors.dept_name_id', $request->department)
            ->where('rider_service_area.address_type', $users->address_type)
            ->where('rider_service_area.add_part1', $users->add_part1)
            ->where('rider_service_area.add_part2', $users->add_part2)
            ->where('rider_service_area.add_part3', $users->add_part3)
            ->where('rider_service_area.add_part4', $users->add_part4)
            ->get();
        if(count($rows)<1){
            return back()->with('errorMessage', 'ডাক্তার পাওয়া যায়নি।');
        }

        //dd($rows);
        return view('frontend.localDoctorSearch',['doctorLists' => $rows,'d_type'=>$request->type]);
    }
    public function doctorProfileFront($id){
        $req_item = explode("&",$id);
        $id = $req_item[0];
        $type = $req_item[1];
        if($type =='Hospital') {
            $rows = DB::table('doctors')
                ->select('*','users.name as dr_name','hospitals.name as hos_name',
                    'doctors.address as dr_address','users.id as u_id')
                ->join('users', 'users.id', '=', 'doctors.doctor_id')
                ->join('hospitals', 'hospitals.id', '=', 'doctors.hos_name_id')
                ->join('med_departments', 'med_departments.id', '=', 'doctors.dept_name_id')
                ->where('doctors.status', 1)
                ->where('users.status', 1)
                ->where('users.id', $id)
                ->first();
        }
         if($type =='Chamber') {
            $rows = DB::table('dr_chamber')
                ->select('*','users.name as dr_name','dr_chamber.chamber_name as hos_name',
                    'dr_chamber.chamber_address as dr_address','users.id as u_id')
                ->join('users', 'users.id', '=', 'dr_chamber.dr_id')
                ->join('doctors', 'doctors.doctor_id', '=', 'dr_chamber.dr_id')
                ->join('med_departments', 'med_departments.id', '=', 'dr_chamber.dept_id')
                ->where('dr_chamber.status', 1)
                ->where('users.status', 1)
                ->where('users.id', $id)
                ->first();
        }
        //dd($rows);
        return view('frontend.doctorProfile',['doctorProfile' => $rows,'type'=>$type]);
    }
    public function localDoctorProfileFront($id){
        $rows = DB::table('doctors')
            ->select('*','users.name as dr_name','hospitals.name as hos_name',
                'doctors.address as dr_address','users.id as u_id')
            ->join('users', 'users.id', '=', 'doctors.doctor_id')
            ->join('hospitals', 'hospitals.id', '=', 'doctors.hos_name_id')
            ->join('med_departments', 'med_departments.id', '=', 'doctors.dept_name_id')
            ->where('doctors.status', 1)
            ->where('users.status', 1)
            ->where('users.id', $id)
            ->first();
        $type ='Local';
        return view('frontend.localDoctorProfile',['doctorProfile' => $rows,'type'=>$type]);
    }
    public function insertAppointment(Request $request){
        try{
            if($request) {
                $result = DB::table('dr_apportionment')->insert([
                    'dr_id' => $request->dr_id,
                    'type' => $request->type,
                    'user_id' => Cookie::get('user_id'),
                    'date' => $request->date,
                    'patient_name' => $request->patient_name,
                    'age' => $request->age,
                    'problem' => $request->problem,
                    'price' => $request->fees,
                ]);
                if ($result) {
                    $lastId = DB::getPdo()->lastInsertId();
                    $rows = DB::table('doctors')
                        ->join('users', 'users.id', '=', 'doctors.doctor_id')
                        ->where('users.id', $request->dr_id)
                        ->first();
                    if($rows->in_timezone == 'AM'){
                        $inTime = $rows->in_time;
                    }
                    if($rows->in_timezone == 'PM'){
                        $inTime = $rows->in_time+12;
                    }
                    if($rows->out_timezone == 'AM'){
                        $outTime = $rows->out_time;
                    }
                    if($rows->out_timezone == 'PM'){
                        $outTime = $rows->out_time+12;
                    }
                    $timeDifference = $outTime - $inTime;
                    $timSlot =15;
                    $totalSerial = ($timeDifference*60)/$timSlot;
                    $rowsDr = DB::table('dr_apportionment')
                        ->where('dr_id', $request->dr_id)
                        ->where('type', $request->type)
                        ->where('date', $request->date)
                        ->orderBy('id','desc')
                        ->skip(1)
                        ->take(1)
                        ->first();

                    if(!empty($rowsDr->serial)){
                        $currSerial = $rowsDr->serial+1;
                    }
                    else{
                        $currSerial = 1;
                    }
                    $timeMode = $currSerial % 4;
                    $hour = (int) floor( $currSerial/4);
                    $totalHour = $inTime+$hour;
                    if($timeMode == 1){
                        $totalMinutes = 15;
                    }
                    if($timeMode == 2){
                        $totalMinutes = 30;
                    }
                    if($timeMode == 3){
                        $totalMinutes = 45;
                    }
                    if($timeMode == 0){
                        $totalMinutes = '00';
                    }
                    $result =DB::table('dr_apportionment')
                        ->where('id', $lastId)
                        ->update([
                            'serial' =>  $currSerial,
                            'time' =>  $totalHour.':'.$totalMinutes,
                        ]);
                    if($result){
                        return back()->with('successMessage', 'ডাক্তার এর ফোন নাম্বারঃ '.$rows->phone.' ভিডিও কল করতে পারেন অথবা কল করতে পারেন।আপনার সিরিয়াল নম্বর:'. $currSerial. ' আপনার ভিসিট টাইম আনুমানিক: '.$totalHour.':'.$totalMinutes);
                    }
                    else{
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
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
    public function insertLocalAppointment(Request $request){
        try{
            if($request) {
                $users = DB::table('users')
                    ->where('id',  $request->dr_id)
                    ->first();
                $result = DB::table('dr_apportionment')->insert([
                    'dr_id' => $request->dr_id,
                    'type' => $request->type,
                    'user_id' => Cookie::get('user_id'),
                    'date' => date('Y-m-d'),
                    'patient_name' => $request->patient_name,
                    'age' => $request->age,
                    'problem' => $request->problem,
                    'price' => $request->fees,
                ]);
                if ($result) {
                    $result = DB::table('users')
                        ->where('id',$users->id)
                        ->update([
                            'working_status' =>2,
                        ]);
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

    public function therapyServiceForm(){
        return view('frontend.therapyServiceForm');
    }
    public function searchTherapyListFront(Request $request){
        $rows = DB::table('therapyfees')
            ->select('*','therapyfees.id as tf_id','therapy_center.id as tc_id')
            ->join('therapy_services', 'therapy_services.id','=','therapyfees.therapy_name_id')
            ->join('therapy_center', 'therapy_center.id','=','therapyfees.therapy_center_id')
            ->where('therapyfees.therapy_name_id',$request->department)
            ->where('therapyfees.status',1)
            ->get();
        if(count($rows)<1){
            return back()->with('errorMessage', 'থেরাপি সেন্টার পাওয়া যায়নি।');
        }
        //dd($rows);
        return view('frontend.therapyCenterList',['therapyCenters' => $rows]);
    }
    public function therapyAppointmentForm($id){
        $rows = DB::table('therapyfees')
            ->select('*','therapyfees.id as tf_id','therapy_center.id as tc_id')
            ->join('therapy_services', 'therapy_services.id','=','therapyfees.therapy_name_id')
            ->join('therapy_center', 'therapy_center.id','=','therapyfees.therapy_center_id')
            ->where('therapyfees.id',$id)
            ->where('therapyfees.status',1)
            ->first();
        //dd($rows);
        return view('frontend.therapyAppointmentForm',['therapyCenter' => $rows]);
    }
    public function insertTherapyAppointment(Request $request){
        try{
            if($request) {
                $result = DB::table('therapy_appointment')->insert([
                    'therapy_fees_id' => $request->tf_id,
                    'user_id' => Cookie::get('user_id'),
                    'date' => $request->date,
                    'patient_name' => $request->patient_name,
                    'age' => $request->age,
                    'problem' => $request->problem,
                    'address' => $request->patient_address,
                    'price' => $request->fees,
                ]);
                if ($result) {
                    $lastId = DB::getPdo()->lastInsertId();
                    $rowsDr = DB::table('therapy_appointment')
                        ->where('therapy_fees_id', $request->tf_id)
                        ->where('date', $request->date)
                        ->orderBy('id','desc')
                        ->skip(1)
                        ->take(1)
                        ->first();
                    if(!empty($rowsDr->serial)){
                        $currSerial = $rowsDr->serial+1;
                    }
                    else{
                        $currSerial = 1;
                    }
                    $result =DB::table('therapy_appointment')
                        ->where('id', $lastId)
                        ->update([
                            'serial' =>  $currSerial,
                        ]);
                    if($result){
                        return back()->with('successMessage', 'আপনার সিরিয়াল নম্বর: = '. $currSerial. '। প্রতিটি  সিরিয়াল টাইম = '.$request->time.' মিনিট।');
                    }
                    else{
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
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
    public function diagnosticBookingForm(){
        return view('frontend.diagnosticBookingForm');
    }
    public function searchDiagnosticListFront(Request $request){
        $rows = DB::table('diagnostic_fees')
            ->select('*','diagnostic_fees.id as df_id')
            ->join('diagnostic_test', 'diagnostic_test.id','=','diagnostic_fees.diagnostic_test_id')
            ->join('diagnostic_center', 'diagnostic_center.id','=','diagnostic_fees.diagnostic_center_id')
            ->where('diagnostic_fees.diagnostic_test_id',$request->department)
            ->where('diagnostic_fees.status',1)
            ->get();
        if(count($rows)<1){
            return back()->with('errorMessage', 'ডায়াগনস্টিক সেন্টার পাওয়া যায়নি।');
        }
        //dd($rows);
        return view('frontend.diagnosticCenterList',['diagnosticCenterLists' => $rows]);
    }
    public function diagnosticAppointmentForm($id){
        $rows = DB::table('diagnostic_fees')
            ->select('*','diagnostic_fees.id as df_id','diagnostic_center.id as dc_id')
            ->join('diagnostic_test', 'diagnostic_test.id','=','diagnostic_fees.diagnostic_test_id')
            ->join('diagnostic_center', 'diagnostic_center.id','=','diagnostic_fees.diagnostic_center_id')
            ->where('diagnostic_fees.id',$id)
            ->where('diagnostic_fees.status',1)
            ->first();
        //dd($rows);
        return view('frontend.diagnosticAppointmentForm',['diagnosticCenter' => $rows]);
    }
    public function insertDiagnosticAppointment(Request $request){
        try{
            if($request) {
                $result = DB::table('diagonostic_appointment')->insert([
                    'diagnostic_fees_id' => $request->df_id,
                    'user_id' => Cookie::get('user_id'),
                    'date' => $request->date,
                    'patient_name' => $request->patient_name,
                    'age' => $request->age,
                    'problem' => $request->problem,
                    'address' => $request->patient_address,
                    'price' => $request->fees,
                ]);
                if ($result) {
                    $lastId = DB::getPdo()->lastInsertId();
                    $rowsDr = DB::table('diagonostic_appointment')
                        ->where('diagnostic_fees_id', $request->df_id)
                        ->where('date', $request->date)
                        ->orderBy('id','desc')
                        ->skip(1)
                        ->take(1)
                        ->first();
                    if(!empty($rowsDr->serial)){
                        $currSerial = $rowsDr->serial+1;
                    }
                    else{
                        $currSerial = 1;
                    }
                    $result =DB::table('diagonostic_appointment')
                        ->where('id', $lastId)
                        ->update([
                            'serial' =>  $currSerial,
                        ]);
                    if($result){
                        return back()->with('successMessage', 'আপনার সিরিয়াল নম্বর: = '. $currSerial. '। প্রতিটি  সিরিয়াল টাইম = '.$request->time.' মিনিট।');
                    }
                    else{
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
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
    public function medicalCampFront(Request $request){
        $rows = DB::table('medical_camp')
            ->where('end_date','>=',date('Y-m-d'))
            ->orderBy('id', 'desc')
            ->get();
        $camp_arr =array();
        $i=0;
        foreach ($rows as $mcamp){
            $user_id = $mcamp->user;
            $address_type = $mcamp->address_type;
            $user = DB::table('users')
                ->where('id', $user_id)
                ->first();
            if($address_type==1){
                $add_part1 = DB::table('divisions')
                    ->where('id',$mcamp->add_part1)
                    ->first();
                $add_part2 = DB::table('districts')
                    ->where('div_id',$mcamp->add_part1)
                    ->where('id',$mcamp->add_part2)
                    ->first();
                $add_part3 = DB::table('upazillas')
                    ->where('div_id',$mcamp->add_part1)
                    ->where('dis_id',$mcamp->add_part2)
                    ->where('id',$mcamp->add_part3)
                    ->first();
                $add_part4 = DB::table('unions')
                    ->where('div_id',$mcamp->add_part1)
                    ->where('dis_id',$mcamp->add_part2)
                    ->where('upz_id',$mcamp->add_part3)
                    ->where('id',$mcamp->add_part4)
                    ->first();
                $add_part5 = DB::table('wards')
                    ->where('div_id',$mcamp->add_part1)
                    ->where('dis_id',$mcamp->add_part2)
                    ->where('upz_id',$mcamp->add_part3)
                    ->where('uni_id',$mcamp->add_part4)
                    ->where('id',$mcamp->add_part5)
                    ->first();
            }
            if($address_type==2){
                $add_part1 = DB::table('divisions')
                    ->where('id',$mcamp->add_part1)
                    ->first();
                $add_part2 = DB::table('cities')
                    ->where('div_id',$mcamp->add_part1)
                    ->where('id',$mcamp->add_part2)
                    ->first();
                $add_part3 = DB::table('city_corporations')
                    ->where('div_id',$mcamp->add_part1)
                    ->where('city_id',$mcamp->add_part2)
                    ->where('id',$mcamp->add_part3)
                    ->first();
                $add_part4 = DB::table('thanas')
                    ->where('div_id',$mcamp->add_part1)
                    ->where('city_id',$mcamp->add_part2)
                    ->where('city_co_id',$mcamp->add_part3)
                    ->where('id',$mcamp->add_part4)
                    ->first();
                $add_part5 = DB::table('c_wards')
                    ->where('div_id',$mcamp->add_part1)
                    ->where('city_id',$mcamp->add_part2)
                    ->where('city_co_id',$mcamp->add_part3)
                    ->where('thana_id',$mcamp->add_part4)
                    ->where('id',$mcamp->add_part5)
                    ->first();
            }
            $camp_arr[$i]['id'] = $mcamp->id;
            $camp_arr[$i]['c_name'] = $mcamp->id;
            $camp_arr[$i]['name'] = $mcamp->c_name;
            $camp_arr[$i]['email'] = $mcamp->email;
            $camp_arr[$i]['phone'] = $mcamp->phone;
            $camp_arr[$i]['user'] = $user->name;
            $camp_arr[$i]['add_part1'] = $add_part1->name;
            $camp_arr[$i]['add_part2'] = $add_part2->name;
            $camp_arr[$i]['add_part3'] = $add_part3->name;
            $camp_arr[$i]['add_part4'] = $add_part4->name;
            $camp_arr[$i]['add_part5'] = $add_part5->name;
            $camp_arr[$i]['start_date'] = $mcamp->start_date;
            $camp_arr[$i]['end_date'] = $mcamp->end_date;
            $camp_arr[$i]['purpose'] = $mcamp->purpose;
            $camp_arr[$i]['address'] = $mcamp->address;
            $i++;
        }
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($camp_arr);
        $perPage = 20;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $paginatedItems->setPath($request->url());
        return view('frontend.medicalCampFront',['medCamps' => $paginatedItems]);
    }
}
