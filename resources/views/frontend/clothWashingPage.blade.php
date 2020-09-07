@extends('frontend.frontLayout')
@section('title', 'কাপড় পরিষ্কার')
@section('ExtCss')
    <style>
        input[type=checkbox] {
            transform: scale(1.2);
        }
        .col-md-12{
            padding-right: 0px;
            padding-left: 0px;
        }
        .col-md-4{
            padding-right: 0px;
            padding-left: 0px;
        }
    </style>
@endsection
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
    {{ Form::open(array('url' => 'clothWashingBookingFront',  'method' => 'post')) }}
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th></th>
                            <th>নাম</th>
                            <th>পরিমান</th>
                            <th>দাম</th>
                        </tr>
                        @foreach($cloths as $cloth)
                            <tr>
                                <td><input type="checkbox" class="form-check-input" name="cloth_id[]" value="{{$cloth->id}}"></td>
                                <td>{{$cloth->name}}</td>
                                <td><input type="number" class="quantity" name="quantity[]" style="width: 50px; text-align: center;" min="1" value="1"  id="{{$cloth->id}}" data-id="{{$cloth->id}}"></td>
                                <td id="td{{$cloth->id}}">{{$cloth->price}}</td>
                            </tr>
                        @endforeach
                    </table><br>
                    <div class="col-md-4">
                        @if(Cookie::get('user_id'))
                            <div class="form-group">
                                <button type="submit" class="btn allButton">অর্ডার করুন</button>
                            </div>
                        @endif
                        @if(Cookie::get('user_id') == null )
                            <div class="form-group">
                                <a href='{{url('login')}}'  class="btn allButton">লগ ইন করুন</a>
                            </div>
                        @endif
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection
@section('js')
    <script>
        $(".quantity").change(function(){
            var id = $(this).data('id');
            var value = $(this).val();
            $.ajax({
                type: 'GET',
                url: 'getClothPriceByIdFront',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    $("#td"+id).html(data.price*value);
                }
            });
        });
    </script>
@endsection
