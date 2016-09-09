@extends('admin.layouts.adminapp')
@section('title', $page)
@section('content')
	<h2>Edit Subscription Plan</h2>
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
			<p class="bold">Edit Subscription Plan</p>
		</div>
		<div class="panel-body">
			<form action="{{ url('admin/subscription/plan/'.$subscription->id) }}" method="POST" class="form-horizontal">
				{{csrf_field()}}
				<input type="hidden" name="_method" value="put" />
				<div class="form-group">
					<label class="control-label col-md-2">Subscription Plan Name</label>
					<div class="col-md-10">
						{{ $subscription->title }}
					</div>
				</div>
				<div class="form-group{{ $errors->has('product_limit') ? ' has-error' : '' }}">
					<label class="control-label col-md-2">Product Limit</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="product_limit" value="{{ $subscription->product_limit}}" >
						@if($errors->has('product_limit'))
							<span class="help-block">
								<strong>{{ $errors->first('product_limit') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group{{ $errors->has('service_limit') ? ' has-error' : '' }}">
					<label class="control-label col-md-2">Service Limit</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="service_limit" value="{{ $subscription->service_limit }}" >
						@if($errors->has('service_limit'))
							<span class="help-block">
								<strong>{{ $errors->first('service_limit') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
					<label class="control-label col-md-2">Price(per month)</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="price" value="{{ $subscription->price }}" >
						@if($errors->has('price'))
							<span class="help-block">
								<strong>{{ $errors->first('price') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12">
						<button type="submit" class="btn btn-default col-md-offset-2" id="btn-login">Update Subscription</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection