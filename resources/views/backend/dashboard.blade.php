@extends('backend.layout')
@section('title', 'ড্যাসবোরড')
@section('page_header', 'ড্যাসবোরড')
@section('dashLiAdd','active')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">ড্যাসবোরড</h3> <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                    </div>

                </div>
                <div class="box-body">
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>{{$users}}</h3>
                                <p>মোট সদস্য</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person"></i>
                            </div>
                            <a href="{{url('user')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>{{$cashOut}}</h3>
                                <p>ক্যাশ ইন</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-cash"></i>
                            </div>
                            <a href="{{url('accounting')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>{{$cashIn}}</h3>
                                <p>ক্যাশ আউট</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-cash"></i>
                            </div>
                            <a href="{{url('accounting')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>{{$p_order}}</h3>
                                <p>পণ্য অর্ডার</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-cart"></i>
                            </div>
                            <a href="{{url('salesReport')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>{{$a_order}}</h3>
                                <p>পশু অর্ডার</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-cart-outline"></i>
                            </div>
                            <a href="{{url('animalSalesReport')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>{{$t_order}}</h3>
                                <p>টিকেট অর্ডার</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-android-time"></i>
                            </div>
                            <a href="{{url('ticketSalesReport')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>{{$d_order}}</h3>
                                <p>ডাক্তার এপয়েনমেনট</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-medkit"></i>
                            </div>
                            <a href="{{url('doctorAppointmentReport')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>{{$th_order}}</h3>
                                <p>থেরাপি এপয়েনমেনট</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-medkit"></i>
                            </div>
                            <a href="{{url('therapyAppointmentReport')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>{{$di_order}}</h3>
                                <p>ডায়াগনস্টিক এপয়েনমেন্ট</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-medkit"></i>
                            </div>
                            <a href="{{url('diagnosticAppointmentReport')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>{{$m_order}}</h3>
                                <p>মেডিসিন অর্ডার</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-cart-outline"></i>
                            </div>
                            <a href="{{url('medicineOrderReportAdmin')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
