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
    {{ Form::open(array('url' => 'insertTicketPayment',  'method' => 'post')) }}
    {{ csrf_field() }}
    <div class="row">
        <div class="card">
            <div class="card-body cardBody">
                <h5 style="text-align: center;">সার্ভিস গ্রহন করার আগে আপনার সার্ভিস এরিয়া ঠিক করে নিন। অন্যথায় সঠিক এরিয়া সার্ভিস পাবেন না।</h5>
                <div class="serviceArea" style="text-align: center;">
                    @if(Cookie::get('user_id'))
                        <div class="form-group">
                            <a href="{{url('serviceArea')}}" type="submit" class="btn allButton">সার্ভিস এরিয়া</a>
                        </div>
                    @endif
                    @if(Cookie::get('user_id') == null )
                        <div class="form-group">
                            <a href='{{url('login')}}'  class="btn allButton">লগ ইন করুন</a>
                        </div>
                    @endif
                </div>
                <div class="transportTypeGroup">
                   <center>
                        <input class="form-check-input" type="radio" name="type" id="transport" value="transport">
                        <label class="form-check-label" for="transport">
                            পরিবহন
                        </label>&nbsp;&nbsp;
                        <input class="form-check-input" type="radio" name="type" id="ticket" value="ticket">
                        <label class="form-check-label" for="ticket">
                             টিকেট
                        </label>
                   </center>
                </div>
                <div class="paribahanGroup" style="display: none;">
                   <center>
                        <input class="form-check-input" type="radio" name="paribahanGroup" id="motor" value="motor" >
                        <label class="form-check-label" for="motor">
                            মোটর সাইকেল
                        </label>&nbsp;&nbsp;
                        <input class="form-check-input" type="radio" name="paribahanGroup" id="private" value="Private Car">
                        <label class="form-check-label" for="private">
                              প্রাইভেট কার
                        </label>&nbsp;&nbsp;
                        <input class="form-check-input" type="radio" name="paribahanGroup" id="micro" value="Micro Bus">
                        <label class="form-check-label" for="micro">
                             মাইক্রো বাস
                        </label>&nbsp;&nbsp;
                        <input class="form-check-input" type="radio" name="paribahanGroup" id="ambulance" value="Ambulance">
                        <label class="form-check-label" for="ambulance">
                            এম্বুলেন্স
                        </label>
                       <input class="form-check-input" type="radio" name="paribahanGroup" id="truck" value="Truck">
                        <label class="form-check-label" for="truck">
                            ট্রাক
                        </label>
                   </center>
                </div>
                <div class="ticketGroup" style="display: none;">
                   <center>
                        <input class="form-check-input ticketGroup1" type="radio" name="ticketGroup" id="bus" value="1">
                        <label class="form-check-label" for="bus">
                            বাস টিকেট
                        </label>&nbsp;&nbsp;
                        <input class="form-check-input ticketGroup1" type="radio" name="ticketGroup" id="train" value="2">
                        <label class="form-check-label" for="train">
                             ট্রেন টিকেট
                        </label>&nbsp;&nbsp;
                        <input class="form-check-input ticketGroup1" type="radio" name="ticketGroup" id="air" value="3">
                        <label class="form-check-label" for="air">
                             এয়ার টিকেট
                        </label>&nbsp;&nbsp;
                        <input class="form-check-input ticketGroup1" type="radio" name="ticketGroup" id="launch" value="4">
                        <label class="form-check-label" for="launch">
                             লঞ্চ টিকেট
                        </label>
                   </center>
                </div>
                <div class="formTicket" style="display: none;">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <select class="form-control select2 from_address" id="from_address" name="from_address" style="width: 100%;" required>
                                <option value="" selected>কোথা থেকে যাবেন </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <select class="form-control select2 to_address" id="to_address" name="to_address" style="width: 100%;" required>
                                <option value="" selected>কোথায় যাবেন</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <input type="number" min="1" class="form-control adult" name="adult" id="adult" placeholder="কত জন" required>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <input type="text" class="form-control" name="date" id="date" placeholder="কত তারিখ" readonly value="{{date("Y-m-d")}}">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <select class="form-control select2 transportName" id="transportName" name="transportName" style="width: 100%;" required>
                                <option  value="" selected> যানবহন নির্বাচন করুন</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <select class="form-control select2 transportType" id="transportType" name="transportType" style="width: 100%;" required>
                                <option  value="" selected> ধরণ নির্বাচন করুন</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <select class="form-control select2 transportTime" name="transportTime" id="transportTime" style="width: 100%;" required>
                                <option  value="" selected> সময় নির্বাচন করুন</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12" >
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
        </div>
    </div>
    {{ Form::close() }}

    {{ Form::open(array('url' => 'insertMotorcycleRide',  'method' => 'post')) }}
    {{ csrf_field() }}
    <div class="row motorDiv" style="display: none;">
        <div class="card">
            <div class="card-body cardBody">
                <div id= "zillaGroupId" style="display: none;">
                    <h5><b>কোথা থেকে যাবেন</b></h5>
                    <div class="form-group">
                        <select id="upz_name" name ="upzid" class="form-control select2 upz_name" style="width: 100%;" required="required">
                            <option value="" selected>উপজেলা  নির্বাচন করুন</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="uni_name" name ="uniid" class="form-control select2 uni_name" style="width: 100%;" required="required">
                            <option value="" selected>ইউনিয়ন  নির্বাচন করুন</option>
                        </select>
                    </div>
                </div>
                <div id= "cityGroupId" style="display: none;">
                    <h5><b>কোথা থেকে যাবেন</b></h5>
                    <div class="form-group">
                        <select id="c_upz_name" name ="c_upzid" class="form-control select2 co_name"  style="width: 100%;" required="required">
                            <option value="" selected>সিটি - কর্পোরেশন  নির্বাচন করুন</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="c_uni_name" name ="c_uniid" class="form-control select2 thana_name" style="width: 100%;" required="required">
                            <option value="" selected>থানা  নির্বাচন করুন</option>
                        </select>
                    </div>
                </div>
                <div id= "zillaGroupIdPost" style="display: none;">
                    <h5><b>কোথায় যাবেন</b></h5>
                    <div class="form-group">
                        <select id="upz_namep" name ="upzidp" class="form-control select2 upz_namep" style="width: 100%;" required="required">
                            <option value="" selected>উপজেলা  নির্বাচন করুন</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="uni_namep" name ="uniidp" class="form-control select2 uni_namep" style="width: 100%;" required="required">
                            <option value="" selected>ইউনিয়ন  নির্বাচন করুন</option>
                        </select>
                    </div>
                </div>
                <div id= "cityGroupIdPost" style="display: none;">
                    <h5><b>কোথায় যাবেন</b></h5>
                    <div class="form-group">
                        <select id="c_upz_namep" name ="c_upzidp" class="form-control select2 co_namep"  style="width: 100%;" required="required">
                            <option value="" selected>সিটি - কর্পোরেশন  নির্বাচন করুন</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="c_uni_namep" name ="c_uniidp" class="form-control select2 thana_namep" style="width: 100%;" required="required">
                            <option value="" selected>থানা  নির্বাচন করুন</option>
                        </select>
                    </div>
                </div>
                <div class="serviceArea" style="display: none;">
                    <div class="form-group">
                        <input type="number" min="1" class="form-control distanceMotor" id="distanceMotor"  name="distanceMotor" placeholder="আনুমানিক দুরত্ত" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="addressType" class="addressType" id="addressType">
                        <input type="hidden" name="transport" class="transport" value="Motorcycle">
                        <button type="submit" class="btn allButton">সাবমিট</button>
                    </div>
                    <div>
                        <h4><b>Terms & Conditions:</b></h4>
                        <p class="motorTerm1"></p>
                        <p class="motorTerm2"></p>
                        <p class="motorTerm3"></p>
                        <p class="motorTerm4"></p>
                        <p class="motorTerm5"></p>
                        <p class="motorTerm6"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
    {{ Form::open(array('url' => 'insertPrivateRide',  'method' => 'post')) }}
    {{ csrf_field() }}
    <div class="row privateDiv" style="display: none;">
        <div class="card">
            <div class="card-body cardBody">
                <div id= "zillaGroupIdPrivate" style="display: none;">
                    <h5><b>কোথা থেকে যাবেন</b></h5>
                    <div class="form-group">
                        <select id="upz_namePri" name ="upzidPri" class="form-control select2 upz_namePri" style="width: 100%;" required="required">
                            <option value="" selected>উপজেলা  নির্বাচন করুন</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="uni_namePri" name ="uniidPri" class="form-control select2 uni_namePri" style="width: 100%;" required="required">
                            <option value="" selected>ইউনিয়ন  নির্বাচন করুন</option>
                        </select>
                    </div>
                </div>
                <div id= "cityGroupIdPrivate" style="display: none;">
                    <h5><b>কোথা থেকে যাবেন</b></h5>
                    <div class="form-group">
                        <select id="c_upz_namePri" name ="c_upzidPri" class="form-control select2 co_namePri"  style="width: 100%;" required="required">
                            <option value="" selected>সিটি - কর্পোরেশন  নির্বাচন করুন</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="c_uni_namePri" name ="c_uniidPri" class="form-control select2 thana_namePri" style="width: 100%;" required="required">
                            <option value="" selected>থানা  নির্বাচন করুন</option>
                        </select>
                    </div>
                </div>
                <div id= "zillaGroupIdPostPrivate" style="display: none;">
                    <h5><b>কোথায় যাবেন</b></h5>
                    <div class="form-group">
                        <select id="div_name" name ="div_id"  class="form-control select2 div_name" style="width: 100%;" required="required">
                            <option value="" selected>বিভাগ নির্বাচন করুন</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="div_name" >এরিয়া</label>
                        <label class="radio-inline">
                            <input type="radio" name="addressGroup"  id="zillaButton" value="1" required> জেলা
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="addressGroup" id="cityButton" value="2">সিটি
                        </label>
                    </div>
                    <div class="zillaDiv" style="display: none;">
                        <div class="form-group">
                            <select id="dis_name" name ="disid" class="form-control select2 dis_name" style="width: 100%;" required="required">
                                <option  value="" selected>জেলা  নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select id="upz_namePostPri" name ="upzidPostPri" class="form-control select2 upz_namePostPri" style="width: 100%;" required="required">
                                <option value="" selected>উপজেলা  নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select id="uni_namePostPri" name ="uniidPostPri" class="form-control select2 uni_namePostPri" style="width: 100%;" required="required">
                                <option value="" selected>ইউনিয়ন  নির্বাচন করুন</option>
                            </select>
                        </div>
                    </div>
                    <div class="cityDiv" style="display: none;">
                        <div class="form-group">
                            <select id="c_dis_name" name ="c_disid" class="form-control select2 city_name" style="width: 100%;" required="required">
                                <option  value="" selected>সিটি  নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select id="c_upz_namePostPri" name ="c_upzidPostPri" class="form-control select2 co_namePostPri"  style="width: 100%;" required="required">
                                <option value="" selected>সিটি - কর্পোরেশন  নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select id="c_uni_namePostPri" name ="c_uniidPostPri" class="form-control select2 thana_namePostPri" style="width: 100%;" required="required">
                                <option value="" selected>থানা  নির্বাচন করুন</option>
                            </select>
                        </div>
                    </div>
                    <div class="serviceAreaPrivate" style="display: none;">
                        <div class="form-group">
                            <input type="number" min="1" class="form-control distancePrivate" id="distancePrivate"  name="distancePrivate" placeholder="আনুমানিক দুরত্ত" required>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="addressType" class="addressType" id="addressType">
                            <input type="hidden" name="transport" class="transportTypePrivate">
                            <button type="submit" class="btn allButton">সাবমিট</button>
                        </div>
                        <div>
                            <h4><b>Terms & Conditions:</b></h4>
                            <p class="privateTerm1"></p>
                            <p class="privateTerm2"></p>
                            <p class="privateTerm3"></p>
                            <p class="privateTerm4"></p>
                            <p class="privateTerm5"></p>
                            <p class="privateTerm6"></p>
                        </div>
                    </div>
                </div>
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
        $("#zillaButton").click(function(){
            $(".zillaDiv").show();
            $(".cityDiv").hide();
            $('.city_name').prop('required',false);
            $('.co_namePostPri').prop('required',false);
            $('.thana_namePostPri').prop('required',false);
        });
        $("#cityButton").click(function(){
            $(".zillaDiv").hide();
            $(".cityDiv").show();
            $('.dis_name').prop('required',false);
            $('.upz_namePostPri').prop('required',false);
            $('.uni_namePostPri').prop('required',false);
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
        $(".div_name").change(function(){
            var id =$(this).val();
            $('.dis_name').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getDistrictListAll',
                data: {id:id},
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
            $('.upz_namePostPri').find('option:not(:first)').remove();
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
                        $(".upz_namePostPri").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".upz_namePostPri").change(function(){
            var id =$(this).val();
            $('.uni_namePostPri').find('option:not(:first)').remove();
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
                        $(".uni_namePostPri").append("<option value='"+id+"'>"+name+"</option>");
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
            $('.co_namePostPri').find('option:not(:first)').remove();
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
                        $(".co_namePostPri").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".co_namePostPri").change(function(){
            var id =$(this).val();
            $('.thana_namePostPri').find('option:not(:first)').remove();
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
                        $(".thana_namePostPri").append("<option value='"+id+"'>"+name+"</option>");
                    }
                    $(".serviceAreaPrivate").show();
                }
            });
        });
        $(".co_namePostPri,.uni_namePostPri").change(function(){
            $(".serviceAreaPrivate").show();
        });
        $("#private, #micro, #ambulance,#truck").click(function(){
            var parVal =  $('input[name="paribahanGroup"]:checked').val();
            $(".motorDiv").hide();
            $(".privateDiv").show();
            $.ajax({
                type: 'GET',
                url: 'getAddressGroupPrivate',
                data: {type:parVal},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    if(data==0){
                        $.toast({
                            heading: 'দুঃখিত!',
                            text: 'সার্ভিসটি পেতে লগ ইন করুন!',
                            showHideTransition: 'slide',
                            icon: 'error',
                            position: {
                                left: 40,
                                top: 60
                            },
                            stack: false
                        })
                    }
                    else if(data==1){
                        $.toast({
                            heading: 'দুঃখিত!',
                            text: 'আপনার সার্ভিস এরিয়া সেট করুন।',
                            showHideTransition: 'slide',
                            icon: 'error',
                            position: {
                                left: 40,
                                top: 60
                            },
                            stack: false
                        })
                    }
                    else if(data==3){
                        $.toast({
                            heading: 'দুঃখিত!',
                            text: 'আপনার সার্ভিস এরিয়া বিদেশি!',
                            showHideTransition: 'slide',
                            icon: 'error',
                            position: {
                                left: 40,
                                top: 60
                            },
                            stack: false
                        })
                    }
                    else{
                        var len = data.length;
                        var addressType = response.addressType;
                        var cost = response.cost;
                        var transport = response.transport;
                        $(".addressType").val(addressType);
                        if(addressType == 1){
                            $("#zillaGroupIdPrivate").show();
                            $("#zillaGroupIdPostPrivate").show();
                            for( var i = 0; i<len; i++){
                                var id = data[i]['id'];
                                var name = data[i]['name'];
                                $(".upz_namePri").append("<option value='"+id+"'>"+name+"</option>");
                            }
                            $('.co_namePri').prop('required',false);
                            $('.thana_namePri').prop('required',false);
                        }
                        if(addressType == 2){
                            $("#cityGroupIdPrivate").show();
                            $("#zillaGroupIdPostPrivate").show();
                            for( var i = 0; i<len; i++){
                                var id = data[i]['id'];
                                var name = data[i]['name'];
                                $(".co_namePri").append("<option value='"+id+"'>"+name+"</option>");
                            }
                            $('.upz_namePri').prop('required',false);
                            $('.uni_namePri').prop('required',false);
                        }
                        $(".addressType").val(addressType);
                        $(".transportTypePrivate").val(transport);
                        $(".privateTerm1").html('1.Minimum charge fees '+cost.minCost+'/-');
                        $(".privateTerm2").html('2.Below 10 km charge fees per km '+cost.km1+'/-');
                        $(".privateTerm3").html('3.10-30 km charge fees per km '+cost.km2+'/-');
                        $(".privateTerm4").html('4.30-50 km charge fees per km '+cost.km3+'/-');
                        $(".privateTerm5").html('4.50-100 km charge fees per km '+cost.km4+'/-');
                        $(".privateTerm6").html('6.More than 100 km charge fees per km '+cost.km5+'/-');
                    }
                }
            });
        });

        $("#motor").click(function(){
            $(".motorDiv").show();
            $(".privateDiv").hide();
            $.ajax({
                type: 'GET',
                url: 'getAddressGroupMotor',
                data: {type:'motor'},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    if(data==0){
                        $.toast({
                            heading: 'দুঃখিত!',
                            text: 'সার্ভিসটি পেতে লগ ইন করুন!',
                            showHideTransition: 'slide',
                            icon: 'error',
                            position: {
                                left: 40,
                                top: 60
                            },
                            stack: false
                        })
                    }
                    else if(data==3){
                        $.toast({
                            heading: 'দুঃখিত!',
                            text: 'আপনার সার্ভিস এরিয়া বিদেশি!',
                            showHideTransition: 'slide',
                            icon: 'error',
                            position: {
                                left: 40,
                                top: 60
                            },
                            stack: false
                        })
                    }
                    else if(data==1){
                        $.toast({
                            heading: 'দুঃখিত!',
                            text: 'আপনার সার্ভিস এরিয়া সেট করুন।',
                            showHideTransition: 'slide',
                            icon: 'error',
                            position: {
                                left: 40,
                                top: 60
                            },
                            stack: false
                        })
                    }
                    else{
                        var len = data.length;
                        var addressType = response.addressType;
                        var cost = response.cost;
                        $(".addressType").val(addressType);
                        if(addressType == 1){
                            $("#zillaGroupId").show();
                            $("#zillaGroupIdPost").show();
                            for( var i = 0; i<len; i++){
                                var id = data[i]['id'];
                                var name = data[i]['name'];
                                $(".upz_name").append("<option value='"+id+"'>"+name+"</option>");
                                $(".upz_namep").append("<option value='"+id+"'>"+name+"</option>");
                            }
                            $('.co_name').prop('required',false);
                            $('.thana_name').prop('required',false);
                            $('.co_namep').prop('required',false);
                            $('.thana_namep').prop('required',false);
                        }
                        if(addressType == 2){
                            $("#cityGroupId").show();
                            $("#cityGroupIdPost").show();
                            for( var i = 0; i<len; i++){
                                var id = data[i]['id'];
                                var name = data[i]['name'];
                                $(".co_name").append("<option value='"+id+"'>"+name+"</option>");
                                $(".co_namep").append("<option value='"+id+"'>"+name+"</option>");
                            }
                            $('.upz_name').prop('required',false);
                            $('.uni_name').prop('required',false);
                            $('.upz_namep').prop('required',false);
                            $('.uni_namep').prop('required',false);
                        }
                        $(".motorTerm1").html('1.Minimum charge fees '+cost.minCost+'/-');
                        $(".motorTerm2").html('2.Below 10 km charge fees per km '+cost.km1+'/-');
                        $(".motorTerm3").html('3.10-30 km charge fees per km '+cost.km2+'/-');
                        $(".motorTerm4").html('4.30-50 km charge fees per km '+cost.km3+'/-');
                        $(".motorTerm5").html('4.50-100 km charge fees per km '+cost.km4+'/-');
                        $(".motorTerm6").html('6.More than 100 km charge fees per km '+cost.km5+'/-');
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
        $(".co_namep").change(function(){
            var id =$(this).val();
            $('.thana_namep').find('option:not(:first)').remove();
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
                        $(".thana_namep").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".co_namePri").change(function(){
            var id =$(this).val();
            $('.thana_namePri').find('option:not(:first)').remove();
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
                        $(".thana_namePri").append("<option value='"+id+"'>"+name+"</option>");
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
        $(".upz_namep").change(function(){
            var id =$(this).val();
            $('.uni_namep').find('option:not(:first)').remove();
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
                        $(".uni_namep").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".upz_namePri").change(function(){
            var id =$(this).val();
            $('.uni_namePri').find('option:not(:first)').remove();
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
                        $(".uni_namePri").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".uni_namep").change(function(){
            $(".serviceArea").show();
        });
        $(".thana_namep").change(function(){
            $(".serviceArea").show();
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
