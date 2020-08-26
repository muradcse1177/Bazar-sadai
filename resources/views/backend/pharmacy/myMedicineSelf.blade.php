@extends('backend.layout')
@section('title', 'সেলফ ম্যানেজমেন্ট')
@section('page_header', 'সেলফ ম্যানেজমেন্ট')
@section('myMedicineSelf','active')
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
                <h3 class="box-title pull-left">আমার সেলফ</h3>
                <span>
                    <select class="form select2 medSelf pull-right" name="medSelf">
                        <option value="" selected>সেলফ নির্বাচন করুন</option>
                    </select>
                </span>
            </div>
            <!-- /.box-header -->
            <div class="Nodata" style="display: none;">
                <p> কোন ডাটা পাওয়া জাচ্ছে না</p>
            </div>
            <div class="box-body table-responsive medDiv">
                <table class="table table-bordered medicineList">
                    <tr>
                        <th>সেলফ নাম </th>
                        <th>ট্রেড নাম </th>
                        <th>পরিমান </th>
                        <th>জেনেরিক নাম </th>
                        <th>কোম্পানি নাম </th>
                        <th>ইউনিট</th>
                        <th>টাইপ</th>
                    </tr>
                    @foreach($medicineLists as $medicineList)
                        <tr class="">
                            <td> {{$medicineList->self_name}} </td>
                            <td> {{$medicineList->name}} </td>
                            <td> {{$medicineList->quantity}} </td>
                            <td> {{$medicineList->genre}} </td>
                            <td> {{$medicineList->company}} </td>
                            <td> {{$medicineList->unit}} </td>
                            <td> {{$medicineList->type}} </td>
                        </tr>
                    @endforeach
                </table>
                {{ $medicineLists->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        $.ajax({
            url: 'getAllMedicineSelf',
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                var data = response.data;
                var len = data.length;
                for( var i = 0; i<len; i++){
                    var id = data[i]['id'];
                    var name = data[i]['name'];
                    $(".medSelf").append("<option value='"+id+"'>"+name+"</option>");
                }

            },
            failure: function (msg) {
                alert('an error occured');
            }
        });
        $(".medSelf").change(function(){
            var id =$(this).val();
            if(id) {
                $.ajax({
                    type: 'GET',
                    url: 'selectSelfById',
                    data: {id: id},
                    dataType: 'json',
                    success: function (response) {
                        $(".medicineList").find("tr:gt(0)").remove();
                        var trHTML = '';
                        var data = response.data;
                        if(data.length>0){
                            $('.Nodata').hide();
                            $('.medDiv').show();
                            for(var  i=0; i<data.length; i++) {
                                trHTML +=
                                    '<tr><td>' + data[i].self_name +
                                    '</td><td>' + data[i].name +
                                    '</td><td>' + data[i].quantity +
                                    '</td><td>' + data[i].genre +
                                    '</td><td>' + data[i].company +
                                    '</td><td>' + data[i].unit +
                                    '</td><td>' + data[i].type +
                                    '</td></tr>';
                            }
                            $('.medicineList').append(trHTML);
                        }
                        else{
                            $('.Nodata').show();
                            $('.medDiv').hide();
                        }
                    }
                });
            }
            else{
                $.toast({
                    heading: 'দুঃখিত',
                    text: 'সেলফ নিরবাচন করুন',
                    showHideTransition: 'slide',
                    icon: 'error'
                })
            }
        });
    </script>
@endsection
