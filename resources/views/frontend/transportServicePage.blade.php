@extends('frontend.frontLayout')
@section('title', 'সেবাসমুহ')
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
    {{ Form::open(array('url' => 'insertTransport',  'method' => 'post')) }}
    {{ csrf_field() }}
    <div class="row">
        <div class="transportTypeGroup">
           <center>
                <input class="form-check-input" type="radio" name="type" id="transport" value="transport">
                <label class="form-check-label" for="gridRadios1">
                    পরিবহন
                </label>&nbsp;&nbsp;
                <input class="form-check-input" type="radio" name="type" id="ticket" value="ticket">
                <label class="form-check-label" for="gridRadios2">
                     টিকেট
                </label>
           </center>
        </div>
        <div class="paribahanGroup" style="display: none;">
           <center>
                <input class="form-check-input" type="radio" name="paribahanGroup" id="motor" value="motor" >
                <label class="form-check-label" for="gridRadios1">
                    মোটর সাইকেল
                </label>&nbsp;&nbsp;
                <input class="form-check-input" type="radio" name="paribahanGroup" id="private" value="private">
                <label class="form-check-label" for="gridRadios2">
                      প্রাইভেট কার
                </label>&nbsp;&nbsp;
                <input class="form-check-input" type="radio" name="paribahanGroup" id="micro" value="micro">
                <label class="form-check-label" for="gridRadios2">
                     মাইক্রো বাস
                </label>&nbsp;&nbsp;
                <input class="form-check-input" type="radio" name="paribahanGroup" id="ambulance" value="ambulance">
                <label class="form-check-label" for="gridRadios2">
                    এম্বুলেন্স
                </label>
           </center>
        </div>
        <div class="ticketGroup" style="display: none;">
           <center>
                <input class="form-check-input ticketGroup1" type="radio" name="ticketGroup" id="bus" value="1">
                <label class="form-check-label" for="gridRadios1">
                    বাস টিকেট
                </label>&nbsp;&nbsp;
                <input class="form-check-input ticketGroup1" type="radio" name="ticketGroup" id="train" value="2">
                <label class="form-check-label" for="gridRadios2">
                     ট্রেন টিকেট
                </label>&nbsp;&nbsp;
                <input class="form-check-input ticketGroup1" type="radio" name="ticketGroup" id="air" value="3">
                <label class="form-check-label" for="gridRadios2">
                     এয়ার টিকেট
                </label>&nbsp;&nbsp;
                <input class="form-check-input ticketGroup1" type="radio" name="ticketGroup" id="launch" value="4">
                <label class="form-check-label" for="gridRadios2">
                     লঞ্চ টিকেট
                </label>
           </center>
        </div>
        <div class="formTicket" style="display: none;">
            <div class="col-sm-4">
                <div class="form-group">
                    <select class="form-control select2 from_address" id="from_address" name="from_address" style="width: 100%;" required>
                        <option value="" selected>কোথা থেকে যাবেন </option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <select class="form-control select2 to_address" id="to_address" name="to_address" style="width: 100%;" required>
                        <option value="" selected>কোথায় যাবেন</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input type="number" min="1" class="form-control adult" name="adult" id="adult" placeholder="কত জন" required>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input type="text" class="form-control" name="date" id="date" placeholder="কত তারিখ" readonly value="{{date("Y-m-d")}}">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <select class="form-control select2 transportName" id="transportName" name="transportName" style="width: 100%;" required>
                        <option  value="" selected> যানবহন নির্বাচন করুন</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <select class="form-control select2 transportType" id="transportType" name="transportType" style="width: 100%;" required>
                        <option  value="" selected> ধরণ নির্বাচন করুন</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <select class="form-control select2 transportTime" name="transportTime" id="transportTime" style="width: 100%;" required>
                        <option  value="" selected> সময় নির্বাচন করুন</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4" >
                <h4 class="price" id="price" style="display: none;"> </h4>
            </div>
            <div class="submitClass" style="display: none;">
                @if(Cookie::get('user_id'))
                    <div class="col-sm-4">
                        <div class="form-group">
                            <button type="submit" class="btn allButton">অর্ডার করুন</button>
                        </div>
                    </div>
                @endif
                @if(Cookie::get('user_id') == null )
                    <div class="col-sm-4">
                        <div class="form-group">
                            <a href='{{url('login')}}'  class="btn allButton">লগ ইন করুন</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
    {{ Form::close() }}
