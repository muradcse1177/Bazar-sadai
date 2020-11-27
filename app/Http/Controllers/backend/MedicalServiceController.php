<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MedicalServiceController extends Controller
{
    public function departmentList(){
        $rows = DB::table('med_departments')
            ->where('status', 1)
            ->orderBy('id', 'DESC')->Paginate(10);
        return view('backend.departmentList', ['departmentLists' => $rows]);
    }
    public function departmentLists(Request $request){
        try{
            $rows = DB::table('med_departments')
                ->where('id', $request->id)
                ->where('status', 1)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertMedDepartment(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('med_departments')
                        ->where('id', $request->id)
                        ->update([
                            'name' => $request->name,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('med_departments')->select('id')->where([
                        ['name', '=', $request->name],
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন আইটেম লিখুন।');
                    } else {
                        $result = DB::table('med_departments')->insert([
                            'name' => $request->name,
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
    public function deleteMedDepartment(Request $request){
        try{

            if($request->id) {
                $result =DB::table('med_departments')
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
    public function hospitalList(){
        $rows = DB::table('hospitals')
            ->select('*','med_departments.name as dept_name','hospitals.name as hos_name','hospitals.id as hos_id')
            ->join('med_departments','hospitals.dept','=','med_departments.id')
            ->where('hospitals.status', 1)
            ->orderBy('hospitals.id', 'DESC')->Paginate(10);
        return view('backend.hospitalList', ['hospitalLists' => $rows]);
    }
    public function getAllMedDepartment(Request $request){
        try{
            $rows = DB::table('med_departments')
                ->where('status', 1)
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertHospital(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('hospitals')
                        ->where('id', $request->id)
                        ->update([
                            'name' => $request->name,
                            'dept' => $request->department,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('hospitals')->select('id')->where([
                        ['name', '=', $request->name],
                        ['dept', '=', $request->department],
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন আইটেম লিখুন।');
                    } else {
                        $result = DB::table('hospitals')->insert([
                            'name' => $request->name,
                            'dept' => $request->department,
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
    public function hospitalListsById(Request $request){
        try{
            $rows = DB::table('hospitals')
                ->where('id', $request->id)
                ->where('status', 1)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteHospital(Request $request){
        try{

            if($request->id) {
                $result =DB::table('hospitals')
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
    public function doctorList(){
        $rows = DB::table('doctors')
            ->select('*','med_departments.name as dept_name','hospitals.name as hos_name','users.name as u_name')
            ->join('med_departments','doctors.dept_name_id','=','med_departments.id')
            ->join('users','users.id','=','doctors.doctor_id')
            ->join('hospitals','hospitals.id','=','doctors.hos_name_id')
            ->where('doctors.status', 1)
            ->orderBy('hospitals.id', 'DESC')->Paginate(10);
        return view('backend.doctorList',['doctorLists' => $rows]);
    }

    public function getHospitalListAll(Request $request){
        try{
            $rows = DB::table('hospitals')
                ->where('dept', $request->id)
                ->where('status', 1)
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getDoctorListAll(Request $request){
        try{
            $rows = DB::table('doctors')
                ->select('*','doctors.id as d_id','users.id as u_id')
                ->join('users','doctors.doctor_id','=','users.id')
                ->where('doctors.dept_name_id', $request->id)
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function privateChamberList(){
        $rows = DB::table('dr_chamber')
            ->select('*','med_departments.name as dep_name','dr_chamber.id as ch_id','users.name as u_name')
            ->join('users','dr_chamber.dr_id','=','users.id')
            ->join('med_departments','dr_chamber.dept_id','=','med_departments.id')
            ->where('dr_chamber.status', 1)
            ->orderBy('dr_chamber.id', 'DESC')->Paginate(10);
        //dd($rows);
        return view('backend.privateChamberList',['dr_chambers' => $rows]);
    }
    public function insertPrivateChamber(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('dr_chamber')
                        ->where('id', $request->id)
                        ->update([
                            'dept_id' => $request->department,
                            'dr_id' => $request->doctor,
                            'chamber_name' => $request->name,
                            'chamber_address' => $request->address,
                            'fees' => $request->fees,
                            'in_time' => $request->intime,
                            'in_timezone' => $request->intimezone,
                            'out_time' => $request->outtime,
                            'out_timezone' => $request->outtimezone,
                            'days' => json_encode($request->days),
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('dr_chamber')->select('id')->where([
                        ['dept_id', '=', $request->department],
                        ['dr_id', '=', $request->doctor],
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন আইটেম লিখুন।');
                    } else {
                        //dd($request->days);
                        $result = DB::table('dr_chamber')->insert([
                            'dept_id' => $request->department,
                            'dr_id' => $request->doctor,
                            'chamber_name' => $request->name,
                            'chamber_address' => $request->address,
                            'fees' => $request->fees,
                            'in_time' => $request->intime,
                            'in_timezone' => $request->intimezone,
                            'out_time' => $request->outtime,
                            'out_timezone' => $request->outtimezone,
                            'days' => json_encode($request->days),
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
    public function chamberListsById(Request $request){
        try{
            $rows = DB::table('dr_chamber')
                ->select('*','med_departments.name as dep_name','dr_chamber.id as ch_id',
                    'users.name as u_name')
                ->join('users','dr_chamber.dr_id','=','users.id')
                ->join('med_departments','dr_chamber.dept_id','=','med_departments.id')
                ->where('dr_chamber.id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteChamber(Request $request){
        try{

            if($request->id) {
                $result =DB::table('dr_chamber')
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
    public function therapyServiceList(){
        $rows = DB::table('therapy_services')
            ->where('status', 1)
            ->orderBy('id', 'DESC')->Paginate(10);
        return view('backend.therapyServiceList',['therapy_services' => $rows]);
    }
    public function insertTherapyService(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('therapy_services')
                        ->where('id', $request->id)
                        ->update([
                            'name' => $request->name,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('therapy_services')->select('id')->where([
                        ['name', '=', $request->name],
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন আইটেম লিখুন।');
                    } else {
                        $result = DB::table('therapy_services')->insert([
                            'name' => $request->name,
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
    public function therapyListsById(Request $request){
        try{
            $rows = DB::table('therapy_services')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteTherapyService(Request $request){
        try{

            if($request->id) {
                $result =DB::table('therapy_services')
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
    public function therapyCenterList(){
        $rows = DB::table('therapy_center')
            ->join('therapy_services','therapy_services.id','=','therapy_center.therapy_service_id')
            ->where('therapy_center.status', 1)
            ->orderBy('therapy_center.id', 'DESC')->Paginate(10);
        return view('backend.therapyCenterList',['therapy_centers' => $rows]);
    }
    public function insertTherapyCenter(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('therapy_center')
                        ->where('id', $request->id)
                        ->update([
                            'therapy_service_id' => $request->therapy_service_id,
                            'center_name' => $request->name,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('therapy_center')->select('id')->where([
                        ['therapy_service_id', '=', $request->therapy_service_id],
                        ['center_name', '=', $request->name],
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন আইটেম লিখুন।');
                    } else {
                        $result = DB::table('therapy_center')->insert([
                            'therapy_service_id' => $request->therapy_service_id,
                            'center_name' => $request->name,
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
    public function getAllTherapyServiceList(Request $request){
        try{
            $rows = DB::table('therapy_services')
                ->where('status', 1)
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function therapyCenterListsById(Request $request){
        try{
            $rows = DB::table('therapy_center')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteTherapyCenter(Request $request){
        try{

            if($request->id) {
                $result =DB::table('therapy_center')
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
    public function therapyFees(){
        $rows = DB::table('therapyfees')
            ->select('*','therapyfees.id as th_id')
            ->join('therapy_services','therapy_services.id','=','therapyfees.therapy_name_id')
            ->join('therapy_center','therapy_center.id','=','therapyfees.therapy_center_id')
            ->where('therapyfees.status', 1)
            ->paginate('10');
        //dd($rows);
        return view('backend.therapyFees',['therapyFeesLists' => $rows]);
    }
    public function getTherapyCenterById(Request $request){
        try{
            $rows = DB::table('therapy_center')
                ->where('therapy_service_id', $request->id)
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function therapyFeesListsById(Request $request){
        try{
            $rows = DB::table('therapyfees')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertTherapyFees(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('therapyfees')
                        ->where('id', $request->id)
                        ->update([
                            'therapy_name_id' => $request->therapy_service_id,
                            'therapy_center_id' => $request->therapy_center_id,
                            'fees' => $request->fees,
                            'time' => $request->time,
                            'intime' => $request->intime,
                            'intimezone' => $request->intimezone,
                            'outtime' => $request->outtime,
                            'outtimezone' => $request->outtimezone,
                            'days' => json_encode($request->days),
                            'home' => $request->home,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('therapyfees')->select('id')->where([
                        ['therapy_name_id', '=', $request->therapy_service_id],
                        ['therapy_center_id', '=', $request->therapy_center_id],
                        ['fees', '=', $request->fees],
                        ['time', '=', $request->time],
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন আইটেম লিখুন।');
                    } else {
                        $result = DB::table('therapyfees')->insert([
                            'therapy_name_id' => $request->therapy_service_id,
                            'therapy_center_id' => $request->therapy_center_id,
                            'fees' => $request->fees,
                            'time' => $request->time,
                            'intime' => $request->intime,
                            'intimezone' => $request->intimezone,
                            'outtime' => $request->outtime,
                            'outtimezone' => $request->outtimezone,
                            'days' => json_encode($request->days),
                            'home' => $request->home,
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
    public function deleteTherapyFees(Request $request){
        try{

            if($request->id) {
                $result =DB::table('therapyfees')
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
    public function diagnosticTestList(){
        $rows = DB::table('diagnostic_test')
            ->where('status', 1)
            ->paginate('10');
        //dd($rows);
        return view('backend.diagnosticTestList',['diagnosticTests' => $rows]);
    }
    public function insertDiagnosticTest(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('diagnostic_test')
                        ->where('id', $request->id)
                        ->update([
                            'name' => $request->name,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('diagnostic_test')->select('id')->where([
                        ['name', '=', $request->name],
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন আইটেম লিখুন।');
                    } else {
                        $result = DB::table('diagnostic_test')->insert([
                            'name' => $request->name,
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
    public function diagnosticListById(Request $request){
        try{
            $rows = DB::table('diagnostic_test')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteDiagnosticTest(Request $request){
        try{

            if($request->id) {
                $result =DB::table('diagnostic_test')
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
    public function diagnosticCenterList(){
        $rows = DB::table('diagnostic_center')
            ->select('*','diagnostic_center.id as c_id')
            ->join('diagnostic_test','diagnostic_test.id','=','diagnostic_center.diagnostic_name_id')
            ->where('diagnostic_center.status', 1)
            ->paginate('10');
        //dd($rows);
        return view('backend.diagnosticCenterList',['diagnosticCenters' => $rows]);
    }
    public function getAllDiagnosticTest(Request $request){
        try{
            $rows = DB::table('diagnostic_test')
                ->where('status', 1)
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertDiagnosticCenter(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('diagnostic_center')
                        ->where('id', $request->id)
                        ->update([
                            'diagnostic_name_id' => $request->test,
                            'center_name' => $request->name,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('diagnostic_center')->select('id')->where([
                        ['center_name', '=', $request->name],
                        ['diagnostic_name_id', '=', $request->test],
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন আইটেম লিখুন।');
                    } else {
                        $result = DB::table('diagnostic_center')->insert([
                            'diagnostic_name_id' => $request->test,
                            'center_name' => $request->name,
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
    public function diagnosticCenterListsById(Request $request){
        try{
            $rows = DB::table('diagnostic_center')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteDiagnosticCenter(Request $request){
        try{

            if($request->id) {
                $result =DB::table('diagnostic_center')
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
    public function diagnosticFees(){
        $rows = DB::table('diagnostic_fees')
            ->select('*','diagnostic_fees.id as f_id')
            ->join('diagnostic_test','diagnostic_test.id','=','diagnostic_fees.diagnostic_test_id')
            ->join('diagnostic_center','diagnostic_center.id','=','diagnostic_fees.diagnostic_center_id')
            ->where('diagnostic_fees.status', 1)
            ->paginate('10');
        //dd($rows);
        return view('backend.diagnosticFees',['diagnosticFeesLists' => $rows]);
    }
    public function getDiagnosticCenterById(Request $request){
        try{
            $rows = DB::table('diagnostic_center')
                ->where('diagnostic_name_id', $request->id)
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertDiagnosticFees(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('diagnostic_fees')
                        ->where('id', $request->id)
                        ->update([
                            'diagnostic_test_id' => $request->diagnostic_test_id,
                            'diagnostic_center_id' => $request->diagnostic_center_id,
                            'fees' => $request->fees,
                            'intime' => $request->intime,
                            'intimezone' => $request->intimezone,
                            'outtime' => $request->outtime,
                            'outtimezone' => $request->outtimezone,
                            'days' => json_encode($request->days),
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('diagnostic_fees')->select('id')->where([
                        ['diagnostic_test_id', '=', $request->diagnostic_test_id],
                        ['diagnostic_center_id', '=', $request->diagnostic_center_id],
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন আইটেম লিখুন।');
                    } else {
                        $result = DB::table('diagnostic_fees')->insert([
                            'diagnostic_test_id' => $request->diagnostic_test_id,
                            'diagnostic_center_id' => $request->diagnostic_center_id,
                            'fees' => $request->fees,
                            'intime' => $request->intime,
                            'intimezone' => $request->intimezone,
                            'outtime' => $request->outtime,
                            'outtimezone' => $request->outtimezone,
                            'days' => json_encode($request->days),
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
    public function diagnosticFeesListsById(Request $request){
        try{
            $rows = DB::table('diagnostic_fees')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteDiagnosticFees(Request $request){
        try{

            if($request->id) {
                $result =DB::table('diagnostic_fees')
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
    public function medicalCampBack(Request  $request){
        $rows = DB::table('medical_camp')
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
        return view('backend.medicalCampBack',['medCamps' => $paginatedItems]);
    }
    public function insertMedicalCamp(Request $request){
        try{
            //dd($request);
            if($request) {
                if ($request->id){
                    $name = $request->name;
                    $email = $request->email;
                    $phone = $request->phone;
                    $addressGroup = $request->addressGroup;
                    $add_part1 = $request->div_id;
                    $address = $request->address;
                    $purpose = $request->purpose;
                    $from_date = $request->from_date;
                    $to_date = $request->to_date;
                    if ($addressGroup == 1) {
                        $add_part2 = $request->disid;
                        $add_part3 = $request->upzid;
                        $add_part4 = $request->uniid;
                        $add_part5 = $request->wardid;
                    }
                    if ($addressGroup == 2) {
                        $add_part2 = $request->c_disid;
                        $add_part3 = $request->c_upzid;
                        $add_part4 = $request->c_uniid;
                        $add_part5 = $request->c_wardid;
                    }
                    $result =DB::table('medical_camp')
                        ->where('id', $request->id)
                        ->update([
                            'c_name' => $name,
                            'email' => $email,
                            'phone' => $phone,
                            'address_type' => $addressGroup,
                            'add_part1' => $add_part1,
                            'add_part2' => $add_part2,
                            'add_part3' => $add_part3,
                            'add_part4' => $add_part4,
                            'add_part5' => $add_part5,
                            'purpose' => $purpose,
                            'address' => $address,
                            'start_date' => $from_date,
                            'end_date' => $to_date,
                            'user' => Cookie::get('user_id'),
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{

                    $name = $request->name;
                    $email = $request->email;
                    $phone = $request->phone;
                    $addressGroup = $request->addressGroup;
                    $add_part1 = $request->div_id;
                    $address = $request->address;
                    $purpose = $request->purpose;
                    $from_date = $request->from_date;
                    $to_date = $request->to_date;
                    if ($addressGroup == 1) {
                        $add_part2 = $request->disid;
                        $add_part3 = $request->upzid;
                        $add_part4 = $request->uniid;
                        $add_part5 = $request->wardid;
                    }
                    if ($addressGroup == 2) {
                        $add_part2 = $request->c_disid;
                        $add_part3 = $request->c_upzid;
                        $add_part4 = $request->c_uniid;
                        $add_part5 = $request->c_wardid;
                    }
                    $result = DB::table('medical_camp')->insert([
                        'c_name' => $name,
                        'email' => $email,
                        'phone' => $phone,
                        'address_type' => $addressGroup,
                        'add_part1' => $add_part1,
                        'add_part2' => $add_part2,
                        'add_part3' => $add_part3,
                        'add_part4' => $add_part4,
                        'add_part5' => $add_part5,
                        'purpose' => $purpose,
                        'address' => $address,
                        'start_date' => $from_date,
                        'end_date' => $to_date,
                        'user' => Cookie::get('user_id'),
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
    public function getMedicalCampList(Request $request){
        try{
            $rows = DB::table('medical_camp')
                ->where('id', $request->id)
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteMedicalCamp(Request $request){
        try{
            if($request->id) {
                $result =DB::table('medical_camp')
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
