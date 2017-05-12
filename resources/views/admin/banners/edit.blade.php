@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2>Edit Banner</h2>
	<hr>
	@include('notification')
	<div class="panel panel-default">
		<div class="panel-body">
			<form action="{{ url('admin/banner/'.$banner->id) }}" method="POST" class="form-horizontal">
				{{ csrf_field() }}
				{{ method_field('PUT') }}
				<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
					<label class="control-label col-md-2">Banner Title</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="title" value="{{ $banner->title or old('title') }}" >
						@if($errors->has('title'))
							<span class="help-block">
								<strong>{{ $errors->first('title') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
					<label class="control-label col-md-2">Banner Description</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="description" value="{{ $banner->description or old('description') }}" >
						@if($errors->has('description'))
							<span class="help-block">
								<strong>{{ $errors->first('description') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
					<label class="control-label col-md-2">City</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="city" value="{{ $banner->city}}" >
						@if($errors->has('city'))
							<span class="help-block">
								<strong>{{ $errors->first('city') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<button type="submit" class="btn btn-success btn-block">Update Banner</button>
			</form>
		</div>
	</div>
@endsection