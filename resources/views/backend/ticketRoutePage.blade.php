@extends('backend.layout')
@section('title','টিকেট রুট')
@section('page_header', 'টিকেট রুট ব্যবস্থাপনা')
@section('serviceMainLi','active menu-open')
@section('transportMainLi','active menu-open')
@section('ticketRoute','active')
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
                    {{ Form::open(array('url' => 'insertTicketRoute',  'method' => 'post')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label> যানবহন ধরণ</label>
                            <select class="form-control select2 transportType" name="transport_id" style="width: 100%;" required>
                                <option value="" selected>যানবহন ধরণ নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">ফ্রম </label>
                            <input type="text" class="form-control from_address" id="from_address"  name="from_address" placeholder="ফ্রম লিখুন" required>
                        </div>
                        <div class="form-group">
                            <label for="">টু </label>
                            <input type="text" class="form-control to_address" id="to_address"  name="to_address" placeholder="টু লিখুন" required>
                        </div>
                        <div class="form-group">
                            <label>পরিবহন নাম</label>
                            <select class="form-control select2 coach_id" name="coach_id" style="width: 100%;" required>
                                <option  value="" selected> পরিবহন নাম নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label> ধরণ</label>
                            <select class="form-control select2 type" name="type_id" style="width: 100%;" required>
                                <option  value="" selected> ধরণ নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">দাম </label>
                            <input type="number" class="form-control price" id="price"  name="price" placeholder="দাম লিখুন" required>
                        </div>
                        <div class="form-group">
                            <label for="">সময় </label>
                            <input type="text" class="form-control time" id=""  name="time" placeholder="10.00 am এভাবে লিখুন" required>
                        </div>
                        <div class="form-group">
                            <label> স্ট্যাটাস </label>
                            <select class="form-control select2 status" name="status" style="width: 100%;" required>
                                <option  value="" selected> স্ট্যাটাস নির্বাচন করুন</option>
                                <option value="1">একটিভ </option>
                                <option value="2">ইন একটিভ</option>
                            </select>
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
                    <h3 class="box-title">বিভাগ লিস্ট </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>নাম </th>
                            <th>ফ্রম </th>
                            <th> টু </th>
                            <th> কোচ নাম </th>
                            <th> কোচ টাইপ  </th>
                            <th> দাম  </th>
                            <th> সময়  </th>
                            <th> স্ট্যাটাস  </th>
                            <th>টুল</th>
                        </tr>

                        @foreach($transports_tickets as $transports_ticket)
                            <tr>
                                <td> {{$transports_ticket->name}} </td>
                                <td> {{$transports_ticket->from_address}} </td>
                                <td> {{$transports_ticket->to_address}} </td>
                                <td> {{$transports_ticket->coach_name}} </td>
                                <td> {{$transports_ticket->type}} </td>
                                <td> {{$transports_ticket->price}} </td>
                                <td> {{$transports_ticket->time}} </td>
                                <td>
                                    @if($transports_ticket->status==1)
                                        {{'একটিভ '}}
                                    @else
                                    {{'ইন একটিভ'}}
                                    @endif
                                </td>
                                <td class="td-actions text-center">
                                    <button type="button" rel="tooltip" class="btn btn-success edit" data-id="{{$transports_ticket->tid}}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" rel="tooltip"  class="btn btn-danger delete" data-id="{{$transports_ticket->tid}}">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $transports_tickets->links() }}
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
                                    {{ Form::open(array('url' => 'deleteTransportsTickets',  'method' => 'post')) }}
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
                url: 'getAllTransportList',
                type: "GET",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".transportType").append("<option value='"+id+"'>"+name+"</option>");
                    }

                },
                failure: function (msg) {
                    alert('an error occured');
                }
            });

            $(".transportType").change(function(){
                var id =$(this).val();
                $('.type').find('option:not(:first)').remove();
                $.ajax({
                    type: 'GET',
                    url: 'getTransportTypeList',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        var data = response.data;
                        var len = data.length;
                        for( var i = 0; i<len; i++){
                            var id = data[i]['id'];
                            var name = data[i]['type'];
                            $(".type").append("<option value='"+id+"'>"+name+"</option>");
                        }
                    }
                });
            });
            $(".transportType").change(function(){
                var id =$(this).val();
                $('.coach_id').find('option:not(:first)').remove();
                $.ajax({
                    type: 'GET',
                    url: 'getCoachListById',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        var data = response.data;
                        var len = data.length;
                        for( var i = 0; i<len; i++){
                            var id = data[i]['id'];
                            var name = data[i]['coach_name'];
                            $(".coach_id").append("<option value='"+id+"'>"+name+"</option>");
                        }
                    }
                });
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
                url: 'getTicketRouteList',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    $('.from_address').val(data.from_address);
                    $('.from_address').val(data.from_address);
                    $('.to_address').val(data.to_address);
                    $('.price').val(data.price);
                    $('.id').val(data.id);
                }
            });
        }
    </script>
@endsection
