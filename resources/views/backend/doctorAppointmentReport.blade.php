@extends('backend.layout')
@section('title', 'ডাক্তার এপয়েনমেন্ট রিপোর্ট')
@section('page_header', 'ডাক্তার এপয়েনমেন্ট রিপোর্ট ব্যবস্থাপনা')
@section('doctorAppointmentLiAdd','active')
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
                    <h3 class="box-title">ডাক্তার এপয়েনমেন্ট রিপোর্ট</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>তারিখ</th>
                            <th>টাইপ</th>
                            <th>ডাক্তার নাম</th>
                            <th>ডাক্তার ফোন নং</th>
                            <th>পেশেন্ট নাম</th>
                            <th>পেশেন্ট ফোন</th>
                            <th>পেশেন্ট বয়স</th>
                            <th>সমস্যা</th>
                            <th>ফিস</th>
                        </tr>

                        @foreach($drReports as $drReport)
                            <tr>
                                <td> {{$drReport-> date}} </td>
                                <td> {{$drReport->dr_name}} </td>
                                <td> {{$drReport->type}} </td>
                                <td> {{$drReport->dr_phone}} </td>
                                <td> {{$drReport->patient_name}} </td>
                                <td> {{$drReport->p_phone}} </td>
                                <td> {{$drReport->age}} </td>
                                <td> {{$drReport->problem}} </td>
                                <td> {{$drReport->price}} </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $drReports->links() }}
                </div>
            </div>

        </div>
    </div>

@endsection
@section('js')
    <script>

    </script>
@endsection
