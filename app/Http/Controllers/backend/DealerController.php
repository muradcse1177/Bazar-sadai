<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
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
    function en2bn($number) {
        $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $bn_number = str_replace($search_array, $replace_array, $number);
        return $bn_number;
    }

    public function mySaleProductDealer (Request $request){
        try{
            $stmt = DB::table('delivery_charges')
                ->where('purpose_id', 1)
                ->first();
            $delivery_charge = $stmt->charge;
            $id = Cookie::get('user_id');
            $stmt= DB::table('v_assign')
                ->select('*','v_assign.id AS salesid','v_assign.v_id AS v_id')
                ->leftJoin('users', 'users.id', '=', 'v_assign.user_id')
                ->orderBy('v_assign.sales_date','Desc')
                ->where('v_assign.dealer_id', $id)
                ->get();
            $orderArr =array();
            $i=0;
            $sum=0;
            foreach($stmt as $row) {
                $stmt2 = DB::table('details')
                    ->join('products', 'products.id', '=', 'details.product_id')
                    ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                    ->where('product_assign.dealer_id', $row->dealer_id)
                    ->where('details.sales_id', $row->salesid)
                    ->orderBy('products.id', 'Asc')
                    ->get();
                $total = 0;
                foreach ($stmt2 as $details) {
                    if ($details->quantity > 101) {
                        $quantity = $details->quantity / 1000;
                    } else {
                        $quantity = $details->quantity;
                    }
                    $subtotal = $details->edit_price * $quantity;
                    $total += $subtotal;
                }
                $row1 = DB::table('users')
                    ->where('id', $row->v_id)
                    ->get();
                $volunteer = DB::table('users')
                    ->where('id', $row->v_id)
                    ->first();
                if ($row1->count() > 0) {
                    $name = $volunteer->name;
                    $v_id = "profile.php?id=" . $volunteer->id;
                } else {
                    $name = "Not Assigned";
                    $v_id = " ";
                }
                if ($row->v_status == 0) $status = "Processing";
                if ($row->v_status == 2) $status = "Assigned";
                if ($row->v_status == 3) $status = "On the service";
                if ($row->v_status == 4) $status = "Delivered";
                $orderArr[$i]['sales_date'] = $row->sales_date;
                $orderArr[$i]['name'] = $row->name;
                $orderArr[$i]['address'] = $row->address;
                $orderArr[$i]['pay_id'] = $row->pay_id;
                $orderArr[$i]['amount'] =   $this->en2bn(number_format($total+$delivery_charge , 2)).'/-';
                $orderArr[$i]['v_id'] =$v_id;
                $orderArr[$i]['v_name'] =$name;
                $orderArr[$i]['user_id'] =$row->user_id;
                $orderArr[$i]['status'] =$status;
                $orderArr[$i]['sales_id'] =$row->salesid;
                $sum = $sum+$total+$delivery_charge;
                $i++;
            }
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $itemCollection = collect($orderArr);
            $perPage = 20;
            $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
            $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
            $paginatedItems->setPath($request->url());
            return view('backend.mySaleProductDealer', ['orders' => $paginatedItems,'sum' => $this->en2bn($sum).'/-']);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }

    public function getDealerProductSalesOrderListByDate (Request $request){
        try{
            $stmt = DB::table('delivery_charges')
                ->where('purpose_id', 1)
                ->first();
            $delivery_charge = $stmt->charge;
            $id = Cookie::get('user_id');
            $stmt= DB::table('v_assign')
                ->select('*','v_assign.id AS salesid','v_assign.v_id AS v_id')
                ->leftJoin('users', 'users.id', '=', 'v_assign.user_id')
                ->orderBy('v_assign.sales_date','Desc')
                ->where('v_assign.dealer_id', $id)
                ->whereBetween('v_assign.sales_date',array($request->from_date,$request->to_date))
                ->get();
            $orderArr =array();
            $i=0;
            $sum=0;
            foreach($stmt as $row) {
                $stmt2 = DB::table('details')
                    ->join('products', 'products.id', '=', 'details.product_id')
                    ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                    ->where('product_assign.dealer_id', $row->dealer_id)
                    ->where('details.sales_id', $row->salesid)
                    ->orderBy('products.id', 'Asc')
                    ->get();
                $total = 0;
                foreach ($stmt2 as $details) {
                    if ($details->quantity > 101) {
                        $quantity = $details->quantity / 1000;
                    } else {
                        $quantity = $details->quantity;
                    }
                    $subtotal = $details->edit_price * $quantity;
                    $total += $subtotal;
                }
                $row1 = DB::table('users')
                    ->where('id', $row->v_id)
                    ->get();
                $volunteer = DB::table('users')
                    ->where('id', $row->v_id)
                    ->first();
                if ($row1->count() > 0) {
                    $name = $volunteer->name;
                    $v_id = "profile.php?id=" . $volunteer->id;
                } else {
                    $name = "Not Assigned";
                    $v_id = " ";
                }
                if ($row->v_status == 0) $status = "Processing";
                if ($row->v_status == 2) $status = "Assigned";
                if ($row->v_status == 3) $status = "On the service";
                if ($row->v_status == 4) $status = "Delivered";
                $orderArr[$i]['sales_date'] = $row->sales_date;
                $orderArr[$i]['name'] = $row->name;
                $orderArr[$i]['address'] = $row->address;
                $orderArr[$i]['pay_id'] = $row->pay_id;
                $orderArr[$i]['amount'] =   $this->en2bn(number_format($total+$delivery_charge , 2)).'/-';
                $orderArr[$i]['v_id'] =$v_id;
                $orderArr[$i]['v_name'] =$name;
                $orderArr[$i]['user_id'] =$row->user_id;
                $orderArr[$i]['status'] =$status;
                $orderArr[$i]['sales_id'] =$row->salesid;
                $sum = $sum+$total+$delivery_charge;
                $i++;
            }
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $itemCollection = collect($orderArr);
            $perPage = 20;
            $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
            $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
            $paginatedItems->setPath($request->url());
            return view('backend.mySaleProductDealer', ['orders' => $paginatedItems,'sum' => $this->en2bn($sum).'/-','from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
}
