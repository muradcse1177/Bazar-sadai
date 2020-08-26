@extends('backend.layout')
@section('title', 'বিক্রয় ম্যানেজমেন্ট')
@section('page_header', 'বিক্রয় ম্যানেজমেন্ট')
@section('myMedicineSale','active')
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
                <h3 class="box-title">মেডিসিন লিস্ট থেকে আপনার অর্ডার  করুন </h3>
            </div>
            {{ Form::open(array('url' => 'insertMedicineSale',  'method' => 'post')) }}
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label>মেডিসিন নাম</label>
                    <select class="form-control select2 med_name" name="med_name" style="width: 100%;" required>
                        <option value="" selected>মেডিসিন নির্বাচন করুন</option>
                    </select>
                </div>
                <label>পরিমান</label>
                <div class="form-group">
                    <input type="number" class="form-control quantity" name="quantity" placeholder="পরিমান" required>
                </div>
                <label>দাম</label>
                <div class="form-group">
                    <input type="number" class="form-control price" name="price" placeholder="দাম" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn allButton">সেভ করুন</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">মেডিসিন লিস্ট থেকে আপনার বিক্রয় করুন </h3>
            </div>
            <div class="med_order">
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
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        $('.select2').select2();
        $.ajax({
            url: 'getAllMedicineBySelf',
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                var data = response.data;
                var len = data.length;
                for( var i = 0; i<len; i++){
                    var id = data[i]['medicine_id'];
                    var name = data[i]['name'];
                    $(".med_name").append("<option value='"+id+"'>"+name+"</option>");
                }

            },
            failure: function (msg) {
                alert('an error occured');
            }
        });
    </script>
@endsection
