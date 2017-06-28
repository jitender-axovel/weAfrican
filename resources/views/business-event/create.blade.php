@extends('layouts.app')
@section('title', $pageTitle)
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}"/>
@endsection
@section('content')
<div class="container row_pad">
    <div class="col-md-12">
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
            <form id="register-form" class="form-horizontal" action="{{ url('business-event') }}" method="POST" enctype='multipart/form-data'>
                {{csrf_field()}}
                <div class="col-md-12">
                 <div class="row">
                    <label class="col-md-2 control-label required">Select Category:</label>
                    <div class="col-md-4 form-group">
                        <select required name="event_category_id" class="form-control" required>
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
                    <label class="col-md-2 required control-label required"> Name of Event</label>
                    <div class="col-md-4 form-group">
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        @if($errors->has('name'))
                            <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 required control-label">Event Keywords</label>
                    <div class="col-md-4 form-group">
                        <input type="text" class="form-control" name="keywords" value="{{ old('keywords') }}" required>
                        @if($errors->has('keywords'))
                            <span class="help-block">
                            <strong>{{ $errors->first('keywords') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label class="col-md-2 required control-label">Organizer Name</label>
                    <div class="col-md-4 form-group">
                        <input type="text" class="form-control" name="organizer_name" value="{{ $business->title or old('organizer_name')}}" required>
                        @if($errors->has('organizer_name'))
                            <span class="help-block">
                            <strong>{{ $errors->first('organizer_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 required control-label">Description</label>
                    <div class="col-md-10 form-group">
                        <textarea required class="form-control" name="description"></textarea>
                        @if($errors->has('description'))
                            <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                </div>
                <div class="row">
                    <label class="col-md-2 required control-label">Event Start Date</label>
                    <div class="col-md-4 form-group">
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
                    <label class="col-md-2 required control-label">Event End Date</label>
                    <div class="col-md-4 form-group">
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
                        <div class="row">
                            <div id="map"></div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="latitude" class="form-control" name="latitude" value ="{{ old('latitude') }}">
                    <input type="hidden" id="longitude" class="form-control" name="longitude" value ="{{ old('longitude') }}">
                 <div class="row">
                    <label class="col-md-2 required control-label">Address</label>
                    <div class="col-md-4 form-group">
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address')}}" required>
                        @if($errors->has('address'))
                            <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label class="col-md-2 control-label required">City:</label>
                        <div class="col-md-4 form-group ">
                            <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}">
                            @if ($errors->has('city'))
                                <span class="help-block">
                                <strong>{{ $errors->first('city') }}</strong>
                                </span>
                            @endif
                        </div>
                </div>
                  <div class="row">
                        <label class="col-md-2 required control-label">State:</label>
                        <div class="col-md-4 form-group">
                            <input type="text" class="form-control" id="state" name="state" value="{{ old('state') }}">
                            @if ($errors->has('state'))
                                <span class="help-block">
                                <strong>{{ $errors->first('state') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label class="col-md-2 control-label required">Country:</label>
                        <div class="col-md-4 form-group">
                            <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}">
                            @if ($errors->has('country'))
                                <span class="help-block">
                                <strong>{{ $errors->first('country') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                      <div class="row">
                        <label class="col-md-2 required control-label">Pin Code: (format:110075)</label>
                        <div class="col-md-4 form-group">
                            <input required type="text" pattern="[0-9]{6}" id="pin_code" class="form-control" name="pin_code" value="{{ old('pin_code') }}">
                            @if ($errors->has('pin_code'))
                                <span class="help-block">
                                <strong>{{ $errors->first('pin_code') }}</strong>
                                </span>
                            @endif
                        </div>
                        </div>
                 <div class="row">
                    <label class="col-md-2 required control-label">Banner Image</label>
                    <div class="col-md-4 form-group ">
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
                </fieldset></div>
                <div class="col-md-12">
                <div class="form-group touchspin_input">
                    <label class="col-md-2 control-label">Total Number Of Seats</label>
                    <div class="col-md-4">
                        <div class="input-group input-group-sm">
                            <input type="text" value="" name="total_seats" id="total_seats" class="form-control input-sm">
                        </div>
                    </div>
                </div>
                </div>
                <div class="col-md-12">
                @if(count($seatingplans)>0)
                    @foreach($seatingplans as $seatingplan)
                        <div class="form-group colm_margin">
                            <div class="col-md-2">
                                <div class="checkbox">
                                  <label class="control-label"><input type="checkbox" id="seating_plan_id_{{$seatingplan->id}}" disabled="disabled" value="">{{ $seatingplan->title }}</label>
                                </div>
                            </div>
                            <div class="col-md-3" class="control-label">
                                <input type="text" class="form-control" name="seating_plan_alias[{{ $seatingplan->id }}]" disabled="disabled" value="{{ $seatingplan->title }}" placeholder="Seating Plan Alias">
                            </div>
                            <div class="col-md-3">
                                <div class="input-group input-group-sm">
                                    <input type="text" disabled="disabled" value="" name="seating_plan[{{ $seatingplan->id }}]" id="seating_plan[{{ $seatingplan->id }}]" class="form-control input-sm seatingplan_touchspin">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input type="text" disabled="disabled" class="form-control seatingplan_price" name="seating_plan_price[{{ $seatingplan->id }}]" placeholder="Per Ticket Price">
                            </div>
                        </div>
                    @endforeach
                @endif
                </div>
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
    //Bootstarp validation on form
        $(document).ready(function() {
            $('#datetimepicker1').datetimepicker({ minDate: new Date() });
            $('#datetimepicker2').datetimepicker({ minDate: new Date() });
            $('#datetimepicker1').on('dp.change dp.show', function(e) {
                $('#register-form').bootstrapValidator('revalidateField', 'start_date_time');
            });
            $('#datetimepicker2').on('dp.change dp.show', function(e) {
                $('#register-form').bootstrapValidator('revalidateField', 'end_date_time');
            });
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
                            'seating_plan_alias[{{$seatingplan->id}}]':{
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
                    $('input[id^="seating_plan_id_"]').each(function(i){
                        $(this).removeAttr('checked');
                        var input = $(this).attr("id");
                        $('input[id="'+input+'"]').attr('disabled','disabled');
                    });
/*                    $('input[name^="seating_plan"]').each(function(i){
                       var input = $(this).attr("name");
                       if(!(input.indexOf('seating_plan_alias[')>-1))
                       {
                            $('input[name="'+input+'"]').val("");
                       }
                       $('input[name="'+input+'"]').attr('disabled','disabled');
                       $('i[data-bv-icon-for="'+input+'"]').css('display', 'none');
                       $('small[data-bv-validator-for="'+input+'"]').css('display', 'none');
                       $('input[name="'+input+'"]').closest( 'div[class^="form-group"]' ).removeClass('has-error');
                       $('input[name="'+input+'"]').closest( 'div[class^="form-group"]' ).removeClass('has-success');

                    });*/
                    bootstrapValidator.enableFieldValidators('total_seats', false);
                }else
                {
                    $('input[id^="seating_plan_id_"]').each(function(i){
                        var input = $(this).attr("id");
                        if(!(input.indexOf('seating_plan_price[')>-1))
                        {
                            $('input[id="'+input+'"]').removeAttr('disabled');
                        }
                    });
                    /*$('input[name^="seating_plan"]').each(function(i){
                       var input = $(this).attr("name");
                       if(!(input.indexOf('seating_plan_price[')>-1))
                       {
                            $('input[name="'+input+'"]').removeAttr('disabled');
                       }
                    });*/
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
                var row  = $(this).parents('.form-group');
                var name = $(this).parent().parent().parent().find('.seatingplan_price').attr('name');
                if($(this).val()!="" && parseInt($(this).val())!==0)
                {
                    $('input[name="'+name+'"]').removeAttr('disabled');
                    bootstrapValidator.enableFieldValidators(name, true);
                }else
                {
                    $('input[name="'+name+'"]').val("");
                    $('input[name="'+name+'"]').attr('disabled','disabled');
                    bootstrapValidator.enableFieldValidators(name, false);
                }
                bootstrapValidator.enableFieldValidators('total_seats', true);
            }).end();
        
            $('input[id^="seating_plan_id_"]').click(function(e){
                if($(this).is(':checked'))
                {
                    $(this).closest('div[class^="form-group"]').find('input[name^="seating_plan_alias"]').removeAttr('disabled');
                    $(this).closest('div[class^="form-group"]').find('input[name^="seating_plan["]').removeAttr('disabled');
                    /*$('input[name^="seating_plan"]').each(function(i){
                       var input = $(this).attr("name");
                       if(!(input.indexOf('seating_plan_price[')>-1))
                       {
                            $('input[name="'+input+'"]').removeAttr('disabled');
                       }
                    });*/
                    bootstrapValidator.enableFieldValidators('total_seats', true);
                }else
                {
                    $(this).closest('div[class^="form-group"]').find('input[name^="seating_plan["]').val('');
                    $(this).closest('div[class^="form-group"]').find('input[name^="seating_plan_price["]').val('');
                    $(this).closest('div[class^="form-group"]').find('input[name^="seating_plan"]').attr('disabled','disabled');
                    /*$(this).closest('i[data-bv-icon-for^="seating_plan_price["]').css('display', 'none');
                    $(this).closest('small[data-bv-validator-for^="seating_plan_price["]').css('display', 'none');
                    $(this).closest('input[name="seating_plan_price["]').closest( 'div[class^="form-group"]' ).removeClass('has-error');*/
                    $(this).closest( 'div[class^="form-group"]' ).removeClass('has-success');
                    $(this).closest( 'div[class^="form-group"]' ).removeClass('has-error');
                    $(this).closest( 'div[class^="form-group"]' ).find('i[data-bv-icon-for^="seating_plan_price["]').css('display', 'none');
                    $(this).closest( 'div[class^="form-group"]' ).find('small[data-bv-validator-for^="seating_plan_price["]').css('display', 'none');
                    bootstrapValidator.enableFieldValidators('total_seats', true);
                }
            });
        });
</script>
<style>
#register-form .touchspin_input .form-control-feedback {
    right: -15px;
}
</style>
@endsection
