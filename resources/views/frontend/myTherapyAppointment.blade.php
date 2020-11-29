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
                        <h4 class="box-title"><i class="fa fa-calendar"></i> <b>আপনার থেরাপি এপয়েনমেনট লিস্ট</b></h4>
                        <div class="box-body table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>তারিখ</th>
                                    <th>থেরাপি নাম</th>
                                    <th>থেরাপি সেন্টার</th>
                                    <th>পেশেন্ট নাম</th>
                                    <th>পেশেন্ট ফোন</th>
                                    <th>পেশেন্ট বয়স</th>
                                    <th>সিরিয়াল</th>
                                    <th>ঠিকানা</th>
                                    <th>সমস্যা</th>
                                    <th>ফিস</th>
                                </tr>
                                <?php
                                $sum =0;
                                ?>
                                @foreach($therapyReports as $therapyReport)
                                    @php
                                        $sum= $sum +$therapyReport->price;
                                    @endphp
                                    <tr>
                                        <td> {{$therapyReport-> date}} </td>
                                        <td> {{$therapyReport->name}} </td>
                                        <td> {{$therapyReport->center_name}} </td>
                                        <td> {{$therapyReport->patient_name}} </td>
                                        <td> {{$therapyReport->phone}} </td>
                                        <td> {{$therapyReport->age}} </td>
                                        <td> {{$therapyReport->serial}} </td>
                                        <td> {{$therapyReport->address}} </td>
                                        <td> {{$therapyReport->problem}} </td>
                                        <td> {{$therapyReport->price.'/-'}} </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="8" style="text-align: right"><b>মোটঃ</b></td>
                                    <td><b>{{$sum.'/-'}}</b></td>
                                </tr>
                            </table>
                            {{ $therapyReports->links() }}
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
