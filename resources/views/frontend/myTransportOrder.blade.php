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
                                    <th>যানবহন</th>
                                    <th>ইউজার</th>
                                    <th>ফ্রম</th>
                                    <th>টু</th>
                                    <th>ইউজার দুরত্ত্ব</th>
                                    <th>ইউজার খরচ</th>
                                    <th>রাইডার দুরত্ত্ব</th>
                                    <th>রাইডার খরচ</th>
                                </tr>
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td> {{$booking['date']}} </td>
                                        <td> {{$booking['transport']}} </td>
                                        <td> {{$booking['user']}} </td>
                                        <td> {{ $booking['add_part1'].', '.$booking['add_part2'].', '.$booking['add_part3'].', '.$booking['add_part4'] }} </td>
                                        <td> {{ $booking['add_partp1'].', '.$booking['add_partp2'].', '.$booking['add_partp3'].', '.$booking['add_partp4'] }} </td>
                                        <td> {{$booking['c_distance']}} </td>
                                        <td> {{$booking['c_cost']}} </td>
                                        <td> {{$booking['r_distance']}} </td>
                                        <td> {{$booking['r_cost']}} </td>
                                    </tr>
                                @endforeach
                            </table>
                            {{ $bookings->links() }}
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
