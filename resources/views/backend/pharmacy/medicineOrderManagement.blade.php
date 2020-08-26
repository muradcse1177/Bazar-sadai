@extends('backend.layout')
@section('title', 'অর্ডার ম্যানেজমেন্ট')
@section('page_header', 'অর্ডার ম্যানেজমেন্ট')
@section('medicineOrderManagement','active')
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
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">মেডিসিন লিস্ট থেকে আপনার অর্ডার করুন </h3>
            </div>
            {{ Form::open(array('url' => 'insertMedicineOrder',  'method' => 'post')) }}
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label>কোম্পানি নাম</label>
                    <select class="form-control select2 company" name="company" style="width: 100%;" required>
                        <option value="" selected>কোম্পানি নির্বাচন করুন</option>
                    </select>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="med_order" style="display: none;">
                <div class="box-body table-responsive">
                    <table class="table table-bordered medicineList">
                        <tr>
                            <th>#</th>
                            <th>পরিমান </th>
                            <th>ট্রেড নাম </th>
                            <th>জেনেরিক নাম </th>
                            <th>কোম্পানি নাম </th>
                            <th>ইউনিট</th>
                            <th>টাইপ</th>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="form-group">
                        <input type="text" class="form-control" name="price" placeholder="আনুমানিক খরচ" required>
                    </div>
                    <button type="submit" class="btn allButton">সেভ করুন</button>
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
            url: 'getAllMedicineCompany',
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                var data = response.data;
                var len = data.length;
                for( var i = 0; i<len; i++){
                    var id = data[i]['company'];
                    var name = data[i]['company'];
                    $(".company").append("<option value='"+id+"'>"+name+"</option>");
                }

            },
            failure: function (msg) {
                alert('an error occured');
            }
        });
        $(".company").change(function(){
            var id =$(this).val();
            if(id) {
                $.ajax({
                    type: 'GET',
                    url: 'selectMedicineByCompany',
                    data: {id: id},
                    dataType: 'json',
                    success: function (response) {
                        $(".medicineList").find("tr:gt(0)").remove();
                        var trHTML = '';
                        var data = response.data;
                        for(var  i=0; i<data.length; i++) {
                            trHTML +=
                                '<tr>' +
                                    '<td>' +
                                        '<div class="form-check">' +
                                        '<input type="checkbox" class="form-check-input medCheckbox" name="med_id[]"  value="'+ data[i].id  +'"' +
                                        '</div>' +
                                    '</td>' +
                                    '<td>' +
                                        '<div class="form-check">' +
                                        '<input type="text" class="form-check-input quantity" name="quantity[]" size="4" id="q'+data[i].id+'" ' +
                                        '</div>' +
                                    '</td>' +
                                    '<td>' + data[i].name +
                                    '</td>' +
                                    '<td>' + data[i].genre +
                                    '</td>' +
                                    '<td>' + data[i].company +
                                    '</td>' +
                                    '<td>' + data[i].unit +
                                    '</td>' +
                                    '<td>' + data[i].type +
                                    '</td>' +
                                '</tr>';
                        }
                        $('.medicineList').append(trHTML);
                        $('.med_order').show();
                    }
                });
            }
            else{
                $.toast({
                    heading: 'দুঃখিত',
                    text: 'কোম্পানি নাম নিরবাচন করুন',
                    showHideTransition: 'slide',
                    icon: 'error'
                })
            }
        });
    </script>
@endsection
