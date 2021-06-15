@extends('backend.layout')
@section('title','হিসাব')
@section('page_header', 'হিসাব ব্যবস্থাপনা')
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
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title addbut"><button type="button" class="btn btn-block btn-success btn-flat"><i class="fa fa-plus-square"></i> নতুন যোগ করুন </button></h3>
                <h3 class="box-title rembut" style="display:none;"><button type="button" class="btn btn-block btn-success btn-flat"><i class="fa fa-minus-square"></i> মুছে ফেলুন </button></h3>
                <h3 class="box-title rembut2" ><button type="button" class="btn btn-block btn-success btn-flat"><i class="fa fa-eye"></i> রিপোর্ট দেখুন </button></h3>
            </div>
            <div class="divform" style="display:none">
                {{ Form::open(array('url' => 'insertM_acc',  'method' => 'post')) }}
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label>কোম্পানি নাম</label>
                        <select class="form-control select2 company" name="company" style="width: 100%;" required>
                            <option value="" selected>কোম্পানি নির্বাচন করুন</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>প্রোজেক্ট নাম</label>
                        <select class="form-control select2 project" name="project" style="width: 100%;" required>
                            <option value="" selected>প্রোজেক্ট নির্বাচন করুন</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>হিসাব ধরণ নাম</label>
                        <select class="form-control select2 type" name="type" style="width: 100%;" required>
                            <option value="" selected>হিসাব ধরণ  নির্বাচন করুন</option>
                            <option value="Cash In" >Cash In</option>
                            <option value="Cash Out" >Cash Out</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">তারিখ</label>
                        <input type="text" class="form-control date" id="date"  name="date" placeholder="তারিখ লিখুন" required>
                    </div>
                    <div class="form-group">
                        <label for="">পারপাস</label>
                        <input type="text" class="form-control purpose" id="purpose"  name="purpose" placeholder="পারপাস লিখুন" required>
                    </div>
                    <div class="form-group">
                        <label for="">রেফারেন্স</label>
                        <input type="text" class="form-control reference" id="reference"  name="reference" placeholder="রেফারেন্স লিখুন" required>
                    </div>
                    <div class="form-group">
                        <label for="">প্রাপ্ত ব্যক্তি</label>
                        <input type="text" class="form-control person" id="person"  name="person" placeholder="প্রাপ্ত ব্যক্তি" required>
                    </div>
                    <div class="form-group">
                        <label for="">পরিমান</label>
                        <input type="number" class="form-control amount" id="amount"  name="amount" placeholder="পরিমান লিখুন" required>
                    </div>
                </div>
                <div class="box-footer">
                    <input type="hidden" name="id" id="id" class="id">
                    <button type="submit" class="btn allButton">সেভ করুন</button>
                </div>
                {{ Form::close() }}
            </div>
            <div class="divform2" style="display:none;">
                {{ Form::open(array('url' => 'getM_accReportByDate',  'method' => 'post')) }}
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label for="">ফ্রম ডেট</label>
                        <input type="text" class="form-control from_date" id="from_date"  name="from_date" placeholder="ফ্রম ডেট লিখুন" required value="@if(isset($from_date)){{$from_date}} @endif">
                    </div>
                    <div class="form-group">
                        <label for="">টু ডেট</label>
                        <input type="text" class="form-control to_date" id="to_date"  name="to_date" placeholder="টু ডেট লিখুন" required value="@if(isset($to_date)){{$to_date}} @endif">
                    </div>
                </div>
                <div class="box-footer">
                    <input type="hidden" name="id" id="id" class="id">
                    <button type="submit" class="btn allButton">সাবমিট</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">হিসাব  লিস্ট </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th>টুল</th>
                        <th>তারিখ  </th>
                        <th>হিসাব ধরণ  </th>
                        <th>কোম্পানি  </th>
                        <th>প্রোজেক্ট  </th>
                        <th>পারপাস  </th>
                        <th>রেফারেন্স  </th>
                        <th>ব্যক্তি  </th>
                        <th>পরিমান(In)  </th>
                        <th>পরিমান(Out)  </th>
                    </tr>
                    @php
                        $sumIn=0;
                        $sumOut=0;
                    @endphp
                    @foreach($accountings as $accounting)
                        <tr>
                            <td class="td-actions text-center">
                                <button type="button" rel="tooltip" class="btn btn-success edit" data-id="{{$accounting->id}}">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </td>
                            <td style="text-align: right;"> {{$accounting-> date}} </td>
                            <td style="text-align: right;"> {{$accounting->type}} </td>
                            <td style="text-align: right;"> {{$accounting->company}} </td>
                            <td style="text-align: right;"> {{$accounting->project}} </td>
                            <td style="text-align: right;"> {{$accounting->purpose}} </td>
                            <td style="text-align: right;"> {{$accounting->reference}} </td>
                            <td style="text-align: right;"> {{$accounting->person}} </td>
                            @if($accounting->type == 'Cash In')
                                <td style="text-align: right;"> {{$accounting->amount}}/- </td>
                                @php
                                    $sumIn = $sumIn + $accounting->amount;
                                @endphp
                            @else
                                <td style="text-align: right;"> {{0}}/- </td>
                            @endif
                            @if($accounting->type == 'Cash Out')
                                <td style="text-align: right;"> {{$accounting->amount}}/- </td>
                                @php
                                    $sumOut = $sumOut + $accounting->amount
                                @endphp
                            @else
                                <td style="text-align: right;"> {{0}}/- </td>
                            @endif
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="8" style="text-align: right;">মোটঃ-</td>
                        <td style="text-align: right;">{{$sumIn}} /-</td>
                        <td style="text-align: right;">{{$sumOut}} /-</td>
                    </tr>
                </table>
                {{ $accountings->links() }}
            </div>
        </div>
    </div>
