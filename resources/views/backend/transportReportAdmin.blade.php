@extends('backend.layout')
@section('title', 'পরিবহন রিপোর্ট')
@section('page_header', 'পরিবহন রিপোর্ট ব্যবস্থাপনা')
@section('transportReportAdmin','active')
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
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="divform">
                    {{ Form::open(array('url' => 'transportListByDate',  'method' => 'post')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="">ফ্রম ডেট</label>
                            <input type="text" class="form-control from_date" id="from_date"  name="from_date" placeholder="ফ্রম ডেট লিখুন" required value="@if(isset($from_date)){{$from_date}} @endif">
                        </div>
                        <div class="form-group">
                            <label for="">টু ডেট</label>
                            <input type="text" class="form-control to_date" id="to_date"  name="to_date" placeholder="টু ডেট লিখুন" required value="@if(isset($to_date)){{$to_date}} @endif">
                        </div>
                        <div class="form-group">
                            <label for="">যানবহন</label>
                            <select id="transport" name ="transport" class="form-control select2 transport" style="width: 100%;" required="required">
                                <option value="" selected>যানবহন  নির্বাচন করুন</option>
                                <option value="Motorcycle">মোটর সাইকেল</option>
                                <option value="Private Car">প্রাইভেট কার</option>
                                <option value="Micro Bus">মাইক্রো বাস</option>
                                <option value="Ambulance">এম্বুলেন্স</option>
                            </select>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" id="id" class="id">
                        <button type="submit" class="btn btn-primary">সাবমিট</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">পরিবহন রিপোর্ট</h3>
                </div>
                <!-- /.box-header -->
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

@endsection
@section('js')
    <script>
        $( function() {
            $('#from_date').datepicker({
                autoclose: true,
                dateFormat: "yy-m-dd",
            })
        } );
        $( function() {
            $('#to_date').datepicker({
                autoclose: true,
                dateFormat: "yy-m-dd",
            })
        } );
    </script>
@endsection
