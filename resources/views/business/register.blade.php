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
                <form id="register-form" class="form-horizontal" role="form" method="POST" action="{{ url('/register-business') }}" enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    
                    <div class="form-group required">
                        <label for="name" class="col-md-2 control-label">Full Name:</label>
                        <div class="col-md-1">
                            <select name="salutation" id="salutation" class="form-control selectpicker" required style="padding-right:0px;">
                                <option value="Mr">Mr.</option>
                                <option value="Ms">Ms.</option>
                                <option value="Mrs">Mrs.</option>
                            </select>
                            @if ($errors->has('salutation'))
                                <span class="help-block">
                                <strong>{{ $errors->first('salutation') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <input required type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" autofocus placeholder="First Name">
                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="middle_name" value="{{ old('middle_name') }}" autofocus placeholder="Middle Name">
                            @if ($errors->has('middle_name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('middle_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <input required type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" autofocus placeholder="Last Name">
                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="gender" class="col-md-2 control-label">Gender:</label>
                        <div class="col-md-4">
                            <div class="col-md-5">
                            <input required type="radio" class="" name="gender"
                            @if(old('gender')!='female')
                                checked="checked"
                            @endif
                            value="male">&nbsp;<label>Male</label>
                            </div>
                            <div class="col-md-4">
                            <input required type="radio" class="" name="gender" 
                            @if(old('gender')=='female')
                                checked="checked"
                            @endif 
                            value="female">&nbsp;<label>Female</label>
                            </div>
                            @if ($errors->has('gender'))
                                <span class="help-block">
                                <strong>{{ $errors->first('gender') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category" class="col-md-2 control-label required">Category:</label>
                        <div class="col-md-4">
                            <select name="bussiness_category_id" id="bussiness_category_id" class="form-control selectpicker" required>
                                <option value="" selected>Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('bussiness_category_id'))
                                <span class="help-block">
                                <strong>{{ $errors->first('bussiness_category_id') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div id="subcategory" style="display: none;">
                            <label for="subcategory" class="col-md-2 control-label required">Sub Category:</label>
                            <div class="col-md-4">
                                <select name="bussiness_subcategory_id" id="bussiness_subcategory_id" class="form-control selectpicker">
                                    <option value="" selected>Select Sub Category</option>
                                </select>
                                @if ($errors->has('bussiness_subcategory_id'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('bussiness_subcategory_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="address" class="col-md-2 control-label">Location:</label>
                        <div class="col-md-10">
                            <div id="map"></div>
                        </div>
                    </div>

                    <input type="hidden" id="latitude" class="form-control" name="latitude" value ="{{ old('latitude') }}">
                    <input type="hidden" id="longitude" class="form-control" name="longitude" value ="{{ old('longitude') }}">

                    <div class="form-group ">
                        <label for="address" class="col-md-2 control-label required">Address:</label>
                        <div class="col-md-4">
                            <input type="text" id="address" class="form-control" name="address" value="{{ old('address') }}">
                            @if ($errors->has('address'))
                                <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>

                        <label for="city" class="col-md-2 control-label required">City:</label>
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
                        <label for="state" class="col-md-2 control-label required">State:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="state" name="state" value="{{ old('state') }}">
                            @if ($errors->has('state'))
                                <span class="help-block">
                                <strong>{{ $errors->first('state') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="country" class="col-md-2 control-label required">Country:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}" >
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
                            <input required type="text" pattern="[0-9]{6}" id="pin_code" class="form-control" name="pin_code" value="{{ old('pin_code') }}">
                            @if ($errors->has('pin_code'))
                                <span class="help-block">
                                <strong>{{ $errors->first('pin_code') }}</strong>
                                </span>
                            @endif
                        </div>

                        <label for="mobile_number" class="col-md-2 required control-label">Mobile Number:(format:99-99-999999)</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control code" id="country_code" name="country_code" value="{{ old('country_code') }}" />

                            <input  type="text" maxlength="10" minlength="10" pattern="[0-9]{10}" class="form-control mobile" name="mobile_number" value="{{ old('mobile_number') }}" required>
                              <span class="help-block">
                                <strong>Please enter mobile no. with country code</strong>
                            </span>
                            @if ($errors->has('mobile_number'))
                                <span class="help-block">
                                <strong>{{ $errors->first('mobile_number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="about_us" class="col-md-2 control-label">Currency</label>
                        <div class="col-md-4">
                            <input type="text" maxlength="5" id="currency" class="form-control" name="currency" value="{{ old('currency') }}" required>
                            @if ($errors->has('currency'))
                                <span class="help-block">
                                <strong>{{ $errors->first('currency') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <legend>Business Information</legend>
                    </div>
                    <div class="form-group">
                        <label for="title" id="business_title_lable" class="col-md-2 control-label required">Business Name:</label>
                        <div class="col-md-4">
                            <input required type="text" class="form-control" name="title" id="business_title" value="{{ old('title') }}">
                            @if ($errors->has('title'))
                                <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="keywords" id="business_keyword_lable" class="col-md-2 required control-label">Business Keywords:</label>
                        <div class="col-md-4" data-tip="Please use as many of keywords , this will help user to find your business during search more visiblility in search result more customer.">
                            <input required type="text" class="form-control" id="business_keywords" name="keywords" placeholder="Ex. Software developer, Gas Supplier , Baby Cloths, Electronics" value="{{ old('keywords') }}">
                            @if ($errors->has('keywords'))
                                <span class="help-block">
                                <strong>{{ $errors->first('keywords') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="website" class="col-md-2 control-label{{ $errors->has('website') ? ' has-error' : '' }}"">Website:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="website" value="{{ old('website') }}">
                            @if ($errors->has('website'))
                                <span class="help-block">
                                <strong>{{ $errors->first('website') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="about_us" id="about_us_lable" class="col-md-2 control-label">About us:</label>
                        <div class="col-md-4">
                            <textarea class="form-control" name="about_us" rows="11" ></textarea>
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
                            <textarea class="form-control" name="working_hours" id="working_hours" rows="8" readonly="readonly" onclick="javascript:$('#working_hours_modal').modal('show')" >
MON  :   10:00 AM to 06:00 PM
TUE  :   10:00 AM to 06:00 PM
WED  :   10:00 AM to 06:00 PM
THU  :   10:00 AM to 06:00 PM
FRI  :   10:00 AM to 06:00 PM
SAT  :   Closed
SUN  :   Closed
</textarea>
                            <br><!-- Trigger the modal with a button -->
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#working_hours_modal" onclick="javascript:checkWorkingHours();">Add Working Hours</button>
                            @if ($errors->has('working_hours'))
                                <span class="help-block">
                                <strong>{{ $errors->first('working_hours') }}</strong>
                                </span>
                            @endif
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="business_logo" id="business_logo_lable" class="col-md-2 control-label">Business Logo:</label>
                        <div class="col-md-4">
                            <input type="file" name="business_logo" id="business_logo" accept="image/jpg,image/jpeg,image/png" />
                            @if ($errors->has('business_logo'))
                                <span class="help-block">
                                <strong>{{ $errors->first('business_logo') }}</strong>
                                </span>
                            @endif
                        </div>

                        <label for="logo_preview" class="col-md-2 control-label">
                        Preview:
                        </label>
                        <div class="col-md-4">
                            <img src="{{asset('images/no-image.jpg')}}" alt=""  id="preview">
                        </div>
                    </div>
                    <div id="entertaintment" style="display: none">
                        <div>
                            <legend>Entertaintment Information</legend>
                        </div>
                    </div>
                    <div id="skilled_professional" style="display: none">
                        <div>
                            <legend>Skilled Professional Information</legend>
                        </div>
                    </div>
                    <div id="common" style="display: none">
                        <div class="form-group">
                            <label for="maritial_status" class="col-md-2 control-label required">Maritial Status:</label>
                            <div class="col-md-4">
                                <select name="maritial_status" id="maritial_status" class="form-control selectpicker">
                                   <option value="">Select One</option>
                                   <option value="married">Married</option>
                                   <option value="single">Single</option>
                                   <option value="divorced">Divorced</option>
                                </select>
                                @if ($errors->has('maritial_status'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('maritial_status') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <label for="occupation" class="col-md-2 control-label required">Occupation:</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="occupation" id="occupation">
                                @if ($errors->has('occupation'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('occupation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="acadmic" class="col-md-2 control-label">Academic Status:</label>
                            <div class="col-md-4">
                                <select name="academic" id="academic" class="form-control selectpicker">
                                   <option value="">Select One</option>
                                   <option value="10">10</option>
                                   <option value="10+2">10+2</option>
                                   <option value="Graduate">Graduate</option>
                                   <option value="Post Graduate">Post Graduate</option>
                                   <option value="Diploma">Diploma</option>
                                </select>
                                @if ($errors->has('academic'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('academic') }}</strong>
                                    </span>
                                @endif
                            </div>
                        
                            <label for="key_skills" class="col-md-2 control-label required">Key Skills:</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="key_skills" id="key_skills">
                                @if ($errors->has('key_skills'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('key_skills') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div>
                        <legend>Login Information</legend>
                    </div>

                     <div class="form-group ">
                        <label for="email" class="col-md-2 control-label required">Email:</label>
                        <div class="col-md-4">
                            <input required type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" class="form-control" name="email" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-md-2 control-label required">Password:</label>
                        <div class="col-md-4">
                            <input required type="password" class="form-control" name="password" value="">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <label for="confirm_password" class="col-md-2 control-label required">Confirm Password:</label>
                        <div class="col-md-4">
                            <input required type="password" class="form-control" name="confirm_password" value="">
                            @if ($errors->has('confirm_password'))
                                <span class="help-block">
                                <strong>{{ $errors->first('confirm_password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="checkbox" class="col-md-2 control-label required">Security Question</label>
                        <div class="col-md-10">
                            <select name="security_question_id" id="security_question_id" class="form-control selectpicker" required="required">
                                <option value="">Select Security Question</option>
                                @foreach($securityquestions as $securityquestion)
                                    <option value="{{ $securityquestion->id }}"
                                    @if(old('security_question_id')==$securityquestion->id)
                                        selected="selected"
                                    @endif
                                    >{{ $securityquestion->question }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('security_question_id'))
                                <span class="help-block">
                                <strong>{{ $errors->first('security_question_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="checkbox" class="col-md-2 control-label required">Answer</label>
                        <div class="col-md-4">
                            <input required type="text" class="form-control" name="security_question_ans" id="security_question_ans" value="{{ old('security_question_ans') }}">
                            @if ($errors->has('security_question_ans'))
                                <span class="help-block">
                                <strong>{{ $errors->first('security_question_ans') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="checkbox" class="col-md-2 control-label"></label>
                        <div class="col-md-10">
                            <input name="is_agree_to_terms" value="" type="checkbox" required> I hereby declare, that I have read and accepted the <a href="" data-toggle="modal" data-target="#myModal">Terms &amp; Conditions.</a>
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
                <h5 class="modal-title">Terms & Conditions</h5>
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

@include('sections.business_hours');
@endsection
@section('header-scripts')
    <script type="text/javascript" src='https://maps.google.com/maps/api/js?key=AIzaSyDEOk91hx04o7INiXclhMwqQi54n2Zo0gU&libraries=places'></script>
    <script src="{{ asset('js/dist/locationpicker.jquery.js') }}"></script>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
    <script src="{{ asset('js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
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
                getCurrencyAndCode();
            },
            oninitialized: function (component) {
                var addressComponents = $(component).locationpicker('map').location.addressComponents;
                updateControls(addressComponents);
            }
        });
    }

    //Bootstarp validation on form
    $(document).ready(function() {
        $('#register-form').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                    full_name: {
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
                    title: {
                        validators: {
                            stringLength: {
                                min: 2,
                                max:20
                            },
                            notEmpty: {
                                message: 'Please supply your business name'
                            }
                        }
                    },
                    bussiness_category_id: {
                        validators: {
                            notEmpty: {
                                message: 'Please select your category'
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
                    address: {
                        validators: {
                             stringLength: {
                                min: 8,
                            },
                            notEmpty: {
                                message: 'Please supply your address'
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
                    country_code: {
                        validators: {
                            numeric: {
                                message: 'The country code can consist only numbers.'
                            },
                            notEmpty: {
                                message: 'Please supply country code.'
                            }
                        }
                    },
                    mobile_number: {
                        validators: {
                            numeric: {
                                message: 'The mobile number can consist only numbers.'
                            },
                            notEmpty: {
                                message: 'Please supply mobile number.'
                            }
                        }
                    }, 
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Please supply your email address'
                            },
                            emailAddress: {
                                message: 'Please supply a valid email address'
                            }
                        }
                    },                  
                    password: {
                        validators: {
                            identical: {
                                field: 'confirm_password',
                                message: 'Confirm your password below - type same password please'
                            }
                        }
                    },
                    confirm_password: {
                        validators: {
                            identical: {
                                field: 'password',
                                message: 'The password and its confirm are not the same'
                            }
                        }
                    },
                    maritial_status: {
                        validators: {
                            notEmpty: {
                                message: 'Please select your maritial status'
                            }
                        }
                    },
                    key_skills: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter your key skills'
                            }
                        }
                    },
                    academic: {
                        validators: {
                            notEmpty: {
                                message: 'Please select your Academic Status'
                            }
                        }
                    },
                    occupation: {
                        validators: {
                            notEmpty: {
                                message: 'Please supply your occupation'
                            }
                        }
                    },
                    security_question_id: {
                        validators: {
                            notEmpty: {
                                message: 'Please select your Security Question'
                            }
                        }
                    },
                    security_question_ans: {
                        validators: {
                            notEmpty: {
                                message: 'Please supply your Security Question Answer'
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

                // Get the BootstrapValidator instance
                var bv = $form.data('bootstrapValidator');

                // Use Ajax to submit form data
                $.post($form.attr('action'), $form.serialize(), function(result) {
                    console.log(result);
                }, 'json');
            });
        });
    function checkWorkingHours()
    {  

        var days = new Array();

        days[0] = document.querySelector('input[name="option_day[0]"]:checked').value;
        days[1] = document.querySelector('input[name="option_day[1]"]:checked').value;
        days[2] = document.querySelector('input[name="option_day[2]"]:checked').value;
        days[3] = document.querySelector('input[name="option_day[3]"]:checked').value;
        days[4] = document.querySelector('input[name="option_day[4]"]:checked').value;
        days[5] = document.querySelector('input[name="option_day[5]"]:checked').value;
        days[6] = document.querySelector('input[name="option_day[6]"]:checked').value;

        for(var i=0;i<days.length;i++)
        {
            if(days[i]!=0)
            {
                document.getElementById("open_"+i).setAttribute('disabled', true);
                document.getElementById("close_"+i).setAttribute('disabled', true);
            }else
            {
                document.getElementById("open_"+i).removeAttribute('disabled');
                document.getElementById("close_"+i).removeAttribute('disabled');
            }
        }
    }
    $(document).ready(function() {
        $('input[type=radio][class=opt_day]').change(function() {
            checkWorkingHours();
        });
        $('#modal_submit').click(function() {

            var days = new Array();

            days[0] = document.querySelector('input[name="option_day[0]"]:checked').value;
            days[1] = document.querySelector('input[name="option_day[1]"]:checked').value;
            days[2] = document.querySelector('input[name="option_day[2]"]:checked').value;
            days[3] = document.querySelector('input[name="option_day[3]"]:checked').value;
            days[4] = document.querySelector('input[name="option_day[4]"]:checked').value;
            days[5] = document.querySelector('input[name="option_day[5]"]:checked').value;
            days[6] = document.querySelector('input[name="option_day[6]"]:checked').value;
            var text = "";
            for(var i=0;i<days.length;i++)
            {
                if(i==0)
                {
                    text = text + "MON  :   ";
                }else if(i==1)
                {
                    text = text + "TUE  :   ";
                }else if(i==2)
                {
                    text = text + "WED  :   ";
                }else if(i==3)
                {
                    text = text + "THU  :   ";
                }else if(i==4)
                {
                    text = text + "FRI  :   ";
                }else if(i==5)
                {
                    text = text + "SAT  :   ";
                }else if(i==6)
                {
                    text = text + "SUN  :   ";
                }
                if(days[i]==0)
                {
                    text = text + convertTime($('#open_'+i).val()) + " to " + convertTime($('#close_'+i).val());
                }else if(days[i]==1)
                {
                    text = text + "Closed";
                }else if(days[i]==2)
                {
                    text = text + "24 Hours Open";
                }
                text = text + "\n";
            }
            //alert(text);
            $("#working_hours").val(text);
            $('#working_hours_modal').modal('hide');
        });
    });
    function convertTime(str)
    {
        var temp = str.split(":");
        temp[0] = parseInt(temp[0]);
        if(temp[0]<10)
        {
            temp[0] = "0" + temp[0];
        }
        return temp.join(":");
    }
</script>
<script type="text/javascript">
    $(function () {
        $('.date').datetimepicker({
            format: 'LT'
        });
    });
</script>
<script type="text/javascript">
    setTimeout(function () {
      getCurrencyAndCode();
    }, 3000);
    window.onload = getCurrencyAndCode();
    $("#country").change(function(){
        getCurrencyAndCode();
    });
    function getCurrencyAndCode()
    {
        $.ajax({
            type: "POST",
            url: '{{ url("country-details") }}',
            data: {
                _token: "{{ csrf_token() }}",
                country : $("#country").val(),
            },success:function(response){
                if(response!="")
                {
                    var result = JSON.parse(response);
                    $("#country_code").val(result.country_code);
                    $("#currency").val(result.currency);
                }else
                {
                     $("#currency").val("USD");
                     $("#country_code").val("");
                }
            }
        });
    }
    $('#bussiness_category_id').on('change', function() {
        if(this.value!=""){
            $.ajax({
                type:'POST',
                url: '{{ url("subcategory") }}',
                data:{
                    _token: "{{ csrf_token() }}",
                    user_role : 3,
                    category : this.value,
                },success:function(response)
                {
                    $('#bussiness_subcategory_id').find('option').not(':first').remove();
                    $('#subcategory').show();
                    $('#bussiness_subcategory_id').attr('required', false);
                    var subcategory = JSON.parse(response);
                    if(Object.keys(subcategory).length>0)
                    {
                        for(key in subcategory){
                            $('#bussiness_subcategory_id').append($("<option></option>").attr("value",key).text(subcategory[key]));
                        }
                        $('#subcategory').show();
                        $('#bussiness_subcategory_id').attr('required', true);
                    }else
                    {
                        $('#subcategory').hide();
                    }
                }
            });
            var selected = $('#bussiness_category_id option:selected').html();
            var bootstrapValidator = $('#register-form').data('bootstrapValidator');
            if(selected=='Entertainment')
            {
                $('#entertaintment').show();
                $('#skilled_professional').hide();
                $('#business_logo_lable').text("Profile Pic :");
                $('#about_us_lable').text("Description :");
                $('#business_title_lable').removeClass("required");
                $('#business_title').attr('required', false);
                /*$('#business_keyword_lable').removeClass("required");
                $('#business_keywords').attr('required', false);*/
                $('#common').show();
                $('#maritial_status').attr('required', true);
                $('#occupation').attr('required', true);
                $('#key_skills').attr('required', true);
                $('#occupation_skill').attr('required', false);
                $('#key_skills_skill').attr('required', false);
                bootstrapValidator.enableFieldValidators('title', false);
                /*bootstrapValidator.enableFieldValidators('keywords', false);*/
            }else if(selected=='Skilled Professional')
            {
                $('#skilled_professional').show();
                $('#business_logo_lable').text("Profile Pic :");
                $('#about_us_lable').text("Description :");
                $('#business_title_lable').removeClass("required");
                $('#business_title').attr('required', false);
                /*$('#business_keyword_lable').removeClass("required");
                $('#business_keywords').attr('required', false);*/
                $('#entertaintment').hide();
                $('#common').show();
                $('#maritial_status').attr('required', false);
                $('#occupation').attr('required', false);
                $('#key_skills').attr('required', false);
                $('#occupation_skill').attr('required', true);
                $('#key_skills_skill').attr('required', true);
                bootstrapValidator.enableFieldValidators('title', false);
                /*bootstrapValidator.enableFieldValidators('keywords', false);*/
            }else
            {
                $('#skilled_professional').hide();
                $('#business_logo_lable').text("Business Logo :");
                $('#about_us_lable').text("About us :");
                $('#business_title_lable').addClass("required");
                $('#business_title').attr('required', true);
                /*$('#business_keyword_lable').addClass("required");
                $('#business_keywords').attr('required', true);*/
                $('#entertaintment').hide();
                $('#common').hide();
                $('#maritial_status').attr('required', false);
                $('#occupation').attr('required', false);
                $('#key_skills').attr('required', false);
                $('#occupation_skill').attr('required', false);
                $('#key_skills_skill').attr('required', false);
                bootstrapValidator.enableFieldValidators('title', true);
                /*bootstrapValidator.enableFieldValidators('keywords', true);*/
            }
        }else
        {
            $('#bussiness_subcategory_id').find('option').not(':first').remove();
            $('#bussiness_subcategory_id').attr('required', false);
            $('#subcategory').hide();
        }
    });
</script>
@endsection


