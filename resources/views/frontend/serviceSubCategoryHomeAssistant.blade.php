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
    <?php
        $url_arr = array("cookingPageFront", "clothWashingPage", "cleaningPage","helpingHandPage","guardPage","productServicingPage","parlorServicingPage",'laundryServicePage');
        $i=0;
    ?>
    <div class="row">
        <div class="col-md-12">
            @foreach($home_assistant_sub_cats as $home_assistant_sub_cat)
                <a href='{{ url($url_arr[$i])}}'>
                    <div class='col-sm-4'>
                        <div class='box box-solid'>
                            <div class='box-body prod-body'>
                                <div class="alert boxBody">
                                    <center><strong>{{ $home_assistant_sub_cat->name }}</strong></center>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <?php $i++; ?>
            @endforeach
        </div>
    </div>
@endsection
@section('js')
@endsection
