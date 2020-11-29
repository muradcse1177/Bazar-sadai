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
                //common
                $user_info = DB::table('users')
                    ->select('*')
                    ->where('id', Cookie::get('user_id'))
                    ->first();
                $working_status = 1;
                if($user_info->address_type == 1) {
                    $ward_info = DB::table('wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('dis_id', $user_info->add_part2)
                        ->where('upz_id', $user_info->add_part3)
                        ->where('uni_id', $user_info->add_part4)
                        ->where('id', $user_info->add_part5)
                        ->first();
                    $ward_plus = $ward_info->position + 1;
                    $ward_minus = $ward_info->position - 1;
                    $ward_plus_id_info = DB::table('wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('dis_id', $user_info->add_part2)
                        ->where('upz_id', $user_info->add_part3)
                        ->where('uni_id', $user_info->add_part4)
                        ->where('position', $ward_plus)
                        ->first();
                    $ward_plus_id = $ward_plus_id_info->id;
                    if($ward_info->position == 1) $ward_minus_id = $ward_info->position;
                    else{
                        $ward_minus_id_info = DB::table('wards')
                            ->select('*')
                            ->where('div_id', $user_info->add_part1)
                            ->where('dis_id', $user_info->add_part2)
                            ->where('upz_id', $user_info->add_part3)
                            ->where('uni_id', $user_info->add_part4)
                            ->where('position', $ward_minus)
                            ->first();
                        $ward_minus_id = $ward_minus_id_info->id;
                    }
                }
                if($user_info->address_type == 2) {
                    $c_ward_info = DB::table('c_wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('city_id', $user_info->add_part2)
                        ->where('city_co_id', $user_info->add_part3)
                        ->where('thana_id', $user_info->add_part4)
                        ->where('id', $user_info->add_part5)
                        ->first();
                    $ward_plus = $c_ward_info->position + 1;
                    $ward_minus = $c_ward_info->position - 1;
                    $c_ward_plus_id_info = DB::table('c_wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('city_id', $user_info->add_part2)
                        ->where('city_co_id', $user_info->add_part3)
                        ->where('thana_id', $user_info->add_part4)
                        ->where('position', $ward_plus)
                        ->first();
                    $ward_plus_id = $c_ward_plus_id_info->id;
                    if($c_ward_info->position == 1) $ward_minus_id = $c_ward_info->position;
                    else{
                        $c_ward_minus_id_info = DB::table('wards')
                            ->select('*')
                            ->where('div_id', $user_info->add_part1)
                            ->where('dis_id', $user_info->add_part2)
                            ->where('upz_id', $user_info->add_part3)
                            ->where('uni_id', $user_info->add_part4)
                            ->where('position', $ward_minus)
                            ->first();
                        $ward_minus_id = $c_ward_minus_id_info->id;
                    }
                }
                $user_type = 16;
                $delivery_man = DB::table('users')
                    ->where('user_type',  $user_type)
                    ->where('add_part1',  $user_info->add_part1)
                    ->where('add_part2',  $user_info->add_part2)
                    ->where('add_part3',  $user_info->add_part3)
                    ->where('add_part4',  $user_info->add_part4)
                    ->where('add_part5',  $user_info->add_part5)
                    ->where('working_status',  $working_status)
                    ->where('address_type',  $user_info->address_type)
                    ->where('status',  1)
                    ->first();
                if(!empty($delivery_man)){
                    $result =DB::table('users')
                        ->where('id', $delivery_man->id)
                        ->update([
                            'working_status' => 2,
                        ]);
                    $result = DB::table('cooking_booking')->insert([
                        'user_id' => Cookie::get('user_id'),
                        'cooker_id' => $delivery_man->id,
                        'days' => $days,
                        'cooking_type' => $request->cooking_type,
                        'meal' => $request->meal,
                        'person' => $request->person,
                        'time' => $request->time,
                        'price' => $price,
                        'date' => date("Y-m-d"),
                    ]);
                }
                else{
                    $delivery_man = DB::table('users')
                        ->where('user_type',  $user_type)
                        ->where('add_part1',  $user_info->add_part1)
                        ->where('add_part2',  $user_info->add_part2)
                        ->where('add_part3',  $user_info->add_part3)
                        ->where('add_part4',  $user_info->add_part4)
                        ->where('add_part5',  $ward_plus_id)
                        ->where('working_status',  $working_status)
                        ->where('address_type',  $user_info->address_type)
                        ->where('status',  1)
                        ->first();
                    if(!empty($delivery_man)){
                        $result =DB::table('users')
                            ->where('id', $delivery_man->id)
                            ->update([
                                'working_status' => 2,
                            ]);
                        $result = DB::table('cooking_booking')->insert([
                            'user_id' => Cookie::get('user_id'),
                            'cooker_id' => $delivery_man->id,
                            'days' => $days,
                            'cooking_type' => $request->cooking_type,
                            'meal' => $request->meal,
                            'person' => $request->person,
                            'time' => $request->time,
                            'price' => $price,
                            'date' => date("Y-m-d"),
                        ]);
                    }
                    else{
                        $delivery_man = DB::table('users')
                            ->where('user_type',  $user_type)
                            ->where('add_part1',  $user_info->add_part1)
                            ->where('add_part2',  $user_info->add_part2)
                            ->where('add_part3',  $user_info->add_part3)
                            ->where('add_part4',  $user_info->add_part4)
                            ->where('add_part5',  $ward_minus_id)
                            ->where('working_status',  $working_status)
                            ->where('address_type',  $user_info->address_type)
                            ->where('status',  1)
                            ->first();
                        if(!empty($delivery_man)){
                            $result =DB::table('users')
                                ->where('id', $delivery_man->id)
                                ->update([
                                    'working_status' => 2,
                                ]);
                            $result = DB::table('cooking_booking')->insert([
                                'user_id' => Cookie::get('user_id'),
                                'cooker_id' => $delivery_man->id,
                                'days' => $days,
                                'cooking_type' => $request->cooking_type,
                                'meal' => $request->meal,
                                'person' => $request->person,
                                'time' => $request->time,
                                'price' => $price,
                                'date' => date("Y-m-d"),
                            ]);

                        }
                    }
                }
                if(!empty($delivery_man)){
                    return redirect()->to('cookingPageFront')->with('successMessage', 'সফল্ভাবে অর্ডার সম্পন্ন্য হয়েছে। '.$delivery_man->name.' আপনার অর্ডার এর দায়িত্বে আছে। প্রয়োজনে '.$delivery_man->phone.' কল করুন।'  );
                }
                else{
                    return redirect()->to('cookingPageFront')->with('errorMessage', 'আপনার এলাকাই কোন কুকার খুজে পাওয়া যায়নি।');
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
                    //common
                    $user_info = DB::table('users')
                        ->select('*')
                        ->where('id', Cookie::get('user_id'))
                        ->first();
                    $working_status = 1;
                    if($user_info->address_type == 1) {
                        $ward_info = DB::table('wards')
                            ->select('*')
                            ->where('div_id', $user_info->add_part1)
                            ->where('dis_id', $user_info->add_part2)
                            ->where('upz_id', $user_info->add_part3)
                            ->where('uni_id', $user_info->add_part4)
                            ->where('id', $user_info->add_part5)
                            ->first();
                        $ward_plus = $ward_info->position + 1;
                        $ward_minus = $ward_info->position - 1;
                        $ward_plus_id_info = DB::table('wards')
                            ->select('*')
                            ->where('div_id', $user_info->add_part1)
                            ->where('dis_id', $user_info->add_part2)
                            ->where('upz_id', $user_info->add_part3)
                            ->where('uni_id', $user_info->add_part4)
                            ->where('position', $ward_plus)
                            ->first();
                        $ward_plus_id = $ward_plus_id_info->id;
                        if($ward_info->position == 1) $ward_minus_id = $ward_info->position;
                        else{
                            $ward_minus_id_info = DB::table('wards')
                                ->select('*')
                                ->where('div_id', $user_info->add_part1)
                                ->where('dis_id', $user_info->add_part2)
                                ->where('upz_id', $user_info->add_part3)
                                ->where('uni_id', $user_info->add_part4)
                                ->where('position', $ward_minus)
                                ->first();
                            $ward_minus_id = $ward_minus_id_info->id;
                        }
                    }
                    if($user_info->address_type == 2) {
                        $c_ward_info = DB::table('c_wards')
                            ->select('*')
                            ->where('div_id', $user_info->add_part1)
                            ->where('city_id', $user_info->add_part2)
                            ->where('city_co_id', $user_info->add_part3)
                            ->where('thana_id', $user_info->add_part4)
                            ->where('id', $user_info->add_part5)
                            ->first();
                        $ward_plus = $c_ward_info->position + 1;
                        $ward_minus = $c_ward_info->position - 1;
                        $c_ward_plus_id_info = DB::table('c_wards')
                            ->select('*')
                            ->where('div_id', $user_info->add_part1)
                            ->where('city_id', $user_info->add_part2)
                            ->where('city_co_id', $user_info->add_part3)
                            ->where('thana_id', $user_info->add_part4)
                            ->where('position', $ward_plus)
                            ->first();
                        $ward_plus_id = $c_ward_plus_id_info->id;
                        if($c_ward_info->position == 1) $ward_minus_id = $c_ward_info->position;
                        else{
                            $c_ward_minus_id_info = DB::table('wards')
                                ->select('*')
                                ->where('div_id', $user_info->add_part1)
                                ->where('dis_id', $user_info->add_part2)
                                ->where('upz_id', $user_info->add_part3)
                                ->where('uni_id', $user_info->add_part4)
                                ->where('position', $ward_minus)
                                ->first();
                            $ward_minus_id = $c_ward_minus_id_info->id;
                        }
                    }
                    $user_type = 21;
                    $delivery_man = DB::table('users')
                        ->where('user_type',  $user_type)
                        ->where('add_part1',  $user_info->add_part1)
                        ->where('add_part2',  $user_info->add_part2)
                        ->where('add_part3',  $user_info->add_part3)
                        ->where('add_part4',  $user_info->add_part4)
                        ->where('add_part5',  $user_info->add_part5)
                        ->where('working_status',  $working_status)
                        ->where('address_type',  $user_info->address_type)
                        ->where('status',  1)
                        ->first();
                    if(!empty($delivery_man)){
                        $result =DB::table('users')
                            ->where('id', $delivery_man->id)
                            ->update([
                                'working_status' => 2,
                            ]);
                        $result = DB::table('cloth_washing_order')->insert([
                            'user_id' => Cookie::get('user_id'),
                            'cleaner_id' => $delivery_man->id,
                            'date' => date("Y-m-d"),
                            'cloth_id' => json_encode($cloth_id),
                            'quantity' => json_encode($quantity),
                            'price' => $price,

                        ]);
                    }
                    else{
                        $delivery_man = DB::table('users')
                            ->where('user_type',  $user_type)
                            ->where('add_part1',  $user_info->add_part1)
                            ->where('add_part2',  $user_info->add_part2)
                            ->where('add_part3',  $user_info->add_part3)
                            ->where('add_part4',  $user_info->add_part4)
                            ->where('add_part5',  $ward_plus_id)
                            ->where('working_status',  $working_status)
                            ->where('address_type',  $user_info->address_type)
                            ->where('status',  1)
                            ->first();
                        if(!empty($delivery_man)){
                            $result =DB::table('users')
                                ->where('id', $delivery_man->id)
                                ->update([
                                    'working_status' => 2,
                                ]);
                            $result = DB::table('cloth_washing_order')->insert([
                                'user_id' => Cookie::get('user_id'),
                                'cleaner_id' => $delivery_man->id,
                                'date' => date("Y-m-d"),
                                'cloth_id' => json_encode($cloth_id),
                                'quantity' => json_encode($quantity),
                                'price' => $price,

                            ]);
                        }
                        else{
                            $delivery_man = DB::table('users')
                                ->where('user_type',  $user_type)
                                ->where('add_part1',  $user_info->add_part1)
                                ->where('add_part2',  $user_info->add_part2)
                                ->where('add_part3',  $user_info->add_part3)
                                ->where('add_part4',  $user_info->add_part4)
                                ->where('add_part5',  $ward_minus_id)
                                ->where('working_status',  $working_status)
                                ->where('address_type',  $user_info->address_type)
                                ->where('status',  1)
                                ->first();
                            if(!empty($delivery_man)){
                                $result =DB::table('users')
                                    ->where('id', $delivery_man->id)
                                    ->update([
                                        'working_status' => 2,
                                    ]);
                                $result = DB::table('cloth_washing_order')->insert([
                                    'user_id' => Cookie::get('user_id'),
                                    'cleaner_id' => $delivery_man->id,
                                    'date' => date("Y-m-d"),
                                    'cloth_id' => json_encode($cloth_id),
                                    'quantity' => json_encode($quantity),
                                    'price' => $price,
                                ]);
                            }
                        }
                    }
                    if(!empty($delivery_man)){
                        return redirect()->to('clothWashingPage')->with('successMessage', 'সফল্ভাবে অর্ডার সম্পন্ন্য হয়েছে। '.$delivery_man->name.' আপনার অর্ডার এর দায়িত্বে আছে। প্রয়োজনে '.$delivery_man->phone.' কল করুন।'  );
                    }
                    else{
                        return redirect()->to('cookingPageFront')->with('errorMessage', 'আপনার এলাকাই কোন কাপড় পরিস্কারক খুজে পাওয়া যায়নি।');
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
                //common
                $user_info = DB::table('users')
                    ->select('*')
                    ->where('id', Cookie::get('user_id'))
                    ->first();
                $working_status = 1;
                if($user_info->address_type == 1) {
                    $ward_info = DB::table('wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('dis_id', $user_info->add_part2)
                        ->where('upz_id', $user_info->add_part3)
                        ->where('uni_id', $user_info->add_part4)
                        ->where('id', $user_info->add_part5)
                        ->first();
                    $ward_plus = $ward_info->position + 1;
                    $ward_minus = $ward_info->position - 1;
                    $ward_plus_id_info = DB::table('wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('dis_id', $user_info->add_part2)
                        ->where('upz_id', $user_info->add_part3)
                        ->where('uni_id', $user_info->add_part4)
                        ->where('position', $ward_plus)
                        ->first();
                    $ward_plus_id = $ward_plus_id_info->id;
                    if($ward_info->position == 1) $ward_minus_id = $ward_info->position;
                    else{
                        $ward_minus_id_info = DB::table('wards')
                            ->select('*')
                            ->where('div_id', $user_info->add_part1)
                            ->where('dis_id', $user_info->add_part2)
                            ->where('upz_id', $user_info->add_part3)
                            ->where('uni_id', $user_info->add_part4)
                            ->where('position', $ward_minus)
                            ->first();
                        $ward_minus_id = $ward_minus_id_info->id;
                    }
                }
                if($user_info->address_type == 2) {
                    $c_ward_info = DB::table('c_wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('city_id', $user_info->add_part2)
                        ->where('city_co_id', $user_info->add_part3)
                        ->where('thana_id', $user_info->add_part4)
                        ->where('id', $user_info->add_part5)
                        ->first();
                    $ward_plus = $c_ward_info->position + 1;
                    $ward_minus = $c_ward_info->position - 1;
                    $c_ward_plus_id_info = DB::table('c_wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('city_id', $user_info->add_part2)
                        ->where('city_co_id', $user_info->add_part3)
                        ->where('thana_id', $user_info->add_part4)
                        ->where('position', $ward_plus)
                        ->first();
                    $ward_plus_id = $c_ward_plus_id_info->id;
                    if($c_ward_info->position == 1) $ward_minus_id = $c_ward_info->position;
                    else{
                        $c_ward_minus_id_info = DB::table('wards')
                            ->select('*')
                            ->where('div_id', $user_info->add_part1)
                            ->where('dis_id', $user_info->add_part2)
                            ->where('upz_id', $user_info->add_part3)
                            ->where('uni_id', $user_info->add_part4)
                            ->where('position', $ward_minus)
                            ->first();
                        $ward_minus_id = $c_ward_minus_id_info->id;
                    }
                }
                if($request->type =='ট্যাংক')
                    $user_type = 24;
                else
                    $user_type = 23;
                $delivery_man = DB::table('users')
                    ->where('user_type',  $user_type)
                    ->where('add_part1',  $user_info->add_part1)
                    ->where('add_part2',  $user_info->add_part2)
                    ->where('add_part3',  $user_info->add_part3)
                    ->where('add_part4',  $user_info->add_part4)
                    ->where('add_part5',  $user_info->add_part5)
                    ->where('working_status',  $working_status)
                    ->where('address_type',  $user_info->address_type)
                    ->where('status',  1)
                    ->first();
                if(!empty($delivery_man)){
                    $result =DB::table('users')
                        ->where('id', $delivery_man->id)
                        ->update([
                            'working_status' => 2,
                        ]);
                    $result = DB::table('cleaning_order')->insert([
                        'user_id' => Cookie::get('user_id'),
                        'cleaner_id' => $delivery_man->id,
                        'type' => $request->type,
                        'size' => $request->size,
                        'price' => $rows->price,
                        'date' => date("Y-m-d"),
                    ]);
                }
                else{
                    $delivery_man = DB::table('users')
                        ->where('user_type',  $user_type)
                        ->where('add_part1',  $user_info->add_part1)
                        ->where('add_part2',  $user_info->add_part2)
                        ->where('add_part3',  $user_info->add_part3)
                        ->where('add_part4',  $user_info->add_part4)
                        ->where('add_part5',  $ward_plus_id)
                        ->where('working_status',  $working_status)
                        ->where('address_type',  $user_info->address_type)
                        ->where('status',  1)
                        ->first();
                    if(!empty($delivery_man)){
                        $result =DB::table('users')
                            ->where('id', $delivery_man->id)
                            ->update([
                                'working_status' => 2,
                            ]);
                        $result = DB::table('cleaning_order')->insert([
                            'user_id' => Cookie::get('user_id'),
                            'cleaner_id' => $delivery_man->id,
                            'type' => $request->type,
                            'size' => $request->size,
                            'price' => $rows->price,
                            'date' => date("Y-m-d"),
                        ]);
                    }
                    else{
                        $delivery_man = DB::table('users')
                            ->where('user_type',  $user_type)
                            ->where('add_part1',  $user_info->add_part1)
                            ->where('add_part2',  $user_info->add_part2)
                            ->where('add_part3',  $user_info->add_part3)
                            ->where('add_part4',  $user_info->add_part4)
                            ->where('add_part5',  $ward_minus_id)
                            ->where('working_status',  $working_status)
                            ->where('address_type',  $user_info->address_type)
                            ->where('status',  1)
                            ->first();
                        if(!empty($delivery_man)){
                            $result =DB::table('users')
                                ->where('id', $delivery_man->id)
                                ->update([
                                    'working_status' => 2,
                                ]);
                            $result = DB::table('cleaning_order')->insert([
                                'user_id' => Cookie::get('user_id'),
                                'cleaner_id' => $delivery_man->id,
                                'type' => $request->type,
                                'size' => $request->size,
                                'price' => $rows->price,
                                'date' => date("Y-m-d"),
                            ]);
                        }
                    }
                }
                if(!empty($delivery_man)){
                    return redirect()->to('cleaningPage')->with('successMessage', 'সফল্ভাবে অর্ডার সম্পন্ন্য হয়েছে। '.$delivery_man->name.' আপনার অর্ডার এর দায়িত্বে আছে। প্রয়োজনে '.$delivery_man->phone.' কল করুন।'  );
                }
                else{
                    return redirect()->to('cleaningPage')->with('errorMessage', 'আপনার এলাকাই কোন  পরিস্কারক খুজে পাওয়া যায়নি।');
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
                //common
                $user_info = DB::table('users')
                    ->select('*')
                    ->where('id', Cookie::get('user_id'))
                    ->first();
                $working_status = 1;
                if($user_info->address_type == 1) {
                    $ward_info = DB::table('wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('dis_id', $user_info->add_part2)
                        ->where('upz_id', $user_info->add_part3)
                        ->where('uni_id', $user_info->add_part4)
                        ->where('id', $user_info->add_part5)
                        ->first();
                    $ward_plus = $ward_info->position + 1;
                    $ward_minus = $ward_info->position - 1;
                    $ward_plus_id_info = DB::table('wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('dis_id', $user_info->add_part2)
                        ->where('upz_id', $user_info->add_part3)
                        ->where('uni_id', $user_info->add_part4)
                        ->where('position', $ward_plus)
                        ->first();
                    $ward_plus_id = $ward_plus_id_info->id;
                    if($ward_info->position == 1) $ward_minus_id = $ward_info->position;
                    else{
                        $ward_minus_id_info = DB::table('wards')
                            ->select('*')
                            ->where('div_id', $user_info->add_part1)
                            ->where('dis_id', $user_info->add_part2)
                            ->where('upz_id', $user_info->add_part3)
                            ->where('uni_id', $user_info->add_part4)
                            ->where('position', $ward_minus)
                            ->first();
                        $ward_minus_id = $ward_minus_id_info->id;
                    }
                }
                if($user_info->address_type == 2) {
                    $c_ward_info = DB::table('c_wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('city_id', $user_info->add_part2)
                        ->where('city_co_id', $user_info->add_part3)
                        ->where('thana_id', $user_info->add_part4)
                        ->where('id', $user_info->add_part5)
                        ->first();
                    $ward_plus = $c_ward_info->position + 1;
                    $ward_minus = $c_ward_info->position - 1;
                    $c_ward_plus_id_info = DB::table('c_wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('city_id', $user_info->add_part2)
                        ->where('city_co_id', $user_info->add_part3)
                        ->where('thana_id', $user_info->add_part4)
                        ->where('position', $ward_plus)
                        ->first();
                    $ward_plus_id = $c_ward_plus_id_info->id;
                    if($c_ward_info->position == 1) $ward_minus_id = $c_ward_info->position;
                    else{
                        $c_ward_minus_id_info = DB::table('wards')
                            ->select('*')
                            ->where('div_id', $user_info->add_part1)
                            ->where('dis_id', $user_info->add_part2)
                            ->where('upz_id', $user_info->add_part3)
                            ->where('uni_id', $user_info->add_part4)
                            ->where('position', $ward_minus)
                            ->first();
                        $ward_minus_id = $c_ward_minus_id_info->id;
                    }
                }
                $user_type = 25;
                $delivery_man = DB::table('users')
                    ->where('user_type',  $user_type)
                    ->where('add_part1',  $user_info->add_part1)
                    ->where('add_part2',  $user_info->add_part2)
                    ->where('add_part3',  $user_info->add_part3)
                    ->where('add_part4',  $user_info->add_part4)
                    ->where('add_part5',  $user_info->add_part5)
                    ->where('working_status',  $working_status)
                    ->where('address_type',  $user_info->address_type)
                    ->where('status',  1)
                    ->first();
                if(!empty($delivery_man)){
                    $result =DB::table('users')
                        ->where('id', $delivery_man->id)
                        ->update([
                            'working_status' => 2,
                        ]);
                    $result = DB::table('helping_hand_order')->insert([
                        'user_id' => Cookie::get('user_id'),
                        'helper' => $delivery_man->id,
                        'days' => $days,
                        'type' => $request->type,
                        'time' => $request->time,
                        'price' => $price,
                        'date' => date("Y-m-d"),
                    ]);
                }
                else{
                    $delivery_man = DB::table('users')
                        ->where('user_type',  $user_type)
                        ->where('add_part1',  $user_info->add_part1)
                        ->where('add_part2',  $user_info->add_part2)
                        ->where('add_part3',  $user_info->add_part3)
                        ->where('add_part4',  $user_info->add_part4)
                        ->where('add_part5',  $ward_plus_id)
                        ->where('working_status',  $working_status)
                        ->where('address_type',  $user_info->address_type)
                        ->where('status',  1)
                        ->first();
                    if(!empty($delivery_man)){
                        $result =DB::table('users')
                            ->where('id', $delivery_man->id)
                            ->update([
                                'working_status' => 2,
                            ]);
                        $result = DB::table('helping_hand_order')->insert([
                            'user_id' => Cookie::get('user_id'),
                            'helper' => $delivery_man->id,
                            'days' => $days,
                            'type' => $request->type,
                            'time' => $request->time,
                            'price' => $price,
                            'date' => date("Y-m-d"),
                        ]);
                    }
                    else{
                        $delivery_man = DB::table('users')
                            ->where('user_type',  $user_type)
                            ->where('add_part1',  $user_info->add_part1)
                            ->where('add_part2',  $user_info->add_part2)
                            ->where('add_part3',  $user_info->add_part3)
                            ->where('add_part4',  $user_info->add_part4)
                            ->where('add_part5',  $ward_minus_id)
                            ->where('working_status',  $working_status)
                            ->where('address_type',  $user_info->address_type)
                            ->where('status',  1)
                            ->first();
                        if(!empty($delivery_man)){
                            $result =DB::table('users')
                                ->where('id', $delivery_man->id)
                                ->update([
                                    'working_status' => 2,
                                ]);
                            $result = DB::table('helping_hand_order')->insert([
                                'user_id' => Cookie::get('user_id'),
                                'helper' => $delivery_man->id,
                                'days' => $days,
                                'type' => $request->type,
                                'time' => $request->time,
                                'price' => $price,
                                'date' => date("Y-m-d"),
                            ]);
                        }
                    }
                }
                if(!empty($delivery_man)){
                    return redirect()->to('helpingHandPage')->with('successMessage', 'সফল্ভাবে অর্ডার সম্পন্ন্য হয়েছে। '.$delivery_man->name.' আপনার অর্ডার এর দায়িত্বে আছে। প্রয়োজনে '.$delivery_man->phone.' কল করুন।'  );
                }
                else{
                    return redirect()->to('helpingHandPage')->with('errorMessage', 'আপনার এলাকাই কোন হেল্পার খুজে পাওয়া যায়নি।');
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
                //common
                $user_info = DB::table('users')
                    ->select('*')
                    ->where('id', Cookie::get('user_id'))
                    ->first();
                $working_status = 1;
                if($user_info->address_type == 1) {
                    $ward_info = DB::table('wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('dis_id', $user_info->add_part2)
                        ->where('upz_id', $user_info->add_part3)
                        ->where('uni_id', $user_info->add_part4)
                        ->where('id', $user_info->add_part5)
                        ->first();
                    $ward_plus = $ward_info->position + 1;
                    $ward_minus = $ward_info->position - 1;
                    $ward_plus_id_info = DB::table('wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('dis_id', $user_info->add_part2)
                        ->where('upz_id', $user_info->add_part3)
                        ->where('uni_id', $user_info->add_part4)
                        ->where('position', $ward_plus)
                        ->first();
                    $ward_plus_id = $ward_plus_id_info->id;
                    if($ward_info->position == 1) $ward_minus_id = $ward_info->position;
                    else{
                        $ward_minus_id_info = DB::table('wards')
                            ->select('*')
                            ->where('div_id', $user_info->add_part1)
                            ->where('dis_id', $user_info->add_part2)
                            ->where('upz_id', $user_info->add_part3)
                            ->where('uni_id', $user_info->add_part4)
                            ->where('position', $ward_minus)
                            ->first();
                        $ward_minus_id = $ward_minus_id_info->id;
                    }
                }
                if($user_info->address_type == 2) {
                    $c_ward_info = DB::table('c_wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('city_id', $user_info->add_part2)
                        ->where('city_co_id', $user_info->add_part3)
                        ->where('thana_id', $user_info->add_part4)
                        ->where('id', $user_info->add_part5)
                        ->first();
                    $ward_plus = $c_ward_info->position + 1;
                    $ward_minus = $c_ward_info->position - 1;
                    $c_ward_plus_id_info = DB::table('c_wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('city_id', $user_info->add_part2)
                        ->where('city_co_id', $user_info->add_part3)
                        ->where('thana_id', $user_info->add_part4)
                        ->where('position', $ward_plus)
                        ->first();
                    $ward_plus_id = $c_ward_plus_id_info->id;
                    if($c_ward_info->position == 1) $ward_minus_id = $c_ward_info->position;
                    else{
                        $c_ward_minus_id_info = DB::table('wards')
                            ->select('*')
                            ->where('div_id', $user_info->add_part1)
                            ->where('dis_id', $user_info->add_part2)
                            ->where('upz_id', $user_info->add_part3)
                            ->where('uni_id', $user_info->add_part4)
                            ->where('position', $ward_minus)
                            ->first();
                        $ward_minus_id = $c_ward_minus_id_info->id;
                    }
                }
                $user_type = 26;
                $delivery_man = DB::table('users')
                    ->where('user_type',  $user_type)
                    ->where('add_part1',  $user_info->add_part1)
                    ->where('add_part2',  $user_info->add_part2)
                    ->where('add_part3',  $user_info->add_part3)
                    ->where('add_part4',  $user_info->add_part4)
                    ->where('add_part5',  $user_info->add_part5)
                    ->where('working_status',  $working_status)
                    ->where('address_type',  $user_info->address_type)
                    ->where('status',  1)
                    ->first();
                if(!empty($delivery_man)){
                    $result =DB::table('users')
                        ->where('id', $delivery_man->id)
                        ->update([
                            'working_status' => 2,
                        ]);
                    $result = DB::table('guard_order')->insert([
                        'user_id' => Cookie::get('user_id'),
                        'gurd_id' => $delivery_man->id,
                        'days' => $days,
                        'type' => $request->type,
                        'time' => $request->time,
                        'price' => $price,
                        'date' => date("Y-m-d"),
                    ]);
                }
                else{
                    $delivery_man = DB::table('users')
                        ->where('user_type',  $user_type)
                        ->where('add_part1',  $user_info->add_part1)
                        ->where('add_part2',  $user_info->add_part2)
                        ->where('add_part3',  $user_info->add_part3)
                        ->where('add_part4',  $user_info->add_part4)
                        ->where('add_part5',  $ward_plus_id)
                        ->where('working_status',  $working_status)
                        ->where('address_type',  $user_info->address_type)
                        ->where('status',  1)
                        ->first();
                    if(!empty($delivery_man)){
                        $result =DB::table('users')
                            ->where('id', $delivery_man->id)
                            ->update([
                                'working_status' => 2,
                            ]);
                        $result = DB::table('guard_order')->insert([
                            'user_id' => Cookie::get('user_id'),
                            'gurd_id' => $delivery_man->id,
                            'days' => $days,
                            'type' => $request->type,
                            'time' => $request->time,
                            'price' => $price,
                            'date' => date("Y-m-d"),
                        ]);
                    }
                    else{
                        $delivery_man = DB::table('users')
                            ->where('user_type',  $user_type)
                            ->where('add_part1',  $user_info->add_part1)
                            ->where('add_part2',  $user_info->add_part2)
                            ->where('add_part3',  $user_info->add_part3)
                            ->where('add_part4',  $user_info->add_part4)
                            ->where('add_part5',  $ward_minus_id)
                            ->where('working_status',  $working_status)
                            ->where('address_type',  $user_info->address_type)
                            ->where('status',  1)
                            ->first();
                        if(!empty($delivery_man)){
                            $result =DB::table('users')
                                ->where('id', $delivery_man->id)
                                ->update([
                                    'working_status' => 2,
                                ]);
                            $result = DB::table('guard_order')->insert([
                                'user_id' => Cookie::get('user_id'),
                                'gurd_id' => $delivery_man->id,
                                'days' => $days,
                                'type' => $request->type,
                                'time' => $request->time,
                                'price' => $price,
                                'date' => date("Y-m-d"),
                            ]);
                        }
                    }
                }
                if(!empty($delivery_man)){
                    return redirect()->to('guardPage')->with('successMessage', 'সফল্ভাবে অর্ডার সম্পন্ন্য হয়েছে। '.$delivery_man->name.' আপনার অর্ডার এর দায়িত্বে আছে। প্রয়োজনে '.$delivery_man->phone.' কল করুন।'  );
                }
                else{
                    return redirect()->to('guardPage')->with('errorMessage', 'আপনার এলাকাই কোন গার্ড খুজে পাওয়া যায়নি।');
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
                //common
                $user_info = DB::table('users')
                    ->select('*')
                    ->where('id', Cookie::get('user_id'))
                    ->first();
                $working_status = 1;
                if($user_info->address_type == 1) {
                    $ward_info = DB::table('wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('dis_id', $user_info->add_part2)
                        ->where('upz_id', $user_info->add_part3)
                        ->where('uni_id', $user_info->add_part4)
                        ->where('id', $user_info->add_part5)
                        ->first();
                    $ward_plus = $ward_info->position + 1;
                    $ward_minus = $ward_info->position - 1;
                    $ward_plus_id_info = DB::table('wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('dis_id', $user_info->add_part2)
                        ->where('upz_id', $user_info->add_part3)
                        ->where('uni_id', $user_info->add_part4)
                        ->where('position', $ward_plus)
                        ->first();
                    $ward_plus_id = $ward_plus_id_info->id;
                    if($ward_info->position == 1) $ward_minus_id = $ward_info->position;
                    else{
                        $ward_minus_id_info = DB::table('wards')
                            ->select('*')
                            ->where('div_id', $user_info->add_part1)
                            ->where('dis_id', $user_info->add_part2)
                            ->where('upz_id', $user_info->add_part3)
                            ->where('uni_id', $user_info->add_part4)
                            ->where('position', $ward_minus)
                            ->first();
                        $ward_minus_id = $ward_minus_id_info->id;
                    }
                }
                if($user_info->address_type == 2) {
                    $c_ward_info = DB::table('c_wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('city_id', $user_info->add_part2)
                        ->where('city_co_id', $user_info->add_part3)
                        ->where('thana_id', $user_info->add_part4)
                        ->where('id', $user_info->add_part5)
                        ->first();
                    $ward_plus = $c_ward_info->position + 1;
                    $ward_minus = $c_ward_info->position - 1;
                    $c_ward_plus_id_info = DB::table('c_wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('city_id', $user_info->add_part2)
                        ->where('city_co_id', $user_info->add_part3)
                        ->where('thana_id', $user_info->add_part4)
                        ->where('position', $ward_plus)
                        ->first();
                    $ward_plus_id = $c_ward_plus_id_info->id;
                    if($c_ward_info->position == 1) $ward_minus_id = $c_ward_info->position;
                    else{
                        $c_ward_minus_id_info = DB::table('wards')
                            ->select('*')
                            ->where('div_id', $user_info->add_part1)
                            ->where('dis_id', $user_info->add_part2)
                            ->where('upz_id', $user_info->add_part3)
                            ->where('uni_id', $user_info->add_part4)
                            ->where('position', $ward_minus)
                            ->first();
                        $ward_minus_id = $c_ward_minus_id_info->id;
                    }
                }
                if($request->type == 'স্টোভ')
                    $user_type = 27;
                if($request->type == 'ইলেক্ট্রনিক্স')
                    $user_type = 28;
                if($request->type == 'স্যানিটারি')
                    $user_type = 29;
                if($request->type == 'এসি')
                    $user_type = 30;
                $delivery_man = DB::table('users')
                    ->where('user_type',  $user_type)
                    ->where('add_part1',  $user_info->add_part1)
                    ->where('add_part2',  $user_info->add_part2)
                    ->where('add_part3',  $user_info->add_part3)
                    ->where('add_part4',  $user_info->add_part4)
                    ->where('add_part5',  $user_info->add_part5)
                    ->where('working_status',  $working_status)
                    ->where('address_type',  $user_info->address_type)
                    ->where('status',  1)
                    ->first();
                if(!empty($delivery_man)){
                    $result =DB::table('users')
                        ->where('id', $delivery_man->id)
                        ->update([
                            'working_status' => 2,
                        ]);
                    $result = DB::table('various_servicing_order')->insert([
                        'user_id' => Cookie::get('user_id'),
                        'worker' => $delivery_man->id,
                        'type' => $request->type,
                        'name' => $request->name,
                        'price' => $rows->price,
                        'date' => date("Y-m-d"),
                    ]);
                }
                else{
                    $delivery_man = DB::table('users')
                        ->where('user_type',  $user_type)
                        ->where('add_part1',  $user_info->add_part1)
                        ->where('add_part2',  $user_info->add_part2)
                        ->where('add_part3',  $user_info->add_part3)
                        ->where('add_part4',  $user_info->add_part4)
                        ->where('add_part5',  $ward_plus_id)
                        ->where('working_status',  $working_status)
                        ->where('address_type',  $user_info->address_type)
                        ->where('status',  1)
                        ->first();
                    if(!empty($delivery_man)){
                        $result =DB::table('users')
                            ->where('id', $delivery_man->id)
                            ->update([
                                'working_status' => 2,
                            ]);
                        $result = DB::table('various_servicing_order')->insert([
                            'user_id' => Cookie::get('user_id'),
                            'worker' => $delivery_man->id,
                            'type' => $request->type,
                            'name' => $request->name,
                            'price' => $rows->price,
                            'date' => date("Y-m-d"),
                        ]);
                    }
                    else{
                        $delivery_man = DB::table('users')
                            ->where('user_type',  $user_type)
                            ->where('add_part1',  $user_info->add_part1)
                            ->where('add_part2',  $user_info->add_part2)
                            ->where('add_part3',  $user_info->add_part3)
                            ->where('add_part4',  $user_info->add_part4)
                            ->where('add_part5',  $ward_minus_id)
                            ->where('working_status',  $working_status)
                            ->where('address_type',  $user_info->address_type)
                            ->where('status',  1)
                            ->first();
                        if(!empty($delivery_man)){
                            $result =DB::table('users')
                                ->where('id', $delivery_man->id)
                                ->update([
                                    'working_status' => 2,
                                ]);
                            $result = DB::table('various_servicing_order')->insert([
                                'user_id' => Cookie::get('user_id'),
                                'worker' => $delivery_man->id,
                                'type' => $request->type,
                                'name' => $request->name,
                                'price' => $rows->price,
                                'date' => date("Y-m-d"),
                            ]);
                        }
                    }
                }
                if(!empty($delivery_man)){
                    return redirect()->to('productServicingPage')->with('successMessage', 'সফল্ভাবে অর্ডার সম্পন্ন্য হয়েছে। '.$delivery_man->name.' আপনার অর্ডার এর দায়িত্বে আছে। প্রয়োজনে '.$delivery_man->phone.' কল করুন।'  );
                }
                else{
                    return redirect()->to('productServicingPage')->with('errorMessage', 'আপনার এলাকাই কোন কাজের লোক খুজে পাওয়া যায়নি।');
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
                //common
                $user_info = DB::table('users')
                    ->select('*')
                    ->where('id', Cookie::get('user_id'))
                    ->first();
                $working_status = 1;
                if($user_info->address_type == 1) {
                    $ward_info = DB::table('wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('dis_id', $user_info->add_part2)
                        ->where('upz_id', $user_info->add_part3)
                        ->where('uni_id', $user_info->add_part4)
                        ->where('id', $user_info->add_part5)
                        ->first();
                    $ward_plus = $ward_info->position + 1;
                    $ward_minus = $ward_info->position - 1;
                    $ward_plus_id_info = DB::table('wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('dis_id', $user_info->add_part2)
                        ->where('upz_id', $user_info->add_part3)
                        ->where('uni_id', $user_info->add_part4)
                        ->where('position', $ward_plus)
                        ->first();
                    $ward_plus_id = $ward_plus_id_info->id;
                    if($ward_info->position == 1) $ward_minus_id = $ward_info->position;
                    else{
                        $ward_minus_id_info = DB::table('wards')
                            ->select('*')
                            ->where('div_id', $user_info->add_part1)
                            ->where('dis_id', $user_info->add_part2)
                            ->where('upz_id', $user_info->add_part3)
                            ->where('uni_id', $user_info->add_part4)
                            ->where('position', $ward_minus)
                            ->first();
                        $ward_minus_id = $ward_minus_id_info->id;
                    }
                }
                if($user_info->address_type == 2) {
                    $c_ward_info = DB::table('c_wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('city_id', $user_info->add_part2)
                        ->where('city_co_id', $user_info->add_part3)
                        ->where('thana_id', $user_info->add_part4)
                        ->where('id', $user_info->add_part5)
                        ->first();
                    $ward_plus = $c_ward_info->position + 1;
                    $ward_minus = $c_ward_info->position - 1;
                    $c_ward_plus_id_info = DB::table('c_wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('city_id', $user_info->add_part2)
                        ->where('city_co_id', $user_info->add_part3)
                        ->where('thana_id', $user_info->add_part4)
                        ->where('position', $ward_plus)
                        ->first();
                    $ward_plus_id = $c_ward_plus_id_info->id;
                    if($c_ward_info->position == 1) $ward_minus_id = $c_ward_info->position;
                    else{
                        $c_ward_minus_id_info = DB::table('wards')
                            ->select('*')
                            ->where('div_id', $user_info->add_part1)
                            ->where('dis_id', $user_info->add_part2)
                            ->where('upz_id', $user_info->add_part3)
                            ->where('uni_id', $user_info->add_part4)
                            ->where('position', $ward_minus)
                            ->first();
                        $ward_minus_id = $c_ward_minus_id_info->id;
                    }
                }
                $user_type = 31;
                $delivery_man = DB::table('users')
                    ->where('user_type',  $user_type)
                    ->where('add_part1',  $user_info->add_part1)
                    ->where('add_part2',  $user_info->add_part2)
                    ->where('add_part3',  $user_info->add_part3)
                    ->where('add_part4',  $user_info->add_part4)
                    ->where('add_part5',  $user_info->add_part5)
                    ->where('working_status',  $working_status)
                    ->where('address_type',  $user_info->address_type)
                    ->where('status',  1)
                    ->first();
                if(!empty($delivery_man)){
                    $result =DB::table('users')
                        ->where('id', $delivery_man->id)
                        ->update([
                            'working_status' => 2,
                        ]);
                    $result = DB::table('parlor_order')->insert([
                        'user_id' => Cookie::get('user_id'),
                        'type' => $request->type,
                        'parlor_id' => $delivery_man->id,
                        'name' => $request->service,
                        'price' => $rows->price,
                        'date' => date("Y-m-d"),
                    ]);
                }
                else{
                    $delivery_man = DB::table('users')
                        ->where('user_type',  $user_type)
                        ->where('add_part1',  $user_info->add_part1)
                        ->where('add_part2',  $user_info->add_part2)
                        ->where('add_part3',  $user_info->add_part3)
                        ->where('add_part4',  $user_info->add_part4)
                        ->where('add_part5',  $ward_plus_id)
                        ->where('working_status',  $working_status)
                        ->where('address_type',  $user_info->address_type)
                        ->where('status',  1)
                        ->first();
                    if(!empty($delivery_man)){
                        $result =DB::table('users')
                            ->where('id', $delivery_man->id)
                            ->update([
                                'working_status' => 2,
                            ]);
                        $result = DB::table('parlor_order')->insert([
                            'user_id' => Cookie::get('user_id'),
                            'type' => $request->type,
                            'parlor_id' => $delivery_man->id,
                            'name' => $request->service,
                            'price' => $rows->price,
                            'date' => date("Y-m-d"),
                        ]);
                    }
                    else{
                        $delivery_man = DB::table('users')
                            ->where('user_type',  $user_type)
                            ->where('add_part1',  $user_info->add_part1)
                            ->where('add_part2',  $user_info->add_part2)
                            ->where('add_part3',  $user_info->add_part3)
                            ->where('add_part4',  $user_info->add_part4)
                            ->where('add_part5',  $ward_minus_id)
                            ->where('working_status',  $working_status)
                            ->where('address_type',  $user_info->address_type)
                            ->where('status',  1)
                            ->first();
                        if(!empty($delivery_man)){
                            $result =DB::table('users')
                                ->where('id', $delivery_man->id)
                                ->update([
                                    'working_status' => 2,
                                ]);
                            $result = DB::table('parlor_order')->insert([
                                'user_id' => Cookie::get('user_id'),
                                'type' => $request->type,
                                'parlor_id' => $delivery_man->id,
                                'name' => $request->service,
                                'price' => $rows->price,
                                'date' => date("Y-m-d"),
                            ]);
                        }
                    }
                }
                if(!empty($delivery_man)){
                    return redirect()->to('productServicingPage')->with('successMessage', 'সফল্ভাবে অর্ডার সম্পন্ন্য হয়েছে। '.$delivery_man->name.' আপনার অর্ডার এর দায়িত্বে আছে। প্রয়োজনে '.$delivery_man->phone.' কল করুন।'  );
                }
                else{
                    return redirect()->to('productServicingPage')->with('errorMessage', 'আপনার এলাকাই কোন কাজের লোক খুজে পাওয়া যায়নি।');
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
    public function laundryServicePage(){
        $rows = DB::table('laundry')
            ->get();
        return view('frontend.laundryServicePage', ['cloths' => $rows]);
    }
    public function getLaundryPriceByIdFront(Request $request){
        $rows = DB::table('laundry')
            ->where('id', $request->id)
            ->first();
        return response()->json(array('data'=>$rows));
    }
    public function laundryBookingFront(Request $request){
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
                        $rows = DB::table('laundry')
                            ->where('id', $cloth_id_arr[$k])
                            ->first();
                        $q_price = $rows->price* $quantity_arr[$k];
                        $price = ($price + $q_price) ;
                    }
                    //common
                    $user_info = DB::table('users')
                        ->select('*')
                        ->where('id', Cookie::get('user_id'))
                        ->first();
                    $working_status = 1;
                    if($user_info->address_type == 1) {
                        $ward_info = DB::table('wards')
                            ->select('*')
                            ->where('div_id', $user_info->add_part1)
                            ->where('dis_id', $user_info->add_part2)
                            ->where('upz_id', $user_info->add_part3)
                            ->where('uni_id', $user_info->add_part4)
                            ->where('id', $user_info->add_part5)
                            ->first();
                        $ward_plus = $ward_info->position + 1;
                        $ward_minus = $ward_info->position - 1;
                        $ward_plus_id_info = DB::table('wards')
                            ->select('*')
                            ->where('div_id', $user_info->add_part1)
                            ->where('dis_id', $user_info->add_part2)
                            ->where('upz_id', $user_info->add_part3)
                            ->where('uni_id', $user_info->add_part4)
                            ->where('position', $ward_plus)
                            ->first();
                        $ward_plus_id = $ward_plus_id_info->id;
                        if($ward_info->position == 1) $ward_minus_id = $ward_info->position;
                        else{
                            $ward_minus_id_info = DB::table('wards')
                                ->select('*')
                                ->where('div_id', $user_info->add_part1)
                                ->where('dis_id', $user_info->add_part2)
                                ->where('upz_id', $user_info->add_part3)
                                ->where('uni_id', $user_info->add_part4)
                                ->where('position', $ward_minus)
                                ->first();
                            $ward_minus_id = $ward_minus_id_info->id;
                        }
                    }
                    if($user_info->address_type == 2) {
                        $c_ward_info = DB::table('c_wards')
                            ->select('*')
                            ->where('div_id', $user_info->add_part1)
                            ->where('city_id', $user_info->add_part2)
                            ->where('city_co_id', $user_info->add_part3)
                            ->where('thana_id', $user_info->add_part4)
                            ->where('id', $user_info->add_part5)
                            ->first();
                        $ward_plus = $c_ward_info->position + 1;
                        $ward_minus = $c_ward_info->position - 1;
                        $c_ward_plus_id_info = DB::table('c_wards')
                            ->select('*')
                            ->where('div_id', $user_info->add_part1)
                            ->where('city_id', $user_info->add_part2)
                            ->where('city_co_id', $user_info->add_part3)
                            ->where('thana_id', $user_info->add_part4)
                            ->where('position', $ward_plus)
                            ->first();
                        $ward_plus_id = $c_ward_plus_id_info->id;
                        if($c_ward_info->position == 1) $ward_minus_id = $c_ward_info->position;
                        else{
                            $c_ward_minus_id_info = DB::table('wards')
                                ->select('*')
                                ->where('div_id', $user_info->add_part1)
                                ->where('dis_id', $user_info->add_part2)
                                ->where('upz_id', $user_info->add_part3)
                                ->where('uni_id', $user_info->add_part4)
                                ->where('position', $ward_minus)
                                ->first();
                            $ward_minus_id = $c_ward_minus_id_info->id;
                        }
                    }
                    $user_type = 22;
                    $delivery_man = DB::table('users')
                        ->where('user_type',  $user_type)
                        ->where('add_part1',  $user_info->add_part1)
                        ->where('add_part2',  $user_info->add_part2)
                        ->where('add_part3',  $user_info->add_part3)
                        ->where('add_part4',  $user_info->add_part4)
                        ->where('add_part5',  $user_info->add_part5)
                        ->where('working_status',  $working_status)
                        ->where('address_type',  $user_info->address_type)
                        ->where('status',  1)
                        ->first();
                    if(!empty($delivery_man)){
                        $result =DB::table('users')
                            ->where('id', $delivery_man->id)
                            ->update([
                                'working_status' => 2,
                            ]);
                        $result = DB::table('laundry_order')->insert([
                            'user_id' => Cookie::get('user_id'),
                            'cleaner_id' => $delivery_man->id,
                            'date' => date("Y-m-d"),
                            'cloth_id' => json_encode($cloth_id),
                            'quantity' => json_encode($quantity),
                            'price' => $price,

                        ]);
                    }
                    else{
                        $delivery_man = DB::table('users')
                            ->where('user_type',  $user_type)
                            ->where('add_part1',  $user_info->add_part1)
                            ->where('add_part2',  $user_info->add_part2)
                            ->where('add_part3',  $user_info->add_part3)
                            ->where('add_part4',  $user_info->add_part4)
                            ->where('add_part5',  $ward_plus_id)
                            ->where('working_status',  $working_status)
                            ->where('address_type',  $user_info->address_type)
                            ->where('status',  1)
                            ->first();
                        if(!empty($delivery_man)){
                            $result =DB::table('users')
                                ->where('id', $delivery_man->id)
                                ->update([
                                    'working_status' => 2,
                                ]);
                            $result = DB::table('laundry_order')->insert([
                                'user_id' => Cookie::get('user_id'),
                                'cleaner_id' => $delivery_man->id,
                                'date' => date("Y-m-d"),
                                'cloth_id' => json_encode($cloth_id),
                                'quantity' => json_encode($quantity),
                                'price' => $price,

                            ]);
                        }
                        else{
                            $delivery_man = DB::table('users')
                                ->where('user_type',  $user_type)
                                ->where('add_part1',  $user_info->add_part1)
                                ->where('add_part2',  $user_info->add_part2)
                                ->where('add_part3',  $user_info->add_part3)
                                ->where('add_part4',  $user_info->add_part4)
                                ->where('add_part5',  $ward_minus_id)
                                ->where('working_status',  $working_status)
                                ->where('address_type',  $user_info->address_type)
                                ->where('status',  1)
                                ->first();
                            if(!empty($delivery_man)){
                                $result =DB::table('users')
                                    ->where('id', $delivery_man->id)
                                    ->update([
                                        'working_status' => 2,
                                    ]);
                                $result = DB::table('laundry_order')->insert([
                                    'user_id' => Cookie::get('user_id'),
                                    'cleaner_id' => $delivery_man->id,
                                    'date' => date("Y-m-d"),
                                    'cloth_id' => json_encode($cloth_id),
                                    'quantity' => json_encode($quantity),
                                    'price' => $price,
                                ]);
                            }
                        }
                    }
                    if(!empty($delivery_man)){
                        return redirect()->to('laundryServicePage')->with('successMessage', 'সফল্ভাবে অর্ডার সম্পন্ন্য হয়েছে। '.$delivery_man->name.' আপনার অর্ডার এর দায়িত্বে আছে। প্রয়োজনে '.$delivery_man->phone.' কল করুন।'  );
                    }
                    else{
                        return redirect()->to('laundryServicePage')->with('errorMessage', 'আপনার এলাকাই কোন কাপড় পরিস্কারক খুজে পাওয়া যায়নি।');
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
}
