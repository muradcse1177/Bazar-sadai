@extends('frontend.frontLayout')
@section('title', 'ট্যুর ও ট্রাভেল')
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
        $j=0;
    ?>
    <div class="row">
        @foreach($results as $result)
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body cardBody pCard" >
                        <div class="col-sm-12">
{{--                            <img src="{{$result->cover_photo}}" height="170" width="100%"/>--}}
                            <div id="myCarousel<?php echo $j; ?>" class="carousel slide" data-ride="carousel">
                                <?php
                                    $photo = json_decode($result->photo);
                                    $photos = explode(",",$photo);
                                    array_pop($photos);
                                    //dd($photos);
                                    $i=0;
                                ?>
                                <ol class="carousel-indicators">
                                @foreach($photos as $ph)
                                    <!-- Indicators -->
                                        @if($i==0)
                                        <li data-target="#myCarousel<?php echo $j; ?>" data-slide-to="<?php echo rand()?>" class="active"></li>
                                        @else
                                        <li data-target="#myCarousel<?php echo $j; ?>" data-slide-to="<?php echo rand()?>"></li>
                                        @endif
                                    <?php $i++; ?>
                                @endforeach
                                </ol>
                                <?php
                                    $i=0;
                                ?>
                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    @foreach($photos as $ph)
                                        @if($i==0)
                                        <div class="item active">
                                            <img src="{{$ph}}"  style="width:100%;" height="170">
                                        </div>
                                        @else
                                        <div class="item">
                                            <img src="{{$ph}}"  style="width:100%; height: 170px;">
                                        </div>
                                        @endif
                                        <?php $i++; ?>
                                    @endforeach
                                </div>
                                <a class="left carousel-control" href="#myCarousel<?php echo $j; ?>" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control" href="#myCarousel<?php echo $j; ?>" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                            <h4>{{$result->name}}</h4>
                            <p class="card-text">পুরা ঠিকানাঃ {{$result->address}} </p>
                            <p class="card-text">ধরণঃ  {{$result->t_type}} </p>
                            <p class="card-text">খরচঃ {{$result->price}} </p>
                            <div style="text-align: justify;">বিবরনঃ {!! nl2br($result->description) !!} </div>
                            <div style="text-align: justify;">সুযোগ সুবিধাঃ {!! nl2br($result->facilities) !!} </div><br>
                            <a href="{{URL::to('bookingHNT?id='.$result->t_id.'&name_id='.$result->id)}}" class="btn allButton">বুকিং করুন</a>

                        </div>
                    </div>
                </div>
            </div>
            <?php  $j++; ?>
        @endforeach
        {{ $results->links() }}
    </div>
@endsection
@section('js')
    <script>
    </script>
@endsection
