<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use smasif\ShurjopayLaravelPackage\ShurjopayService;

class PaymentController extends Controller
{
   public function getPaymentCartView(Request $request){
       Session::put('donate', $request->donate);
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
       $stmt = DB::table('carts')
           ->select('*','carts.id AS cartid')
           ->leftJoin('products', 'products.id', '=', 'carts.product_id')
           ->join('product_assign','product_assign.product_id', '=','products.id')
           ->where('carts.user_id',Cookie::get('user_id'))
           ->where('product_assign.dealer_id',$dealer->id)
           ->orderBy('products.id','Asc')
           ->get();
       $total =0;
       if($stmt->count() > 0) {
           foreach ($stmt as $row) {
               $quantity = $row->quantity / $row->minqty;
               $subtotal = $row->edit_price * $quantity;
               $total += $subtotal;
           }
       }
       $rows = DB::table('delivery_charges')
           ->where('purpose_id', 1)
           ->first();
       $delivery_charge = $rows->charge;
       $d_total = 0;
       if($request->donate == 'want_donate'){
           $d_cart = DB::table('donate_carts')
               ->select('*')
               ->where('user_id', Cookie::get('user_id'))
               ->get();
           if($d_cart->count()>0){
               $d_stmt = DB::table('donate_carts')
                   ->select('*','donate_carts.id AS cartid')
                   ->leftJoin('products', 'products.id', '=', 'donate_carts.product_id')
                   ->join('product_assign','product_assign.product_id', '=','products.id')
                   ->where('donate_carts.user_id',Cookie::get('user_id'))
                   ->where('product_assign.dealer_id',$dealer->id)
                   ->orderBy('products.id','Asc')
                   ->get();
           }
           if($d_stmt->count() > 0) {
               foreach ($d_stmt as $d_row) {
                   $d_quantity = $d_row->quantity / $d_row->minqty;
                   $d_subtotal = $d_row->edit_price * $d_quantity;
                   $d_total += $d_subtotal;
               }
           }
           $Total = $total+$delivery_charge+$d_total;
       }
       else{
           $Total = $total+$delivery_charge;
       }
       $shurjopay_service = new ShurjopayService();
       $tx_id = $shurjopay_service->generateTxId();
       $success_route = url('sales');
       $shurjopay_service->sendPayment($Total, $success_route);
   }
}
