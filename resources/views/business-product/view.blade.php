@extends('layouts.app')
@section('content')
<div class="main-container row">
    <div class="col-md-10 col-md-offset-1">
        <h5 class="text-left">View Product</h5>
        <hr>
        @include('notification')
        @if (count($errors) > 0)
	        <div class="alert alert-danger">
	            <ul>
	                @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	                @endforeach
	            </ul>
	        </div>
        @endif
        <div class="panel panel-default document">
            <div class="container">
                <div class="col-md-5">
                    <div class="product col-md-12 service-image-left">
                        <div class="owl-carousel owl-theme">
                            @foreach($product->business_product_images as $product_image)
                                @if($product_image->featured_image==1)
                                    <img id="item-display" src="{{asset(config('image.product_image_url').''.$product_image->image)}}" alt="">
                                @endif
                            @endforeach
                            @foreach($product->business_product_images as $product_image)
                                @if($product_image->featured_image!=1)
                                    <img id="item-display" src="{{asset(config('image.product_image_url').''.$product_image->image)}}" alt="">
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="product-title"><label>Title:&nbsp;&nbsp;</label>{{$product->title}}</div>
                    <div class="product-desc"><label>Description:&nbsp;&nbsp;</label>{{$product->description}}</div>
                    <hr>
                    <div class="product-price"><label>Price:&nbsp;&nbsp;</label>{{Auth::user()->currency}} {{$product->price}}</div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
@section('header-scripts')
<link rel="stylesheet" type="text/css" href="{{ asset('css/owl.carousel.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/owl.theme.default.min.css') }}">
<script src="{{ asset('js/owl.carousel.min.js') }}" type="text/javascript"></script>
@endsection
@section('scripts')
<script type="text/javascript">
    function previewImg(img)
    {
        var id = img.id[img.id.length -1];
        input = "#preview"+img.id[img.id.length -1];
        if (img.files && img.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#preview'+id).attr('src', e.target.result);
            }
            reader.readAsDataURL(img.files[0]);
        }
    }
    $('.owl-carousel').owlCarousel({
        singleItem: true,
        items:1,
        loop:true,
        margin:10,
        autoplay:true,
        autoplayHoverPause:true,

        responsiveClass:true,
        responsive:{
            0:{
                items:1,
                nav:true
            },
            600:{
                items:1,
                nav:true
            },
            1000:{
                items:1,
                nav:true,
            }
        }
    })
</script>
@endsection