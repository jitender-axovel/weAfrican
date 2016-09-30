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
					<div class="col-md-10">
					{{$subscription->title}}
					</div>
					</div>
					<div class="form-group">
					<label class="control-label col-md-2">Coverage</label>
					<div class="col-md-6">
					{{ $subscription->coverage }}
						
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Price(per month)</label>
					<div class="col-md-6{{ $errors->has('price') ? ' has-error' : '' }}">
						<input required type="text" class="form-control" name="price" value="{{ $subscription->price }}" >
						@if($errors->has('price'))
							<span class="help-block">
								<strong>{{ $errors->first('price') }}</strong>
							</span>
						@endif
					</div>
					
				</div>
				<div class="col-md-6 col-md-offset-2">
						<button type="submit" class="btn btn-success btn-block" id="btn-login">Update Subscription</button>
					</div>
			</form>
		</div>
	</div>
@endsection