<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function insertUserType(Request $request){
        try{
            if($request) {
                $rows = DB::table('user_type')->select('name')->where([
                    ['name', '=', $request->name]
                ])->where('status', 1)->distinct()->get()->count();
                if ($rows > 0) {
                    return back()->with('errorMessage', ' নতুন ইউজার ধরন লিখুন।');
                } else {
                    $result = DB::table('user_type')->insert([
                        'name' => $request->name,
                        'type' => $request->type
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
    public function selectUser_type(){
        try{
            $rows = DB::table('user_type')->where('status', 1)
                ->orderBy('id', 'DESC')->Paginate(10);
            return view('backend.user_type', ['user_types' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function selectUser(){
        try{
            $rows = DB::table('users')
                ->select('*','user_type.name as designation','users.name as name','users.id as u_id')
                ->join('user_type','users.user_type','=','user_type.id')
                ->orderBy('users.id', 'DESC')
                ->Paginate(10);
            return view('backend.user', ['users' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }

    public function getUserListByID(Request $request){
        try{
            $rows = DB::table('users')
                ->where('id', $request->id)
                ->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertUser(Request $request){
        try{
            //dd($request);
                if($request) {
                    if ($request->id){
                        $username = $request->name;
                        $email = $request->email;
                        $phone = $request->phone;
                        $password = Hash::make($request->password);
                        $gender = $request->gender;
                        $addressGroup = $request->addressGroup;
                        $add_part1 = $request->div_id;
                        $address = $request->address;
                        $user_type = $request->user_type;
                        $userPhotoPath = "";
                        $userPhotoIdPath = "";
                        $nid = "";
                        if ($request->hasFile('user_photo')) {
                            $targetFolder = 'public/asset/images/';
                            $file = $request->file('user_photo');
                            $pname = time() . '.' . $file->getClientOriginalName();
                            $image['filePath'] = $pname;
                            $file->move($targetFolder, $pname);
                            $userPhotoPath = $targetFolder . $pname;
                        }
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
                        if ($user_type == 5 || $user_type == 6 || $user_type == 7) {
                            $nid = $request->nid;
                            if ($request->hasFile('photoId')) {
                                $targetFolder = 'public/asset/images/';
                                $file = $request->file('photoId');
                                $pIname = time() . '.' . $file->getClientOriginalName();
                                $image['filePath'] = $pIname;
                                $file->move($targetFolder, $pIname);
                                $userPhotoIdPath = $targetFolder . $pIname;
                            }

                        }
                        $result =DB::table('users')
                            ->where('id', $request->id)
                            ->update([
                                'name' => $username,
                                'email' => $email,
                                'password' => $password,
                                'phone' => $phone,
                                'gender' => $gender,
                                'address_type' => $addressGroup,
                                'add_part1' => $add_part1,
                                'add_part2' => $add_part2,
                                'add_part3' => $add_part3,
                                'add_part4' => $add_part4,
                                'add_part5' => $add_part5,
                                'address' => $address,
                                'user_type' => $user_type,
                                'status' => 1,
                                'photo' => $userPhotoPath,
                                'nid' => $nid,
                                'photoid' => $userPhotoIdPath,
                                'working_status' => 1,
                            ]);
                        if ($result) {
                            if($user_type == 13){
                                $result = DB::table('doctors')
                                    ->where('doctor_id', $request->id)
                                    ->update([
                                    'dept_name_id' => $request->doc_department,
                                    'hos_name_id' => $request->doc_hospital,
                                    'designation' => $request->designation,
                                    'current_institute' => $request->currentInstitute,
                                    'education' => $request->education,
                                    'specialized' => $request->specialized,
                                    'experience' => $request->experience,
                                    'fees' => $request->fees,
                                    'address' => $request->pa_address,
                                    'in_time' => $request->intime,
                                    'in_timezone' => $request->intimezone,
                                    'out_time' => $request->outtime,
                                    'out_timezone' => $request->outtimezone,
                                    'days' => json_encode($request->days),
                                ]);
                            }
                            return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                        } else {
                            return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                        }
                    }
                    else{
                        $rows = DB::table('users')
                            ->where('phone', $request->phone)
                            ->orwhere('email', $request->email)
                            ->distinct()->get()->count();
                        if ($rows > 0) {
                            return back()->with('errorMessage', ' নতুন ইউজার লিখুন।');
                        } else {
                            $username = $request->name;
                            $email = $request->email;
                            $phone = $request->phone;
                            $password = Hash::make($request->password);
                            $gender = $request->gender;
                            $addressGroup = $request->addressGroup;
                            $add_part1 = $request->div_id;
                            $address = $request->address;
                            $user_type = $request->user_type;
                            $userPhotoPath = "";
                            $userPhotoIdPath = "";
                            $nid = "";
                            if ($request->hasFile('user_photo')) {
                                $targetFolder = 'public/asset/images/';
                                $file = $request->file('user_photo');
                                $pname = time() . '.' . $file->getClientOriginalName();
                                $image['filePath'] = $pname;
                                $file->move($targetFolder, $pname);
                                $userPhotoPath = $targetFolder . $pname;
                            }
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
                            if ($user_type == 5 || $user_type == 6 || $user_type == 7) {
                                $nid = $request->nid;
                                if ($request->hasFile('photoId')) {
                                    $targetFolder = 'public/asset/images/';
                                    $file = $request->file('photoId');
                                    $pIname = time() . '.' . $file->getClientOriginalName();
                                    $image['filePath'] = $pIname;
                                    $file->move($targetFolder, $pIname);
                                    $userPhotoIdPath = $targetFolder . $pIname;
                                }

                            }
                            $result = DB::table('users')->insert([
                                'name' => $username,
                                'email' => $email,
                                'password' => $password,
                                'phone' => $phone,
                                'gender' => $gender,
                                'address_type' => $addressGroup,
                                'add_part1' => $add_part1,
                                'add_part2' => $add_part2,
                                'add_part3' => $add_part3,
                                'add_part4' => $add_part4,
                                'add_part5' => $add_part5,
                                'address' => $address,
                                'user_type' => $user_type,
                                'status' => 1,
                                'photo' => $userPhotoPath,
                                'nid' => $nid,
                                'photoid' => $userPhotoIdPath,
                                'working_status' => 1,
                            ]);
                            if ($result) {
                                if($user_type == 7){
                                    $dealer_id = DB::getPdo()->lastInsertId();
                                    DB::insert("INSERT INTO product_assign (product_id, dealer_id, edit_price)
                                    SELECT id,$dealer_id,price
                                        FROM products");
                                }
                                if($user_type == 13){
                                    $doctor_id = DB::getPdo()->lastInsertId();
                                    $result = DB::table('doctors')->insert([
                                        'doctor_id' => $doctor_id,
                                        'dept_name_id' => $request->doc_department,
                                        'hos_name_id' => $request->doc_hospital,
                                        'designation' => $request->designation,
                                        'current_institute' => $request->currentInstitute,
                                        'education' => $request->education,
                                        'specialized' => $request->specialized,
                                        'experience' => $request->experience,
                                        'fees' => $request->fees,
                                        'address' => $request->pa_address,
                                        'in_time' => $request->intime,
                                        'in_timezone' => $request->intimezone,
                                        'out_time' => $request->outtime,
                                        'out_timezone' => $request->outtimezone,
                                        'days' => json_encode($request->days),
                                    ]);
                                }
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
    public function getWardListAll(Request $request){
        try{
            $rows = DB::table('wards')
                ->where('uni_id', $request->id)
                ->where('status', 1)
                ->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getC_wardListAll(Request $request){
        try{
            $rows = DB::table('c_wards')
                ->where('thana_id', $request->id)
                ->where('status', 1)
                ->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getAllUserType(Request $request){
        try{
            $rows = DB::table('user_type')
                ->where('status', 1)
                ->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteUser(Request $request){
        try{

            if($request->id) {
                $result =DB::table('users')
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
    public function about_us(Request $request){
        try{
            $rows = DB::table('about_us')
                ->get();
            return view('backend.about_us', ['abouts' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertAboutUs(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('about_us')
                        ->where('id', $request->id)
                        ->update([
                            'about' => $request->name
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else {
                    $rows = DB::table('about_us')->select('id')->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' আমাদের সম্পর্কে শুধু পরিবর্তনযোগ্য');
                    } else {
                        $result = DB::table('about_us')->insert([
                            'about' => $request->name,
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
    public function insertContactUs(Request $request){
        try{
            $result = DB::table('contact_us')->insert([
                'name' => $request->name,
                'phone' => $request->phone,
                'purpose' => $request->purpose,
            ]);
            if ($result) {
                return back()->with('successMessage', 'আপনার মুল্যবান মতামতের জন্য।');
            } else {
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getAboutUS(Request $request){
        try{
            $rows = DB::table('about_us')
                ->where('id', $request->id)
                ->first();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function contact_us(Request $request){
        try{
            $rows = DB::table('contact_us')
                ->paginate();
            return view('backend.contact_us', ['lists' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getContactUs(Request $request){
        try{
            $rows = DB::table('contact_us')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getHospitalListAll(Request $request){
        try{
            $rows = DB::table('hospitals')
                ->where('dept', $request->id)
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getAllMedDept(Request $request){
        try{
            $rows = DB::table('med_departments')
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getMealTypeAll(Request $request){
        try{
            $rows = DB::table('meal_time')
                ->where('m_time', $request->id)
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }

}
