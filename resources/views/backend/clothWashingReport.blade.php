@extends('backend.layout')
@section('title', 'কাপড় ওয়াশিং রিপোর্ট')
@section('page_header', 'কাপড় ওয়াশিং ব্যবস্থাপনা')
@section('clothWashingReport','active')
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
                    {{ Form::open(array('url' => 'clothWashingReportListByDate',  'method' => 'post')) }}
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
                                <th>বিস্তারিত</th>
                                <th>নাম</th>
                                <th>ফোন</th>
                                <th>ক্লিনার নাম</th>
                                <th>ক্লিনার ফোন</th>
                                <th>দাম</th>
                            </tr>
                            @foreach($washings as $washing)
                                <tr>
                                    <td>{{$washing->date}}</td>
                                    <td class="td-actions text-left">
                                        <button type="button" rel="tooltip" class="btn btn-success details" data-id="{{$washing->c_id}}">
                                            বিস্তারিত
                                        </button>
                                    </td>
                                    <td>{{$washing->u_name}}</td>
                                    <td>{{$washing->u_phone}}</td>
                                    <td>{{$washing->name}}</td>
                                    <td>{{$washing->phone}}</td>
                                    <td>{{$washing->price.'/-'}}</td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $washings->links() }}
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
                                    <table class="table table-bordered">
                                        <thead>
                                        <th>নাম</th>
                                        <th>পরিমান</th>
                                        </thead>
                                        <tbody id="detail">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn allButton pull-right" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                                </div>
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
            $(document).on('click', '.details', function(e){
                e.preventDefault();
                $('#transaction').modal('show');
                var id = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: 'getClothWashingById',
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
