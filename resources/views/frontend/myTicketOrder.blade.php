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
                        <h4 class="box-title"><i class="fa fa-calendar"></i> <b>আপনার টিকেট ক্রয় লিস্ট</b></h4>
                        <div class="box-body table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>ফ্রম</th>
                                    <th>টু</th>
                                    <th>পরিবহন নাম</th>
                                    <th>ধরণ</th>
                                    <th>তারিখ</th>
                                    <th>সময়</th>
                                    <th>লোকসংখ্যা</th>
                                    <th>দাম</th>
                                </tr>
                                <?php
                                $sum =0;
                                ?>
                                @foreach($ticket_Sales as $ticket_Sale)
                                    @php
                                        $sum= $sum +$ticket_Sale->price;
                                    @endphp
                                    <tr>
                                        <td> {{$ticket_Sale->from_address}} </td>
                                        <td> {{$ticket_Sale->to_address}} </td>
                                        <td> {{$ticket_Sale->transport_name}} </td>
                                        <td> {{$ticket_Sale->transport_type}} </td>
                                        <td> {{$ticket_Sale->date}} </td>
                                        <td> {{$ticket_Sale->transport_time}} </td>
                                        <td> {{$ticket_Sale->adult}} </td>
                                        <td> {{$ticket_Sale->price.'/-'}} </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="7" style="text-align: right"><b>মোটঃ</b></td>
                                    <td><b>{{$sum.'/-'}}</b></td>
                                </tr>
                            </table>
                            {{ $ticket_Sales->links() }}
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
