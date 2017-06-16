@extends('layouts.app')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}"/>
@endsection
@section('content')
<div class="container row_pad">
    <div class="col-md-12">
    <div  class="row">
        <h5 class="text-left">Edit Event</h5>
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
            <form id="register-form" class="form-horizontal" action="{{ url('business-event/'.$event->id) }}" method="POST" enctype='multipart/form-data'>
                {{csrf_field()}}
                {{ method_field('PUT') }}
                <div class="form-group ">
                    <label for="category" class="col-md-2 required control-label">Category</label>
                    <div class="col-md-4">
                        <select required class="form-control" name="event_category_id" required>
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
                <div class="form-group">
                        <label for="address" class="col-md-2 control-label">Location:</label>
                        <div class="col-md-10">
                            <div id="map"></div>
                        </div>
                        <input type="hidden" id="latitude" class="form-control" name="latitude" value ="{{ old('latitude') }}">
                        <input type="hidden" id="longitude" class="form-control" name="longitude" value ="{{ old('longitude') }}">
                </div>
                <div class="form-group ">
                    <label for="address" class="col-md-2  control-label">Address</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="address" name="address" value="{{ $event->address }}" required >
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
                        <img src="{{asset('images/no-image.jpg')}}" alt=""  id="preview">
                    </div>
                </div>
                <fieldset>
                    <legend>Event Seating Plan</legend>
                </fieldset>
                <div class="form-group touchspin_input">
                    <label for="seating_plan" class="col-md-2 control-label">Total Number Of Seats</label>
                    <div class="col-md-4">
                        <div class="input-group input-group-sm">
                            <input type="text" value="{{$event->total_seats}}" name="total_seats" id="total_seats" class="form-control input-sm">
                        </div>
                    </div>
                </div>
                @if(count($seatingplans)>0)
                    @foreach($seatingplans as $seatingplan)
                        <div class="form-group">
                            <label class="col-md-2 control-label">{{ $seatingplan->title}}</label>
                            <div class="col-md-4 mg_botm" class="control-label">
                                <input type="text" class="form-control" name="seating_plan_alias[{{ $seatingplan->id }}]" value="{{ $seatingplan->getEventPlanAlias($event->id, $seatingplan->id) }}" placeholder="Seating Plan Alias">
                            </div>
                            <div class="col-md-3 mg_botm">
                                <div class="input-group input-group-sm">
                                    <input type="text" value="
                                    @if($seatingplan->getEventPlanSeats($event->id, $seatingplan->id))
                                    {{$seatingplan->getEventPlanSeats($event->id, $seatingplan->id) }}
                                    @endif
                                    " name="seating_plan[{{ $seatingplan->id }}]" id="seating_plan[{{ $seatingplan->id }}]" class="form-control input-sm seatingplan_touchspin">
                                </div>
                            </div>
                            <div class="col-md-3 mg_botm">
                                <input type="text" class="form-control seatingplan_price" name="seating_plan_price[{{ $seatingplan->id }}]" value="{{ $seatingplan->getEventPlanSeatsPrice($event->id, $seatingplan->id) }}">
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="form-group">
                    <div class="col-md-12 text-right">
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
@endsection
@section('header-scripts')
    <script type="text/javascript" src='https://maps.google.com/maps/api/js?key=AIzaSyDEOk91hx04o7INiXclhMwqQi54n2Zo0gU&libraries=places'></script>
    <script src="{{ asset('js/dist/locationpicker.jquery.js') }}"></script>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
    <script src="{{ asset('js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.bootstrap-touchspin.min.css') }}">
    <script src="{{ asset('js/jquery.bootstrap-touchspin.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">

        var lat;
        var long;
        var ip = "{{$ip}}";
        @if($event->latitude!="" and $event->latitude!="0.000000" and $event->longitude!="" and $event->longitude!="0.000000")
            $( document ).ready(function() {
                lat = parseFloat({{ $event->latitude }});
                long = parseFloat({{ $event->longitude }});
                buildMap(lat, long);
            });
        @else
            function getLocation()
            {
                jQuery.get('http://freegeoip.net/json/'+ip, function (response){
                        //alert(response.longitude);
                        lat = parseFloat(response.latitude);
                        long = parseFloat(response.longitude);
                        buildMap(lat,long);
                    }, "jsonp");
            }
            $( document ).ready(function() {
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
        @endif

        function buildMap(lat,long)
        {
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
        //GeoLocation Map Script(locationPicker with jquery)
        function updateControls(addressComponents) {
            $('#us5-street1').val(addressComponents.addressLine1);
            $('#city').val(addressComponents.city);
            $('#state').val(addressComponents.stateOrProvince);
            $('#pin_code').val(addressComponents.postalCode);
            $('#country').val(addressComponents.country);
        }
    </script>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('js/datepicker/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/datepicker/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/datepicker/bootstrap-datetimepicker.js') }}"></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
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
    
    $("#banner").change(function(){
        readURL(this);
    });
    //Bootstarp validation on form
        $(document).ready(function() {
            var min1 = $('#datetimepicker1').val();console.log('min',min1);
            var min2 = $('#datetimepicker2').val();console.log('min',min2);
            $('#datetimepicker1').datetimepicker({ defaultDate: ""+min1+"", });
            $('#datetimepicker2').datetimepicker({ defaultDate: ""+min2+"",  });
            $('#register-form').bootstrapValidator({
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
                    total_seats:
                    {
                        validators:{
                            callback: {
                                message: 'The sum of all the seats in seating plan must be equal to Total Seats',
                                callback: function(value, validator, $field) {
                                    var total = 0;
                                    $(".seatingplan_touchspin").each(function() {
                                        if($(this).val()!="")
                                        {
                                            total = total + parseInt($(this).val());
                                        }else
                                        {
                                            total = total + 0;
                                        }
                                    });
                                    if (total === parseInt($("#total_seats").val())) {
                                        /*validator.updateStatus(total_seats, 'VALID', 'callback');*/
                                        return true;
                                    }
                                    return false;
                                }
                            }
                        }
                    },
                    @if(count($seatingplans)>0)
                        @foreach($seatingplans as $seatingplan)
                            'seating_plan_price[{{$seatingplan->id}}]':{
                                validators: {
                                    notEmpty: {
                                        message: 'Please supply your Per Ticket Price'
                                    }
                                }
                            },
                        @endforeach
                    @endif
                }
            })
            .on('success.form.bv', function(e) {
                $('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
                    $('#register-form').data('bootstrapValidator').resetForm();

                // Prevent form submission
                e.preventDefault();

                // Get the form instance
                var $form = $(e.target);

                // Get the BootstrapValidator instance
                var bv = $form.data('bootstrapValidator');

                // Use Ajax to submit form data
                $.post($form.attr('action'), $form.serialize(), function(result) {
                    console.log(result);
                }, 'json');
            });
            $('#datetimepicker1').on('dp.change dp.show', function(e) {
                $('#register-form').bootstrapValidator('revalidateField', 'start_date_time');
            });
            $('#datetimepicker2').on('dp.change dp.show', function(e) {
                $('#register-form').bootstrapValidator('revalidateField', 'end_date_time');
            });
            var bootstrapValidator = $('#register-form').data('bootstrapValidator');
            bootstrapValidator.enableFieldValidators('total_seats', false);
            @if(count($seatingplans)>0)
                @foreach($seatingplans as $seatingplan)
                bootstrapValidator.enableFieldValidators('seating_plan_price[{{$seatingplan->id}}]', false);
                @endforeach
            @endif
            $("input[name='total_seats']").TouchSpin({
                postfix: "Seats",
                postfix_extraclass: "btn btn-default",
                min: 0,
                max: 5000,
                step: 1,
            }).on('change touchspin.on.min touchspin.on.max',function(e){
                if($(this).val()=="" || parseInt($(this).val())==0)
                {
                    $('input[name^="seating_plan"]').each(function(i){
                       var input = $(this).attr("name");
                       if(!(input.indexOf('seating_plan_alias[')>-1))
                       {
                            $('input[name="'+input+'"]').val("");
                       }
                       $('input[name="'+input+'"]').attr('readonly','readonly');
                       $('i[data-bv-icon-for="'+input+'"]').css('display', 'none');
                       $('small[data-bv-validator-for="'+input+'"]').css('display', 'none');
                       $('input[name="'+input+'"]').closest( 'div[class^="form-group"]' ).removeClass('has-error');
                       $('input[name="'+input+'"]').closest( 'div[class^="form-group"]' ).removeClass('has-success');

                    });
                    bootstrapValidator.enableFieldValidators('total_seats', false);
                }else
                {
                    $('input[name^="seating_plan"]').each(function(i){
                       var input = $(this).attr("name");
                       if(!(input.indexOf('seating_plan_price[')>-1))
                       {
                            $('input[name="'+input+'"]').removeAttr('readonly');
                       }
                    });
                    bootstrapValidator.enableFieldValidators('total_seats', true);
                }
                $('#register-form').bootstrapValidator('validateField', 'total_seats');
            }).end();
            $(".seatingplan_touchspin").TouchSpin({
                postfix: "Seats",
                postfix_extraclass: "btn btn-default",
                min: 0,
                max: 5000,
                step: 1,
            }).on('change touchspin.on.min touchspin.on.max', function(e) {
                var name = $(this).parent().parent().parent().find('.seatingplan_price').attr('name');
                if($(this).val()!="" && parseInt($(this).val())!==0)
                {
                    $('input[name="'+name+'"]').removeAttr('readonly');
                    bootstrapValidator.enableFieldValidators(name, true);
                }else
                {
                    $('input[name="'+name+'"]').val("");
                    $('input[name="'+name+'"]').attr('readonly','readonly');
                    bootstrapValidator.enableFieldValidators(name, false);
                }
                bootstrapValidator.enableFieldValidators('total_seats', true);
            }).end();

            if($('input[name="total_seats"]').val()=="" || parseInt($('input[name="total_seats"]').val())==0)
            {
                $('input[name^="seating_plan"]').each(function(i){
                   var input = $(this).attr("name");
                   if(!(input.indexOf('seating_plan_alias[')>-1))
                   {
                        $('input[name="'+input+'"]').val("");
                   }
                   $('input[name="'+input+'"]').attr('readonly','readonly');
                   $('i[data-bv-icon-for="'+input+'"]').css('display', 'none');
                   $('small[data-bv-validator-for="'+input+'"]').css('display', 'none');
                   $('input[name="'+input+'"]').closest( 'div[class^="form-group"]' ).removeClass('has-error');
                   $('input[name="'+input+'"]').closest( 'div[class^="form-group"]' ).removeClass('has-success');

                });
                bootstrapValidator.enableFieldValidators('total_seats', false);
            }else
            {
                $('input[name^="seating_plan"]').each(function(i){
                   var input = $(this).attr("name");
                   if(!(input.indexOf('seating_plan_price[')>-1))
                   {
                        $('input[name="'+input+'"]').removeAttr('readonly');
                   }
                });
                bootstrapValidator.enableFieldValidators('total_seats', true);
            }
            $('#register-form').bootstrapValidator('validateField', 'total_seats');
            $(".seatingplan_touchspin").each(function() {
                var name = $(this).parent().parent().parent().find('.seatingplan_price').attr('name');
                if($(this).val()!="" && parseInt($(this).val())!==0)
                {
                    $('input[name="'+name+'"]').removeAttr('readonly');
                    bootstrapValidator.enableFieldValidators(name, true);
                }else
                {
                    $('input[name="'+name+'"]').val("");
                    $('input[name="'+name+'"]').attr('readonly','readonly');
                    bootstrapValidator.enableFieldValidators(name, false);
                }
                bootstrapValidator.enableFieldValidators('total_seats', true);
            });
        });
</script>
<style>
#register-form .touchspin_input .form-control-feedback {
    right: -15px;
}
</style>
@endsection