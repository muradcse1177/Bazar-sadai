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
                        <h4 class="box-title"><i class="fa fa-calendar"></i> <b>আপনার পণ্য ক্রয় লিস্ট</b></h4>
                        <div class="box-body table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>তারিখ</th>
                                    <th>অর্ডার নং</th>
                                    <th>দায়িত্ত্ব</th>
                                    <th>ফোন</th>
                                    <th>অবস্থা</th>
                                    <th>বিস্তারিত</th>
                                    <th>পরিমান</th>
                                </tr>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{$order['sales_date']}}</td>
                                        <td>{{$order['pay_id']}}</td>
                                        <td><a href='{{$order['v_id']}}'><button type='button' class='btn btn-success btn-sm btn-flat'>{{$order['v_name']}} </button></a></td>
                                        <td><a href="tel:{{$order['deliver_phone']}}"><button type='button' class='btn btn-success btn-sm btn-flat'>{{$order['deliver_phone']}} </button></a></td>
                                        <td><button type='button' class='btn btn-danger btn-sm btn-flat u_search' data-id='{{$order['user_id']}}'>{{$order['status']}} </button></td>
                                        <td><button type='button' class='btn btn-info btn-sm btn-flat transact' data-id='{{$order['sales_id']}}'><i class='fa fa-search'></i> বিস্তারিত</button></td>
                                        <td> {{$order['amount']}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="6" style="text-align: right"><b>মোটঃ</b></td>
                                    <td><b>{{$sum}}</b></td>
                                </tr>
                            </table>
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="transaction">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><b>বিস্তারিত ট্রানজেকশন</b></h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            তারিখ: <span id="date"></span>
                            <span class="pull-right">ট্রানজেকশন: <span id="transid"></span></span>
                        </p>
                        <table class="table table-bordered">
                            <thead>
                            <th>পন্য</th>
                            <th>দাম</th>
                            <th>পরিমান</th>
                            <th>মোট</th>
                            </thead>
                            <tbody id="detail">
                            <tr>
                                <td colspan="3" align="right"><b> ডেলিভারি চার্জ </b></td>
                                <td><span id="delivery"></span></td>
                            </tr>
                            <tr>
                                <td colspan="3" align="right"><b>সর্বমোট </b></td>
                                <td><span id="total"></span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(function(){
            $(document).on('click', '.transact', function(e){
                e.preventDefault();
                $('#transaction').modal('show');
                var id = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: 'transaction',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id
                    },
                    dataType: 'json',
                    success:function(response){
                        $('#date').html(response.data.date);
                        $('#transid').html(response.data.transaction);
                        $('#detail').prepend(response.data.list);
                        $('#total').html(response.data.total);
                        $('#delivery').html(response.data.delivery_charge);
                    }
                });
            });

            $("#transaction").on("hidden.bs.modal", function () {
                $('.prepend_items').remove();
            });
        });
    </script>
@endsection
