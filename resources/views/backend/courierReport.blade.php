@extends('backend.layout')
@section('title', 'কুরিয়ার রিপোর্ট')
@section('page_header', 'কুরিয়ার রিপোর্ট ব্যবস্থাপনা')
@section('courierReport','active')
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
                    {{ Form::open(array('url' => 'courierListByDate',  'method' => 'post')) }}
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
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">রিপোর্ট</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>তারিখ</th>
                            <th>পে আইডি</th>
                            <th>স্ট্যাটাস</th>
                            <th>মেসেজ</th>
                            <th>ইউজার</th>
                            <th>ফোন</th>
                            <th>ওজন</th>
                            <th>খরচ</th>
                            <th>দেশ</th>
                            <th>ফ্রম</th>
                            <th>টু</th>
                        </tr>
                        @foreach($bookings as $booking)
                            <tr>
                                <td> {{$booking['date']}} </td>
                                <td> {{$booking['tx_id']}} </td>
                                <td>
                                    <button type="button" rel="tooltip" class="btn btn-success edit" data-id="{{$booking['id']}}">
                                        <i class="fa fa-edit"></i>{{$booking['status']}}
                                    </button>
                                </td>
                                <td>
                                    <button type="button" rel="tooltip" class="btn btn-success msg" data-msg="{{$booking['cc_id']}}">
                                        <i class="fa fa-edit"></i> Set Message
                                    </button>
                                </td>
                                <td>
                                    <button type="button" rel="tooltip" class="btn btn-success status" data-m="{{$booking['cc_id']}}">
                                        <i class="fa fa-eye"></i> Status
                                    </button>
                                </td>
                                <td> {{$booking['user']}} </td>
                                <td> {{$booking['user_phone']}} </td>
                                <td> {{$booking['weight']}} </td>
                                <td> {{$booking['cost'].'/-'}} </td>
                                <td> {{$booking['n_name']}} </td>
                                <td> {{ $booking['add_part1'].', '.$booking['add_part2'].', '.$booking['add_part3'].', '.$booking['add_part4'] }} </td>
                                <td> {{ $booking['add_part1C'].', '.$booking['add_part2C'].', '.$booking['add_part3C'].', '.$booking['add_part4C'].', '.$booking['add_part5C'].', '.$booking['address'] }} </td>

                            </tr>
                        @endforeach
                    </table>
                    {{ $bookings->links() }}
                </div><div class="modal fade"  tabindex="-1"   id="statusModal"  role="dialog">
                    <div class="modal-dialog modal-medium">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">স্ট্যাটাস</h4>
                            </div>
                            {{ Form::open(array('url' => 'changeCourierStatusAdmin',  'method' => 'post')) }}
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>স্ট্যাটাস</label>
                                        <select class="form-control select2 status" name="status" style="width: 100%;" required>
                                            <option value="" selected>স্ট্যাটাস  নির্বাচন করুন</option>
                                            <option value="On the way">On the way</option>
                                            <option value="Delivered">Delivered</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="id" id="id" class="id">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success btn-flat contact"><i class="fa fa-check-square-o"></i> Save</button>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                <div class="modal fade"  tabindex="-1"   id="msgModal"  role="dialog">
                    <div class="modal-dialog modal-medium">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">মেসেজ স্ট্যাটাস</h4>
                            </div>
                            {{ Form::open(array('url' => 'changeCourierMessageAdmin',  'method' => 'post')) }}
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="box-body">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="">মেসেজ</label>
                                            <input type="text" class="form-control message" id="message"  name="message" placeholder="মেসেজ" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="msg" id="msg" class="msg">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success btn-flat contact"><i class="fa fa-check-square-o"></i> Save</button>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                <div class="modal fade"  tabindex="-1"   id="msgStatusModal"  role="dialog">
                    <div class="modal-dialog modal-medium">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">মেসেজ স্ট্যাটাস</h4>
                            </div>
                            <div class="modal-body">
                                <div class="box-body">
                                    <div id="statusBody">

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
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
        $(function(){
            $(document).on('click', '.edit', function(e){
                e.preventDefault();
                $('#statusModal').modal('show');
                var id = $(this).data('id');
                $('#id').val(id);
            });
            $(document).on('click', '.msg', function(e){
                e.preventDefault();
                $('#msgModal').modal('show');
                var msg = $(this).data('msg');
                $('#msg').val(msg);
            });
            $(document).on('click', '.status', function(e){
                e.preventDefault();
                var msgId = $(this).data('m');
                $('#msgStatusModal').modal('show');
                $.ajax({
                    type: 'GET',
                    url: 'getCourierMessageAdmin',
                    data: {id:msgId},
                    success: function(response){
                        var data = response.output;
                        //console.log(data);
                        $('#statusBody').html(data.list);
                    }
                });
            });
        });
    </script>
@endsection
