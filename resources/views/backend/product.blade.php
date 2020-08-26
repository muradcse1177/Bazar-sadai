@extends('backend.layout')
@section('title','পন্য')
@section('page_header', 'পন্য  ব্যবস্থাপনা')
@section('proLiAdd','active')
@section('extracss')
    <link rel="stylesheet" href="public/asset/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
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
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title addbut"><button type="button" class="btn btn-block btn-success btn-flat"><i class="fa fa-plus-square"></i> নতুন যোগ করুন </button></h3>
                    <h3 class="box-title rembut" style="display:none;"><button type="button" class="btn btn-block btn-success btn-flat"><i class="fa fa-minus-square"></i> মুছে ফেলুন </button></h3>
                </div>
                <div class="divform" style="display:none">
                    {{ Form::open(array('url' => 'insertProducts',  'method' => 'post','enctype'=>'multipart/form-data')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label> ক্যাটেগরি নাম</label>
                            <select class="form-control select2 cat_name" name="catId" style="width: 100%;" required>
                                <option value="" selected> ক্যাটেগরি  নির্বাচন করুন</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">পন্য নাম</label>
                            <input type="text" class="form-control name" id="name"  name="name" placeholder="নাম লিখুন" required>
                        </div>
                        <div class="form-group">
                            <label for="">দাম</label>
                            <input type="number" class="form-control price" id="price"  name="price" min="1" placeholder="দাম" required>
                        </div>
                        <div class="form-group">
                            <label for="">ইউনিট</label>
                            <input type="text" class="form-control unit" id="unit"  name="unit" placeholder="ইউনিট" required>
                        </div>
                        <div class="form-group">
                            <label for="">নুন্যতম পরিমান</label>
                            <input type="number" class="form-control minqty" id="minqty"  min="1" name="minqty" placeholder="নুন্যতম পরিমান" required>
                        </div>
                        <div class="form-group">
                            <label for="">ছবি</label>
                            <input type="file" class="form-control type" accept="image/*" name="product_photo" placeholder="ছবি">
                        </div>
                        <div class="form-group">
                            <label for="">বিবরন</label>
                            <textarea class="textarea description" id="description" placeholder="বিবরন লিখুন" name="description"
                                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
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
        <div class="col-md-12">
            <div class="box">
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
                            <th> ইউনিট  </th>
                             <th>টুল</th>
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
                                <td class="td-actions text-center">
                                    <button type="button" rel="tooltip" class="btn btn-success edit" data-id="{{$product->id}}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" rel="tooltip"  class="btn btn-danger delete" data-id="{{$product->id}}">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php $i++ ?>
                        @endforeach
                    </table>
                    {{ $products->links() }}
                    <div class="modal modal-danger fade" id="modal-danger">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">মুছে ফেলতে চান</h4>
                                </div>
                                <div class="modal-body">
                                    <center><p>মুছে ফেলতে চান?</p></center>
                                </div>
                                <div class="modal-footer">
                                    {{ Form::open(array('url' => 'deleteProduct',  'method' => 'post')) }}
                                    {{ csrf_field() }}
                                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">না</button>
                                    <button type="submit" class="btn btn-outline">হ্যা</button>
                                    <input type="hidden" name="id" id="id" class="id">
                                    {{ Form::close() }}
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection
@section('js')
    <script src="public/asset/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script>

        $(document).ready(function(){
            $('.textarea').wysihtml5();
            $.ajax({
                url: 'getAllCategory',
                type: "GET",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".cat_name").append("<option value='"+id+"'>"+name+"</option>");
                    }

                },
                failure: function (msg) {
                    alert('an error occured');
                }
            });
            $(".cat_name").change(function(){
                var id =$(this).val();
                $('.subcat_name').find('option:not(:first)').remove();
                $.ajax({
                    type: 'GET',
                    url: 'getSubCategoryListAll',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        var data = response.data;
                        var len = data.length;
                        for( var i = 0; i<len; i++){
                            var id = data[i]['id'];
                            var name = data[i]['name'];
                            $(".subcat_name").append("<option value='"+id+"'>"+name+"</option>");
                        }
                    }
                });
            });
        });
        $(document).ready(function(){
            $(".addbut").click(function(){
                $(".divform").show();
                $(".rembut").show();
                $(".addbut").hide();
            });
            $(".rembut").click(function(){
                $(".divform").hide();
                $(".addbut").show();
                $(".rembut").hide();
            });

        });
        $(function(){
            $('.select2').select2()
            $(document).on('click', '.edit', function(e){
                e.preventDefault();
                $('.divform').show();
                var id = $(this).data('id');
                getRow(id);
            });
            $(document).on('click', '.delete', function(e){
                e.preventDefault();
                $('#modal-danger').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });
        });
        function getRow(id){
            $.ajax({
                type: 'POST',
                url: 'getProductList',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    console.log(data);
                    $('.name').val(data.name);
                    $('.id').val(data.id);
                    $('.price').val(data.price);
                    $('.unit').val(data.unit);
                    $('.minqty').val(data.minqty);
                    $('#description ~ iframe').contents().find('.wysihtml5-editor').html(data.description);
                    //Also works $('.wysihtml5-sandbox').contents().find('.wysihtml5-editor').html(data.description);

                }
            });
        }
    </script>
@endsection
