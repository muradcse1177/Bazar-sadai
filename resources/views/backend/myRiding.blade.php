@extends('backend.layout')
@section('title', 'রাইডিং')
@section('page_header', 'রাইডিং ব্যবস্থাপনা')
@section('myRiding','active')
@section('extracss')
@endsection
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
                    {{ Form::open(array('url' => 'myRidingListByDate',  'method' => 'post')) }}
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
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">রাইড লিস্ট </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>তারিখ</th>
                            <th>দুরত্ত্ব সেট</th>
                            <th>ইউজার</th>
                            <th>ফোন</th>
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
                                <td>
                                    <button type="button" rel="tooltip" class="btn btn-success distance" data-id="{{$booking['id']}}">
                                        দুরত্ত্ব সেট
                                    </button>
                                </td>
                                <td> {{$booking['user']}} </td>
                                <td> {{$booking['phone']}} </td>
                                <td> {{ $booking['add_part3'].', '.$booking['add_part4'] }} </td>
                                <td> {{ $booking['add_partp3'].', '.$booking['add_partp4'] }} </td>
                                <td> {{$booking['c_distance']}} </td>
                                <td> {{$booking['c_cost']}} </td>
                                <td> {{$booking['r_distance']}} </td>
                                <td> {{$booking['r_cost']}} </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $bookings->links() }}
                </div>
                <div class="modal fade"  tabindex="-1"   id="distance"  role="dialog">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">দুরত্ত্ব সেট</h4>
                            </div>
                            {{ Form::open(array('url' => 'setRiderDistance',  'method' => 'post')) }}
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <input class="form-control" name="distance" id="setDistance" placeholder="দুরত্ত্ব সেট">
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="id" id="id" class="id">
                                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">সেভ করুন</button>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
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
        $(document).on('click', '.distance', function(e){
            e.preventDefault();
            var id = $(this).data('id');
            $('.id').val(id);
            $('#distance').modal('show');
        });
    </script>
@endsection
