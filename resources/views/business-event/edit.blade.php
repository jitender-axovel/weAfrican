@extends('layouts.app')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}"/>
@endsection
@section('content')
<div class="main-container row">
    <div class="col-md-10 col-md-offset-1">
        <h5 class="text-left">Edit Event</h5>
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
            <form id="register-form" class="form-horizontal" action="{{ url('business-event/'.$event->id) }}" method="POST" enctype='multipart/form-data'>
                {{csrf_field()}}
                {{ method_field('PUT') }}
                <div class="form-group ">
                    <label for="category" class="col-md-2 required control-label">Category</label>
                    <div class="col-md-4">
                        <select required name="event_category_id" required>
                            <option value="" selected>Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if($event->category->title == $category->title){{ 'selected'}} @else @endif  >{{ $category->title }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('event_category_id'))
                            <span class="help-block">
                            <strong>{{ $errors->first('event_category_id') }}</strong>
                            </span>
                        @endif
                    </div>
                     <label for="name" class="col-md-2 required control-label">Event Name</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="name" value="{{ $event->name }}" required>
                        @if($errors->has('name'))
                            <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group ">
                   
                    <label for="keywords" class="col-md-2 required control-label">Event Keywords</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="keywords" value="{{ $event->keywords }}" required>
                        @if($errors->has('keywords'))
	                        <span class="help-block">
	                        <strong>{{ $errors->first('keywords') }}</strong>
	                        </span>
                        @endif
                    </div>
                    <label for="organizer_name" class="col-md-2 required control-label">Organizer Name</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="organizer_name" value="{{ $event->organizer_name }}" required >
                        @if($errors->has('organizer_name'))
                            <span class="help-block">
                            <strong>{{ $errors->first('organizer_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-md-2 required control-label">Description</label>
                    <div class="col-md-10">
                        <textarea required type="text" class="form-control" name="description">{{ $event->description }}</textarea>
                        @if($errors->has('description'))
                            <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="start_date_time" class="col-md-2 required control-label">Event Starting Date& Time</label>
                    <div class="col-md-4">
                    <div class='input-group date' id='datetimepicker1'>
                        <input type='text' class="form-control" id='datetimepicker1' name="start_date_time" value="{{ date('m/d/Y h:i A', strtotime($event->start_date_time))}}" >
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                        @if($errors->has('start_date_time'))
                            <span class="help-block">
                               <strong>{{ $errors->first('start_date_time') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label for="end_date_time" class="col-md-2 required control-label">Event Ending Date& Time</label>
                    <div class="col-md-4">
                    <div class='input-group date' id='datetimepicker2'>
                        <input type='text' class="form-control" id='datetimepicker2' name="end_date_time" value="{{ date('m/d/Y h:i A', strtotime($event->end_date_time))}}" >
                            <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                        @if($errors->has('end_date_time'))
                            <span class="help-block">
                                <strong>{{ $errors->first('end_date_time') }}</strong>
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
                <div class="form-group ">
                    <label for="address" class="col-md-2  control-label">Address</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="address" value="{{ $event->address }}" required >
                        @if($errors->has('address'))
                            <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label for="city" class="col-md-2 control-label">City:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="city" name="city" value="{{ $event->city }}">
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
                            <input type="text" class="form-control" id="state" name="state" value="{{ $event->state }}">
                            @if ($errors->has('state'))
                                <span class="help-block">
                                <strong>{{ $errors->first('state') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="country" class="col-md-2 control-label">Country:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="country" name="country" value="{{ $event->country }}">
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
                            <input required type="text" pattern="[0-9]{6}" id="pin_code" class="form-control" name="pin_code" value="{{ $event->pin_code }}">
                            @if ($errors->has('pin_code'))
                                <span class="help-block">
                                <strong>{{ $errors->first('pin_code') }}</strong>
                                </span>
                            @endif
                        </div>
                        </div>
                
                <div class="form-group ">
                    <label for="banner" class="col-md-2  control-label">Banner Image</label>
                    <div class="col-md-4">
                        <img src="{{asset(config('image.banner_image_url').'event/thumbnails/small/'.$event->banner)}}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="banner" class="col-md-2 control-label">Image</label>
                    <div class="col-md-4">
                        <input type="file" name="banner" id="banner">
                        @if($errors->has('banner'))
                        <span class="help-block">
                        <strong>{{ $errors->first('banner') }}</strong>
                        </span>
                        @endif
                    </div>
                    <label for="city" class="col-md-2 control-label">Banner Preview</label>
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
        }, "jsonp");
    </script>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('js/datepicker/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/datepicker/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/datepicker/bootstrap-datetimepicker.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datetimepicker1').datetimepicker();
        $('#datetimepicker2').datetimepicker();
    });

    function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
          }
        reader.readAsDataURL(input.files[0]);
      }
    }
    
    $("#banner").change(function(){
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
    $('#map').locationpicker({
        location: {
            latitude: 28.6667,
            longitude: 77.2167
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
</script>
@endsection