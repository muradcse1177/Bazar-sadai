<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PharmacyController extends Controller
{
    public function medicineSelfManagement(){
        return view('backend.pharmacy.medicineSelfManagement');
    }
    public function medicineSelfName(){
        $rows = DB::table('medicine_self_name')
            ->where('user_id', Cookie::get('user_id'))
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->Paginate(10);
        return view('backend.pharmacy.medicineSelfName', ['selfNames' => $rows]);
    }
    public function medicineSelfById(Request $request){
        try{
            $rows = DB::table('medicine_self_name')
                ->where('user_id', Cookie::get('user_id'))
                ->where('id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getAllMedicineSelf(Request $request){
        try{
            $rows = DB::table('medicine_self_name')
                ->where('user_id', Cookie::get('user_id'))
                ->where('status', 1)
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertMedicineSelf(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('medicine_self_name')
                        ->where('id', $request->id)
                        ->update([
                            'name' => $request->name,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else {
                    $rows = DB::table('medicine_self_name')
                        ->select('name')
                        ->where([
                            ['name', '=', $request->name],
                            ['user_id', '=', 'user_id' =>Cookie::get('user_id')]
                        ])
                        ->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন ডাটা দিন');
                    } else {
                        $result = DB::table('medicine_self_name')->insert([
                            'name' => $request->name,
                            'user_id' =>Cookie::get('user_id')
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

    public function deleteMedicineSelf(Request $request){
        try{

            if($request->id) {
                $result =DB::table('medicine_self_name')
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
    public function searchMedicineBackend(Request $request){
        $trade_name = $request->trade_name;
        $generic_name = $request->generic_name;
        $company_name = $request->company_name ;
        if($company_name=="" && $trade_name=="" && $generic_name==""){
            return back()->with('errorMessage', 'কোন ডাটা পাওয়া যাইনি।');
        }
        else{
            if($trade_name) {
                $medicine = DB::table('products')
                    ->where('name', 'LIKE', '%' . $trade_name . '%')
                    ->where('status', 1)
                    ->where('cat_id', 3)
                    ->orderBy('id', 'ASC')->get();
                $dealer_status['status'] = 0;
                return view('backend.pharmacy.searchMedicineBackend', ['medicineLists' => $medicine]);
            }
            if($generic_name) {
                $medicine = DB::table('products')
                    ->where('genre', 'LIKE', '%' . $generic_name . '%')
                    ->where('status', 1)
                    ->where('cat_id', 3)
                    ->orderBy('id', 'ASC')->get();
                $dealer_status['status'] = 0;
                return view('backend.pharmacy.searchMedicineBackend', ['medicineLists' => $medicine]);
            }
            if($company_name) {
                $medicine = DB::table('products')
                    ->where('company', 'LIKE', '%' . $company_name . '%')
                    ->where('status', 1)
                    ->where('cat_id', 3)
                    ->orderBy('id', 'ASC')->get();
                $dealer_status['status'] = 0;
                return view('backend.pharmacy.searchMedicineBackend', ['medicineLists' => $medicine]);
            }
        }
    }
    public function insertMedicineIntoSelf(Request $request){
        try{
            $rows = DB::table('medicine_self')
                ->select('id')
                ->where([
                    ['user_id', '=',  Cookie::get('user_id')],
                    ['self_id', '=',  $request->self_id],
                    ['medicine_id', '=',  $request->id],
                ])
                ->distinct()->get()->count();
            if ($rows > 0) {
                $rows1 = DB::table('medicine_self')
                    ->select('*')
                    ->where([
                        ['user_id', '=',  Cookie::get('user_id')],
                        ['self_id', '=',  $request->self_id],
                        ['medicine_id', '=',  $request->id],
                    ])
                    ->first();
                //dd($rows1);
                $result =DB::table('medicine_self')
                    ->where('id', $rows1->id)
                    ->update([
                        'self_id' => $request->self_id,
                        'quantity' => $rows1->quantity+$request->quantity,
                    ]);
                if ($result) {
                    return response()->json(array('data' => 1, 'msg' => 'সফল্ভাবে সম্পন্ন্য হয়েছে।'));
                } else {
                    return response()->json(array('data' => 0, 'msg' => 'আবার চেষ্টা করুন।'));
                }
            }
            else {
                $result = DB::table('medicine_self')->insert([
                    'user_id' => Cookie::get('user_id'),
                    'self_id' => $request->self_id,
                    'medicine_id' => $request->id,
                    'quantity' => $request->quantity,
                    'date' => date("Y-m-d"),
                ]);
                if ($result) {
                    return response()->json(array('data' => 1, 'msg' => 'সফল্ভাবে সম্পন্ন্য হয়েছে।'));
                } else {
                    return response()->json(array('data' => 0, 'msg' => 'আবার চেষ্টা করুন।'));
                }
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function searchMedicineByLetterBackend($letter){
        $medicine = DB::table('products')
            ->where('name', 'LIKE', $letter . '%')
            ->where('status', 1)
            ->where('cat_id', 3)
            ->orderBy('id', 'ASC')->get();
        return view('backend.pharmacy.searchMedicineByLetterBackend', ['medicineLists' => $medicine]);
    }
    public function myMedicineSelf(){
        $medicine = DB::table('medicine_self')
            ->select('*','medicine_self_name.name as self_name')
            ->join('medicine_self_name','medicine_self_name.id','=','medicine_self.self_id')
            ->join('products','products.id','=','medicine_self.medicine_id')
            ->where('medicine_self.user_id',  Cookie::get('user_id'))
            ->where('medicine_self.status', 1)
            ->orderBy('medicine_self.id', 'ASC')->paginate(100);
        //dd($medicine);
        return view('backend.pharmacy.myMedicineSelf', ['medicineLists' => $medicine]);
    }
    public function selectSelfById(Request $request){
        $rows = DB::table('medicine_self')
            ->select('*','medicine_self_name.name as self_name')
            ->join('medicine_self_name','medicine_self_name.id','=','medicine_self.self_id')
            ->join('products','products.id','=','medicine_self.medicine_id')
            ->where('medicine_self.user_id',  Cookie::get('user_id'))
            ->where('medicine_self.status', 1)
            ->where('medicine_self.self_id', $request->id)
            ->orderBy('medicine_self.id', 'ASC')->get();
        //dd($medicine);
        return response()->json(array('data'=>$rows));
    }
    public function medicineOrderManagement(){
        return view('backend.pharmacy.medicineOrderManagement');
    }
    public function getAllMedicineCompany(){
        $rows = DB::table('products')
            ->where('cat_id', 3)
            ->distinct()
            ->get('company');
        return response()->json(array('data'=>$rows));
    }
    public function selectMedicineByCompany(Request $request){
        $rows = DB::table('products')
            ->where('cat_id', 3)
            ->where('company', $request->id)
            ->get();
        return response()->json(array('data'=>$rows));
    }
    public function insertMedicineOrder(Request $request){

        $quantity = array_filter($request->quantity, function($value) { return !is_null($value) && $value !== ''; });
        $medicine_id = array_filter($request->med_id, function($value) { return !is_null($value) && $value !== ''; });
        $price = array_filter($request->price, function($value) { return !is_null($value) && $value !== ''; });
        $output = array('list'=>'');
        $email = trim($request->email);
        $user =DB::table('users')
            ->where('id',  Cookie::get('user_id'))
            ->first();
        $pharmacy =DB::table('pharmacy')
            ->where('user_id',  Cookie::get('user_id'))
            ->first();
        $i =0;
        $j=0;
        foreach ($quantity as $q){
            $quantity_arr[$i] =$q;
            $i++;
        }
        foreach ($price as $p){
            $price_arr[$j] =$p;
            $j++;
        }

        $data = array(
            'companyName'=> $request->company,
            'medicines'=>$medicine_id,
            'quantity'=>$quantity_arr,
            'price'=>  $price_arr,
            'user_name'=> $user->name,
            'user_phone'=> $user->phone,
            'pharmacy'=> $pharmacy->pharmacy_name,
            'address'=> $pharmacy->pharmacy_address,
        );
        $customerName = $user->name;
        Mail::send('backend.pharmacy.medicineOrderEmailFormat', $data, function($message) use($email,$customerName) {
            $message->to($email, $customerName)->subject('Medicine Order Request');
            $message->from('hello@bazar-sadai.com','Bazar-sadai.com');
        });
        if (Mail::failures()) {
            return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
        }
        else {
            $result = DB::table('medicine_order')->insert([
                'user_id' => Cookie::get('user_id'),
                'med_id' => json_encode($medicine_id),
                'quantity' => json_encode($quantity),
                'price' =>  json_encode($price_arr),
                'date' => date("Y-m-d"),
                'company' => $request->company,
                'email' => $request->email,
            ]);
            if ($result) {
                return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
            } else {
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }
        }

    }
    public function myMedicineOrder(){
        $orders = DB::table('medicine_order')
            ->select('*')
            ->where('user_id',  Cookie::get('user_id'))
            ->orderBy('id', 'Desc')->paginate(100);
        return view('backend.pharmacy.myMedicineOrder', ['orders' => $orders]);
    }

    public function getMyMedicineOrderById(Request $request){
        $output = array('list'=>'');
        $orders = DB::table('medicine_order')
            ->where('id',  $request->id)
            ->first();
        $medicine_id = json_decode($orders->med_id);
        $quantity = json_decode($orders->quantity);
        $price = json_decode($orders->price);
        $i=0;
        $j=0;
        foreach ($quantity as $q){
            $quantity_arr[$i] =$q;
            $i++;
        }
        foreach ($price as $p){
            $price_arr[$j] =$p;
            $j++;
        }
        for($i=0; $i<count($medicine_id); $i++){
            $medicine = DB::table('products')
                ->select('*')
                ->where('id',  $medicine_id[$i])
                ->first();
            $output['list'] .= "
                    <tr class='prepend_items'>
                        <td>".$medicine->name."</td>
                        <td>".$medicine->type."</td>
                        <td>".$quantity_arr[$i]."</td>
                        <td>".$price_arr[$i]."</td>
                    </tr>
                ";
        }
        return response()->json(array('data'=>$output));
    }

    public function getOrderListByDate(Request $request){
        $orders = DB::table('medicine_order')
            ->select('*')
            ->where('user_id',  Cookie::get('user_id'))
            ->whereBetween('date',array($request->from_date,$request->to_date))
            ->orderBy('id', 'Desc')->paginate(100);
        //dd($orders);
        return view('backend.pharmacy.myMedicineOrder', ['orders' => $orders,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
    }
    public function myMedicineSale(Request $request){
        $rows = DB::table('medicine_sale')
            ->select('*','medicine_sale.price as sale_price')
            ->join('products','products.id','=','medicine_sale.med_id')
            ->where('user_id',  Cookie::get('user_id'))
            ->paginate(100);
        return view('backend.pharmacy.myMedicineSale',['orders' => $rows]);
    }
    public function insertMedicineSale(Request $request){
        $rows = DB::table('medicine_self')
            ->select('*')
            ->where('medicine_id', $request->med_name)
            ->where('user_id',  Cookie::get('user_id'))
            ->first();
        if($rows->quantity > $request->quantity){
            $result = DB::table('medicine_sale')->insert([
                'med_id' =>$request->med_name,
                'user_id' => Cookie::get('user_id'),
                'price' => $request->price,
                'date' => date("Y-m-d"),
                'quantity' => $request->quantity,
            ]);
            if ($result) {
                $result =DB::table('medicine_self')
                    ->where('medicine_id', $request->med_name)
                    ->where('user_id', Cookie::get('user_id'))
                    ->update([
                        'quantity' => $rows->quantity-$request->quantity,
                    ]);
                if($result){
                    return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                }
                else{
                    return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                }
            } else {
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }
        }
        else{
            return back()->with('errorMessage', 'আপনার ইনভেনটরিতে মেডিসিন কম আছে');
        }
    }
    public function getAllMedicineBySelf(Request $request){
        $rows = DB::table('medicine_self')
            ->select('*')
            ->join('products','products.id','=','medicine_self.medicine_id')
            ->where('medicine_self.user_id',  Cookie::get('user_id'))
            ->get();
        return response()->json(array('data'=>$rows));
    }
    public function myMedicineSalesReport(){
        $orders = DB::table('medicine_sale')
            ->select('*','medicine_sale.price as sale_price')
            ->join('products','products.id','=','medicine_sale.med_id')
            ->where('medicine_sale.user_id',  Cookie::get('user_id'))
            ->orderBy('medicine_sale.id', 'Desc')->paginate(100);
        return view('backend.pharmacy.myMedicineSalesReport', ['orders' => $orders]);
    }
    public function getSaleReportByDate(Request $request){
        $orders = DB::table('medicine_sale')
            ->select('*','medicine_sale.price as sale_price')
            ->join('products','products.id','=','medicine_sale.med_id')
            ->where('user_id',  Cookie::get('user_id'))
            ->whereBetween('date',array($request->from_date,$request->to_date))
            ->orderBy('medicine_sale.id', 'Desc')->paginate(100);
        //dd($orders);
        return view('backend.pharmacy.myMedicineSalesReport', ['orders' => $orders,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
    }
    public function medicineCompanyEmail(){
        $rows = DB::table('med_company_email')
            ->select('*')
            ->paginate(20);
        return view('backend.medicineCompanyEmail', ['medEmails' => $rows]);
    }
    public function insertMedicineCompanyEmail(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('med_company_email')
                        ->where('id', $request->id)
                        ->update([
                            'email' => $request->email,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else {
                    $rows = DB::table('med_company_email')
                        ->select('company_name')
                        ->where([
                            ['email', '=', $request->email]
                        ])
                        ->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন ডাটা দিন');
                    } else {
                        $result = DB::table('med_company_email')->insert([
                            'company_name' => $request->company,
                            'email' => $request->email,
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
    public function getMedicineCompanyEmailById(Request $request){
        $rows = DB::table('med_company_email')
            ->where('id', $request->id)
            ->first();
        return response()->json(array('data'=>$rows));
    }
    public function deleteMedicineCompanyEmail(Request $request){
        try{

            if($request->id) {
                $result = DB::table('med_company_email')->delete($request->id);
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
    public function medicineOrderReportAdmin(){
        $orders = DB::table('medicine_order')
            ->select('*')
            ->orderBy('id', 'Desc')->paginate(100);
        return view('backend.medicineSalesReportAdmin', ['orders' => $orders]);
    }
    public function getAdminMedicineOrderById(Request $request){
        $output = array('list'=>'');
        $orders = DB::table('medicine_order')
            ->where('id',  $request->id)
            ->first();
        $medicine_id = json_decode($orders->med_id);
        $quantity = json_decode($orders->quantity);
        $i =0;
        foreach ($quantity as $q){
            $quantity_arr[$i] =$q;
            $i++;
        }
        for($i=0; $i<count($medicine_id); $i++){
            $medicine = DB::table('products')
                ->select('*')
                ->where('id',  $medicine_id[$i])
                ->first();
            $output['list'] .= "
                    <tr class='prepend_items'>
                        <td>".$medicine->name."</td>
                        <td>".$medicine->type."</td>
                        <td>".$quantity_arr[$i]."</td>
                    </tr>
                ";
        }
        return response()->json(array('data'=>$output));
    }
    public function getOrderListByDateAdmin(Request $request){
        $orders = DB::table('medicine_order')
            ->select('*')
            ->whereBetween('date',array($request->from_date,$request->to_date))
            ->orderBy('id', 'Desc')->paginate(100);
        //dd($orders);
        return view('backend.medicineSalesReportAdmin', ['orders' => $orders,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
    }
}
