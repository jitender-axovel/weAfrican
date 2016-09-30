@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
<div class="main-container row">
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
	<div class="register-business">
		<h3 class="text-center">Business Profile</h3>
		<dl class="dl-horizontal">
			<dt>Business name</dt>
			<dd>{{$business->title}}</dd>
			<dt>Category:</dt>
			<dd>{{ $business->bussiness_category_id}}</dd>
			<dt>Bussiness keywords</dt>
			<dd>{{ $business->keywords }}</dd>
			<dt>About Us</dt>
			<dd>{{ $business->about_us }}</dd>
			<dt>Address</dt>
			<dd>{{ $business->address }}</dd>
			<dt>City</dt>
			<dd>{{ $business->city }}</dd>
			<dt>State</dt>
			<dd>{{ $business->state }}</dd>
			<dt>Country:</dt>
			<dd>{{ $business->country }}</dd>
			<dt>Pin code</dt>
			<dd>{{ $business->pin_code }}</dd>
			<dt>Email</dt>
			<dd>{{ $business->email }}</dd>
			<dt>Primary Mobile Number</dt>
			<dd>{{ $business->phone_number }}</dd>
			<dt>Secondary Mobile Number</dt>
			<dd>{{ $business->secondary_phone_number }}</dd>
			<dt>Website</dt>
			<dd>{{ $business->website }}</dd>
			<dt>Working Hours</dt>
			<dd>{{ $business->working_hours }}</dd>
			@if($business->business_proof)
				<dt>Identity Proof</dt>
				<dd><img src="{{asset(config('image.document_url').$business->identity_proof)}}" style="width:100px;height:100px;"/>
				<a href="{{ URL::to('admin/business/identity/proof/validate/'.$business->id) }}">
				
			                    @if($business->is_identity_proof_validate)
			                    <button type="button" class="btn btn-success" title="Verified"><i class="fa fa-ban"></i></button>
			                    	
		                    	@else
		                    		<button type="button" class="btn btn-danger" title="Unverified"><i class="fa fa-unlock"></i></button>
		                		@endif
		                    </a>
		                    </dd>
				<dt>Business Proof</dt>
				<dd><img src="{{asset(config('image.document_url').$business->business_proof)}}" style="width:100px;height:100px;"/>
				<a href="{{ URL::to('admin/business/proof/validate/'.$business->id) }}">
			                    @if($business->is_business_proof_validate)
			                    <button type="button" class="btn btn-success" title="Verified"><i class="fa fa-ban"></i></button>
			                    	
		                    	@else
		                    		<button type="button" class="btn btn-danger" title="Unverified"><i class="fa fa-unlock"></i></button>
		                		@endif
		                    </a></dd>
			@else
					<dt>User does not upload any document.</dt>
					<dd><a href="{{url('upload')}}"><button>Upload Document</button></a></dd>
			@endif
		</dl>
	</div>
</div>
@endsection