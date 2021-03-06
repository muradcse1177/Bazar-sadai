@extends('backend.layout')
@section('title', 'বিক্রয় রিপোর্ট')
@section('page_header', 'বিক্রয় রিপোর্ট ব্যবস্থাপনা')
@section('ticketSalesLiAdd','active')
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
                    {{ Form::open(array('url' => 'getTicketSalesOrderListByDate',  'method' => 'post')) }}
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
                    <h3 class="box-title">বিক্রয় রিপোর্ট</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>নাম</th>
                            <th>ফোন</th>
                            <th>ই-মেইল</th>
                            <th>ফ্রম</th>
                            <th>টু</th>
                            <th>পরিবহন নাম</th>
                            <th>ধরণ</th>
                            <th>তারিখ</th>
                            <th>সময়</th>
                            <th>লোকসংখ্যা</th>
                            <th>দাম</th>
                        </tr>
                        <?php
                            $sum =0;
                        ?>
                        @foreach($ticket_Sales as $ticket_Sale)
                            @php
                                   $sum= $sum +$ticket_Sale->price;
                            @endphp
                            <tr>
                                <td> {{$ticket_Sale-> name}} </td>
                                <td> {{$ticket_Sale->phone}} </td>
                                <td> {{$ticket_Sale->email}} </td>
                                <td> {{$ticket_Sale->from_address}} </td>
                                <td> {{$ticket_Sale->to_address}} </td>
                                <td> {{$ticket_Sale->transport_name}} </td>
                                <td> {{$ticket_Sale->transport_type}} </td>
                                <td> {{$ticket_Sale->date}} </td>
                                <td> {{$ticket_Sale->transport_time}} </td>
                                <td> {{$ticket_Sale->adult}} </td>
                                <td> {{$ticket_Sale->price.'/-'}} </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="10" style="text-align: right"><b>মোটঃ</b></td>
                            <td><b>{{$sum.'/-'}}</b></td>
                        </tr>
                    </table>
                    {{ $ticket_Sales->links() }}
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
