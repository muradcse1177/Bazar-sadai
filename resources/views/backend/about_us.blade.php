@extends('backend.layout')
@section('title', 'আমাদের সম্পর্কে')
@section('page_header', 'আমাদের সম্পর্কে  ব্যবস্থাপনা')
@section('aboutLiAdd','active')
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
                <div class="divform" style="display:none">
                    {{ Form::open(array('url' => 'insertAboutUs',  'method' => 'post')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="">আমাদের সম্পর্কে</label>
                            <textarea  class="form-control name textarea" id="name" rows="9"  name="name" placeholder="আমাদের সম্পর্কে লিখুন" required></textarea>
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
                    <h3 class="box-title">আমাদের সম্পর্কে</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>আমাদের সম্পর্কে </th>
                            <th>টুল</th>
                        </tr>
                        @foreach($abouts as $about)
                            <tr>
                                <td> {!! $about->about !!} </td>
                                <td class="td-actions text-center">
                                    <button type="button" rel="tooltip" class="btn btn-success edit" data-id="{{$about->id}}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
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
                url: 'getAboutUS',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    $('#name ~ iframe').contents().find('.wysihtml5-editor').html(data.about);
                    $('.id').val(data.id);
                }
            });
        }
    </script>
@endsection
