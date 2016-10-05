@extends('layouts.app')
@section('title', 'We African - login')
@section('content')
<div class="main-container row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Enter details to continue</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}

                     <div class="form-group{{ $errors->has('full_name') ? ' has-error' : '' }}">
                        <label for="full_name" class="col-md-4 control-label">Name</label>

                        <div class="col-md-6">
                            <input id="full_name" type="text" class="form-control" name="full_name" value="{{ old('full_name') }}" autofocus>

                            @if ($errors->has('full_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('full_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                 <!--    <div class="form-group{{ $errors->has('mobile_number') ? ' has-error' : '' }}">
                        <label for="mobile_number" class="col-md-4 control-label">Phone Number</label>

                        <div class="col-md-6">
                            <input id="mobile_number" type="text" class="form-control" name="mobile_number" value="{{ old('mobile_number') }}" autofocus>

                            @if ($errors->has('mobile_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mobile_number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div> -->

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Mobile Number</label>

                        <div class="col-md-6">
                            <input id="password" type="text" class="form-control" name="password">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> Remember Me
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>

                            <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                Forgot Your Password?
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
