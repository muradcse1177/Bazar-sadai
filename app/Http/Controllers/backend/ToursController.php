<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class ToursController extends Controller
{
    public function bookingMainAddress(Request  $request){
        try{
            $rows = DB::table('booking_main_address')
                ->orderBy('id', 'DESC')->Paginate(20);
            return view('backend.bookingMainAddress', ['addresses' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function insertMainAddress(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('booking_main_address')
                        ->where('id', $request->id)
                        ->update([
                            'country' =>  $request->country,
                            'name' =>  $request->name,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('booking_main_address')->select('name')->where([
                        ['name', '=', $request->name]
                    ])->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন ঠিকানা লিখুন।');
                    } else {
                        $result = DB::table('booking_main_address')->insert([
                            'country' => $request->country,
                            'name' => $request->name
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
    public function getTourAddressListById(Request $request){
        try{
            $rows = DB::table('booking_main_address')->where('id', $request->id)->first();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteTourAddress(Request $request){
        try{
            if($request->id) {
                $result =DB::table('booking_main_address')
                    ->where('id', $request->id)->delete();
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
    public function bookingTourAll1(Request  $request){
        try{
            $rows = DB::table('toor_booking1')
                ->orderBy('id', 'DESC')->Paginate(20);
            return view('backend.bookingTourAll', ['tours' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function bookingTourAllAgent1(Request  $request){
        try{
            $rows = DB::table('toor_booking1')
                ->where('user_id',Cookie::get('user_id'))
                ->orderBy('id', 'DESC')
                ->Paginate(20);
            return view('backend.bookingTourAllAgent1', ['tours' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getMainPlaceListAll(Request $request){
        try{

            $rows = DB::table('booking_main_address')->where('country', $request->id)->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getMainPlaceListAllAgent(Request $request){
        try{

            $rows = DB::table('booking_main_address')->where('country', $request->id)->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getTourMainListById(Request $request){
        try{

            $rows = DB::table('toor_booking1')->where('id', $request->id)->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getTourMainListByIdAgent(Request $request){
        try{

            $rows = DB::table('toor_booking1')->where('id', $request->id)->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertTourBooking1(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $photo='';
                    if ($request->hasFile('cover_photo')) {
                        $targetFolder = 'public/asset/images/';
                        $file = $request->file('cover_photo');
                        $pname = time() . '.' . $file->getClientOriginalName();
                        $image['filePath'] = $pname;
                        $file->move($targetFolder, $pname);
                        $photo = $targetFolder . $pname;
                    }
                    $result =DB::table('toor_booking1')
                        ->where('id', $request->id)
                        ->update([
                            'bookingName' => $request->bookingName,
                            'country' => $request->country,
                            'place' => $request->place,
                            'name' => $request->name,
                            'address' => $request->address,
                            'cover_photo' => $photo,
                            'description' => $request->description,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('toor_booking1')->select('name')->where([
                        ['name', '=', $request->name],
                        ['place', '=', $request->place]
                    ])->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন করে লিখুন।');
                    } else {
                        $photo='';
                        if ($request->hasFile('cover_photo')) {
                            $targetFolder = 'public/asset/images/';
                            $file = $request->file('cover_photo');
                            $pname = time() . '.' . $file->getClientOriginalName();
                            $image['filePath'] = $pname;
                            $file->move($targetFolder, $pname);
                            $photo = $targetFolder . $pname;
                        }
                        $result = DB::table('toor_booking1')->insert([
                            'user_id' => Cookie::get('user_id'),
                            'bookingName' => $request->bookingName,
                            'country' => $request->country,
                            'place' => $request->place,
                            'name' => $request->name,
                            'address' => $request->address,
                            'cover_photo' => $photo,
                            'description' => $request->description,
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
    public function insertTourBooking1Agent(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $photo='';
                    if ($request->hasFile('cover_photo')) {
                        $targetFolder = 'public/asset/images/';
                        $file = $request->file('cover_photo');
                        $pname = time() . '.' . $file->getClientOriginalName();
                        $image['filePath'] = $pname;
                        $file->move($targetFolder, $pname);
                        $photo = $targetFolder . $pname;
                    }
                    $result =DB::table('toor_booking1')
                        ->where('id', $request->id)
                        ->update([
                            'bookingName' => $request->bookingName,
                            'country' => $request->country,
                            'place' => $request->place,
                            'name' => $request->name,
                            'address' => $request->address,
                            'cover_photo' => $photo,
                            'description' => $request->description,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('toor_booking1')->select('name')->where([
                        ['name', '=', $request->name],
                        ['place', '=', $request->place]
                    ])->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন করে লিখুন।');
                    } else {
                        $photo='';
                        if ($request->hasFile('cover_photo')) {
                            $targetFolder = 'public/asset/images/';
                            $file = $request->file('cover_photo');
                            $pname = time() . '.' . $file->getClientOriginalName();
                            $image['filePath'] = $pname;
                            $file->move($targetFolder, $pname);
                            $photo = $targetFolder . $pname;
                        }
                        $result = DB::table('toor_booking1')->insert([
                            'user_id' => Cookie::get('user_id'),
                            'bookingName' => $request->bookingName,
                            'country' => $request->country,
                            'place' => $request->place,
                            'name' => $request->name,
                            'address' => $request->address,
                            'cover_photo' => $photo,
                            'description' => $request->description,
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
    public function deleteTourMainListAgent(Request $request){
        try{
            if($request->id) {
                $result =DB::table('toor_booking1')
                    ->where('id', $request->id)->delete();
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

    public function bookingTourAll2(Request  $request){
        try{
            $rows = DB::table('toor_booking2')
                ->select('*','toor_booking2.id as t_id' )
                ->join('toor_booking1','toor_booking2.name_id','=','toor_booking1.id')
                ->orderBy('toor_booking2.id', 'DESC')
                ->Paginate(20);
            return view('backend.bookingTourAll2', ['tours' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function bookingTourAllAgent2(Request  $request){
        try{
            $rows = DB::table('toor_booking2')
                ->select('*','toor_booking2.id as t_id' )
                ->join('toor_booking1','toor_booking2.name_id','=','toor_booking1.id')
                ->where('user_id',Cookie::get('user_id'))
                ->orderBy('toor_booking2.id', 'DESC')
                ->Paginate(20);
            return view('backend.bookingTourAllAgent2', ['tours' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getAllToursNameList(Request $request){
        try{

            $rows = DB::table('toor_booking1')->where('user_id',Cookie::get('user_id') )->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getAllToursNameListAgent(Request $request){
        try{

            $rows = DB::table('toor_booking1')->where('user_id',Cookie::get('user_id') )->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertTourBooking2(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $photo='';
                    if ($request->hasFile('photo')) {
                        $destinationPath = 'public/asset/images/';
                        $files = $request->file('photo');

                        foreach ($files as $file) {
                            $file_name = time() . '.'. $file->getClientOriginalName();
                            $file->move($destinationPath , $file_name);
                            $photo .= $destinationPath . $file_name .',';
                        }
                    }
                    $result =DB::table('toor_booking2')
                        ->where('id', $request->id)
                        ->update([
                            'name_id' => $request->name,
                            't_type' => $request->type,
                            'price' => $request->price,
                            'photo' => json_encode($photo),
                            'description' => $request->description,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $photo='';
                    if ($request->hasFile('photo')) {
                        $destinationPath = 'public/asset/images/';
                        $files = $request->file('photo');

                        foreach ($files as $file) {
                            $file_name = time() . '.'. $file->getClientOriginalName();
                            $file->move($destinationPath , $file_name);
                            $photo .= $destinationPath . $file_name .',';
                        }
                    }
                    $result = DB::table('toor_booking2')->insert([
                        'name_id' => $request->name,
                        't_type' => $request->type,
                        'price' => $request->price,
                        'photo' => json_encode($photo),
                        'description' => $request->description,
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
    public function insertTourBooking2Agent(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $photo='';
                    if ($request->hasFile('photo')) {
                        $destinationPath = 'public/asset/images/';
                        $files = $request->file('photo');

                        foreach ($files as $file) {
                            $file_name = time() . '.'. $file->getClientOriginalName();
                            $file->move($destinationPath , $file_name);
                            $photo .= $destinationPath . $file_name .',';
                        }
                    }
                    $result =DB::table('toor_booking2')
                        ->where('id', $request->id)
                        ->update([
                            'name_id' => $request->name,
                            't_type' => $request->type,
                            'price' => $request->price,
                            'photo' => json_encode($photo),
                            'description' => $request->description,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $photo='';
                    if ($request->hasFile('photo')) {
                        $destinationPath = 'public/asset/images/';
                        $files = $request->file('photo');

                        foreach ($files as $file) {
                            $file_name = time() . '.'. $file->getClientOriginalName();
                            $file->move($destinationPath , $file_name);
                            $photo .= $destinationPath . $file_name .',';
                        }
                    }
                    $result = DB::table('toor_booking2')->insert([
                        'name_id' => $request->name,
                        't_type' => $request->type,
                        'price' => $request->price,
                        'photo' => json_encode($photo),
                        'description' => $request->description,
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
    public function getTourBooking2ListById(Request $request){
        try{
            $rows = DB::table('toor_booking2')->where('id',$request->id)->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getTourBooking2ListByIdAgent(Request $request){
        try{
            $rows = DB::table('toor_booking2')->where('id',$request->id)->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteTourBookingList(Request $request){
        try{
            if($request->id) {
                $result =DB::table('toor_booking2')
                    ->where('id', $request->id)->delete();
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
    public function deleteTourBookingListAgent(Request $request){
        try{
            if($request->id) {
                $result =DB::table('toor_booking2')
                    ->where('id', $request->id)->delete();
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
    public function tntProfile(){
        try{
            $results = DB::table('bookingtnt')
                ->select('*','bookingtnt.price as f_price')
                ->join('toor_booking2','toor_booking2.id','=','bookingtnt.pack_id')
                ->join('toor_booking1','toor_booking1.id','=','toor_booking2.name_id')
                ->where('toor_booking1.user_id',Cookie::get('user_id'))
                ->orderBy('bookingtnt.id','desc')
                ->paginate(20);
            return view('backend.toursNTravelsReport',['orders' => $results]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
}
