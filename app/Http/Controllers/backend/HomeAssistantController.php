<?php

namespace App\Http\Controllers\backend;
use smasif\ShurjopayLaravelPackage\ShurjopayService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeAssistantController extends Controller
{
    public function cookingPage(){
        $shurjopay_service = new ShurjopayService();
        $tx_id = $shurjopay_service->generateTxId();
        $a = $shurjopay_service->sendPayment(200);
        dd($a);
        $rows = DB::table('cooking')
            ->where('status', 1)
            ->orderBy('id', 'DESC')->Paginate(10);
        return view('backend.cookingPage', ['cookings' => $rows]);
    }

    public function getCookingList(Request $request){
        try{
            $rows = DB::table('cooking')
                ->where('id', $request->id)
                ->where('status', 1)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertCooking(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('cooking')
                        ->where('id', $request->id)
                        ->update([
                            'cooking_type' => $request->type,
                            'meal' => $request->meal,
                            'time' => $request->time,
                            'price' => $request->price,
                            'person' => $request->person,
                            'gender' => $request->gender,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('cooking')->select('id')->where([
                        ['cooking_type', '=', $request->type],
                        ['meal', '=', $request->meal],
                        ['time', '=', $request->time],
                        ['price', '=', $request->price],
                        ['person', '=', $request->person],
                        ['gender', '=', $request->gender],
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন আইটেম লিখুন।');
                    } else {
                        $result = DB::table('cooking')->insert([
                            'cooking_type' => $request->type,
                            'meal' => $request->meal,
                            'time' => $request->time,
                            'price' => $request->price,
                            'person' => $request->person,
                            'gender' => $request->gender,
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
    public function deleteCooking(Request $request){
        try{

            if($request->id) {
                $result =DB::table('cooking')
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
    public function parlorService(){
        $rows = DB::table('parlor_service')
            ->where('status', 1)
            ->orderBy('id', 'DESC')->Paginate(10);
        return view('backend.parlorService', ['p_services' => $rows]);
    }
    public function getAllParlorType(Request $request){
        try{
            $rows = DB::table('parlor')
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }

    public function insertParlourService(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('parlor_service')
                        ->where('id', $request->id)
                        ->update([
                            'p_type' => $request->p_type,
                            'service' => $request->service,
                            'price' => $request->price,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('parlor_service')->select('id')->where([
                        ['p_type', '=', $request->p_type],
                        ['service', '=', $request->service],
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন আইটেম লিখুন।');
                    } else {
                        $result = DB::table('parlor_service')->insert([
                            'p_type' => $request->p_type,
                            'service' => $request->service,
                            'price' => $request->price,
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

    public function getParlorServiceById(Request $request){
        try{
            $rows = DB::table('parlor_service')
                ->where('id', $request->id)
                ->where('status', 1)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteParlorService(Request $request){
        try{

            if($request->id) {
                $result =DB::table('parlor_service')
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

    public function clothWashing(){
        $rows = DB::table('cloth_washing')
            ->orderBy('id', 'DESC')->Paginate(20);
        return view('backend.clothWashing', ['cloths' => $rows]);
    }
    public function insertCloth(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('cloth_washing')
                        ->where('id', $request->id)
                        ->update([
                            'name' => $request->name,
                            'price' => $request->price,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('cloth_washing')->select('id')->where([
                        ['name', '=', $request->name],
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন আইটেম লিখুন।');
                    } else {
                        $result = DB::table('cloth_washing')->insert([
                            'name' => $request->name,
                            'price' => $request->price,
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
    public function getClothById(Request $request){
        try{
            $rows = DB::table('cloth_washing')
                ->where('id', $request->id)
                ->where('status', 1)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteCloth(Request $request){
        try{

            if($request->id) {
                $result =DB::table('cloth_washing')
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
    public function roomCleaning(){
        $rows = DB::table('room_cleaning')
            ->orderBy('id', 'DESC')->Paginate(20);
        return view('backend.roomCleaning', ['rooms' => $rows]);
    }
    public function insertRoomCleaning(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('room_cleaning')
                        ->where('id', $request->id)
                        ->update([
                            'type' => $request->type,
                            'size' => $request->size,
                            'price' => $request->price,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('room_cleaning')->select('id')->where([
                        ['type', '=', $request->type],
                        ['size', '=', $request->size],
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন আইটেম লিখুন।');
                    } else {
                        $result = DB::table('room_cleaning')->insert([
                            'type' => $request->type,
                            'size' => $request->size,
                            'price' => $request->price,
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
    public function getRoomCleaningById(Request $request){
        try{
            $rows = DB::table('room_cleaning')
                ->where('id', $request->id)
                ->where('status', 1)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteRoomCleaning(Request $request){
        try{

            if($request->id) {
                $result =DB::table('room_cleaning')
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
    public function childCaring(){
        $rows = DB::table('child_caring')
            ->orderBy('id', 'DESC')->Paginate(20);
        return view('backend.childCaring', ['childs' => $rows]);
    }
    public function insertChildCaring(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('child_caring')
                        ->where('id', $request->id)
                        ->update([
                            'type' => $request->type,
                            'time' => $request->time,
                            'price' => $request->price,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('child_caring')->select('id')->where([
                        ['type', '=', $request->type],
                        ['time', '=', $request->size],
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন আইটেম লিখুন।');
                    } else {
                        $result = DB::table('child_caring')->insert([
                            'type' => $request->type,
                            'time' => $request->time,
                            'price' => $request->price,
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
    public function getChildCaringById(Request $request){
        try{
            $rows = DB::table('child_caring')
                ->where('id', $request->id)
                ->where('status', 1)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteChildCaring(Request $request){
        try{

            if($request->id) {
                $result =DB::table('room_cleaning')
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
    public function guardSetting(){
        $rows = DB::table('guard_setting')
            ->orderBy('id', 'DESC')->Paginate(20);
        return view('backend.guardSetting', ['guards' => $rows]);
    }
    public function insertGuardSetting(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('guard_setting')
                        ->where('id', $request->id)
                        ->update([
                            'type' => $request->type,
                            'time' => $request->time,
                            'price' => $request->price,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('guard_setting')->select('id')->where([
                        ['type', '=', $request->type],
                        ['time', '=', $request->size],
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন আইটেম লিখুন।');
                    } else {
                        $result = DB::table('guard_setting')->insert([
                            'type' => $request->type,
                            'time' => $request->time,
                            'price' => $request->price,
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
    public function getGuardSettingById(Request $request){
        try{
            $rows = DB::table('guard_setting')
                ->where('id', $request->id)
                ->where('status', 1)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteGuardSetting(Request $request){
        try{

            if($request->id) {
                $result =DB::table('guard_setting')
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
    public function variousServicing(){
        $rows = DB::table('various_servicing')
            ->orderBy('id', 'DESC')->Paginate(20);
        return view('backend.variousServicing', ['services' => $rows]);
    }
    public function insertVariousServicing(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('various_servicing')
                        ->where('id', $request->id)
                        ->update([
                            'type' => $request->type,
                            'name' => $request->name,
                            'price' => $request->price,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('various_servicing')->select('id')->where([
                        ['type', '=', $request->type],
                        ['name', '=', $request->name],
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন আইটেম লিখুন।');
                    } else {
                        $result = DB::table('various_servicing')->insert([
                            'type' => $request->type,
                            'name' => $request->name,
                            'price' => $request->price,
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
    public function getVariousServiceById(Request $request){
        try{
            $rows = DB::table('various_servicing')
                ->where('id', $request->id)
                ->where('status', 1)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteVariousService(Request $request){
        try{

            if($request->id) {
                $result =DB::table('various_servicing')
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
    public function laundryService(){
        $rows = DB::table('laundry')
            ->orderBy('id', 'DESC')->Paginate(20);
        return view('backend.laundryService', ['cloths' => $rows]);
    }
    public function insertLaundry(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('laundry')
                        ->where('id', $request->id)
                        ->update([
                            'name' => $request->name,
                            'price' => $request->price,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('laundry')->select('id')->where([
                        ['name', '=', $request->name],
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন আইটেম লিখুন।');
                    } else {
                        $result = DB::table('laundry')->insert([
                            'name' => $request->name,
                            'price' => $request->price,
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
    public function getLaundryById(Request $request){
        try{
            $rows = DB::table('laundry')
                ->where('id', $request->id)
                ->where('status', 1)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteLaundry(Request $request){
        try{

            if($request->id) {
                $result =DB::table('laundry')
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
