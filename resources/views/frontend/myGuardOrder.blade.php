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
                                    <th>গার্ড নাম</th>
                                    <th>গার্ড ফোন</th>
                                    <th>দিন</th>
                                    <th>ঘণ্টা</th>
                                    <th>ধরণ</th>
                                    <th>দাম</th>
                                </tr>
                                @foreach($washings as $washing)
                                    <tr>
                                        <td>{{$washing->date}}</td>
                                        <td>{{$washing->u_name}}</td>
                                        <td>{{$washing->u_phone}}</td>
                                        <td>{{$washing->name}}</td>
                                        <td>{{$washing->phone}}</td>
                                        <td>{{$washing->days}}</td>
                                        <td>{{$washing->time}}</td>
                                        <td>{{$washing->type}}</td>
                                        <td>{{$washing->price.'/-'}}</td>
                                    </tr>
                                @endforeach
                            </table>
                            {{ $washings->links() }}
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
