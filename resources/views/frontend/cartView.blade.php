@extends('frontend.frontLayout')
@section('title', 'বাজার লিস্ট')
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
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">আপনার বাজার লিস্ট </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th></th>
                            <th>ছবি</th>
                            <th>নাম</th>
                            <th>দাম </th>
                            <th>পরিমান</th>
                            <th>ইউনিট</th>
                            <th>মোট</th>
                        </thead>
                        <tbody id="tbody">
                        </tbody>
                    </table>
                <?php
                $set='123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $code=substr(str_shuffle($set), 0, 12);
                ?>
                    @if(Cookie::get('user_id') != null && $count >0)
                         <h4>
                             <a href='{{url('sales/'.$code)}}'>
                                <button type='button' class='btn allButton active'>অর্ডার প্লেস করুন</button>
                             </a>
                         </h4>
                    @endif
                    @if(Cookie::get('user_id') == null )
                         <h4> আপনার অর্ডার সম্পন্ন্য করতে   <a href='{{url('login')}}'>
                                <button type='button' class='btn allButton active'>লগ ইন</button></a> করুন</h4>
                        @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        getDetails();
        $(document).on('click', '.cart_delete', function(e){
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id':id,
                },
                url: '{{ url('/') }}/product/cart_delete',
                dataType: 'json',
                success: function(response){
                    console.log(response);
                    if(!response.error){
                        getDetails();
                        getCart();
                        window.location.reload();
                    }
                }
            });
        });
        function getDetails(){
            $.ajax({
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                url: '{{ url('/') }}/product/cart_details',
                dataType: 'json',
                success: function(response){
                    console.log(response.output);
                    $('#tbody').html(response.output);
                    getCart();
                }
            });
        }

    </script>
@endsection
