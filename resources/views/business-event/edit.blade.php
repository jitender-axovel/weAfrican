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
            <form id="register-form" class="form-horizontal" action="{{ url('business-event/'.$event->id) }}" method="POST">
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
                    <label for="title" class="col-md-2 required control-label">Event Title</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="title" value="{{ $event->title }}" required>
                        @if($errors->has('title'))
	                        <span class="help-block">
	                        <strong>{{ $errors->first('title') }}</strong>
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
                    <label for="event_dt" class="col-md-2 required control-label">Event Date& Time</label>
                    <div class="col-md-4">
                        <input  type="text" class="form-control" name="event_dt" id="dob" value="{{ $event->event_dt }}" >
                        @if($errors->has('event_dt'))
	                        <span class="help-block">
	                        <strong>{{ $errors->first('event_dt') }}</strong>
	                        </span>
                        @endif
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
<script type="text/javascript">
    $(document).ready(function () {
		$('#dob').datepicker({
			format: "yyyy-mm-dd"
       	});  
           
	});
</script>
@endsection