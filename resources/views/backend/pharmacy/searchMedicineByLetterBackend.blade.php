@extends('backend.layout')
@section('title', 'সেলফ ম্যানেজমেন্ট')
@section('page_header', 'সেলফ ম্যানেজমেন্ট')
@section('medicineSelfManagement','active')
@section('content')
@section('extracss')
    <style>
        .allButton{
            background-color: darkgreen;
            margin-top: 10px;
            color: white;
        }
        .medicine_text{
            color: darkgreen;
            font-size: 20px;
        }
    </style>
@endsection


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
        <!-- general form elements -->
        <div class="box box-primary">
            <center>
                <button type="button" class="btn allButton trade_button">ট্রেড নাম</button>
                <button type="button" class="btn allButton generic_button">জেনেরিক নাম</button>
                <button type="button" class="btn allButton company_button">কোম্পানি</button>
                <div style="padding-top: 10px;">
                    {{ Form::open(array('url' => 'searchMedicineBackend',  'method' => 'get')) }}
                    {{ csrf_field() }}
                    <input type="text" name="trade_name" id="trade_name"  placeholder=" Search Trade Name"  class="form-control searchMedicine" style="display: none;">
                    <input type="text" name="generic_name" id="generic_name" placeholder="Search Generic Name" class="form-control searchMedicine" style="display: none;">
                    <input type="text" name="company_name" id="company_name" placeholder="Search Company Name" class="form-control searchMedicine" style="display: none;">
                    <button type="submit" class="pull-right" style="display: none;"></button>
                    {{ Form::close() }}
                </div>
            </center>
            <center>
                <a href=" {{url('searchMedicineByLetterBackend/A')}}" class="medicine_text"> <u>A</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/B')}}" class="medicine_text"> <u>B</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/C')}}" class="medicine_text"> <u>C</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/D')}}" class="medicine_text"> <u>D</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/E')}}" class="medicine_text"> <u>E</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/F')}}" class="medicine_text"> <u>F</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/G')}}" class="medicine_text"> <u>G</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/H')}}" class="medicine_text"> <u>H</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/I')}}" class="medicine_text"> <u>I</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/J')}}" class="medicine_text"> <u>J</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/K')}}" class="medicine_text"> <u>K</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/L')}}" class="medicine_text"> <u>L</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/M')}}" class="medicine_text"> <u>M</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/N')}}" class="medicine_text"> <u>N</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/O')}}" class="medicine_text"> <u>O</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/P')}}" class="medicine_text"> <u>P</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/Q')}}" class="medicine_text"> <u>Q</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/R')}}" class="medicine_text"> <u>R</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/S')}}" class="medicine_text"> <u>S</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/T')}}" class="medicine_text"> <u>T</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/U')}}" class="medicine_text"> <u>U</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/V')}}" class="medicine_text"> <u>V</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/W')}}" class="medicine_text"> <u>W</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/X')}}" class="medicine_text"> <u>X</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/Y')}}" class="medicine_text"> <u>Y</u></a>
                <a href=" {{url('searchMedicineByLetterBackend/Z')}}" class="medicine_text"> <u>Z</u></a>
            </center>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">মেডিসিন লিস্ট থেকে আপনার সেলফ তৈরি/আপডেট করুন </h3>
            </div>
            {{ Form::open(array('url' => 'insertTherapyCenter',  'method' => 'post')) }}
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label>সেলফ নাম</label>
                    <select class="form-control select2 medSelf" name="medSelf" style="width: 100%;" required>
                        <option value="" selected>সেলফ নির্বাচন করুন</option>
                    </select>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th>সাবমিট</th>
                        <th>পরিমান </th>
                        <th>ট্রেড নাম </th>
                        <th>জেনেরিক নাম </th>
                        <th>কোম্পানি নাম </th>
                        <th>ইউনিট</th>
                        <th>টাইপ</th>
                    </tr>
                    @foreach($medicineLists as $medicineList)
                        <tr>
                            <td class="td-actions text-center">
                                <button type="button" rel="tooltip" class="btn btn-success medCheckButton" id="{{$medicineList->id}}" value="{{$medicineList->id}}">
                                    <i class="fa fa-arrow-circle-left"></i>
                                </button>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input type="text" class="form-check-input quantity" id="{{'q'.$medicineList->id}}"  name="quantity" value="" size="4">
                                </div>
                            </td>
                            <td> {{$medicineList->name}} </td>
                            <td> {{$medicineList->genre}} </td>
                            <td> {{$medicineList->company}} </td>
                            <td> {{$medicineList->unit}} </td>
                            <td> {{$medicineList->type}} </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        $('.select2').select2();
        $(".trade_button").click(function(){
            $("#trade_name").show();
            $("#generic_name").hide();
            $("#company_name").hide();
        });
        $(".generic_button").click(function(){
            $("#generic_name").show();
            $("#trade_name").hide();
            $("#company_name").hide();
        });
        $(".company_button").click(function(){
            $("#company_name").show();
            $("#trade_name").hide();
            $("#generic_name").hide();
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{url('getAllMedicineSelf')}}',
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                var data = response.data;
                var len = data.length;
                for( var i = 0; i<len; i++){
                    var id = data[i]['id'];
                    var name = data[i]['name'];
                    $(".medSelf").append("<option value='"+id+"'>"+name+"</option>");
                }

            },
            failure: function (msg) {
                alert('an error occured');
            }
        });
        $(".medCheckButton").click(function(){
            var id =$(this).val();
            var quantity =$('#q'+ id).val();
            var $option = $('.medSelf').find('option:selected');
            var value = $option.val();
            if(value) {
                if(quantity){
                    $.ajax({
                        type: 'GET',
                        url: '{{url('insertMedicineIntoSelf')}}',
                        data: {id: id,self_id:value,quantity:quantity},
                        dataType: 'json',
                        success: function (response) {
                            var data = response.data;
                            if(data ==1) {
                                $.toast({
                                    heading: 'ধন্যবাদ',
                                    text: response.msg,
                                    showHideTransition: 'slide',
                                    icon: 'success'
                                })
                            }
                            if(data ==0) {
                                $.toast({
                                    heading: 'দুঃখিত',
                                    text: response.msg,
                                    showHideTransition: 'slide',
                                    icon: 'error'
                                })
                            }
                        }
                    });
                }
                else{
                    $.toast({
                        heading: 'দুঃখিত',
                        text: 'পরিমান নিরবাচন করুন',
                        showHideTransition: 'slide',
                        icon: 'error'
                    })
                }

            }
            else{
                $.toast({
                    heading: 'দুঃখিত',
                    text: 'সেলফ নাম নিরবাচন করুন',
                    showHideTransition: 'slide',
                    icon: 'error'
                })
            }
        });
    </script>
@endsection
