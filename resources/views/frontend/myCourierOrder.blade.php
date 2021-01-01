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
                                    <th>অর্ডার আইডি</th>
                                    <th>মেসেজ</th>
                                    <th>স্ট্যাটাস</th>
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
                                        <td> {{$booking['status']}}</td>
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
                        </div>
                    </div>
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
@endsection
@section('js')
    <script>
        $(document).on('click', '.status', function(e){
            e.preventDefault();
            var msgId = $(this).data('m');
            $('#msgStatusModal').modal('show');
            $.ajax({
                type: 'GET',
                url: 'getCourierMessageBuyer',
                data: {id:msgId},
                success: function(response){
                    var data = response.output;
                    //console.log(data);
                    $('#statusBody').html(data.list);
                }
            });
        });
    </script>
@endsection
