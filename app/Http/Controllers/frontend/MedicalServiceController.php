<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use smasif\ShurjopayLaravelPackage\ShurjopayService;

class MedicalServiceController extends Controller
{
    public function doctorAppointmentForm(){
        return view('frontend.doctorAppointmentForm');
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
            $shurjopay_service = new ShurjopayService();
            $tx_id = $shurjopay_service->generateTxId();
            $success_route = 'http://localhost/bazar-sadai/insertTherapyAppointment';
            $shurjopay_service->sendPayment(1, $success_route);
            exit();
//            dd($tx_id);
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
}
