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
                    <!-- <input type="hidden" name="currency" id="currency" value=""> -->
                    <input type="hidden" name="working_hours" id="working_hours" value="MON  :   10:00 AM to 06:00 PM
TUE  :   10:00 AM to 06:00 PM
WED  :   10:00 AM to 06:00 PM
THU  :   10:00 AM to 06:00 PM
FRI  :   10:00 AM to 06:00 PM
SAT  :   Closed
SUN  :   Closed">
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
                            <select name="bussiness_category_id" class="form-control selectpicker" required>
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
                    <div class="form-group ">
                        <label for="keywords" class="col-md-2 required control-label">Business Keywords:</label>
                        <div class="col-md-4" data-tip="Please use as many of keywords , this will help user to find your business during search more visiblility in search result more customer.">
                            <input required type="text" class="form-control" name="keywords" placeholder="Ex. Software developer, Gas Supplier , Baby Cloths, Electronics" value="{{ old('keywords') }}">
                            @if ($errors->has('keywords'))
                                <span class="help-block">
                                <strong>{{ $errors->first('keywords') }}</strong>
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
                    <div class="form-group col-md-12">
                        <label for="address" class="col-md-2 control-label">Location:</label>
                        <div id="map"></div>
                    </div>
                    <input type="hidden" id="latitude" class="form-control" name="latitude" value ="{{ old('latitude') }}">
                    <input type="hidden" id="longitude" class="form-control" name="longitude" value ="{{ old('longitude') }}">
                    <div class="form-group required">
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
                    <div class="form-group required">
                        <label for="state" class="col-md-2 control-label">State:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="state" name="state" value="{{ old('state') }}">
                            @if ($errors->has('state'))
                                <span class="help-block">
                                <strong>{{ $errors->first('state') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="country" class="col-md-2 control-label">Country:</label>
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
                            <input required type="text" maxlength="5" id="currency" class="form-control" name="currency" value="{{ old('currency') }}">
                            @if ($errors->has('currency'))
                                <span class="help-block">
                                <strong>{{ $errors->first('currency') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="about_us" class="col-md-2 control-label">About us:</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="about_us" rows="5" ></textarea>
                            @if ($errors->has('about_us'))
                                <span class="help-block">
                                <strong>{{ $errors->first('about_us') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="working_hours" class="col-md-2 control-label">
                        Working Hours:
                        </label>
                        <div class="col-md-10">
                            <!-- Trigger the modal with a button -->
                            <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#working_hours_modal" onclick="javascript:checkWorkingHours();">Add Working Hours</button>
                            
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
                    <div>
                        <legend>Login Information</legend>
                    </div>
                     <div class="form-group required">
                        <label for="email" class="col-md-2 control-label">Email:</label>
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
                            </button>`
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
<div id="working_hours_modal" class="modal fade bs-example-modal-lg" role="dialog">
  <div class="modal-dialog modal-lg"">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Working Hours</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-2">
                    <label for="working_hours" class="control-label">
                        Monday:
                    </label>
                </div>
                <div class="col-md-10">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <input name="option_day[0]" value="0" checked="checked" id="open_0_radio" class="opt_day" type="radio">&nbsp;Open
                        </div>
                        <div class="col-md-4">
                            <input name="option_day[0]" value="1" class="opt_day" id="close_0_radio" type="radio">&nbsp;Closed
                        </div>
                        <div class="col-md-4">
                            <input name="option_day[0]" value="2" class="opt_day" id="hour24_0_radio" type="radio">&nbsp;24 Hours Open
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="working_hours" class="col-md-5 control-label">
                            Opening Time: 
                        </label>
                        <div class='col-md-7'>
                            <div class='input-group date' id='datetimepicker3'>
                                <input type='text' name="open[0]" disabled="" id="open_0" class="form-control" value="10:00 AM" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="working_hours" class="col-md-5 control-label">
                            Closing Time: 
                        </label>
                        <div class='col-md-7'>
                            <div class='input-group date' id='datetimepicker3'>
                                <input type='text' name="close[0]" disabled="" id="close_0" class="form-control" value="6:00 PM" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-2">
                    <label for="working_hours" class="control-label">
                        Tuesday:
                    </label>
                </div>
                <div class="col-md-10">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <input name="option_day[1]" value="0" checked="checked" id="open_1_radio" class="opt_day" type="radio">&nbsp;Open
                        </div>
                        <div class="col-md-4">
                            <input name="option_day[1]" value="1" class="opt_day" id="close_1_radio" type="radio">&nbsp;Closed
                        </div>
                        <div class="col-md-4">
                            <input name="option_day[1]" value="2" class="opt_day" id="hour24_1_radio" type="radio">&nbsp;24 Hours Open
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="working_hours" class="col-md-5 control-label">
                            Opening Time: 
                        </label>
                        <div class='col-md-7'>
                            <div class='input-group date' id='datetimepicker3'>
                                <input type='text' name="open[1]" id="open_1" disabled="" class="form-control" value="10:00 AM" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="working_hours" class="col-md-5 control-label">
                            Closing Time: 
                        </label>
                        <div class='col-md-7'>
                            <div class='input-group date' id='datetimepicker3'>
                                <input type='text' name="close[1]" disabled="" id="close_1" class="form-control" value="6:00 PM" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-2">
                    <label for="working_hours" class="control-label">
                        Wednesday:
                    </label>
                </div>
                <div class="col-md-10">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <input name="option_day[2]" value="0" checked="checked" id="open_2_radio" class="opt_day" type="radio">&nbsp;Open
                        </div>
                        <div class="col-md-4">
                            <input name="option_day[2]" value="1" class="opt_day" id="close_2_radio" type="radio">&nbsp;Closed
                        </div>
                        <div class="col-md-4">
                            <input name="option_day[2]" value="2" class="opt_day" id="hour24_2_radio" type="radio">&nbsp;24 Hours Open
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="working_hours" class="col-md-5 control-label">
                            Opening Time: 
                        </label>
                        <div class='col-md-7'>
                            <div class='input-group date' id='datetimepicker3'>
                                <input type='text' name="open[2]" disabled="" id="open_2" class="form-control" value="10:00 AM" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="working_hours" class="col-md-5 control-label">
                            Closing Time: 
                        </label>
                        <div class='col-md-7'>
                            <div class='input-group date' id='datetimepicker3'>
                                <input type='text' name="close[2]" disabled="" id="close_2" class="form-control" value="6:00 PM" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-2">
                    <label for="working_hours" class="control-label">
                        Thursday:
                    </label>
                </div>
                <div class="col-md-10">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <input name="option_day[3]" value="0" checked="checked" id="open_3_radio" class="opt_day" type="radio">&nbsp;Open
                        </div>
                        <div class="col-md-4">
                            <input name="option_day[3]" value="1" class="opt_day" id="close_3_radio" type="radio">&nbsp;Closed
                        </div>
                        <div class="col-md-4">
                            <input name="option_day[3]" value="2" class="opt_day" id="hour24_3_radio" type="radio">&nbsp;24 Hours Open
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="working_hours" class="col-md-5 control-label">
                            Opening Time: 
                        </label>
                        <div class='col-md-7'>
                            <div class='input-group date' id='datetimepicker3'>
                                <input type='text' name="open[3]" disabled="" id="open_3" class="form-control" value="10:00 AM" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="working_hours" class="col-md-5 control-label">
                            Closing Time: 
                        </label>
                        <div class='col-md-7'>
                            <div class='input-group date' id='datetimepicker3'>
                                <input type='text' name="close[3]" disabled="" id="close_3" class="form-control" value="6:00 PM" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-2">
                    <label for="working_hours" class="control-label">
                        Friday:
                    </label>
                </div>
                <div class="col-md-10">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <input name="option_day[4]" value="0" checked="checked" id="open_4_radio" class="opt_day" type="radio">&nbsp;Open
                        </div>
                        <div class="col-md-4">
                            <input name="option_day[4]" value="1" class="opt_day" id="close_4_radio" type="radio">&nbsp;Closed
                        </div>
                        <div class="col-md-4">
                            <input name="option_day[4]" value="2" class="opt_day" id="hour24_4_radio" type="radio">&nbsp;24 Hours Open
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="working_hours" class="col-md-5 control-label">
                            Opening Time: 
                        </label>
                        <div class='col-md-7'>
                            <div class='input-group date' id='datetimepicker3'>
                                <input type='text' name="open[4]" disabled="" id="open_4" class="form-control" value="10:00 AM" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="working_hours" class="col-md-5 control-label">
                            Closing Time: 
                        </label>
                        <div class='col-md-7'>
                            <div class='input-group date' id='datetimepicker3'>
                                <input type='text' name="close[4]" disabled="" id="close_4" class="form-control" value="6:00 PM" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-2">
                    <label for="working_hours" class="control-label">
                        Saturday:
                    </label>
                </div>
                <div class="col-md-10">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <input name="option_day[5]" value="0" class="opt_day" id="open_5_radio" type="radio">&nbsp;Open
                        </div>
                        <div class="col-md-4">
                            <input name="option_day[5]" value="1" checked="checked" id="close_5_radio" class="opt_day" type="radio">&nbsp;Closed
                        </div>
                        <div class="col-md-4">
                            <input name="option_day[5]" value="2" class="opt_day" id="hour24_5_radio" type="radio">&nbsp;24 Hours Open
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="working_hours" class="col-md-5 control-label">
                            Opening Time: 
                        </label>
                        <div class='col-md-7'>
                            <div class='input-group date' id='datetimepicker3'>
                                <input type='text' name="open[5]" disabled="" id="open_5" class="form-control" value="10:00 AM" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="working_hours" class="col-md-5 control-label">
                            Closing Time: 
                        </label>
                        <div class='col-md-7'>
                            <div class='input-group date' id='datetimepicker3'>
                                <input type='text' name="close[5]" disabled="" id="close_5" class="form-control" value="6:00 PM" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-2">
                    <label for="working_hours" class="control-label">
                        Sunday:
                    </label>
                </div>
                <div class="col-md-10">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <input name="option_day[6]" value="0" class="opt_day" id="open_6_radio" type="radio">&nbsp;Open
                        </div>
                        <div class="col-md-4">
                            <input name="option_day[6]" value="1" checked="checked" id="close_6_radio" class="opt_day" type="radio">&nbsp;Closed
                        </div>
                        <div class="col-md-4">
                            <input name="option_day[6]" value="2" class="opt_day" id="hour24_6_radio" type="radio">&nbsp;24 Hours Open
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="working_hours" class="col-md-5 control-label">
                            Opening Time: 
                        </label>
                        <div class='col-md-7'>
                            <div class='input-group date' id='datetimepicker3'>
                                <input type='text' name="open[6]" disabled="" id="open_6" class="form-control" value="10:00 AM" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="working_hours" class="col-md-5 control-label">
                            Closing Time: 
                        </label>
                        <div class='col-md-7'>
                            <div class='input-group date' id='datetimepicker3'>
                                <input type='text' name="close[6]" disabled="" id="close_6" class="form-control" value="6:00 PM" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="modal_submit">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
    <script type="text/javascript">
        var lat = "";
        var long = "";
        var ip = "{{$ip}}";

        
        $( document ).ready(function() {
          navigator.geolocation.getCurrentPosition(showPosition);
          if(navigator.geolocation)
          {
                function showPosition(position) {
                  lat = position.coords.latitude;
                  long = position.coords.longitude;
                  if(lat!="" && long!="")
                  {
                    buildMap(lat, long);
                  }else
                  {
                    jQuery.get('http://freegeoip.net/json/'+ip, function (response){
                        //alert(response.longitude);
                        lat = parseFloat(response.latitude);
                        long = parseFloat(response.longitude);
                        buildMap(lat,long);
                    }, "jsonp");
                  }
                }
          }else
          {
            jQuery.get('http://freegeoip.net/json/'+ip, function (response){
                //alert(response.longitude);
                lat = parseFloat(response.latitude);
                long = parseFloat(response.longitude);
                buildMap(lat,long);
            }, "jsonp");
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
                }
            })
            .on('success.form.bv', function(e) {
                $('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
                    $('#reg_form').data('bootstrapValidator').resetForm();

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
    window.onload = function () {  getCurrencyAndCode(); };
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
                console.log(response);
                if(response!="")
                {
                    var result = JSON.parse(response);
                    $("#country_code").val(result.country_code);
                    $("#currency").val(result.currency);
                }else
                {
                     $("#currency").val("USD");
                }
            }
        });
    }
</script>
@endsection


