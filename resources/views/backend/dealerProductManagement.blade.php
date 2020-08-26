@extends('backend.layout')
@section('title','পন্য')
@section('page_header', ' ডিলার পন্য  ব্যবস্থাপনা')
@section('dpmtLiAdd','active')
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
                            <th> কোম্পানি </th>
                            <th>দাম পরিবর্তন </th>
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
                                <?php
                                if (strpos($product->price, '৳') !== false) {
                                    $priceArr = explode("৳",$product->price);
                                    $price = (int)$priceArr[1];
                                }
                                else{
                                    $price=$product->price;
                                }
                                ?>
                                <td> {{$price}} </td>
                                <td> {{$product->unit}} </td>
                                <td> {{$product->company}} </td>
                                <td class="td-actions text-center">
                                    <button type="button" rel="tooltip" class="btn btn-success edit" data-id="{{$product->id}}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                                <?php $i++ ?>
                        @endforeach
                    </table>
                    {{ $products->links() }}

                </div>
            </div>

        </div>
    </div>

    <div class="modal fade"  tabindex="-1"   id="priceChange"  role="dialog">
        <div class="modal-dialog modal-medium">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">দাম পরিবর্তন</h4>
                </div>
                <div class="modal-body">
                    <div id="modalRes">
                        {{ Form::open(array('url' => 'changeProductPrice',  'method' => 'post')) }}
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="">দাম</label>
                            <input type="number" class="form-control price" id="price"  name="price" min="1" placeholder="দাম" required>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">না</button>
                        <button type="submit" class="btn btn-success" >সেভ করুন</button>
                        <input type="hidden" name="id" id="id" class="id">
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>


        $(function(){
            $(document).on('click', '.edit', function(e){
                e.preventDefault();
                $('#priceChange').modal('show');
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
                    $('.id').val(data.id);
                    $('.price').val(data.price);

                }
            });
        }
    </script>
@endsection
