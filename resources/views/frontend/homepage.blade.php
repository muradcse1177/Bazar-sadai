@extends('frontend.frontLayout')
@section('title', 'হোম')
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
            @foreach($p_categories as $category)
                    <a href='{{ URL::to('product/'.$category->id) }}'>
                        <div class='col-sm-4'>
                            <div class='box box-solid'>
                                <div class='box-body prod-body'>
                                    <div class="alert boxBody">
                                        <center><strong>{{ $category->name }}</strong></center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
            @endforeach
            @foreach($se_categories as $secategory)
            <a href='{{ URL::to('buySale/'.$secategory->id) }}'>
                <div class='col-sm-4'>
                    <div class='box box-solid'>
                        <div class='box-body prod-body'>
                            <div class="alert boxBody">
                                <center><strong>{{ $secategory->name }}</strong></center>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
            <a href='{{ URL::to('serviceCategory') }}'>
                <div class='col-sm-4'>
                    <div class='box box-solid'>
                        <div class='box-body prod-body'>
                            <div class="alert boxBody">
                                <center><strong>সেবা সমুহ</strong></center>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
@section('js')
<script>
    setTimeout(function () {
        $('#signupModal').modal('show');
    }, 20000);
</script>
@endsection
