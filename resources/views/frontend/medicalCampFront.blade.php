@extends('frontend.frontLayout')
@section('title', 'থেডিকেল ক্যাম্প')
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
        @foreach($medCamps as $medCamp)
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body cardBody">
                        <div class="col-sm-12">
                            <h3 class="card-title"> {{$medCamp['name']}}</h3>
                            <p class="card-text">ঠিকানাঃ {{$medCamp['add_part1'].', '.$medCamp['add_part2'].', '.$medCamp['add_part3'].', '.$medCamp['add_part4'].', '.$medCamp['add_part5'].', '.$medCamp['address'] }} </p>
                            <p class="card-text">যোগাযোগঃ {{$medCamp['email'].' ,'.$medCamp['phone']}} </p>
                            <p class="card-text">উদ্দেশ্যঃ {{$medCamp['purpose']}} </p>
                            <p class="card-text">শুরুঃ {{$medCamp['start_date']}} </p>
                            <p class="card-text">শেষঃ {{$medCamp['end_date']}} </p>
                            <p class="card-text">ওপেনারঃ {{$medCamp['user']}} </p>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{$medCamps->links()}}
    </div>
@endsection
@section('js')
    <script>
    </script>
@endsection
