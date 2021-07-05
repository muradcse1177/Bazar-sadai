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
        <div class="col-sm-12 mainSlide">
            <div class="card">
                <div class="card-body cardBody pCard">
                    <div class="col-sm-12">
                        <div class="col-sm-12">
                            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                <?php
                                $i=0;
                                ?>
                                <ol class="carousel-indicators">
                                @foreach($slides as $ph)
                                    <!-- Indicators -->
                                        @if($i==0)
                                            <li data-target="#myCarousel" data-slide-to="<?php echo rand()?>" class="active"></li>
                                        @else
                                            <li data-target="#myCarousel" data-slide-to="<?php echo rand()?>"></li>
                                        @endif
                                        <?php $i++; ?>
                                    @endforeach
                                </ol>
                            <?php
                            $i=0;
                            ?>
                            <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    @foreach($slides as $ph)
                                        @if($i==0)
                                            <div class="item active">
                                                <img class="mainImg" src="{{url('public/asset/images/'.$ph->slide)}}"  style="width:100%;">
                                            </div>
                                        @else
                                            <div class="item">
                                                <img class="mainImg" src="{{url('public/asset/images/'.$ph->slide)}}"  style="width:100%;">
                                            </div>
                                        @endif
                                        <?php $i++; ?>
                                    @endforeach
                                </div>
                                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
            <?php
            $url_arr = array("buySaleAnimal", "buySale");
            $i=0;
            ?>
            @foreach($se_categories as $secategory)
            <a href='{{ url($url_arr[$i].'/'.$secategory->id)}}'>
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
            <?php $i++; ?>
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
            <a href='{{ URL::to('forHumanity') }}'>
                <div class='col-sm-4'>
                    <div class='box box-solid'>
                        <div class='box-body prod-body'>
                            <div class="alert boxBody">
                                <center><strong>মানুষ মানুষের জন্য</strong></center>
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
