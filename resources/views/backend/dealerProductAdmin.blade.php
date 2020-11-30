@extends('backend.layout')
@section('title','পন্য')
@section('page_header', 'পন্য  ব্যবস্থাপনা')
@section('proLiAdd','active')

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
                <div class="divform" >
                    {{ Form::open(array('url' => 'searchDealerProductsAdmin',  'method' => 'post',)) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label> ডিলার নাম</label>
                            <select class="form-control select2 dealer" name="dealer" style="width: 100%;" required>
                                <option value="" selected> ডিলার নাম  নির্বাচন করুন</option>
                            </select>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" id="id" class="id">
                        <button type="submit" class="btn btn-primary">সার্চ করুন</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">পন্য  লিস্ট </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th> #  </th>
                            <th> ছবি  </th>
                            <th> নাম  </th>
                            <th> দাম  </th>
                            <th> ইউনিট </th>
                            <th> কোম্পানি </th>
                            <th> ধরণ </th>
                        </tr>
                        <?php $i=1?>
                        @foreach($products as $product)
                            <?php $noImage ="public/asset/images/noImage.jpg"; ?>
                            <tr>
                                <td> {{$i}} </td>
                                <td>
                                    @if($product->photo)
                                        <div class="text-left">
                                            <img src="{{ $product->photo }}" class="rounded" height="35px" width="35px">
                                        </div>
                                    @else
                                        <div class="text-left">
                                            <img src="{{$noImage}}" class="rounded" height="35px" width="35px">
                                        </div>
                                    @endif
                                </td>
                                <td> {{$product->name}} </td>
                                <td> {{$product->price}} </td>
                                <td> {{$product->unit}} </td>
                                <td> {{$product->company}} </td>
                                <td> {{$product->type}} </td>
                            </tr>
                            <?php $i++ ?>
                        @endforeach
                    </table>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>


@endsection
@section('js')
<script>
    $(function(){
        $('.select2').select2()
        $(document).ready(function(){
            $.ajax({
                url: 'getAllDealerAdmin',
                type: "GET",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".dealer").append("<option value='"+id+"'>"+name+"</option>");
                    }

                },
                failure: function (msg) {
                    alert('an error occured');
                }
            });
        });
    });
</script>
@endsection
