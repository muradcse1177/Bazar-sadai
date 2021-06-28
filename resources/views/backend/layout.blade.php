<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="{{url('public/asset/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet"  href="{{url('public/asset/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet"  href="{{url('public/asset/bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- daterange picker -->
{{--    <link rel="stylesheet"  href="{{url('public/asset/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">--}}
    <!-- bootstrap datepicker -->
{{--    <link rel="stylesheet"  href="{{url('public/asset/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">--}}
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet"  href="{{url('public/asset/plugins/iCheck/all.css')}}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet"  href="{{url('public/asset/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">
    <!-- Bootstrap time Picker -->
{{--    <link rel="stylesheet"  href="{{url('public/asset/plugins/timepicker/bootstrap-timepicker.min.css')}}">--}}
    <!-- Select2 -->
    <link rel="stylesheet"  href="{{url('public/asset/bower_components/select2/dist/css/select2.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet"  href="{{url('public/asset/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet"  href="{{url('public/asset/dist/css/skins/_all-skins.min.css')}}">
    <link rel="stylesheet"  href="{{url('public/asset/toast/jquery.toast.css')}}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    @yield('extracss')
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
        .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
            position: relative;
            min-height: 1px;
            padding-right: 7px;
            padding-left: 7px;
        }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>B</b>S</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>বাজার সদাই</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">4</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 1 messages</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li><!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="{{url('public/asset/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
                                            </div>
                                            <h4>
                                                Support Team
                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <!-- end message -->
                                </ul>
                            </li>
                            <li class="footer"><a href="#">See All Messages</a></li>
                        </ul>
                    </li>
                    <!-- Notifications: style can be found in dropdown.less -->
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">10</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 10 notifications</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li>
                    <!-- Tasks: style can be found in dropdown.less -->
                    <li class="dropdown tasks-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger">9</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 9 tasks</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Design some buttons
                                                <small class="pull-right">20%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                                                     aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">View all tasks</a>
                            </li>
                        </ul>
                    </li>
                    <!-- User Account: style can be found in dropdown.less -->
                    @php
                        $Image =url("public/asset/images/noImage.jpg");
                        if(Cookie::get('user_photo'))
                            $Image = url(Cookie::get('user_photo'));
                    @endphp
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ $Image}}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{ Cookie::get('user_name') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{{$Image}}" class="img-circle" alt="User Image">

                                <p>
                                    {{ Cookie::get('user_name') }}
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">প্রোফাইল</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('logout') }}" class="btn btn-default btn-flat">লগ আউট </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{$Image}}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ Cookie::get('user_name') }}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                @if(Cookie::get('user_type') != 12)
                <li class="header">রিপোর্ট</li>
                @endif
                @if(Cookie::get('user_type') == 17||Cookie::get('user_type') == 18||Cookie::get('user_type') == 19||Cookie::get('user_type') == 20||Cookie::get('user_type') == 32)
                    <li class="@yield('riderServiceArea')">
                        <a href ="{{ url('riderServiceArea') }}" >
                            <i class="fa fa-car"></i> <span>আমার সার্ভিস এরিয়া</span>
                        </a>
                    </li>
                        <li class="@yield('myRiding')">
                        <a href ="{{ url('myRiding') }}" >
                            <i class="fa fa-car"></i> <span>আমার রাইডিং</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 13)
                    <li class="@yield('doctorServiceArea')">
                        <a href ="{{ url('doctorServiceArea') }}" >
                            <i class="fa fa-car"></i> <span>আমার সার্ভিস এরিয়া</span>
                        </a>
                    </li>
                        <li class="@yield('myPatientList')">
                        <a href ="{{ url('myPatientList') }}" >
                            <i class="fa fa-medkit"></i> <span>আমার পেশেন্ট</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 4)
                    <li class="@yield('mySaleProduct')">
                        <a href ="{{ url('mySaleProduct') }}" >
                            <i class="fa fa-shopping-cart"></i> <span>আমার বিক্রয়</span>
                        </a>
                    </li>
                        <li class="@yield('sellerForm')">
                        <a href ="{{ url('sellerForm') }}" >
                            <i class="fa fa-shopping-cart"></i> <span>আমার পণ্য</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 5)
                    <li class="@yield('deliveryProfile')">
                        <a href ="{{ url('deliveryProfile') }}" >
                            <i class="fa fa-book"></i> <span>আমার ডেলিভারি</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 7)
                    <li class="@yield('mySaleProductDealer')">
                        <a href ="{{ url('mySaleProductDealer') }}" >
                            <i class="fa fa-shopping-basket"></i> <span>আমার বিক্রয়</span>
                        </a>
                    </li>
                    <li class="@yield('dealerProfile')">
                        <a href ="{{ url('dealerProfile') }}" >
                            <i class="fa fa-shopping-basket"></i> <span>আমার পণ্য</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 16)
                    <li class="@yield('cookerProfile')">
                        <a href ="{{ url('cookerProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>আমার প্রোফাইল</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 21)
                    <li class="@yield('clothCleanerProfile')">
                        <a href ="{{ url('clothCleanerProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>আমার প্রোফাইল</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 22)
                    <li class="@yield('laundryProfile')">
                        <a href ="{{ url('laundryProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>আমার প্রোফাইল</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 23)
                    <li class="@yield('roomCleanerProfile')">
                        <a href ="{{ url('roomCleanerProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>আমার প্রোফাইল</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 24)
                    <li class="@yield('tankCleanerProfile')">
                        <a href ="{{ url('tankCleanerProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>আমার প্রোফাইল</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 25)
                    <li class="@yield('helpingHandProfile')">
                        <a href ="{{ url('helpingHandProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>আমার প্রোফাইল</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 26)
                    <li class="@yield('guardProfile')">
                        <a href ="{{ url('guardProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>আমার প্রোফাইল</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 27)
                    <li class="@yield('stoveProfile')">
                        <a href ="{{ url('stoveProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>আমার প্রোফাইল</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 28)
                    <li class="@yield('electronicsProfile')">
                        <a href ="{{ url('electronicsProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>আমার প্রোফাইল</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 29)
                    <li class="@yield('sanitaryProfile')">
                        <a href ="{{ url('sanitaryProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>আমার প্রোফাইল</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 30)
                    <li class="@yield('acProfile')">
                        <a href ="{{ url('acProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>আমার প্রোফাইল</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 31)
                    <li class="@yield('parlorProfile')">
                        <a href ="{{ url('parlorProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>আমার প্রোফাইল</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 33)
                    <li class="@yield('courierProfile')">
                        <a href ="{{ url('courierProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>আমার প্রোফাইল</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 34)
                    <li class="@yield('tntProfile')">
                        <a href ="{{ url('tntProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>আমার প্রোফাইল</span>
                        </a>
                    </li>
                    <li class ="@yield('bookingTourAll1')"><a href="{{ url('bookingTourAllAgent1') }}"><i class="fa fa-circle-o"></i>হোটেল/রুম/ট্যুর বুকিং ধাপ-১</a></li>
                    <li class ="@yield('bookingTourAll2')"><a href="{{ url('bookingTourAllAgent2') }}"><i class="fa fa-circle-o"></i>হোটেল/রুম/ট্যুর বুকিং ধাপ-২</a></li>
                @endif
                @if(Cookie::get('user_type') == 15)
                    <li class="@yield('myMedicineSelf')">
                        <a href ="{{ url('myMedicineSelf') }}" >
                            <i class="fa fa-book"></i> <span>আমার সেলফ</span>
                        </a>
                    </li>
                    <li class="@yield('myMedicineOrder')">
                        <a href ="{{ url('myMedicineOrder') }}" >
                            <i class="fa fa-book"></i> <span>আমার অর্ডার</span>
                        </a>
                    </li>
                    <li class="@yield('myMedicineSalesReport')">
                        <a href ="{{ url('myMedicineSalesReport') }}" >
                            <i class="fa fa-book"></i> <span>বিক্রয় রিপোর্ট</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 11)
                    <li class="@yield('dashLiAdd')">
                        <a href="{{ url('dashboard') }}">
                            <i class="fa fa-dashboard"></i> <span>ড্যাসবোরড</span>
                        </a>
                    </li>
                    <li class="@yield('accountingLiAdd')">
                        <a href="{{ url('accounting') }}">
                            <i class="fa fa-dashboard"></i> <span>হিসাব</span>
                        </a>
                    </li>
                    <li class="@yield('salesLiAdd')">
                        <a href="{{ url('salesReport') }}">
                            <i class="fa fa-shopping-bag"></i> <span>পণ্য বিক্রয় রিপোর্ট</span>
                        </a>
                    </li>
                    <li class="@yield('aniSalesLiAdd')">
                        <a href="{{ url('animalSalesReport') }}">
                            <i class="fa fa-shopping-bag"></i> <span>পশু বিক্রয় রিপোর্ট</span>
                        </a>
                    </li>
                    <li class="@yield('ticketSalesLiAdd')">
                        <a href="{{ url('ticketSalesReport') }}">
                            <i class="fa fa-shopping-bag"></i> <span>টিকেট বিক্রয় রিপোর্ট</span>
                        </a>
                    </li>
                    <li class="@yield('doctorAppointmentLiAdd')">
                        <a href="{{ url('doctorAppointmentReport') }}">
                            <i class="fa fa-shopping-bag"></i> <span>ডাক্তার এপয়েনমেন্ট রিপোর্ট</span>
                        </a>
                    </li>
                    <li class="@yield('therapyAppointmentLiAdd')">
                        <a href="{{ url('therapyAppointmentReport') }}">
                            <i class="fa fa-shopping-bag"></i> <span>থেরাপি এপয়েনমেন্ট রিপোর্ট</span>
                        </a>
                    </li>
                    <li class="@yield('diagnosticAppointmentLiAdd')">
                        <a href="{{ url('diagnosticAppointmentReport') }}">
                            <i class="fa fa-shopping-bag"></i> <span>ডায়াগনস্টিক  রিপোর্ট</span>
                        </a>
                    </li>
                    <li class="@yield('medicineOrderReportAdmin')">
                        <a href="{{ url('medicineOrderReportAdmin') }}">
                            <i class="fa fa-shopping-bag"></i> <span>মেডিসিন অর্ডার  রিপোর্ট</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 1 || Cookie::get('user_type') == 2 || Cookie::get('user_type') == 8)
                <li class="@yield('dashLiAdd')">
                    <a href="{{ url('dashboard') }}">
                        <i class="fa fa-dashboard"></i> <span>ড্যাসবোরড</span>
                    </a>
                </li>
                <li class="@yield('accountingLiAdd')">
                    <a href="{{ url('accounting') }}">
                        <i class="fa fa-dashboard"></i> <span>হিসাব</span>
                    </a>
                </li>
                <li class="@yield('salesLiAdd')">
                    <a href="{{ url('salesReport') }}">
                        <i class="fa fa-shopping-bag"></i> <span>পণ্য বিক্রয় রিপোর্ট</span>
                    </a>
                </li>
                <li class="@yield('aniSalesLiAdd')">
                    <a href="{{ url('animalSalesReport') }}">
                        <i class="fa fa-shopping-bag"></i> <span>পশু বিক্রয় রিপোর্ট</span>
                    </a>
                </li>
                <li class="@yield('productUploadReport')">
                    <a href="{{ url('productUploadReport') }}">
                        <i class="fa fa-upload"></i> <span>পণ্য আপলোড রিপোর্ট</span>
                    </a>
                </li>
                <li class="@yield('ticketSalesLiAdd')">
                    <a href="{{ url('ticketSalesReport') }}">
                        <i class="fa fa-shopping-bag"></i> <span>টিকেট বিক্রয় রিপোর্ট</span>
                    </a>
                </li>
                <li class="@yield('doctorAppointmentLiAdd')">
                    <a href="{{ url('doctorAppointmentReport') }}">
                        <i class="fa fa-shopping-bag"></i> <span>ডাক্তার এপয়েনমেন্ট রিপোর্ট</span>
                    </a>
                </li>
                <li class="@yield('therapyAppointmentLiAdd')">
                    <a href="{{ url('therapyAppointmentReport') }}">
                        <i class="fa fa-shopping-bag"></i> <span>থেরাপি এপয়েনমেন্ট রিপোর্ট</span>
                    </a>
                </li>
                <li class="@yield('diagnosticAppointmentLiAdd')">
                    <a href="{{ url('diagnosticAppointmentReport') }}">
                        <i class="fa fa-shopping-bag"></i> <span>ডায়াগনস্টিক  রিপোর্ট</span>
                    </a>
                </li>
                <li class="@yield('medicineOrderReportAdmin')">
                    <a href="{{ url('medicineOrderReportAdmin') }}">
                        <i class="fa fa-shopping-bag"></i> <span>মেডিসিন অর্ডার  রিপোর্ট</span>
                    </a>
                </li>
                <li class="@yield('transportReportAdmin')">
                    <a href="{{ url('transportReportAdmin') }}">
                        <i class="fa fa-car"></i> <span>পরিবহন রিপোর্ট</span>
                    </a>
                </li>
                <li class="@yield('courierReport')">
                    <a href="{{ url('courierReport') }}">
                        <i class="fa fa-car"></i> <span>কুরিয়ার রিপোর্ট</span>
                    </a>
                </li>
                <li class="@yield('cookingReport')">
                    <a href="{{ url('cookingReport') }}">
                        <i class="fa fa-dashboard"></i> <span>কুকিং রিপোর্ট</span>
                    </a>
                </li>
                <li class="@yield('clothWashingReport')">
                    <a href="{{ url('clothWashingReport') }}">
                        <i class="fa fa-dashboard"></i> <span>কাপড় পরিষ্কার রিপোর্ট</span>
                    </a>
                </li>
                <li class="@yield('laundryReport')">
                    <a href="{{ url('laundryReport') }}">
                        <i class="fa fa-dashboard"></i> <span>লন্ড্রি রিপোর্ট</span>
                    </a>
                </li>
                <li class="@yield('roomCleaningReport')">
                    <a href="{{ url('roomCleaningReport') }}">
                        <i class="fa fa-dashboard"></i> <span>রুম/ ওয়াশরুম/ ট্যাঙ্ক রিপোর্ট</span>
                    </a>
                </li>
                <li class="@yield('helpingHandReport')">
                    <a href="{{ url('helpingHandReport') }}">
                        <i class="fa fa-dashboard"></i> <span>বাচ্চা/ কাজে সহায়তা রিপোর্ট</span>
                    </a>
                </li>
                <li class="@yield('guardReport')">
                    <a href="{{ url('guardReport') }}">
                        <i class="fa fa-dashboard"></i> <span>গার্ড রিপোর্ট</span>
                    </a>
                </li>
                <li class="@yield('variousServicingReport')">
                    <a href="{{ url('variousServicingReport') }}">
                        <i class="fa fa-dashboard"></i> <span>বিভিন্ন সার্ভিসিং রিপোর্ট</span>
                    </a>
                </li>
                <li class="@yield('parlorReport')">
                    <a href="{{ url('parlorReport') }}">
                        <i class="fa fa-dashboard"></i> <span>পার্লর রিপোর্ট</span>
                    </a>
                </li>
                <li class="@yield('toursNTravelsReport')">
                    <a href="{{ url('toursNTravelsReport') }}">
                        <i class="fa fa-plane"></i> <span>ট্যুরস এন্ড ট্রাভেলস রিপোর্ট</span>
                    </a>
                </li>
                <li class="@yield('donationReportBackend')">
                    <a href="{{ url('donationReportBackend') }}">
                        <i class="fa fa-medkit"></i> <span>ডোনেশন রিপোর্ট</span>
                    </a>
                </li>
                <li class="@yield('dealerProductAdmin')">
                    <a href="{{ url('dealerProductAdmin') }}">
                        <i class="fa fa-user"></i> <span>ডিলার পণ্য রিপোর্ট</span>
                    </a>
                </li>
                @endif
                <li class="header">ব্যবস্থাপনা</li>
                @if(Cookie::get('user_type') == 15)
                    <li class="@yield('medicineSelfName')">
                        <a href ="{{ url('medicineSelfName') }}" >
                            <i class="fa fa-book"></i> <span>সেলফ নাম</span>
                        </a>
                    </li>
                    <li class="@yield('medicineSelfManagement')">
                        <a href ="{{ url('medicineSelfManagement') }}" >
                            <i class="fa fa-book"></i> <span>সেলফ এন্ট্রি</span>
                        </a>
                    </li>
                    <li class="@yield('myMedicineSale')">
                        <a href ="{{ url('myMedicineSale') }}" >
                            <i class="fa fa-book"></i> <span>আমার বিক্রয়</span>
                        </a>
                    </li>
                    <li class="@yield('medicineOrderManagement')">
                        <a href ="{{ url('medicineOrderManagement') }}" >
                            <i class="fa fa-book"></i> <span>অর্ডার করুন</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 12)
                    <li class="treeview  @yield('mainLiAdd')">
                        <a href="#">
                            <i class="fa fa-address-book"></i>
                            <span>ঠিকানা</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class ="@yield('divLiAdd')"><a href="{{ url('division') }}"><i class="fa fa-circle-o"></i> বিভাগ</a></li>
                            <li class="treeview  @yield('mainDisLiAdd')">
                                <a href="#"><i class="fa fa-circle-o"></i> জেলা ভিত্তিক
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class ="@yield('disLiAdd')"><a href="{{ url('district') }}"><i class="fa fa-circle-o"></i> জেলা</a></li>
                                    <li class ="@yield('upLiAdd')"><a href="{{ url('upazilla') }}"><i class="fa fa-circle-o"></i> উপজেলা</a></li>
                                    <li class ="@yield('uniLiAdd')"><a href="{{ url('union') }}"><i class="fa fa-circle-o"></i> ইউনিয়ন </a></li>
                                    <li class ="@yield('wardLiAdd')"><a href="{{ url('ward') }}"><i class="fa fa-circle-o"></i> ওয়ার্ড  </a></li>
                                </ul>
                            </li>
                            <li class="treeview  @yield('mainCityLiAdd')">
                                <a href="#"><i class="fa fa-circle-o"></i> শহর ভিত্তিক
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class ="@yield('cityLiAdd')" ><a href="{{ url('city') }}"><i class="fa fa-circle-o"></i> সিটি </a></li>
                                    <li class ="@yield('cityCorLiAdd')" ><a href="{{ url('city_corporation') }}"><i class="fa fa-circle-o"></i> সিটি কর্পোরেশন </a></li>
                                    <li class ="@yield('thanaLiAdd')" ><a href="{{ url('thana') }}"><i class="fa fa-circle-o"></i> থানা  </a></li>
                                    <li class ="@yield('cWardLiAdd')" ><a href="{{ url('c_ward') }}"><i class="fa fa-circle-o"></i> ওয়ার্ড  </a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview  @yield('mainUserLiAdd')">
                        <a href="#">
                            <i class="fa fa-address-book"></i>
                            <span>ইউজার</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class ="@yield('userTypeLiAdd')"><a href="{{ url('user_type') }}"><i class="fa fa-circle-o"></i> ইউজার ধরন </a></li>
                            <li class ="@yield('userLiAdd')"><a href="{{ url('user') }}"><i class="fa fa-circle-o"></i> ইউজার  </a></li>

                        </ul>
                    </li>
                    <li class="@yield('catLiAdd')">
                        <a href ="{{ url('category') }}">
                            <i class="fa fa-bandcamp"></i> <span>ক্যাটেগরি </span>
                        </a>
                    </li>
                    <li class="@yield('subCatLiAdd')">
                        <a href ="{{ url('subcategory') }}">
                            <i class="fa fa-bandcamp"></i> <span> সাব ক্যাটেগরি </span>
                        </a>
                    </li>
                    <li class="@yield('proLiAdd')">
                        <a href ="{{ url('product') }}" >
                            <i class="fa fa-shopping-cart"></i> <span>পণ্য</span>
                        </a>
                    </li>
                    <li class="@yield('allMedicineList')">
                        <a href ="{{ url('allMedicineList') }}" >
                            <i class="fa fa-medkit"></i> <span>ঔষধ</span>
                        </a>
                    </li>
                    <li class="@yield('medicineCompanyEmail')">
                        <a href ="{{ url('medicineCompanyEmail') }}" >
                            <i class="fa fa-medkit"></i> <span>ঔষধ কোম্পানি ইমেইল</span>
                        </a>
                    </li>
                    <li class="@yield('deliveryLiAdd')">
                        <a href ="{{ url('delivery_charge') }}" >
                            <i class="fa fa-delicious"></i> <span> পণ্য ডেলিভারি চার্জ</span>
                        </a>
                    </li>
                    <li class="treeview  @yield('serviceMainLi')">
                        <a href="#">
                            <i class="fa fa-address-book"></i>
                            <span>সেবাসমুহ</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="treeview  @yield('transportMainLi')">
                                <a href="#"><i class="fa fa-circle-o"></i> পরিবহন ও টিকেট
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class ="@yield('coachPage')"><a href="{{ url('coachPage') }}"><i class="fa fa-circle-o"></i> ট্রান্সপোর্ট</a></li>
                                    <li class ="@yield('ticketRoute')"><a href="{{ url('ticketRoute') }}"><i class="fa fa-circle-o"></i> টিকেট রুট</a></li>
                                </ul>
                            </li>
                            <li class="treeview  @yield('medicalMainLi')">
                                <a href="#"><i class="fa fa-circle-o"></i> মেডিকেল সার্ভিস
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class ="@yield('departmentList')"><a href="{{ url('departmentList') }}"><i class="fa fa-circle-o"></i> ডিপার্টমেন্ট </a></li>
                                    <li class ="@yield('hospitalList')"><a href="{{ url('hospitalList') }}"><i class="fa fa-circle-o"></i> হাসপাতাল </a></li>
                                    <li class ="@yield('doctorList')"><a href="{{ url('doctorList') }}"><i class="fa fa-circle-o"></i> ডাক্তার লিস্ট</a></li>
                                    <li class ="@yield('privateChamberList')"><a href="{{ url('privateChamberList') }}"><i class="fa fa-circle-o"></i> প্রাইভেট চেম্বার </a></li>
                                    <li class ="@yield('therapyServiceList')"><a href="{{ url('therapyServiceList') }}"><i class="fa fa-circle-o"></i> থেরাপি সার্ভিস </a></li>
                                    <li class ="@yield('therapyCenterList')"><a href="{{ url('therapyCenterList') }}"><i class="fa fa-circle-o"></i> থেরাপি সেন্টার </a></li>
                                    <li class ="@yield('therapyFees')"><a href="{{ url('therapyFees') }}"><i class="fa fa-circle-o"></i> থেরাপি ফিস </a></li>
                                    <li class ="@yield('diagnosticTestList')"><a href="{{ url('diagnosticTestList') }}"><i class="fa fa-circle-o"></i> ডায়াগনস্টিক টেস্ট </a></li>
                                    <li class ="@yield('diagnosticCenterList')"><a href="{{ url('diagnosticCenterList') }}"><i class="fa fa-circle-o"></i> ডায়াগনস্টিক সেন্টার </a></li>
                                    <li class ="@yield('diagnosticFees')"><a href="{{ url('diagnosticFees') }}"><i class="fa fa-circle-o"></i> ডায়াগনস্টিক ফিস </a></li>
                                </ul>
                            </li>
                            <li class="treeview  @yield('homeAssistantMainLi')">
                                <a href="#"><i class="fa fa-circle-o"></i> হোম এসিস্ট্যান্ট
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class ="@yield('cookingPage')"><a href="{{ url('cookingPage') }}"><i class="fa fa-circle-o"></i> কুকিং</a></li>
                                    <li class ="@yield('clothWashing')"><a href="{{ url('clothWashing') }}"><i class="fa fa-circle-o"></i>কাপড় পরিষ্কার</a></li>
                                    <li class ="@yield('roomCleaning')"><a href="{{ url('roomCleaning') }}"><i class="fa fa-circle-o"></i>রুম/ওয়াশরুম/ট্যাংক পরিষ্কার</a></li>
                                    <li class ="@yield('childCaring')"><a href="{{ url('childCaring') }}"><i class="fa fa-circle-o"></i>বাচ্চা দেখাশোনা ও কাজে সহায়তা</a></li>
                                    <li class ="@yield('guardSetting')"><a href="{{ url('guardSetting') }}"><i class="fa fa-circle-o"></i>গার্ড</a></li>
                                    <li class ="@yield('variousServicing')"><a href="{{ url('variousServicing') }}"><i class="fa fa-circle-o"></i> বিভিন্ন সার্ভিসিং</a></li>
                                    <li class ="@yield('parlorService')"><a href="{{ url('parlorService') }}"><i class="fa fa-circle-o"></i>পার্লার সার্ভিস</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="@yield('aboutLiAdd')">
                        <a href ="{{ url('about_us') }}" >
                            <i class="fa fa-address-book-o"></i> <span>আমাদের সম্পর্কে</span>
                        </a>
                    </li>
                    <li class="@yield('contactLiAdd')">
                        <a href ="{{ url('contact_us') }}" >
                            <i class="fa fa-address-card"></i> <span>যোগাযোগকারি</span>
                        </a>
                    </li>
                @endif
                    @if(Cookie::get('user_type') == 1 || Cookie::get('user_type') == 2 || Cookie::get('user_type') == 8)
                        <li class="treeview  @yield('mainLiAdd')">
                            <a href="#">
                                <i class="fa fa-address-book"></i>
                                <span>ঠিকানা</span>
                                <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class ="@yield('divLiAdd')"><a href="{{ url('division') }}"><i class="fa fa-circle-o"></i> বিভাগ</a></li>
                                <li class="treeview  @yield('mainDisLiAdd')">
                                    <a href="#"><i class="fa fa-circle-o"></i> জেলা ভিত্তিক
                                        <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li class ="@yield('disLiAdd')"><a href="{{ url('district') }}"><i class="fa fa-circle-o"></i> জেলা</a></li>
                                        <li class ="@yield('upLiAdd')"><a href="{{ url('upazilla') }}"><i class="fa fa-circle-o"></i> উপজেলা</a></li>
                                        <li class ="@yield('uniLiAdd')"><a href="{{ url('union') }}"><i class="fa fa-circle-o"></i> ইউনিয়ন </a></li>
                                        <li class ="@yield('wardLiAdd')"><a href="{{ url('ward') }}"><i class="fa fa-circle-o"></i> ওয়ার্ড  </a></li>
                                    </ul>
                                </li>
                                <li class="treeview  @yield('mainCityLiAdd')">
                                    <a href="#"><i class="fa fa-circle-o"></i> শহর ভিত্তিক
                                        <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li class ="@yield('cityLiAdd')" ><a href="{{ url('city') }}"><i class="fa fa-circle-o"></i> সিটি </a></li>
                                        <li class ="@yield('cityCorLiAdd')" ><a href="{{ url('city_corporation') }}"><i class="fa fa-circle-o"></i> সিটি কর্পোরেশন </a></li>
                                        <li class ="@yield('thanaLiAdd')" ><a href="{{ url('thana') }}"><i class="fa fa-circle-o"></i> থানা  </a></li>
                                        <li class ="@yield('cWardLiAdd')" ><a href="{{ url('c_ward') }}"><i class="fa fa-circle-o"></i> ওয়ার্ড  </a></li>
                                    </ul>
                                </li>
                                <li class="treeview  @yield('mainForeignLiAdd')">
                                    <a href="#"><i class="fa fa-circle-o"></i> বিদেশ ভিত্তিক
                                        <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li class ="@yield('naming1')" ><a href="{{ url('naming1') }}"><i class="fa fa-circle-o"></i> দেশ (নেমিং ১)  </a></li>
                                        <li class ="@yield('naming2')" ><a href="{{ url('naming2') }}"><i class="fa fa-circle-o"></i> নেমিং ২ </a></li>
                                        <li class ="@yield('naming3')" ><a href="{{ url('naming3') }}"><i class="fa fa-circle-o"></i> নেমিং ৩ </a></li>
                                        <li class ="@yield('naming4')" ><a href="{{ url('naming4') }}"><i class="fa fa-circle-o"></i> নেমিং ৪  </a></li>
                                        <li class ="@yield('naming5')" ><a href="{{ url('naming5') }}"><i class="fa fa-circle-o"></i> নেমিং ৫  </a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview  @yield('mainUserLiAdd')">
                            <a href="#">
                                <i class="fa fa-address-book"></i>
                                <span>ইউজার</span>
                                <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class ="@yield('userTypeLiAdd')"><a href="{{ url('user_type') }}"><i class="fa fa-circle-o"></i> ইউজার ধরন </a></li>
                                <li class ="@yield('userLiAdd')"><a href="{{ url('user') }}"><i class="fa fa-circle-o"></i> ইউজার  </a></li>

                            </ul>
                        </li>
                        <li class="@yield('catLiAdd')">
                            <a href ="{{ url('category') }}">
                                <i class="fa fa-bandcamp"></i> <span>ক্যাটেগরি </span>
                            </a>
                        </li>
                        <li class="@yield('subCatLiAdd')">
                            <a href ="{{ url('subcategory') }}">
                                <i class="fa fa-bandcamp"></i> <span> সাব ক্যাটেগরি </span>
                            </a>
                        </li>
                        <li class="@yield('proLiAdd')">
                            <a href ="{{ url('product') }}" >
                                <i class="fa fa-shopping-cart"></i> <span>পণ্য</span>
                            </a>
                        </li>
                        <li class="@yield('allMedicineList')">
                            <a href ="{{ url('allMedicineList') }}" >
                                <i class="fa fa-medkit"></i> <span>ঔষধ</span>
                            </a>
                        </li>
                        <li class="@yield('medicineCompanyEmail')">
                            <a href ="{{ url('medicineCompanyEmail') }}" >
                                <i class="fa fa-medkit"></i> <span>ঔষধ কোম্পানি ইমেইল</span>
                            </a>
                        </li>
                        <li class="@yield('deliveryLiAdd')">
                            <a href ="{{ url('delivery_charge') }}" >
                                <i class="fa fa-delicious"></i> <span> পণ্য ডেলিভারি চার্জ</span>
                            </a>
                        </li>
                        <li class="@yield('transportCost')">
                            <a href ="{{ url('transportCost') }}" >
                                <i class="fa fa-delicious"></i> <span>পরিবহন খরচ নির্ধারণ</span>
                            </a>
                        </li>
                        <li class="treeview  @yield('serviceMainLi')">
                            <a href="#">
                                <i class="fa fa-address-book"></i>
                                <span>সেবাসমুহ</span>
                                <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="treeview  @yield('transportMainLi')">
                                    <a href="#"><i class="fa fa-circle-o"></i> পরিবহন ও টিকেট
                                        <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li class ="@yield('coachPage')"><a href="{{ url('coachPage') }}"><i class="fa fa-circle-o"></i> ট্রান্সপোর্ট</a></li>
                                        <li class ="@yield('ticketRoute')"><a href="{{ url('ticketRoute') }}"><i class="fa fa-circle-o"></i> টিকেট রুট</a></li>
                                        <li class ="@yield('courierType')"><a href="{{ url('courierType') }}"><i class="fa fa-circle-o"></i>কুরিয়ার ধরণ</a></li>
                                        <li class ="@yield('courierSettings')"><a href="{{ url('courierSettings') }}"><i class="fa fa-circle-o"></i>কুরিয়ার সেটিংস</a></li>
                                    </ul>
                                </li>
                                <li class="treeview  @yield('tntMainLi')">
                                    <a href="#"><i class="fa fa-circle-o"></i> ট্যুরস এন্ড ট্রাভেলস
                                        <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li class ="@yield('bookingMainAddress')"><a href="{{ url('bookingMainAddress') }}"><i class="fa fa-circle-o"></i>বুকিং প্রধান ঠিকানা</a></li>
                                        <li class ="@yield('bookingTourAll1')"><a href="{{ url('bookingTourAll1') }}"><i class="fa fa-circle-o"></i>হোটেল/রুম/ট্যুর বুকিং ধাপ-১</a></li>
                                        <li class ="@yield('bookingTourAll2')"><a href="{{ url('bookingTourAll2') }}"><i class="fa fa-circle-o"></i>হোটেল/রুম/ট্যুর বুকিং ধাপ-২</a></li>
                                    </ul>
                                </li>
                                <li class="treeview  @yield('medicalMainLi')">
                                    <a href="#"><i class="fa fa-circle-o"></i> মেডিকেল সার্ভিস
                                        <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li class ="@yield('departmentList')"><a href="{{ url('departmentList') }}"><i class="fa fa-circle-o"></i> ডিপার্টমেন্ট </a></li>
                                        <li class ="@yield('hospitalList')"><a href="{{ url('hospitalList') }}"><i class="fa fa-circle-o"></i> হাসপাতাল </a></li>
                                        <li class ="@yield('doctorList')"><a href="{{ url('doctorList') }}"><i class="fa fa-circle-o"></i> ডাক্তার লিস্ট</a></li>
                                        <li class ="@yield('privateChamberList')"><a href="{{ url('privateChamberList') }}"><i class="fa fa-circle-o"></i> প্রাইভেট চেম্বার </a></li>
                                        <li class ="@yield('therapyServiceList')"><a href="{{ url('therapyServiceList') }}"><i class="fa fa-circle-o"></i> থেরাপি সার্ভিস </a></li>
                                        <li class ="@yield('therapyCenterList')"><a href="{{ url('therapyCenterList') }}"><i class="fa fa-circle-o"></i> থেরাপি সেন্টার </a></li>
                                        <li class ="@yield('therapyFees')"><a href="{{ url('therapyFees') }}"><i class="fa fa-circle-o"></i> থেরাপি ফিস </a></li>
                                        <li class ="@yield('diagnosticTestList')"><a href="{{ url('diagnosticTestList') }}"><i class="fa fa-circle-o"></i> ডায়াগনস্টিক টেস্ট </a></li>
                                        <li class ="@yield('diagnosticCenterList')"><a href="{{ url('diagnosticCenterList') }}"><i class="fa fa-circle-o"></i> ডায়াগনস্টিক সেন্টার </a></li>
                                        <li class ="@yield('diagnosticFees')"><a href="{{ url('diagnosticFees') }}"><i class="fa fa-circle-o"></i> ডায়াগনস্টিক ফিস </a></li>
                                        <li class ="@yield('medicalCamp')"><a href="{{ url('medicalCampBack') }}"><i class="fa fa-circle-o"></i>মেডিকেল ক্যাম্প</a></li>
                                    </ul>
                                </li>
                                <li class="treeview  @yield('homeAssistantMainLi')">
                                    <a href="#"><i class="fa fa-circle-o"></i> হোম এসিস্ট্যান্ট
                                        <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li class ="@yield('cookingPage')"><a href="{{ url('cookingPage') }}"><i class="fa fa-circle-o"></i> কুকিং</a></li>
                                        <li class ="@yield('clothWashing')"><a href="{{ url('clothWashing') }}"><i class="fa fa-circle-o"></i>কাপড় পরিষ্কার</a></li>
                                        <li class ="@yield('roomCleaning')"><a href="{{ url('roomCleaning') }}"><i class="fa fa-circle-o"></i>রুম/ওয়াশরুম/ট্যাংক পরিষ্কার</a></li>
                                        <li class ="@yield('childCaring')"><a href="{{ url('childCaring') }}"><i class="fa fa-circle-o"></i>বাচ্চা দেখাশোনা ও কাজে সহায়তা</a></li>
                                        <li class ="@yield('guardSetting')"><a href="{{ url('guardSetting') }}"><i class="fa fa-circle-o"></i>গার্ড</a></li>
                                        <li class ="@yield('variousServicing')"><a href="{{ url('variousServicing') }}"><i class="fa fa-circle-o"></i> বিভিন্ন সার্ভিসিং</a></li>
                                        <li class ="@yield('parlorService')"><a href="{{ url('parlorService') }}"><i class="fa fa-circle-o"></i>পার্লার সার্ভিস</a></li>
                                        <li class ="@yield('laundryService')"><a href="{{ url('laundryService') }}"><i class="fa fa-circle-o"></i>লন্ড্রি সার্ভিস</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="@yield('aboutLiAdd')">
                            <a href ="{{ url('about_us') }}" >
                                <i class="fa fa-address-book-o"></i> <span>আমাদের সম্পর্কে</span>
                            </a>
                        </li>
                        <li class="@yield('contactLiAdd')">
                            <a href ="{{ url('contact_us') }}" >
                                <i class="fa fa-address-card"></i> <span>যোগাযোগকারি</span>
                            </a>
                        </li>
                    @endif

            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('page_header')
            </h1>
        </section>
        <section class="content">
            @yield('content')
        </section>
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <center><strong>&copy; বাজার-সদাই, ২০২০। সার্বিক সহযোগীতায়-  <a href="https://parallaxsoft.com/">Parallax Soft Inc.</a></strong></center>
    </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{url('public/asset/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{url('public/asset/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Select2 -->
<script src="{{url('public/asset/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<!-- InputMask -->
<script src="{{url('public/asset/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{url('public/asset/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{url('public/asset/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<!-- date-range-picker -->
<script src="{{url('public/asset/bower_components/moment/min/moment.min.js')}}"></script>
{{--<script src="{{url('public/asset/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>--}}
<!-- bootstrap datepicker -->
{{--<script src="{{url('public/asset/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>--}}
<!-- bootstrap color picker -->
<script src="{{url('public/asset/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
<!-- bootstrap time picker -->
{{--<script src="{{url('public/asset/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>--}}
<!-- SlimScroll -->
<script src="{{url('public/asset/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{url('public/asset/plugins/iCheck/icheck.min.js')}}"></script>
<!-- FastClick -->
<script src="{{url('public/asset/bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('public/asset/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('public/asset/dist/js/demo.js')}}"></script>
<script src="{{url('public/asset/toast/jquery.toast.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- Page script -->
@yield('js')
</body>
</html>
