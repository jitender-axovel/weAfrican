@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="main-container row">
    <div class="col-md-10 col-md-offset-1">
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
        <div class="panel panel-default">
            <div class="panel-heading">Register Your Business for Free</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/register-business') }}" enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class="form-group required">
                        <label for="full_name" class="col-md-2 control-label">Full Name:</label>
                        <div class="col-md-4">
                            <input required type="text" class="form-control" name="full_name" value="{{ old('full_name') }}" autofocus>
                            @if ($errors->has('full_name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('full_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="country_code" class="col-md-2 control-label">Country Code:</label>
                        <div class="col-md-4">
                            <input required type="text"
                                class="form-control" name="country_code" value="{{ old('country_code') }}" autofocus >
                            <span class="help-block">
                                <strong>Please Enter the country code. Ex: 91</strong>
                            </span>
                            @if ($errors->has('country_code'))
                                <span class="help-block">
                                <strong>Please Enter the contry code. Ex: 91{{ $errors->first('country_code') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="title" class="col-md-2 control-label">Business Name:</label>
                        <div class="col-md-4">
                            <input required type="text" class="form-control" name="title" value="{{ old('title') }}">
                            @if ($errors->has('title'))
                                <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="category" class="col-md-2 control-label">Category:</label>
                        <div class="col-md-4">
                            <select required name="bussiness_category_id" required>
                                <option value="" selected>Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if($category->title == $category->title){{ 'selected'}} @endif  >{{ $category->title }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('bussiness_category_id'))
                                <span class="help-block">
                                <strong>{{ $errors->first('bussiness_category_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="keywords" class="col-md-2 control-label">Business Keywords:</label>
                        <div class="col-md-4">
                            <input required type="text" class="form-control" name="keywords" value="{{ old('keywords') }}">
                            @if ($errors->has('keywords'))
                                <span class="help-block">
                                <strong>{{ $errors->first('keywords') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="email" class="col-md-2 control-label">Business Email:</label>
                        <div class="col-md-4">
                            <input required type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" class="form-control" name="email" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="password" class="col-md-2 control-label">Password:</label>
                        <div class="col-md-4">
                            <input required type="password" class="form-control" name="password" value="">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="confirm_password" class="col-md-2 control-label">Confirm Password:</label>
                        <div class="col-md-4">
                            <input required type="password" class="form-control" name="confirm_password" value="">
                            @if ($errors->has('confirm_password'))
                                <span class="help-block">
                                <strong>{{ $errors->first('confirm_password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="address" class="col-md-2 control-label">Location:</label>
                        <div id="map"></div>
                    </div>
                    <input type="hidden" id="latitude" class="form-control" name="latitude" value ="{{ old('latitude') }}">
                    <input type="hidden" id="longitude" class="form-control" name="longitude" value ="{{ old('longitude') }}">
                    <div class="form-group">
                        <label for="address" class="col-md-2 control-label">Address:</label>
                        <div class="col-md-4">
                            <input type="text" id="address"class="form-control" name="address" value="{{ old('address') }}">
                            @if ($errors->has('address'))
                                <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="city" class="col-md-2 control-label">City:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}">
                            @if ($errors->has('city'))
                                <span class="help-block">
                                <strong>{{ $errors->first('city') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="state" class="col-md-2 control-label">State:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="state" name="state" value="{{ old('state') }}" readonly="true">
                            @if ($errors->has('state'))
                                <span class="help-block">
                                <strong>{{ $errors->first('state') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="country" class="col-md-2 control-label">Country:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}" readonly="true">
                            @if ($errors->has('country'))
                                <span class="help-block">
                                <strong>{{ $errors->first('country') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pin_code" class="col-md-2 required control-label">Pin Code: (format:110075)</label>
                        <div class="col-md-4">
                            <input required type="text" pattern="[0-9]{6}" id="pin_code" class="form-control" name="pin_code" value="{{ old('pin_code') }}" readonly="true">
                            @if ($errors->has('pin_code'))
                                <span class="help-block">
                                <strong>{{ $errors->first('pin_code') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="website" class="col-md-2 control-label">Website:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="website" value="{{ old('website') }}">
                            @if ($errors->has('website'))
                                <span class="help-block">
                                <strong>{{ $errors->first('website') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="mobile_number" class="col-md-2 control-label">Primary Mobile Number:(format:99-99-999999)</label>
                        <div class="col-md-4">
                            <input required type="text" maxlength="10" minlength="10" pattern="[0-9]{10}" class="form-control" name="mobile_number" value="{{ old('mobile_number') }}">
                            @if ($errors->has('mobile_number'))
                                <span class="help-block">
                                <strong>{{ $errors->first('mobile_number') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="secondary_phone_number" class="col-md-2 control-label">
                        Secondary Mobile Number:
                        <span>(format:99-99-999999)</span>
                        </label>
                        <div class="col-md-4">
                            <input type="text"  maxlength="10" min-length="10" pattern="[0-9]{10}" class="form-control" name="secondary_phone_number" value="{{ old('secondary_phone_number') }}" required>
                            @if ($errors->has('secondary_phone_number'))
                                <span class="help-block">
                                <strong>{{ $errors->first('secondary_phone_number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="about_us" class="col-md-2 control-label">About us:</label>
                        <div class="col-md-4">
                            <textarea class="form-control" name="about_us" rows="10" ></textarea>
                            @if ($errors->has('about_us'))
                                <span class="help-block">
                                <strong>{{ $errors->first('about_us') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="working_hours" class="col-md-2 control-label">
                        Working Hours:
                        </label>
                        <div class="col-md-4">
                            <textarea class="form-control" name="working_hours" rows="10" ></textarea>
                            @if ($errors->has('working_hours'))
                                <span class="help-block">
                                <strong>{{ $errors->first('working_hours') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="business_logo" class="col-md-2 control-label">Business Logo:</label>
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
                            <img src="{{asset('images/no-image.jpg')}}" alt=""  id="preview">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="checkbox" class="col-md-2 control-label"></label>
                        <div class="col-md-10">
                            <input required name="is_agree_to_terms" value="" type="checkbox"> I hereby declare, that I have read and accepted the <a href="" data-toggle="modal" data-target="#myModal">Terms &amp; Conditions.</a>
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
</div>
<!-- Terms & Conditions Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Terms & Conditions</h4>
            </div>
            <div class="modal-body">
                @if($term->content)
                {!! $term->content !!}
                @else
                <p class="text-center">{{ $term->title }}'s page content is still being prepared.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('header-scripts')
    <script type="text/javascript" src='https://maps.google.com/maps/api/js?key=AIzaSyDEOk91hx04o7INiXclhMwqQi54n2Zo0gU&libraries=places'></script>
    <script src="{{ asset('js/dist/locationpicker.jquery.js') }}"></script>
    <script type="text/javascript">
        var lat;
        var long;
        var ip = "{{$ip}}";

        jQuery.get('http://freegeoip.net/json/'+ip, function (response){
            //alert(response.longitude);
            lat = parseFloat(response.latitude);
            long = parseFloat(response.longitude);
            buildMap(lat,long)
        }, "jsonp");
    </script>
@endsection
@section('scripts')
<script type="text/javascript">
    //Image preview jQuery
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

    //GeoLocation Map Script(locationPicker with jquery)
    function updateControls(addressComponents) {
        $('#us5-street1').val(addressComponents.addressLine1);
        $('#city').val(addressComponents.city);
        $('#state').val(addressComponents.stateOrProvince);
        $('#pin_code').val(addressComponents.postalCode);
        $('#country').val(addressComponents.country);
    }
    function buildMap(lat,long){
        $('#map').locationpicker({
            location: {
                latitude: lat,
                longitude: long
            },
            radius: 100,
            inputBinding: {
                        latitudeInput: $('#latitude'),
                        longitudeInput: $('#longitude'),
                        radiusInput: $('#us3-radius'),
                        locationNameInput: $('#address')
            },
            enableAutocomplete: true,
            onchanged: function (currentLocation, radius, isMarkerDropped) {
                var addressComponents = $(this).locationpicker('map').location.addressComponents;
                updateControls(addressComponents);
            },
            oninitialized: function (component) {
                var addressComponents = $(component).locationpicker('map').location.addressComponents;
                updateControls(addressComponents);
            }
        });
    }
</script>
@endsection