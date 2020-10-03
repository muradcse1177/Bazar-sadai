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

}
