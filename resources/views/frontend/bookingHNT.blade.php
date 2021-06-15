@extends('frontend.frontLayout')
@section('title', 'এপয়েনমেন্ট')
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
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body cardBody">
                    <div class="col-sm-12">
                        <h3 class="card-title">{{"এপয়েনমেন্ট ফর্ম পুরন করুন" }}</h3>
                        {{ Form::open(array('url' => 'insertBookingHNTPayment',  'method' => 'post')) }}
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="number" class="form-control number" name="number" id="number" placeholder="রুম সংখ্যা" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control startDate" name="startDate" id="startDate" placeholder="চেক ইন " required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control endDate" name="endDate" id="endDate" placeholder="চেক আউট" required>
                        </div>

                        <div class="priceDiv">

                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="cod">
                            <label class="form-check-label" for="flexCheckDefault">
                                Cash on Presence
                            </label>
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="time" value="" required>
                        </div>
                        @if(Cookie::get('user_id'))
                            <div class="form-group">
                                <input type="hidden" name="name_id" value="{{$_GET['name_id']}}">
                                <input type="hidden" name="main_id" value="{{$_GET['id']}}">
                                <input type="hidden" name="price" id="price" value="">
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
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $( function() {
            $('#startDate').datepicker({
                autoclose: true,
                minDate:0,
                dateFormat: "yy-m-dd",
            })

        } );
        $( function() {
            $('#endDate').datepicker({
                autoclose: true,
                minDate:0,
                dateFormat: "yy-m-dd",
            })

        } );
        $(".endDate,.startDate,.number").change(function(){
            var id =$('#number').val();
            var d_id = {{$_GET['id']}};
            var name_id = {{$_GET['name_id']}};
            var start= $("#startDate").datepicker("getDate");
            var end= $("#endDate").datepicker("getDate");
            days = (end- start) / (1000 * 60 * 60 * 24);
            $.ajax({
                type: 'GET',
                url: 'getHNTPrice',
                data: {id:id, d_id:d_id,days:days},
                dataType: 'json',
                success: function(response){
                    $('.priceDiv').html("বুকিং প্রাইসঃ "+ response.data+" টাকা");
                    $('#price').val(response.data);
                }
            });
        });
    </script>
@endsection