@endsection
@section('js')
    <script>
        $('.select2').select2();
        $("#transport").click(function(){
            $(".paribahanGroup").show();
            $(".ticketGroup").hide();
            $(".formTicket").hide();
        });
        $("#ticket").click(function(){
            $(".ticketGroup").show();
            $(".paribahanGroup").hide();
        });
        $("#bus").click(function(){
            $(".formTicket").show();
            $(".submitClass").show();
        });
        $("#train").click(function(){
            $(".formTicket").show();
            $(".submitClass").show();
        });
        $("#air").click(function(){
            $(".formTicket").show();
            $(".submitClass").show();
        });
        $("#launch").click(function(){
            $(".formTicket").show();
            $(".submitClass").show();
        });
        $( function() {
            $('#date').datepicker({
                autoclose: true,
                minDate:0,
                dateFormat: "yy-m-dd",
            })

        } );
        $(".ticketGroup1").change(function(){
            var id =  $('input[name="ticketGroup"]:checked').val();
            $('.from_address').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getAllFromAddressById',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['from_address'];
                        var name = data[i]['from_address'];
                        $(".from_address").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".from_address").change(function(){
            var id =$(this).val();
            var transport_id =  $('input[name="ticketGroup"]:checked').val();
            $('.to_address').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getAllToAddress',
                data: {id:id,transport_id:transport_id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['to_address'];
                        var name = data[i]['to_address'];
                        $(".to_address").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".to_address").change(function(){
            var from_address = $('#from_address').find(":selected").text();
            var to_address = $('#to_address').find(":selected").text();
            var transport_id =  $('input[name="ticketGroup"]:checked').val();
            $('.transportName').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getAllTransport',
                data: {from_address:from_address,to_address:to_address,transport_id:transport_id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['coach_name'];
                        var name = data[i]['coach_name'];
                        $(".transportName").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".transportName").change(function(){
            var from_address = $('#from_address').find(":selected").text();
            var to_address = $('#to_address').find(":selected").text();
            var transportName = $('#transportName').find(":selected").text();
            var transport_id =  $('input[name="ticketGroup"]:checked').val();
            $('.transportType').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getAllTransportType',
                data: {from_address:from_address,to_address:to_address,transportName:transportName,transport_id:transport_id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['type'];
                        var name = data[i]['type'];
                        $(".transportType").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".transportType").change(function(){
            var from_address = $('#from_address').find(":selected").text();
            var to_address = $('#to_address').find(":selected").text();
            var transportName = $('#transportName').find(":selected").text();
            var transportType = $('#transportType').find(":selected").text();
            var transport_id =  $('input[name="ticketGroup"]:checked').val();
            $('.transportTime').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getAllTransportTime',
                data: {from_address:from_address,to_address:to_address,transportName:transportName,
                    transport_id:transport_id, transportType:transportType},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['time'];
                        var name = data[i]['time'];
                        $(".transportTime").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".transportTime").change(function(){
            var from_address = $('#from_address').find(":selected").text();
            var to_address = $('#to_address').find(":selected").text();
            var transportName = $('#transportName').find(":selected").text();
            var transportType = $('#transportType').find(":selected").text();
            var transportTime = $('#transportTime').find(":selected").text();
            var transport_id =  $('input[name="ticketGroup"]:checked').val();
            var adult = $('#adult').val();
            //$('.transportTime').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getTransportPrice',
                data: {from_address:from_address,to_address:to_address,transportName:transportName,
                    transport_id:transport_id,transportType:transportType,transportTime:transportTime,
                    adult:adult},
                dataType: 'json',
                success: function(response){
                    $("#price").css("display", "block");
                    $('#price').html("টিকেট প্রাইসঃ "+ response.data+" টাকা");

                }
            });
        });
    </script>
@endsection
