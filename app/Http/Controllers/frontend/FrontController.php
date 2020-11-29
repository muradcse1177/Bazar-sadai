<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use smasif\ShurjopayLaravelPackage\ShurjopayService;

class FrontController extends Controller
{
    public function homepageManager(Request $request){
        try{
            $product_cat = DB::table('categories')
                ->where('type', 1)
                ->where('status', 1)
                ->orderBy('id', 'ASC')->get();
            $sale_cat = DB::table('categories')
                ->where('type', 3)
                ->where('status', 1)
                ->orderBy('id', 'ASC')->get();
            return view('frontend.homepage',
                [
                    'p_categories' => $product_cat,
                    'se_categories' => $sale_cat,
                ]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getProductByCatId($id){
        try{
            if(Cookie::get('user_id') != null) {
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
                if(!empty($dealer)) {
                    $dealer_product = DB::table('products')
                        ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                        ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                        ->where('products.cat_id', $id)
                        ->where('products.status', 1)
                        ->where('product_assign.dealer_id', $dealer->id)
                        ->orderBy('products.id', 'ASC')->paginate(100);
                    //dd($dealer_product);
                    if($dealer_product->count()>0){
                        $dealer_status['status'] = 1;
                        //dd($dealer_product);
                        return view('frontend.productPage', ['products' => $dealer_product,'status' =>$dealer_status]);
                    }
                }
                else{
                    $dealer_product = DB::table('products')
                        ->where('cat_id', $id)
                        ->where('status', 1)
                        ->orderBy('id', 'ASC')->paginate(100);
                    $dealer_status['status'] = 0;
                    return view('frontend.productPage', ['products' => $dealer_product ,'status' =>$dealer_status]);
                }

            }
            else {
                $dealer_product = DB::table('products')
                    ->where('cat_id', $id)
                    ->where('status', 1)
                    ->orderBy('id', 'ASC')->paginate(100);
                $dealer_status['status'] = 0;
                return view('frontend.productPage', ['products' => $dealer_product,'status' =>$dealer_status]);
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getProductMiqty(Request $request){
        try{
            $rows = DB::table('products')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('products'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function cart_add(Request $request){
        try{
            $id=$request->id;
            $quantity= $request->quantity;
            if(Cookie::get('user_id') != null){
                $rowsCount = DB::table('carts')
                    ->where('user_id', Cookie::get('user_id'))
                    ->where('product_id', $id)
                    ->distinct()->get()->count();
                if($rowsCount < 1){
                    try{
                        $result = DB::table('carts')->insert([
                            'user_id' => Cookie::get('user_id'),
                            'product_id' => $id,
                            'quantity' =>$quantity
                        ]);
                        $result1 = DB::table('donate_carts')->insert([
                            'user_id' => Cookie::get('user_id'),
                            'product_id' => $id,
                            'quantity' =>$quantity
                        ]);
                        $output['message'] = 'Item added to cart';

                    }
                    catch(\Illuminate\Database\QueryException $ex){
                        return back()->with('errorMessage', $ex->getMessage());
                    }
                }
                else{
                    $output['error'] = true;
                    $output['message'] = 'Product already in cart';
                }
            }
            else {
                if (!Session::has('cart_item')) {
                    Session::put('cart_item', array());
                }
                $exist = array();
                foreach (Session::get('cart_item') as $row) {
                    array_push($exist, $row['productid']);
                }

                if (in_array($id, $exist)) {
                    $output['error'] = true;
                    $output['message'] = 'Product already in cart';
                } else {
                    $data['productid'] = $id;
                    $data['quantity'] = $quantity;
                    $item = Session::get('cart_item');
                    if (array_push($item, $data)) {
                        Session::put('cart_item', $item);
                        $output['message'] = 'Item added to cart';
                    } else {
                        $output['error'] = true;
                        $output['message'] = 'Cannot add item to cart';
                    }
                }
            }
            return response()->json(array('output'=>$output));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public static function en2bn($number) {
        $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $bn_number = str_replace($search_array, $replace_array, $number);
        return $bn_number;
    }
    public function cart_fetch(Request $request){
        try{
            $output = array('list'=>'','count'=>0);
            if(Cookie::get('user_id') != null){
                try{
                    $url = url('/') . '/';
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
                    if(!empty($dealer)) {
                        $stmt = DB::table('carts')
                            ->select('*', 'products.name AS prodname')
                            ->leftJoin('products', 'products.id', '=', 'carts.product_id')
                            ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                            ->where('carts.user_id', Cookie::get('user_id'))
                            ->where('product_assign.dealer_id', $dealer->id)
                            ->orderBy('products.id', 'Asc')
                            ->get();
                        foreach ($stmt as $row) {
                            $output['count']++;
                            $image = (!empty($row->photo)) ? $row->photo : 'public/asset/images/noImage.jpg';

                            $quantity = $row->quantity / $row->minqty;
                            $bprice = $this->en2bn($row->edit_price);
                            $bquantity = $this->en2bn($quantity);
                            $bsum = $this->en2bn($row->edit_price * $quantity);
                            $url = url('/') . '/';
                            $output['list'] .= "
                            <li>
                                <a href=''>
                                    <div class='pull-left'>
                                        <img src='" . $url . $image . "' class='img-circle' alt='User Image'>
                                    </div>
                                    <h4 style='font-size: 14px;'>
                                        <b>" . $row->name . ' = ' . " $bprice&times; " . $bquantity . '=' . $bsum . '৳' . "</b>
                                    </h4>
                                </a>
                            </li>
                        ";
                        }
                    }
                    else{
                        $output['message']='No Dealer and Delivery Man are found in your area.';
                    }
                }
                catch(\Illuminate\Database\QueryException $ex){
                    return back()->with('errorMessage', $ex->getMessage());
                }
            }
            else {
                if (!Session::has('cart_item')) {
                    $cart_item = array();
                    Session::put('cart_item', $cart_item);
                    $cart_item = Session::get('cart_item');
                }
                if (Session::has('cart_item') == null) {
                    $output['count'] = 0;
                } else {
                    $cart_item = Session::get('cart_item');
                    foreach ($cart_item as $row) {
                        $output['count']++;
                        $product = DB::table('products')
                            ->where('id', $row['productid'])
                            ->first();
                        $image = (!empty($product->photo)) ? $product->photo : 'public/asset/images/noImage.jpg';

                        $quantity = $row['quantity']/$product->minqty;
                        $bprice = $this->en2bn($product->price);
                        $bquantity = $this->en2bn($quantity);
                        if (strpos($product->price, '৳') !== false) {
                            $priceArr = explode("৳",$product->price);
                            $price = (int)$priceArr[1];
                        }
                        else{
                            $price=$product->price;
                        }

                        $bsum = $this->en2bn($price * $quantity);
                        $url = url('/') . '/';
                        $output['list'] .= "
                            <li>
                                <a href=''>
                                    <div class='pull-left'>
                                        <img src='" . $url . $image . "' class='img-circle' alt='User Image'>
                                    </div>
                                    <h4 style='font-size: 14px;'>
                                        <b>" . $product->name . ' = ' . " $bprice&times; " . $bquantity . '=' . $bsum . '৳' . "</b>
                                    </h4>
                                </a>
                            </li>
                        ";

                    }
                }
            }

            return response()->json(array('output'=>$output));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function cart_view(Request $request){
        try{
            if(Cookie::get('user_id') != null ) {
                $id =Cookie::get('user_id');
            }else{
                $id = '';
            }
            $rowsCount = DB::table('carts')
                ->where('user_id', $id)
                ->distinct()->get()->count();

            return view('frontend.cartView', ['count' => $rowsCount]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function donate(){
        $output="";
        $url =url('/').'/';
        if(Cookie::get('user_id') != null ){
            try{
                $total = 0;
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
                $stmt = DB::table('donate_carts')
                    ->select('*','donate_carts.id AS cartid','products.id as p_id')
                    ->leftJoin('products', 'products.id', '=', 'donate_carts.product_id')
                    ->join('product_assign','product_assign.product_id', '=','products.id')
                    ->where('donate_carts.user_id',Cookie::get('user_id'))
                    ->where('product_assign.dealer_id',$dealer->id)
                    ->orderBy('products.id','Asc')
                    ->get();
                if($stmt->count() > 0) {
                    foreach ($stmt as $row) {
                        $image = (!empty($row->photo)) ? $url . $row->photo : $url . 'public/asset/images/noImage.jpg';
                        $quantity = $row->quantity / $row->minqty;
                        $subtotal = $row->edit_price * $quantity;
                        $total += $subtotal;
                        $output .= "
                        <tr>
                            <td><button type='button' data-id='" . $row->cartid . "' class='btn btn-danger btn-flat cart_delete_donate'><i class='fa fa-remove'></i></button></td>
                            <td><img src='" . $image . "' width='30px' height='30px'></td>
                            <td>" . $row->name . "</td>
                            <td> " . $this->en2bn(number_format($row->edit_price, 2)) . "</td>
                            <td><input style='width: 60px; text-align: center;' min='1' type='number' data-id='".$row->p_id."' id='".'q'.$row->p_id."' class='quantity' value='".$row->quantity."'></td>
                            <td>" . $row->unit . "</td>
                            <td> " . $this->en2bn(number_format($subtotal, 2)) . "</td>
                        </tr>
                        ";
                    }
                    $output .= "
                        <tr>
                            <td colspan='6' align='right'><b>সর্বমোট</b></td>
                            <td><b> " . $this->en2bn(number_format($total , 2)) . "</b></td>
                        <tr>
                        ";
                }
                else{
                    $output .= "
                        <tr>
                            <td colspan='7' align='center'>Donate cart empty</td>
                        <tr>
                    ";
                }
                return response()->json(array('output'=>$output));
            }
            catch(\Illuminate\Database\QueryException $ex){
                return back()->with('errorMessage', $ex->getMessage());
            }
        }
    }
    public function donateQuantityChange(Request $request){
        $result =DB::table('donate_carts')
            ->where('user_id',  Cookie::get('user_id'))
            ->where('product_id', $request->id)
            ->update([
                'quantity' => $request->value,
            ]);
        $output="";
        $url =url('/').'/';
        if(Cookie::get('user_id') != null ){
            try{
                $total = 0;
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
                $stmt = DB::table('donate_carts')
                    ->select('*','donate_carts.id AS cartid','products.id as p_id')
                    ->leftJoin('products', 'products.id', '=', 'donate_carts.product_id')
                    ->join('product_assign','product_assign.product_id', '=','products.id')
                    ->where('donate_carts.user_id',Cookie::get('user_id'))
                    ->where('product_assign.dealer_id',$dealer->id)
                    ->orderBy('products.id','Asc')
                    ->get();
                if($stmt->count() > 0) {
                    foreach ($stmt as $row) {
                        $image = (!empty($row->photo)) ? $url . $row->photo : $url . 'public/asset/images/noImage.jpg';
                        $quantity = $row->quantity / $row->minqty;
                        $subtotal = $row->edit_price * $quantity;
                        $total += $subtotal;
                        $output .= "
                        <tr>
                            <td><button type='button' data-id='" . $row->cartid . "' class='btn btn-danger btn-flat cart_delete_donate'><i class='fa fa-remove'></i></button></td>
                            <td><img src='" . $image . "' width='30px' height='30px'></td>
                            <td>" . $row->name . "</td>
                            <td> " . $this->en2bn(number_format($row->edit_price, 2)) . "</td>
                            <td><input style='width: 60px; text-align: center;' min='1' type='number' data-id='".$row->p_id."' id='".'q'.$row->p_id."' class='quantity' value='".$row->quantity."'></td>
                            <td>" . $row->unit . "</td>
                            <td> " . $this->en2bn(number_format($subtotal, 2)) . "</td>
                        </tr>
                        ";
                    }
                    $output .= "
                        <tr>
                            <td colspan='6' align='right'><b>সর্বমোট</b></td>
                            <td><b> " . $this->en2bn(number_format($total , 2)) . "</b></td>
                        <tr>
                        ";
                }
                else{
                    $output .= "
                        <tr>
                            <td colspan='7' align='center'>Donate cart empty</td>
                        <tr>
                    ";
                }
                return response()->json(array('output'=>$output));
            }
            catch(\Illuminate\Database\QueryException $ex){
                return back()->with('errorMessage', $ex->getMessage());
            }
        }
    }
    public function cart_details(Request $request){
        try{
            $output="";
            $rows = DB::table('delivery_charges')
                ->where('purpose_id', 1)
                ->first();
            $delivery_charge = $rows->charge;
            $url =url('/').'/';
            if(Cookie::get('user_id') != null ){
                if(Session::has('cart_item')){
                    foreach(Session::get('cart_item') as $row){
                        $rowsCount = DB::table('carts')
                            ->where('user_id', Cookie::get('user_id'))
                            ->where('product_id', $row['productid'])
                            ->distinct()->get()->count();
                        if($rowsCount < 1){
                            $result = DB::table('carts')->insert([
                                'user_id' => Cookie::get('user_id'),
                                'product_id' => $row['productid'],
                                'quantity' => $row['quantity']
                            ]);
                            $result1 = DB::table('donate_carts')->insert([
                                'user_id' => Cookie::get('user_id'),
                                'product_id' => $row['productid'],
                                'quantity' => $row['quantity']
                            ]);
                        }
                        else{
                            $result =DB::table('carts')
                                ->where('user_id',  Cookie::get('user_id'))
                                ->where('product_id', $row['productid'])
                                ->update([
                                    'quantity' => $row['quantity'],
                                ]);
                            $result1 =DB::table('donate_carts')
                                ->where('user_id',  Cookie::get('user_id'))
                                ->where('product_id', $row['productid'])
                                ->update([
                                    'quantity' => $row['quantity'],
                                ]);
                        }
                    }
                    session()->forget('cart_item');
                }
                try{
                    $total = 0;
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
                    if($stmt->count() > 0) {
                        foreach ($stmt as $row) {
                            $image = (!empty($row->photo)) ? $url . $row->photo : $url . 'public/asset/images/noImage.jpg';
                            $quantity = $row->quantity / $row->minqty;
                            $subtotal = $row->edit_price * $quantity;
                            $total += $subtotal;
                            $output .= "
                        <tr>
                            <td><button type='button' data-id='" . $row->cartid . "' class='btn btn-danger btn-flat cart_delete'><i class='fa fa-remove'></i></button></td>
                            <td><img src='" . $image . "' width='30px' height='30px'></td>
                            <td>" . $row->name . "</td>
                            <td> " . $this->en2bn(number_format($row->edit_price, 2)) . "</td>
                            <td>" . $this->en2bn($row->quantity) . "</td>
                            <td>" . $row->unit . "</td>
                            <td> " . $this->en2bn(number_format($subtotal, 2)) . "</td>
                        </tr>
                        ";
                        }
                        $output .= "
                        <tr>
                            <td colspan='6' align='right'><b>সার্ভিস চার্জ </b></td>
                            <td><b> " . $this->en2bn(number_format($delivery_charge, 2)) . "</b></td>
                        <tr>
                        <tr>
                            <td colspan='6' align='right'><b>সর্বমোট</b></td>
                            <td><b> " . $this->en2bn(number_format($total + $delivery_charge, 2)) . "</b></td>
                        <tr>
                        ";
                    }
                    else{
                        $output .= "
                        <tr>
                            <td colspan='7' align='center'>Shopping cart empty</td>
                        <tr>
                    ";
                    }
                }
                catch(\Illuminate\Database\QueryException $ex){
                    return back()->with('errorMessage', $ex->getMessage());
                }
            }
            else {
                $count= count(Session::get('cart_item'));
                if ($count > 0) {
                    $total = 0;
                    foreach (Session::get('cart_item') as $row) {
                        $product = DB::table('products')
                            ->where('id', $row['productid'])
                            ->first();
                        $image = (!empty($product->photo)) ? $url . $product->photo : $url . 'public/asset/images/noImage.jpg';
                        $quantity = $row['quantity'] / $product->minqty;
                        $price=$product->price;
                        $subtotal =$price * $quantity;
                        $total += $subtotal;
                        $bprice = $this->en2bn($price);
                        $output .= "
					<tr>
						<td><button type='button' data-id='" . $row['productid'] . "' class='btn btn-danger btn-flat cart_delete'><i class='fa fa-remove'></i></button></td>
						<td><img src='" . $image . "' width='30px' height='30px'></td>
						<td>" . $product->name . "</td>
						<td> " . $this->en2bn(number_format($price, 2)) . "</td>
						<td>" . $this->en2bn($row['quantity']) . "</td>
						<td>" . $product->unit . "</td>
						<td> " . $this->en2bn(number_format($subtotal, 2)) . "</td>
					</tr>
				    ";
                    }
                    $output .= "
                        <tr>
                            <td colspan='6' align='right'><b>সার্ভিস চার্জ </b></td>
                            <td><b> " . $this->en2bn(number_format($delivery_charge, 2)) . "</b></td>
                        <tr>
                        <tr>
                            <td colspan='6' align='right'><b>সর্বমোট</b></td>
                            <td><b> " . $this->en2bn(number_format($total + $delivery_charge, 2)) . "</b></td>
                        <tr>
                    ";
                }
                else {
                    $output .= "
                        <tr>
                            <td colspan='7' align='center'>Shopping cart empty</td>
                        <tr>
                    ";
                }
            }
            return response()->json(array('output'=>$output));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function cart_delete(Request $request){
        try{
            $output = array('error'=>false);
            $id = $request->id;
            if(Cookie::get('user_id') != null ){
                try{
                    DB::table('carts')->where('id', $id)->delete();
                    $output['message'] = 'Deleted';

                }
                catch(\Illuminate\Database\QueryException $ex){
                    return back()->with('errorMessage', $ex->getMessage());
                }
            }
            else {
                $cart_item = Session::get('cart_item');
                foreach ($cart_item as $key => $row) {
                    if ($row['productid'] == $id) {
                        unset($cart_item[$key]);
                        $output['message'] = 'Deleted';
                    }
                }
                Session::put('cart_item', $cart_item);
            }
            return response()->json(array('output' => $output));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function cart_delete_donate(Request $request){
        try{
            $output = array('error'=>false);
            $id = $request->id;
            if(Cookie::get('user_id') != null ){
                try{
                    DB::table('donate_carts')->where('id', $id)->delete();
                    $output['message'] = 'Deleted';

                }
                catch(\Illuminate\Database\QueryException $ex){
                    return back()->with('errorMessage', $ex->getMessage());
                }
                return response()->json(array('output' => $output));
            }

        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function sales(Request $request){
        try{
            $status = $request->status;
            $type = 'daily_sales';
            $msg = $request->msg;
            $tx_id = $request->tx_id;
            $bank_tx_id = $request->bank_tx_id;
            $amount = $request->amount;
            $bank_status = $request->bank_status;
            $sp_code = $request->sp_code;
            $sp_code_des = $request->sp_code_des;
            $sp_payment_option = $request->sp_payment_option;
            $date = date('Y-m-d');
            if($status){
                $result = DB::table('payment_info')->insert([
                    'user_id' => Cookie::get('user_id'),
                    'status' => $status,
                    'type' => $type,
                    'msg' => $msg,
                    'tx_id' => $tx_id,
                    'bank_tx_id' => $bank_tx_id,
                    'amount' => $amount,
                    'bank_status' => $bank_status,
                    'sp_code' => $sp_code,
                    'sp_code_des' => $sp_code_des,
                    'sp_payment_option' => $sp_payment_option,
                ]);
                $user_info = DB::table('users')
                    ->select('*')
                    ->where('id', Cookie::get('user_id'))
                    ->first();
                $delear = DB::table('users')
                    ->where('user_type',  7)
                    ->where('add_part1',  $user_info->add_part1)
                    ->where('add_part2',  $user_info->add_part2)
                    ->where('add_part3',  $user_info->add_part3)
                    ->where('address_type',  $user_info->address_type)
                    ->where('status',  1)
                    ->first();
                $result = DB::table('v_assign')->insert([
                    'user_id' => Cookie::get('user_id'),
                    'dealer_id' => $delear->id,
                    'pay_id' => $tx_id,
                    'sales_date' => $date
                ]);
                $salesid = DB::getPdo()->lastInsertId();
                $stmt = DB::table('carts')
                    ->select('*','carts.id AS cartid')
                    ->leftJoin('products', 'products.id', '=', 'carts.product_id')
                    ->join('product_assign','product_assign.product_id', '=','products.id')
                    ->where('carts.user_id',Cookie::get('user_id'))
                    ->where('product_assign.dealer_id',$delear->id)
                    ->orderBy('products.id','Asc')
                    ->get();
                //dd($stmt);
                foreach($stmt as $row){
                    $result = DB::table('details')->insert([
                        'sales_id' => $salesid,
                        'product_id' => $row->product_id,
                        'quantity' => $row->quantity,
                        'price' => $row->edit_price
                    ]);
                }
                if(Session::get('donate')  == 'want_donate'){
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
                            ->where('product_assign.dealer_id',$delear->id)
                            ->orderBy('products.id','Asc')
                            ->get();
                        foreach($d_stmt as $d_row){
                            $result = DB::table('donation_details')->insert([
                                'sales_id' => $salesid,
                                'product_id' => $d_row->product_id,
                                'quantity' => $d_row->quantity,
                            ]);
                        }
                        DB::table('donate_carts')->where('user_id',  Cookie::get('user_id'))->delete();
                        session()->forget('donate');
                    }
                }
                $product_cart = DB::table('carts')
                    ->select('*')
                    ->where('user_id', Cookie::get('user_id'))
                    ->first();
                DB::table('carts')->where('user_id',  Cookie::get('user_id'))->delete();
                DB::table('donate_carts')->where('user_id',  Cookie::get('user_id'))->delete();
                $working_status = 1;
                if($user_info->address_type == 1) {
                    $ward_info = DB::table('wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('dis_id', $user_info->add_part2)
                        ->where('upz_id', $user_info->add_part3)
                        ->where('uni_id', $user_info->add_part4)
                        ->where('id', $user_info->add_part5)
                        ->first();
                    $ward_plus = $ward_info->position + 1;
                    $ward_minus = $ward_info->position - 1;
                    $ward_plus_id_info = DB::table('wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('dis_id', $user_info->add_part2)
                        ->where('upz_id', $user_info->add_part3)
                        ->where('uni_id', $user_info->add_part4)
                        ->where('position', $ward_plus)
                        ->first();
                    $ward_plus_id = $ward_plus_id_info->id;
                    if($ward_info->position == 1) $ward_minus_id = $ward_info->position;
                    else{
                        $ward_minus_id_info = DB::table('wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('dis_id', $user_info->add_part2)
                        ->where('upz_id', $user_info->add_part3)
                        ->where('uni_id', $user_info->add_part4)
                        ->where('position', $ward_minus)
                        ->first();
                        $ward_minus_id = $ward_minus_id_info->id;
                    }
                }
                if($user_info->address_type == 2) {
                    $c_ward_info = DB::table('c_wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('city_id', $user_info->add_part2)
                        ->where('city_co_id', $user_info->add_part3)
                        ->where('thana_id', $user_info->add_part4)
                        ->where('id', $user_info->add_part5)
                        ->first();
                    $ward_plus = $c_ward_info->position + 1;
                    $ward_minus = $c_ward_info->position - 1;
                    $c_ward_plus_id_info = DB::table('c_wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('city_id', $user_info->add_part2)
                        ->where('city_co_id', $user_info->add_part3)
                        ->where('thana_id', $user_info->add_part4)
                        ->where('position', $ward_plus)
                        ->first();
                    $ward_plus_id = $c_ward_plus_id_info->id;
                    if($c_ward_info->position == 1) $ward_minus_id = $c_ward_info->position;
                    else{
                        $c_ward_minus_id_info = DB::table('wards')
                        ->select('*')
                        ->where('div_id', $user_info->add_part1)
                        ->where('dis_id', $user_info->add_part2)
                        ->where('upz_id', $user_info->add_part3)
                        ->where('uni_id', $user_info->add_part4)
                        ->where('position', $ward_minus)
                        ->first();
                        $ward_minus_id = $c_ward_minus_id_info->id;
                    }
                }
                $user_type = 5;
                $delivery_man = DB::table('users')
                    ->where('user_type',  $user_type)
                    ->where('add_part1',  $user_info->add_part1)
                    ->where('add_part2',  $user_info->add_part2)
                    ->where('add_part3',  $user_info->add_part3)
                    ->where('add_part4',  $user_info->add_part4)
                    ->where('add_part5',  $user_info->add_part5)
                    ->where('working_status',  $working_status)
                    ->where('address_type',  $user_info->address_type)
                    ->where('status',  1)
                    ->get();
                if($delivery_man->count()>0){
                    $result =DB::table('users')
                        ->where('id', $delivery_man[0]->id)
                        ->update([
                            'working_status' => 2,
                        ]);
                    $result =DB::table('v_assign')
                        ->where('id', $salesid)
                        ->update([
                            'v_id' => $delivery_man[0]->id,
                            'v_type' => $delivery_man[0]->user_type,
                            'v_status' => 2,
                        ]);
                }
                else{
                    $delivery_man = DB::table('users')
                        ->where('user_type',  $user_type)
                        ->where('add_part1',  $user_info->add_part1)
                        ->where('add_part2',  $user_info->add_part2)
                        ->where('add_part3',  $user_info->add_part3)
                        ->where('add_part4',  $user_info->add_part4)
                        ->where('add_part5',  $ward_plus_id)
                        ->where('working_status',  $working_status)
                        ->where('address_type',  $user_info->address_type)
                        ->where('status',  1)
                        ->get();
                    if($delivery_man->count()>0){
                        $result =DB::table('users')
                            ->where('id', $delivery_man[0]->id)
                            ->update([
                                'working_status' => 2,
                            ]);
                        $result =DB::table('v_assign')
                            ->where('id', $salesid)
                            ->update([
                                'v_id' => $delivery_man[0]->id,
                                'v_type' => $delivery_man[0]->user_type,
                                'v_status' => 2,
                            ]);
                    }
                    else{
                        $delivery_man = DB::table('users')
                            ->where('user_type',  $user_type)
                            ->where('add_part1',  $user_info->add_part1)
                            ->where('add_part2',  $user_info->add_part2)
                            ->where('add_part3',  $user_info->add_part3)
                            ->where('add_part4',  $user_info->add_part4)
                            ->where('add_part5',  $ward_minus_id)
                            ->where('working_status',  $working_status)
                            ->where('address_type',  $user_info->address_type)
                            ->where('status',  1)
                            ->get();
                        if($delivery_man->count()>0){
                            $result =DB::table('users')
                                ->where('id', $delivery_man[0]->id)
                                ->update([
                                    'working_status' => 2,
                                ]);
                            $result =DB::table('v_assign')
                                ->where('id', $salesid)
                                ->update([
                                    'v_id' => $delivery_man[0]->id,
                                    'v_type' => $delivery_man[0]->user_type,
                                    'v_status' => 2,
                                ]);
                        }
                        else{
                            $result =DB::table('v_assign')
                                ->where('id', $salesid)
                                ->update([
                                    'v_id' => 0,
                                    'v_type' => 0,
                                    'v_status' => 0,
                                ]);
                        }
                    }
                }
                if($delivery_man->count()>0){
                    return redirect()->to('myProductOrder')->with('successMessage', 'সফল্ভাবে অর্ডার সম্পন্ন্য হয়েছে। '.$delivery_man[0]->name.' আপনার অর্ডার এর দায়িত্বে আছে। প্রয়োজনে '.$delivery_man[0]->phone.' কল করুন।'  );
                }
                else{
                    return redirect()->to('myProductOrder')->with('successMessage', 'অর্ডার প্রোসেসিং আছে। ');
                }

            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function buySale($id){
        try{
            $products = DB::table('seller_product')
                ->where('status', 'Active')
                ->where('amount','>', 0)
                ->get();
            //dd($products);

            //dd($product);
               return view('frontend.buysale', ['products' => $products]);
            }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getAllSaleCategory(Request $request){
        try{
            $rows = DB::table('categories')
                ->where('id', 6)
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }

    public function insertSaleProduct(Request $request){
        try{
            if($request) {
                    if(Cookie::get('user_id')) {
                        $PhotoPath="";
                        if ($request->hasFile('photo')) {
                            $targetFolder = 'public/asset/images/';
                            $file = $request->file('photo');
                            $pname = time() . '.' . $file->getClientOriginalName();
                            $image['filePath'] = $pname;
                            $file->move($targetFolder, $pname);
                            $PhotoPath = $targetFolder . $pname;
                        }
                        $address = $request->address1.','.$request->address2.','.$request->address3;
                        $result = DB::table('sale_products')->insert([
                            'seller_id' => Cookie::get('user_id'),
                            'name' => $request->name,
                            'price' => $request->price,
                            'jat' => $request->jat,
                            'color' => $request->color,
                            'weight' => $request->weight,
                            'address' => $address,
                            'photo' => $PhotoPath,
                            'description' => $request->description,
                        ]);
                        if ($result) {
                            return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                        } else {
                            return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                        }
                    }
                    else{
                        return back()->with('errorMessage', 'ফর্ম পুরন করুন।');
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
    public function getSaleProductsDetails(Request $request){
        try{
            $rows = DB::table('seller_product')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function animalSaleView($id){
        try{

            $rows = DB::table('sale_products')
                ->where('id', $id)
                ->first();
            return view('frontend.animalSaleView', ['products' => $rows, 'id' =>$id]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function productSaleView($id){
        try{

            $rows = DB::table('seller_product')
                ->where('id', $id)
                ->first();
            return view('frontend.productSaleView', ['products' => $rows, 'id' =>$id]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function animalSales($id){
        try{

            $rows = DB::table('sale_products')
                ->where('id', $id)
                ->first();
            $set='123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $code=substr(str_shuffle($set), 0, 12);
            $result = DB::table('animal_sales')->insert([
                'seller_id' => $rows->seller_id,
                'buyer_id' =>  Cookie::get('user_id'),
                'product_id' => $rows->id,
                'date' =>date("Y-m-d"),
                'pay_id' => $code,
            ]);

            if ($result) {
                $upresult =DB::table('sale_products')
                    ->where('id', $rows->id)
                    ->update([
                        'sale_status' => 0,
                    ]);
                if ($upresult) {
                    return redirect()->to('profile')->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে। দ্রুত আপনার সাথে যোগাযোগ করা হবে।');
                }
                else{
                    return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                }

            } else {
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function productSales($id){
        try{
            $rows = DB::table('seller_product')
                ->where('id', $id)
                ->first();
            $set='123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $code=substr(str_shuffle($set), 0, 12);
            $result = DB::table('product_sales')->insert([
                'seller_id' => $rows->seller_id,
                'buyer_id' =>  Cookie::get('user_id'),
                'product_id' => $rows->id,
                'date' =>date("Y-m-d"),
                'pay_id' => $code,
            ]);

            if ($result) {
                $upresult =DB::table('seller_product')
                    ->where('id', $rows->id)
                    ->update([
                        'amount' => $rows->amount-1,
                    ]);
                if ($upresult) {
                    return redirect()->to('myVariousProductOrderUser')->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে। দ্রুত আপনার সাথে যোগাযোগ করা হবে।');
                }
                else{
                    return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                }

            } else {
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function searchProduct(Request $request){
        try{
            if(Cookie::get('user_id') != null) {
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
                if(!empty($dealer)) {
                    $dealer_product = DB::table('products')
                        ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                        ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                        ->where('products.name', 'LIKE','%'.$request->key.'%')
                        ->orWhere('products.genre', 'LIKE','%'.$request->key.'%')
                        ->where('products.status', 1)
                        ->where('product_assign.dealer_id', $dealer->id)
                        ->orderBy('products.id', 'ASC')->paginate(100);
                    if($dealer_product->count()>0){
                        $dealer_status['status'] = 1;
                        return view('frontend.productPage', ['products' => $dealer_product,'status' =>$dealer_status]);
                    }
                    else{
                        return back()->with('errorMessage', 'পণ্যটি পাওয়া যায়নি।');
                    }

                }
                else{
                    $dealer_product = DB::table('products')
                        ->where('name', 'LIKE','%'.$request->key.'%')
                        ->orWhere('genre', 'LIKE','%'.$request->key.'%')
                        ->where('status', 1)
                        ->orderBy('id', 'ASC')->paginate(100);
                    if($dealer_product->count()>0){
                        $dealer_status['status'] = 0;
                        return view('frontend.productPage', ['products' => $dealer_product,'status' =>$dealer_status]);
                    }
                    else{
                        return back()->with('errorMessage', 'পণ্যটি পাওয়া যায়নি।');
                    }
                }

            }
            else {
                $dealer_product = DB::table('products')
                    ->where('name', 'LIKE','%'.$request->key.'%')
                    ->orWhere('genre', 'LIKE','%'.$request->key.'%')
                    ->where('status', 1)
                    ->orderBy('id', 'ASC')->paginate(100);
                if($dealer_product->count()>0){
                    $dealer_status['status'] = 0;
                    return view('frontend.productPage', ['products' => $dealer_product,'status' =>$dealer_status]);
                }
                else{
                    return back()->with('errorMessage', 'পণ্যটি পাওয়া যায়নি।');
                }
            }

        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function searchMedicine(Request $request){
        try{
            $trade_name = $request->trade_name;
            $generic_name = $request->generic_name;
            $company_name = $request->company_name ;
            if($company_name=="" && $trade_name=="" && $generic_name==""){
                return back()->with('errorMessage', 'কোন ডাটা পাওয়া যাইনি।');
            }
            else{
                if(Cookie::get('user_id') != null) {
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
                    if(!empty($dealer)) {
                        if($trade_name){
                            $dealer_product = DB::table('products')
                                ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                                ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                                ->where('products.name', 'LIKE','%'.$trade_name.'%')
                                ->where('products.status', 1)
                                ->where('products.cat_id', 3)
                                ->where('product_assign.dealer_id', $dealer->id)
                                ->orderBy('products.id', 'ASC')->paginate(100);
                        }
                        if($generic_name){
                            $dealer_product = DB::table('products')
                                ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                                ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                                ->where('products.genre', 'LIKE','%'.$generic_name.'%')
                                ->where('products.status', 1)
                                ->where('products.cat_id', 3)
                                ->where('product_assign.dealer_id', $dealer->id)
                                ->orderBy('products.id', 'ASC')->paginate(100);
                        }
                        if($company_name){
                            $dealer_product = DB::table('products')
                                ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                                ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                                ->where('products.company', 'LIKE','%'.$company_name.'%')
                                ->where('products.status', 1)
                                ->where('products.cat_id', 3)
                                ->where('product_assign.dealer_id', $dealer->id)
                                ->orderBy('products.id', 'ASC')->paginate(100);
                        }
                        if($dealer_product->count()>0){
                            $dealer_status['status'] = 1;
                            return view('frontend.productPage', ['products' => $dealer_product,'status' =>$dealer_status]);
                        }
                        else{
                            return back()->with('errorMessage', 'পণ্যটি পাওয়া যায়নি।');
                        }
                    }
                    else{
                        if($trade_name) {
                            $dealer_product = DB::table('products')
                                ->where('name', 'LIKE', '%' . $trade_name . '%')
                                ->where('status', 1)
                                ->where('cat_id', 3)
                                ->orderBy('id', 'ASC')->paginate(100);
                            if($dealer_product->count()>0){
                                $dealer_status['status'] = 0;
                                return view('frontend.productPage', ['products' => $dealer_product,'status' =>$dealer_status]);
                            }
                            else{
                                return back()->with('errorMessage', 'পণ্যটি পাওয়া যায়নি।');
                            }
                        }
                        if($generic_name) {
                            $dealer_product = DB::table('products')
                                ->where('genre', 'LIKE', '%' . $generic_name . '%')
                                ->where('status', 1)
                                ->where('cat_id', 3)
                                ->orderBy('id', 'ASC')->paginate(100);
                            if($dealer_product->count()>0){
                                $dealer_status['status'] = 0;
                                return view('frontend.productPage', ['products' => $dealer_product,'status' =>$dealer_status]);
                            }
                            else{
                                return back()->with('errorMessage', 'পণ্যটি পাওয়া যায়নি।');
                            }
                        }
                        if($company_name) {
                            $dealer_product = DB::table('products')
                                ->where('company', 'LIKE', '%' . $company_name . '%')
                                ->where('status', 1)
                                ->where('cat_id', 3)
                                ->orderBy('id', 'ASC')->paginate(100);
                            if($dealer_product->count()>0){
                                $dealer_status['status'] = 0;
                                return view('frontend.productPage', ['products' => $dealer_product,'status' =>$dealer_status]);
                            }
                            else{
                                return back()->with('errorMessage', 'পণ্যটি পাওয়া যায়নি।');
                            }
                        }
                    }

                }
                else {
                    if ($trade_name) {
                        $dealer_product = DB::table('products')
                            ->where('name', 'LIKE', '%' . $trade_name . '%')
                            ->where('status', 1)
                            ->where('cat_id', 3)
                            ->orderBy('id', 'ASC')->paginate(100);
                        if($dealer_product->count()>0){
                            $dealer_status['status'] = 0;
                            return view('frontend.productPage', ['products' => $dealer_product,'status' =>$dealer_status]);
                        }
                        else{
                            return back()->with('errorMessage', 'পণ্যটি পাওয়া যায়নি।');
                        }
                    }
                    if ($generic_name) {
                        $dealer_product = DB::table('products')
                            ->where('genre', 'LIKE', '%' . $generic_name . '%')
                            ->where('status', 1)
                            ->where('cat_id', 3)
                            ->orderBy('id', 'ASC')->paginate(100);
                        if($dealer_product->count()>0){
                            $dealer_status['status'] = 0;
                            return view('frontend.productPage', ['products' => $dealer_product,'status' =>$dealer_status]);
                        }
                        else{
                            return back()->with('errorMessage', 'পণ্যটি পাওয়া যায়নি।');
                        }
                    }
                    if ($company_name) {
                        $dealer_product = DB::table('products')
                            ->where('company', 'LIKE', '%' . $company_name . '%')
                            ->where('status', 1)
                            ->where('cat_id', 3)
                            ->orderBy('id', 'ASC')->paginate(100);
                        if($dealer_product->count()>0){
                            $dealer_status['status'] = 0;
                            return view('frontend.productPage', ['products' => $dealer_product,'status' =>$dealer_status]);
                        }
                        else{
                            return back()->with('errorMessage', 'পণ্যটি পাওয়া যায়নি।');
                        }
                    }
                }
            }

        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function searchMedicineByLetter($letter){
        try{
            if($letter==""){
                return back()->with('errorMessage', 'কোন ডাটা পাওয়া যাইনি।');
            }
            else{
                if(Cookie::get('user_id') != null) {
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
                    if(!empty($dealer)) {
                        if($letter){
                            $dealer_product = DB::table('products')
                                ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                                ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                                ->where('products.name', 'LIKE',$letter.'%')
                                ->where('products.status', 1)
                                ->where('products.cat_id', 3)
                                ->where('product_assign.dealer_id', $dealer->id)
                                ->orderBy('products.id', 'ASC')->paginate(100);
                        }
                        if($dealer_product->count()>0){
                            $dealer_status['status'] = 1;
                            //dd($dealer_product);
                            return view('frontend.productPage', ['products' => $dealer_product,'status' =>$dealer_status]);
                        }
                    }
                    else{
                        if($letter) {
                            $dealer_product = DB::table('products')
                                ->where('name', 'LIKE',  $letter . '%')
                                ->where('status', 1)
                                ->where('cat_id', 3)
                                ->orderBy('id', 'ASC')->paginate(100);
                            $dealer_status['status'] = 0;
                            return view('frontend.productPage', ['products' => $dealer_product, 'status' => $dealer_status]);
                        }
                    }

                }
                else {
                    if ($letter) {
                        $dealer_product = DB::table('products')
                            ->where('name', 'LIKE', $letter . '%')
                            ->where('status', 1)
                            ->where('cat_id', 3)
                            ->orderBy('id', 'ASC')->paginate(100);
                        $dealer_status['status'] = 0;
                        return view('frontend.productPage', ['products' => $dealer_product, 'status' => $dealer_status]);
                    }
                }
            }

        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }

    public function deliveryAddress(Request $request){

        $upresult =DB::table('sale_products')
            ->where('id', $request->proId)
            ->update([
                'delivery_address' => $request->delAdd,
            ]);
        if($upresult){
            return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
        }
        else{
            return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
        }
    }
    public function serviceCategory(Request $request){

        $services_cat_trans = DB::table('categories')
            ->where('id', 8)
            ->where('type', 2)
            ->where('status', 1)
            ->orderBy('id', 'ASC')->get();
        $services_cat_courier = DB::table('categories')
            ->where('id', 11)
            ->where('type', 2)
            ->where('status', 1)
            ->orderBy('id', 'ASC')->get();
        $services_cat_medical = DB::table('categories')
            ->where('id', 10)
            ->where('type', 2)
            ->where('status', 1)
            ->orderBy('id', 'ASC')->get();
        $home_assistants = DB::table('categories')
            ->where('id', 9)
            ->where('type', 2)
            ->where('status', 1)
            ->orderBy('id', 'ASC')->get();
        return view('frontend.servicesCategory',
                [
                    'services_cat_trans' => $services_cat_trans,
                    'services_cat_medical'=>$services_cat_medical,
                    'home_assistants'=>$home_assistants,
                    'services_cat_couriers'=>$services_cat_courier
                ]);
    }
    public function serviceSubCategoryMedical($id){
        $med_services_sub_cat = DB::table('subcategories')
            ->where('cat_id', $id)
            ->where('type', 2)
            ->where('status', 1)
            ->orderBy('id', 'ASC')->get();
        return view('frontend.serviceSubCategoryMedical', ['med_services_sub_cat' => $med_services_sub_cat]);
    }

    public function changeWorkingStatus(Request  $request){
        if($request->id == 0){
            $result =DB::table('users')
                ->where('id', Cookie::get('user_id'))
                ->update([
                    'working_status' => $request->id,
                ]);
        }
        if($request->id == 1){
            $result =DB::table('users')
                ->where('id', Cookie::get('user_id'))
                ->update([
                    'working_status' => $request->id,
                ]);
        }
        if($request->id == 2){
            $result =DB::table('users')
                ->where('id', Cookie::get('user_id'))
                ->update([
                    'working_status' => $request->id,
                ]);
            if($result){
                $result1 =DB::table('v_assign')
                    ->where('v_id', Cookie::get('user_id'))
                    ->orderBy('id','desc')
                    ->first();
                $result2 =DB::table('v_assign')
                    ->where('id', $result1->id)
                    ->update([
                        'v_status' => $request->id,
                    ]);
                if($result2){
                    return response()->json(array('data'=>'ok'));
                }
                else{
                    return response()->json(array('data'=>'not ok'));
                }
            }
        }
        if($request->id == 3){
            $result =DB::table('users')
                ->where('id', Cookie::get('user_id'))
                ->update([
                    'working_status' => $request->id,
                ]);
            if($result){
                $result1 =DB::table('v_assign')
                    ->where('v_id', Cookie::get('user_id'))
                    ->orderBy('id','desc')
                    ->first();
                $result2 =DB::table('v_assign')
                    ->where('id', $result1->id)
                    ->update([
                        'v_status' => $request->id,
                    ]);
                if($result2){
                    return response()->json(array('data'=>'ok'));
                }
                else{
                    return response()->json(array('data'=>'not ok'));
                }
            }
        }
        if($request->id == 4){
            $result =DB::table('users')
                ->where('id', Cookie::get('user_id'))
                ->update([
                    'working_status' => 1,
                ]);
            if($result){
                $result1 =DB::table('v_assign')
                    ->where('v_id', Cookie::get('user_id'))
                    ->orderBy('id','desc')
                    ->first();
                $result2 =DB::table('v_assign')
                    ->where('id', $result1->id)
                    ->update([
                        'v_status' => $request->id,
                    ]);
                if($result2){
                    return response()->json(array('data'=>'ok'));
                }
                else{
                    return response()->json(array('data'=>'not ok'));
                }
            }
        }
        else{
            return response()->json(array('data'=>'not ok'));
        }
    }

    public function forHumanity(){
        $rows = DB::table('donation_details')
            ->select('products.cat_id','products.unit','products.name', DB::raw('SUM(donation_details.quantity) AS quantity'))
            ->join('products','products.id','=','donation_details.product_id')
            ->groupBy('products.name','products.unit','products.cat_id')
            ->get();
        return view('frontend.forHumanity',['products' => $rows]);
    }



}
