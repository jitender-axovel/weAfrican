@extends('admin.layouts.adminapp')
@section('title', $page)
@section('content')
	<h2>Edit User</h2>
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
	<div class="panel panel-default">
		<div class="panel-heading">
			<p class="bold">Edit User</p>
		</div>
		<div class="panel-body">
			<form action="{{ url('admin/users/'.$users->id) }}" method="POST" class="form-horizontal">
				{{csrf_field()}}
				<input type="hidden" name="_method" value="put" />
				<div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
					<label class="control-label col-md-2">First Name</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="first_name" value="{{ $users->first_name }}" >
						@if($errors->has('first_name'))
							<span class="help-block">
								<strong>{{ $errors->first('first_name') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
					<label class="control-label col-md-2">Last Name</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="last_name" value="{{ $users->last_name }}" >
						@if($errors->has('last_name'))
							<span class="help-block">
								<strong>{{ $errors->first('last_name') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
					<label class="control-label col-md-2">Email</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="email" value="{{ $users->email }}" >
						@if($errors->has('email'))
							<span class="help-block">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
					<label class="control-label col-md-2">Password</label>
					<div class="col-md-10">
						<input type="password" class="form-control" name="password" value="{{ old('password') }}" >
						@if($errors->has('password'))
							<span class="help-block">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group{{ $errors->has('confirm_password') ? ' has-error' : '' }}">
					<label class="control-label col-md-2">Confirm Password</label>
					<div class="col-md-10">
						<input type="password" class="form-control" name="confirm_password" value="{{ old('confirm_passowrd') }}" >
						@if($errors->has('confirm_password'))
							<span class="help-block">
								<strong>{{ $errors->first('confirm_password') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12">
						<button type="submit" class="btn btn-default col-md-offset-2" id="btn-login">Update User</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection