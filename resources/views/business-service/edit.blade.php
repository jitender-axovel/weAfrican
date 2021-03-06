@extends('layouts.app')
@section('content')
<div class="container row_pad">
    <div class="col-md-12">
        <h5 class="text-left">Edit Service</h5>
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
            <form id="register-form" class="form-horizontal" action="{{ url('business-service/'.$service->id) }}" method="POST">
                {{csrf_field()}}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label for="service_name" class="col-md-2 required control-label">Service Name</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="title" value="{{ $service->title }}" required>
                        @if($errors->has('title'))
                            <span class="help-block">
                            <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-md-2 required control-label">Description</label>
                    <div class="col-md-6">
                        <textarea required type="text" class="form-control" name="description">{{ $service->description }}</textarea>
                        @if($errors->has('description'))
                            <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-8 text-right">
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