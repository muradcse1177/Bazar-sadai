@extends('backend.layout')
@section('title', 'সেলার')
@section('page_header', 'সেলার ব্যবস্থাপনা')
@section('sellerForm','active')
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
                    {{ Form::open(array('url' => 'insertSellerProduct',  'method' => 'post' ,'enctype'=>'multipart/form-data')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label>ধরন</label>
                            <select class="form-control  type" name="type" style="width: 100%;" required>
                                <option value="" selected>ধরন  নির্বাচন করুন</option>
                                <option value="Animal">পশু</option>
                                <option value="Others">অন্যান্য</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name" >নাম</label>
                            <input type="text" class="form-control name" name="name" placeholder="নাম"  required>
                        </div>
                        <div class="form-group">
                            <label for="name" >দাম</label>
                            <input type="number" class="form-control price" name="price" placeholder="দাম"  required>
                        </div>
                        <div class="form-group">
                            <label for="name" >পরিমান</label>
                            <input type="number" class="form-control amount" name="amount" placeholder="পরিমান"  required>
                        </div>
                        <div class="form-group">
                            <label for="name" >জেলা / সিটি-করপোরেশন</label>
                            <input type="text" class="form-control address1" name="address1" placeholder="জেলা/সিটি-করপোরেশন"  required>
                        </div>
                        <div class="form-group">
                            <label for="name" >উপজেলা / থানা</label>
                            <input type="text" class="form-control address2" name="address2" placeholder="উপজেলা/থানা"  required>
                        </div>
                        <div class="form-group">
                            <label for="name" >ইউনিয়ন /ওয়ার্ড </label>
                            <input type="text" class="form-control address3" name="address3" placeholder="ইউনিয়ন /ওয়ার্ড"  required>
                        </div>
                        <div class="form-group">
                            <label for="type" >ছবি</label>
                            <input type="file" class="form-control" accept="image/*" name="photo" placeholder="ছবি" required>
                        </div>
                        <div class="form-group">
                            <label>স্ট্যাটাস</label>
                            <select class="form-control select2 status" name="status" style="width: 100%;" required>
                                <option value="" selected>স্ট্যাটাস  নির্বাচন করুন</option>
                                <option value="Active">একটিভ</option>
                                <option value="Inactive">ইন একটিভ</option>
                            </select>
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
                    <h3 class="box-title">লিস্ট </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>ছবি</th>
                            <th>নাম</th>
                            <th>দাম</th>
                            <th>পরিমান</th>
                            <th>স্ট্যাটাস</th>
                            <th>টুল</th>
                        </tr>
                        @foreach($products as $product)
                            <?php
                                $Image =url('/')."/public/asset/images/noImage.jpg";
                                if(!empty($product->photo)){
                                    $Image =url('/').'/'.$product->photo;
                                }
                            ?>
                            <tr>
                                <td><img src="{{$Image}}" height="42" width="42">  </td>
                                <td> {{$product->name}} </td>
                                <td> {{$product->price}} </td>
                                <td> {{$product->amount}} </td>
                                <td> {{$product->status}} </td>
                                <td class="td-actions text-center">
                                    <button type="button" rel="tooltip" class="btn btn-success edit" data-id="{{$product->id}}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" rel="tooltip"  class="btn btn-danger delete" data-id="{{$product->id}}">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <button type="button" rel="tooltip" class="btn btn-success search" data-id="{{$product->id}}">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </td>
                            </tr>
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
                                    {{ Form::open(array('url' => 'deleteSellerProduct',  'method' => 'post')) }}
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
                    <div class="modal fade"  tabindex="-1"   id="contactModal"  role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">বিস্তারিত</h4>
                                </div>
                                <div class="modal-body">
                                    <div id="modalRes">

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('js')
    <script src="public/asset/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script>
        $('.textarea').wysihtml5();
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
            $(document).on('click', '.search', function(e){
                e.preventDefault();
                $('#contactModal').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });
        });
        function getRow(id){
            $.ajax({
                type: 'POST',
                url: 'getSellerProductsById',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var address = data.address.split(',');
                    $('.name').val(data.name);
                    $('.price').val(data.price);
                    $('.amount').val(data.amount);
                    $('.status').val(data.status);
                    $('.address1').val(address[0]);
                    $('.address2').val(address[1]);
                    $('.address3').val(address[2]);
                    $('#modalRes').html(data.description);
                    $('#description ~ iframe').contents().find('.wysihtml5-editor').html(data.description);
                    $('.id').val(data.id);
                }
            });
        }
    </script>
@endsection
