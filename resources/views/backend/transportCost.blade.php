@extends('backend.layout')
@section('title','পরিবহন খরচ নির্ধারণ')
@section('page_header', 'পরিবহন খরচ ব্যবস্থাপনা')
@section('transportCost','active')
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
                    {{ Form::open(array('url' => 'insertTransportCost',  'method' => 'post')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label>যানবহন নাম</label>
                            <select class="form-control select2 transport" name="transport" style="width: 100%;" required>
                                <option value="" selected>যানবহন  নির্বাচন করুন</option>
                                <option value="Motorcycle">মোটর সাইকেল</option>
                                <option value="Micro Bus">মাইক্রো বাস</option>
                                <option value="Private Car">প্রাইভেট কার</option>
                                <option value="Ambulance">এম্বুলেন্স</option>
                                <option value="Truck">ট্রাক</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="minCost">সর্বনিম্ন খরচ</label>
                            <input type="text" class="form-control minCost" id="minCost"  name="minCost" placeholder="সর্বনিম্ন খরচ লিখুন" required>
                        </div>
                        <div class="form-group">
                            <label for="km1">১০ কিমি থেকে কম (প্রতি কিমি খরচ) </label>
                            <input type="text" class="form-control km1" id="km1"  name="km1" placeholder="১০ কিমি থেকে কম" required>
                        </div>
                        <div class="form-group">
                            <label for="km2">১০-৩০ কিমি (প্রতি কিমি খরচ) </label>
                            <input type="text" class="form-control km2" id="km2"  name="km2" placeholder="১০-৩০ কিমি" required>
                        </div>
                        <div class="form-group">
                            <label for="km3">৩০-৫০ কিমি (প্রতি কিমি খরচ) </label>
                            <input type="text" class="form-control km3" id="km3"  name="km3" placeholder="৩০-৫০ কিমি" required>
                        </div>
                        <div class="form-group">
                            <label for="km4">৫০-১০০ কিমি (প্রতি কিমি খরচ) </label>
                            <input type="text" class="form-control km4" id="km4"  name="km4" placeholder="৫০-১০০ কিমি" required>
                        </div>
                        <div class="form-group">
                            <label for="km5">১০০ কিমি থেকে বেশি (প্রতি কিমি খরচ) </label>
                            <input type="text" class="form-control km5" id="km5"  name="km5" placeholder="১০০ কিমি থেকে বেশি" required>
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
                    <h3 class="box-title">খরচ  লিস্ট </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>যানবহন  </th>
                            <th>সর্বনিম্ন খরচ  </th>
                            <th>১-১০ কিমি </th>
                            <th>১০-৩০ কিমি </th>
                            <th>৩০-৫০ কিমি </th>
                            <th>৫০-১০০ কিমি </th>
                            <th> ১০০-~ কিমি </th>
                            <th>টুল</th>
                        </tr>
                        @foreach($costs as $cost)
                            <tr>
                                <td> {{$cost-> transport_type}} </td>
                                <td> {{$cost->minCost}} </td>
                                <td> {{$cost->km1.'/-'}} </td>
                                <td> {{$cost->km2.'/-'}} </td>
                                <td> {{$cost->km3.'/-'}} </td>
                                <td> {{$cost->km4.'/-'}} </td>
                                <td> {{$cost->km5.'/-'}} </td>
                                <td class="td-actions text-center">
                                    <button type="button" rel="tooltip" class="btn btn-success edit" data-id="{{$cost->id}}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" rel="tooltip"  class="btn btn-danger delete" data-id="{{$cost->id}}">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $costs->links() }}
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
                                    {{ Form::open(array('url' => 'deleteTransportCost',  'method' => 'post')) }}
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
                url: 'getTransportCostList',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    $('.transport').val(data.transport_type);
                    $('.minCost').val(data.minCost);
                    $('.km1').val(data.km1);
                    $('.km2').val(data.km2);
                    $('.km3').val(data.km3);
                    $('.km4').val(data.km4);
                    $('.km5').val(data.km5);
                    $('.id').val(data.id);
                    $('.select2').select2()
                }
            });
        }
    </script>
@endsection
