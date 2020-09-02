<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function salesReport ( ){
        try{
            return view('backend.sales', ['divisions' => '']);
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
                ->get();

            return view('backend.animalSalesReport', ['aminal_Sales' => $aminal_Sale]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function ticketSalesReport ( ){
        try{
            $ticket_Sale = DB::table('ticket_booking')
                ->join('users', 'ticket_booking.user_id', '=', 'users.id')
                ->orderBy('ticket_booking.id','desc')
                ->paginate(10);
            return view('backend.ticketSalesReport', ['ticket_Sales' => $ticket_Sale]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function accounting ( ){
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
        //dd($orders);
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

}
