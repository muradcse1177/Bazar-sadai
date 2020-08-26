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
        @foreach($therapyCenters as $therapyCenter)
            <div class="col-sm-6">
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
                            <a href="{{URL::to('therapyAppointmentForm/'.$therapyCenter->tf_id)}}" class="btn allButton">বুকিং করুন</a>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
    </div>
@endsection
@section('js')
    <script>
    </script>
@endsection
