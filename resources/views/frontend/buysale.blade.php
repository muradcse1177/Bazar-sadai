@extends('frontend.frontLayout')
@section('title', 'ক্রয় বিক্রয়')
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
    <div class="row">
        <div>
            <center><a href="{{URL::to('/login')}}"><button class='btn btn-success btn-sm withPick btn-flat allButton'> কোন কিছু বিক্রয় করতে এখানে ক্লিক অরুন</button></a></center>
        </div><br>
        <div class="col-md-12">
            <?php

            //dd($products);
                foreach ($products as $product){
                    $id = $product->seller_id;
                    $user_info = DB::table('users')
                        ->where('users.id', $id)
                        ->where('users.status', 1)
                        ->first();

                    if(!empty($user_info)) {
                        $address_type = $user_info->address_type;
                        if ($address_type == 1) {
                            $seller_address = DB::table('users')
                                ->select('*', 'users.name as sellername','divisions.name as divname', 'districts.name as disname'
                                    , 'upazillas.name as upzname', 'unions.name as uniname', 'wards.name as wardsname')
                                ->join('divisions', 'users.add_part1', '=', 'divisions.id')
                                ->join('districts', 'users.add_part2', '=', 'districts.id')
                                ->join('upazillas', 'users.add_part3', '=', 'upazillas.id')
                                ->join('unions', 'users.add_part4', '=', 'unions.id')
                                ->join('wards', 'users.add_part5', '=', 'wards.id')
                                ->where('users.id',$id)
                                ->first();
                        }
                        if ($address_type == 2) {
                            $seller_address = DB::table('users')
                                ->select('*', 'users.name as sellername','divisions.name as divname', 'cities.name as disname'
                                    , 'city_corporations.name as upzname', 'thanas.name as uniname', 'c_wards.name as wardsname')
                                ->join('divisions', 'users.add_part1', '=', 'divisions.id')
                                ->join('cities', 'users.add_part2', '=', 'cities.id')
                                ->join('city_corporations', 'users.add_part3', '=', 'city_corporations.id')
                                ->join('thanas', 'users.add_part4', '=', 'thanas.id')
                                ->join('c_wards', 'users.add_part5', '=', 'c_wards.id')
                                ->where('users.id',$id)
                                ->first();
                        }
                    }

            ?>

                @php
                $Image =url('/')."/public/asset/images/noImage.jpg";
                   if(!empty($product->photo))
                       $Image =url('/').'/'.$product->photo;
                @endphp
                <div  id="" class="">
                    <img src="{{$Image}}" width ="100%" height="150" >
                </div>
                <div class='col-sm-12'>
                    <p>
                        <b>{{"প্রাণীর নামঃ ". $product->name .','.' '.'দামঃ '. en2bn($product->price).' টাকা '.','." জাতঃ ". $product->jat .','." রঙঃ ". $product->color.','." ওজনঃ ". en2bn($product->weight).' কেজি' }} </b>
                    </p>
                    <p>
                        {{"ঠিকানাঃ ".$product->address}}
                    </p>
                </div>

                <div class="col-md-12">
                    <span>
                    <div class='col-sm-4'>
                        <button class='btn btn-success btn-sm edit btn-flat details ' data-id='{{$product->id}}'><i class="fa fa-shopping-search "></i> বিস্তারিত</button>
                       <a href="{{ URL::to('animalSaleView/'.$product->id) }}"><button type="submit" data-id="{{$product->id}}" class="btn btn-default btn-flat btn-sm submit"><i class="fa fa-shopping-bag"></i>
                        </button></a>
                    </div>
</span>
                </div><hr>
           <?php } ?>
        </div>
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
    </script>
@endsection
