@extends('frontend.frontLayout')
@section('title', 'কুরিয়ার সেবা')
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
    {{ Form::open(array('url' => 'insertCourierBooking',  'method' => 'post')) }}
    {{ csrf_field() }}
    <div class="row">
        <div class="card">
            <div class="card-body cardBody">
                <h5 style="text-align: center;"><b>আপনার পছন্দের কুরিয়ার খুজে নিন।</b></h5>
                <h5 style="text-align: center;">সার্ভিস গ্রহন করার আগে আপনার সার্ভিস এরিয়া ঠিক করে নিন। অন্যথায় সঠিক এরিয়া সার্ভিস পাবেন না।</h5>
                <div class="serviceArea" style="text-align: center;">
                    @if(Cookie::get('user_id'))
                        <div class="form-group">
                            <a href="{{url('serviceAreaCourier')}}" type="submit" class="btn allButton">সার্ভিস এরিয়া সেট করুন</a>
                        </div>
                    @endif
                    @if(Cookie::get('user_id') == null )
                        <div class="form-group">
                            <a href='{{url('login')}}'  class="btn allButton">লগ ইন করুন</a>
                        </div>
                    @endif
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label><b>শর্তাবলিঃ</b></label>
                        <div><label>Standard: সর্বোচ্চ  ৭২ ঘণ্টার ভিতর ডেলিভারি দেওয়া হবে।  </label></div>
                        <div><label>Express: সর্বোচ্চ ৪৮ ঘণ্টার ভিতর ডেলিভারি দেওয়া হবে।</label></div>
                        <div> <label>Emergency Express: সর্বোচ্চ ২৪ ঘণ্টার ভিতর ডেলিভারি দেওয়া হবে।</label></div>
                    </div>
                    <div class="form-group">
                        <label for="dis_name" >কুরিয়ার  ধরণ</label>
                        <select class="form-control select2 type" id="type" name="type" style="width: 100%;" required>
                            <option value="" selected> কুরিয়ার  ধরণ  নির্বাচন করুন</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dis_name" >ওজন</label>
                        <select class="form-control select2 weight" id="weight" name="weight" style="width: 100%;" required>
                            <option value="" selected>ওজন  নির্বাচন করুন</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">কুরিয়ার (দেশ) </label>
                        <select class="form-control select2 country" name="country" style="width: 100%;" required>
                            <option value="" selected>কুরিয়ার (দেশ)  নির্বাচন করুন</option>
                            <option value="1">বাংলাদেশ</option>
                            <option value="2">বিদেশ</option>
                        </select>
                    </div>
                    <div class="form-group f_countryDiv" style="display: none">
                        <label for="">দেশ</label>
                        <select class="form-control select2 f_country" name="f_country" style="width: 100%;" >
                            <option value="" selected>দেশ  নির্বাচন করুন</option>
                        </select>
                    </div>
                    <div class="col-sm-12 priceDiv" style="display: none;">
                        <div class="form-group">
                            <h4 class="price"></h4>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="div_name" >এরিয়া (কোথায় পাঠাতে চান)</label>
                        <label class="radio-inline zillaGroup">
                            <input type="radio" name="addressGroup"  id="zillaGroup" value="1" required> জেলা
                        </label>
                        <label class="radio-inline cityGroup">
                            <input type="radio" name="addressGroup" id="cityGroup" value="2">সিটি
                        </label>
                        <label class="radio-inline foreignGroup">
                            <input type="radio" name="addressGroup" id="foreignGroup" value="3">বিদেশ
                        </label>
                    </div><div id="divDiv" style="display: none;">
                        <div class="form-group">
                            <select id="div_name" name ="div_id"  class="form-control select2 div_name" style="width: 100%;" required>
                                <option value="" selected>বিভাগ নির্বাচন করুন</option>
                            </select>
                        </div>
                    </div>
                    <div id= "zillaGroupId" style="display: none;">
                        <div class="form-group">
                            <label for="dis_name" >জেলা</label>
                            <select id="dis_name" name ="disid" class="form-control select2 dis_name" style="width: 100%;" required="required">
                                <option  value="" selected>জেলা  নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="upz_name" >উপজেলা</label>
                            <select id="upz_name" name ="upzid" class="form-control select2 upz_name" style="width: 100%;" required="required">
                                <option value="" selected>উপজেলা  নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="uni_name" >ইউনিয়ন</label>
                            <select id="uni_name" name ="uniid" class="form-control select2 uni_name" style="width: 100%;" required="required">
                                <option value="" selected>ইউনিয়ন  নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="uni_name" >ওয়ার্ড</label>
                            <select id="ward_name" name ="wardid" class="form-control select2 ward_name"  style="width: 100%;" required="required">
                                <option value="" selected>ওয়ার্ড  নির্বাচন করুন</option>
                            </select>
                        </div>
                    </div>
                    <div id= "cityGroupId" style="display: none;">
                        <div class="form-group">
                            <label for="c_dis_name" >সিটি</label>
                            <select id="c_dis_name" name ="c_disid" class="form-control select2 city_name" style="width: 100%;" required="required">
                                <option  value="" selected>সিটি  নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="c_upz_name" >সিটি - কর্পোরেশন</label>
                            <select id="c_upz_name" name ="c_upzid" class="form-control select2 co_name"  style="width: 100%;" required="required">
                                <option value="" selected>সিটি - কর্পোরেশন  নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="c_uni_name" >থানা</label>
                            <select id="c_uni_name" name ="c_uniid" class="form-control select2 thana_name" style="width: 100%;" required="required">
                                <option value="" selected>থানা  নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="uni_name" >ওয়ার্ড</label>
                            <select id="c_ward_name" name ="c_wardid" class="form-control select2 c_ward_name"   style=" width: 100%;" required="required">
                                <option value="" selected>ওয়ার্ড  নির্বাচন করুন</option>
                            </select>
                        </div>
                    </div>
                    <div id= "foreignGroupId" class="foreignGroupId" style="display: none;">
                        <div class="form-group">
                            <select id="naming1" name ="naming1" class="form-control select2 naming1"  style="width: 100%;" required="required">
                                <option  value="" selected>Select your Country</option>
                            </select>
                        </div>
                        <div class="form-group naming2Div" style="display: none;">
                            <select id="naming2" name ="naming2" class="form-control select2 naming2"  style="width: 100%;" required="required">
                            </select>
                        </div>
                        <div class="form-group naming3Div" style="display: none;">
                            <select id="naming3" name ="naming3" class="form-control select2 naming3"  style="width: 100%;" required="required">
                            </select>
                        </div>
                        <div class="form-group naming4Div" style="display: none;">
                            <select id="naming4" name ="naming4" class="form-control select2 naming4"  style="width: 100%;" required="required">
                            </select>
                        </div>
                        <div class="form-group naming5Div" style="display: none;">
                            <select id="naming5" name ="naming5" class="form-control select2 naming5"  style="width: 100%;" required="required">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="address" placeholder="ঠিকানা (Address)"  required>
                    </div>
                    <div class="form-check">
                        <div>
                            <label>বুকিংকৃত পণ্য অফিসে কিভাবে পৌছাবেন </label>
                        </div>
                        <input class="form-check-input" type="radio" name="bookingPlace" id="bookingPlace1" value="own" required>
                        <label class="form-check-label" for="bookingPlace1">
                            নিজ দায়িত্বে
                        </label>
                        <input class="form-check-input" type="radio" name="bookingPlace" id="bookingPlace2" value="office">
                        <label class="form-check-label" for="bookingPlace2">
                            পিক আপ প্রয়োজন
                        </label>
                    </div>
                    <div class="form-group pickupAddress" style="display: none;">
                        <input type="text" class="form-control pickupAddress" name="pickupAddress" placeholder=" ঠিকানা (Pickup Address)"  required>
                    </div>
                </div>
                <div class="col-sm-12">
                    @if(Cookie::get('user_id'))
                        <div class="form-group">
                            <input type="hidden" class="lastPrice" name="lastPrice">
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
        $("#bookingPlace2").click(function(){
            $(".pickupAddress").show();
            $('.pickupAddress').prop('required',true);
        });
        $("#bookingPlace1").click(function(){
            $(".pickupAddress").hide();
            $('.pickupAddress').prop('required',false);
        });
        $(".country").change(function(){
            var id =$(this).val();
            $('.f_country').find('option:not(:first)').remove();
            if(id == 2){
                $(".f_countryDiv").show();
                $(".cityGroup").hide();
                $(".zillaGroup").hide();
                $(".foreignGroup").show();
                $.ajax({
                    type: 'GET',
                    url: 'getAllNaming1CountryFront',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        var data = response.data;
                        var len = data.length;
                        for( var i = 0; i<len; i++){
                            var id = data[i]['id'];
                            var name = data[i]['name'];
                            $(".f_country").append("<option value='"+id+"'>"+name+"</option>");
                        }
                    }
                });
            }
            else{
                $(".f_countryDiv").hide();
                $(".foreignGroup").hide();
                $(".cityGroup").show();
                $(".zillaGroup").show();
                var idd = 1;
                var type =$('.type').val();
                var weight =$('.weight').val();
                $.ajax({
                    type: 'GET',
                    url: 'getAllCourierCostBd',
                    data: {id:idd,type:type,weight:weight},
                    dataType: 'json',
                    success: function(response){
                        var data = response.data;
                        var len = data.length;
                        $('.price').html('Courier Cost: '+data +' Taka');
                        $('.lastPrice').val(data);
                        $('.priceDiv').show();
                    }
                });
            }

        });
        $(document).ready(function(){
            $.ajax({
                url: 'getAllCourierTypeFront',
                type: "GET",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".type").append("<option value='"+id+"'>"+name+"</option>");
                    }

                },
                failure: function (msg) {
                    alert('an error occured');
                }
            });
            $(".type").change(function(){
                var id =$(this).val();
                $('.weight').find('option:not(:first)').remove();
                $.ajax({
                    type: 'GET',
                    url: 'getAllCourierWeight',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        var data = response.data;
                        var len = data.length;
                        for( var i = 0; i<len; i++){
                            var id = data[i]['weight'];
                            var name = data[i]['weight'];
                            $(".weight").append("<option value='"+id+"'>"+name+"</option>");
                        }
                    }
                });
            });
            $(".f_country").change(function(){
                var id =$(this).val();
                var type =$('.type').val();
                var weight =$('.weight').val();
                $.ajax({
                    type: 'GET',
                    url: 'getAllCourierCost',
                    data: {id:id,type:type,weight:weight},
                    dataType: 'json',
                    success: function(response){
                        var data = response.data;
                        var len = data.length;
                        $('.price').html('Courier Cost: '+data +' Taka');
                        $('.priceDiv').show();
                        $('.lastPrice').val(data);
                    }
                });
            });
        });
        $("#zillaGroup").click(function(){
            $("#zillaGroupId").show();
            $("#cityGroupId").hide();
            $("#foreignGroupId").hide();
            $("#divDiv").show();
            $('.city_name').prop('required',false);
            $('.co_name').prop('required',false);
            $('.thana_name').prop('required',false);
            $('.c_ward_name').prop('required',false);
            $('.naming1').prop('required',false);
            $('.naming2').prop('required',false);
            $('.naming3').prop('required',false);
            $('.naming4').prop('required',false);
            $('.naming5').prop('required',false);
        });
        $("#cityGroup").click(function(){
            $("#zillaGroupId").hide();
            $("#cityGroupId").show();
            $("#foreignGroupId").hide();
            $("#divDiv").show();
            $('.dis_name').prop('required',false);
            $('.upz_name').prop('required',false);
            $('.uni_name').prop('required',false);
            $('.ward_name').prop('required',false);
            $('.naming1').prop('required',false);
            $('.naming2').prop('required',false);
            $('.naming3').prop('required',false);
            $('.naming4').prop('required',false);
            $('.naming5').prop('required',false);
        });
        $("#foreignGroup").click(function(){
            $("#zillaGroupId").hide();
            $("#cityGroupId").hide();
            $("#foreignGroupId").show();
            $("#divDiv").hide();
            $('.div_name').prop('required',false);
            $('.city_name').prop('required',false);
            $('.co_name').prop('required',false);
            $('.thana_name').prop('required',false);
            $('.c_ward_name').prop('required',false);
            $('.dis_name').prop('required',false);
            $('.upz_name').prop('required',false);
            $('.uni_name').prop('required',false);
            $('.ward_name').prop('required',false);
        });$(document).ready(function(){
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

        });
        $(function(){
            $('.select2').select2();

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
                $('.upz_name').find('option:not(:first)').remove();
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
                            $(".upz_name").append("<option value='"+id+"'>"+name+"</option>");
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
            $(".uni_name").change(function(){
                var id =$(this).val();
                $('.ward_name').find('option:not(:first)').remove();
                $.ajax({
                    type: 'GET',
                    url: 'getWardListAll',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        var data = response.data;
                        var len = data.length;
                        for( var i = 0; i<len; i++){
                            var id = data[i]['id'];
                            var name = data[i]['name'];
                            $(".ward_name").append("<option value='"+id+"'>"+name+"</option>");
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
                $('.co_name').find('option:not(:first)').remove();
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
                            $(".co_name").append("<option value='"+id+"'>"+name+"</option>");
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
            $(".thana_name").change(function(){
                var id =$(this).val();
                $('.c_ward_name').find('option:not(:first)').remove();
                $.ajax({
                    type: 'GET',
                    url: 'getC_wardListAll',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        var data = response.data;
                        var len = data.length;
                        for( var i = 0; i<len; i++){
                            var id = data[i]['id'];
                            var name = data[i]['name'];
                            $(".c_ward_name").append("<option value='"+id+"'>"+name+"</option>");
                        }
                    }
                });
            });
        });
        $.ajax({
            url: 'getAllNaming1Front',
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                var data = response.data;
                var len = data.length;
                for( var i = 0; i<len; i++){
                    var id = data[i]['id'];
                    var name = data[i]['name'];
                    $(".naming1").append("<option value='"+id+"'>"+name+"</option>");
                }

            },
            failure: function (msg) {
                alert('an error occured');
            }
        });
        $(".naming1").change(function(){
            var id =$(this).val();
            $.ajax({
                type: 'GET',
                url: 'getNaming2ListAllFront',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    $(".naming2Div").show();
                    $(".naming2").append("<option value=''>"+'Select your  '+data[0]['naming2']+ "</option>");
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".naming2").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".naming2").change(function(){
            var id =$(this).val();
            $.ajax({
                type: 'GET',
                url: 'getNaming3ListAllFront',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    $(".naming3Div").show();
                    $(".naming3").append("<option value=''>"+'Select your  '+data[0]['naming3']+ "</option>");
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".naming3").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".naming3").change(function(){
            var id =$(this).val();
            $.ajax({
                type: 'GET',
                url: 'getNaming4ListAllFront',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    $(".naming4Div").show();
                    $(".naming4").append("<option value=''>"+'Select your  '+data[0]['naming4']+ "</option>");
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".naming4").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".naming4").change(function(){
            var id =$(this).val();
            $.ajax({
                type: 'GET',
                url: 'getNaming5ListAllFront',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    $(".naming5Div").show();
                    $(".naming5").append("<option value=''>"+'Select your  '+data[0]['naming5']+ "</option>");
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".naming5").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });

    </script>
@endsection
