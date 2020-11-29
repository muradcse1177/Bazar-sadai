@extends('backend.layout')
@section('title', 'কুকিং রিপোর্ট')
@section('page_header', 'কুকিং রিপোর্ট ব্যবস্থাপনা')
@section('cookingReport','active')
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
                    {{ Form::open(array('url' => 'cookingReportListByDate',  'method' => 'post')) }}
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
                    <h4 class="box-title"><i class="fa fa-calendar"></i> <b>আপনার লিস্ট</b></h4>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>তারিখ</th>
                                <th>নাম</th>
                                <th>ফোন</th>
                                <th>কুকার নাম</th>
                                <th>কুকার ফোন</th>
                                <th>ধরণ</th>
                                <th>দিন</th>
                                <th>মিল</th>
                                <th>জন</th>
                                <th>সময়</th>
                                <th>দাম</th>
                            </tr>
                            @foreach($cookings as $cooking)
                                <tr>
                                    <td>{{$cooking->date}}</td>
                                    <td>{{$cooking->u_name}}</td>
                                    <td>{{$cooking->u_phone}}</td>
                                    <td>{{$cooking->name}}</td>
                                    <td>{{$cooking->phone}}</td>
                                    <td>{{$cooking->cooking_type}}</td>
                                    <td>{{$cooking->days}}</td>
                                    <td>{{$cooking->meal}}</td>
                                    <td>{{$cooking->person}}</td>
                                    <td>{{$cooking->time}}</td>
                                    <td>{{$cooking->price.'/-'}}</td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $cookings->links() }}
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
