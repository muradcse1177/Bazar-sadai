<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function verifyUsers(Request $request){
        try{
            if($request->login == "login"){
                $phone = $request->phone;
                $password = $request->password;
                $rows = DB::table('users')
                    ->where('phone', $phone)
                    ->get()->count();
                if ($rows > 0) {
                    $rows = DB::table('users')
                        ->where('phone', $phone)
                        ->first();
                    if (Hash::check($password, $rows->password)) {
                        $role = $rows->user_type;
                        Session::put('user_info', $rows);
                        Cookie::queue('user', $rows->id, time()+31556926 ,'/');
                        Cookie::queue('user_id', $rows->id, time()+31556926 ,'/');
                        Cookie::queue('user_name', $rows->name, time()+31556926 ,'/');
                        Cookie::queue('user_type', $rows->user_type, time()+31556926 ,'/');
                        Cookie::queue('user_photo', $rows->photo, time()+31556926 ,'/');
                        if($role==3){
                            Cookie::queue('front', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('cart_view');
                        }
                        elseif($role==15){
                            Cookie::queue('admin', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('myMedicineSale');
                        }
                        elseif($role==3 || $role==4 || $role==5 || $role==13){
                            return redirect()->to('profile');
                        }
                        elseif($role==1 || $role==2 || $role==8){
                            Cookie::queue('admin', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('dashboard');
                        }
                        elseif ($role==12){
                            Cookie::queue('admin', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('product');
                        }
                        elseif ($role==11){
                            Cookie::queue('admin', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('accounting');
                        }
                    }
                    else{
                        return back()->with('errorMessage', 'পাসওয়ার্ড ভুল দিয়েছেন।');
                    }
                } else {
                    return back()->with('errorMessage', 'আপনাকে পাওয়া যাচ্ছে না।');
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
    public function getAllUserTypeSignUp(Request $request){
        try{
            $rows = DB::table('user_type')
                ->where('type', 2)
                ->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertNewUser(Request $request){
        try{
            if($request) {
                //dd($request);
                $rows = DB::table('users')
                    ->where('phone', $request->phone)
                    ->orwhere('email', $request->email)
                    ->distinct()->get()->count();
                if ($rows > 0) {
                    return back()->with('errorMessage', ' নতুন ইউজার লিখুন।');
                } else {
                    $username = $request->name;
                    $email = $request->email;
                    $phone = $request->phone;
                    $password = Hash::make($request->password);
                    $gender = $request->gender;
                    $addressGroup = $request->addressGroup;
                    $add_part1 = $request->div_id;
                    $address = $request->address;
                    $user_type = $request->user_type;
                    $nid = "";
                    if ($addressGroup == 1) {
                        $add_part2 = $request->disid;
                        $add_part3 = $request->upzid;
                        $add_part4 = $request->uniid;
                        $add_part5 = $request->wardid;
                    }
                    if ($addressGroup == 2) {
                        $add_part2 = $request->c_disid;
                        $add_part3 = $request->c_upzid;
                        $add_part4 = $request->c_uniid;
                        $add_part5 = $request->c_wardid;
                    }
                    if ($user_type == 5 || $user_type == 6 || $user_type == 7) {
                        $nid = $request->nid;
                    }
                    $result = DB::table('users')->insert([
                        'name' => $username,
                        'email' => $email,
                        'password' => $password,
                        'phone' => $phone,
                        'gender' => $gender,
                        'address_type' => $addressGroup,
                        'add_part1' => $add_part1,
                        'add_part2' => $add_part2,
                        'add_part3' => $add_part3,
                        'add_part4' => $add_part4,
                        'add_part5' => $add_part5,
                        'address' => $address,
                        'user_type' => $user_type,
                        'status' => 1,
                        'nid' => $nid,
                        'working_status' => 1,
                    ]);
                    if ($result) {
                        if($user_type == 13){
                            $doctor_id = DB::getPdo()->lastInsertId();
                            $result = DB::table('doctors')->insert([
                                'doctor_id' => $doctor_id,
                                'dept_name_id' => $request->doc_department,
                                'hos_name_id' => $request->doc_hospital,
                                'designation' => $request->designation,
                                'current_institute' => $request->currentInstitute,
                                'education' => $request->education,
                                'specialized' => $request->specialized,
                                'experience' => $request->experience,
                                'fees' => $request->fees,
                                'address' => $request->pa_address,
                                'in_time' => $request->intime,
                                'in_timezone' => $request->intimezone,
                                'out_time' => $request->outtime,
                                'out_timezone' => $request->outtimezone,
                                'days' => json_encode($request->days),
                            ]);
                        }
                        if($user_type == 15) {
                            $pharmacy_id = DB::getPdo()->lastInsertId();
                            $result = DB::table('pharmacy')->insert([
                                'user_id' => $pharmacy_id,
                                'pharmacy_name' => $request->p_name,
                                'pharmacy_address' => $request->p_address,
                            ]);
                        }
                        if($user_type == 16){
                            $Cooker_id = DB::getPdo()->lastInsertId();
                            $result = DB::table('cookers')->insert([
                                'cooker_id' => $Cooker_id,
                                'mealtype' => $request->mealtype,
                                'meal' => $request->meal,
                                'mealtime' => $request->mealtime,
                            ]);
                        }
                        $rows = DB::table('users')
                            ->where('phone', $phone)
                            ->first();
                        $user = $rows->id;
                        $role = $rows->user_type;
                        Cookie::queue('user', $user, time()+31556926 ,'/');
                        Cookie::queue('role', $role, time()+31556926 ,'/');
                        return redirect()->to('login');
                        //return redirect()->to('login')->with('errorMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে। লগ ইন করুন। ');
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
    public function logout(){
        Cookie::queue(Cookie::forget('user','/'));
        Cookie::queue(Cookie::forget('user_id','/'));
        Cookie::queue(Cookie::forget('user_name','/'));
        Cookie::queue(Cookie::forget('user_type','/'));
        Cookie::queue(Cookie::forget('user_photo','/'));
        Cookie::queue(Cookie::forget('admin','/'));
        Cookie::queue(Cookie::forget('front','/'));
        session()->forget('user_info');
        session()->flush();
        return redirect()->to('homepage');
    }
    public function profile(){
        try{
            if(Cookie::get('user_id')) {
                $output = '';
                $buyer_sold_lst="";
                $id = Cookie::get('user_id');
                $user_info = DB::table('users')
                    ->select('user_type.name as desig', 'users.*')
                    ->join('user_type', 'user_type.id', '=', 'users.user_type')
                    ->where('users.id', $id)
                    ->where('users.status', 1)
                    ->first();
                $users['info'] = $user_info;
                if(Cookie::get('user_type') ==3) {
                    $buyer_sold_lst = DB::table('sale_products')
                        ->select('*','sale_products.id as salePID', 'sale_products.name as salName', 'sale_products.photo as salPPhoto')
                        ->join('animal_sales', 'sale_products.id', '=', 'animal_sales.product_id')
                        ->join('users', 'users.id', '=', 'animal_sales.seller_id')
                        ->where('animal_sales.buyer_id', $id)
                        ->where('sale_products.sale_status', 0)
                        ->get();
                }
                $users['animal_buy_info'] = $buyer_sold_lst;
                if(Cookie::get('user_type') ==4) {
                    $user_sale_info = DB::table('sale_products')
                        ->select('*','sale_products.id as salePID', 'sale_products.name as salName', 'sale_products.photo as salPPhoto')
                        ->join('users', 'users.id', '=', 'sale_products.seller_id')
                        ->where('sale_products.seller_id', $id)
                        ->where('sale_products.sale_status', 1)
                        ->get();
                    $user_sold_lst = DB::table('sale_products')
                        ->select('*','sale_products.id as salePID', 'sale_products.name as salName', 'sale_products.photo as salPPhoto')
                        ->join('animal_sales', 'sale_products.id', '=', 'animal_sales.product_id')
                        ->join('users', 'users.id', '=', 'animal_sales.buyer_id')
                        ->where('sale_products.seller_id', $id)
                        ->where('sale_products.sale_status', 0)
                        ->get();
                    //dd($user_sold_lst);

                    return view('frontend.profile', ['users' => $users,'user_sale_info' => $user_sale_info,
                        'user_sold_lst' => $user_sold_lst]);
                }
                return view('frontend.profile', ['users' => $users]);
            }
            else{
                return redirect()->to('/');
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function transaction(Request $request){
        try{
            $id= $request->id;
            $output = array('list'=>'');
            $stmt = DB::table('delivery_charges')
                ->where('purpose_id', 1)
                ->first();
            $delivery_charge = $stmt->charge;
            $customer = DB::table('users')
                ->where('id',Cookie::get('user_id'))
                ->first();
            $dealer = DB::table('users')
                ->where('add_part1',$customer->add_part1)
                ->where('add_part2',$customer->add_part2)
                ->where('add_part3',$customer->add_part3)
                ->where('address_type',$customer->address_type)
                ->where('user_type',7)
                ->first();
            $stmt2= DB::table('details')
                ->join('products', 'products.id', '=', 'details.product_id')
                ->join('v_assign', 'v_assign.id', '=', 'details.sales_id')
                ->join('product_assign','product_assign.product_id', '=','products.id')
                ->where('product_assign.dealer_id',$dealer->id)
                ->where('details.sales_id', $id)
                ->orderBy('products.id','Asc')
                ->get();

            $data = json_decode($stmt2, true);

            $total = 0;
            foreach($data as $row){

                $output['transaction'] = $row['pay_id'];
                $output['date'] = date('M d, Y', strtotime($row['sales_date']));
                if($row['quantity']>50) {
                    $quantity = $row['quantity']/1000;
                }
                else{
                    $quantity = $row['quantity'];
                }
                $subtotal = $row['edit_price']*$quantity;
                $total += $subtotal;
                $output['list'] .= "
                    <tr class='prepend_items'>
                        <td>".$row['name']."</td>
                        <td> ".$this->en2bn(number_format($row['edit_price'], 2))."</td>
                        <td>".$this->en2bn($row['quantity'])."</td>
                        <td> ".$this->en2bn(number_format($subtotal, 2))."</td>
                    </tr>
                ";
            }

            $output['delivery_charge'] = '<b> '.$this->en2bn(number_format($delivery_charge, 2)).'<b>';
            $output['total'] = '<b> '.$this->en2bn(number_format($delivery_charge+$total, 2)).'<b>';
            return response()->json(array('data'=>$output));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public static function en2bn($number) {
        $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $bn_number = str_replace($search_array, $replace_array, $number);
        return $bn_number;
    }
}
