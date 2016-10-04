@extends('layouts.app')
@section('content')

<div class="main-container row">
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
    <div class="col-md-10 col-md-offset-1">
        <h4>Edit Business Profile</h4>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register-business/'.$business->id) }}" enctype='multipart/form-data'>
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-group ">
                <label for="title" class="col-md-2 required control-label">Business Name</label>
                <div class="col-md-4">
                    <input required type="text" class="form-control" name="title" value="{{ $business->title }}">
                    @if ($errors->has('title'))
                    <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
                    </span>
                    @endif
                </div>
                <label for="category" class="col-md-2 required control-label">Category</label>
                <div class="col-md-4">
                    <select required name="bussiness_category_id" required>
                        <option value="" selected>Select Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if($business->category->title == $category->title){{ 'selected'}} @else @endif  >{{ $category->title }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('bussiness_category_id'))
                    <span class="help-block">
                    <strong>{{ $errors->first('bussiness_category_id') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group ">
                <label for="keywords" class="col-md-2 required control-label">Business Keywords</label>
                <div class="col-md-4">
                    <input required type="text" class="form-control" name="keywords" value="{{ $business->keywords }}">
                    @if ($errors->has('keywords'))
                    <span class="help-block">
                    <strong>{{ $errors->first('keywords') }}</strong>
                    </span>
                    @endif
                </div>
                <label for="email" class="col-md-2 required control-label">Business Email</label>
                <div class="col-md-4">
                    <input required type="email" class="form-control" name="email" value=" {{$business->email }}">
                    @if ($errors->has('email'))
                    <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="address" class="col-md-2 control-label">Address</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="address" value="{{ $business->address }}">
                    @if ($errors->has('address'))
                    <span class="help-block">
                    <strong>{{ $errors->first('address') }}</strong>
                    </span>
                    @endif
                </div>
                <label for="city" class="col-md-2 control-label">City</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="city" value="{{ $business->city }}">
                    @if ($errors->has('city'))
                    <span class="help-block">
                    <strong>{{ $errors->first('city') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="state" class="col-md-2 control-label">State</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="state" value="{{ $business->state }}">
                    @if ($errors->has('state'))
                    <span class="help-block">
                    <strong>{{ $errors->first('state') }}</strong>
                    </span>
                    @endif
                </div>
                <label for="country" class="col-md-2 control-label">Country</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="country" value="{{ $business->country }}">
                    @if ($errors->has('country'))
                    <span class="help-block">
                    <strong>{{ $errors->first('country') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="pin_code" class="col-md-2 control-label">Pin Code</label>
                <div class="col-md-4">
                    <input type="number" class="form-control" name="pin_code" value="{{ $business->pin_code }}" required>
                    @if ($errors->has('pin_code'))
                    <span class="help-block">
                    <strong>{{ $errors->first('pin_code') }}</strong>
                    </span>
                    @endif
                </div>
                <label for="website" class="col-md-2 control-label">Website</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="website" value="{{ $business->website }}">
                    @if ($errors->has('website'))
                    <span class="help-block">
                    <strong>{{ $errors->first('website') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group ">
                <label for="mobile_number" class="col-md-2 required control-label">Primary Mobile Number:</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="mobile_number" value="{{ $business->mobile_number }}" disabled>
                    @if ($errors->has('mobile_number'))
                    <span class="help-block">
                    <strong>{{ $errors->first('mobile_number') }}</strong>
                    </span>
                    @endif
                </div>
                <label for="secondary_phone_number" class="col-md-2 control-label">
                Secondary Mobile Number:(format:99-99-999999)
                </label>
                <div class="col-md-4">
                    <input type="text" maxlength="10" min-length="10" pattern="[0-9]{10}" class="form-control" name="secondary_phone_number" value="{{ $business->secondary_phone_number }}">
                    @if ($errors->has('secondary_phone_number'))
                    <span class="help-block">
                    <strong>{{ $errors->first('secondary_phone_number') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="about_us" class="col-md-2 control-label">About us</label>
                <div class="col-md-4">
                    <textarea class="form-control" name="about_us" rows="10" >{{ $business->about_us }}</textarea>
                    @if ($errors->has('about_us'))
                    <span class="help-block">
                    <strong>{{ $errors->first('about_us') }}</strong>
                    </span>
                    @endif
                </div>
                <label for="working_hours" class="col-md-2 control-label">
                Working Hours
                </label>
                <div class="col-md-4">
                    <textarea class="form-control" name="working_hours" rows="10" >{{ $business->working_hours }}</textarea>
                    @if ($errors->has('working_hours'))
                    <span class="help-block">
                    <strong>{{ $errors->first('working_hours') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="about_us" class="col-md-2 control-label">Business Logo</label>
                <div class="col-md-10">
                    @if($business->business_logo != NULL)
                        <img src="{{asset(config('image.logo_image_url').$business->business_logo)}}" style="width:100px;height:100px"/>
                    @else
                        <img src="{{asset('images/no-uploaded.png')}}" style="width:100px;height:100px"/>
                    @endif
                </div>
            </div>
              <div class="form-group">
                    <label for="business_logo" class="col-md-2 control-label">Edit Business Logo:</label>
                    <div class="col-md-4">
                        <input type="file" name="business_logo" id="business_logo">
                        @if ($errors->has('business_logo'))
                            <span class="help-block">
                            <strong>{{ $errors->first('business_logo') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label for="logo_preview" class="col-md-2 control-label">
                        Logo Preview:
                        </label>
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
    
    $("#business_logo").change(function(){
        readURL(this);
    });
</script>
@endsection