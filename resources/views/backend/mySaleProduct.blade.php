@extends('backend.layout')
@section('title', 'সেলার')
@section('page_header', 'সেলার ব্যবস্থাপনা')
@section('sellerForm','active')
@section('extracss')
    <link rel="stylesheet" href="public/asset/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
@endsection
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
                    <h3 class="box-title">লিস্ট </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>ছবি</th>
                            <th>নাম</th>
                            <th>তারিখ</th>
                            <th>অর্ডার নং</th>
                            <th>ফোন</th>
                            <th>ঠিকানা</th>
                            <th>দাম</th>
                        </tr>
                        <?php
                        use Illuminate\Support\Facades\DB;
                        ?>
                        @foreach($products as $product)
                            <?php
                                $Image =url('/')."/public/asset/images/noImage.jpg";
                                if(!empty($product->photo)){
                                    $Image =url('/').'/'.$product->photo;
                                }
                                $id = $product->buyer_id;
                                $user_info = DB::table('users')
                                    ->where('users.id', $id)
                                    ->where('users.status', 1)
                                    ->first();
                                if(!empty($user_info)) {
                                    $address_type = $user_info->address_type;
                                    if ($address_type == 1) {
                                        $buyer = DB::table('users')
                                            ->select('*', 'users.name as sellername','divisions.name as divname', 'districts.name as disname'
                                                , 'upazillas.name as upzname', 'unions.name as uniname', 'wards.name as wardsname')
                                            ->join('divisions', 'users.add_part1', '=', 'divisions.id')
                                            ->join('districts', 'users.add_part2', '=', 'districts.id')
                                            ->join('upazillas', 'users.add_part3', '=', 'upazillas.id')
                                            ->join('unions', 'users.add_part4', '=', 'unions.id')
                                            ->join('wards', 'users.add_part5', '=', 'wards.id')
                                            ->where('users.id',$id)
                                            ->first();
                                    }
                                    if ($address_type == 2) {
                                        $buyer = DB::table('users')
                                            ->select('*', 'users.name as sellername','divisions.name as divname', 'cities.name as disname'
                                                , 'city_corporations.name as upzname', 'thanas.name as uniname', 'c_wards.name as wardsname')
                                            ->join('divisions', 'users.add_part1', '=', 'divisions.id')
                                            ->join('cities', 'users.add_part2', '=', 'cities.id')
                                            ->join('city_corporations', 'users.add_part3', '=', 'city_corporations.id')
                                            ->join('thanas', 'users.add_part4', '=', 'thanas.id')
                                            ->join('c_wards', 'users.add_part5', '=', 'c_wards.id')
                                            ->where('users.id',$id)
                                            ->first();
                                    }
                                }
                            ?>
                            <tr>
                                <td><img src="{{$Image}}" height="42" width="42">  </td>
                                <td> {{$product->name}} </td>
                                <td> {{$product->date}} </td>
                                <td> {{$product->pay_id}} </td>
                                <td> {{$buyer->phone}} </td>
                                <td> {{$buyer->divname.' ,'.$buyer->disname.' ,'.$buyer->upzname.' ,'.$buyer->uniname.' ,'.$buyer->wardsname.' ,'.$buyer->address}} </td>
                                <td> {{$product->price}} </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $products->links() }}

                </div>
            </div>

        </div>
    </div>
@endsection
@section('js')
    <script>

    </script>
@endsection
