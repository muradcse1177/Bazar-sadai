<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function selectCategory(Request $request){
        try{

            $rows = DB::table('categories')->where('status', 1)
                ->orderBy('id', 'DESC')->Paginate(10);
            return view('backend.category', ['categories' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function insertCategory(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('categories')
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
                    $rows = DB::table('categories')->select('name')->where([
                        ['name', '=', $request->name]
                        ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন বিভাগ লিখুন।');
                    } else {
                        $result = DB::table('categories')->insert([
                            'name' => $request->name,
                            'type' => $request->cat_type
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

    public function getCategoryList(Request $request){
        try{
            $rows = DB::table('categories')->where('id', $request->id)->first();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteCategory(Request $request){
        try{

            if($request->id) {
                $result =DB::table('categories')
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
    public function selectSubCategory(Request $request){
        try{
            $rows = DB::table('subcategories')
                ->select('categories.name as catName', 'subcategories.id', 'subcategories.name','subcategories.type')
                ->join('categories', 'categories.id', '=', 'subcategories.cat_id')
                ->where('subcategories.status', 1)
                ->orderBy('subcategories.id', 'DESC')->Paginate(10);

            return view('backend.subcategory', ['subcategories' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getCategoryListAll(Request $request){
        try{
            $rows = DB::table('categories')
                ->where('type', $request->id)
                ->where('status', 1)
                ->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertSubcategory(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('subcategories')
                        ->where('id', $request->id)
                        ->update([
                            'name' =>  $request->name,
                            'cat_id' => $request->catId,
                            'type' => $request->cat_type
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('subcategories')->select('name')->where([
                        ['name', '=', $request->name]
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন বিভাগ লিখুন।');
                    } else {
                        $result = DB::table('subcategories')->insert([
                            'name' => $request->name,
                            'cat_id' => $request->catId,
                            'type' => $request->cat_type
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
    public function getSubCategoryList(Request $request){
        try{
            $rows = DB::table('subcategories')->where('id', $request->id)->first();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteSubCategory(Request $request){
        try{

            if($request->id) {
                $result =DB::table('subcategories')
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


    public function selectProduct(Request $request){
        try{

            $rows = DB::table('products')->where('status', 1)
                ->orderBy('id', 'DESC')->Paginate(20);
            return view('backend.product', ['products' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function productSearchFromAdmin(Request $request){
        try{
            if($request->proSearch == null){
                $rows = DB::table('products')
                    ->where('status', 1)
                    ->orderBy('id', 'DESC')
                    ->Paginate(20);
            }
            else{
                $rows = DB::table('products')
                    ->where('status', 1)
                    ->where('name', 'LIKE','%'.$request->proSearch.'%')
                    ->orderBy('id', 'DESC')
                    ->Paginate(20);
            }

            return view('backend.product', ['products' => $rows, "key"=>$request->proSearch]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }

    public function getAllCategory(Request $request){
        try{
            $rows = DB::table('categories')
                ->where('status', 1)
                ->where('type', 1)
                ->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getSubCategoryListAll(Request $request){
        try{
            $rows = DB::table('subcategories')
                ->where('cat_id', $request->id)
                ->where('status', 1)
                ->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getProductList(Request $request){
        try{
            $rows = DB::table('products')
                ->where('id', $request->id)
                ->first();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function delivery_charge(Request $request){
        try{
            $rows = DB::table('delivery_charges')
                ->where('purpose_id', 1)
                ->get();
            return view('backend.delivery_charge', ['delivery_charges' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getDeliveryCharge(Request $request){
        try{
            $rows = DB::table('delivery_charges')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertDeliveryCharge(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('delivery_charges')
                        ->where('id', $request->id)
                        ->update([
                            'charge' =>  $request->name,
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
    public function insertProducts(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $photo='';
                    if ($request->hasFile('product_photo')) {
                        $targetFolder = 'public/asset/images/';
                        $file = $request->file('product_photo');
                        $pname = time() . '.' . $file->getClientOriginalName();
                        $image['filePath'] = $pname;
                        $file->move($targetFolder, $pname);
                        $photo = $targetFolder . $pname;
                    }
                    $result =DB::table('products')
                        ->where('id', $request->id)
                        ->update([
                            'name' =>  $request->name,
                            'cat_id' => $request->catId,
                            'sub_cat_id' => $request->subcatId,
                            'description' => $request->description,
                            'price' => $request->price,
                            'unit' => $request->unit,
                            'minqty' => $request->minqty,
                            'photo' => $photo,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('products')->select('name')->where([
                        ['name', '=', $request->name]
                        ])->where('status', 1)
                        ->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন পন্য লিখুন।');
                    }
                    else {
                        if ($request->hasFile('product_photo')) {

                            $targetFolder = 'public/asset/images/';
                            $file = $request->file('product_photo');
                            $pname = time() . '.' . $file->getClientOriginalName();
                            $image['filePath'] = $pname;
                            $file->move($targetFolder, $pname);
                            $photo = $targetFolder . $pname;
                        }
                        else{
                            $photo ="";
                        }
                        $result = DB::table('products')->insert([
                            'name' =>  $request->name,
                            'cat_id' => $request->catId,
                            'sub_cat_id' => $request->subcatId,
                            'description' => $request->description,
                            'price' => $request->price,
                            'unit' => $request->unit,
                            'minqty' => $request->minqty,
                            'photo' => $photo,
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
    public function deleteProduct(Request $request){
        try{

            if($request->id) {
                $result =DB::table('products')
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
    public function dealerProductManagement(){
        try{
            $rows = DB::table('products')->where('status', 1)
                ->orderBy('id', 'ASC')->Paginate(100);
            return view('backend.dealerProductManagement', ['products' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function changeProductPrice(Request $request){
        try{
            if(Cookie::get('user_id') !=null) {
                $user_id = Cookie::get('user_id');
                $rows = DB::table('product_assign')
                    ->where('product_id',  $request->id)
                    ->where('dealer_id',  $user_id)
                    ->distinct()->get()->count();
                if ($rows > 0) {
                    $result =DB::table('product_assign')
                        ->where('product_id',  $request->id)
                        ->where('dealer_id',  $user_id)
                        ->update([
                            'edit_price' => $request->price
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else {
                    $result = DB::table('product_assign')->insert([
                        'product_id' => $request->id,
                        'dealer_id' => $user_id,
                        'edit_price' => $request->price
                    ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
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
    public function compareDealerProduct(){
        try{
            $rows = DB::table('products')
                ->join('product_assign','product_assign.product_id','=','products.id')
                ->where('products.status', 1)
                ->where('product_assign.dealer_id', Cookie::get('user_id'))
                ->orderBy('products.id', 'DESC')->Paginate(100);
            return view('backend.compareDealerProduct', ['products' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function allMedicineList(Request $request){
        try{

            $rows = DB::table('medicine_lists')->where('status', 1)
                ->orderBy('name')->Paginate(20);
            return view('backend.allMedicineList', ['allMedicineLists' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function medicineSearchFromAdmin(Request $request){
        try{
            if($request->proSearch == null){
                $rows = DB::table('medicine_lists')
                    ->where('status', 1)
                    ->orderBy('name')
                    ->Paginate(20);
                return view('backend.allMedicineList', ['allMedicineLists' => $rows]);
            }
            else{
                $rows = DB::table('medicine_lists')
                    ->where('status', 1)
                    ->where('name', 'LIKE','%'.$request->proSearch.'%')
                    ->orwhere('genre', 'LIKE','%'.$request->proSearch.'%')
                    ->orwhere('company', 'LIKE','%'.$request->proSearch.'%')
                    ->orderBy('name')
                    ->Paginate(20);
                return view('backend.allMedicineList', ['allMedicineLists' => $rows,"key"=>$request->proSearch]);
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
}
