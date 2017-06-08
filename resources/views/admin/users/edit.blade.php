@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2>Edit User</h2>
	<hr>
	@include('notification')
	<div class="panel panel-default">
		<div class="panel-body">
			<form action="{{ url('admin/users/'.$user->id) }}" method="POST" class="form-horizontal">
				{{csrf_field()}}
				{{ method_field('PUT') }}
				<div class="form-group">
					<label class="control-label col-md-2">First Name</label>
					<div class="col-md-4{{ ($errors->has('first_name')) ? ' has-error' : '' }}">
						<input required type="text" class="form-control" name="first_name" value="{{ $user->first_name ? $user->first_name : old('first_name') }}">
						@if($errors->has('first_name'))
							<span class="help-block">
								<strong>{{ $errors->first('first_name') }}</strong>
							</span>
						@endif
					</div>
					<label class="control-label col-md-2">Middle Name</label>
					<div class="col-md-4{{ ($errors->has('middle_name')) ? ' has-error' : '' }}">
						<input required type="text" class="form-control" name="middle_name" value="{{ $user->middle_name ? $user->middle_name : old('middle_name') }}">
						@if($errors->has('middle_name'))
							<span class="help-block">
								<strong>{{ $errors->first('middle_name') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Last Name</label>
					<div class="col-md-4{{ ($errors->has('last_name')) ? ' has-error' : '' }}">
						<input required type="text" class="form-control" name="last_name" value="{{ $user->last_name ? $user->last_name : old('last_name') }}">
						@if($errors->has('last_name'))
							<span class="help-block">
								<strong>{{ $errors->first('last_name') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<button type="submit" class="btn btn-success" id="btn-login">Save User</button>
			</form>
		</div>
	</div>
@endsection