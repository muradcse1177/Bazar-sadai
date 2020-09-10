@extends('backend.layout')
@section('title','ঔষধ')
@section('page_header', 'ঔষধ  ব্যবস্থাপনা')
@section('allMedicineList','active')

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
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">ঔষধ  লিস্ট </h3>
                    {{ Form::open(array('url' => 'medicineSearchFromAdmin',  'method' => 'get')) }}
                    {{ csrf_field() }}
                    <div class="pull-right">
                        <span>
                            <input type="text" name="proSearch" size="9" value="<?php if(isset($key)) echo $key;?>"> &nbsp;
                            <button type="submit" rel="tooltip"  class=" pull-right" style="height: 25px; text-align: center; background-color: darkgreen; color: white" >
                                <i class="fa fa-arrow-right"></i>
                            </button>
                        </span>
                    </div>
                    {{ Form::close() }}
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th> ট্রেড নাম  </th>
                            <th>  জেনেরিক নাম  </th>
                            <th> স্ট্রেন্থ  </th>
                            <th> কোম্পানি  </th>
                            <th> টাইপ  </th>
                            <th> দাম  </th>
                        </tr>
                        @foreach($allMedicineLists as $allMedicineList)
                            <tr>
                                <td> {{$allMedicineList->name}} </td>
                                <td> {{$allMedicineList->genre}} </td>
                                <td> {{$allMedicineList->strength}} </td>
                                <td> {{$allMedicineList->company}} </td>
                                <td> {{$allMedicineList->type}} </td>
                                <td> {{$allMedicineList->price}} </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $allMedicineLists->links() }}
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
                                    {{ Form::open(array('url' => 'deleteProduct',  'method' => 'post')) }}
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

@endsection
