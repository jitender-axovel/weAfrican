@extends('layouts.app')
@section('content')
<div class="main-container row">
    <div class="col-md-10 col-md-offset-1">
        <h5 class="text-left">Edit Product</h5>
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
                @if(count($product_images)>0)
                @foreach($product_images as $key => $product_image)
                    @if($key==0)
                        <div class="form-group">
                            <input type="hidden" class="product_image_id" name="product_image_id[]" value="{{$product_image->id}}">
                            <label class="col-xs-2 control-label">Image</label>
                            <div class="col-xs-3">
                                <input type="file" class="form-control product_image" accept="image/*" name="product_image[{{$product_image->id}}]" value="{{ asset(config('image.product_image_url').'thumbnails/small/'.$product_image->image) }}" onchange="previewImg(this)" />
                            </div>
                            <div class="col-xs-3">
                                <img src="{{ asset(config('image.product_image_url').'thumbnails/small/'.$product_image->image) }}" alt="" id="preview">
                            </div>
                            <div class="col-xs-3">
                                <div class="radio">
                                  <label><input type="radio" class="featured_image" name="featured_image" @if($product_image->featured_image==1) checked="checked" @endif value="{{$key+1}}" /><br>Featured Image</label>
                                </div>
                            </div>
                            <div class="col-xs-1">
                                <button type="button" class="btn btn-default addButton"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    @else
                        <div class="form-group">
                            <input type="hidden" class="product_image_id" name="product_image_id[]" value="{{$product_image->id}}">
                            <div class="col-xs-3 col-xs-offset-2">
                                <input type="file" class="form-control product_image" accept="image/*" name="product_image[{{$product_image->id}}]" value="{{ asset(config('image.product_image_url').'thumbnails/small/'.$product_image->image) }}" onchange="previewImg(this)" />
                            </div>
                            <div class="col-xs-3">
                                <img src="{{ asset(config('image.product_image_url').'thumbnails/small/'.$product_image->image) }}" alt="" id="preview">
                            </div>
                            <div class="col-xs-3">
                                <div class="radio">
                                  <label><input type="radio" class="featured_image" name="featured_image" @if($product_image->featured_image==1) checked="checked" @endif value="{{$key+1}}" /><br>Featured Image</label>
                                </div>
                            </div>
                            <div class="col-xs-1">
                                <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                    @endif
                @endforeach
                @else
                    <div class="form-group">
                        <label class="col-xs-2 control-label">Image</label>
                        <div class="col-xs-3">
                            <input type="file" class="form-control" accept="image/*" name="product_image[]" onchange="previewImg(this)" />
                        </div>
                        <div class="col-xs-3">
                            <img src="{{asset('images/no-image.jpg')}}" alt="" id="preview">
                        </div>
                        <div class="col-xs-3">
                            <div class="radio">
                              <label><input type="radio" class="featured_image" name="featured_image" checked="checked" value="1" />&nbsp;Featured Image</label>
                            </div>
                        </div>
                        <div class="col-xs-1">
                            <button type="button" class="btn btn-default addButton"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                @endif
                <!-- The template for adding new field -->
                <div class="form-group hide" id="bookTemplate">
                    <div class="col-xs-3 col-xs-offset-2">
                        <input type="file" class="form-control product_image" accept="image/*" name="product_image[]" onchange="previewImg(this)" />
                    </div>
                    <div class="col-xs-3">
                        <img src="{{asset('images/no-image.jpg')}}" alt="" id="preview">
                    </div>
                    <div class="col-xs-3">
                        <div class="radio">
                          <label><input type="radio" class="featured_image" name="featured_image" value="1" /><br>Featured Image</label>
                        </div>
                    </div>
                    <div class="col-xs-1">
                        <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
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
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/jquery.formvalidation/0.6.1/css/formValidation.min.css">
<script src='https://cdn.jsdelivr.net/jquery.formvalidation/0.6.1/js/formValidation.min.js'></script>
<script src='https://cdn.jsdelivr.net/jquery.formvalidation/0.6.1/js/framework/bootstrap.min.js'></script>
<script type="text/javascript">
    function previewImg(img)
    {
        var id = img.id[img.id.length -1];
        if (img.files && img.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(img).closest('.form-group').find("img").attr('src', e.target.result);
            }
            reader.readAsDataURL(img.files[0]);
        }
    }
    
    $(document).ready(function() {
        // The maximum number of options
        var MAX_OPTIONS = 5;
        $('#register-form').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                title: {
                    validators: {
                            stringLength: {
                            min: 2,
                        },
                            notEmpty: {
                            message: 'Please supply your product title'
                        }
                    }
                },
                price: {
                    validators:{
                        notEmpty: {
                                message: 'Please supply your product price'
                            },
                        numeric: {
                        message: 'The price must be a number',
                        transformer: function($field, validatorName, validator) {
                            var value = $field.val();
                            return value.replace(',', '');
                        }
                    }
                    }
                },
                description: {
                    validators:{
                    notEmpty: {
                            message: 'Please supply your product description'
                        }
                    }
                },
                'product_image[]': {
                    row: '.col-xs-3',
                    validators: {
                        notEmpty: {
                            message: 'Please choose a product image'
                        },
                        file: {
                            extension: 'jpeg,jpg,png',
                            type: 'image/jpg,image/png,image/x-png,image/x-jpg,image/jpeg',
                            maxSize: 10 * 1024 * 1024, // 2048 * 1024
                            message: 'Please choose a image file with a size less than 4M.',
                        },
                    }
                },
                featured_image: {
                    validators:{
                    notEmpty: {
                            message: 'Please select a featured image'
                        }
                    }
                },
                @foreach($product_images as $product_image)
                    'product_image[{{$product_image->id}}]':{
                        row: '.col-xs-3',
                        validators: {
                            file: {
                                extension: 'jpeg,jpg,png',
                                type: 'image/jpg,image/png,image/x-png,image/x-jpg,image/jpeg',
                                maxSize: 10 * 1024 * 1024, // 2048 * 1024
                                message: 'Please choose a image file with a size less than 4M.',
                            },
                        }
                    },
                @endforeach
            }
        })

        // Called after adding new field
        .on('added.field.fv', function(e, data) {
            // data.field   --> The field name
            // data.element --> The new field element
            // data.options --> The new field options
            if (data.field === 'product_image[]') {
                if ($('#register-form').find(':visible[name^="product_image["]').length >= MAX_OPTIONS) {
                    $('#register-form').find('.addButton').attr('disabled', 'disabled');
                }
            }
        })

        // Called after removing the field
        .on('removed.field.fv', function(e, data) {
           if (data.field === 'product_image[]') {
                if ($('#register-form').find(':visible[name^="product_image["]').length < MAX_OPTIONS) {
                    $('#register-form').find('.addButton').removeAttr('disabled');
                }
            }
        })

        // Add button click handler
        .on('click', '.addButton', function() {
            var $template = $('#bookTemplate'),
                $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .insertBefore($template);

            // Add new fields
            // Note that we DO NOT need to pass the set of validators
            // because the new field has the same name with the original one
            // which its validators are already set
            $("#featured_image option:not(:first)").remove();
            for(var i=1; i<=$('#register-form').find(':visible[name^="product_image["]').length; i++)
            {
                $('#featured_image').append('<option value="'+i+'">'+i+'</option>');
            }
            $('#register-form')
                .formValidation('addField', $clone.find('[name="product_image[]"]'))
                .formValidation('revalidateField', 'featured_image');
            var i=1;
            $('.featured_image').each(function(){
                if ($('#register-form').find(':visible[name="product_title[]"]').length < MAX_OPTIONS) {
                    var $row = $(this).closest('.form-group');
                    $row.find('[name="featured_image"]').attr('value',i);
                    i++;
                }
            });
            $('#register-form').formValidation('revalidateField', 'featured_image');
        })

        // Remove button click handler
        .on('click', '.removeButton', function() {
            var $row = $(this).closest('.form-group');

            // Remove fields
            $('#register-form')
                .formValidation('removeField', $row.find('[name="product_image[]"]'))
                .formValidation('revalidateField', 'featured_image');

            // Remove element containing the fields
            $row.remove();
            var i=1;
            $('.featured_image').each(function(){
                if ($('#register-form').find(':visible[name^="product_image["]').length < MAX_OPTIONS) {
                    var $row = $(this).closest('.form-group');
                    $row.find('[name="featured_image"]').attr('value',i);
                    i++;
                }
            });
            $('#register-form').formValidation('revalidateField', 'featured_image');
        })
        .on('success.field.fv', function(e, data) {
            if (data.fv.getSubmitButton()) {
                data.fv.disableSubmitButtons(false);
            }
        });
        
    });
</script>
@endsection