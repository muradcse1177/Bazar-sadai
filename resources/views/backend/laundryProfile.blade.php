@extends('backend.layout')
@section('title','আমার প্রোফাইল প্রোফাইল')
@section('page_header', 'আমার প্রোফাইল ব্যবস্থাপনা')
@section('laundryProfile','active')
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
        $(function(){
            $(".w_status").change(function(){
                var id =$(this).val();
                $.ajax({
                    type: 'GET',
                    url: 'changeWorkingStatusProvider',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        location.reload();

                    }
                });
            });
        });
        $(function(){
            $(document).on('click', '.details', function(e){
                e.preventDefault();
                $('#transaction').modal('show');
                var id = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: 'getLaundryWashingByIdOwn',
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
