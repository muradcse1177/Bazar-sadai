@extends('backend.layout')
@section('title', 'বুকিং')
@section('page_header', 'বুকিং ব্যবস্থাপনা')
@section('serviceMainLi','active menu-open')
@section('bookingTourAll1','active')
@section('tntMainLi','active menu-open')
@section('extracss')
    <link rel="stylesheet" href="public/asset/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
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
                <div class="box-header with-border">
                    <h3 class="box-title addbut"><button type="button" class="btn btn-block btn-success btn-flat"><i class="fa fa-plus-square"></i> নতুন যোগ করুন </button></h3>
                    <h3 class="box-title rembut" style="display:none;"><button type="button" class="btn btn-block btn-success btn-flat"><i class="fa fa-minus-square"></i> মুছে ফেলুন </button></h3>
                </div>
                <div class="divform" style="display:none">
                    {{ Form::open(array('url' => 'insertTourBooking1',  'method' => 'post','enctype'=> 'multipart/form-data')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <label>বুকিং</label>
                        <div class="form-group">
                            <select class="form-control select2 bookingName" id="bookingName" name="bookingName" style="width: 100%;" required>
                                <option value="" selected> বুকিং নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>দেশ </label>
                            <select class="form-control select2 country" name="country" style="width: 100%;" required>
                                <option value="" selected>দেশ নির্বাচন করুন</option>
                                <option value="বাংলাদেশ">বাংলাদেশ</option>
                                <option value="বিদেশ">বিদেশ</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>প্রধান ঠিকানা </label>
                            <select class="form-control select2 place" name="place" style="width: 100%;" required>
                                <option value="" selected>প্রধান ঠিকানা নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">হোটেল/আবাসিক ভবন/ট্যুর প্যাকেজ নাম</label>
                            <input type="text" class="form-control name" id="name"  name="name" placeholder="নাম লিখুন" required>
                        </div>
                        <div class="form-group">
                            <label for="">পুরা ঠিকানা</label>
                            <input type="text" class="form-control address" id="address"  name="address" placeholder="ঠিকানা লিখুন" required>
                        </div>
                        <div class="form-group">
                            <label for="">কভার ফটো</label>
                            <input type="file" class="form-control cover_photo" accept="image/*" name="cover_photo" placeholder="ছবি" required>
                        </div>
                        <div class="form-group">
                            <label for="">বিবরন</label>
                            <textarea class="textarea description" id="description" placeholder="বিবরন লিখুন" maxlength="3000" name="description"
                                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>
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
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">সকল লিস্ট </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>ছবি </th>
                            <th>বুকিং </th>
                            <th>দেশ </th>
                            <th>স্থান </th>
                            <th>নাম </th>
                            <th>পুরা ঠিকানা </th>
                            <th>টুল</th>
                        </tr>
                        @foreach($tours as $tour)
                            <tr>
                                <td> <img src="{{$tour->cover_photo}}" height="50" width="50"> </td>
                                <td> {{$tour->bookingName}} </td>
                                <td> {{$tour->country}} </td>
                                <td> {{$tour->place}} </td>
                                <td> {{$tour->name}} </td>
                                <td> {{$tour->address}} </td>
                                <td class="td-actions text-center">
                                    <button type="button" rel="tooltip" class="btn btn-success edit" data-id="{{$tour->id}}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" rel="tooltip"  class="btn btn-danger delete" data-id="{{$tour->id}}">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $tours->links() }}
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
                                    {{ Form::open(array('url' => 'deleteTourMainList',  'method' => 'post')) }}
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
    <script src="public/asset/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script>
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
        $('.select2').select2();
        $.ajax({
            url: '{{ url('/') }}/getAllToursListFront',
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                var data = response.data;
                var len = data.length;
                for( var i = 0; i<len; i++){
                    var id = data[i]['name'];
                    var name = data[i]['name'];
                    $(".bookingName").append("<option value='"+id+"'>"+name+"</option>");
                }

            },
            failure: function (msg) {
                alert('an error occured');
            }
        });
        $(".country").change(function(){
            var id =$(this).val();
            $('.place').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getMainPlaceListAll',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['name'];
                        var name = data[i]['name'];
                        $(".place").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(function(){
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
                url: 'getTourMainListById',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    $('.bookingName').val(data.bookingName);
                    $('.name').val(data.name);
                    $('.country').val(data.country);
                    $('.description').val(data.description);
                    $('.address').val(data.address);
                    $('.id').val(data.id);
                    $('.select2').select2();
                }
            });
        }
    </script>
@endsection
