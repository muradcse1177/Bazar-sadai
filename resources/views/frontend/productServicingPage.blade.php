@extends('frontend.frontLayout')
@section('title', 'পণ্য সেবা')
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
    {{ Form::open(array('url' => 'productServicingBookingFront',  'method' => 'post')) }}
    {{ csrf_field() }}
    <div class="row">
        <div class="card">
            <div class="card-body cardBody">
                <h5 style="text-align: center;"><b>আপনার পছন্দের পণ্য সার্ভিসিং খুজে নিন।</b></h5>
                <div class="col-sm-12">
                    <div class="form-group">
                        <select class="form-control select2 type" id="type" name="type" style="width: 100%;" required>
                            <option value="" selected> পণ্য  ধরণ  নির্বাচন করুন</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <select class="form-control select2 name" id="name" name="name" style="width: 100%;" required>
                            <option value="" selected>সার্ভিস নির্বাচন করুন</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <h4 style="display: none;" class="price"> </h4>
                    </div>
                </div>
                <div class="col-sm-12">
                    @if(Cookie::get('user_id'))
                        <div class="form-group">
                            <button type="submit" class="btn allButton">বুকিং করুন</button>
                        </div>
                    @endif
                    @if(Cookie::get('user_id') == null )
                        <div class="form-group">
                            <a href='{{url('login')}}'  class="btn allButton">লগ ইন করুন</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection
@section('js')
    <script>
        $('.select2').select2();
        $(document).ready(function(){
            $.ajax({
                url: 'getAllProductServiceTypeFront',
                type: "GET",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['type'];
                        var name = data[i]['type'];
                        $(".type").append("<option value='"+id+"'>"+name+"</option>");
                    }

                },
                failure: function (msg) {
                    alert('an error occured');
                }
            });
        });
        $(".type").change(function(){
            var type =$(this).val();
            $('.name').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getProductServiceNameTimeFront',
                data: {type:type},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['name'];
                        var name = data[i]['name'];
                        $(".name").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".name").change(function(){
            var name = $(this).val();
            var type = $("#type").val();
            $.ajax({
                type: 'GET',
                url: 'getProductServicePriceFront',
                data: {name:name,type:type},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    $(".price").html('Price: '+ data.price +' tk');
                    $(".price").show();
                }
            });
        });
    </script>
@endsection
