@extends('frontend.frontLayout')
@section('title', 'প্রোফাইল')
@section('ExtCss')
    <link rel="stylesheet" href="public/asset/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
            @if ($message = Session::get('successMessage'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> ধন্যবাদ</h4>
                    {{ $message }}
                </div>
            @endif
            @if ($message = Session::get('errorMessage'))

                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-warning"></i> দুঃখিত!</h4>
                    {{ $message }}
                </div>
            @endif
            <div class="col-md-4">
                @php
                    $Image ="public/asset/images/noImage.jpg";
                    if(!empty($users['info'])){
                       if(!empty($users['info']->photo))
                           $Image =$users['info']->photo;
                       }
                @endphp
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="{{url($Image)}}" alt="User profile picture">

                        <h3 class="profile-username text-center"></h3>

                        <p class="text-muted text-center">{{$users['info']->desig}}</p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>নামঃ</b> <a class="pull-right">{{$users['info']->name}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>মোবাইলঃ</b> <a class="pull-right">{{$users['info']->phone}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>মেইলঃ</b> <a class="pull-right">{{$users['info']->email}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>লিঙ্গঃ</b> <a class="pull-right">{{$users['info']->gender}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>ঠিকানাঃ</b> <a class="pull-right">{{$users['info']->address}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>সক্রিয়তাঃ</b> <a class="pull-right">@if($users['info']->status == 1){{'একটিভ' }} @else {{'একটিভ নয়'}}@endif</a>
                            </li>
                        </ul>
                        <button class="btn btn-primary btn-block edit allButton" data-id="{{$users['info']->id}}"><b>তথ্য পরিবর্তন করুন</b></button>
                    </div>
                </div>
            </div>
            <div class="col-md-8 divform"  style="display:none;">
                <div class="box box-primary">
                        <div class="box-header with-border">
                            <div>
                                {{ Form::open(array('url' => 'insertUser',  'method' => 'post','enctype'=>'multipart/form-data')) }}
                                {{ csrf_field() }}
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="name" >নাম</label>
                                        <input type="text" class="form-control name" name="name" placeholder="নাম"  required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" >ই-মেইল</label>
                                        <input type="email" class="form-control email" name="email" placeholder="ই-মেইল"  required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" >ফোন </label>
                                        <input type="tel" class="form-control phone" name="phone" placeholder="ফোন নম্বর" pattern="\+?(88)?0?1[3456789][0-9]{8}\b"  required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" >পাসওয়ার্ড</label>
                                        <input type="password" class="form-control password" name="password" placeholder="পাসওয়ার্ড"  required >
                                    </div>
                                    <div class="form-group">
                                        <label for="div_name" >লিঙ্গ</label>
                                        <label class="radio-inline">
                                            <input type="radio" name="gender"  id="male" value="M" required> পুরুষ
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" id="female" value="F">মহিলা
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="div_name">বিভাগ</label>
                                        <select id="div_name" name ="div_id"  class="form-control select2 div_name" style="width: 100%;" required="required">
                                            <option value="" selected>বিভাগ নির্বাচন করুন</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="div_name" >বসবাস</label>
                                        <label class="radio-inline">
                                            <input type="radio" name="addressGroup"  id="zillaGroup" value="1" required> জেলা
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="addressGroup" id="cityGroup" value="2">সিটি
                                        </label>
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
                                            <label for="ward_name" >ওয়ার্ড</label>
                                            <select id="ward_name" name ="wardid" class="form-control select2 ward_name" style="width: 100%;" required="required">
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
                                            <label for="c_ward_name" >ওয়ার্ড</label>
                                            <select id="c_ward_name" name ="c_wardid" class="form-control select2 c_ward_name" style="width: 100%;" required="required">
                                                <option value="" selected>ওয়ার্ড  নির্বাচন করুন</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address" >ঠিকানা</label>
                                        <input type="text" class="form-control address" name="address" placeholder="ঠিকানা"  required>
                                    </div>
                                    <div class="form-group">
                                        <label for="type" >ছবি</label>
                                        <input type="file" class="form-control type" accept="image/*" name="user_photo" placeholder="ছবি">
                                    </div>
                                    <div class="photoId" style="display: none;">
                                        <div class="form-group">
                                            <label for="address" >এন আইডি নম্বর</label>
                                            <input type="text" class="form-control nid" name="nid" placeholder="এন আইডি নম্বর">
                                        </div>
                                    </div>

                                </div>
                                <div class="box-footer">
                                    <input type="hidden" name="id" id="id" class="id">
                                    <button type="submit" class="btn btn-primary">সেভ করুন</button>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')
    <script src="public/asset/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script>

        $(document).on('click', '.edit', function(e){
            e.preventDefault();
            $('.divform').show();
            var id = $(this).data('id');
            console.log(id);
            getRow(id);
        });
        function getRow(id){
            $.ajax({
                type: 'POST',
                url: 'getUserListByIdProfile',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    $('.name').val(data[0]['name']);
                    $('.phone').val(data[0]['phone']);
                    $('.email').val(data[0]['email']);
                    $('.address').val(data[0]['address']);
                    $('.id').val(data[0]['id']);
                    $('.nid').val(data[0]['nid']);
                    if(data[0]['gender']=='M')
                        $("#male").attr('checked', 'checked');
                    else
                        $("#female").attr('checked', 'checked');
                    $('.select2').select2();
                }
            });
        }
        $(document).ready(function(){
            $("#zillaGroup").click(function(){
                $("#zillaGroupId").show();
                $("#cityGroupId").hide();
                $('.city_name').prop('required',false);
                $('.co_name').prop('required',false);
                $('.thana_name').prop('required',false);
                $('.c_ward_name').prop('required',false);
            });
            $("#cityGroup").click(function(){
                $("#zillaGroupId").hide();
                $("#cityGroupId").show();
                $('.dis_name').prop('required',false);
                $('.upz_name').prop('required',false);
                $('.uni_name').prop('required',false);
                $('.ward_name').prop('required',false);
            });
            $.ajax({
                url: 'getAllSaleCategory',
                type: "GET",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".cat_type").append("<option value='"+id+"'>"+name+"</option>");
                    }

                },
                failure: function (msg) {
                    alert('an error occured');
                }
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
            $.ajax({
                url: 'getAllUserTypeSignUp',
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
            $(".div_name").change(function(){
                var id =$(this).val();
                $('.dis_name').find('option:not(:first)').remove();
                $.ajax({
                    type: 'GET',
                    url: 'getDistrictListAll',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id
                    },
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
            $(".w_status").change(function(){
                var id =$(this).val();
                $.ajax({
                    type: 'GET',
                    url: 'changeWorkingStatus',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        location.reload();

                    }
                });
            });
            $('.select2').select2();


        })
    </script>
@endsection
