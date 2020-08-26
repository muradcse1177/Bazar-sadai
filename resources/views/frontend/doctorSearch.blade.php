@extends('frontend.frontLayout')
@section('title', 'ডাক্তার লিস্ট')
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
        ?>
        @foreach($doctorLists as $doctorList)
        <div class="card">
            <div class="card-body cardBody">
                <div class="col-sm-3">
                    @if($doctorList->photo)
                        <img src="{{URL::to($doctorList->photo)}}" height="220px" width="220px">
                    @else
                        <img src="{{URL::to('public/asset/images/doctor.png')}}" height="220px" width="220px">
                    @endif
                </div>
                <div class="col-sm-9">
                    <h3 class="card-title">{{$doctorList->dr_name}}</h3>
                    <p class="card-text">বর্তমান কর্মস্থলঃ {{$doctorList->current_institute}} </p>
                    <p class="card-text">স্পেশালিষ্টঃ {{$doctorList->name}} </p>
                    <p class="card-text">পদবীঃ  {{$doctorList->designation}} </p>
                    <p class="card-text">শিক্ষাঃ {{$doctorList->education}} </p>
                    <p class="card-text">হাস্পাতালঃ {{$doctorList->hos_name}} </p>
                    <p class="card-text">ঠিকানাঃ  {{$doctorList->dr_address}} </p>
                    <a href="{{URL::to('doctorProfileFront/'.$doctorList->u_id.'&'.$d_type)}}" class="btn allButton">প্রোফাইল দেখুন</a>
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
