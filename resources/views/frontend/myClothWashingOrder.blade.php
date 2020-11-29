@extends('frontend.frontLayout')
@section('title', 'প্রোফাইল')
@section('ExtCss')
    <link rel="stylesheet" href="public/asset/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
            @if ($message = Session::get('successMessage'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> ধন্যবাদ</h4>
                    {{ $message }}
                </div>
            @endif
            @if ($message = Session::get('errorMessage'))

                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-warning"></i> দুঃখিত!</h4>
                    {{ $message }}
                </div>
            @endif
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="box-header with-border">
                        <h4 class="box-title"><i class="fa fa-calendar"></i> <b>আপনার লিস্ট</b></h4>
                        <div class="box-body table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>তারিখ</th>
                                    <th>বিস্তারিত</th>
                                    <th>নাম</th>
                                    <th>ফোন</th>
                                    <th>ক্লিনার নাম</th>
                                    <th>ক্লিনার ফোন</th>
                                    <th>দাম</th>
                                </tr>
                                @foreach($washings as $washing)
                                    <tr>
                                        <td>{{$washing->date}}</td>
                                        <td class="td-actions text-left">
                                            <button type="button" rel="tooltip" class="btn btn-success details" data-id="{{$washing->c_id}}">
                                                বিস্তারিত
                                            </button>
                                        </td>
                                        <td>{{$washing->u_name}}</td>
                                        <td>{{$washing->u_phone}}</td>
                                        <td>{{$washing->name}}</td>
                                        <td>{{$washing->phone}}</td>
                                        <td>{{$washing->price.'/-'}}</td>
                                    </tr>
                                @endforeach
                            </table>
                            {{ $washings->links() }}
                        </div>
                        <div class="modal fade" id="transaction">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><b>বিস্তারিত ট্রানজেকশন</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered">
                                            <thead>
                                            <th>নাম</th>
                                            <th>পরিমান</th>
                                            </thead>
                                            <tbody id="detail">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn allButton pull-right" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                                    </div>
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
    <script>
        $(function(){
            $(document).on('click', '.details', function(e){
                e.preventDefault();
                $('#transaction').modal('show');
                var id = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: 'getClothWashingByIdUser',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id
                    },
                    dataType: 'json',
                    success:function(response){
                        $('#detail').prepend(response.data.list);
                    }
                });
            });

            $("#transaction").on("hidden.bs.modal", function () {
                $('.prepend_items').remove();
            });
        });
    </script>
@endsection
