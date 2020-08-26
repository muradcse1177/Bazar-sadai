@extends('frontend.frontLayout')
@section('title', 'বাজার লিস্ট')
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
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">আপনার বাজার লিস্ট </h3>
                </div>
                <!-- /.box-header -->
                <?php
                        function en2bn($number) {
                            $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
                            $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
                            $bn_number = str_replace($search_array, $replace_array, $number);
                            return $bn_number;
                        }
                        ?>
                @php
                    $Image =url('/')."/public/asset/images/noImage.jpg";
                       if(!empty($products->photo))
                           $Image =url('/').'/'.$products->photo;
                @endphp
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>ছবি</th>
                            <th>নাম</th>
                            <th>ওজন</th>
                            <th>জাত</th>
                            <th>ঠিকানা</th>
                            <th>দাম </th>
                        </thead>
                       <tr>
                            <td> <img src="{{$Image}}" width ="45" height="45" ></td>
                            <td>{{$products->name}}</td>
                            <td>{{en2bn($products->weight)}}</td>
                            <td>{{$products->jat}}</td>
                            <td>{{$products->address}}</td>
                            <td>{{en2bn($products->price)}}</td>
                       </tr>

                    </table>
                    <?php

                    if(Cookie::get('user') != null) {?>
                    <h4><a href='{{url('animalSales/'.$products->id)}}'>
                            <button type='button' class='btn btn-primary active'>অর্ডার প্লেস করুন</button></a></h4>
                    <?php }

                    else {
                    if(Cookie::get('user') != null){ ?>
                    <h4><a href='{{url('animalSales/'.$products->id)}}'><button type='button' class='btn btn-primary active'>অর্ডার প্লেস করুন</button></a></h4>
                    <?php  }

                    else{?>
                    <h4> আপনার অর্ডার সম্পন্ন্য করতে   <a href='{{url('login')}}'>
                            <button type='button' class='btn btn-primary active'>লগ ইন</button></a> করুন</h4>
                    <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade"  tabindex="-1"   id="deliveryPlace"  role="dialog">
        <div class="modal-dialog modal-medium">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">আপনি কোথায় ডেলিভারি চান? অথবা ইগনোর করুন।</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(array('url' => 'deliveryAddress',  'method' => 'post')) }}
                    {{ csrf_field() }}
                    <input type="text" name="delAdd" class="form-control" placeholder="ডেলিভারি ঠিকানা লিখুন" required>
                    <input type="hidden" name="proId" value="{{$id}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">সেভ করুন</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $(window).on('load',function(){
            $('#deliveryPlace').modal('show');
        });
    </script>
@endsection
