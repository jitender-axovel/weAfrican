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
	<div class="main-container row">
	    <div class="col-md-10 col-md-offset-1">
	        <h4>Add Product</h4>
	        <form id="register-form" class="form-horizontal" action="{{ url('business-product') }}" method="POST" enctype='multipart/form-data'>
	            {{csrf_field()}}
	            <div class="form-group ">
	                <label for="category" class="col-md-2 required control-label">Product Name</label>
	                <div class="col-md-4">
	                    <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
	                    @if($errors->has('title'))
	                    <span class="help-block">
	                    <strong>{{ $errors->first('title') }}</strong>
	                    </span>
	                    @endif
	                </div>
	                <label for="price" class="col-md-2 required control-label">Price</label>
	                <div class="col-md-4">
	                    <input type="text" class="form-control" name="price" value="{{ old('price') }}" required>
	                    @if($errors->has('price'))
	                    <span class="help-block">
	                    <strong>{{ $errors->first('price') }}</strong>
	                    </span>
	                    @endif
	                </div>
	            </div>
	            <div class="form-group ">
	                <label for="description" class="col-md-2 required control-label">Description</label>
	                <div class="col-md-4">
	                    <input type="text" class="form-control" name="description" value="" required >
	                    @if($errors->has('description'))
	                    <span class="help-block">
	                    <strong>{{ $errors->first('description') }}</strong>
	                    </span>
	                    @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="address" class="col-md-2 required control-label">Image</label>
	                <div class="col-md-4">
	                    <input type="file" name="product_image" id="product_image" required>
	                    @if($errors->has('product_image'))
	                    <span class="help-block">
	                    <strong>{{ $errors->first('product_image') }}</strong>
	                    </span>
	                    @endif
	                </div>
	                <label for="city" class="col-md-2 control-label">Image Preview</label>
	                <div class="col-md-4">
	                    <img src="#" alt=""  id="preview">
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-md-12 col-md-offset-2">
	                    <button type="submit" class="btn btn-primary">
	                    Submit
	                    </button>
	                </div>
	            </div>
	        </form>
	    </div>
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
