@extends('frontend.frontLayout')
@section('title', 'সার্ভিস এরিয়া')
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
    {{ Form::open(array('url' => 'insertServiceArea',  'method' => 'post')) }}
    {{ csrf_field() }}
    <div class="form-group">
        <label for="div_name">বিভাগ</label>
        <select id="div_name" name ="div_id"  class="form-control select2 div_name" style="width: 100%;" required="required">
            <option value="" selected>বিভাগ নির্বাচন করুন</option>
        </select>
    </div>
    <div class="form-group">
        <label for="div_name" >এরিয়া</label>
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
    </div>
    <div class="serviceArea" style="display: none;">
        <div class="form-group">
            <button type="submit" class="btn allButton">সাবমিট</button>
        </div>
    </div>
    {{ Form::close() }}
@endsection
@section('js')
    <script>
        $(document).ready(function(){
            $(".addbut").click(function(){
                $(".divform").show();
                $(".rembut").show();
                $(".addbut").hide();
            });
            $(".rembut").click(function(){
                $(".divform").hide();
                $(".addbut").show();
                $(".rembut").hide();
            });
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
        });
        $(document).ready(function(){
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
                $(".serviceArea").show();
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
                $(".serviceArea").show();
            });
        });
    </script>
@endsection
