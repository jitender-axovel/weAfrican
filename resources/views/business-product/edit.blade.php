@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
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
	<div class="register-business">
		<h3 class="text-center">Edit Product</h3>
		<form id="register-form" class="form-horizontal" action="{{ url('business-product/'.$product->id) }}" method="POST" enctype='multipart/form-data'>
		{{csrf_field()}}
		{{ method_field('PUT') }}
		 	<div class="row">
        		<div class="col-xs-6 form-group">
            		<label>Product Name</label>
            		<input type="text" class="form-control" name="title" value="{{ $product->title }}" required>
					@if($errors->has('title'))
						<span class="help-block">
							<strong>{{ $errors->first('title') }}</strong>
						</span>
					@endif
				</div>
		        <div class="col-xs-6 form-group">
		            <label>Price</label>
					<input type="text" class="form-control" name="price" value="{{ $product->price }}" required>
					@if($errors->has('price'))
						<span class="help-block">
							<strong>{{ $errors->first('price') }}</strong>
						</span>
					@endif
		        </div>
		        <div class="col-xs-12  form-group">
		        	<label class="col-md-6">Description</label>
					<input type="text" class="form-control" name="description" value="{{ $product->description }}" required >
						@if($errors->has('description'))
							<span class="help-block">
								<strong>{{ $errors->first('description') }}</strong>
							</span>
						@endif
				</div>
				<div class="col-xs-12 form-group">
					<label class="col-md-2">Product Image</label>
					 <img src="{{asset(config('image.product_image_url').'thumbnails/small/'.$product->image)}}"/>
				</div>
				<div class="col-xs-12 form-group">
					<label class="col-md-1">Image</label>
					 <input type="file" name="product_image" id="product_image">
						@if($errors->has('product_image'))
							<span class="help-block">
								<strong>{{ $errors->first('product_image') }}</strong>
							</span>
						@endif
				</div>
			  	<div class="col-xs-12 form-group">
					<label class="col-md-6">Image Preview</label>
					<div class="caption col-md-6 col-md-offset-1">
						<img src="#" alt=""  id="preview">
					</div>
				</div>
		         <div class="col-xs-6 form-group">
		            <button type="submit" class="btn btn-default">Submit</button>
		        </div>
    		</div>
		</form>
	</div>	
@endsection
@section('scripts')
	<script type="text/javascript">

    function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
          }
        reader.readAsDataURL(input.files[0]);
      }
    }

    $("#product_image").change(function(){
        readURL(this);
    });
	</script>
@endsection
