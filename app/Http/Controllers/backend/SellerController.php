<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    public function sellerForm(){
        $rows = DB::table('seller_product')
            ->where('status', 'Active')
            ->where('amount','>', '0')
            ->where('seller_id', Cookie::get('user_id'))
            ->paginate(20);
        return view('backend.sellerForm',['products' => $rows]);
    }
    public function insertSellerProduct(Request $request){
        try{
            if($request) {
                if(Cookie::get('user_id')) {
                    if($request->id) {
                        if ($request->hasFile('photo')) {
                            $targetFolder = 'public/asset/images/';
                            $file = $request->file('photo');
                            $pname = time() . '.' . $file->getClientOriginalName();
                            $image['filePath'] = $pname;
                            $file->move($targetFolder, $pname);
                            $PhotoPath = $targetFolder . $pname;
                        }
                        $address = $request->address1.','.$request->address2.','.$request->address3;
                        $result =DB::table('seller_product')
                            ->where('id', $request->id)
                            ->update([
                                'name' => $request->name,
                                'amount' => $request->amount,
                                'price' => $request->price,
                                'address' => $address,
                                'photo' => $PhotoPath,
                                'description' => $request->description,
                                'status' => $request->status,
                            ]);
                        if ($result) {
                            return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                        } else {
                            return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                        }
                    }
                    else{
                        if ($request->hasFile('photo')) {
                            $targetFolder = 'public/asset/images/';
                            $file = $request->file('photo');
                            $pname = time() . '.' . $file->getClientOriginalName();
                            $image['filePath'] = $pname;
                            $file->move($targetFolder, $pname);
                            $PhotoPath = $targetFolder . $pname;
                        }
                        $address = $request->address1.','.$request->address2.','.$request->address3;
                        $result = DB::table('seller_product')->insert([
                            'seller_id' => Cookie::get('user_id'),
                            'name' => $request->name,
                            'amount' => $request->amount,
                            'price' => $request->price,
                            'address' => $address,
                            'photo' => $PhotoPath,
                            'description' => $request->description,
                            'status' => $request->status,
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
            else{
                return back()->with('errorMessage', 'ফর্ম পুরন করুন।');
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getSellerProductsById(Request $request){
        try{
            $rows = DB::table('seller_product')
                ->where('id', $request->id)
                ->where('seller_id', Cookie::get('user_id'))
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteSellerProduct(Request $request){
        try{
            if($request->id) {
                $result =DB::table('seller_product')
                    ->where('id', $request->id)
                    ->where('seller_id', Cookie::get('user_id'))
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
    public function mySaleProduct(){
        try{
            $products = DB::table('product_sales')
                ->join('seller_product as a','product_sales.product_id','=','a.id')
                ->where('product_sales.seller_id', Cookie::get('user_id'))
                ->paginate(20);
            //dd($products);
            return view('backend.mySaleProduct',['products' => $products]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
}
