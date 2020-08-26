<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

}
