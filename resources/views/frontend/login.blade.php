@extends('frontend.loginLayout')
@section('title','লগ ইন ')
@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href=""><b>বাজার - সদাই</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">লগ ইন করুন </p>
        @if ($message = Session::get('errorMessage'))
            <center><p style="color: red">{{$message}} </p></center>
        @endif
        {{ Form::open(array('url' => 'verifyUser',  'method' => 'post')) }}
        {{ csrf_field() }}
            <div class="form-group has-feedback">
                <input type="tel" class="form-control" name ="phone" placeholder="ফোন" pattern="\+?(88)?0?1[3456789][0-9]{8}\b" required>
                <span class="glyphicon glyphicon-phone form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control"  name="password" placeholder="পাসওয়ার্ড" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox ">
                        <label>
                            <input type="checkbox"> আপনাকে স্মরণ করিয়ে দিব
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" value="login"  name="login" class="btn btn-primary btn-block btn-flat">লগ ইন</button>
                </div>
                <!-- /.col -->
            </div>
        {{ Form::close() }}
        <a href="#">পাসওয়ার্ড ভুলে গেছি</a><br>
        <a href="{{ url('signup') }}" class="text-center">আমি নতুন মেম্বার</a>

    </div>
    <!-- /.login-box-body -->
</div>
@endsection

