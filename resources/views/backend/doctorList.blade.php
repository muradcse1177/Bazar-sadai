@extends('backend.layout')
@section('title','ডাক্তার')
@section('page_header', 'ডাক্তার ব্যবস্থাপনা')
@section('serviceMainLi','active menu-open')
@section('medicalMainLi','active menu-open')
@section('doctorList','active')
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
                    <h3 class="box-title">ডাক্তার লিস্ট </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>নাম </th>
                            <th>ডিপার্টমেন্ট </th>
                            <th>হাসপাতাল </th>
                            <th>পদবী </th>
                            <th>বর্তমান কর্মস্থল  </th>
                            <th>শিক্ষা </th>
                            <th>বিশেষজ্ঞ</th>
                        </tr>
                        @foreach($doctorLists as $doctorList)
                            <tr>
                                <td> {{$doctorList->u_name}} </td>
                                <td> {{$doctorList->dept_name}} </td>
                                <td> {{$doctorList->hos_name}} </td>
                                <td> {{$doctorList->designation}} </td>
                                <td> {{$doctorList->current_institute}} </td>
                                <td> {{$doctorList->education}} </td>
                                <td> {{$doctorList->specialized}} </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $doctorLists->links() }}
                </div>
            </div>

        </div>
    </div>


@endsection
@section('js')
    <script>

    </script>
@endsection
