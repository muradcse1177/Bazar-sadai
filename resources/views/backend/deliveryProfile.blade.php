@extends('backend.layout')
@section('title','ডেলিভারি প্রোফাইল')
@section('page_header', 'ডেলিভারি প্রোফাইল ব্যবস্থাপনা')
@section('deliveryProfile','active')
@section('content')
@section('extracss')
    <style>
        .allButton{
            background-color: darkgreen;
            margin-top: 10px;
            color: white;
        }
        .medicine_text{
            color: darkgreen;
            font-size: 20px;
        }
    </style>
@endsection
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
        <div class="box box-primary">
            <div class="box-header with-border">
                <center><h4 class="box-title"><b>স্ট্যাটাস</b></h4></center>
                <div class="box-body">
                    <center>
                        @if($users['info']->working_status == 1 || $users['info']->working_status == 4 || $users['info']->working_status == 0)
                            <input class="form-check-input w_status" type="radio" name="w_status" id="notwork" value="0"  @if($users['info']->working_status == 0) {{'checked'}} @endif>
                            <label class="form-check-label" for="notwork">
                                Not willing to work
                            </label>&nbsp;&nbsp;
                            <input class="form-check-input w_status" type="radio" name="w_status" id="free" value="1" @if($users['info']->working_status == 1) {{'checked'}} @endif>
                            <label class="form-check-label" for="free">
                                Free
                            </label>&nbsp;&nbsp;
                        @endif
                        @if($users['info']->working_status == 2)
                            <input class="form-check-input w_status" type="radio" name="w_status" id="assigned" value="2" @if($users['info']->working_status == 2) {{'checked'}} @endif>
                            <label class="form-check-label" for="free">
                                Assigned
                            </label>&nbsp;&nbsp;
                            <input class="form-check-input w_status" type="radio" name="w_status" id="working" value="3" @if($users['info']->working_status == 3) {{'checked'}} @endif>
                            <label class="form-check-label" for="working">
                                On the working
                            </label>&nbsp;&nbsp;
                        @endif
                        @if($users['info']->working_status == 3)
                            <input class="form-check-input w_status" type="radio" name="w_status" id="working" value="3" @if($users['info']->working_status == 3) {{'checked'}} @endif>
                            <label class="form-check-label" for="working">
                                On the working
                            </label>&nbsp;&nbsp;
                            <input class="form-check-input w_status" type="radio" name="w_status" id="delivered" value="4">
                            <label class="form-check-label" for="delivered">
                                Delivered
                            </label>&nbsp;&nbsp;
                        @endif
                    </center>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h4 class="box-title"><i class="fa fa-calendar"></i> <b>আপনার ডেলিভারি  লিস্ট</b></h4>
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>তারিখ</th>
                            <th>অর্ডার নং</th>
                            <th>ফোন</th>
                            <th>অবস্থা</th>
                            <th>বিস্তারিত</th>
                            <th>পরিমান</th>
                        </tr>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{$order['sales_date']}}</td>
                                <td>{{$order['pay_id']}}</td>
                                <td><a href="tel:{{$order['phone']}}"><button type='button' class='btn btn-success btn-sm btn-flat'>{{$order['phone']}} </button></a></td>
                                <td><button type='button' class='btn btn-danger btn-sm btn-flat u_search' data-id='{{$order['user_id']}}'>{{$order['status']}} </button></td>
                                <td><button type='button' class='btn btn-info btn-sm btn-flat transact' data-id='{{$order['sales_id']}}'><i class='fa fa-search'></i> বিস্তারিত</button></td>
                                <td> {{$order['amount']}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" style="text-align: right"><b>মোটঃ</b></td>
                            <td><b>{{$sum}}</b></td>
                        </tr>
                    </table>
                    {{ $orders->links() }}
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
            $(".w_status").change(function(){
                var id =$(this).val();
                $.ajax({
                    type: 'GET',
                    url: 'changeWorkingStatus',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        location.reload();

                    }
                });
            });
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
