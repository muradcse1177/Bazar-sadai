@extends('frontend.frontLayout')
@section('title', 'বুকিং')
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
            @foreach($tours_sub_cats as $tours_sub_cats)
                <a href='{{ URL::to('bookingPageTNT?scat_id='.$tours_sub_cats->id) }}'>
                    <div class='col-sm-4'>
                        <div class='box box-solid'>
                            <div class='box-body prod-body'>
                                <div class="alert boxBody">
                                    <center><strong>{{ $tours_sub_cats->name }}</strong></center>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    {{ Form::close() }}
@endsection
@section('js')
    <script>
    </script>
@endsection