</div>


@endsection
@section('js')
    <script>
        $( function() {
            $('#date').datepicker({
                autoclose: true,
                dateFormat: "yy-m-dd",
            })
        } );
        $( function() {
            $('#from_date').datepicker({
                autoclose: true,
                dateFormat: "yy-m-dd",
            })
        } );
        $( function() {
            $('#to_date').datepicker({
                autoclose: true,
                dateFormat: "yy-m-dd",
            })
        } );
        $(document).ready(function(){
            $(".addbut").click(function(){
                $(".divform").show();
                $(".rembut").show();
                $(".addbut").hide();
                $(".divform2").hide();
            });
            $(".rembut").click(function(){
                $(".divform").hide();
                $(".addbut").show();
                $(".rembut").hide();
                $(".divform2").hide();
            });
            $(".rembut2").click(function(){
                $(".divform2").show();
                $(".divform").hide();
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
        });
        function getRow(id){
            $.ajax({
                type: 'POST',
                url: 'getM_accListById',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    $('.company').val(data.company);
                    $('.project').val(data.project);
                    $('.type').val(data.type);
                    $('.date').val(data.date);
                    $('.purpose').val(data.purpose);
                    $('.amount').val(data.amount);
                    $('.person').val(data.person);
                    $('.reference').val(data.reference);
                    $('.id').val(data.id);
                    $('.select2').select2()
                }
            });
        }
        $(document).ready(function(){
            $.ajax({
                url: 'getAllCompany',
                type: "GET",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['name'];
                        var name = data[i]['name'];
                        $(".company").append("<option value='"+id+"'>"+name+"</option>");
                    }

                },
                failure: function (msg) {
                    alert('an error occured');
                }
            });
            $.ajax({
                url: 'getAllProject',
                type: "GET",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['name'];
                        var name = data[i]['name'];
                        $(".project").append("<option value='"+id+"'>"+name+"</option>");
                    }

                },
                failure: function (msg) {
                    alert('an error occured');
                }
            });
        });
    </script>
@endsection
