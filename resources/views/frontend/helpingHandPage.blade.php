@extends('frontend.frontLayout')
@section('title', 'কাজে সহযোগিতা')
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
    {{ Form::open(array('url' => 'helpingHandBookingFront',  'method' => 'post')) }}
    {{ csrf_field() }}
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <select class="form-control select2 type" id="type" name="type" style="width: 100%;" required>
                    <option value="" selected> ধরণ  নির্বাচন করুন</option>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <input type="number" name="days" id="days" class="form-control days" placeholder="কয় দিন" min="1" required>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <select class="form-control select2 time" id="time" name="time" style="width: 100%;" required>
                    <option value="" selected>ঘন্টা নির্বাচন করুন</option>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <h4 style="display: none;" class="price"> </h4>
            </div>
        </div>
        <div class="col-sm-4">
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
            {{ Form::close() }}
        </div>
    </div>
    {{ Form::close() }}
@endsection
@section('js')
    <script>
        $('.select2').select2();
        $(document).ready(function(){
            $.ajax({
                url: 'getAllHelpingHandTypeFront',
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
            if(type =='মাসিক'){
                $(".days").hide();
                $('.days').prop('required',false);
            }
            else{
                $(".days").show();
                $('.days').prop('required',true);
            }
            $('.time').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getHelpingTimeFront',
                data: {type:type},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['time'];
                        var name = data[i]['time'];
                        $(".time").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".time").change(function(){
            var time = $(this).val();
            var type = $("#type").val();
            $.ajax({
                type: 'GET',
                url: 'getHelpingPriceFront',
                data: {time:time,type:type},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var days =$("#days").val();
                    if(days<=0) days=1;
                    $(".price").html('Price: '+ data.price*days +' tk');
                    $(".price").show();
                }
            });
        });
        $(".days").change(function(){
            var days = $(this).val();
            var time = $("#time").val();
            var type = $("#type").val();
            $.ajax({
                type: 'GET',
                url: 'getHelpingPriceFront',
                data: {time:time,type:type},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    if(days<=0) days=1;
                    $(".price").html('Price: '+ data.price*days +' tk');
                    $(".price").show();
                }
            });
        });
    </script>
@endsection
