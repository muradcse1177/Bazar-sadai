@extends('backend.layout')
@section('title', 'বিক্রয় রিপোর্ট')
@section('page_header', 'বিক্রয় রিপোর্ট')
@section('myMedicineSalesReport','active')
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
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="divform">
                {{ Form::open(array('url' => 'getSaleReportByDate',  'method' => 'post')) }}
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
                    <button type="submit" class="btn allButton">সাবমিট</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    @if(count($orders)>0)
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title pull-left">আমার অর্ডার</h3>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-bordered medicineList">
                        <tr>
                            <th>তারিখ</th>
                            <th>ট্রেড নাম </th>
                            <th>জেনেরিক নাম </th>
                            <th>কোম্পানি নাম </th>
                            <th>ইউনিট</th>
                            <th>টাইপ</th>
                            <th>পরিমান </th>
                            <th>দাম </th>
                        </tr>
                        <?php
                        $sum =0;
                        ?>
                        @foreach($orders as $order)
                            @php $sum = $sum + $order->sale_price; @endphp
                            <tr class="">
                                <td> {{$order->date}} </td>
                                <td> {{$order->name}} </td>
                                <td> {{$order->genre}} </td>
                                <td> {{$order->company}} </td>
                                <td> {{$order->unit}} </td>
                                <td> {{$order->type}} </td>
                                <td> {{$order->quantity}} </td>
                                <td> {{$order->sale_price}} </td>
                            </tr>
                        @endforeach
                        <tr class="">
                            <td colspan="7" align="right"> মোট </td>
                            <td colspan="8"> {{$sum}} </td>
                        </tr>
                    </table>
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    @else
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title pull-left">কোন ডাটা পাওয়া যাচ্ছে না</h3>
                </div>
            </div>
        </div>
    @endif
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
            $(document).on('click', '.details', function(e){
                e.preventDefault();
                $('#transaction').modal('show');
                var id = $(this).data('id');
                console.log(id);
                $.ajax({
                    type: 'POST',
                    url: 'getMyMedicineOrderById',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id
                    },
                    dataType: 'json',
                    success:function(response){
                        $('#detail').prepend(response.data.list);
                    }
                });
            });

            $("#transaction").on("hidden.bs.modal", function () {
                $('.prepend_items').remove();
            });
        });
    </script>
@endsection
