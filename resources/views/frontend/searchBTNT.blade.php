@extends('frontend.frontLayout')
@section('title', 'বুকিং')
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
    {{ Form::open(array('url' => 'searchTourNTravels',  'method' => 'post')) }}
    {{ csrf_field() }}
    <div class="row">
        <div class="card">
            <div class="card-body cardBody">
                <h5 style="text-align: center;"><b>আপনার বুকিং খুজে নিন।</b></h5>
                <div class="col-sm-12">
                    <div class="form-group">
                        <select class="form-control select2 country" name="country" style="width: 100%;" required>
                            <option value="" selected>দেশ নির্বাচন করুন</option>
                            <option value="বাংলাদেশ">বাংলাদেশ</option>
                            <option value="বিদেশ">বিদেশ</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <select class="form-control select2 place" id="place" name="place" style="width: 100%;" required>
                            <option value="" selected> স্থান নির্বাচন করুন</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <input type="hidden" name="bookingName" value="{{$_GET['scat_id']}}">
                        <button type="submit" class="btn allButton">সার্চ করুন</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection
@section('js')
    <script>
        $('.select2').select2();
        $(".country").change(function(){
            var id =$(this).val();
            $('.place').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: '{{ url('/') }}/getMainPlaceListAllFront',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['name'];
                        var name = data[i]['name'];
                        $(".place").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
    </script>
@endsection
