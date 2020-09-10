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
                        <h4 class="box-title"><i class="fa fa-calendar"></i> <b>আপনার পশু ক্রয় লিস্ট</b></h4>
                        <div class="box-body table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>ছবি</th>
                                    <th>তারিখ</th>
                                    <th>পশুর নাম</th>
                                    <th>অর্ডার নং</th>
                                    <th>বিক্রেতার নাম</th>
                                    <th>বিক্রেতার ফোন</th>
                                    <th>ডেলিভারি ঠিকানা </th>
                                    <th>দাম</th>
                                </tr>
                                <?php
                                $sum =0;
                                ?>
                                @foreach($aminal_Sales as $aminal_Sale)
                                    @php
                                        $Image =url('/')."/public/asset/images/noImage.jpg";
                                           if(!empty($aminal_Sale->salPPhoto))
                                               $Image =url('/').'/'.$aminal_Sale->salPPhoto;
                                           $sum= $sum +$aminal_Sale->price;
                                    @endphp
                                    <tr>
                                        <td> <img src="{{$Image}}" width ="45" height="45" ></td>
                                        <td> {{$aminal_Sale-> date}} </td>
                                        <td> {{$aminal_Sale->salName}} </td>
                                        <td> {{$aminal_Sale->pay_id}} </td>
                                        <td> {{$aminal_Sale->name}} </td>
                                        <td> {{$aminal_Sale->sellerPhone}} </td>
                                        <td> {{$aminal_Sale->delivery_address}} </td>
                                        <td> {{$aminal_Sale->price.'/-'}} </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="7" style="text-align: right"><b>মোটঃ</b></td>
                                    <td><b>{{$sum.'/-'}}</b></td>
                                </tr>
                            </table>
                            {{ $aminal_Sales->links() }}
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
