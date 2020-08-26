@extends('frontend.frontLayout')
@section('title', 'পন্য')
@section('ExtCss')

@endsection
@section('content')
    <div class="callout" id="callout" style="display:none">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <span class="message"></span>
    </div>

    <div class="row">
        <div>
            <center><button class='btn btn-success btn-sm withPick btn-flat'> ছবিসহ দেখুন</button></center>
            <center><button style="display: none;" class='btn btn-success btn-sm withoutPick btn-flat'> ছবি বাদে দেখুন</button></center>
        </div>
        <?php
        function en2bn($number) {
            $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
            $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
            $bn_number = str_replace($search_array, $replace_array, $number);
            return $bn_number;
        }

        ?>
        @foreach($products as $product)
            @php

                if($status['status']==1)  $price = $product->edit_price;
                if($status['status']==0)  $price = $product->price;
                //$Image =url('/')."/public/asset/images/noImage.jpg";
                $Image ="";
                   if(!empty($product->photo))
                       $Image =url('/').'/'.$product->photo;
            @endphp
            @if((!empty($product->photo)))
                <div style="display: none;" id="{{$product->id.'bphoto'}}" class="photoShow">
                    <img src="{{$Image}}" width ="100%" height="150" >
                </div>
            @endif
            <div class='col-sm-12'>
                <p><b>{{$product->name .' '.'( '. en2bn($price).'টাকা প্রতি'.' '.en2bn($product->minqty).' '.$product->unit.' )'}} </b>
                <!-- <button class='btn btn-success btn-sm edit btn-flat' data-id='{{$product->id.'b'}}'> ছবি</button>-->
                </p>
            </div>
            <div class="col-md-12">
                <form class="form-inline" id="{{$product->id.'productForm'}}">
                    <div class="form-group">
                        <div class="input-group col-sm-12">
                            <span class="input-group-btn">
                                <button type="button" id="minus" class="btn btn-default btn-flat btn-lg minus"  data-id="{{$product->id}}"><i class="fa fa-minus"></i></button>
                            </span>
                            <input type="text" name="quantity" id="{{$product->id.'q'}}" class="form-control input-lg" value="{{$product->minqty}}" readonly>
                            <span class="input-group-btn">
                                <button type="button" id="add" class="btn btn-default btn-flat btn-lg add" data-id="{{$product->id}}"><i class="fa fa-plus"></i>
                                </button>
                            </span>
                            <input type="hidden" value="{{$product->id}}" name="id">
                            <span class="input-group-btn">
                                <button type="submit" data-id="{{$product->id}}" class="btn btn-default btn-flat btn-lg submit"><i class="fa fa-shopping-bag"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </form>
            </div><hr>
        @endforeach
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function(){
            $(function(){
                $(document).ready(function(){
                    $(".withPick").click(function(){
                        $(".photoShow").show();
                        $(".withPick").hide();
                        $(".withoutPick").show();
                    });

                });
                $(document).ready(function(){
                    $(".withoutPick").click(function(){
                        $(".photoShow").hide();
                        $(".withPick").show();
                        $(".withoutPick").hide();
                    });

                });
                $(document).on('click', '.add', function(e){
                    e.preventDefault();
                    var id = $(this).data('id');
                    console.log(id);
                    var host = window.location.host
                    var quantity = $("#"+id+"q").val();
                    console.log(quantity);
                    $.ajax({
                        type: 'POST',
                        url: 'getProductMiqty',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": id
                        },
                        dataType: 'json',
                        success: function(response){
                            var products = response.products;
                            var minqty = products.minqty;
                            quantity = parseInt(quantity) + parseInt(minqty);
                            $("#"+id+"q").val(quantity);
                        }
                    });
                });
                $(document).on('click', '.minus', function(e){
                    e.preventDefault();
                    var id = $(this).data('id');
                    console.log(id);
                    var quantity = $("#"+id+"q").val();
                    $.ajax({
                        type: 'POST',
                        url: 'getProductMiqty',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": id
                        },
                        dataType: 'json',
                        success: function(response){
                            var products = response.products;
                            var minqty = products.minqty;
                            if(quantity > parseInt(minqty)){
                                quantity = parseInt(quantity) - parseInt(minqty);
                            }
                            $("#"+id+"q").val(quantity);
                        }
                    });

                });
            });
        });

    </script>
@endsection
