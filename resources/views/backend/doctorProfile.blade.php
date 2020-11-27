@extends('backend.layout')
@section('title', 'সার্ভিস এরিয়া')
@section('page_header', 'সার্ভিস এরিয়া ব্যবস্থাপনা')
@section('doctorServiceArea','active')
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
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><b>আমার সার্ভিস এরিয়া: {{@$name->divName.', '.@$name->disName.', '.@$name->upzName.', '.@$name->uniName}}</b></h3>
                </div>
                <div class="divform">
                    <div class="box-body">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">আমার স্ট্যাটাস</h3>
                </div>
                <div class="divform">
                    <div class="box-body">
                        <center>
                            @if(@$users['info']->working_status == 1 || @$users['info']->working_status == 4 || @$users['info']->working_status == 0)
                                <input class="form-check-input w_status" type="radio" name="w_status" id="notwork" value="0"  @if(@$users['info']->working_status == 0) {{'checked'}} @endif>
                                <label class="form-check-label" for="notwork">
                                    Not willing to work
                                </label>&nbsp;&nbsp;
                                <input class="form-check-input w_status" type="radio" name="w_status" id="free" value="1" @if(@$users['info']->working_status == 1) {{'checked'}} @endif>
                                <label class="form-check-label" for="free">
                                    Free
                                </label>&nbsp;&nbsp;
                            @endif
                            @if(@$users['info']->working_status == 2)
                                <input class="form-check-input w_status" type="radio" name="w_status" id="assigned" value="2" @if(@$users['info']->working_status == 2) {{'checked'}} @endif>
                                <label class="form-check-label" for="free">
                                    Assigned
                                </label>&nbsp;&nbsp;
                                <input class="form-check-input w_status" type="radio" name="w_status" id="working" value="3" @if(@$users['info']->working_status == 3) {{'checked'}} @endif>
                                <label class="form-check-label" for="working">
                                    Start
                                </label>&nbsp;&nbsp;
                            @endif
                            @if(@$users['info']->working_status == 3)
                                <input class="form-check-input w_status" type="radio" name="w_status" id="working" value="3" @if(@$users['info']->working_status == 3) {{'checked'}} @endif>
                                <label class="form-check-label" for="working">
                                    Start
                                </label>&nbsp;&nbsp;
                                <input class="form-check-input w_status" type="radio" name="w_status" id="delivered" value="4">
                                <label class="form-check-label" for="delivered">
                                    End
                                </label>&nbsp;&nbsp;
                            @endif
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">আপনি কি লোকাল ডাক্তার হিসাবে কাজ করতে চান?</h3>
                </div>
                <div class="">
                    <div class="box-body">
                        <center>
                            <?php
                               if($dr_status == 1)
                                   $checked = 'checked';
                               else
                                   $checked = '';
                            ?>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="localDr" name="localDr" {{$checked}}>
                                <label class="form-check-label" for="localDr">আমাকে চেক করুন</label>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">সার্ভিস এরিয়া পরিবরতন</h3>
                </div>
                <div class="divform">
                    {{ Form::open(array('url' => 'insertDoctorServiceArea',  'method' => 'post')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
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
                                <button type="submit" class="btn btn-primary">সাবমিট</button>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        $(document).ready(function(){
            $(".w_status").change(function(){
                var id =$(this).val();
                $.ajax({
                    type: 'GET',
                    url: 'changeWorkingStatusProvider',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        location.reload();

                    }
                });
            });
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

            $("#localDr").change(function(){
                if($("#localDr").prop('checked') == true){
                    var id =1;
                }
                else{
                    var id =0;
                }
                $.ajax({
                    type: 'GET',
                    url: 'changeLocalDoctorStatus',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        var data = response.data;
                        if(data==1){
                            $.toast({
                                heading: 'ধন্যবাদ',
                                text: 'সফল্ভাবে সম্পন্ন্য হয়েছে।',
                                showHideTransition: 'slide',
                                icon: 'success',
                                position: {
                                    left: 40,
                                    top: 60
                                },
                                stack: false
                            })
                        }
                        if(data == 0){
                            $.toast({
                                heading: 'দুঃখিত',
                                text: 'আবার চেষ্টা করুন।',
                                showHideTransition: 'slide',
                                icon: 'error',
                                position: {
                                    left: 40,
                                    top: 60
                                },
                                stack: false
                            })
                        }
                    }
                });
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
