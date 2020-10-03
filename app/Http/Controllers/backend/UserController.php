<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function dashboard(){
        $users = DB::table('users')->where('status', 1)->distinct()->get()->count();
        $cashOut = DB::table('accounting')
            ->where('date', date('y-m-d'))
            ->where('type', 'Cash Out')
            ->sum('amount');
        $cashIn = DB::table('accounting')
            ->where('date', date('y-m-d'))
            ->where('type', 'Cash In')
            ->sum('amount');
        $p_order = DB::table('v_assign')
            ->where('sales_date', date('y-m-d'))
            ->distinct()->get()->count();
        $a_order = DB::table('animal_sales')
            ->where('date', date('y-m-d'))
            ->distinct()->get()->count();
        $t_order = DB::table('ticket_booking')
            ->where('date', date('y-m-d'))
            ->distinct()->get()->count();
        $d_order = DB::table('dr_apportionment')
            ->where('date', date('y-m-d'))
            ->distinct()->get()->count();
        $th_order = DB::table('therapy_appointment')
            ->where('date', date('y-m-d'))
            ->distinct()->get()->count();
        $di_order = DB::table('diagonostic_appointment')
            ->where('date', date('y-m-d'))
            ->distinct()->get()->count();
        $m_order = DB::table('medicine_order')
            ->where('date', date('y-m-d'))
            ->distinct()->get()->count();

        return view('backend.dashboard',
            [
                'users' => $users,
                'cashOut' => $cashOut,
                'cashIn' => $cashIn,
                'p_order' => $p_order,
                'a_order' => $a_order,
                't_order' => $t_order,
                'd_order' => $d_order,
                'th_order' => $th_order,
                'di_order' => $di_order,
                'm_order' => $m_order,
            ]
        );
    }
    public function insertUserType(Request $request){
        try{
            if($request) {
                $rows = DB::table('user_type')->select('name')->where([
                    ['name', '=', $request->name]
                ])->where('status', 1)->distinct()->get()->count();
                if ($rows > 0) {
                    return back()->with('errorMessage', ' নতুন ইউজার ধরন লিখুন।');
                } else {
                    $result = DB::table('user_type')->insert([
                        'name' => $request->name,
                        'type' => $request->type
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
    public function selectUser_type(){
        try{
            $rows = DB::table('user_type')->where('status', 1)
                ->orderBy('id', 'DESC')->Paginate(10);
            return view('backend.user_type', ['user_types' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function selectUser(){
        try{
            $rows = DB::table('users')
                ->select('*','user_type.name as designation','users.name as name','users.id as u_id')
                ->join('user_type','users.user_type','=','user_type.id')
                ->orderBy('users.id', 'DESC')
                ->Paginate(10);
            return view('backend.user', ['users' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function selectUserFromUserPanel(Request  $request){
        try{
            if($request->userType =="All"){
                $rows = DB::table('users')
                    ->select('*','user_type.name as designation','users.name as name','users.id as u_id')
                    ->join('user_type','users.user_type','=','user_type.id')
                    ->orderBy('users.id', 'DESC')
                    ->Paginate(10);
            }
            else{
                $rows = DB::table('users')
                    ->select('*','user_type.name as designation','users.name as name','users.id as u_id')
                    ->join('user_type','users.user_type','=','user_type.id')
                    ->where('user_type', $request->userType)
                    ->orderBy('users.id', 'DESC')
                    ->Paginate(10);
            }

            return view('backend.user', ['users' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }

    public function getUserListByID(Request $request){
        try{
            $rows = DB::table('users')
                ->where('id', $request->id)
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertUser(Request $request){
        try{
            //dd($request);
                if($request) {
                    if ($request->id){
                        $username = $request->name;
                        $email = $request->email;
                        $phone = $request->phone;
                        $password = Hash::make($request->password);
                        $gender = $request->gender;
                        $addressGroup = $request->addressGroup;
                        $add_part1 = $request->div_id;
                        $address = $request->address;
                        $user_type = $request->user_type;
                        $userPhotoPath = "";
                        $userPhotoIdPath = "";
                        $nid = "";
                        if ($request->hasFile('user_photo')) {
                            $targetFolder = 'public/asset/images/';
                            $file = $request->file('user_photo');
                            $pname = time() . '.' . $file->getClientOriginalName();
                            $image['filePath'] = $pname;
                            $file->move($targetFolder, $pname);
                            $userPhotoPath = $targetFolder . $pname;
                        }
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
                            if ($request->hasFile('photoId')) {
                                $targetFolder = 'public/asset/images/';
                                $file = $request->file('photoId');
                                $pIname = time() . '.' . $file->getClientOriginalName();
                                $image['filePath'] = $pIname;
                                $file->move($targetFolder, $pIname);
                                $userPhotoIdPath = $targetFolder . $pIname;
                            }

                        }
                        $result =DB::table('users')
                            ->where('id', $request->id)
                            ->update([
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
                                'status' => 1,
                                'photo' => $userPhotoPath,
                                'nid' => $nid,
                                'photoid' => $userPhotoIdPath,
                                'working_status' => 1,
                            ]);
                        if ($result) {
                            if($user_type == 13){
                                $result = DB::table('doctors')
                                    ->where('doctor_id', $request->id)
                                    ->update([
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
                            return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                        } else {
                            return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                        }
                    }
                    else{
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
                            $userPhotoPath = "";
                            $userPhotoIdPath = "";
                            $nid = "";
                            if ($request->hasFile('user_photo')) {
                                $targetFolder = 'public/asset/images/';
                                $file = $request->file('user_photo');
                                $pname = time() . '.' . $file->getClientOriginalName();
                                $image['filePath'] = $pname;
                                $file->move($targetFolder, $pname);
                                $userPhotoPath = $targetFolder . $pname;
                            }
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
                                if ($request->hasFile('photoId')) {
                                    $targetFolder = 'public/asset/images/';
                                    $file = $request->file('photoId');
                                    $pIname = time() . '.' . $file->getClientOriginalName();
                                    $image['filePath'] = $pIname;
                                    $file->move($targetFolder, $pIname);
                                    $userPhotoIdPath = $targetFolder . $pIname;
                                }

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
                                'photo' => $userPhotoPath,
                                'nid' => $nid,
                                'photoid' => $userPhotoIdPath,
                                'working_status' => 1,
                            ]);
                            if ($result) {
                                if($user_type == 7){
                                    $dealer_id = DB::getPdo()->lastInsertId();
                                    DB::insert("INSERT INTO product_assign (product_id, dealer_id, edit_price)
                                    SELECT id,$dealer_id,price
                                        FROM products");
                                }
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
    public function getWardListAll(Request $request){
        try{
            $rows = DB::table('wards')
                ->where('uni_id', $request->id)
                ->where('status', 1)
                ->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getC_wardListAll(Request $request){
        try{
            $rows = DB::table('c_wards')
                ->where('thana_id', $request->id)
                ->where('status', 1)
                ->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getAllUserType(Request $request){
        try{
            $rows = DB::table('user_type')
                ->where('status', 1)
                ->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteUser(Request $request){
        try{

            if($request->id) {
                $result =DB::table('users')
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
    public function about_us(Request $request){
        try{
            $rows = DB::table('about_us')
                ->get();
            return view('backend.about_us', ['abouts' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertAboutUs(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('about_us')
                        ->where('id', $request->id)
                        ->update([
                            'about' => $request->name
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else {
                    $rows = DB::table('about_us')->select('id')->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' আমাদের সম্পর্কে শুধু পরিবর্তনযোগ্য');
                    } else {
                        $result = DB::table('about_us')->insert([
                            'about' => $request->name,
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
    public function insertContactUs(Request $request){
        try{
            $result = DB::table('contact_us')->insert([
                'name' => $request->name,
                'phone' => $request->phone,
                'purpose' => $request->purpose,
            ]);
            if ($result) {
                return back()->with('successMessage', 'আপনার মুল্যবান মতামতের জন্য।');
            } else {
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getAboutUS(Request $request){
        try{
            $rows = DB::table('about_us')
                ->where('id', $request->id)
                ->first();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function contact_us(Request $request){
        try{
            $rows = DB::table('contact_us')
                ->paginate();
            return view('backend.contact_us', ['lists' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getContactUs(Request $request){
        try{
            $rows = DB::table('contact_us')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getHospitalListAll(Request $request){
        try{
            $rows = DB::table('hospitals')
                ->where('dept', $request->id)
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getAllMedDept(Request $request){
        try{
            $rows = DB::table('med_departments')
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getMealTypeAll(Request $request){
        try{
            $rows = DB::table('meal_time')
                ->where('m_time', $request->id)
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    function en2bn($number) {
        $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $bn_number = str_replace($search_array, $replace_array, $number);
        return $bn_number;
    }
    public function myProductOrder(Request $request){
        try{
            $stmt = DB::table('delivery_charges')
                ->where('purpose_id', 1)
                ->first();
            $delivery_charge = $stmt->charge;
            $id = Cookie::get('user_id');
            $stmt= DB::table('v_assign')
                ->select('*','v_assign.id AS salesid','v_assign.v_id AS v_id')
                ->join('users as a', 'a.id', '=', 'v_assign.user_id')
                ->where('user_id',$id)
                ->orderBy('v_assign.sales_date','Desc')
                ->get();
            $orderArr =array();
            $i=0;
            $sum=0;
            foreach($stmt as $row) {
                $dealer = DB::table('users')
                    ->where('add_part1', $row->add_part1)
                    ->where('add_part2', $row->add_part2)
                    ->where('add_part3', $row->add_part3)
                    ->where('address_type', $row->address_type)
                    ->where('user_type', 7)
                    ->first();
                if (isset($dealer->id))
                    $dealer_id = $dealer->id;
                else
                    $dealer_id = "";
                $stmt2 = DB::table('details')
                    ->join('products', 'products.id', '=', 'details.product_id')
                    ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                    ->where('product_assign.dealer_id', $dealer_id)
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
                    $phone = $volunteer->phone;
                    $v_id = "profile.php?id=" . $volunteer->id;
                } else {
                    $name = "Not Assigned";
                    $v_id = " ";
                    $phone ="Not Assigned";
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
                $orderArr[$i]['deliver_phone'] =$phone;
                $sum = $sum+$total+$delivery_charge;
                $i++;
            }
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $itemCollection = collect($orderArr);
            $perPage = 10;
            $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
            $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
            $paginatedItems->setPath($request->url());
            return view('frontend.myProductOrder', ['orders' => $paginatedItems,'sum' => $this->en2bn($sum).'/-']);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function myAnimalOrder(){
        try{

            $aminal_Sale = DB::table('sale_products')
                ->select('*','sale_products.id as salePID', 'sale_products.name as salName',
                    'sale_products.photo as salPPhoto','u1.name as buyerName','u1.phone as buyerPhone','u2.phone as sellerPhone')
                ->join('animal_sales', 'sale_products.id', '=', 'animal_sales.product_id')
                ->join('users as u1', 'u1.id', '=', 'animal_sales.buyer_id')
                ->join('users as u2', 'u2.id', '=', 'animal_sales.seller_id')
                ->where('u1.id', Cookie::get('user_id'))
                ->where('sale_products.sale_status', 0)
                ->paginate(10);

            return view('frontend.myAnimalOrder', ['aminal_Sales' => $aminal_Sale]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function myTicketOrder(){
        try{
            $ticket_Sale = DB::table('ticket_booking')
                ->join('users', 'ticket_booking.user_id', '=', 'users.id')
                ->where('user_id', Cookie::get('user_id'))
                ->orderBy('ticket_booking.id','desc')
                ->paginate(10);
            return view('frontend.myTicketOrder', ['ticket_Sales' => $ticket_Sale]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function myDrAppointment(){
        $rows = DB::table('dr_apportionment')
            ->select('*','dr_apportionment.id as a_id','a.phone as dr_phone','b.phone as p_phone','a.name as dr_name')
            ->join('users as a','a.id','=','dr_apportionment.dr_id')
            ->join('users as b','b.id','=','dr_apportionment.user_id')
            ->where('b.id', Cookie::get('user_id'))
            ->paginate('20');
        return view('frontend.myDrAppointment',['drReports' => $rows]);
    }
    public function myTherapyAppointment(){
        $rows = DB::table('therapy_appointment')
            ->select('*')
            ->join('users','users.id','=','therapy_appointment.user_id')
            ->join('therapyfees as a','a.id','=','therapy_appointment.therapy_fees_id')
            ->join('therapy_center','therapy_center.id','=','a.therapy_center_id')
            ->join('therapy_services','therapy_services.id','=','a.therapy_name_id')
            ->where('users.id', Cookie::get('user_id'))
            ->paginate('20');
        return view('frontend.myTherapyAppointment',['therapyReports' => $rows]);
    }
    public function myDiagnosticAppointment(){
        $rows = DB::table('diagonostic_appointment')
            ->select('*')
            ->join('users','users.id','=','diagonostic_appointment.user_id')
            ->join('diagnostic_fees as a','a.id','=','diagonostic_appointment.diagnostic_fees_id')
            ->join('diagnostic_center','diagnostic_center.id','=','a.diagnostic_center_id')
            ->join('diagnostic_test','diagnostic_test.id','=','a.diagnostic_test_id')
            ->where('users.id', Cookie::get('user_id'))
            ->paginate('20');
        //dd($rows);
        return view('frontend.myDiagnosticAppointment',['diagnosticReports' => $rows]);
    }
    public function deliveryProfile(Request $request){
        try{
            $stmt = DB::table('delivery_charges')
                ->where('purpose_id', 1)
                ->first();
            $delivery_charge = $stmt->charge;
            $id = Cookie::get('user_id');
            $stmt= DB::table('v_assign')
                ->select('*','v_assign.id AS salesid','v_assign.v_id AS v_id')
                ->join('users', 'users.id', '=', 'v_assign.v_id')
                ->where('v_assign.v_id',$id)
                ->orderBy('v_assign.sales_date','desc')
                ->get();
            //dd($stmt);
            $orderArr =array();
            $i=0;
            $sum=0;
            foreach($stmt as $row) {
                $dealer = DB::table('users')
                    ->where('add_part1', $row->add_part1)
                    ->where('add_part2', $row->add_part2)
                    ->where('add_part3', $row->add_part3)
                    ->where('address_type', $row->address_type)
                    ->where('user_type', 7)
                    ->first();
                if (isset($dealer->id))
                    $dealer_id = $dealer->id;
                else
                    $dealer_id = "";
                $stmt2 = DB::table('details')
                    ->join('products', 'products.id', '=', 'details.product_id')
                    ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                    ->where('product_assign.dealer_id', $dealer_id)
                    ->where('details.sales_id', $row->salesid)
                    ->orderBy('products.id', 'Desc')
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
                $customer = DB::table('users')
                    ->where('id', $row->user_id)
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
                if ($row->v_status == 3) $status = "On the Working";
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
                $orderArr[$i]['phone'] =$customer->phone;
                $sum = $sum+$total+$delivery_charge;
                $i++;
            }
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $itemCollection = collect($orderArr);
            $perPage = 10;
            $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
            $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
            $paginatedItems->setPath($request->url());

            $id = Cookie::get('user_id');
            $user_info = DB::table('users')
                ->select('user_type.name as desig', 'users.*')
                ->join('user_type', 'user_type.id', '=', 'users.user_type')
                ->where('users.id', $id)
                ->where('users.status', 1)
                ->first();
            $users['info'] = $user_info;
            return view('backend.deliveryProfile', ['orders' => $paginatedItems,'sum' => $this->en2bn($sum).'/-','users' => $users]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function myVariousProductOrder(){
        try{
            $products = DB::table('product_sales')
                ->select('*','product_sales.id as ps_id','a.address as ps_address')
                ->join('seller_product as a','product_sales.product_id','=','a.id')
                ->where('product_sales.buyer_id', Cookie::get('user_id'))
                ->paginate(20);
            return view('frontend.myVariousProductOrder',['orders' => $products]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
}
