<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeAssistantController extends Controller
{
    public function cookingPage(){
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
}
