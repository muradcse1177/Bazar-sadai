@extends('backend.layout')
@section('title', 'এসএমএস')
@section('page_header', 'এসএমএস ব্যবস্থাপনা')
@section('sms','active')
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
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="divform">
                    {{ Form::open(array('url' => 'smsSend',  'method' => 'post')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="">ফোন নাম্বার (এভাবে লিখুন -- 01707011562,01929877307)</label>
                            <input  class="form-control phone" id="phone"  name="phone" placeholder="এভাবে লিখুন -- 01707011562,01929877307" required>
                        </div>
                        <div class="form-group">
                            <label for="">মেসেজ</label>
                            <textarea  class="form-control msg" id="msg" rows="5"  name="msg" placeholder="মেসেজ লিখুন" required></textarea>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" id="id" class="id">
                        <button type="submit" class="btn btn-primary">সেভ করুন</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')
    <script>

    </script>
@endsection
