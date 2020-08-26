<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function doctorAppointmentReport(){
        $rows = DB::table('dr_apportionment')
            ->select('*','dr_apportionment.id as a_id','a.phone as dr_phone','b.phone as p_phone','a.name as dr_name')
            ->join('users as a','a.id','=','dr_apportionment.dr_id')
            ->join('users as b','b.id','=','dr_apportionment.user_id')
            ->paginate('20');
        //dd($rows);
        return view('backend.doctorAppointmentReport',['drReports' => $rows]);
    }
    public function therapyAppointmentReport(){
        $rows = DB::table('therapy_appointment')
            ->select('*')
            ->join('users','users.id','=','therapy_appointment.user_id')
            ->join('therapyfees as a','a.id','=','therapy_appointment.therapy_fees_id')
            ->join('therapy_center','therapy_center.id','=','a.therapy_center_id')
            ->join('therapy_services','therapy_services.id','=','a.therapy_name_id')
            ->paginate('20');
        //dd($rows);
        return view('backend.therapyAppointmentReport',['therapyReports' => $rows]);
    }
    public function diagnosticAppointmentReport(){
        $rows = DB::table('diagonostic_appointment')
            ->select('*')
            ->join('users','users.id','=','diagonostic_appointment.user_id')
            ->join('diagnostic_fees as a','a.id','=','diagonostic_appointment.diagnostic_fees_id')
            ->join('diagnostic_center','diagnostic_center.id','=','a.diagnostic_center_id')
            ->join('diagnostic_test','diagnostic_test.id','=','a.diagnostic_test_id')
            ->paginate('20');
        //dd($rows);
        return view('backend.diagnosticAppointmentReport',['diagnosticReports' => $rows]);
    }
}
