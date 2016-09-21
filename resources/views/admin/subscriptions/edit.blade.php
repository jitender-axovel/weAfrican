@extends('admin.layouts.adminapp')
@section('title', $page)
@section('content')
	<h2>Edit {{ $subscription->title }} Subscription Plan</h2>
	<hr>
	@include('notification')
	<div class="panel panel-default">
		<div class="panel-body">
			<form action="{{ url('admin/subscription/plan/'.$subscription->id) }}" method="POST" class="form-horizontal">
				{{csrf_field()}}
				{{ method_field('PUT') }}
				<div class="form-group">
					<label class="control-label col-md-2">Product Limit</label>
					<div class="col-md-4{{ $errors->has('product_limit') ? ' has-error' : '' }}">
						<input type="text" class="form-control" name="product_limit" value="{{ $subscription->product_limit}}" >
						@if($errors->has('product_limit'))
							<span class="help-block">
								<strong>{{ $errors->first('product_limit') }}</strong>
							</span>
						@endif
					</div>
					<label class="control-label col-md-2">Service Limit</label>
					<div class="col-md-4{{ $errors->has('service_limit') ? ' has-error' : '' }}">
						<input type="text" class="form-control" name="service_limit" value="{{ $subscription->service_limit }}" >
						@if($errors->has('service_limit'))
							<span class="help-block">
								<strong>{{ $errors->first('service_limit') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Price(per month)</label>
					<div class="col-md-4{{ $errors->has('price') ? ' has-error' : '' }}">
						<input type="text" class="form-control" name="price" value="{{ $subscription->price }}" >
						@if($errors->has('price'))
							<span class="help-block">
								<strong>{{ $errors->first('price') }}</strong>
							</span>
						@endif
					</div>
					<div class="col-md-6">
						<button type="submit" class="btn btn-success btn-block" id="btn-login">Update Subscription</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection