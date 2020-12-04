@extends('frontend.loginLayout')
@section('title','সাইন আপ')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href=""><b>বাজার - সদাই</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">সাইন আপ করুন </p>
            @if ($message = Session::get('errorMessage'))
                <center><p style="color: red">{{$message}} </p></center>
            @endif
            <div class="divform">
                {{ Form::open(array('url' => 'insertNewUser',  'method' => 'post')) }}
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <input type="text" class="form-control  name" name="name" placeholder="নাম"  required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control email" name="email" placeholder="ই-মেইল"  required>
                    </div>
                    <div class="form-group">
                        <input type="tel" class="form-control phone" name="phone" placeholder="ফোন নম্বর" pattern="\+?(88)?0?1[3456789][0-9]{8}\b"  required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control password" name="password" placeholder="পাসওয়ার্ড"  required >
                    </div>
                    <div class="form-group">
                        <label class="radio-inline">
                            <input type="radio" name="gender"  id="male" value="M" required> পুরুষ
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="gender" id="female" value="F">মহিলা
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="radio-inline">
                            <input type="radio" name="addressGroup"  id="zillaGroup" value="1"  required> জেলা
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="addressGroup" id="cityGroup" value="2">সিটি
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="addressGroup" id="foreignGroup" value="3">বিদেশ
                        </label>
                    </div>
                    <div id="divDiv" style="display: none;">
                        <div class="form-group">
                            <select id="div_name" name ="div_id"  class="form-control select2 div_name" style="width: 100%;" required>
                                <option value="" selected>বিভাগ নির্বাচন করুন</option>
                            </select>
                        </div>
                    </div>
                    <div id= "zillaGroupId" class="zillaGroupId" style="display: none;">
                        <div class="form-group">
                            <select id="dis_name" name ="disid" class="form-control select2 dis_name"  style="width: 100%;" required="required">
                                <option  value="" selected>জেলা  নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select id="upz_name" name ="upzid" class="form-control select2 upz_name"  style="width: 100%;" required="required">
                                <option value="" selected>উপজেলা  নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select id="uni_name" name ="uniid" class="form-control select2 uni_name"  style="width: 100%;" required="required">
                                <option value="" selected>ইউনিয়ন  নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select id="ward_name" name ="wardid" class="form-control select2 ward_name"  style="width: 100%;" required="required">
                                <option value="" selected>ওয়ার্ড  নির্বাচন করুন</option>
                            </select>
                        </div>
                    </div>
                    <div id= "cityGroupId" class="cityGroupId" style="display: none;">
                        <div class="form-group">
                            <select id="c_dis_name" name ="c_disid" class="form-control select2 city_name"  style="width: 100%;" required="required">
                                <option  value="" selected>সিটি  নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select id="c_upz_name" name ="c_upzid" class="form-control select2 co_name"   style="width: 100%;" required="required">
                                <option value="" selected>সিটি - কর্পোরেশন  নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select id="c_uni_name" name ="c_uniid" class="form-control select2 thana_name"  style="width: 100%;" required="required">
                                <option value="" selected>অঞ্চল/থানা  নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
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
                        <input type="text" class="form-control" name="address" placeholder="ঠিকানা"  required>
                    </div>
                    <div class="form-group">
                        <select id="type" name ="user_type" class="form-control  select2 type" style="width: 100%;" required="required">
                            <option value="" selected>সদস্য ধরন   নির্বাচন করুন </option>
                        </select>
                    </div>
                    <div class="photoId" style="display: none;">
                        <div class="form-group">
                            <label for="address" >এন আইডি নম্বর</label>
                            <input type="text" class="form-control nid" name="nid" placeholder="এন আইডি নম্বর" required>
                        </div>
                    </div>
                    <div class="doctorsForm" style="display: none;">
                        <div class="form-group">
                            <select id="doc_department" name ="doc_department" class="form-control select2 doc_department" style="width: 100%;" required>
                                <option value=""selected>ডিপার্টমেন্ট  নির্বাচন করুন </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select id="doc_hospital" name ="doc_hospital" class="form-control select2 doc_hospital" style="width: 100%;" required>
                                <option value=""selected>হাসপাতাল  নির্বাচন করুন </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control designation" name="designation" placeholder="পদবী" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="currentInstitute" placeholder="বর্তমান কর্মস্থল নাম">
                        </div>
                        <div class="form-group">
                            <textarea  class="form-control" name="education" placeholder="শিক্ষাগত যোগ্যতা"></textarea>
                        </div>
                        <div class="form-group">
                            <textarea  class="form-control" name="specialized" placeholder="বিশেষ যোগ্যতা"></textarea>
                        </div>
                        <div class="form-group">
                            <textarea  class="form-control" name="experience" placeholder="অভিজ্ঞতা"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control fees" id="fees"  name="fees" min="0" placeholder=" ফিস লিখুন" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control pa_address" id="pa_address"  name="pa_address" placeholder="রোগী দেখার ঠিকানা" required>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control intime" id="intime"  name="intime" min="0" placeholder="ইন টাইম" required>
                        </div>
                        <div class="form-group">
                            <select class="form-control select2 intimezone" name="intimezone" id="intimezone" style="width: 100%;" required>
                                <option  value="" selected> ইন টাইম নির্বাচন করুন</option>
                                <option  value="AM">AM</option>
                                <option  value="PM">PM</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control outtime" id="outtime"  name="outtime" min="0" placeholder="আউট টাইম" required>
                        </div>
                        <div class="form-group">
                            <select class="form-control select2 outtimezone" name="outtimezone" id="outtimezone" style="width: 100%;" required>
                                <option  value="" selected> আউট টাইম নির্বাচন করুন</option>
                                <option  value="AM">AM</option>
                                <option  value="PM">PM</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label> রোগী দেখার দিন সমুহ </label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="saturday" name="days[]" value="Saturday" checked>
                                <label class="form-check-label" for="saturday">Saturday</label>
                                <input type="checkbox" class="form-check-input" id="sunday" name="days[]" value="Sunday" checked>
                                <label class="form-check-label" for="sunday">Sunday</label>
                                <input type="checkbox" class="form-check-input" id="monday" name="days[]" value="Monday" checked>
                                <label class="form-check-label" for="monday">Monday</label>
                                <input type="checkbox" class="form-check-input" id="tuesday" name="days[]" value="Tuesday" checked>
                                <label class="form-check-label" for="tuesday">Tuesday</label>
                                <input type="checkbox" class="form-check-input" id="wednesday" name="days[]" value="Wednesday" checked>
                                <label class="form-check-label" for="wednesday">Wednesday</label>
                                <input type="checkbox" class="form-check-input" id="thursday" name="days[]" value="Thursday" checked>
                                <label class="form-check-label" for="thursday">Thursday</label>
                                <input type="checkbox" class="form-check-input" id="friday" name="days[]" value="Friday" checked>
                                <label class="form-check-label" for="friday">Friday</label>
                            </div>
                        </div>
                    </div>
                    <div class="pharmacyForm" style="display: none;">
                        <div class="form-group">
                            <input type="text" class="form-control p_name" id="p_name"  name="p_name" min="0" placeholder="ফার্মেসী নাম" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control p_address" id="p_address"  name="p_address" min="0" placeholder="ফার্মেসী ঠিকানা " required>
                        </div>
                    </div>
                    <div class="cookingForm" style="display: none;">
                        <div class="form-group">
                            <label> ধরণ</label>
                            <select class="form-control select2 mealtype" name="mealtype" id="mealtype" style="width: 100%;" required>
                                <option  value="" selected> ধরণ নির্বাচন করুন</option>
                                <option  value="1"> প্রতি দিন</option>
                                <option  value="30"> প্রতি মাস</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>প্রতিদিন মিল</label>
                            <select class="form-control select2 meal" name="meal" id="meal" style="width: 100%;" required>
                                <option  value="" selected> মিল নির্বাচন করুন</option>
                                <option  value="১ বার"> ১ বার</option>
                                <option  value="২ বার"> ২ বার</option>
                                <option  value="৩ বার"> ৩ বার</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>প্রতিদিন মিল</label>
                            <select class="form-control select2 mealtime" name="mealtime" id="mealtime" style="width: 100%;" required>
                                <option  value="" selected> মিল নির্বাচন করুন</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox ">
                        <label>
                            <input type="checkbox"> আপনাকে স্মরণ করিয়ে দিব
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" value="login"  name="login" class="btn btn-primary btn-block btn-flat">সাইন আপ </button>
                </div>
                <!-- /.col -->
            </div>
            {{ Form::close() }}
            <a href="{{ url('login') }}" class="text-center">আমার মেম্বারশিপ আছে</a>

        </div>
        <!-- /.login-box-body -->
    </div>
@endsection
@section('js')
    <script>

        $(document).ready(function(){
            $.ajax({
                url: 'getAllMedDept',
                type: "GET",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".doc_department").append("<option value='"+id+"'>"+name+"</option>");
                    }

                },
                failure: function (msg) {
                    alert('an error occured');
                }
            });
            $(".meal").change(function(){
                var id =$(this).val();
                $('.mealtime').find('option:not(:first)').remove();
                $.ajax({
                    type: 'GET',
                    url: 'getMealTypeAll',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        var data = response.data;
                        var len = data.length;
                        for( var i = 0; i<len; i++){
                            var id = data[i]['name'];
                            var name = data[i]['name'];
                            $(".mealtime").append("<option value='"+id+"'>"+name+"</option>");
                        }
                    }
                });
            });
            $(".doc_department").change(function(){
                var id =$(this).val();
                $('.doc_hospital').find('option:not(:first)').remove();
                $.ajax({
                    type: 'GET',
                    url: 'getHospitalListAll',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        var data = response.data;
                        var len = data.length;
                        for( var i = 0; i<len; i++){
                            var id = data[i]['id'];
                            var name = data[i]['name'];
                            $(".doc_hospital").append("<option value='"+id+"'>"+name+"</option>");
                        }
                    }
                });
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
        });
        $(function(){
            $('.select2').select2();
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
            });
            $('#type').change(function(){
                var value = $(this).val();
                if(value==13){
                    $(".doctorsForm").show();
                    //pharmacy
                    $('.p_name').prop('required',false);
                    $('.p_address').prop('required',false);
                    //cooking
                    $('.mealtype').prop('required',false);
                    $('.meal').prop('required',false);
                    $('.mealtime').prop('required',false);

                }
                else if(value==15){
                    $(".pharmacyForm").show();
                    //doctor
                    $('.doc_department').prop('required',false);
                    $('.doc_hospital').prop('required',false);
                    $('.designation').prop('required',false);
                    $('.fees').prop('required',false);
                    $('.pa_address').prop('required',false);
                    $('.intime').prop('required',false);
                    $('.intimezone').prop('required',false);
                    $('.outtime').prop('required',false);
                    $('.outtimezone').prop('required',false);
                    //cooking
                    $('.mealtype').prop('required',false);
                    $('.meal').prop('required',false);
                    $('.mealtime').prop('required',false);
                }
                else if(value==16){
                    $(".cookingForm").show();
                    //doctor
                    $('.doc_department').prop('required',false);
                    $('.doc_hospital').prop('required',false);
                    $('.designation').prop('required',false);
                    $('.fees').prop('required',false);
                    $('.pa_address').prop('required',false);
                    $('.intime').prop('required',false);
                    $('.intimezone').prop('required',false);
                    $('.outtime').prop('required',false);
                    $('.outtimezone').prop('required',false);
                    //pharmacy
                    $('.p_name').prop('required',false);
                    $('.p_address').prop('required',false);
                }
                else{
                    $(".doctorsForm").hide();
                    $(".pharmacyForm").hide();
                    $(".cookingForm").hide();
                    //doctor
                    $('.doc_department').prop('required',false);
                    $('.doc_hospital').prop('required',false);
                    $('.designation').prop('required',false);
                    $('.fees').prop('required',false);
                    $('.pa_address').prop('required',false);
                    $('.intime').prop('required',false);
                    $('.intimezone').prop('required',false);
                    $('.outtime').prop('required',false);
                    $('.outtimezone').prop('required',false);
                    //pharmacy
                    $('.p_name').prop('required',false);
                    $('.p_address').prop('required',false);
                    //cooking
                    $('.mealtype').prop('required',false);
                    $('.meal').prop('required',false);
                    $('.mealtime').prop('required',false);
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
        });

        $(".type").change(function(){
            var id =$(this).val();
            if(id== 5 || id==6 || id==7){
                $(".photoId").show();
            }
            else{
                $(".photoId").hide();
                $('.nid').prop('required',false);
            }

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
