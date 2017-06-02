@extends('layouts.app')
@section('content')
<div class="main-container row register-business">
    <h4>Edit Business Profile</h4>
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
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register-business/'.$business->id) }}" enctype='multipart/form-data'>
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-group ">
                <label for="title" class="col-md-2 required control-label">Name</label>
                <div class="col-md-1">
                    <select name="salutation" id="salutation" class="form-control selectpicker" required style="padding-right:0px;">
                        <option @if($business->user->salutation=="Mr") selected="selected" @endif value="Mr">Mr.</option>
                        <option @if($business->user->salutation=="Ms") selected="selected" @endif value="Ms">Ms.</option>
                        <option @if($business->user->salutation=="Mrs") selected="selected" @endif value="Mrs">Mrs.</option>
                    </select>
                    @if ($errors->has('salutation'))
                        <span class="help-block">
                        <strong>{{ $errors->first('salutation') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-3">
                    <input required type="text" class="form-control" name="first_name" value="{{ $business->user->first_name }}" placeholder="First Name">
                    @if ($errors->has('title'))
                    <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="middle_name" value="{{ $business->user->middle_name }}" placeholder="Middle Name">
                    @if ($errors->has('title'))
                    <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-md-3">
                    <input required type="text" class="form-control" name="last_name" value="{{ $business->user->last_name }}" placeholder="Last Name">
                    @if ($errors->has('title'))
                    <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group ">
                <label for="category" class="col-md-2 required control-label">Category</label>
                <div class="col-md-4">
                    <select required class="form-control selectpicker" disabled="disabled" >
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
                @if(count($subcategories)>0 and $subcategories!=null)
                    <label for="subcategory" class="col-md-2 required control-label">Sub-Category</label>
                    <div class="col-md-4">
                        <select required class="form-control selectpicker" disabled="disabled" >
                            <option value="" selected>Select Category</option>
                            @foreach($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}" @if($business->subcategory->title == $subcategory->title){{ 'selected'}} @else @endif  >{{ $subcategory->title }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
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
                <label for="keywords" class="col-md-2 required control-label">Business Keywords</label>
                <div class="col-md-4">
                    <input required type="text" class="form-control" name="keywords" value="{{ $business->keywords }}">
                    @if ($errors->has('keywords'))
                        <span class="help-block">
                        <strong>{{ $errors->first('keywords') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group ">
                <label for="email" class="col-md-2 required control-label">Business Email</label>
                <div class="col-md-4">
                    <input required type="email" class="form-control" value=" {{$business->user->email }}" disabled="disabled">
                    @if ($errors->has('email'))
                        <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <label for="address" class="col-md-2 control-label">Address</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="address" value="{{ $business->user->address }}">
                    @if ($errors->has('address'))
                        <span class="help-block">
                        <strong>{{ $errors->first('address') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="city" class="col-md-2 control-label">City</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="city" value="{{ $business->user->city }}">
                    @if ($errors->has('city'))
                        <span class="help-block">
                        <strong>{{ $errors->first('city') }}</strong>
                        </span>
                    @endif
                </div>
                <label for="state" class="col-md-2 control-label">State</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="state" value="{{ $business->user->state }}">
                    @if ($errors->has('state'))
                        <span class="help-block">
                        <strong>{{ $errors->first('state') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="country" class="col-md-2 control-label">Country</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="country" value="{{ $business->user->country }}" disabled>
                    @if ($errors->has('country'))
                        <span class="help-block">
                        <strong>{{ $errors->first('country') }}</strong>
                        </span>
                    @endif
                </div>
                <label for="pin_code" class="col-md-2 control-label">Pin Code</label>
                <div class="col-md-4">
                    <input type="number" class="form-control" name="pin_code" value="{{ $business->user->pin_code }}" required>
                    @if ($errors->has('pin_code'))
                        <span class="help-block">
                        <strong>{{ $errors->first('pin_code') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="website" class="col-md-2 control-label">Website</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="website" value="{{ $business->website }}">
                    @if ($errors->has('website'))
                        <span class="help-block">
                        <strong>{{ $errors->first('website') }}</strong>
                        </span>
                    @endif
                </div>
                <label for="mobile_number" class="col-md-2 required control-label">Mobile Number:</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="mobile_number" value="{{ $business->user->mobile_number }}">
                    @if ($errors->has('mobile_number'))
                        <span class="help-block">
                        <strong>{{ $errors->first('mobile_number') }}</strong>
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
                    <textarea class="form-control" name="working_hours" id="working_hours" rows="8" readonly="readonly" onclick="javascript:$('#working_hours_modal').modal('show');" >{{ $business->working_hours }}</textarea>
                    <br>
                    <!-- Trigger the modal with a button -->
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#working_hours_modal" onclick="javascript:checkWorkingHours();">Update Working Hours</button>
                </div>
            </div>
            <div class="form-group">
                <label for="about_us" class="col-md-2 control-label">Business Logo</label>
                <div class="col-md-10">
                    @if($business->business_logo != NULL)
                        <img src="{{asset(config('image.logo_image_url').$business->business_logo)}}"/>
                    @else
                        <img src="{{asset('images/no-uploaded.png')}}"/>
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
                    <img src="{{asset('images/no-image.jpg')}}" alt=""  id="preview">
                </div>
            </div>
            <div class="form-group">
                <label for="about_us" class="col-md-2 control-label">Business Logo</label>
                <div class="col-md-10">
                    @if($business->banner != NULL)
                        <img src="{{asset(config('image.banner_image_url').'business/thumbnails/small/'.$business->banner)}}"/ alt="Banner Image">
                    @else
                        <p>Banner Image not uploded yet.</p>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="banner" class="col-md-2 control-label">Upload Business Banner:</label>
                <div class="col-md-4">
                    <input type="file" name="banner" id="banner">
                    @if ($errors->has('banner'))
                        <span class="help-block">
                        <strong>{{ $errors->first('banner') }}</strong>
                        </span>
                    @endif
                </div>
                <label for="banner_preview" class="col-md-2 control-label">
               Banner Preview:
                </label>
                <div class="col-md-4">
                    <img src="{{asset('images/no-image.jpg')}}" alt=""  id="bannerPreview">
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
@section('header-scripts')
    <script src='http://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
    <script src="{{ asset('js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
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

    function bannerReadURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#bannerPreview').attr('src', e.target.result);
          }
        reader.readAsDataURL(input.files[0]);
      }
    }
    
    $("#banner").change(function(){
        bannerReadURL(this);
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
        setWorkingHoursValue();
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
    function setWorkingHoursValue()
    {
        var text = Array();
        @if(count(explode(PHP_EOL,$business->working_hours))>1)
            @for($i=0;$i<count(explode(PHP_EOL,$business->working_hours))-1;$i++)
                text[{{ $i }}] = "{{ preg_replace('/([\r\n\t])/','', explode(PHP_EOL,$business->working_hours)[$i]) }}";
            @endfor
        @endif
        for(var i=0;i<text.length;i++)
        {
            var day = text[i].split("  :   ")[0];
            if(day=="MON")
            {
                setWorkingHoursValuesModal(text[i].split("  :   ")[1],0);
            }else if(day=="TUE")
            {
                setWorkingHoursValuesModal(text[i].split("  :   ")[1],1);
            }else if(day=="WED")
            {
                setWorkingHoursValuesModal(text[i].split("  :   ")[1],2);
            }else if(day=="THU")
            {
                setWorkingHoursValuesModal(text[i].split("  :   ")[1],3);
            }else if(day=="FRI")
            {
                setWorkingHoursValuesModal(text[i].split("  :   ")[1],4);
            }else if(day=="SAT")
            {
                setWorkingHoursValuesModal(text[i].split("  :   ")[1],5);
            }else if(day=="SUN")
            {
                setWorkingHoursValuesModal(text[i].split("  :   ")[1],6);
            }
        }
    }
    function setWorkingHoursValuesModal(str,i)
    {
        if(str=="24 Hours Open")
        {
            $('input:radio[id=hour24_'+i+'_radio]').prop('checked', true);
        }else if(str=="Closed")
        {
            $('input:radio[id=close_'+i+'_radio]').prop('checked', true);
        }else
        {
            $('input:radio[id=open_'+i+'_radio]').prop('checked', true);
            var time = str.split(" to ");
            var open = time[0].split(":");
            var close = time[1].split(":");
            if(parseInt(open[0])>10)
            {
                $("#open_"+i).val(time[0]);
            }else
            {
                $("#open_"+i).val(parseInt(open[0])+":"+open[1]);
            }
            if(parseInt(close[0])>10)
            {
                $("#close_"+i).val(time[1]);
            }else
            {
                $("#close_"+i).val(parseInt(close[0])+":"+close[1]);
            }
        }
    }
</script>
<script type="text/javascript">
    $(function () {
        $('.date').datetimepicker({
            format: 'LT'
        });
    });
</script>
@endsection

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
                            <input name="option_day[0]" value="0" id="open_0_radio" class="opt_day" type="radio">&nbsp;Open
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
                            <input name="option_day[1]" value="0" id="open_1_radio" class="opt_day" type="radio">&nbsp;Open
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
                            <input name="option_day[2]" value="0" id="open_2_radio" class="opt_day" type="radio">&nbsp;Open
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
                            <input name="option_day[3]" value="0" id="open_3_radio" class="opt_day" type="radio">&nbsp;Open
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
                            <input name="option_day[4]" value="0" id="open_4_radio" class="opt_day" type="radio">&nbsp;Open
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
                            <input name="option_day[5]" value="1" id="close_5_radio" class="opt_day" type="radio">&nbsp;Closed
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
                            <input name="option_day[6]" value="1" id="close_6_radio" class="opt_day" type="radio">&nbsp;Closed
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