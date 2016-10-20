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
                    <label for="name" class="col-md-2 required control-label">Event Name</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="name" value="{{ $event->name }}" required>
                        @if($errors->has('name'))
	                        <span class="help-block">
	                        <strong>{{ $errors->first('name') }}</strong>
	                        </span>
                        @endif
                    </div>
                    <label for="keywords" class="col-md-2 required control-label">Event Keywords</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="keywords" value="{{ $event->keywords }}" required>
                        @if($errors->has('keywords'))
	                        <span class="help-block">
	                        <strong>{{ $errors->first('keywords') }}</strong>
	                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group ">
                    <label for="organizer_name" class="col-md-2 required control-label">Organizer Name</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="organizer_name" value="{{ $event->organizer_name }}" required >
                        @if($errors->has('organizer_name'))
	                        <span class="help-block">
	                        <strong>{{ $errors->first('organizer_name') }}</strong>
	                        </span>
                        @endif
                    </div>
                    <label for="address" class="col-md-2  control-label">Address</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="address" value="{{ $event->address }}" required >
                        @if($errors->has('address'))
	                        <span class="help-block">
	                        <strong>{{ $errors->first('address') }}</strong>
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
</script>
@endsection