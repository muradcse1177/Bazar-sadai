@extends('frontend.frontLayout')
@section('title', 'থেরাপি এপয়েনমেন্ট')
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
    <?php
    function en2bn($number) {
        $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $bn_number = str_replace($search_array, $replace_array, $number);
        return $bn_number;
    }
    ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body cardBody">
                    <div class="col-sm-12">
                        <h3 class="card-title">{{$therapyCenter->center_name}}</h3>
                        <p class="card-text">থেরাপিঃ {{$therapyCenter->name}} </p>
                        <p class="card-text">ফিসঃ {{en2bn($therapyCenter->fees.' টাকা')}} </p>
                        <p class="card-text">সময়ঃ {{en2bn($therapyCenter->time).'মিনিট'}} </p>
                        <p class="card-text">থেরাপি নেওয়ার সময়ঃ {{$therapyCenter->intime.' '.$therapyCenter->intimezone.'-'.$therapyCenter->outtime.' '.$therapyCenter->outtimezone}} </p>
                        <p class="card-text">থেরাপি নেওয়ার দিনঃ
                            <?php
                            $days = json_decode($therapyCenter->days);
                            foreach ($days as $day){
                                echo $day.','.' ';
                            }

                            ?>
                        </p>
                        <h3 class="card-title">{{"এপয়েনমেন্ট ফর্ম পুরন করুন" }}</h3>
                        {{ Form::open(array('url' => 'insertTherapyAppointment',  'method' => 'post')) }}
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" class="form-control date" name="date" id="date" placeholder="তারিখ নির্বাচন করুন " required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control patient_name" name="patient_name" id="patient_name" placeholder="রোগীর নাম" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control patient_address" name="patient_address" id="patient_address" placeholder="রোগীর ঠিকানা" required>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control patient_age" name="age" id="age" placeholder="বয়স" required>
                            <input type="hidden" class="form-control" name="tf_id" value="{{$therapyCenter->tf_id}}" required>
                            <input type="hidden" class="form-control" name="fees" value="{{$therapyCenter->fees}}" required>
                        </div>
                        <div class="form-group">
                            <textarea type="text" class="form-control problem" name="problem" id="problem" placeholder="সমস্যা" required></textarea>
                        </div>
                        @if(Cookie::get('user_id'))
                            <div class="form-group">
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
            $('#date').datepicker({
                autoclose: true,
                minDate:0,
                dateFormat: "yy-m-dd",
            })

        } );
    </script>
@endsection
