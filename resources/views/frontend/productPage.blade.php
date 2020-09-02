@extends('frontend.frontLayout')
@section('title', 'পন্য')
@section('ExtCss')
<style>
    .medicine_text{
        font-size: 20px;
        text-align: justify;
    }
    .col-sm-12{
        padding-right: 0px;
        padding-left: 0px;
    }
    .col-sm-6{
        padding-right: 0px;
        padding-left: 0px;
    }
    .pDiv1 {
        width: 120px;
        height: 120px;
        margin-right: 2px;
        float: left;
    }
    .imgProduct{
        border: 1px solid darkgreen;
    }
    .pProduct{
        margin-bottom:2px;
    }
</style>
@endsection
@section('content')
    <div class="callout" id="callout" style="display:none">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <span class="message"></span>
    </div>
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
            <?php
                if($products[0]->cat_id == 3){
            ?>
        <center>
            <button type="button" class="btn allButton trade_button">ট্রেড নাম</button>
            <button type="button" class="btn allButton generic_button">জেনেরিক নাম</button>
            <button type="button" class="btn allButton company_button">কোম্পানি</button>
            <div style="padding-top: 10px;">
                {{ Form::open(array('url' => 'searchMedicine',  'method' => 'get')) }}
                {{ csrf_field() }}
                <input type="text" name="trade_name" id="trade_name"  placeholder=" Search Trade Name"  class="form-control searchMedicine" style="display: none;">
                <input type="text" name="generic_name" id="generic_name" placeholder="Search Generic Name" class="form-control searchMedicine" style="display: none;">
                <input type="text" name="company_name" id="company_name" placeholder="Search Company Name" class="form-control searchMedicine" style="display: none;">
                <button type="submit" class="pull-right" style="display: none;"></button>
                {{ Form::close() }}
            </div>
        </center>
        <center>
            <a href="{{url('searchMedicineByLetter/A')}}" class="medicine_text"> <u>A</u></a>
            <a href="{{url('searchMedicineByLetter/B')}}" class="medicine_text"> <u>B</u></a>
            <a href="{{url('searchMedicineByLetter/C')}}" class="medicine_text"> <u>C</u></a>
            <a href="{{url('searchMedicineByLetter/D')}}" class="medicine_text"> <u>D</u></a>
            <a href="{{url('searchMedicineByLetter/E')}}" class="medicine_text"> <u>E</u></a>
            <a href="{{url('searchMedicineByLetter/F')}}" class="medicine_text"> <u>F</u></a>
            <a href="{{url('searchMedicineByLetter/G')}}" class="medicine_text"> <u>G</u></a>
            <a href="{{url('searchMedicineByLetter/H')}}" class="medicine_text"> <u>H</u></a>
            <a href="{{url('searchMedicineByLetter/I')}}" class="medicine_text"> <u>I</u></a>
            <a href="{{url('searchMedicineByLetter/J')}}" class="medicine_text"> <u>J</u></a>
            <a href="{{url('searchMedicineByLetter/K')}}" class="medicine_text"> <u>K</u></a>
            <a href="{{url('searchMedicineByLetter/L')}}" class="medicine_text"> <u>L</u></a>
            <a href="{{url('searchMedicineByLetter/M')}}" class="medicine_text"> <u>M</u></a>
            <a href="{{url('searchMedicineByLetter/N')}}" class="medicine_text"> <u>N</u></a>
            <a href="{{url('searchMedicineByLetter/O')}}" class="medicine_text"> <u>O</u></a>
            <a href="{{url('searchMedicineByLetter/P')}}" class="medicine_text"> <u>P</u></a>
            <a href="{{url('searchMedicineByLetter/Q')}}" class="medicine_text"> <u>Q</u></a>
            <a href="{{url('searchMedicineByLetter/R')}}" class="medicine_text"> <u>R</u></a>
            <a href="{{url('searchMedicineByLetter/S')}}" class="medicine_text"> <u>S</u></a>
            <a href="{{url('searchMedicineByLetter/T')}}" class="medicine_text"> <u>T</u></a>
            <a href="{{url('searchMedicineByLetter/U')}}" class="medicine_text"> <u>U</u></a>
            <a href="{{url('searchMedicineByLetter/V')}}" class="medicine_text"> <u>V</u></a>
            <a href="{{url('searchMedicineByLetter/W')}}" class="medicine_text"> <u>W</u></a>
            <a href="{{url('searchMedicineByLetter/X')}}" class="medicine_text"> <u>X</u></a>
            <a href="{{url('searchMedicineByLetter/Y')}}" class="medicine_text"> <u>Y</u></a>
            <a href="{{url('searchMedicineByLetter/Z')}}" class="medicine_text"> <u>Z</u></a>
        </center>
        <?php
            }
            else{ ?>
                <center>
                    <button class='btn allButton withPick'> ছবিসহ দেখুন</button>
                    <button style="display: none;" class='btn allButton withoutPick'> ছবি বাদে দেখুন</button>
                </center>
        <?php
           }
        ?>
        <?php

            function en2bn($number) {
                $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
                $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
                $bn_number = str_replace($search_array, $replace_array, $number);
                return $bn_number;
            }
        ?>
        @foreach($products as $product)
            <div class='col-sm-6'>
                <div class="card">
                    <div class="card-body cardBody pCard">
                        @php
                            if($status['status']==1)  $price = $product->edit_price;
                            if($status['status']==0)  $price = $product->price;
                            $Image ="";
                               if(!empty($product->photo))
                                   $Image =url('/').'/'.$product->photo;
                               else
                                   $Image =url('/')."/public/asset/images/noImage.jpg";
                        @endphp
                        <div class='col-sm-12'>
                                <div class="pDiv1">
                                    <div id="{{$product->id.'bphoto'}}" >
                                        <img class="imgProduct" src="{{$Image}}" width ="118" height="115">
                                    </div>
                                </div>

                                <div class="pDiv2">
                                    <p class="pProduct">{{$product->name .' - '.en2bn($price.' টাকা')}}
                                    </p>
                                    @if($product->cat_id !=3)
                                        <p class="pProduct">{{en2bn($product->minqty).' '.$product->unit}}</p>
                                    @endif
                                    @if($product->cat_id==3)
                                        <p class="pProduct">{{$product->unit}}</p>
                                        <p class="pProduct">{{$product->type}}</p>
                                        <p class="pProduct">{{$product->company}}</p>
                                    @endif
                                </div>
                        </div>
                        <div class="col-sm-12 pForm">
                            <form class="form-inline" id="{{$product->id.'productForm'}}">
                                <div class="form-group">
                                    <div class="input-group col-sm-12">
                                    <span class="input-group-btn">
                                        <button type="button" id="minus" class="btn btn-default btn-flat btn-lg minus"  data-id="{{$product->id}}"><i class="fa fa-minus"></i></button>
                                    </span>
                                        <input type="text" name="quantity" style="text-align: center; " id="{{$product->id.'q'}}" class="form-control input-lg" value="{{$product->minqty}}" readonly>
                                        <span class="input-group-btn">
                                        <button type="button" id="add" class="btn btn-default btn-flat btn-lg add" data-id="{{$product->id}}"><i class="fa fa-plus"></i>
                                        </button>
                                    </span>
                                        <input type="hidden" value="{{$product->id}}" name="id">
                                        <span class="input-group-btn">
                                             <button type="submit" data-id="{{$product->id}}" id="{{'bg'.$product->id}}"  class="btn btn-default btn-flat btn-lg submit">
                                                 <i class="fa fa-shopping-bag"></i>
                                             </button>
                                            <button type="submit" id="{{'ch'.$product->id}}" class="btn btn-default btn-flat btn-lg" style="display: none;" >
                                                 <i class="fa fa-check"></i>
                                            </button>
                                    </span>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
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
                $(".trade_button").click(function(){
                    $("#trade_name").show();
                    $("#generic_name").hide();
                    $("#company_name").hide();
                });
                $(".generic_button").click(function(){
                    $("#generic_name").show();
                    $("#trade_name").hide();
                    $("#company_name").hide();
                });
                $(".company_button").click(function(){
                    $("#company_name").show();
                    $("#trade_name").hide();
                    $("#generic_name").hide();
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
