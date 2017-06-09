@extends('layouts.app')
@section('title', $pageTitle)
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}"/>
@endsection
@section('content')
<div class="main-container row">
    <div class="col-md-10 col-md-offset-1">
        <h5 class="text-left">Add Event</h5>
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
            <form id="event-form" class="form-horizontal" action="{{ url('business-event') }}" method="POST" enctype='multipart/form-data'>
                {{csrf_field()}}
                 <div class="form-group required">
                    <label class="col-md-2 control-label">Select Category:</label>
                    <div class="col-md-4">
                        <select required name="event_category_id" class="form-control js-example-basic-single" data-show-subtext="true" data-live-search="true" required>
                            <option value="" selected>Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" >{{ $category->title }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('event_category_id'))
                            <span class="help-block">
                            <strong>{{ $errors->first('event_category_id') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label class="col-md-2 required control-label"> Name of Event</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        @if($errors->has('name'))
                            <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group ">
                    
                    <label class="col-md-2 required control-label">Event Keywords</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="keywords" value="{{ old('keywords') }}" required>
                        @if($errors->has('keywords'))
	                        <span class="help-block">
	                        <strong>{{ $errors->first('keywords') }}</strong>
	                        </span>
                        @endif
                    </div>
                    <label class="col-md-2 required control-label">Organizer Name</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="organizer_name" value="{{ $business->title or old('organizer_name')}}" required>
                        @if($errors->has('organizer_name'))
                            <span class="help-block">
                            <strong>{{ $errors->first('organizer_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 required control-label">Description</label>
                    <div class="col-md-10">
                        <textarea required class="form-control" name="description"></textarea>
                        @if($errors->has('description'))
                            <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                </div>
                <div class="form-group">
                    <label class="col-md-2 required control-label">Event Start Date& Time</label>
                    <div class="col-md-4">
                        <div class='input-group date' id='datetimepicker1'>
                            <input type='text' class="form-control" id='datetimepicker1' name="start_date_time" value="{{ old('start_date_time') }}" />
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
                    <label class="col-md-2 required control-label">Event End Date& Time</label>
                    <div class="col-md-4">
                        <div class='input-group date' id='datetimepicker2'>
                            <input type='text' class="form-control" id='datetimepicker2' name="end_date_time" value="{{ old('end_date_time')}}" />
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
                    <div class="form-group">
                        <label class="col-md-2 control-label">Location:</label>
                        <div class="col-md-10">
                            <div id="map"></div>
                        </div>
                    </div>
                    <input type="hidden" id="latitude" class="form-control" name="latitude" value ="{{ old('latitude') }}">
                    <input type="hidden" id="longitude" class="form-control" name="longitude" value ="{{ old('longitude') }}">
                 <div class="form-group ">
                    <label class="col-md-2 required control-label">Address</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address')}}" required>
                        @if($errors->has('address'))
                            <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label class="col-md-2 control-label">City:</label>
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
                        <label class="col-md-2 control-label">State:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="state" name="state" value="{{ old('state') }}">
                            @if ($errors->has('state'))
                                <span class="help-block">
                                <strong>{{ $errors->first('state') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label class="col-md-2 control-label">Country:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}">
                            @if ($errors->has('country'))
                                <span class="help-block">
                                <strong>{{ $errors->first('country') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                      <div class="form-group">
                        <label class="col-md-2 required control-label">Pin Code: (format:110075)</label>
                        <div class="col-md-4">
                            <input required type="text" pattern="[0-9]{6}" id="pin_code" class="form-control" name="pin_code" value="{{ old('pin_code') }}">
                            @if ($errors->has('pin_code'))
                                <span class="help-block">
                                <strong>{{ $errors->first('pin_code') }}</strong>
                                </span>
                            @endif
                        </div>
                        </div>
                 <div class="form-group">
                    <label class="col-md-2 required control-label">Banner Image</label>
                    <div class="col-md-4">
                        <input type="file" name="banner" id="banner" required>
                        @if($errors->has('banner'))
                            <span class="help-block">
                            <strong>{{ $errors->first('banner') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label class="col-md-2 control-label">Banner Preview</label>
                    <div class="col-md-4">
                        <img src="{{asset('images/no-image.jpg')}}" alt=""  id="preview">
                    </div>
                </div>
                <fieldset>
                    <legend>Event Seating Plan</legend>
                </fieldset>
                <div class="form-group">
                    <label class="col-md-2 control-label">Total Number Of Seats</label>
                    <div class="col-md-4">
                        <select class="form-control js-example-basic-single" name="total_seats" id="total_seats" data-show-subtext="true" data-live-search="true">
                            <option value="">Select Total Seats</option>
                            @for($i=0;$i<=5000;$i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                @if(count($seatingplans)>0)
                    @foreach($seatingplans as $seatingplan)
                        <div class="form-group">
                            <label class="col-md-2 control-label">{{ $seatingplan->title }}</label>
                            <div class="col-md-4">
                                <select class="form-control js-example-basic-single" name="seating_plan[{{ $seatingplan->id }}]" data-show-subtext="true" data-live-search="true">
                                    <option value="">Select Seats for {{ $seatingplan->title }}</option>
                                    @for($i=1;$i<=5000;$i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <label class="col-md-3 control-label">{{ $seatingplan->title }} Per Ticket Price</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="seating_plan_price[{{ $seatingplan->id }}]" value="">
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="col-md-6 bs-example">
      <div class="input-group">
        <label for="PayDate" class="input-group-addon btn">
          <span class="glyphicon glyphicon-calendar"></span></label>
        <input type="text" id="PayDate" name="PayDate" class="form-control date-picker" />
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
    <script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>

    <script type="text/javascript">
        
        var lat;
        var long;
        var ip = "{{$ip}}";
        function getLocation()
        {
            jQuery.get('http://freegeoip.net/json/'+ip, function (response){
                    //alert(response.longitude);
                    lat = parseFloat(response.latitude);
                    long = parseFloat(response.longitude);
                    buildMap(lat,long);
                }, "jsonp");
        }

        $(document).ready(function() {
            navigator.geolocation.getCurrentPosition(showPosition);
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(hasGeolocation, noGeolocation)
            } else {
                getLocation();
            }

            function hasGeolocation(position) {
                var lat = position.coords.latitude;
              var lng = position.coords.longitude;
              $('.map-lat').val(lat);
              $('.map-lon').val(lng);
              buildMap(lat, lng);
            }

            function noGeolocation() {
                getLocation();
            }

            function geolocationNotSupported() {
                getLocation();
            }

            function showPosition(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                $('.map-lat').val(lat);
                $('.map-lon').val(lng);
                buildMap(lat, lng);
            }
        });
    </script>
@endsection

@section('scripts')
    <script src='http://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
    <script src="{{ asset('js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#datetimepicker1').datetimepicker();
            $('#datetimepicker2').datetimepicker();
            $(".js-example-basic-single").select2();
            $(".date-picker").datetimepicker();
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

        function checkTotalSeats()
        {
            /*var total = $("#total_seats").val();
            var temp = 0;
            $("input[id='seats_in_plan']").each(function() {
                if(total>$(this).val())
                {
                    alert("Seats Available cannot be greater than Total Available Seats");
                    self.focus();
                    return;
                }
            });*/
        }

        var total_seats = $('#total_seats').val();
        var sum = 0;
        $("input[id='seats_in_plan']").each(function() {
            sum = sum + parseInt($(this).val());
        });

        //Bootstarp validation on form
        $(document).ready(function() {
           
            $('#event-form').bootstrapValidator({
                // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    name: {
                        validators: {
                                stringLength: {
                                min: 2,
                            },
                            regexp: {
                                regexp: /^[a-zA-Z\s]+$/,
                                message: 'The Full name can only consist of alphabetical and space'
                            },
                                notEmpty: {
                                message: 'Please supply your full name'
                            }
                        }
                    },
                    keywords: {
                        validators: {
                            notEmpty: {
                                message: 'Please supply your business keywords'
                            }
                        }
                    },
                    description: {
                        validators: {
                            notEmpty: {
                                message: 'Please supply your Event Description'
                            }
                        }
                    },
                    start_date_time: {
                        validators: {
                            notEmpty: {
                                message: 'Please supply your Event Start Time'
                            },
                            date: {
                                format: 'MM/DD/YYYY h:m A',
                                message: 'The value is not a valid date'
                            }
                        }
                    },
                    end_date_time: {
                        validators: {
                            notEmpty: {
                                message: 'Please supply your Event End Time'
                            },
                            date: {
                                format: 'MM/DD/YYYY h:m A',
                                message: 'The value is not a valid date'
                            }
                        }
                    },
                    city: {
                        validators: {
                             stringLength: {
                                min: 4,
                            },
                            notEmpty: {
                                message: 'Please supply your city'
                            }
                        }
                    },
                    state: {
                        validators: {
                             stringLength: {
                                min: 4,
                            },
                            notEmpty: {
                                message: 'Please supply your state'
                            }
                        }
                    },
                    country: {
                        validators: {
                            notEmpty: {
                                message: 'Please supply your country'
                            }
                        }
                    },
                    pin_code: {
                        validators: {
                            notEmpty: {
                                message: 'Please supply your pin code'
                            }
                        }
                    },
                        PayDate: {
               validators: {
                 notEmpty: {
                   message: 'The Pay Date is required and cannot be empty'
                 },
                 date: {
                   format: 'MM/DD/YYYY',
                   message: 'The format is dd/mm/yyyy'
                 }
               }
             },
                }
            })
            .on('success.form.bv', function(e) {
                $('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
                    $('#register-form').data('bootstrapValidator').resetForm();

                // Prevent form submission
                e.preventDefault();

                // Get the form instance
                var $form = $(e.target);
                total_seats = $('#total_seats').val();
                sum = 0;
                $("input[id='seats_in_plan']").each(function() {
                    sum = sum + parseInt($(this).val());
                });

                // Get the BootstrapValidator instance
                var bv = $form.data('bootstrapValidator');

                // Use Ajax to submit form data
                $.post($form.attr('action'), $form.serialize(), function(result) {
                    console.log(result);
                }, 'json');
            });

             $('.date-picker').on('changeDate show', function(e) {
           $('#event-form').bootstrapValidator('revalidateField', 'PayDate');

        });
</script>
@endsection