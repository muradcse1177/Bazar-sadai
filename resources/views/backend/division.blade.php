@extends('backend.layout')
@section('title', 'বিভাগ')
@section('page_header', 'বিভাগ ব্যবস্থাপনা')
@section('mainLiAdd','active menu-open')
@section('divLiAdd','active')
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
                    {{ Form::open(array('url' => 'insertDivision',  'method' => 'post')) }}
                    {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="">বিভাগের নাম</label>
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
                    <h3 class="box-title">বিভাগ লিস্ট </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>নাম </th>
                            <th>টুল</th>
                        </tr>
                        @foreach($divisions as $division)
                            <tr>
                                <td> {{$division->name}} </td>
                                <td class="td-actions text-center">
                                    <button type="button" rel="tooltip" class="btn btn-success edit" data-id="{{$division->id}}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" rel="tooltip"  class="btn btn-danger delete" data-id="{{$division->id}}">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $divisions->links() }}
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
                                    {{ Form::open(array('url' => 'deleteDivision',  'method' => 'post')) }}
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
   });
   function getRow(id){
       $.ajax({
           type: 'POST',
           url: 'getDivisionList',
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
