<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
   <link rel="stylesheet" href="{{ url('/') }}/public/asset/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('/') }}/public/asset/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ url('/') }}/public/asset/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('/') }}/public/asset/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ url('/') }}/public/asset/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/public/asset/bower_components/select2/dist/css/select2.min.css">
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet"  href="{{url('public/asset/toast/jquery.toast.css')}}">
    <style type="text/css">
        /* Small devices (tablets, 768px and up) */
        @media (min-width: 768px){
            #navbar-search-input{
                width: 60px;
            }
            #navbar-search-input:focus{
                width: 100px;
            }
        }

        /* Medium devices (desktops, 992px and up) */
        @media (min-width: 992px){
            #navbar-search-input{
                width: 150px;
            }
            #navbar-search-input:focus{
                width: 250px;
            }
        }
        .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
            position: relative;
            min-height: 1px;
            padding-right: 7px;
            padding-left: 7px;
            margin-left: 0px;
            margin-right: 0px;
        }
        .word-wrap{
            overflow-wrap: break-word;
        }
        .prod-body{
            height:70px;
        }

        .box:hover {
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        }
        .register-box{
            margin-top:20px;
        }

        #trending{
            list-style: none;
            padding:10px 5px 10px 15px;
        }
        #trending li {
            padding-left: 1.3em;
        }
        #trending li:before {
            content: "\f046";
            font-family: FontAwesome;
            display: inline-block;
            margin-left: -1.3em;
            width: 1.3em;
        }

        /*Magnify*/
        .magnify > .magnify-lens {
            width: 100px;
            height: 100px;
        }
        footer {
            position: fixed;
            height: 60px;
            bottom: 0;
            width: 100%;
        }
        .cardBody{
            margin-left: 10px;
            margin-right: 10px;
            margin-bottom: 10px;
        }
        .pCard{
            margin-top: 10px;
            margin-left: 10px;
            margin-right: 10px;
            margin-bottom: 10px;
        }
        .card{
            margin-left: 10px;
            margin-right: 10px;
            margin-bottom: 10px;
        }
        .boxBody{
            background-color: darkgreen;
            color: white;
        }
        /*.modal {*/
        /*    text-align: center;*/
        /*    padding: 0!important;*/
        /*}*/
        /*.modal:before {*/
        /*    content: '';*/
        /*    display: inline-block;*/
        /*    height: 100%;*/
        /*    vertical-align: middle;*/
        /*    margin-right: -4px;*/
        /*}*/

        /*.modal-dialog {*/
        /*    display: inline-block;*/
        /*    text-align: left;*/
        /*    vertical-align: middle;*/
        /*}*/
        .allButton{
            background-color: darkgreen;
            color: white;
            margin-bottom: 5px;
        }
        .medicine_text{
            color: darkgreen;
        }
        .searchMedicine{
            margin-left: 5px;
            margin-right: 5px;
        }
        .container {
            padding-right: 5px;
            padding-left: 5px;
            margin-right: auto;
            margin-left: auto;
        }
        .skin-blue .main-header li.user-header {
            background-color: darkgreen;
        }
    </style>
    @yield('ExtCss')
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">
    <header class="main-header">

        <nav class="navbar navbar-static-top navbar-fixed-top " id="mNavbar" style="background-color: darkgreen;">
            <div class="container">

                <div class="navbar-header">
                    <a href="{{ url('homepage') }}">
                        <img src="{{url('public/bs.ico')}}" style="background-color:white; width: 42px; height: 40px; margin-top: 5px; margin-bottom: 5px; margin-left: 15px;"  class="pull-left">
                    </a>
{{--                    <a href="{{ url('homepage') }}" class="navbar-brand"><b>বাজার - সদাই</b></a>--}}
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>

                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                    <ul class="nav navbar-nav">

                        @if (Cookie::get('user') == null)
                            <li><a href="{{ url('login') }}">লগ ইন</a></li>
                            <li><a href="{{ url('signup') }}">সাইন আপ</a></li>
                        @endif
                        @if(Cookie::get('user_type') == 3)
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">আমার ট্রানজেকশন <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{url('myProductOrder')}}">পণ্য ক্রয়</a></li>
                                    <li><a href="{{url('myVariousProductOrder')}}">হরেক রকম পণ্য ক্রয়</a></li>
                                    <li><a href="{{url('myAnimalOrder')}}">পশু ক্রয়</a></li>
                                    <li><a href="{{url('myTicketOrder')}}">টিকেট ক্রয়</a></li>
                                    <li><a href="{{url('myDrAppointment')}}">ডাক্তার এপয়েনমেনট</a></li>
                                    <li><a href="{{url('myTherapyAppointment')}}">থেরাপি এপয়েনমেনট</a></li>
                                    <li><a href="{{url('myDiagnosticAppointment')}}">ডায়াগনস্টিক এপয়েনমেনট</a></li>
                                </ul>
                            </li>
                        @endif
                        @if(Cookie::get('user_type') == 5)
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">আমার ট্রানজেকশন <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{url('myProductOrder')}}">পণ্য ক্রয়</a></li>
                                    <li><a href="{{url('myAnimalOrder')}}">পশু ক্রয়</a></li>
                                    <li><a href="{{url('myTicketOrder')}}">টিকেট ক্রয়</a></li>
                                    <li><a href="{{url('myDrAppointment')}}">ডাক্তার এপয়েনমেনট</a></li>
                                    <li><a href="{{url('myTherapyAppointment')}}">থেরাপি এপয়েনমেনট</a></li>
                                    <li><a href="{{url('myDiagnosticAppointment')}}">ডায়াগনস্টিক এপয়েনমেনট</a></li>
                                </ul>
                            </li>
                        @endif
                        <li><a href="#" data-toggle="modal" data-target="#aboutus">আমাদের সম্পর্কে</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#contactus">যোগাযোগ করুন</a></li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
                <!-- Navbar Right Menu -->

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown messages-menu">
                            <!-- Menu toggle button -->
                            <a href="" class="dropdown-toggle" data-toggle="dropdown" id="backButton">
                                <i class="fa fa-backward"></i>
                            </a>
                        </li>
                        <li class="dropdown messages-menu">
                            <!-- Menu toggle button -->
                            <a href="" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-search"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">
                                    {{ Form::open(array('url' => 'searchProduct',  'method' => 'get')) }}
                                    {{ csrf_field() }}
                                          <input type="text" class="form-control" placeholder="পন্য খুজুন" name="key" required>
                                    {{ Form::close() }}
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown messages-menu">
                            <!-- Menu toggle button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="label label-success cart_count"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header"><center><p>আইটেম পরিমান = <span class="cart_count"></span></p><center></li>
                                <li>
                                    <ul class="menu" id="cart_menu">

                                    </ul>
                                </li>
                                <li style="background-color: darkgreen; text-align: center;" ><a href="{{ url('cart_view') }}">অর্ডার করুন</a></li>
                            </ul>
                        </li>

                        @php
                            $Image = url('/')."/public/asset/images/noImage.jpg";
                             if (Cookie::get('user') != null){
                                 if(!empty(Cookie::get('user_photo')))
                                   $Image = url('/')."/".Cookie::get('user_photo');
                         @endphp
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="{{$Image}}" class="user-image" alt="User Image">
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{{Cookie::get('user_name')}}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="{{$Image}}" class="img-circle" alt="User Image">

                                    <p>
                                        {{Cookie::get('user_name')}}
                                    </p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{{ url('profile') }}" class="btn btn-default btn-flat">প্রোফাইল</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{ url('logout') }}" class="btn btn-default btn-flat">লগ আউট </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        @php
                          }
                        @endphp
                    </ul>
                </div>

            </div>
            <!-- /.container-fluid -->
        </nav>
    </header>
    <!-- Full Width Column -->
    <div class="content-wrapper">
        <div class="container">
            <section class="content">
            @yield('content')
            </section>
        </div>
    </div>
    <div style = "height: 60px;" ></div>

   <footer class="main-footer" style="background-color: darkgreen; color: white;">
       <!-- Load Facebook SDK for JavaScript -->
       <div id="fb-root"></div>
       <script>
           window.fbAsyncInit = function() {
               FB.init({
                   xfbml            : true,
                   version          : 'v7.0'
               });
           };
           (function(d, s, id) {
               var js, fjs = d.getElementsByTagName(s)[0];
               if (d.getElementById(id)) return;
               js = d.createElement(s); js.id = id;
               js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
               fjs.parentNode.insertBefore(js, fjs);
           }(document, 'script', 'facebook-jssdk'));</script>

       <!-- Your Chat Plugin code -->
       <div class="fb-customerchat"
            attribution=setup_tool
            page_id="104600097984633"
            theme_color="#13cf13"
            logged_in_greeting="হ্যালো, আপনাকে কিভাবে সাহায্য করতে পারি?"
            logged_out_greeting="হ্যালো, আপনাকে কিভাবে সাহায্য করতে পারি?">
       </div>
        <center><strong >&copy; বাজার-সদাই, ২০২০ ।। সার্বিক সহযোগীতায় - <br> <a href="https://parallaxsoft.com/" style="color: white;">Parallax Soft Inc.</a></strong></center>
    </footer>
