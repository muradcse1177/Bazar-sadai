@extends('frontend.frontLayout')
@section('title', 'প্রোফাইল')
@section('ExtCss')
    <link rel="stylesheet" href="public/asset/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
            @if ($message = Session::get('successMessage'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> ধন্যবাদ</h4>
                    {{ $message }}
                </div>
            @endif
            @if ($message = Session::get('errorMessage'))

                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-warning"></i> দুঃখিত!</h4>
                    {{ $message }}
                </div>
            @endif
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="box-header with-border">
                        <h4 class="box-title"><i class="fa fa-calendar"></i> <b>আপনার লিস্ট</b></h4>
                        <div class="box-body table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>তারিখ</th>
                                    <th>নাম</th>
                                    <th>ফোন</th>
                                    <th>কুকার নাম</th>
                                    <th>কুকার ফোন</th>
                                    <th>ধরণ</th>
                                    <th>দিন</th>
                                    <th>মিল</th>
                                    <th>জন</th>
                                    <th>সময়</th>
                                    <th>দাম</th>
                                </tr>
                                @foreach($cookings as $cooking)
                                    <tr>
                                        <td>{{$cooking->date}}</td>
                                        <td>{{$cooking->u_name}}</td>
                                        <td>{{$cooking->u_phone}}</td>
                                        <td>{{$cooking->name}}</td>
                                        <td>{{$cooking->phone}}</td>
                                        <td>{{$cooking->cooking_type}}</td>
                                        <td>{{$cooking->days}}</td>
                                        <td>{{$cooking->meal}}</td>
                                        <td>{{$cooking->person}}</td>
                                        <td>{{$cooking->time}}</td>
                                        <td>{{$cooking->price.'/-'}}</td>
                                    </tr>
                                @endforeach
                            </table>
                            {{ $cookings->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')
    <script>

    </script>
@endsection
