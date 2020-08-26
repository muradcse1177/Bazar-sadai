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
                    <a href="{{url('searchMedicineByLetterBackend/A')}}" class="medicine_text"> <u>A</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/B')}}" class="medicine_text"> <u>B</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/C')}}" class="medicine_text"> <u>C</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/D')}}" class="medicine_text"> <u>D</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/E')}}" class="medicine_text"> <u>E</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/F')}}" class="medicine_text"> <u>F</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/G')}}" class="medicine_text"> <u>G</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/H')}}" class="medicine_text"> <u>H</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/I')}}" class="medicine_text"> <u>I</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/J')}}" class="medicine_text"> <u>J</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/K')}}" class="medicine_text"> <u>K</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/L')}}" class="medicine_text"> <u>L</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/M')}}" class="medicine_text"> <u>M</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/N')}}" class="medicine_text"> <u>N</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/O')}}" class="medicine_text"> <u>O</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/P')}}" class="medicine_text"> <u>P</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/Q')}}" class="medicine_text"> <u>Q</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/R')}}" class="medicine_text"> <u>R</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/S')}}" class="medicine_text"> <u>S</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/T')}}" class="medicine_text"> <u>T</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/U')}}" class="medicine_text"> <u>U</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/V')}}" class="medicine_text"> <u>V</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/W')}}" class="medicine_text"> <u>W</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/X')}}" class="medicine_text"> <u>X</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/Y')}}" class="medicine_text"> <u>Y</u></a>
                    <a href="{{url('searchMedicineByLetterBackend/Z')}}" class="medicine_text"> <u>Z</u></a>
                </center>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
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
    </script>
@endsection
