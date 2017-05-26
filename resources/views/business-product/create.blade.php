@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="main-container row">
    <div class="col-md-10 col-md-offset-1">
        <h5 class="text-left">Add Product</h5>
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
                        <textarea required type="text" class="form-control" name="description"></textarea>
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
                        <input type="file" name="product_image[]" accept="image/*" onchange="previewImg(this)" id="product_image1" required>
                        @if($errors->has('product_image.0'))
	                        <span class="help-block">
	                        <strong>{{ $errors->first('product_image') }}</strong>
	                        </span>
                        @endif
                    </div>
                    <label for="city" class="col-md-2 control-label">Image Preview</label>
                    <div class="col-md-4">
                        <img src="{{asset('images/no-image.jpg')}}" alt=""  id="preview1">
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="col-md-2 required control-label">Image</label>
                    <div class="col-md-4">
                        <input type="file" name="product_image[]" accept="image/*" onchange="previewImg(this)" id="product_image2" required>
                        @if($errors->has('product_image.1'))
                            <span class="help-block">
                            <strong>{{ $errors->first('product_image') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label for="city" class="col-md-2 control-label">Image Preview</label>
                    <div class="col-md-4">
                        <img src="{{asset('images/no-image.jpg')}}" alt=""  id="preview2">
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="col-md-2 required control-label">Image</label>
                    <div class="col-md-4">
                        <input type="file" name="product_image[]" accept="image/*" onchange="previewImg(this)" id="product_image3" required>
                        @if($errors->has('product_image.2'))
                            <span class="help-block">
                            <strong>{{ $errors->first('product_image') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label for="city" class="col-md-2 control-label">Image Preview</label>
                    <div class="col-md-4">
                        <img src="{{asset('images/no-image.jpg')}}" alt=""  id="preview3">
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="col-md-2 required control-label">Image</label>
                    <div class="col-md-4">
                        <input type="file" name="product_image[]" accept="image/*" onchange="previewImg(this)" id="product_image4" required>
                        @if($errors->has('product_image.3'))
                            <span class="help-block">
                            <strong>{{ $errors->first('product_image') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label for="city" class="col-md-2 control-label">Image Preview</label>
                    <div class="col-md-4">
                        <img src="{{asset('images/no-image.jpg')}}" alt=""  id="preview4">
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="col-md-2 required control-label">Image</label>
                    <div class="col-md-4">
                        <input type="file" name="product_image[]" accept="image/*" onchange="previewImg(this)" id="product_image5" required>
                        @if($errors->has('product_image.4'))
                            <span class="help-block">
                            <strong>{{ $errors->first('product_image') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label for="city" class="col-md-2 control-label">Image Preview</label>
                    <div class="col-md-4">
                        <img src="{{asset('images/no-image.jpg')}}" alt=""  id="preview5">
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