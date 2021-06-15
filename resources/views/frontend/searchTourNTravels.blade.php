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
        <div class="row">
        @foreach($results as $result)
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body cardBody pCard" >
                        <div class="col-sm-12">
                            <img src="{{$result->cover_photo}}" height="170" width="100%"/>
                            <h4>{{$result->name}}</h4>
                            <p class="card-text">লোকেশনঃ {{$result->place}} </p>
                            <p class="card-text">পুরা ঠিকানাঃ {{$result->address}} </p>
                            @if($result->bookingName !='ট্যুর প্যাকেজ')
                                <a href="{{URL::to('bookingHotel?id='.$result->id)}}" class="btn allButton">বিস্তারিত</a>
                            @else
                                <a href="{{URL::to('bookingTourPackage?id='.$result->id)}}" class="btn allButton">বিস্তারিত</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
    @endforeach
    {{ $results->links() }}
</div>
@endsection
@section('js')
<script>
</script>
@endsection
