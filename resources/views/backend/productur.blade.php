@extends('backend.layout')
@section('title', 'আপলোড ব্যবস্থাপনা')
@section('page_header', 'আপলোড ব্যবস্থাপনা')
@section('productUploadReport','active')
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
                        <div class="form-check deleteCheck" style="display: none;">
                            <input class="form-check-input" type="checkbox" name="deleteCheck" value="1">
                            <label class="form-check-label" for="flexCheckDefault">
                                আপনার আগের ছবিগুলা কি ডিলিট করতে চান?
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="type" >ছবি</label>
                            <input class="form-control" type="file" accept="image/*"name="photo[]" required>
                        </div>
                        <div id="newRow">

                        </div>
                        <div class="form-group">
                            <a type="submit" class="btn btn-primary" id="addMore"><i class="fa-fa ion-plus"></i>আরও যোগ করুন</a>
                        </div>
                        <div class="form-group">
                            <label for="type" >ভিডিও</label>
                            <input type="file" class="form-control video" accept="video/mp4,video/x-m4v,video/*" name="video" placeholder="ভিডিও">
                        </div>
                        <div class="form-group">
                            <label for="type" >পণ্য মালিকের ফোন</label>
                            <input type="tel" class="form-control w_phone" name="w_phone" placeholder="পণ্য মালিকের ফোন">
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
                                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>
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
                            <th>সেলার নাম</th>
                            <th>পণ্য নাম</th>
                            <th>ফোন</th>
                            <th>দাম</th>
                            <th>পরিমান</th>
                            <th>পণ্য মালিক</th>
                            <th>স্ট্যাটাস</th>
                            <th></th>
                            <th>এপ্রুভাল</th>
                            <th>টুল</th>
                        </tr>
                        @foreach($products as $product)
                            <?php
                                $photo = json_decode($product->s_photos);
                                $photos = explode(",",$photo);
                                array_pop($photos);
                                $i=0;
                            ?>
                            <tr>
                                <td> {{$product->name}} </td>
                                <td> {{$product->uname}} </td>
                                <td> {{$product->phone}} </td>
                                <td> {{$product->price}} </td>
                                <td> {{$product->amount}} </td>
                                <td> {{$product->w_phone}} </td>
                                <td> {{$product->s_status}} </td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control  situation" name="situation" style="width: 100%;" required>
                                            <option value="On Sale&{{$product->s_id}}" @if($product->situation == 'On Sale'){{'Selected'}} @endif>On Sale</option>
                                            <option value="Booked&{{$product->s_id}}" @if($product->situation == 'Booked'){{'Selected'}} @endif>Booked</option>
                                            <option value="Shipped&{{$product->s_id}}" @if($product->situation == 'Shipped'){{'Selected'}} @endif>Shipped</option>
                                            <option value="Delivered&{{$product->s_id}}" @if($product->situation == 'Delivered'){{'Selected'}} @endif>Delivered</option>
                                        </select>
                                    </div>
                                </td>
                                @if($product->approval == 1)
                                    @php
                                        $button = 'info';
                                        $approval = 'Approved';
                                    @endphp
                                @else
                                    @php
                                        $button = 'warning';
                                        $approval = 'Not Approved';
                                    @endphp
                                @endif
                                <td class="td-actions text-center">
                                    <button type="button" rel="tooltip" class="btn btn-{{$button}} approval" data-id="{{$product->s_id}}">
                                        {{$approval}}
                                    </button>
                                </td>
                                <td class="td-actions text-center">
                                    <button type="button" rel="tooltip" class="btn btn-success edit" data-id="{{$product->s_id}}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" rel="tooltip"  class="btn btn-danger delete" data-id="{{$product->s_id}}">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <button type="button" rel="tooltip" class="btn btn-success search" data-id="{{$product->s_id}}">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $products->links() }}
                    <div class="modal modal-danger fade" id="modal-approval">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">এপ্রুভাল পরিবর্তন করতে চান</h4>
                                </div>
                                <div class="modal-body">
                                    <center><p>এপ্রুভাল পরিবর্তন করতে চান?</p></center>
                                </div>
                                <div class="modal-footer">
                                    {{ Form::open(array('url' => 'approvalChange',  'method' => 'post')) }}
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
                                    {{ Form::open(array('url' => 'deleteSellerUploadProduct',  'method' => 'post')) }}
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
        $("#addMore").click(function () {
            var html = '';
            html += '<div class="form-group" id="inputFormRow">';
            html += '<div class="input-group">';
            html += '<input class="form-control" type="file" accept="image/*"name="photo[]" required>';
            html += '<span class="input-group-btn">';
            html += '<a class="btn btn-danger" id="remove">বাদ দিন</a>';
            html += '</span>';
            html += '</div>';
            html += '</div>';

            $('#newRow').append(html);
        });
        $(document).on('click', '#remove', function () {
            $(this).closest('#inputFormRow').remove();
        });
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
        $(".situation").change(function(){
            var id =$(this).val();
            $.ajax({
                type: 'GET',
                url: 'changeSellerProductSituation',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    location.reload();
                }
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
            $(document).on('click', '.approval', function(e){
                e.preventDefault();
                $('#modal-approval').modal('show');
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
                url: 'getSellerProductsByIdAdmin',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var address = data.address.split(',');
                    $('.name').val(data.name);
                    $('.status').val(data.status);
                    $('.type').val(data.type);
                    $('.price').val(data.price);
                    $('.w_phone').val(data.w_phone);
                    $('.amount').val(data.amount);
                    $('.address1').val(address[0]);
                    $('.address2').val(address[1]);
                    $('.address3').val(address[2]);
                    $('#modalRes').html(data.description);
                    $('#description ~ iframe').contents().find('.wysihtml5-editor').html(data.description);
                    $('.id').val(data.id);
                    $(".deleteCheck").show();
                    $('.select2').select2()

                }
            });
        }
    </script>
@endsection
