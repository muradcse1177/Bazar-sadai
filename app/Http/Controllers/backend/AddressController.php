<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function selectDivision ( ){
        try{

            $rows = DB::table('divisions')->where('status', 1)
                ->orderBy('id', 'DESC')->Paginate(5);
            return view('backend.division', ['divisions' => $rows,'action'=>'show']);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
	}
	public function getDivisionList(Request $request){
        try{
            $rows = DB::table('divisions')->where('id', $request->id)->first();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
	}
	public function insertDivision(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('divisions')
                        ->where('id', $request->id)
                        ->update([
                            'name' =>  $request->name,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('divisions')->select('name')->where([
                        ['name', '=', $request->name]
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন বিভাগ লিখুন।');
                    } else {
                        $result = DB::table('divisions')->insert([
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
	public function deletetDivision(Request $request){
        try{

            if($request->id) {
                $result =DB::table('divisions')
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

    public function selectDistrict(){
        try{
            $rows = DB::table('districts')
                ->select('divisions.name as divName', 'districts.id', 'districts.name')
                ->join('divisions', 'districts.div_id', '=', 'divisions.id')
                ->where('districts.status', 1)
                ->Paginate(10);
            return view('backend.district', ['districts' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getAllDivision(Request $request){
        try{
            $rows = DB::table('divisions')->where('status', 1)->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertDistrict(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('districts')
                        ->where('id', $request->id)
                        ->update([
                            'div_id' => $request->divId,
                            'name' => $request->name
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('districts')->select('name')
                        ->where([['name', '=', $request->name]
                        ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন জেলা লিখুন।');
                    } else {
                        $result = DB::table('districts')->insert([
                            'div_id' => $request->divId,
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
    public function getDistrictList(Request $request){
        try{
            $rows = DB::table('districts')->where('id', $request->id)->first();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteDistrict(Request $request){
        try{

            if($request->id) {
                $result =DB::table('districts')
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
    public function selectUpzilla(){
        try{
            $rows = DB::table('upazillas')
                ->select('divisions.name as divName',
                    'districts.name as disName', 'upazillas.id', 'upazillas.name')
                ->join('districts', 'districts.id', '=', 'upazillas.dis_id')
                ->join('divisions', 'districts.div_id', '=', 'divisions.id')
                ->where('upazillas.status', 1)
                ->Paginate(10);
            return view('backend.upazilla', ['upazillas' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getAllCategory(Request $request){
        try{
            $rows = DB::table('districts')
                ->where('div_id', $request->id)
                ->where('status', 1)
                ->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertUpazilla(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('upazillas')
                        ->where('id', $request->id)
                        ->update([
                            'div_id' => $request->divId,
                            'dis_id' => $request->disId,
                            'name' => $request->name
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
//                    $rows = DB::table('upazillas')
//                        ->select('name')
//                        ->where([['name', '=', $request->name]
//                        ])->where('status', 1)->distinct()->get()->count();
//                    if ($rows > 0) {
//                        return back()->with('errorMessage', ' নতুন উপজেলা লিখুন।');
//                    } else {
                        $result = DB::table('upazillas')->insert([
                            'div_id' => $request->divId,
                            'dis_id' => $request->disId,
                            'name' => $request->name
                        ]);
                        if ($result) {
                            return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                        } else {
                            return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                        }
//                    }
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
    public function getUpazillaList(Request $request){
        try{
            $rows = DB::table('upazillas')->where('id', $request->id)->first();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteUpazilla(Request $request){
        try{

            if($request->id) {
                $result =DB::table('upazillas')
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
    public function selectUnion(){
        try{
            $rows = DB::table('unions')
                ->select('divisions.name as divName',
                    'districts.name as disName','upazillas.name as upzName', 'unions.id', 'unions.name')
                ->join('upazillas', 'upazillas.id', '=', 'unions.upz_id')
                ->join('districts', 'districts.id', '=', 'upazillas.dis_id')
                ->join('divisions', 'divisions.id', '=', 'districts.div_id')
                ->where('unions.status', 1)
                ->Paginate(10);
            return view('backend.union', ['unions' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getUpazillaListAll(Request $request){
        try{
            $rows = DB::table('upazillas')
                ->where('dis_id', $request->id)
                ->where('status', 1)
                ->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getDistrictListAll(Request $request){
        try{
            $rows = DB::table('districts')
                ->where('div_id', $request->id)
                ->where('status', 1)
                ->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertUnion(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('unions')
                        ->where('id', $request->id)
                        ->update([
                            'div_id' => $request->divId,
                            'dis_id' => $request->disId,
                            'upz_id' => $request->upzId,
                            'name' => $request->name
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
//                    $rows = DB::table('unions')
//                        ->select('name')
//                        ->where([['name', '=', $request->name]
//                        ])->where('status', 1)->distinct()->get()->count();
//                    if ($rows > 0) {
//                        return back()->with('errorMessage', ' নতুন ইউনিয়ন লিখুন।');
//                    } else {
                        $result = DB::table('unions')->insert([
                            'div_id' => $request->divId,
                            'dis_id' => $request->disId,
                            'upz_id' => $request->upzId,
                            'name' => $request->name
                        ]);
                        if ($result) {
                            return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                        } else {
                            return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                        }
//                    }
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
    public function getUnionList(Request $request){
        try{
            $rows = DB::table('unions')->where('id', $request->id)->first();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteUnion(Request $request){
        try{

            if($request->id) {
                $result =DB::table('unions')
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
    public function selectWard(){
        try{
            $rows = DB::table('wards')
                ->select('divisions.name as divName',
                    'districts.name as disName','upazillas.name as upzName','unions.name as uniName',
                    'wards.id', 'wards.name','wards.position')
                ->join('unions', 'unions.id', '=', 'wards.uni_id')
                ->join('upazillas', 'upazillas.id', '=', 'unions.upz_id')
                ->join('districts', 'districts.id', '=', 'upazillas.dis_id')
                ->join('divisions', 'divisions.id', '=', 'districts.div_id')
                ->where('wards.status', 1)
                ->Paginate(10);
            return view('backend.ward', ['wards' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getUnionListAll(Request $request){
        try{
            $rows = DB::table('unions')
                ->where('upz_id', $request->id)
                ->where('status', 1)
                ->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertWard(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('wards')
                        ->where('id', $request->id)
                        ->update([
                            'div_id' => $request->divId,
                            'dis_id' => $request->disId,
                            'upz_id' => $request->upzId,
                            'uni_id' => $request->uniId,
                            'name' => $request->name,
                            'position' => $request->position
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $result = DB::table('wards')->insert([
                        'div_id' => $request->divId,
                        'dis_id' => $request->disId,
                        'upz_id' => $request->upzId,
                        'uni_id' => $request->uniId,
                        'name' => $request->name,
                        'position' => $request->position,
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
    public function getWardList(Request $request){
        try{
            $rows = DB::table('wards')->where('id', $request->id)->first();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteWard(Request $request){
        try{

            if($request->id) {
                $result =DB::table('wards')
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
    public function selectCity(){
        try{
            $rows = DB::table('cities')
                    ->select('divisions.name as divName', 'cities.id', 'cities.name')
                ->join('divisions', 'cities.div_id', '=', 'divisions.id')
                ->where('cities.status', 1)
                ->Paginate(10);
            return view('backend.city', ['districts' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function insertCity(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('cities')
                        ->where('id', $request->id)
                        ->update([
                            'div_id' => $request->divId,
                            'name' => $request->name
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('cities')->select('name')
                        ->where([['name', '=', $request->name]
                        ]) ->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন  সিটি লিখুন।');
                    } else {
                        $result = DB::table('cities')->insert([
                            'div_id' => $request->divId,
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
    public function getCityList(Request $request){
        try{
            $rows = DB::table('cities')->where('id', $request->id)->first();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteCity(Request $request){
        try{

            if($request->id) {
                $result =DB::table('cities')
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
    public function selectCity_corporation(){
        try{
            $rows = DB::table('city_corporations')
                ->select('divisions.name as divName',
                    'cities.name as disName', 'city_corporations.id', 'city_corporations.name')
                ->join('cities', 'cities.id', '=', 'city_corporations.city_id')
                ->join('divisions', 'cities.div_id', '=', 'divisions.id')
                ->where('city_corporations.status', 1)
                ->Paginate(10);
            return view('backend.city_corporation', ['upazillas' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getCityListAll(Request $request){
        try{
            $rows = DB::table('cities')
                ->where('div_id', $request->id)
                ->where('status', 1)
                ->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertCitycorporation(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('city_corporations')
                        ->where('id', $request->id)
                        ->update([
                            'div_id' => $request->divId,
                            'city_id' => $request->disId,
                            'name' => $request->name
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('city_corporations')
                        ->select('name')
                        ->where([['name', '=', $request->name]
                        ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন সিটি-করপোরেশন  লিখুন।');
                    } else {
                        $result = DB::table('city_corporations')->insert([
                            'div_id' => $request->divId,
                            'city_id' => $request->disId,
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
    public function getCityCorporationList(Request $request){
        try{
            $rows = DB::table('city_corporations')->where('id', $request->id)->first();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteCityCorporation(Request $request){
        try{

            if($request->id) {
                $result =DB::table('city_corporations')
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
    public function selectThana(){
        try{
            $rows = DB::table('thanas')
                ->select('divisions.name as divName',
                    'cities.name as disName','city_corporations.name as upzName', 'thanas.id', 'thanas.name')
                ->join('city_corporations', 'city_corporations.id', '=', 'thanas.city_co_id')
                ->join('cities', 'cities.id', '=', 'city_corporations.city_id')
                ->join('divisions', 'divisions.id', '=', 'cities.div_id')
                ->where('thanas.status', 1)
                ->Paginate(10);
            return view('backend.thana', ['unions' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getCityCorporationListAll(Request $request){
        try{
            $rows = DB::table('city_corporations')
                ->where('city_id', $request->id)
                ->where('status', 1)
                ->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertThana(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('thanas')
                        ->where('id', $request->id)
                        ->update([
                            'div_id' => $request->divId,
                            'city_id' => $request->disId,
                            'city_co_id' => $request->upzId,
                            'name' => $request->name
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('thanas')
                        ->select('name')
                        ->where([['name', '=', $request->name]
                        ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন থানা লিখুন।');
                    } else {
                        $result = DB::table('thanas')->insert([
                            'div_id' => $request->divId,
                            'city_id' => $request->disId,
                            'city_co_id' => $request->upzId,
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
    public function getThanaList(Request $request){
        try{
            $rows = DB::table('thanas')->where('id', $request->id)->first();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteThana(Request $request){
        try{

            if($request->id) {
                $result =DB::table('thanas')
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
    public function selectC_ward(){
        try{
            $rows = DB::table('c_wards')
                ->select('divisions.name as divName',
                    'cities.name as disName','city_corporations.name as upzName','thanas.name as uniName',
                    'c_wards.id', 'c_wards.name','c_wards.position')
                ->join('thanas', 'thanas.id', '=', 'c_wards.thana_id')
                ->join('city_corporations', 'city_corporations.id', '=', 'thanas.city_co_id')
                ->join('cities', 'cities.id', '=', 'city_corporations.city_id')
                ->join('divisions', 'divisions.id', '=', 'cities.div_id')
                ->where('c_wards.status', 1)
                ->Paginate(10);
            return view('backend.c_ward', ['wards' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getThanaListAll(Request $request){
        try{
            $rows = DB::table('thanas')
                ->where('city_co_id', $request->id)
                ->where('status', 1)
                ->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertC_Ward(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('c_wards')
                        ->where('id', $request->id)
                        ->update([
                            'div_id' => $request->divId,
                            'city_id' => $request->disId,
                            'city_co_id' => $request->upzId,
                            'thana_id' => $request->uniId,
                            'name' => $request->name,
                            'position' => $request->position
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $result = DB::table('c_wards')->insert([
                        'div_id' => $request->divId,
                        'city_id' => $request->disId,
                        'city_co_id' => $request->upzId,
                        'thana_id' => $request->uniId,
                        'name' => $request->name,
                        'position' => $request->position
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
    public function getC_WardList(Request $request){
        try{
            $rows = DB::table('c_wards')->where('id', $request->id)->first();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteC_ward(Request $request){
        try{

            if($request->id) {
                $result =DB::table('c_ward')
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
