@extends('backend.layout')
@section('title', 'বিক্রয় রিপোর্ট')
@section('page_header', 'বিক্রয় রিপোর্ট ব্যবস্থাপনা')
@section('salesLiAdd','active')
@section('content')

    @if ($message = Session::get('successMessage'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> ধন্যবাদ</h4>
            {{ $message }}</b>
        </div>
    @endif
    @if ($message = Session::get('errorMessage'))

        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-warning"></i> দুঃখিত!</h4>
            {{ $message }}
        </div>
    @endif

    <div class="row">

        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">বিক্রয় রিপোর্ট</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th class="hidden"></th>
                            <th>তারিখ</th>
                            <th>ক্রেতার নাম</th>
                            <th>ঠিকানা</th>
                            <th>অর্ডার নং</th>
                            <th>পরিমান</th>
                            <th>দায়িত্ত্ব</th>
                            <th>অবস্থা</th>
                            <th>বিস্তারিত</th>
                        </tr>
                        <?php
                             function en2bn($number) {
                                $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
                                $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
                                $bn_number = str_replace($search_array, $replace_array, $number);
                                return $bn_number;
                             }
                            use Illuminate\Support\Facades\DB;
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
                            //dd($stmt);

                            foreach($stmt as $row){
                                $dealer = DB::table('users')
                                    ->where('add_part1',$row->add_part1)
                                    ->where('add_part2',$row->add_part2)
                                    ->where('add_part3',$row->add_part3)
                                    ->where('address_type',$row->address_type)
                                    ->where('user_type',7)
                                    ->first();
                                if(isset($dealer->id))
                                    $dealer_id= $dealer->id;
                                else
                                    $dealer_id= "";
                                $stmt2= DB::table('details')
                                    ->join('products', 'products.id', '=', 'details.product_id')
                                    ->join('product_assign','product_assign.product_id', '=','products.id')
                                    ->where('product_assign.dealer_id',$dealer_id)
                                    ->where('details.sales_id', $row->salesid)
                                    ->orderBy('products.id','Asc')
                                    ->get();
                               // dd($stmt2);

                                $total = 0;
                                foreach($stmt2 as $details){
                                    if($details->quantity >101) {
                                        $quantity = $details->quantity/1000;
                                    }
                                    else{
                                        $quantity = $details->quantity;
                                    }
                                    $subtotal = $details->edit_price*$quantity;
                                    $total += $subtotal;
                                }
                                //print_r($total); echo '<br>';
                                $row1 = DB::table('users')
                                    ->where('id', $row->v_id)
                                    ->get();
                                $volunteer = DB::table('users')
                                    ->where('id', $row->v_id)
                                    ->first();
                                if( $row1->count()>0 ) {
                                    $name =  $volunteer->name;
                                    $v_id= "profile.php?id=". $volunteer->id;
                                }
                                else {
                                    $name =  "Not Assigned" ;
                                    $v_id=" ";
                                }
                                if($row->v_status==0) $status = "Processing";
                                if($row->v_status==2) $status = "Assigned";
                                if($row->v_status==3) $status = "On the service";
                                if($row->v_status==4) $status = "Delivered";
                                echo "
                                  <tr>
                                    <td class='hidden'></td>
                                    <td>".date('M d, Y', strtotime($row->sales_date))."</td>
                                    <td>".$row->name."</td>
                                    <td>".$row->address."</td>
                                    <td>".$row->pay_id."</td>
                                    <td> ".en2bn(number_format($total+$delivery_charge , 2))."</td>
                                    <td><center><a href='". $v_id."'><button type='button' class='btn btn-success btn-sm btn-flat'>".$name." </button></a></center></td>
                                    <td><button type='button' class='btn btn-danger btn-sm btn-flat u_search' data-id='".$row->user_id."'>".$status." </button></td>
                                    <td><button type='button' class='btn btn-info btn-sm btn-flat transact' data-id='".$row->salesid."'><i class='fa fa-search'></i> বিস্তারিত</button></td>
                                  </tr>
                                ";

                        }
                        ?>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="transaction">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><b>বিস্তারিত ট্রানজেকশন</b></h4>
                </div>
                <div class="modal-body">
                    <p>
                        তারিখ: <span id="date"></span>
                        <span class="pull-right">ট্রানজেকশন: <span id="transid"></span></span>
                    </p>
                    <table class="table table-bordered">
                        <thead>
                        <th>পন্য</th>
                        <th>দাম</th>
                        <th>পরিমান</th>
                        <th>মোট</th>
                        </thead>
                        <tbody id="detail">
                        <tr>
                            <td colspan="3" align="right"><b> ডেলিভারি চার্জ </b></td>
                            <td><span id="delivery"></span></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right"><b>সর্বমোট </b></td>
                            <td><span id="total"></span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(function(){
            $(document).on('click', '.transact', function(e){
                e.preventDefault();
                $('#transaction').modal('show');
                var id = $(this).data('id');
                console.log(id);
                $.ajax({
                    type: 'POST',
                    url: 'transaction',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id
                    },
                    dataType: 'json',
                    success:function(response){
                        $('#date').html(response.data.date);
                        $('#transid').html(response.data.transaction);
                        $('#detail').prepend(response.data.list);
                        $('#total').html(response.data.total);
                        $('#delivery').html(response.data.delivery_charge);
                    }
                });
            });

            $("#transaction").on("hidden.bs.modal", function () {
                $('.prepend_items').remove();
            });
        });
    </script>
@endsection
