@extends('frontend.frontLayout')
@section('title', 'কুকিং')
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
    {{ Form::open(array('url' => 'cookingBookingFront',  'method' => 'post')) }}
    {{ csrf_field() }}
    <div class="row">
        <div class="card">
            <div class="card-body cardBody">
                <h5 style="text-align: center;"><b>আপনার পছন্দের কুকার খুজে নিন।</b></h5>
                <div class="col-sm-12">
                    <div class="form-group">
                        <select class="form-control select2 cooking_type" id="cooking_type" name="cooking_type" style="width: 100%;" required>
                            <option value="" selected> কুকিং ধরণ  নির্বাচন করুন</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <input type="number" class="form-control days" id="days" name="days" min="1" placeholder="কত দিন" required>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <select class="form-control select2 meal" id="meal" name="meal" style="width: 100%;" required>
                            <option value="" selected> মিল ধরণ নির্বাচন করুন</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <select class="form-control select2 person" id="person" name="person" style="width: 100%;" required>
                            <option value="" selected> জন নির্বাচন করুন</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <select class="form-control select2 time" id="time" name="time" style="width: 100%;" required>
                            <option value="" selected> সময় নির্বাচন করুন</option>
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
                url: 'getAllCookingType',
                type: "GET",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['cooking_type'];
                        var name = data[i]['cooking_type'];
                        $(".cooking_type").append("<option value='"+id+"'>"+name+"</option>");
                    }

                },
                failure: function (msg) {
                    alert('an error occured');
                }
            });
        });
        $(".cooking_type").change(function(){
            var id =$(this).val();
            if(id =='মাসিক'){
                $(".days").hide();
                $('.days').prop('required',false);
            }
            else{
                $(".days").show();
                $('.days').prop('required',true);
            }
            $('.meal').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getMealTypeFront',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['meal'];
                        var name = data[i]['meal'];
                        $(".meal").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".meal").change(function(){
            var meal =$(this).val();
            var cooking_type =$("#cooking_type").val();
            $('.person').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getMealPersonFront',
                data: {meal:meal,cooking_type:cooking_type},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['person'];
                        var name = data[i]['person'];
                        $(".person").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".person").change(function(){
            var person =$(this).val();
            var meal =$('#meal').val();
            var cooking_type =$("#cooking_type").val();
            $('.time').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getMealTimeFront',
                data: {person:person,meal:meal,cooking_type:cooking_type},
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
            var person =$("#person").val();
            var meal =$('#meal').val();
            var cooking_type =$("#cooking_type").val();
            $.ajax({
                type: 'GET',
                url: 'getMealPriceFront',
                data: {time:time,person:person,meal:meal,cooking_type:cooking_type},
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
            var person =$("#person").val();
            var meal =$('#meal').val();
            var cooking_type =$("#cooking_type").val();
            $.ajax({
                type: 'GET',
                url: 'getMealPriceFront',
                data: {time:time,person:person,meal:meal,cooking_type:cooking_type},
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
