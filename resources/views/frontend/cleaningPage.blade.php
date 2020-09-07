@extends('frontend.frontLayout')
@section('title', 'ক্লিনিং')
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
    {{ Form::open(array('url' => 'cleaningBookingFront',  'method' => 'post')) }}
    {{ csrf_field() }}
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <select class="form-control select2 type" id="type" name="type" style="width: 100%;" required>
                    <option value="" selected>ক্লিনিং  ধরণ  নির্বাচন করুন</option>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <select class="form-control select2 size" id="size" name="size" style="width: 100%;" required>
                    <option value="" selected> সাইজ ধরণ নির্বাচন করুন</option>
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
                url: 'getAllCleaningTypeFront',
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
            $('.size').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getCleaningSizeFront',
                data: {type:type},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['size'];
                        var name = data[i]['size'];
                        $(".size").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".size").change(function(){
            var size = $(this).val();
            var type = $("#type").val();
            $.ajax({
                type: 'GET',
                url: 'getCleaningPriceFront',
                data: {size:size,type:type},
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
