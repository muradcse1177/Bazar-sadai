@extends('frontend.frontLayout')
@section('title', 'ডায়াগনস্টিক এপয়েনমেন্ট')
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
    {{ Form::open(array('url' => 'searchDiagnosticListFront',  'method' => 'post')) }}
    {{ csrf_field() }}
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <select class="form-control select2 department" id="department" name="department" style="width: 100%;" required>
                    <option value="" selected>ডায়াগনস্টিক নির্বাচন করুন</option>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <button type="submit" class="btn allButton">সার্চ করুন</button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection
@section('js')
    <script>
        $('.select2').select2();
        $.ajax({
            url: 'getAllDiagnosticTest',
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                var data = response.data;
                var len = data.length;
                for( var i = 0; i<len; i++){
                    var id = data[i]['id'];
                    var name = data[i]['name'];
                    $(".department").append("<option value='"+id+"'>"+name+"</option>");
                }

            },
            failure: function (msg) {
                alert('an error occured');
            }
        });
    </script>
@endsection
