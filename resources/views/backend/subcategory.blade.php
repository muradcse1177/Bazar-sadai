@extends('backend.layout')
@section('title','সাব ক্যাটেগরি')
@section('page_header', 'সাব  ক্যাটেগরি ব্যবস্থাপনা')
@section('subCatLiAdd','active')
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
                    {{ Form::open(array('url' => 'insertSubcategory',  'method' => 'post')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label> ধরন</label>
                            <select class="form-control select2 cat_type" name="cat_type" style="width: 100%;" required="requred">
                                <option value="" selected> ধরন  নির্বাচন করুন</option>
                                <option value="1">পন্য</option>
                                <option value="2">সার্ভিস</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label> ক্যাটেগরি নাম</label>
                            <select class="form-control select2 cat_name" name="catId" style="width: 100%;" required>
                                <option value="" selected> ক্যাটেগরি  নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">সাব ক্যাটেগরি নাম</label>
                            <input type="text" class="form-control name" id="name"  name="name" placeholder="নাম লিখুন" required>
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
                    <h3 class="box-title">সাব ক্যাটেগরি  লিস্ট </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>সাব ক্যাটেগরি  </th>
                            <th>ক্যাটেগরি  </th>
                            <th>ধরন  </th>
                            <th>টুল</th>
                        </tr>
                        @foreach($subcategories as $subcategory)
                            <tr>
                                <td> {{$subcategory-> name}} </td>
                                <td> {{$subcategory->catName}} </td>
                                <td>  @if ($subcategory->type ==1){{'পন্য' }}  @else{{'সার্ভিস'}} @endif </td>
                                <td class="td-actions text-center">
                                    <button type="button" rel="tooltip" class="btn btn-success edit" data-id="{{$subcategory->id}}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" rel="tooltip"  class="btn btn-danger delete" data-id="{{$subcategory->id}}">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $subcategories->links() }}
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
                                    {{ Form::open(array('url' => 'deleteSubCategory',  'method' => 'post')) }}
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
    <script>

        $(document).ready(function(){
            $(".cat_type").change(function(){
                var id =$(this).val();
                $('.cat_name').find('option:not(:first)').remove();
                $.ajax({
                    type: 'GET',
                    url: 'getCategoryListAll',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        var data = response.data;
                        var len = data.length;
                        for( var i = 0; i<len; i++){
                            var id = data[i]['id'];
                            var name = data[i]['name'];
                            $(".cat_name").append("<option value='"+id+"'>"+name+"</option>");
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
                url: 'getSubCategoryList',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    $('.name').val(data.name);
                    $('.id').val(data.id);
                }
            });
        }
    </script>
@endsection
