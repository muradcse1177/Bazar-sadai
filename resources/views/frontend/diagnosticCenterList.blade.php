@extends('frontend.frontLayout')
@section('title', 'ডায়াগনস্টিক এপয়েনমেন্ট')
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
        @foreach($diagnosticCenterLists as $diagnosticCenterLists)
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body cardBody">
                        <div class="col-sm-12">
                            <h3 class="card-title">{{$diagnosticCenterLists->center_name}}</h3>
                            <p class="card-text">টেস্টঃ {{$diagnosticCenterLists->name}} </p>
                            <p class="card-text">ফিসঃ {{en2bn($diagnosticCenterLists->fees.' টাকা')}} </p>
                            <p class="card-text">টেস্ট করার সময়ঃ {{$diagnosticCenterLists->intime.' '.$diagnosticCenterLists->intimezone.'-'.$diagnosticCenterLists->outtime.' '.$diagnosticCenterLists->outtimezone}} </p>
                            <p class="card-text">টেস্ট করার দিনঃ
                                <?php
                                $days = json_decode($diagnosticCenterLists->days);
                                foreach ($days as $day){
                                    echo $day.','.' ';
                                }

                                ?>
                            </p>
                            <a href="{{URL::to('diagnosticAppointmentForm/'.$diagnosticCenterLists->df_id)}}" class="btn allButton">বুকিং করুন</a>
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
