@extends('frontend.frontLayout')
@section('title', 'প্রোফাইল')
@section('ExtCss')
    <link rel="stylesheet" href="public/asset/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
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
            <div class="col-md-4">
                @php
                    $Image ="public/asset/images/noImage.jpg";
                    if(!empty($users['info'])){
                       if(isset($users['info']->photo))
                           $Image =$users->photo;
                @endphp
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="{{$Image}}" alt="User profile picture">

                        <h3 class="profile-username text-center"></h3>

                        <p class="text-muted text-center">{{$users['info']->desig}}</p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>নামঃ</b> <a class="pull-right">{{$users['info']->name}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>মোবাইলঃ</b> <a class="pull-right">{{$users['info']->phone}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>মেইলঃ</b> <a class="pull-right">{{$users['info']->email}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>লিঙ্গঃ</b> <a class="pull-right">{{$users['info']->gender}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>ঠিকানাঃ</b> <a class="pull-right">{{$users['info']->address}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>সক্রিয়তাঃ</b> <a class="pull-right">@if($users['info']->status == 1){{'একটিভ' }} @else {{'একটিভ নয়'}}@endif</a>
                            </li>
                        </ul>
                        <button class="btn btn-primary btn-block edit allButton" data-id="{{$users['info']->id}}"><b>তথ্য পরিবর্তন করুন</b></button>
                    </div>
                </div>
            </div>
            @php
            }
            @endphp
            @if($users['info']->user_type == 5)
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <center><h4 class="box-title"><b>স্ট্যাটাস</b></h4></center>
                        <div class="box-body">

                                <center>
                                    @if($users['info']->working_status == 1 || $users['info']->working_status == 4 || $users['info']->working_status == 0)
                                    <input class="form-check-input w_status" type="radio" name="w_status" id="notwork" value="0"  @if($users['info']->working_status == 0) {{'checked'}} @endif>
                                    <label class="form-check-label" for="notwork">
                                       Not willing to work
                                    </label>&nbsp;&nbsp;
                                    <input class="form-check-input w_status" type="radio" name="w_status" id="free" value="1" @if($users['info']->working_status == 1) {{'checked'}} @endif>
                                    <label class="form-check-label" for="free">
                                       Free
                                    </label>&nbsp;&nbsp;
                                    @endif
                                    @if($users['info']->working_status == 2)
                                        <input class="form-check-input w_status" type="radio" name="w_status" id="assigned" value="2" @if($users['info']->working_status == 2) {{'checked'}} @endif>
                                        <label class="form-check-label" for="free">
                                            Assigned
                                        </label>&nbsp;&nbsp;
                                        <input class="form-check-input w_status" type="radio" name="w_status" id="working" value="3" @if($users['info']->working_status == 3) {{'checked'}} @endif>
                                        <label class="form-check-label" for="working">
                                            On the working
                                        </label>&nbsp;&nbsp;
                                    @endif
                                    @if($users['info']->working_status == 3)
                                    <input class="form-check-input w_status" type="radio" name="w_status" id="working" value="3" @if($users['info']->working_status == 3) {{'checked'}} @endif>
                                    <label class="form-check-label" for="working">
                                        On the working
                                    </label>&nbsp;&nbsp;
                                    <input class="form-check-input w_status" type="radio" name="w_status" id="delivered" value="4">
                                    <label class="form-check-label" for="delivered">
                                       Delivered
                                    </label>&nbsp;&nbsp;
                                    @endif
                                </center>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-md-8">
                <div class="box box-primary">
                    @if(Cookie::get('user_type')==4)
                    <div class="box-header with-border">
                        <h4 class="box-title"><i class="fa fa-balance-scale"></i> <b>আপনি কি বিক্রয় করতে চান।</b></h4>
                        <div class="box-body">
                            {{ Form::open(array('url' => 'insertSaleProduct',  'method' => 'post','enctype'=>'multipart/form-data')) }}
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="type" >ধরন</label>
                                <select id="cat_type" name ="cat_type" class="form-control select2 cat_type" style="width: 100%;" required>
                                    <option value=""selected>ধরন নির্বাচন করুন </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name" >নাম</label>
                                <input type="text" class="form-control name" name="name" placeholder="নাম"  required>
                            </div>
                            <div class="form-group">
                                <label for="name" >দাম</label>
                                <input type="number" class="form-control price" name="price" placeholder="দাম"  required>
                            </div>
                            <div class="form-group">
                                <label for="name" >জাত</label>
                                <input type="text" class="form-control jat" name="jat" placeholder="জাত"  required>
                            </div>
                            <div class="form-group">
                                <label for="name" >রঙ</label>
                                <input type="text" class="form-control color" name="color" placeholder="রঙ"  required>
                            </div>
                            <div class="form-group">
                                <label for="name" >ওজন</label>
                                <input type="number" class="form-control weight" name="weight" placeholder="ওজন"  required>
                            </div>
                            <h4> পন্যের ঠিকানাঃ</h4>
                            <div class="form-group">
                                <label for="name" >জেলা / সিটি-করপোরেশন</label>
                                <input type="text" class="form-control address1" name="address1" placeholder="জেলা/সিটি-করপোরেশন"  required>
                            </div>
                            <div class="form-group">
                                <label for="name" >উপজেলা / থানা</label>
                                <input type="text" class="form-control address2" name="address2" placeholder="উপজেলা/থানা"  required>
                            </div>
                            <div class="form-group">
                                <label for="name" >ইউনিয়ন /ওয়ার্ড </label>
                                <input type="text" class="form-control address3" name="address3" placeholder="ইউনিয়ন /ওয়ার্ড"  required>
                            </div>
                            <div class="form-group">
                                <label for="name" >ইউনিট</label>
                                <input type="text" class="form-control unit" name="unit" placeholder="ইউনিট" >
                            </div>
                            <div class="form-group">
                                <label for="type" >ছবি</label>
                                <input type="file" class="form-control" accept="image/*" name="photo" placeholder="ছবি">
                            </div>
                            <div class="form-group">
                                <label for="">বিবরন</label>
                                <textarea class="textarea description" id="description" placeholder="বিবরন লিখুন" name="description"
                                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                            </div>
                            <div class="box-footer">
                                <input type="hidden" name="id" id="id" class="id">
                                <button type="submit" class="btn btn-primary">সেভ করুন</button>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                    <div class="box-header with-border">
                        <h4 class="box-title"><i class="fa fa-calendar"></i> <b>আপনার বিক্রয় যোগ্য মালের লিস্ট দেখুন</b></h4>
                        <div class="box-body table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>ছবি</th>
                                    <th>নাম</th>
                                    <th>দাম</th>
                                    <th>ওজন</th>
                                    <th>জাত</th>
                                    <th>বিস্তারিত</th>
                                </tr>

                                @foreach($user_sale_info as $user_sale)

                                    <?php
                                    $Image =url('/')."/public/asset/images/noImage.jpg";
                                    if(!empty($user_sale->salPPhoto)){
                                        $Image =url('/').'/'.$user_sale->salPPhoto;
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <img src="{{$Image}}" width ="42" height="42" >
                                        </td>
                                        <td> {{$user_sale->salName}} </td>
                                        <td> {{$user_sale->price}} </td>
                                        <td> {{$user_sale->weight}} </td>
                                        <td> {{$user_sale->jat}} </td>
                                        <td class="td-actions text-center">
                                            <button type="button" rel="tooltip" class="btn btn-success search" data-id="{{$user_sale->salePID}}">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="box-header with-border">
                        <h4 class="box-title"><i class="fa fa-calendar"></i> <b>আপনার পশু ট্রাঞ্জেকশন লিস্ট দেখুন</b></h4>
                        <div class="box-body table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>তারিখ</th>
                                    <th>অর্ডার নং</th>
                                    <th>নাম</th>
                                    <th>দাম</th>
                                    <th>কাস্টোমার</th>
                                    <th>ফোন</th>
                                </tr>

                                @foreach($user_sold_lst as $user_sold_lst)

                                    <?php
                                        $Image =url('/')."/public/asset/images/noImage.jpg";
                                        if(!empty($user_sold_lst->salPPhoto)){
                                            $Image =url('/').'/'.$user_sold_lst->salPPhoto;
                                        }
                                    ?>
                                    <tr>
                                        <td>
                                            <img src="{{$Image}}" width ="42" height="42" >
                                        </td>
                                        <td> {{$user_sold_lst->pay_id}} </td>
                                        <td> {{$user_sold_lst->name}} </td>
                                        <td> {{$user_sold_lst->price}} </td>
                                        <td> {{$user_sold_lst->name}} </td>
                                        <td> {{$user_sold_lst->phone}} </td>

                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="modal fade"  tabindex="-1"   id="contactModal"  role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">বিস্তারিত</h4>
                                </div>
                                <div class="modal-body">
                                    <div id="modalRes">

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="divform" style="display:none;">
                        {{ Form::open(array('url' => 'insertUser',  'method' => 'post','enctype'=>'multipart/form-data')) }}
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name" >নাম</label>
                                <input type="text" class="form-control name" name="name" placeholder="নাম"  required>
                            </div>
                            <div class="form-group">
                                <label for="name" >ই-মেইল</label>
                                <input type="email" class="form-control email" name="email" placeholder="ই-মেইল"  required>
                            </div>
                            <div class="form-group">
                                <label for="phone" >ফোন </label>
                                <input type="tel" class="form-control phone" name="phone" placeholder="ফোন নম্বর" pattern="\+?(88)?0?1[3456789][0-9]{8}\b"  required>
                            </div>
                            <div class="form-group">
                                <label for="password" >পাসওয়ার্ড</label>
                                <input type="password" class="form-control password" name="password" placeholder="পাসওয়ার্ড"  required >
                            </div>
                            <div class="form-group">
                                <label for="div_name" >লিঙ্গ</label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender"  id="male" value="M" required> পুরুষ
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" id="female" value="F">মহিলা
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="div_name">বিভাগ</label>
                                <select id="div_name" name ="div_id"  class="form-control select2 div_name" style="width: 100%;" required="required">
                                    <option value="" selected>বিভাগ নির্বাচন করুন</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="div_name" >বসবাস</label>
                                <label class="radio-inline">
                                    <input type="radio" name="addressGroup"  id="zillaGroup" value="1" required> জেলা
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="addressGroup" id="cityGroup" value="2">সিটি
                                </label>
                            </div>
                            <div id= "zillaGroupId" style="display: none;">
                                <div class="form-group">
                                    <label for="dis_name" >জেলা</label>
                                    <select id="dis_name" name ="disid" class="form-control select2 dis_name" style="width: 100%;" required="required">
                                        <option  value="" selected>জেলা  নির্বাচন করুন</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="upz_name" >উপজেলা</label>
                                    <select id="upz_name" name ="upzid" class="form-control select2 upz_name" style="width: 100%;" required="required">
                                        <option value="" selected>উপজেলা  নির্বাচন করুন</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="uni_name" >ইউনিয়ন</label>
                                    <select id="uni_name" name ="uniid" class="form-control select2 uni_name" style="width: 100%;" required="required">
                                        <option value="" selected>ইউনিয়ন  নির্বাচন করুন</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="ward_name" >ওয়ার্ড</label>
                                    <select id="ward_name" name ="wardid" class="form-control select2 ward_name" style="width: 100%;" required="required">
                                        <option value="" selected>ওয়ার্ড  নির্বাচন করুন</option>
                                    </select>
                                </div>
                            </div>
                            <div id= "cityGroupId" style="display: none;">
                                <div class="form-group">
                                    <label for="c_dis_name" >সিটি</label>
                                    <select id="c_dis_name" name ="c_disid" class="form-control select2 city_name" style="width: 100%;" required="required">
                                        <option  value="" selected>সিটি  নির্বাচন করুন</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="c_upz_name" >সিটি - কর্পোরেশন</label>
                                    <select id="c_upz_name" name ="c_upzid" class="form-control select2 co_name"  style="width: 100%;" required="required">
                                        <option value="" selected>সিটি - কর্পোরেশন  নির্বাচন করুন</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="c_uni_name" >থানা</label>
                                    <select id="c_uni_name" name ="c_uniid" class="form-control select2 thana_name" style="width: 100%;" required="required">
                                        <option value="" selected>থানা  নির্বাচন করুন</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="c_ward_name" >ওয়ার্ড</label>
                                    <select id="c_ward_name" name ="c_wardid" class="form-control select2 c_ward_name" style="width: 100%;" required="required">
                                        <option value="" selected>ওয়ার্ড  নির্বাচন করুন</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address" >ঠিকানা</label>
                                <input type="text" class="form-control address" name="address" placeholder="ঠিকানা"  required>
                            </div>
                            <div class="form-group">
                                <label for="type" >সদস্য ধরন</label>
                                <select id="type" name ="user_type" class="form-control select2 type" style="width: 100%;" required>
                                    <option value=""selected>সদস্য ধরন   নির্বাচন করুন </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="type" >ছবি</label>
                                <input type="file" class="form-control type" accept="image/*" name="user_photo" placeholder="ছবি">
                            </div>
                            <div class="photoId" style="display: none;">
                                <div class="form-group">
                                    <label for="address" >এন আইডি নম্বর</label>
                                    <input type="text" class="form-control nid" name="nid" placeholder="এন আইডি নম্বর">
                                </div>
                            </div>

                        </div>
                        <div class="box-footer">
                            <input type="hidden" name="id" id="id" class="id">
                            <button type="submit" class="btn btn-primary">সেভ করুন</button>
                        </div>
                        {{ Form::close() }}
                    </div>

                    <div class="box-header with-border">
                        <h4 class="box-title"><i class="fa fa-calendar"></i> <b>আপনার ট্রাঞ্জেকশন লিস্ট দেখুন</b></h4>
                        <div class="box-body table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>তারিখ</th>
                                    <th>অর্ডার নং</th>
                                    <th>পরিমান</th>
                                    <th>অবস্থা</th>
                                    <th>দায়িত্ত্ব</th>
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
                                    if(Cookie::get('user_type') == 3) {
                                        $user_cart= DB::table('v_assign')
                                            ->where('user_id', $id)
                                            ->orderBy('sales_date','desc')
                                            ->get();
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
                                        if(isset($dealer->id))
                                            $dealer_id= $dealer->id;
                                        else
                                            $dealer_id= "";
                                        foreach($user_cart as $row){
                                            $stmt2= DB::table('details')
                                                ->join('products', 'products.id', '=', 'details.product_id')
                                                ->join('product_assign','product_assign.product_id', '=','products.id')
                                                ->where('product_assign.dealer_id',$dealer_id)
                                                ->where('details.sales_id', $row->id)
                                                ->orderBy('products.id','Asc')
                                                ->get();
                                            $total = 0;
                                            foreach($stmt2 as $row2){
                                                if($row2->quantity>101) {
                                                    $quantity = $row2->quantity/1000;
                                                }
                                                else{
                                                    $quantity = $row2->quantity;
                                                }
                                                $subtotal = $row2->edit_price*$quantity;
                                                $total += $subtotal;
                                            }
                                            $stmt1= DB::table('users')
                                                ->where('id', $row->v_id)
                                                ->get();
                                            $delivery_man= DB::table('users')
                                                ->where('id', $row->v_id)
                                                ->first();
                                            if( $stmt1->count()>0 ) {
                                                $name = $delivery_man->name;
                                                $phone= $delivery_man->phone;
                                            }
                                            else {
                                                $name =  "Not Assigned" ;
                                                $phone="";
                                            }
                                            $status ="";
                                            if($row->v_status ==0) $status = "Processing";
                                            if($row->v_status ==2) $status = "Assigned";
                                            if($row->v_status ==3) $status = "On the service";
                                            if($row->v_status ==4) $status = "Delivered";
                                            echo "
                                                <tr>
                                                    <td class='hidden'></td>
                                                    <td>".date('M d, Y', strtotime($row->sales_date))."</td>
                                                    <td>".$row->pay_id."</td>
                                                    <td>".en2bn(number_format($total+$delivery_charge, 2))."</td>
                                                    <td>".$status."</td>
                                                    <td><center><a href='tel:". $phone."'><button type='button' class='btn allButton '>".$name." </button></a></center></td>
                                                    <td><button class='btn allButton transact' data-id='".$row->id."'><i class='fa fa-search'></i> বিস্তারিত</button></td>
                                                </tr>
                                            ";
                                        }
                                    }
                                    if(Cookie::get('user_type') == 5 || Cookie::get('user_type') == 6){
                                        $user_cart= DB::table('v_assign')
                                            ->where('v_id', $id)
                                            ->orderBy('sales_date','desc')
                                            ->get();
                                        //dd($user_cart);
                                        $user_cart= DB::table('v_assign')
                                            ->where('user_id', $id)
                                            ->orderBy('sales_date','desc')
                                            ->get();
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
                                        if(isset($dealer->id))
                                            $dealer_id= $dealer->id;
                                        else
                                            $dealer_id= "";
                                        //dd($dealer_id);
                                        foreach($user_cart as $row){
                                            $stmt2= DB::table('details')
                                                ->join('products', 'products.id', '=', 'details.product_id')
                                                ->join('product_assign','product_assign.product_id', '=','products.id')
                                                ->where('product_assign.dealer_id',$dealer_id)
                                                ->where('details.sales_id', $row->id)
                                                ->orderBy('products.id','Asc')
                                                ->get();
                                            $total = 0;
                                            foreach($stmt2 as $row2){
                                                if($row2->quantity>101) {
                                                    $quantity = $row2->quantity/1000;
                                                }
                                                else{
                                                    $quantity = $row2->quantity;
                                                }
                                                $subtotal = $row2->edit_price*$quantity;
                                                $total += $subtotal;
                                            }
                                            $stmt1= DB::table('users')
                                                ->where('id', $row->v_id)
                                                ->get();
                                            $delivery_man= DB::table('users')
                                                ->where('id', $row->v_id)
                                                ->first();
                                            if( $stmt1->count()>0 ) {
                                                $name = $delivery_man->name;
                                                $phone= $delivery_man->phone;
                                            }
                                            else {
                                                $name =  "Not Assigned" ;
                                                $phone="";
                                            }
                                            $status ="";
                                            if($row->v_status ==0) $status = "Processing";
                                            if($row->v_status ==2) $status = "Assigned";
                                            if($row->v_status ==3) $status = "On the service";
                                            if($row->v_status ==4) $status = "Delivered";
                                            echo "
                                                <tr>
                                                    <td class='hidden'></td>
                                                    <td>".date('M d, Y', strtotime($row->sales_date))."</td>
                                                    <td>".$row->pay_id."</td>
                                                    <td>".en2bn(number_format($total+$delivery_charge, 2))."</td>
                                                    <td>".$status."</td>
                                                    <td><center><a href='tel:". $phone."'><button type='button' class='btn allButton'>".$name." </button></a></center></td>
                                                    <td><button class='btn allButton transact' data-id='".$row->id."'><i class='fa fa-search'></i> বিস্তারিত</button></td>
                                                </tr>
                                            ";
                                        }
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                        @if(Cookie::get('user_type') == 3)
                    <div class="box-header with-border">
                        <h4 class="box-title"><i class="fa fa-calendar"></i> <b>আপনার পশু ট্রাঞ্জেকশন লিস্ট দেখুন</b></h4>
                        <div class="box-body table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>তারিখ</th>
                                    <th>অর্ডার নং</th>
                                    <th>নাম</th>
                                    <th>দাম</th>
                                    <th>মালিক</th>
                                    <th>ফোন</th>
                                </tr>

                                @foreach($users['animal_buy_info'] as $user_buy_lst)

                                    <?php
                                    $Image =url('/')."/public/asset/images/noImage.jpg";
                                    if(!empty($user_buy_lst->salPPhoto)){
                                        $Image =url('/').'/'.$user_buy_lst->salPPhoto;
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <img src="{{$Image}}" width ="42" height="42" >
                                        </td>
                                        <td> {{$user_buy_lst->pay_id}} </td>
                                        <td> {{$user_buy_lst->salName}} </td>
                                        <td> {{$user_buy_lst->price}} </td>
                                        <td> {{$user_buy_lst->name}} </td>
                                        <td> {{$user_buy_lst->phone}} </td>

                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                        @endif

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
    </div>
@endsection
@section('js')
    <script src="public/asset/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>

    $(function(){
        $(document).on('click', '.search', function(e){
            e.preventDefault();
            $('#contactModal').modal('show');
            var id = $(this).data('id');
            getRowDetails(id);
        });
    });
    function getRowDetails(id){
        $.ajax({
            type: 'POST',
            url: 'getSaleProductsDetails',
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id
            },
            dataType: 'json',
            success: function(response){
                var data = response.data;
                $('#modalRes').html(data.description);
            }
        });
    }

    $(function(){
        $('.textarea').wysihtml5();
        $(document).on('click', '.transact', function(e){
            e.preventDefault();
            $('#transaction').modal('show');
            var id = $(this).data('id');
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
    function getRow(id){
        $.ajax({
            type: 'POST',
            url: 'getUserList',
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id
            },
            dataType: 'json',
            success: function(response){
                var data = response.data;
                $('.name').val(data[0]['name']);
                $('.phone').val(data[0]['phone']);
                $('.email').val(data[0]['email']);
                $('.password').val('*******************');
                $('.address').val(data[0]['address']);
                $('.id').val(data[0]['id']);
                $('.nid').val(data[0]['nid']);
            }
        });
    }
    $(document).ready(function(){
        $(".edit").click(function(){
            $('.divform').show();
            var id = $(this).data('id');
            getRow(id);
        });
        $("#zillaGroup").click(function(){
            $("#zillaGroupId").show();
            $("#cityGroupId").hide();
            $('.city_name').prop('required',false);
            $('.co_name').prop('required',false);
            $('.thana_name').prop('required',false);
            $('.c_ward_name').prop('required',false);
        });
        $("#cityGroup").click(function(){
            $("#zillaGroupId").hide();
            $("#cityGroupId").show();
            $('.dis_name').prop('required',false);
            $('.upz_name').prop('required',false);
            $('.uni_name').prop('required',false);
            $('.ward_name').prop('required',false);
        });
        $.ajax({
            url: 'getAllSaleCategory',
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                var data = response.data;
                var len = data.length;
                for( var i = 0; i<len; i++){
                    var id = data[i]['id'];
                    var name = data[i]['name'];
                    $(".cat_type").append("<option value='"+id+"'>"+name+"</option>");
                }

            },
            failure: function (msg) {
                alert('an error occured');
            }
        });
        $.ajax({
            url: 'getAllDivision',
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                var data = response.data;
                var len = data.length;
                for( var i = 0; i<len; i++){
                    var id = data[i]['id'];
                    var name = data[i]['name'];
                    $(".div_name").append("<option value='"+id+"'>"+name+"</option>");
                }

            },
            failure: function (msg) {
                alert('an error occured');
            }
        });
        $.ajax({
            url: 'getAllUserTypeSignUp',
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                var data = response.data;
                var len = data.length;
                for( var i = 0; i<len; i++){
                    var id = data[i]['id'];
                    var name = data[i]['name'];
                    $(".type").append("<option value='"+id+"'>"+name+"</option>");
                }

            },
            failure: function (msg) {
                alert('an error occured');
            }
        });
        $(".div_name").change(function(){
            var id =$(this).val();
            $('.dis_name').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getDistrictListAll',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".dis_name").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".dis_name").change(function(){
            var id =$(this).val();
            $('.upz_name').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getUpazillaListAll',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".upz_name").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".upz_name").change(function(){
            var id =$(this).val();
            $('.uni_name').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getUnionListAll',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".uni_name").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".uni_name").change(function(){
            var id =$(this).val();
            $('.ward_name').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getWardListAll',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".ward_name").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".div_name").change(function(){
            var id =$(this).val();
            $('.city_name').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getCityListAll',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".city_name").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".city_name").change(function(){
            var id =$(this).val();
            $('.co_name').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getCityCorporationListAll',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".co_name").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".co_name").change(function(){
            var id =$(this).val();
            $('.thana_name').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getThanaListAll',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".thana_name").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".thana_name").change(function(){
            var id =$(this).val();
            $('.c_ward_name').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getC_wardListAll',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".c_ward_name").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".type").change(function(){
            var id =$(this).val();
            if(id== 5 || id==6 || id==7){
                $(".photoId").show();
            }
            else{
                $(".photoId").hide();
                $('.nid').prop('required',false);
            }

        });
        $(".w_status").change(function(){
            var id =$(this).val();
            $.ajax({
                type: 'GET',
                url: 'changeWorkingStatus',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    location.reload();

                }
            });
        });
        $('.select2').select2();


    })
</script>
@endsection
