@extends('frontend.frontLayout')
@section('title', 'পণ্য লিস্ট')
@section('ExtCss')
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
            <?php
                function en2bn($number) {
                    $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
                    $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
                    $bn_number = str_replace($search_array, $replace_array, $number);
                    return $bn_number;
                }
                ?>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="box-header with-border">
                        <h4 class="box-title"><i class="fa fa-calendar"></i> <b>এপর্যন্ত প্রাপ্ত দান হতে মানুষের জন্য পাওয়া গিয়েছে।</b></h4>
                        <div class="box-body table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>পণ্য</th>
                                    <th>পরিমান</th>
                                </tr>
                                @foreach($products as $product)
                                    <?php
                                        if($product->cat_id == 3)
                                            $unit ="টি";
                                        else
                                            $unit = $product-> unit;
                                    ?>
                                    <tr>
                                        <td> {{$product-> name}} </td>
                                        <td> {{en2bn($product-> quantity).' '.$unit}} </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <p style="text-align: justify;"><b> মানুষের জন্য প্রাপ্ত দান হতে সাহায্য পাওয়ার জন্য বা আপনার নিকটস্থ খোঁজ পাওয়া অসহায় বা অর্থাভাবে চিকিৎসা করাতে পারছে না এমন মানুষের জন্য আমাদের সাথে যোগাযোগ করুন ।</b></p>
                        <p style="text-align: justify;"><a href ='{{ URL::to('product/1') }}'> <u>নিত্য প্রয়োজনীয় জিনিষ ডোনেট করুন।</u></a></p>
                        <p style="text-align: justify;"><a href ='{{ URL::to('product/3') }}'> <u>মেডিসিন ডোনেট করুন।</u></a></p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')
    <script>
    </script>
@endsection
