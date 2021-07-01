@extends('frontend.frontLayout')
@section('title', 'ক্রয় বিক্রয়')
@section('ExtCss')
    <style>
        .col-sm-12{
            padding-right: 0px;
            padding-left: 0px;
        }
        .col-md-12{
            padding-right: 0px;
            padding-left: 0px;
        }
        .col-md-6{
            padding-right: 0px;
            padding-left: 0px;
        }
        .col-sm-4{
            padding-right: 0px;
            padding-left: 0px;
        }
         .market {
             display: flex;
             justify-content: center;
             align-items: center;
             height: 200px;
         }
    </style>
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
    <?php
    use Illuminate\Support\Facades\DB;
    function en2bn($number) {
        $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $bn_number = str_replace($search_array, $replace_array, $number);
        return $bn_number;
    }
    ?>
    <?php
    $j=0;
    ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="sCard sPCard">
                {{ Form::open(array('url' => 'searchAnimal',  'method' => 'post')) }}
                {{ csrf_field() }}
                    <div class="form-group">
                        <div class="input-group">
                            <input class="form-control search" name="search" id="search" value="{{@$val}}" placeholder="তথ্য খুজুন">
                            <span class="input-group-btn">
                            <button class="btn btn-info"><i class="fa fa-search"></i></button>
                        </span>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
        @foreach ($products as $product)
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body cardBody pCard">
                        <div class="col-sm-12">
                            <div id="myCarousel<?php echo $j; ?>" class="carousel slide" data-ride="carousel">
                                <?php
                                $photo = json_decode($product->photo);
                                $photos = explode(",",$photo);
                                array_pop($photos);

                                $i=0;
                                ?>
                                <ol class="carousel-indicators">
                                @foreach($photos as $ph)
                                    <!-- Indicators -->
                                        @if($i==0)
                                            <li data-target="#myCarousel<?php echo $j; ?>" data-slide-to="<?php echo rand()?>" class="active"></li>
                                        @else
                                            <li data-target="#myCarousel<?php echo $j; ?>" data-slide-to="<?php echo rand()?>"></li>
                                        @endif
                                        <?php $i++; ?>
                                    @endforeach
                                </ol>
                            <?php
                            $i=0;
                            ?>
                            <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    @foreach($photos as $ph)
                                        @if($i==0)
                                            <div class="item active">
                                                <img src="{{url($ph)}}"  style="width:100%;" height="170">
                                            </div>
                                        @else
                                            <div class="item">
                                                <img src="{{url($ph)}}"  style="width:100%; height: 170px;">
                                            </div>
                                        @endif
                                        <?php $i++; ?>
                                    @endforeach
                                </div>
                                <a class="left carousel-control" href="#myCarousel<?php echo $j; ?>" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control" href="#myCarousel<?php echo $j; ?>" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                        <div class='col-sm-12'>
                            <p>
                                <b>{{"নামঃ ". $product->name .','.' '.'দামঃ '. en2bn($product->price).' টাকা' }} </b>
                            </p>
                        </div>
                        <div class='col-sm-12'>
                            <p>
                                <b>{{"পন্যের লোকেশনঃ". $product->address}} </b>
                            </p>
                        </div>
                        <div class="col-md-12">
                            <span>
                                <div class='col-sm-12'>
                                    <button class='btn btn-success btn-sm edit btn-flat details ' data-id='{{$product->id}}'><i class="fa fa-shopping-search "></i> বিস্তারিত</button>
                                    @if(@$product->video)
                                    <a href="{{ URL::to('videoView?id='.$product->id) }}"> <button class='btn btn-default btn-flat btn-sm video ' data-id='{{$product->id}}'><i class="fa fa-youtube-play "></i></button></a>
                                    @endif
                                    <a href="{{ URL::to('productSaleView/'.$product->id) }}"><button type="submit" data-id="{{$product->id}}" class="btn btn-default btn-flat btn-sm submit"><i class="fa fa-shopping-bag"></i></button></a>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <?php  $j++; ?>
        @endforeach
        {{$products->links()}}
    </div>
    <div class="modal fade"  tabindex="-1"   id="detailsModal"  role="dialog">
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
@endsection
@section('js')
    <script>
        $('#search').on('input', function() {
            var val = $('#search').val();
            $.ajax({
                type: 'GET',
                url: '{{url('/')}}/getAnimalSearchByValue',
                data: {val:val},
                dataType: 'json',
                success: function(response){
                    var data = response.data;

                    $( "#search" ).autocomplete({
                        source: data
                    });
                }
            });
        });


        $(function(){
            $(document).on('click', '.details', function(e){
                e.preventDefault();
                $('#detailsModal').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });
        });
        function getRow(id){
            $.ajax({
                type: 'POST',
                url: '{{url('/')}}/getSaleProductsDetails',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    $('#modalRes').html(data.description);
                }
            });
        }
        function getVideo(id){
            $.ajax({
                type: 'POST',
                url: '{{url('/')}}/getSaleProductsDetails',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    $('#modalRes').html(data.description);
                }
            });
        }
    </script>
@endsection
