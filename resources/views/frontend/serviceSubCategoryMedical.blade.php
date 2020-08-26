@extends('frontend.frontLayout')
@section('title', 'সেবাসমুহ')
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
            @foreach($med_services_sub_cat as $med_services_sub_cat)
                @if($med_services_sub_cat->id==16)
                <a href='{{ URL::to('doctorAppointmentForm') }}'>
                    <div class='col-sm-4'>
                        <div class='box box-solid'>
                            <div class='box-body prod-body'>
                                <div class="alert boxBody">
                                    <center><strong>{{ $med_services_sub_cat->name }}</strong></center>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endif
                @if($med_services_sub_cat->id==17)
                <a href='{{ URL::to('therapyServiceForm') }}'>
                    <div class='col-sm-4'>
                        <div class='box box-solid'>
                            <div class='box-body prod-body'>
                                <div class="alert boxBody">
                                    <center><strong>{{ $med_services_sub_cat->name }}</strong></center>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endif
                @if($med_services_sub_cat->id==18)
                <a href='{{ URL::to('diagnosticBookingForm') }}'>
                    <div class='col-sm-4'>
                        <div class='box box-solid'>
                            <div class='box-body prod-body'>
                                <div class="alert boxBody">
                                    <center><strong>{{ $med_services_sub_cat->name }}</strong></center>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endif
            @endforeach
        </div>
    </div>
@endsection
@section('js')
@endsection
