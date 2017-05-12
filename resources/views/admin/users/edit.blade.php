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
					<label class="control-label col-md-2">Full Name</label>
					<div class="col-md-10{{ ($errors->has('full_name')) ? ' has-error' : '' }}">
						<input required type="text" class="form-control" name="full_name" value="{{ $user->full_name ? $user->full_name : old('full_name') }}">
						@if($errors->has('full_name'))
							<span class="help-block">
								<strong>{{ $errors->first('full_name') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<button type="submit" class="btn btn-success btn-block" id="btn-login">Save User</button>
			</form>
		</div>
	</div>
@endsection