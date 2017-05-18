@extends('layouts.app')
@section('content')
<div class="main-container row">
    <div class="col-md-10 col-md-offset-1">
        <h5 class="text-left">Edit Product</h5>
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
            <form id="register-form" class="form-horizontal" action="{{ url('business-product/'.$product->id) }}" method="POST" enctype='multipart/form-data'>
                {{csrf_field()}}
                {{ method_field('PUT') }}
                <div class="form-group ">
                    <label for="category" class="col-md-2 required control-label">Product Name</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="title" value="{{ $product->title }}" required>
                        @if($errors->has('title'))
                        <span class="help-block">
                        <strong>{{ $errors->first('title') }}</strong>
                        </span>
                        @endif
                    </div>
                    <label for="price" class="col-md-2 required control-label">Price</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="price" value="{{ $product->price }}" required>
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
                        <textarea required type="text" class="form-control" name="description">{{ $product->description }}</textarea>
                        @if($errors->has('description'))
                        <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="col-md-2 control-label">Image</label>
                    <div class="col-md-4">
                        <input type="file" name="product_image[]" accept="image/*" onchange="previewImg(this)" id="product_image1">
                        @if($errors->has('product_image'))
                        <span class="help-block">
                        <strong>{{ $errors->first('product_image') }}</strong>
                        </span>
                        @endif
                    </div>
                    <label for="city" class="col-md-2 control-label">Image Preview</label>
                    <div class="col-md-4">
                        @if(explode('|', $product->image)[0]!="")
                            <img src="{{asset(config('image.product_image_url').'thumbnails/small/'.explode('|', $product->image)[0])}}" alt=""  id="preview1">
                        @else
                            <img src="{{asset('images/no-image.jpg')}}" alt=""  id="preview1">
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="col-md-2 control-label">Image</label>
                    <div class="col-md-4">
                        <input type="file" name="product_image[]" accept="image/*" onchange="previewImg(this)" id="product_image2">
                        @if($errors->has('product_image'))
                        <span class="help-block">
                        <strong>{{ $errors->first('product_image') }}</strong>
                        </span>
                        @endif
                    </div>
                    <label for="city" class="col-md-2 control-label">Image Preview</label>
                    <div class="col-md-4">
                        @if(explode('|', $product->image)[1]!="")
                            <img src="{{asset(config('image.product_image_url').'thumbnails/small/'.explode('|', $product->image)[1])}}" alt=""  id="preview2">
                        @else
                            <img src="{{asset('images/no-image.jpg')}}" alt=""  id="preview2">
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="col-md-2 control-label">Image</label>
                    <div class="col-md-4">
                        <input type="file" name="product_image[]" accept="image/*" onchange="previewImg(this)" id="product_image3">
                        @if($errors->has('product_image'))
                        <span class="help-block">
                        <strong>{{ $errors->first('product_image') }}</strong>
                        </span>
                        @endif
                    </div>
                    <label for="city" class="col-md-2 control-label">Image Preview</label>
                    <div class="col-md-4">
                        @if(explode('|', $product->image)[2]!="")
                            <img src="{{asset(config('image.product_image_url').'thumbnails/small/'.explode('|', $product->image)[2])}}" alt=""  id="preview3">
                        @else
                            <img src="{{asset('images/no-image.jpg')}}" alt=""  id="preview3">
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="col-md-2 control-label">Image</label>
                    <div class="col-md-4">
                        <input type="file" name="product_image[]" accept="image/*" onchange="previewImg(this)" id="product_image4">
                        @if($errors->has('product_image'))
                        <span class="help-block">
                        <strong>{{ $errors->first('product_image') }}</strong>
                        </span>
                        @endif
                    </div>
                    <label for="city" class="col-md-2 control-label">Image Preview</label>
                    <div class="col-md-4">
                        @if(explode('|', $product->image)[3]!="")
                            <img src="{{asset(config('image.product_image_url').'thumbnails/small/'.explode('|', $product->image)[3])}}" alt=""  id="preview4">
                        @else
                            <img src="{{asset('images/no-image.jpg')}}" alt=""  id="preview4">
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="col-md-2 control-label">Image</label>
                    <div class="col-md-4">
                        <input type="file" name="product_image[]" accept="image/*" onchange="previewImg(this)" id="product_image5">
                        @if($errors->has('product_image'))
                        <span class="help-block">
                        <strong>{{ $errors->first('product_image') }}</strong>
                        </span>
                        @endif
                    </div>
                    <label for="city" class="col-md-2 control-label">Image Preview</label>
                    <div class="col-md-4">
                        @if(explode('|', $product->image)[4]!="")
                            <img src="{{asset(config('image.product_image_url').'thumbnails/small/'.explode('|', $product->image)[4])}}" alt=""  id="preview5">
                        @else
                            <img src="{{asset('images/no-image.jpg')}}" alt=""  id="preview5">
                        @endif
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