</div>
<div class="modal fade"  tabindex="-1"   id="aboutus"  role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">আমাদের সম্পর্কে</h4>
            </div>
            <div class="modal-body">
                <?php
                use Illuminate\Support\Facades\DB;
                $stmt = DB::table('about_us')
                    ->first();
                ?>
                {{$stmt->about}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="contactus">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>ধন্যবাদ আপনার মুল্যবান মতামতের জন্য।</b></h4>
            </div>
            <div class="modal-body">
                <p class="call-out"><b>আমাদের সাথে যোগাযোগ করুন</b></p>
                {{ Form::open(array('url' => 'insertContactUs',  'method' => 'post','class'=>'form-horizontal')) }}
                {{ csrf_field() }}

                    <div class="form-group">
                        <label for="firstname" class="col-sm-3 control-label">নাম</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control"  id="name" name="name" placeholder="নাম"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-sm-3 control-label">ফোন </label>

                        <div class="col-sm-9">
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="ফোন নম্বর" pattern="\+?(88)?0?1[3456789][0-9]{8}\b" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label">উদ্দেশ্য</label>

                        <div class="col-sm-9">
                            <textarea  class="form-control" id="purpose" name="purpose" placeholder="উদ্দেশ্য" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                        <button type="submit" class="btn btn-success btn-flat contact" name="save" value= "1"><i class="fa fa-check-square-o"></i> Save</button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@if (Cookie::get('user') == null)
<div class="modal fade"  tabindex="-1"   id="signupModal"  role="dialog">
    <div class="modal-dialog modal-medium">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">বাজার সম্পর্কে</h4>
            </div>
            <div class="modal-body">
            <p>এলাকা ভিত্তিক বাজার এর দাম পরিবর্তন হতে পারে। সঠিক দাম পেতে সাইন আপ অথবা লগ ইন করে বাজার শুরু করুন। ধন্যবাদ। </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif

<script src="{{ url('/') }}/public/asset/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ url('/') }}/public/asset/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="{{ url('/') }}/public/asset/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="{{ url('/') }}/public/asset/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{ url('/') }}/public/asset/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ url('/') }}/public/asset/dist/js/demo.js"></script>
<script src="{{ url('/') }}/public/asset/bower_components/select2/dist/js/select2.full.min.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{url('public/asset/toast/jquery.toast.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#backButton').on('click', function(e){
            e.preventDefault();
            window.history.back();
        });
        var $navbar = $("#mNavbar");

        AdjustHeader(); // Incase the user loads the page from halfway down (or something);
        $(window).scroll(function() {
            AdjustHeader();
        });

        function AdjustHeader(){
            if ($(window).scrollTop() > 60) {
                if (!$navbar.hasClass("navbar-fixed-top")) {
                    $navbar.addClass("navbar-fixed-top");
                }
            } else {
                $navbar.removeClass("navbar-fixed-top");
            }
        }
    });
    $(function(){
        getCart();
        $('.submit').on('click',function(){
            var id = $(this).data('id');
            $("#ch"+id).show();
            $("#bg"+id).css("display", "none");
            $('#'+id+'productForm').submit(function(e){
                e.preventDefault();
                var quantity = $("#"+id+"q").val();
                $.ajax({
                    type: 'POST',
                    url:  '{{ url('/') }}/product/cart_add',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id,
                        "quantity": quantity,
                    },
                    dataType: 'json',
                    success: function(response){
                        var msg= response.output;
                        $('#ch'+id).show();
                        if(response.error){
                            $.toast({
                                heading: 'দুঃখিত',
                                text: msg.message,
                                showHideTransition: 'slide',
                                icon: 'error',
                                position: {
                                    left: 40,
                                    top: 60
                                },
                                stack: false
                            })
                        }
                        else{
                            $.toast({
                                heading: 'ধন্যবাদ',
                                text: msg.message,
                                showHideTransition: 'slide',
                                icon: 'success',
                                position: {
                                    left: 40,
                                    top: 60
                                },
                                stack: false
                            })
                            getCart();
                        }
                    }
                });
            });
        });
    });

    function getCart(){
        $.ajax({
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
            },
            url: '{{ url('/') }}/product/cart_fetch',
            dataType: 'json',
            success: function(response){
                $('#cart_menu').html(response.output.list);
                $('.cart_count').html(response.output.count);
            }
        });
    }
</script>
@yield('js')
</body>
</html>
