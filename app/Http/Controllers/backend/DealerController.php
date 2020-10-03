<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class DealerController extends Controller
{
    public function dealerProfile(){
        try{
            $rows = DB::table('products')
                ->join('product_assign','product_assign.product_id','=','products.id')
                ->where('product_assign.dealer_id', Cookie::get('user_id'))
                ->where('products.status', 1)
                ->orderBy('products.id', 'ASC')
                ->Paginate(100);
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
    public function getProductListDealer(Request $request){
        try{
            $user_id = Cookie::get('user_id');
            $rows = DB::table('product_assign')
                ->where('product_id',  $request->id)
                ->where('dealer_id',  $user_id)
                ->first();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function productSearchFromDealer(Request $request){
        try{
            if($request->proSearch == null){
                $rows = DB::table('products')
                    ->join('product_assign','product_assign.product_id','=','products.id')
                    ->where('product_assign.dealer_id', Cookie::get('user_id'))
                    ->where('products.status', 1)
                    ->orderBy('products.id', 'ASC')
                    ->Paginate(100);
                return view('backend.dealerProductManagement', ['products' => $rows]);
            }
            else {
                $rows = DB::table('products')
                ->join('product_assign','product_assign.product_id','=','products.id')
                ->where('product_assign.dealer_id', Cookie::get('user_id'))
                ->where('name', 'LIKE','%'.$request->proSearch.'%')
                ->where('products.status', 1)
                ->orderBy('products.id', 'ASC')
                ->Paginate(100);
                return view('backend.dealerProductManagement', ['products' => $rows , "key"=>$request->proSearch]);
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
}
