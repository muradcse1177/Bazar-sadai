@extends('backend.layout')
@section('title','চেম্বার')
@section('page_header', 'চেম্বার ব্যবস্থাপনা')
@section('serviceMainLi','active menu-open')
@section('medicalMainLi','active menu-open')
@section('privateChamberList','active')
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
                    {{ Form::open(array('url' => 'insertPrivateChamber',  'method' => 'post')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label> ডিপার্টমেন্ট</label>
                            <select class="form-control select2 department" name="department" id="department" style="width: 100%;" required>
                                <option  value="" selected>ডিপার্টমেন্ট নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label> ডাক্তার নাম </label>
                            <select class="form-control select2 doctor" name="doctor" id="doctor" style="width: 100%;" required>
                                <option  value="" selected>ডাক্তার নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">প্রাইভেট চেম্বার নাম </label>
                            <input type="text" class="form-control name" id="name"  name="name" placeholder=" নাম লিখুন" required>
                        </div>
                        <div class="form-group">
                            <label for="">প্রাইভেট চেম্বার ঠিকানা </label>
                            <input type="text" class="form-control address" id="address"  name="address" placeholder="প্রাইভেট চেম্বার ঠিকানা লিখুন" required>
                        </div>
                        <div class="form-group">
                            <label for="">প্রাইভেট চেম্বার ফিস </label>
                            <input type="number" class="form-control fees" id="fees"  name="fees" min="0" placeholder="প্রাইভেট চেম্বার ফিস লিখুন" required>
                        </div>
                        <div class="form-group">
                            <label for="">ইন টাইম</label>
                            <input type="number" class="form-control intime" id="intime"  name="intime" min="0" placeholder="ইন টাইম" required>
                        </div>
                        <div class="form-group">
                            <label> ইন টাইম  </label>
                            <select class="form-control select2 intimezone" name="intimezone" id="intimezone" style="width: 100%;" required>
                                <option  value="" selected> ইন টাইম নির্বাচন করুন</option>
                                <option  value="AM">AM</option>
                                <option  value="PM">PM</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">আউট টাইম</label>
                            <input type="number" class="form-control outtime" id="outtime"  name="outtime" min="0" placeholder="আউট টাইম" required>
                        </div>
                        <div class="form-group">
                            <label> আউট টাইম  </label>
                            <select class="form-control select2 outtimezone" name="outtimezone" id="outtimezone" style="width: 100%;" required>
                                <option  value="" selected> আউট টাইম নির্বাচন করুন</option>
                                <option  value="AM">AM</option>
                                <option  value="PM">PM</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label> রোগী দেখার দিন সমুহ </label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="saturday" name="days[]" value="Saturday">
                                <label class="form-check-label" for="saturday">Saturday</label>
                                <input type="checkbox" class="form-check-input" id="sunday" name="days[]" value="Sunday">
                                <label class="form-check-label" for="sunday">Sunday</label>
                                <input type="checkbox" class="form-check-input" id="monday" name="days[]" value="Monday">
                                <label class="form-check-label" for="monday">Monday</label>
                                <input type="checkbox" class="form-check-input" id="tuesday" name="days[]" value="Tuesday">
                                <label class="form-check-label" for="tuesday">Tuesday</label>
                                <input type="checkbox" class="form-check-input" id="wednesday" name="days[]" value="Wednesday">
                                <label class="form-check-label" for="wednesday">Wednesday</label>
                                <input type="checkbox" class="form-check-input" id="thursday" name="days[]" value="Thursday">
                                <label class="form-check-label" for="thursday">Thursday</label>
                                <input type="checkbox" class="form-check-input" id="friday" name="days[]" value="Friday">
                                <label class="form-check-label" for="friday">Friday</label>
                            </div>
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
                            <h3 class="box-title">চেম্বার লিস্ট </h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>ডিপার্টমেন্ট </th>
                                    <th>ডাক্তার </th>
                                    <th>চেম্বার নাম </th>
                                    <th>চেম্বার ঠিকানা </th>
                                    <th>ফিস </th>
                                    <th> টাইম </th>
                                    <th>টুল</th>
                                </tr>
                                @foreach($dr_chambers as $dr_chamber)
                                    <tr>
                                        <td> {{$dr_chamber->dep_name}} </td>
                                        <td> {{$dr_chamber->u_name}} </td>
                                        <td> {{$dr_chamber->chamber_name}} </td>
                                        <td> {{$dr_chamber->chamber_address}} </td>
                                        <td> {{$dr_chamber->fees}} </td>
                                        <td> {{$dr_chamber->in_time.''.$dr_chamber->in_timezone .'-'.$dr_chamber->out_time.''.$dr_chamber->out_timezone}} </td>
                                        <td class="td-actions text-center">
                                            <button type="button" rel="tooltip" class="btn btn-success edit" data-id="{{$dr_chamber->ch_id}}">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button" rel="tooltip"  class="btn btn-danger delete" data-id="{{$dr_chamber->ch_id}}">
                                                <i class="fa fa-close"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            {{ $dr_chambers->links() }}
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
                                            {{ Form::open(array('url' => 'deleteChamber',  'method' => 'post')) }}
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
            $.ajax({
                url: 'getAllMedDepartment',
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
                url: 'chamberListsById',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    $('.name').val(data.chamber_name);
                    $('.address').val(data.chamber_address);
                    $('.id').val(data.id);
                    $('.fees').val(data.fees);
                    $('.intime').val(data.in_time);
                    $('.intimezone').val(data.in_timezone);
                    $('.outtime').val(data.out_time);
                    $('.outtimezone').val(data.out_timezone);
                    $('.select2').select2();
                }
            });
        }
        $(".department").change(function(){
            var id =$(this).val();
            $('.doctor').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getDoctorListAll',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['u_id'];
                        var name = data[i]['name'];
                        $(".doctor").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
    </script>
@endsection
