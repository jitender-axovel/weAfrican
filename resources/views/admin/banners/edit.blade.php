@extends('admin.layouts.adminapp')
@section('title', $page)
@section('content')
	<h2>Edit Banner</h2>
	<hr>
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
			<p class="bold">Edit  Banner</p>
		</div>
		<div class="panel-body">
			<form action="{{ url('admin/banner/'.$banner->id) }}" method="POST" class="form-horizontal">
				{{csrf_field()}}
				<input type="hidden" name="_method" value="put" />
				<div class="form-group{{ $errors->has('city_id') ? ' has-error' : '' }}">
					<label class="control-label col-md-2">City</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="product_limit" value="{{ $banner->city_id}}" >
						@if($errors->has('city_id'))
							<span class="help-block">
								<strong>{{ $errors->first('city_id') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
					<label class="control-label col-md-2">Banner Name</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="name" value="{{ $banner->name }}" >
						@if($errors->has('name'))
							<span class="help-block">
								<strong>{{ $errors->first('name') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12">
						<button type="submit" class="btn btn-default col-md-offset-2" id="btn-login">Update Banner</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection