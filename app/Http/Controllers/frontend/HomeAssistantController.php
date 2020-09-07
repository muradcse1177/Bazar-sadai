<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class HomeAssistantController extends Controller
{
    public function serviceSubCategoryHomeAssistant($id){
        $home_assistant_sub_cat = DB::table('subcategories')
            ->where('cat_id', $id)
            ->where('type', 2)
            ->where('status', 1)
            ->orderBy('id', 'ASC')->get();
        return view('frontend.serviceSubCategoryHomeAssistant', ['home_assistant_sub_cats' => $home_assistant_sub_cat]);
    }
    public function cookingPageFront(){
        return view('frontend.cookingPage');
    }
    public function getAllCookingType(){
        $rows = DB::table('cooking')
            ->distinct()
            ->get('cooking_type');
        return response()->json(array('data'=>$rows));
    }
    public function getMealTypeFront(Request $request){
        $rows = DB::table('cooking')
            ->where('cooking_type', $request->id)
            ->get();
        return response()->json(array('data'=>$rows));
    }
    public function getMealPersonFront(Request $request){
        $rows = DB::table('cooking')
            ->where('cooking_type', $request->cooking_type)
            ->where('meal', $request->meal)
            ->get();
        return response()->json(array('data'=>$rows));
    }
    public function getMealTimeFront(Request $request){
        $rows = DB::table('cooking')
            ->where('cooking_type', $request->cooking_type)
            ->where('meal', $request->meal)
            ->where('person', $request->person)
            ->get();
        return response()->json(array('data'=>$rows));
    }
    public function getMealPriceFront(Request $request){
        $rows = DB::table('cooking')
            ->where('cooking_type', $request->cooking_type)
            ->where('meal', $request->meal)
            ->where('person', $request->person)
            ->where('time', $request->time)
            ->first();
        return response()->json(array('data'=>$rows));
    }
    public function cookingBookingFront(Request $request){
        try{
            if($request) {
                $rows = DB::table('cooking')
                    ->where('cooking_type', $request->cooking_type)
                    ->where('meal', $request->meal)
                    ->where('person', $request->person)
                    ->where('time', $request->time)
                    ->first();
                if($request->days) {
                    $price = $request->days * $rows->price;
                    $days = $request->days;
                }
                else {
                    $price = $rows->price;
                    $days =30;
                }
                $result = DB::table('cooking_booking')->insert([
                    'user_id' => Cookie::get('user_id'),
                    'days' => $days,
                    'cooking_type' => $request->cooking_type,
                    'meal' => $request->meal,
                    'person' => $request->person,
                    'time' => $request->time,
                    'price' => $price,
                    'date' => date("Y-m-d"),
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
    public function clothWashingPage(){
        $rows = DB::table('cloth_washing')
            ->get();
        return view('frontend.clothWashingPage', ['cloths' => $rows]);
    }
    public function getAllClothTypeFront(){
        $rows = DB::table('cloth_washing')
            ->get();
        return response()->json(array('data'=>$rows));
    }
    public function getClothWashingPriceFront(Request $request){
        $rows = DB::table('cloth_washing')
            ->where('id', $request->id)
            ->first();
        return response()->json(array('data'=>$rows));
    }
    public function clothWashingBookingFront(Request $request){
        try{
            if($request) {
                if(!empty($request->cloth_id)){
                    $quantity = array_filter($request->quantity, function($value) { return !is_null($value) && $value !== ''; });
                    $cloth_id = array_filter($request->cloth_id, function($value) { return !is_null($value) && $value !== ''; });
                    $i =0;
                    $j=0;
                    foreach ($quantity as $q){
                        $quantity_arr[$i] =$q;
                        $i++;
                    }
                    foreach ($cloth_id as $p){
                        $cloth_id_arr[$j] =$p;
                        $j++;
                    }
                    $price = 0;
                    for ($k=0; $k<count($cloth_id_arr); $k++){
                        $rows = DB::table('cloth_washing')
                            ->where('id', $cloth_id_arr[$k])
                            ->first();
                        $q_price = $rows->price* $quantity_arr[$k];
                        $price = ($price + $q_price) ;
                    }
                    $result = DB::table('cloth_washing_order')->insert([
                        'user_id' => Cookie::get('user_id'),
                        'date' => date("Y-m-d"),
                        'cloth_id' => json_encode($cloth_id),
                        'quantity' => json_encode($quantity),
                        'price' => $price,

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
            else{
                return back()->with('errorMessage', 'ফর্ম পুরন করুন।');
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getClothPriceByIdFront(Request $request){
        $rows = DB::table('cloth_washing')
            ->where('id', $request->id)
            ->first();
        return response()->json(array('data'=>$rows));
    }
    public function cleaningPage(){
        return view('frontend.cleaningPage');
    }
    public function getAllCleaningTypeFront(Request $request){
        $rows = DB::table('room_cleaning')
            ->distinct()
            ->get('type');
        return response()->json(array('data'=>$rows));
    }
    public function getCleaningSizeFront(Request $request){
        $rows = DB::table('room_cleaning')
            ->where('type', $request->type)
            ->get();
        return response()->json(array('data'=>$rows));
    }
    public function getCleaningPriceFront(Request $request){
        $rows = DB::table('room_cleaning')
            ->where('type', $request->type)
            ->where('size', $request->size)
            ->first();
        return response()->json(array('data'=>$rows));
    }
    public function cleaningBookingFront(Request $request){
        try{
            if($request) {
                $rows = DB::table('room_cleaning')
                    ->where('type', $request->type)
                    ->where('size', $request->size)
                    ->first();
                $result = DB::table('cleaning_order')->insert([
                    'user_id' => Cookie::get('user_id'),
                    'type' => $request->type,
                    'size' => $request->size,
                    'price' => $rows->price,
                    'date' => date("Y-m-d"),
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
    public function getAllHelpingHandTypeFront(Request $request){
        $rows = DB::table('child_caring')
            ->distinct()
            ->get('type');
        return response()->json(array('data'=>$rows));
    }
    public function helpingHandPage(){
        return view('frontend.helpingHandPage');
    }
    public function getHelpingTimeFront(Request $request){
        $rows = DB::table('child_caring')
            ->where('type', $request->type)
            ->get();
        return response()->json(array('data'=>$rows));
    }
    public function getHelpingPriceFront(Request $request){
        $rows = DB::table('child_caring')
            ->where('type', $request->type)
            ->where('time', $request->time)
            ->first();
        return response()->json(array('data'=>$rows));
    }
    public function helpingHandBookingFront(Request $request){
        try{
            if($request) {
                $rows = DB::table('child_caring')
                    ->where('type', $request->type)
                    ->where('time', $request->time)
                    ->first();
                if($request->days) {
                    $price = $request->days * $rows->price;
                    $days = $request->days;
                }
                else {
                    $price = $rows->price;
                    $days =30;
                }
                $result = DB::table('helping_hand_order')->insert([
                    'user_id' => Cookie::get('user_id'),
                    'days' => $days,
                    'type' => $request->type,
                    'time' => $request->time,
                    'price' => $price,
                    'date' => date("Y-m-d"),
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
    public function guardPage(){
        return view('frontend.guardPage');
    }
    public function getAllGuardTypeFront(Request $request){
        $rows = DB::table('guard_setting')
            ->distinct()
            ->get('type');
        return response()->json(array('data'=>$rows));
    }
    public function getGuardTimeFront(Request $request){
        $rows = DB::table('guard_setting')
            ->where('type', $request->type)
            ->get();
        return response()->json(array('data'=>$rows));
    }
    public function getGuardPriceFront(Request $request){
        $rows = DB::table('guard_setting')
            ->where('type', $request->type)
            ->where('time', $request->time)
            ->first();
        return response()->json(array('data'=>$rows));
    }
    public function guardBookingFront(Request $request){
        try{
            if($request) {
                $rows = DB::table('guard_setting')
                    ->where('type', $request->type)
                    ->where('time', $request->time)
                    ->first();
                if($request->days) {
                    $price = $request->days * $rows->price;
                    $days = $request->days;
                }
                else {
                    $price = $rows->price;
                    $days =30;
                }
                $result = DB::table('guard_order')->insert([
                    'user_id' => Cookie::get('user_id'),
                    'days' => $days,
                    'type' => $request->type,
                    'time' => $request->time,
                    'price' => $price,
                    'date' => date("Y-m-d"),
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
    public function productServicingPage(){
        return view('frontend.productServicingPage');
    }
    public function getAllProductServiceTypeFront(Request $request){
        $rows = DB::table('various_servicing')
            ->get();
        return response()->json(array('data'=>$rows));
    }
    public function getProductServiceNameTimeFront(Request $request){
        $rows = DB::table('various_servicing')
            ->where('type', $request->type)
            ->get();
        return response()->json(array('data'=>$rows));
    }
    public function getProductServicePriceFront(Request $request){
        $rows = DB::table('various_servicing')
            ->where('type', $request->type)
            ->where('name', $request->name)
            ->first();
        return response()->json(array('data'=>$rows));
    }
    public function productServicingBookingFront(Request $request){
        try{
            if($request) {
                $rows = DB::table('various_servicing')
                    ->where('type', $request->type)
                    ->where('name', $request->name)
                    ->first();
                $result = DB::table('various_servicing_order')->insert([
                    'user_id' => Cookie::get('user_id'),
                    'type' => $request->type,
                    'name' => $request->name,
                    'price' => $rows->price,
                    'date' => date("Y-m-d"),
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
    public function parlorServicingPage(){
        return view('frontend.parlorServicingPage');
    }
    public function getAllParlorTypeFront(Request $request){
        $rows = DB::table('parlor_service')
            ->distinct()
            ->get('p_type');
        return response()->json(array('data'=>$rows));
    }
    public function getParlorServiceNameFront(Request $request){
        $rows = DB::table('parlor_service')
            ->where('p_type', $request->type)
            ->get();
        return response()->json(array('data'=>$rows));
    }
    public function getParlorServicePriceFront(Request $request){
        $rows = DB::table('parlor_service')
            ->where('p_type', $request->type)
            ->where('service', $request->service)
            ->first();
        return response()->json(array('data'=>$rows));
    }
    public function parlorServiceBookingFront(Request $request){
        try{
            if($request) {
                $rows = DB::table('parlor_service')
                    ->where('p_type', $request->type)
                    ->where('service', $request->service)
                    ->first();
                $result = DB::table('parlor_order')->insert([
                    'user_id' => Cookie::get('user_id'),
                    'type' => $request->type,
                    'name' => $request->service,
                    'price' => $rows->price,
                    'date' => date("Y-m-d"),
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
