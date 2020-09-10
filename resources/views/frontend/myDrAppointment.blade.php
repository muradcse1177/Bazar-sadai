@extends('frontend.frontLayout')
@section('title', 'প্রোফাইল')
@section('ExtCss')
    <link rel="stylesheet" href="public/asset/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
            @if ($message = Session::get('successMessage'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> ধন্যবাদ</h4>
                    {{ $message }}
                </div>
            @endif
            @if ($message = Session::get('errorMessage'))

                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-warning"></i> দুঃখিত!</h4>
                    {{ $message }}
                </div>
            @endif
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="box-header with-border">
                        <h4 class="box-title"><i class="fa fa-calendar"></i> <b>আপনার ডাক্তার এপয়েনমেনট লিস্ট</b></h4>
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
                                <?php
                                $sum =0;
                                ?>
                                @foreach($drReports as $drReport)
                                    @php
                                        $sum= $sum +$drReport->price;
                                    @endphp
                                    <tr>
                                        <td> {{$drReport-> date}} </td>
                                        <td> {{$drReport->type}} </td>
                                        <td> {{$drReport->dr_name}} </td>
                                        <td> {{$drReport->dr_phone}} </td>
                                        <td> {{$drReport->patient_name}} </td>
                                        <td> {{$drReport->p_phone}} </td>
                                        <td> {{$drReport->age}} </td>
                                        <td> {{$drReport->problem}} </td>
                                        <td> {{$drReport->price.'/-'}} </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="8" style="text-align: right"><b>মোটঃ</b></td>
                                    <td><b>{{$sum.'/-'}}</b></td>
                                </tr>
                            </table>
                            {{ $drReports->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')
    <script>

    </script>
@endsection
