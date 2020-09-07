@extends('backend.layout')
@section('title','কুকিং')
@section('page_header', 'কুকিং ব্যবস্থাপনা')
@section('serviceMainLi','active menu-open')
@section('homeAssistantMainLi','active menu-open')
@section('cookingPage','active')
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
                    {{ Form::open(array('url' => 'insertCooking',  'method' => 'post')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label> ধরণ</label>
                            <select class="form-control select2 type" name="type" id="type" style="width: 100%;" required>
                                <option  value="" selected> ধরণ নির্বাচন করুন</option>
                                <option  value="ডেইলি">ডেইলি</option>
                                <option  value="মাসিক">মাসিক</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>প্রতিদিন মিল</label>
                            <select class="form-control select2 meal" name="meal" id="meal" style="width: 100%;" required>
                                <option  value="" selected> মিল নির্বাচন করুন</option>
                                <option  value="১ বার"> ১ বার</option>
                                <option  value="২ বার"> ২ বার</option>
                                <option  value="৩ বার"> ৩ বার</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>প্রতিদিন মিল</label>
                            <select class="form-control select2 time" name="time" id="time" style="width: 100%;" required>
                                <option  value="" selected> মিল নির্বাচন করুন</option>
                                <option  value="সকাল">সকাল</option>
                                <option  value="দুপুর">দুপুর</option>
                                <option  value="রাত">রাত</option>
                                <option  value="সকাল-দুপুর">সকাল-দুপুর</option>
                                <option  value="সকাল-রাত">সকাল-রাত</option>
                                <option  value="দুপুর-রাত">দুপুর-রাত</option>
                                <option  value="সকাল-দুপুর-রাত">সকাল-দুপুর-রাত</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>কতজনের মিল</label>
                            <select class="form-control select2 person" name="person" id="person" style="width: 100%;" required>
                                <option  value="" selected>কতজনের  মিল নির্বাচন করুন</option>
                                <option  value="১-৩ জন">১-৩ জন</option>
                                <option  value="৪-৬ জন">৪-৬ জন</option>
                                <option  value="৬-১০ জন">৬-১০ জন</option>
                                <option  value="১০-১৫ জন">১০-১৫ জন</option>
                                <option  value="১৫-২০ জন">১৫-২০ জন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>লিঙ্গ</label>
                            <select class="form-control select2 gender" name="gender" id="gender" style="width: 100%;" required>
                                <option  value="" selected>লিঙ্গ নির্বাচন করুন</option>
                                <option  value="মহিলা">মহিলা</option>
                                <option  value="পুরুষ">পুরুষ</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">দাম </label>
                            <input type="number" class="form-control price" id="price"  name="price" placeholder="দাম লিখুন" required>
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
                    <h3 class="box-title">কুকিং লিস্ট </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>কুকিং ধরন </th>
                            <th>মিল </th>
                            <th>পারসন </th>
                            <th>সময় </th>
                            <th>লিঙ্গ </th>
                            <th>দাম </th>
                            <th>টুল</th>
                        </tr>
                        @foreach($cookings as $cooking)
                            <tr>
                                <td> {{$cooking->cooking_type}}</td>
                                <td> {{$cooking->meal}} </td>
                                <td> {{$cooking->person}} </td>
                                <td> {{$cooking->time}} </td>
                                <td> {{$cooking->gender}} </td>
                                <td> {{$cooking->price}} </td>
                                <td class="td-actions text-center">
                                    <button type="button" rel="tooltip" class="btn btn-success edit" data-id="{{$cooking->id}}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" rel="tooltip"  class="btn btn-danger delete" data-id="{{$cooking->id}}">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $cookings->links() }}
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
                                    {{ Form::open(array('url' => 'deleteCooking',  'method' => 'post')) }}
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
            $('.select2').select2()
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
                url: 'getCookingList',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    $('#type').val(data.cooking_type);
                    $('.id').val(data.id);
                    $('#meal').val(data.meal);
                    $('#time').val(data.time);
                    $('#gender').val(data.gender);
                    $('#person').val(data.person);
                    $('#price').val(data.price);
                    $('.select2').select2();
                }
            });
        }
    </script>
@endsection
