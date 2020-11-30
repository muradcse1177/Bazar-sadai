@extends('frontend.frontLayout')
@section('title', 'ডাক্তার প্রোফাইল')
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
        <?php
        $noimage = 'public/asset/images/doctor.png';
        function en2bn($number) {
            $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
            $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
            $bn_number = str_replace($search_array, $replace_array, $number);
            return $bn_number;
        }
        ?>
        <div class="card">
            <div class="card-body cardBody">
                <div class="col-sm-3">
                    @if($doctorProfile->photo)
                        <img src="{{URL::to($doctorProfile->photo)}}" height="220px" width="220px">
                    @else
                        <img src="{{URL::to('public/asset/images/doctor.png')}}" height="220px" width="220px">
                    @endif
                </div>
                <div class="col-sm-9">
                    <h3 class="card-title">{{$doctorProfile->dr_name}}</h3>
                    <p class="card-text">বর্তমান কর্মস্থলঃ {{$doctorProfile->current_institute}} </p>
                    <p class="card-text">স্পেশালিষ্টঃ {{$doctorProfile->name}} </p>
                    <p class="card-text">পদবীঃ  {{$doctorProfile->designation}} </p>
                    <p class="card-text">শিক্ষাঃ {{$doctorProfile->education}} </p>
                    <p class="card-text">হাস্পাতালঃ {{$doctorProfile->hos_name}} </p>
                    <p class="card-text">ঠিকানাঃ  {{$doctorProfile->dr_address}} </p>
                    <p class="card-text">ফিসঃ  {{en2bn($doctorProfile->fees).' টাকা'}} </p>
                    <p class="card-text">রোগী দেখার সময়ঃ  {{$doctorProfile->in_time.''.$doctorProfile->in_timezone.'-'.$doctorProfile->out_time.''.$doctorProfile->in_timezone}} </p>
                    <p class="card-text">রোগী দেখার দিন সমুহঃ
                        <?php
                        $days = json_decode($doctorProfile->days);
                        foreach ($days as $day){
                            echo $day.','.' ';
                        }

                        ?>
                    </p>
                    <p class="card-text">বিশেষ যোগ্যতাঃ  {{$doctorProfile->specialized}} </p>
                    <p class="card-text">অভিজ্ঞতাঃ   {{$doctorProfile->experience}} </p>
                    <p class="card-text">ই-মেইলঃ   {{$doctorProfile->email}} </p>
                    <h3 class="card-title">{{"এপয়েনমেন্ট ফর্ম পুরন করুন" }}</h3>
                    {{ Form::open(array('url' => 'insertLocalAppointmentPayment',  'method' => 'post')) }}
                    {{ csrf_field() }}

                    <div class="form-group">
                        <input type="text" class="form-control date" name="date" id="date" placeholder="তারিখ" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control patient_name" name="patient_name" id="patient_name" placeholder="রোগীর নাম" required>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control patient_name" name="age" id="age" placeholder="বয়স" required>
                        <input type="hidden" class="form-control" name="type" value="{{$type}}" required>
                        <input type="hidden" class="form-control" name="dr_id" value="{{$doctorProfile->u_id}}" required>
                        <input type="hidden" class="form-control" name="fees" value="{{$doctorProfile->fees}}" required>
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
