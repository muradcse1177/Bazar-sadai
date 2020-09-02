@extends('backend.layout')
@section('title', 'বিক্রয় রিপোর্ট')
@section('page_header', 'বিক্রয় রিপোর্ট ব্যবস্থাপনা')
@section('aniSalesLiAdd','active')
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
                            <th>ছবি</th>
                            <th>তারিখ</th>
                            <th>পশুর নাম</th>
                            <th>অর্ডার নং</th>
                            <th>ক্রেতার নাম</th>
                            <th>ক্রেতার ফোন</th>
                            <th>বিক্রেতার নাম</th>
                            <th>বিক্রেতার ফোন</th>
                            <th>দাম</th>
                            <th>ডেলিভারি ঠিকানা </th>
                        </tr>

                        @foreach($aminal_Sales as $aminal_Sale)
                            @php
                                $Image =url('/')."/public/asset/images/noImage.jpg";
                                   if(!empty($aminal_Sale->salPPhoto))
                                       $Image =url('/').'/'.$aminal_Sale->salPPhoto;
                            @endphp
                            <tr>
                                <td> <img src="{{$Image}}" width ="45" height="45" ></td>
                                <td> {{$aminal_Sale-> date}} </td>
                                <td> {{$aminal_Sale->salName}} </td>
                                <td> {{$aminal_Sale->pay_id}} </td>
                                <td> {{$aminal_Sale->name}} </td>
                                <td> {{$aminal_Sale->sellerPhone}} </td>
                                <td> {{$aminal_Sale->buyerName}} </td>
                                <td> {{$aminal_Sale->buyerPhone}} </td>
                                <td> {{$aminal_Sale->price}} </td>
                                <td> {{$aminal_Sale->delivery_address}} </td>

                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('js')
    <script>

    </script>
@endsection
