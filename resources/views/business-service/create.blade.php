@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="main-container row">
    <div class="col-md-10 col-md-offset-1">
        <h5 class="text-left">Add Service</h5>
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
            <form id="register-form" class="form-horizontal" action="{{ url('business-service') }}" method="POST">
                {{csrf_field()}}
                <div class="form-group ">
                    <label for="category" class="col-md-2 required control-label">Service Name</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
                        @if($errors->has('title'))
                            <span class="help-block">
                            <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group ">
                    <label for="description" class="col-md-2 required control-label">Description</label>
                    <div class="col-md-6">
                        <textarea required type="text" class="form-control" name="description"></textarea>
                        @if($errors->has('description'))
                            <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
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