<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    function en2bn($number) {
        $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $bn_number = str_replace($search_array, $replace_array, $number);
        return $bn_number;
    }
    public function salesReport (Request $request){
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
            return view('backend.sales', ['orders' => $paginatedItems,'sum' => $this->en2bn($sum).'/-']);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getProductSalesOrderListByDate (Request $request){
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
                ->whereBetween('sales_date',array($request->from_date,$request->to_date))
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
            return view('backend.sales', ['orders' => $paginatedItems,'sum' => $this->en2bn($sum).'/-','from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function animalSalesReport ( ){
        try{

            $aminal_Sale = DB::table('sale_products')
                ->select('*','sale_products.id as salePID', 'sale_products.name as salName',
                    'sale_products.photo as salPPhoto','u1.name as buyerName','u1.phone as buyerPhone','u2.phone as sellerPhone')
                ->join('animal_sales', 'sale_products.id', '=', 'animal_sales.product_id')
                ->join('users as u1', 'u1.id', '=', 'animal_sales.buyer_id')
                ->join('users as u2', 'u2.id', '=', 'animal_sales.seller_id')
                ->where('sale_products.sale_status', 0)
                ->paginate(20);

            return view('backend.animalSalesReport', ['aminal_Sales' => $aminal_Sale]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getAnimalSalesOrderListByDate (Request $request){
        try{

            $aminal_Sale = DB::table('sale_products')
                ->select('*','sale_products.id as salePID', 'sale_products.name as salName',
                    'sale_products.photo as salPPhoto','u1.name as buyerName','u1.phone as buyerPhone','u2.phone as sellerPhone')
                ->join('animal_sales', 'sale_products.id', '=', 'animal_sales.product_id')
                ->join('users as u1', 'u1.id', '=', 'animal_sales.buyer_id')
                ->join('users as u2', 'u2.id', '=', 'animal_sales.seller_id')
                ->where('sale_products.sale_status', 0)
                ->whereBetween('date',array($request->from_date,$request->to_date))
                ->paginate(20);

            return view('backend.animalSalesReport', ['aminal_Sales' => $aminal_Sale,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function ticketSalesReport (){
        try{
            $ticket_Sale = DB::table('ticket_booking')
                ->join('users', 'ticket_booking.user_id', '=', 'users.id')
                ->orderBy('ticket_booking.id','desc')
                ->paginate(20);
            return view('backend.ticketSalesReport', ['ticket_Sales' => $ticket_Sale]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getTicketSalesOrderListByDate (Request $request){
        try{
            $ticket_Sale = DB::table('ticket_booking')
                ->join('users', 'ticket_booking.user_id', '=', 'users.id')
                ->whereBetween('date',array($request->from_date,$request->to_date))
                ->orderBy('ticket_booking.id','desc')
                ->paginate(20);
            return view('backend.ticketSalesReport', ['ticket_Sales' => $ticket_Sale,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function accounting (){
        try{
            $row = DB::table('accounting')
                ->orderBy('date','desc')
                ->paginate(20);
            return view('backend.accounting', ['accountings' => $row]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function insertAccounting(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('accounting')
                        ->where('id', $request->id)
                        ->update([
                            'type' => $request->type,
                            'purpose' => $request->purpose,
                            'amount' => $request->amount,
                            'date' => $request->date,
                            'person' => $request->person,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else {
                    $rows = DB::table('accounting')
                        ->select('id')
                        ->where([
                            ['type', '=', $request->type],
                            ['purpose', '=', $request->purpose],
                            ['amount', '=', $request->amount],
                            ['date', '=', $request->date],
                            ['person', '=', $request->person],
                        ])
                        ->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন ডাটা দিন');
                    } else {
                        $result = DB::table('accounting')->insert([
                            'type' => $request->type,
                            'purpose' => $request->purpose,
                            'amount' => $request->amount,
                            'date' => $request->date,
                            'person' => $request->person,
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
    public function getAccountingReportByDate (Request $request){
        $row = DB::table('accounting')
            ->whereBetween('date',array($request->from_date,$request->to_date))
            ->orderBy('date', 'Desc')->paginate(20);
        return view('backend.accounting', ['accountings' => $row,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
    }
    public function getAccountingListById(Request $request){
        try{
            $rows = DB::table('accounting')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function doctorAppointmentReport(){
        $rows = DB::table('dr_apportionment')
            ->select('*','dr_apportionment.id as a_id','a.phone as dr_phone','b.phone as p_phone','a.name as dr_name')
            ->join('users as a','a.id','=','dr_apportionment.dr_id')
            ->join('users as b','b.id','=','dr_apportionment.user_id')
            ->paginate('20');
        return view('backend.doctorAppointmentReport',['drReports' => $rows]);
    }
    public function getDrAppOrderListByDate(Request $request){
        $rows = DB::table('dr_apportionment')
            ->select('*','dr_apportionment.id as a_id','a.phone as dr_phone','b.phone as p_phone','a.name as dr_name')
            ->join('users as a','a.id','=','dr_apportionment.dr_id')
            ->join('users as b','b.id','=','dr_apportionment.user_id')
            ->whereBetween('date',array($request->from_date,$request->to_date))
            ->paginate('20');
        //dd($rows);
        return view('backend.doctorAppointmentReport',['drReports' => $rows,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
    }
    public function therapyAppointmentReport(){
        $rows = DB::table('therapy_appointment')
            ->select('*')
            ->join('users','users.id','=','therapy_appointment.user_id')
            ->join('therapyfees as a','a.id','=','therapy_appointment.therapy_fees_id')
            ->join('therapy_center','therapy_center.id','=','a.therapy_center_id')
            ->join('therapy_services','therapy_services.id','=','a.therapy_name_id')
            ->paginate('20');
        //dd($rows);
        return view('backend.therapyAppointmentReport',['therapyReports' => $rows]);
    }
    public function getTherapyAppOrderListByDate(Request $request){
        $rows = DB::table('therapy_appointment')
            ->select('*')
            ->join('users','users.id','=','therapy_appointment.user_id')
            ->join('therapyfees as a','a.id','=','therapy_appointment.therapy_fees_id')
            ->join('therapy_center','therapy_center.id','=','a.therapy_center_id')
            ->join('therapy_services','therapy_services.id','=','a.therapy_name_id')
            ->whereBetween('date',array($request->from_date,$request->to_date))
            ->paginate('20');
        //dd($rows);
        return view('backend.therapyAppointmentReport',['therapyReports' => $rows,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
    }
    public function diagnosticAppointmentReport(){
        $rows = DB::table('diagonostic_appointment')
            ->select('*')
            ->join('users','users.id','=','diagonostic_appointment.user_id')
            ->join('diagnostic_fees as a','a.id','=','diagonostic_appointment.diagnostic_fees_id')
            ->join('diagnostic_center','diagnostic_center.id','=','a.diagnostic_center_id')
            ->join('diagnostic_test','diagnostic_test.id','=','a.diagnostic_test_id')
            ->paginate('20');
        //dd($rows);
        return view('backend.diagnosticAppointmentReport',['diagnosticReports' => $rows]);
    }
    public function getDiagAppOrderListByDate(Request $request){
        $rows = DB::table('diagonostic_appointment')
            ->select('*')
            ->join('users','users.id','=','diagonostic_appointment.user_id')
            ->join('diagnostic_fees as a','a.id','=','diagonostic_appointment.diagnostic_fees_id')
            ->join('diagnostic_center','diagnostic_center.id','=','a.diagnostic_center_id')
            ->join('diagnostic_test','diagnostic_test.id','=','a.diagnostic_test_id')
            ->whereBetween('date',array($request->from_date,$request->to_date))
            ->paginate('20');
        //dd($rows);
        return view('backend.diagnosticAppointmentReport',['diagnosticReports' => $rows,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
    }

    public function donationReportBackend(){
        $rows = DB::table('donation_details')
            ->select('*','products.name as p_name')
            ->join('products','products.id','=','donation_details.product_id')
            ->join('v_assign','donation_details.sales_id','=','v_assign.id')
            ->join('users','users.id','=','v_assign.user_id')
            ->paginate(20);
        //dd($rows);
        return view('backend.donationReportBackend',['products' => $rows]);
    }
    public function donationListByDate(Request $request){
        $rows = DB::table('donation_details')
            ->select('*','products.name as p_name')
            ->join('products','products.id','=','donation_details.product_id')
            ->join('v_assign','donation_details.sales_id','=','v_assign.id')
            ->join('users','users.id','=','v_assign.user_id')
            ->whereBetween('v_assign.sales_date',array($request->from_date,$request->to_date))
            ->paginate(20);
        //dd($rows);
        return view('backend.donationReportBackend',['products' => $rows],['diagnosticReports' => $rows,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
    }
    public function transportReportAdmin(Request $request){
        $rows = DB::table('ride_booking')
            ->get();
        $booking =array();
        $i = 0;
        foreach ($rows as $riding){
            $user_id = $riding->user_id;
            $address_type = $riding->address_type;
            $address_typep = $riding->address_type;
            $service_area = DB::table('service_area')
                ->where('user_id',$user_id)
                ->first();
            $user = DB::table('users')
                ->where('id', $user_id)
                ->first();
            if($address_type==1){
                $add_part1 = DB::table('divisions')
                    ->where('id',$service_area->add_part1)
                    ->first();
                $add_part2 = DB::table('districts')
                    ->where('div_id',$service_area->add_part1)
                    ->where('id',$service_area->add_part2)
                    ->first();
                $add_part3 = DB::table('upazillas')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('id',$riding->add_part3)
                    ->first();
                $add_part4 = DB::table('unions')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('upz_id',$riding->add_part3)
                    ->where('id',$riding->add_part4)
                    ->first();
            }
            if($address_type==2){
                $add_part1 = DB::table('divisions')
                    ->where('id',$service_area->add_part1)
                    ->first();
                $add_part2 = DB::table('cities')
                    ->where('div_id',$service_area->add_part1)
                    ->where('id',$service_area->add_part2)
                    ->first();
                $add_part3 = DB::table('city_corporations')
                    ->where('div_id',$service_area->add_part1)
                    ->where('city_id',$service_area->add_part2)
                    ->where('id',$riding->add_part3)
                    ->first();
                $add_part4 = DB::table('thanas')
                    ->where('div_id',$service_area->add_part1)
                    ->where('city_id',$service_area->add_part2)
                    ->where('city_co_id',$riding->add_part3)
                    ->where('id',$riding->add_part4)
                    ->first();
            }
            if($address_typep==1){
                $add_partp1 = DB::table('divisions')
                    ->where('id',$riding->add_partp1)
                    ->first();
                $add_partp2 = DB::table('districts')
                    ->where('div_id',$riding->add_partp1)
                    ->where('id',$riding->add_partp2)
                    ->first();
                $add_partp3 = DB::table('upazillas')
                    ->where('div_id',$riding->add_partp1)
                    ->where('dis_id',$riding->add_partp2)
                    ->where('id',$riding->add_partp3)
                    ->first();
                $add_partp4 = DB::table('unions')
                    ->where('div_id',$riding->add_partp1)
                    ->where('dis_id',$riding->add_partp2)
                    ->where('upz_id',$riding->add_partp3)
                    ->where('id',$riding->add_partp4)
                    ->first();
            }
            if($address_typep==2){
                $add_partp1 = DB::table('divisions')
                    ->where('id',$riding->add_partp1)
                    ->first();
                $add_partp2 = DB::table('cities')
                    ->where('div_id',$riding->add_partp1)
                    ->where('id',$riding->add_partp2)
                    ->first();
                $add_partp3 = DB::table('city_corporations')
                    ->where('div_id',$riding->add_partp1)
                    ->where('city_id',$riding->add_partp2)
                    ->where('id',$riding->add_partp3)
                    ->first();
                $add_partp4 = DB::table('thanas')
                    ->where('div_id',$riding->add_partp1)
                    ->where('city_id',$riding->add_partp2)
                    ->where('city_co_id',$riding->add_partp3)
                    ->where('id',$riding->add_partp4)
                    ->first();
            }
            if($riding->transport =='Motorcycle'){
                if($address_type==1){
                    $add_partp1 = DB::table('divisions')
                        ->where('id',$service_area->add_part1)
                        ->first();
                    $add_partp2 = DB::table('districts')
                        ->where('div_id',$service_area->add_part1)
                        ->where('id',$service_area->add_part2)
                        ->first();
                    $add_partp3 = DB::table('upazillas')
                        ->where('div_id',$service_area->add_part1)
                        ->where('dis_id',$service_area->add_part2)
                        ->where('id',$riding->add_partp3)
                        ->first();
                    $add_partp4 = DB::table('unions')
                        ->where('div_id',$service_area->add_part1)
                        ->where('dis_id',$service_area->add_part2)
                        ->where('upz_id',$riding->add_partp3)
                        ->where('id',$riding->add_partp4)
                        ->first();
                }
                if($address_type==2){
                    $add_partp1 = DB::table('divisions')
                        ->where('id',$service_area->add_part1)
                        ->first();
                    $add_partp2 = DB::table('cities')
                        ->where('div_id',$service_area->add_part1)
                        ->where('id',$service_area->add_part2)
                        ->first();
                    $add_partp3 = DB::table('city_corporations')
                        ->where('div_id',$service_area->add_part1)
                        ->where('city_id',$service_area->add_part2)
                        ->where('id',$riding->add_partp3)
                        ->first();
                    $add_partp4 = DB::table('thanas')
                        ->where('div_id',$service_area->add_part1)
                        ->where('city_id',$service_area->add_part2)
                        ->where('city_co_id',$riding->add_part3)
                        ->where('id',$riding->add_partp4)
                        ->first();
                }
            }
            $booking[$i]['date'] = $riding->date;
            $booking[$i]['transport'] = $riding->transport;
            $booking[$i]['user'] = $user->name;
            $booking[$i]['add_part1'] = $add_part1->name;
            $booking[$i]['add_part2'] = $add_part2->name;
            $booking[$i]['add_part3'] = $add_part3->name;
            $booking[$i]['add_part4'] = $add_part4->name;
            $booking[$i]['add_partp1'] = @$add_partp1->name;
            $booking[$i]['add_partp2'] = @$add_partp2->name;
            $booking[$i]['add_partp3'] = @$add_partp3->name;
            $booking[$i]['add_partp4'] = @$add_partp4->name;
            $booking[$i]['c_distance'] = $riding->customer_distance;
            $booking[$i]['c_cost'] = $riding->cutomer_cost;
            $booking[$i]['r_distance'] = $riding->rider_distance;
            $booking[$i]['r_cost'] = $riding->rider_cost;
            $i++;
        }
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($booking);
        $perPage = 20;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $paginatedItems->setPath($request->url());
        return view('backend.transportReportAdmin',['bookings' => $paginatedItems]);
    }
    public function transportListByDate(Request $request){
        $rows = DB::table('ride_booking')
            ->where('transport',$request->transport)
            ->whereBetween('date',array($request->from_date,$request->to_date))
            ->get();
        $booking =array();
        $i = 0;
        foreach ($rows as $riding){
            $user_id = $riding->user_id;
            $address_type = $riding->address_type;
            $address_typep = $riding->address_type;
            $service_area = DB::table('service_area')
                ->where('user_id',$user_id)
                ->first();
            $user = DB::table('users')
                ->where('id', $user_id)
                ->first();
            if($address_type==1){
                $add_part1 = DB::table('divisions')
                    ->where('id',$service_area->add_part1)
                    ->first();
                $add_part2 = DB::table('districts')
                    ->where('div_id',$service_area->add_part1)
                    ->where('id',$service_area->add_part2)
                    ->first();
                $add_part3 = DB::table('upazillas')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('id',$riding->add_part3)
                    ->first();
                $add_part4 = DB::table('unions')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('upz_id',$riding->add_part3)
                    ->where('id',$riding->add_part4)
                    ->first();
            }
            if($address_type==2){
                $add_part1 = DB::table('divisions')
                    ->where('id',$service_area->add_part1)
                    ->first();
                $add_part2 = DB::table('cities')
                    ->where('div_id',$service_area->add_part1)
                    ->where('id',$service_area->add_part2)
                    ->first();
                $add_part3 = DB::table('city_corporations')
                    ->where('div_id',$service_area->add_part1)
                    ->where('city_id',$service_area->add_part2)
                    ->where('id',$riding->add_part3)
                    ->first();
                $add_part4 = DB::table('thanas')
                    ->where('div_id',$service_area->add_part1)
                    ->where('city_id',$service_area->add_part2)
                    ->where('city_co_id',$riding->add_part3)
                    ->where('id',$riding->add_part4)
                    ->first();
            }
            if($address_typep==1){
                $add_partp1 = DB::table('divisions')
                    ->where('id',$riding->add_partp1)
                    ->first();
                $add_partp2 = DB::table('districts')
                    ->where('div_id',$riding->add_partp1)
                    ->where('id',$riding->add_partp2)
                    ->first();
                $add_partp3 = DB::table('upazillas')
                    ->where('div_id',$riding->add_partp1)
                    ->where('dis_id',$riding->add_partp2)
                    ->where('id',$riding->add_partp3)
                    ->first();
                $add_partp4 = DB::table('unions')
                    ->where('div_id',$riding->add_partp1)
                    ->where('dis_id',$riding->add_partp2)
                    ->where('upz_id',$riding->add_partp3)
                    ->where('id',$riding->add_partp4)
                    ->first();
            }
            if($address_typep==2){
                $add_partp1 = DB::table('divisions')
                    ->where('id',$riding->add_partp1)
                    ->first();
                $add_partp2 = DB::table('cities')
                    ->where('div_id',$riding->add_partp1)
                    ->where('id',$riding->add_partp2)
                    ->first();
                $add_partp3 = DB::table('city_corporations')
                    ->where('div_id',$riding->add_partp1)
                    ->where('city_id',$riding->add_partp2)
                    ->where('id',$riding->add_partp3)
                    ->first();
                $add_partp4 = DB::table('thanas')
                    ->where('div_id',$riding->add_partp1)
                    ->where('city_id',$riding->add_partp2)
                    ->where('city_co_id',$riding->add_partp3)
                    ->where('id',$riding->add_partp4)
                    ->first();
            }
            if($riding->transport =='Motorcycle'){
                if($address_type==1){
                    $add_partp1 = DB::table('divisions')
                        ->where('id',$service_area->add_part1)
                        ->first();
                    $add_partp2 = DB::table('districts')
                        ->where('div_id',$service_area->add_part1)
                        ->where('id',$service_area->add_part2)
                        ->first();
                    $add_partp3 = DB::table('upazillas')
                        ->where('div_id',$service_area->add_part1)
                        ->where('dis_id',$service_area->add_part2)
                        ->where('id',$riding->add_partp3)
                        ->first();
                    $add_partp4 = DB::table('unions')
                        ->where('div_id',$service_area->add_part1)
                        ->where('dis_id',$service_area->add_part2)
                        ->where('upz_id',$riding->add_partp3)
                        ->where('id',$riding->add_partp4)
                        ->first();
                }
                if($address_type==2){
                    $add_partp1 = DB::table('divisions')
                        ->where('id',$service_area->add_part1)
                        ->first();
                    $add_partp2 = DB::table('cities')
                        ->where('div_id',$service_area->add_part1)
                        ->where('id',$service_area->add_part2)
                        ->first();
                    $add_partp3 = DB::table('city_corporations')
                        ->where('div_id',$service_area->add_part1)
                        ->where('city_id',$service_area->add_part2)
                        ->where('id',$riding->add_partp3)
                        ->first();
                    $add_partp4 = DB::table('thanas')
                        ->where('div_id',$service_area->add_part1)
                        ->where('city_id',$service_area->add_part2)
                        ->where('city_co_id',$riding->add_part3)
                        ->where('id',$riding->add_partp4)
                        ->first();
                }
            }
            $booking[$i]['date'] = $riding->date;
            $booking[$i]['transport'] = $riding->transport;
            $booking[$i]['user'] = $user->name;
            $booking[$i]['add_part1'] = $add_part1->name;
            $booking[$i]['add_part2'] = $add_part2->name;
            $booking[$i]['add_part3'] = $add_part3->name;
            $booking[$i]['add_part4'] = $add_part4->name;
            $booking[$i]['add_partp1'] = @$add_partp1->name;
            $booking[$i]['add_partp2'] = @$add_partp2->name;
            $booking[$i]['add_partp3'] = @$add_partp3->name;
            $booking[$i]['add_partp4'] = @$add_partp4->name;
            $booking[$i]['c_distance'] = $riding->customer_distance;
            $booking[$i]['c_cost'] = $riding->cutomer_cost;
            $booking[$i]['r_distance'] = $riding->rider_distance;
            $booking[$i]['r_cost'] = $riding->rider_cost;
            $i++;
        }
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($booking);
        $perPage = 20;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $paginatedItems->setPath($request->url());
        return view('backend.transportReportAdmin',['bookings' => $paginatedItems,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
    }
    public function courierReport(Request $request){
        $rows = DB::table('courier_booking')
            ->select('*','naming1s.name as n_name','courier_type.name as c_name','courier_status.status as c_status','courier_status.id as c_id')
            ->join('courier_type','courier_type.id','=','courier_booking.type')
            ->join('courier_status','courier_status.c_id','=','courier_booking.id')
            ->join('naming1s','naming1s.id','=','courier_booking.f_country')
            ->get();
        $booking =array();
        $i = 0;
        foreach ($rows as $couriers) {
            $service_area = DB::table('service_area')
                ->where('user_id',$couriers->user_id)
                ->first();
            $user = DB::table('users')
                ->where('id',$couriers->user_id)
                ->first();
            $address_type_service_area = $service_area->address_type;
            if($address_type_service_area==1){
                $add_part1 = DB::table('divisions')
                    ->where('id',$service_area->add_part1)
                    ->first();
                $add_part2 = DB::table('districts')
                    ->where('div_id',$service_area->add_part1)
                    ->where('id',$service_area->add_part2)
                    ->first();
                $add_part3 = DB::table('upazillas')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('id',$service_area->add_part3)
                    ->first();
                $add_part4 = DB::table('unions')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('upz_id',$service_area->add_part3)
                    ->where('id',$service_area->add_part4)
                    ->first();
            }
            if($address_type_service_area==2){
                $add_part1 = DB::table('divisions')
                    ->where('id',$service_area->add_part1)
                    ->first();
                $add_part2 = DB::table('cities')
                    ->where('div_id',$service_area->add_part1)
                    ->where('id',$service_area->add_part2)
                    ->first();
                $add_part3 = DB::table('city_corporations')
                    ->where('div_id',$service_area->add_part1)
                    ->where('city_id',$service_area->add_part2)
                    ->where('id',$service_area->add_part3)
                    ->first();
                $add_part4 = DB::table('thanas')
                    ->where('div_id',$service_area->add_part1)
                    ->where('city_id',$service_area->add_part2)
                    ->where('city_co_id',$service_area->add_part3)
                    ->where('id',$service_area->add_part4)
                    ->first();
            }
            if($address_type_service_area==3){
                $add_part1 = DB::table('naming1s')
                    ->where('id',$service_area->add_part1)
                    ->first();
                $add_part2 = DB::table('naming2s')
                    ->where('div_id',$service_area->add_part1)
                    ->where('id',$service_area->add_part2)
                    ->first();
                $add_part3 = DB::table('naming3s')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('id',$service_area->add_part3)
                    ->first();
                $add_part4 = DB::table('naming4')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('upz_id',$service_area->add_part3)
                    ->where('id',$service_area->add_part4)
                    ->first();
            }
            if($couriers->address_type==1){
                $add_part1C = DB::table('divisions')
                    ->where('id',$couriers->add_part1)
                    ->first();
                $add_part2C = DB::table('districts')
                    ->where('div_id',$couriers->add_part1)
                    ->where('id',$couriers->add_part2)
                    ->first();
                $add_part3C = DB::table('upazillas')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('id',$couriers->add_part3)
                    ->first();
                $add_part4C = DB::table('unions')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('id',$couriers->add_part4)
                    ->first();
                $add_part5C = DB::table('wards')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('uni_id',$couriers->add_part4)
                    ->where('id',$couriers->add_part5)
                    ->first();
            }
            if($couriers->address_type==2){
                $add_part1C = DB::table('divisions')
                    ->where('id',$couriers->add_part1)
                    ->first();
                $add_part2C = DB::table('cities')
                    ->where('div_id',$couriers->add_part1)
                    ->where('id',$couriers->add_part2)
                    ->first();
                $add_part3C = DB::table('city_corporations')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('id',$couriers->add_part3)
                    ->first();
                $add_part4C = DB::table('thanas')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('id',$couriers->add_part4)
                    ->first();
                $add_part5C = DB::table('c_wards')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('uni_id',$couriers->add_part4)
                    ->where('id',$couriers->add_part5)
                    ->first();
            }
            if($couriers->address_type==3){
                $add_part1C = DB::table('naming1s')
                    ->where('id',$couriers->add_part1)
                    ->first();
                $add_part2C = DB::table('naming2s')
                    ->where('div_id',$couriers->add_part1)
                    ->where('id',$couriers->add_part2)
                    ->first();
                $add_part3C = DB::table('naming3s')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('id',$couriers->add_part3)
                    ->first();
                $add_part4C = DB::table('naming4')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('id',$couriers->add_part4)
                    ->first();
                $add_part5C = DB::table('naming5s')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('uni_id',$couriers->add_part4)
                    ->where('id',$couriers->add_part5)
                    ->first();
            }
            $booking[$i]['date'] = $couriers->date;
            $booking[$i]['user'] = $user->name;
            $booking[$i]['user_phone'] = $user->phone;
            $booking[$i]['add_part1'] = $add_part1->name;
            $booking[$i]['add_part2'] = $add_part2->name;
            $booking[$i]['add_part3'] = $add_part3->name;
            $booking[$i]['add_part4'] = $add_part4->name;
            $booking[$i]['add_part1C'] = $add_part1C->name;
            $booking[$i]['add_part2C'] = $add_part2C->name;
            $booking[$i]['add_part3C'] = $add_part3C->name;
            $booking[$i]['add_part4C'] = $add_part4C->name;
            $booking[$i]['add_part5C'] = $add_part5C->name;
            $booking[$i]['address'] = $couriers->address;
            $booking[$i]['n_name'] = $couriers->n_name;
            $booking[$i]['cost'] = $couriers->cost;
            $booking[$i]['weight'] = $couriers->weight;
            $booking[$i]['tx_id'] = $couriers->tx_id;
            $booking[$i]['status'] = $couriers->c_status;
            $booking[$i]['msg'] = $couriers->msg;
            $booking[$i]['id'] = $couriers->c_id;
            $i++;

        }
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($booking);
        $perPage = 20;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $paginatedItems->setPath($request->url());
        return view('backend.courierReport',['bookings' => $paginatedItems]);
    }
    public function courierListByDate(Request $request){
        $rows = DB::table('courier_booking')
            ->select('*','naming1s.name as n_name','courier_type.name as c_name','courier_status.status as c_status','courier_status.id as c_id')
            ->join('courier_type','courier_type.id','=','courier_booking.type')
            ->join('courier_status','courier_status.c_id','=','courier_booking.id')
            ->join('naming1s','naming1s.id','=','courier_booking.f_country')
            ->whereBetween('date',array($request->from_date,$request->to_date))
            ->get();
        $booking =array();
        $i = 0;
        foreach ($rows as $couriers) {
            $service_area = DB::table('service_area')
                ->where('user_id',$couriers->user_id)
                ->first();
            $user = DB::table('users')
                ->where('id',$couriers->user_id)
                ->first();
            $address_type_service_area = $service_area->address_type;
            if($address_type_service_area==1){
                $add_part1 = DB::table('divisions')
                    ->where('id',$service_area->add_part1)
                    ->first();
                $add_part2 = DB::table('districts')
                    ->where('div_id',$service_area->add_part1)
                    ->where('id',$service_area->add_part2)
                    ->first();
                $add_part3 = DB::table('upazillas')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('id',$service_area->add_part3)
                    ->first();
                $add_part4 = DB::table('unions')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('upz_id',$service_area->add_part3)
                    ->where('id',$service_area->add_part4)
                    ->first();
            }
            if($address_type_service_area==2){
                $add_part1 = DB::table('divisions')
                    ->where('id',$service_area->add_part1)
                    ->first();
                $add_part2 = DB::table('cities')
                    ->where('div_id',$service_area->add_part1)
                    ->where('id',$service_area->add_part2)
                    ->first();
                $add_part3 = DB::table('city_corporations')
                    ->where('div_id',$service_area->add_part1)
                    ->where('city_id',$service_area->add_part2)
                    ->where('id',$service_area->add_part3)
                    ->first();
                $add_part4 = DB::table('thanas')
                    ->where('div_id',$service_area->add_part1)
                    ->where('city_id',$service_area->add_part2)
                    ->where('city_co_id',$service_area->add_part3)
                    ->where('id',$service_area->add_part4)
                    ->first();
            }
            if($address_type_service_area==3){
                $add_part1 = DB::table('naming1s')
                    ->where('id',$service_area->add_part1)
                    ->first();
                $add_part2 = DB::table('naming2s')
                    ->where('div_id',$service_area->add_part1)
                    ->where('id',$service_area->add_part2)
                    ->first();
                $add_part3 = DB::table('naming3s')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('id',$service_area->add_part3)
                    ->first();
                $add_part4 = DB::table('naming4')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('upz_id',$service_area->add_part3)
                    ->where('id',$service_area->add_part4)
                    ->first();
            }
            if($couriers->address_type==1){
                $add_part1C = DB::table('divisions')
                    ->where('id',$couriers->add_part1)
                    ->first();
                $add_part2C = DB::table('districts')
                    ->where('div_id',$couriers->add_part1)
                    ->where('id',$couriers->add_part2)
                    ->first();
                $add_part3C = DB::table('upazillas')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('id',$couriers->add_part3)
                    ->first();
                $add_part4C = DB::table('unions')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('id',$couriers->add_part4)
                    ->first();
                $add_part5C = DB::table('wards')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('uni_id',$couriers->add_part4)
                    ->where('id',$couriers->add_part5)
                    ->first();
            }
            if($couriers->address_type==2){
                $add_part1C = DB::table('divisions')
                    ->where('id',$couriers->add_part1)
                    ->first();
                $add_part2C = DB::table('cities')
                    ->where('div_id',$couriers->add_part1)
                    ->where('id',$couriers->add_part2)
                    ->first();
                $add_part3C = DB::table('city_corporations')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('id',$couriers->add_part3)
                    ->first();
                $add_part4C = DB::table('thanas')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('id',$couriers->add_part4)
                    ->first();
                $add_part5C = DB::table('c_wards')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('uni_id',$couriers->add_part4)
                    ->where('id',$couriers->add_part5)
                    ->first();
            }
            if($couriers->address_type==3){
                $add_part1C = DB::table('naming1s')
                    ->where('id',$couriers->add_part1)
                    ->first();
                $add_part2C = DB::table('naming2s')
                    ->where('div_id',$couriers->add_part1)
                    ->where('id',$couriers->add_part2)
                    ->first();
                $add_part3C = DB::table('naming3s')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('id',$couriers->add_part3)
                    ->first();
                $add_part4C = DB::table('naming4')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('id',$couriers->add_part4)
                    ->first();
                $add_part5C = DB::table('naming5s')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('uni_id',$couriers->add_part4)
                    ->where('id',$couriers->add_part5)
                    ->first();
            }
            $booking[$i]['date'] = $couriers->date;
            $booking[$i]['user'] = $user->name;
            $booking[$i]['user_phone'] = $user->phone;
            $booking[$i]['add_part1'] = $add_part1->name;
            $booking[$i]['add_part2'] = $add_part2->name;
            $booking[$i]['add_part3'] = $add_part3->name;
            $booking[$i]['add_part4'] = $add_part4->name;
            $booking[$i]['add_part1C'] = $add_part1C->name;
            $booking[$i]['add_part2C'] = $add_part2C->name;
            $booking[$i]['add_part3C'] = $add_part3C->name;
            $booking[$i]['add_part4C'] = $add_part4C->name;
            $booking[$i]['add_part5C'] = $add_part5C->name;
            $booking[$i]['address'] = $couriers->address;
            $booking[$i]['n_name'] = $couriers->n_name;
            $booking[$i]['cost'] = $couriers->cost;
            $booking[$i]['weight'] = $couriers->weight;
            $booking[$i]['tx_id'] = $couriers->tx_id;
            $booking[$i]['status'] = $couriers->c_status;
            $booking[$i]['msg'] = $couriers->msg;
            $booking[$i]['id'] = $couriers->c_id;
            $i++;

        }
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($booking);
        $perPage = 20;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $paginatedItems->setPath($request->url());
        return view('backend.courierReport',['bookings' => $paginatedItems,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
    }
    public function cookingReport (){
        try{

            $cooking = DB::table('cooking_booking')
                ->select('*','a.name as u_name','a.phone as  u_phone')
                ->join('users as a', 'a.id', '=', 'cooking_booking.user_id')
                ->join('users as b', 'b.id', '=', 'cooking_booking.cooker_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->paginate(20);
            return view('backend.cookingReport',['cookings' =>$cooking]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function cookingReportListByDate (Request  $request){
        try{

            $cooking = DB::table('cooking_booking')
                ->select('*','a.name as u_name','a.phone as  u_phone')
                ->join('users as a', 'a.id', '=', 'cooking_booking.user_id')
                ->join('users as b', 'b.id', '=', 'cooking_booking.cooker_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->whereBetween('date',array($request->from_date,$request->to_date))
                ->paginate(20);
            return view('backend.cookingReport',['cookings' =>$cooking,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function clothWashingReport (Request  $request){
        try{

            $washing = DB::table('cloth_washing_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','cloth_washing_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'cloth_washing_order.user_id')
                ->join('users as b', 'b.id', '=', 'cloth_washing_order.cleaner_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->orderBy('cloth_washing_order.id','desc')
                ->paginate(20);
            return view('backend.clothWashingReport',['washings' =>$washing]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function clothWashingReportListByDate (Request  $request){
        try{

            $washing = DB::table('cloth_washing_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','cloth_washing_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'cloth_washing_order.user_id')
                ->join('users as b', 'b.id', '=', 'cloth_washing_order.cleaner_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->orderBy('cloth_washing_order.id','desc')
                ->whereBetween('date',array($request->from_date,$request->to_date))
                ->paginate(20);
            return view('backend.clothWashingReport',['washings' =>$washing,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getClothWashingById(Request $request){
        $output = array('list'=>'');
        $orders = DB::table('cloth_washing_order')
            ->where('id',  $request->id)
            ->first();
        $cloth_id = json_decode($orders->cloth_id);
        $quantity = json_decode($orders->quantity);
        $i =0;
        foreach ($quantity as $q){
            $quantity_arr[$i] =$q;
            $i++;
        }
        for($i=0; $i<count($cloth_id); $i++){
            $cloth = DB::table('cloth_washing')
                ->select('*')
                ->where('id',  $cloth_id[$i])
                ->first();
            $output['list'] .= "
                    <tr class='prepend_items'>
                        <td>".$cloth->name."</td>
                        <td>".$quantity_arr[$i]."</td>
                    </tr>
                ";
        }
        return response()->json(array('data'=>$output));
    }
    public function roomCleaningReport (Request  $request){
        try{
            $washing = DB::table('cleaning_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','cleaning_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'cleaning_order.user_id')
                ->join('users as b', 'b.id', '=', 'cleaning_order.cleaner_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->orderBy('cleaning_order.id','desc')
                ->paginate(20);
            return view('backend.roomCleaningReport',['washings' =>$washing]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function cleaningReportListByDate (Request  $request){
        try{
            $washing = DB::table('cleaning_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','cleaning_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'cleaning_order.user_id')
                ->join('users as b', 'b.id', '=', 'cleaning_order.cleaner_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->whereBetween('date',array($request->from_date,$request->to_date))
                ->orderBy('cleaning_order.id','desc')
                ->paginate(20);
            return view('backend.roomCleaningReport',['washings' =>$washing,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function helpingHandReport (Request  $request){
        try{
            $washing = DB::table('helping_hand_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','helping_hand_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'helping_hand_order.user_id')
                ->join('users as b', 'b.id', '=', 'helping_hand_order.helper')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->orderBy('helping_hand_order.id','desc')
                ->paginate(20);
            return view('backend.helpingHandReport',['washings' =>$washing]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function helpingHandReportListByDate (Request  $request){
        try{
            $washing = DB::table('helping_hand_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','helping_hand_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'helping_hand_order.user_id')
                ->join('users as b', 'b.id', '=', 'helping_hand_order.helper')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->whereBetween('date',array($request->from_date,$request->to_date))
                ->orderBy('helping_hand_order.id','desc')
                ->paginate(20);
            return view('backend.helpingHandReport',['washings' =>$washing,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function guardReport (Request  $request){
        try{
            $washing = DB::table('guard_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','guard_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'guard_order.user_id')
                ->join('users as b', 'b.id', '=', 'guard_order.gurd_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->orderBy('guard_order.id','desc')
                ->paginate(20);
            return view('backend.guardReport',['washings' =>$washing]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function guardReportListByDate (Request  $request){
        try{
            $washing = DB::table('guard_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','guard_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'guard_order.user_id')
                ->join('users as b', 'b.id', '=', 'guard_order.gurd_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->whereBetween('date',array($request->from_date,$request->to_date))
                ->orderBy('guard_order.id','desc')
                ->paginate(20);
            return view('backend.guardReport',['washings' =>$washing,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function variousServicingReport (Request  $request){
        try{

            $washing = DB::table('various_servicing_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','various_servicing_order.name as v_name')
                ->join('users as a', 'a.id', '=', 'various_servicing_order.user_id')
                ->join('users as b', 'b.id', '=', 'various_servicing_order.worker')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->orderBy('various_servicing_order.id','desc')
                ->paginate(20);
            return view('backend.variousServicingReport',['washings' =>$washing]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function laundryReport (Request  $request){
        try{
            $washing = DB::table('laundry_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','laundry_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'laundry_order.user_id')
                ->join('users as b', 'b.id', '=', 'laundry_order.cleaner_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->orderBy('laundry_order.id','desc')
                ->paginate(20);
            return view('backend.laundryReport',['washings' =>$washing]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function laundryReportListByDate (Request  $request){
        try{
            $washing = DB::table('laundry_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','laundry_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'laundry_order.user_id')
                ->join('users as b', 'b.id', '=', 'laundry_order.cleaner_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->orderBy('laundry_order.id','desc')
                ->whereBetween('date',array($request->from_date,$request->to_date))
                ->paginate(20);
            return view('backend.laundryReport',['washings' =>$washing,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getLaundryWashingById(Request $request){
        $output = array('list'=>'');
        $orders = DB::table('laundry_order')
            ->where('id',  $request->id)
            ->first();
        $cloth_id = json_decode($orders->cloth_id);
        $quantity = json_decode($orders->quantity);
        $i =0;
        foreach ($quantity as $q){
            $quantity_arr[$i] =$q;
            $i++;
        }
        for($i=0; $i<count($cloth_id); $i++){
            $cloth = DB::table('laundry')
                ->select('*')
                ->where('id',  $cloth_id[$i])
                ->first();
            $output['list'] .= "
                    <tr class='prepend_items'>
                        <td>".$cloth->name."</td>
                        <td>".$quantity_arr[$i]."</td>
                    </tr>
                ";
        }
        return response()->json(array('data'=>$output));
    }
    public function parlorReport  (Request  $request){
        try{
            $washing = DB::table('parlor_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','parlor_order.name as v_name')
                ->join('users as a', 'a.id', '=', 'parlor_order.user_id')
                ->join('users as b', 'b.id', '=', 'parlor_order.parlor_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->orderBy('parlor_order.id','desc')
                ->paginate(20);
            return view('backend.parlorReport',['washings' =>$washing]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function parlorReportListByDate  (Request  $request){
        try{
            $washing = DB::table('parlor_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','parlor_order.name as v_name')
                ->join('users as a', 'a.id', '=', 'parlor_order.user_id')
                ->join('users as b', 'b.id', '=', 'parlor_order.parlor_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->whereBetween('date',array($request->from_date,$request->to_date))
                ->orderBy('parlor_order.id','desc')
                ->paginate(20);
            return view('backend.parlorReport',['washings' =>$washing,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }

}
