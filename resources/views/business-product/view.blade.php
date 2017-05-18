@extends('layouts.app')
@section('content')
<div class="main-container row">
    <div class="col-md-10 col-md-offset-1">
        <h5 class="text-left">View Product</h5>
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
        	<form class="form-horizontal">
        		<div class="form-group ">
        			<label for="category" class="col-md-2">Product Name</label>
                    <div class="col-md-4">
                    	{{ $product->title }}
                    </div>
                    <label for="category" class="col-md-2">Product Price</label>
                    <div class="col-md-4">
                    	{{ $product->price }}
                    </div>
        		</div>
        		<div class="form-group ">
        			<label for="category" class="col-md-2">Product Description</label>
                    <div class="col-md-10">
                    	{{ $product->description }}
                    </div>
        		</div>
        		<div class="form-group ">
        			<label for="category" class="col-md-2">Product Image 1</label>
                    <div class="col-md-4">
                    	@if(explode('|',$product->image)[0]!="")
	        				<img src="{{asset(config('image.product_image_url').'thumbnails/small/'.explode('|', $product->image)[0])}}"/>
	        			@else
	        				<img src="{{asset('images/no-image.jpg')}}"/>
	        			@endif
                    </div>
                    <label for="category" class="col-md-2">Product Image 2</label>
                    <div class="col-md-4">
                    	@if(explode('|',$product->image)[0]!="")
	        				<img src="{{asset(config('image.product_image_url').'thumbnails/small/'.explode('|', $product->image)[1])}}"/>
	        			@else
	        				<img src="{{asset('images/no-image.jpg')}}"/>
	        			@endif
                    </div>
        		</div>
        		<div class="form-group ">
        			<label for="category" class="col-md-2">Product Image 3</label>
                    <div class="col-md-4">
                    	@if(explode('|',$product->image)[0]!="")
	        				<img src="{{asset(config('image.product_image_url').'thumbnails/small/'.explode('|', $product->image)[2])}}"/>
	        			@else
	        				<img src="{{asset('images/no-image.jpg')}}"/>
	        			@endif
                    </div>
                    <label for="category" class="col-md-2">Product Image 4</label>
                    <div class="col-md-4">
                    	@if(explode('|',$product->image)[0]!="")
	        				<img src="{{asset(config('image.product_image_url').'thumbnails/small/'.explode('|', $product->image)[3])}}"/>
	        			@else
	        				<img src="{{asset('images/no-image.jpg')}}"/>
	        			@endif
                    </div>
        		</div>
        		<div class="form-group ">
        			<label for="category" class="col-md-2">Product Image 5</label>
                    <div class="col-md-4">
                    	@if(explode('|',$product->image)[0]!="")
	        				<img src="{{asset(config('image.product_image_url').'thumbnails/small/'.explode('|', $product->image)[4])}}"/>
	        			@else
	        				<img src="{{asset('images/no-image.jpg')}}"/>
	        			@endif
                    </div>
        		</div>
        	</form>
            
        </div>
    </div>
</div>
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
</script>
@endsection