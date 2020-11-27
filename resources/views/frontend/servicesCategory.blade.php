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
            @foreach($services_cat_trans as $services_cat_tran)
                <a href='{{ URL::to('transportService') }}'>
                    <div class='col-sm-4'>
                        <div class='box box-solid'>
                            <div class='box-body prod-body'>
                                <div class="alert boxBody">
                                    <center><strong>{{ $services_cat_tran->name }}</strong></center>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
            @foreach($services_cat_medical as $services_cat_medical)
                <a href='{{ URL::to('serviceSubCategoryMedical/'.$services_cat_medical->id) }}'>
                    <div class='col-sm-4'>
                        <div class='box box-solid'>
                            <div class='box-body prod-body'>
                                <div class="alert boxBody">
                                    <center><strong>{{ $services_cat_medical->name }}</strong></center>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
            @foreach($home_assistants as $home_assistant)
                <a href='{{ URL::to('serviceSubCategoryHomeAssistant/'.$home_assistant->id) }}'>
                    <div class='col-sm-4'>
                        <div class='box box-solid'>
                            <div class='box-body prod-body'>
                                <div class="alert boxBody">
                                    <center><strong>{{ $home_assistant->name }}</strong></center>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
            @foreach($services_cat_couriers as $services_cat_courier)
                <a href='{{ URL::to('courier') }}'>
                    <div class='col-sm-4'>
                        <div class='box box-solid'>
                            <div class='box-body prod-body'>
                                <div class="alert boxBody">
                                    <center><strong>{{ $services_cat_courier->name }}</strong></center>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
@section('js')
@endsection
