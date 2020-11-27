@extends('backend.layout')
@section('title','নেমিং ৫')
@section('page_header', 'নেমিং ৫ ব্যবস্থাপনা')
@section('mainLiAdd','active menu-open')
@section('naming5','active')
@section('mainForeignLiAdd','active menu-open')
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
                <div class="box-header with-border">
                    <h3 class="box-title addbut"><button type="button" class="btn btn-block btn-success btn-flat"><i class="fa fa-plus-square"></i> নতুন যোগ করুন </button></h3>
                    <h3 class="box-title rembut" style="display:none;"><button type="button" class="btn btn-block btn-success btn-flat"><i class="fa fa-minus-square"></i> মুছে ফেলুন </button></h3>
                </div>
                <div class="divform" style="display:none">
                    {{ Form::open(array('url' => 'insertNaming5',  'method' => 'post')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label>দেশের নাম</label>
                            <select class="form-control select2 div_name" name="divId" style="width: 100%;" required>
                                <option value="" selected>দেশ  নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>নেমিং ২ নাম</label>
                            <select class="form-control select2 dis_name" name="disId" style="width: 100%;" required>
                                <option value="" selected>নেমিং ২ নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>নেমিং  ৩ নাম</label>
                            <select class="form-control select2 upz_name" name="upzId" style="width: 100%;" required>
                                <option value="" selected>নেমিং ৩ নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>নেমিং ৪ নাম</label>
                            <select class="form-control select2 uni_name" name="uniId" style="width: 100%;" required>
                                <option value="" selected>নেমিং ৪  নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for=""> নেমিং  ৫</label>
                            <input type="text" class="form-control name5" id="name5"  name="name5" placeholder="নেমিং  ৫ লিখুন" required>
                        </div>
                        <div class="form-group">
                            <label for="">নাম </label>
                            <input type="text" class="form-control name" id="name"  name="name" placeholder="নাম লিখুন" required>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" id="id" class="id">
                        <button type="submit" class="btn btn-primary">সেভ করুন</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">নেমিং ৫  লিস্ট </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th> দেশ </th>
                            <th>নেমিং -২  </th>
                            <th>নেমিং -৩ </th>
                            <th>নেমিং ৪ </th>
                            <th>নেমিং ৫ </th>
                            <th>নাম </th>
                            <th>টুল</th>
                        </tr>
                        @foreach($naming5s as $naming5)
                            <tr>
                                <td> {{$naming5-> divName}} </td>
                                <td> {{$naming5-> disName}} </td>
                                <td> {{$naming5-> upzName}} </td>
                                <td> {{$naming5-> uniName}} </td>
                                <td> {{$naming5->naming5}} </td>
                                <td> {{$naming5->name}} </td>
                                <td class="td-actions text-center">
                                    <button type="button" rel="tooltip" class="btn btn-success edit" data-id="{{$naming5->id}}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" rel="tooltip"  class="btn btn-danger delete" data-id="{{$naming5->id}}">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $naming5s->links() }}
                    <div class="modal modal-danger fade" id="modal-danger">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">মুছে ফেলতে চান</h4>
                                </div>
                                <div class="modal-body">
                                    <center><p>মুছে ফেলতে চান?</p></center>
                                </div>
                                <div class="modal-footer">
                                    {{ Form::open(array('url' => 'deleteNaming5',  'method' => 'post')) }}
                                    {{ csrf_field() }}
                                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">না</button>
                                    <button type="submit" class="btn btn-outline">হ্যা</button>
                                    <input type="hidden" name="id" id="id" class="id">
                                    {{ Form::close() }}
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection
@section('js')
    <script>

        $(document).ready(function(){
            $.ajax({
                url: 'getAllNaming1',
                type: "GET",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".div_name").append("<option value='"+id+"'>"+name+"</option>");
                    }

                },
                failure: function (msg) {
                    alert('an error occured');
                }
            });
        });
        $(document).ready(function(){
            $(".addbut").click(function(){
                $(".divform").show();
                $(".rembut").show();
                $(".addbut").hide();
            });
            $(".rembut").click(function(){
                $(".divform").hide();
                $(".addbut").show();
                $(".rembut").hide();
            });

        });
        $(function(){
            $('.select2').select2()
            $(document).on('click', '.edit', function(e){
                e.preventDefault();
                $('.divform').show();
                var id = $(this).data('id');
                getRow(id);
            });
            $(document).on('click', '.delete', function(e){
                e.preventDefault();
                $('#modal-danger').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });
        });
        function getRow(id){
            $.ajax({
                type: 'POST',
                url: 'getNaming5List',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    $('.name').val(data.name);
                    $('.name5').val(data.naming5);
                    $('.id').val(data.id);
                    $('.select2').select2()
                }
            });
        }
        $(".div_name").change(function(){
            var id =$(this).val();
            $('.dis_name').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getNaming2ListAll',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".dis_name").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".dis_name").change(function(){
            var id =$(this).val();
            $('.upz_name').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getNaming3ListAll',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".upz_name").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".upz_name").change(function(){
            var id =$(this).val();
            $('.uni_name').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getNaming4ListAll',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".uni_name").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
    </script>
@endsection
