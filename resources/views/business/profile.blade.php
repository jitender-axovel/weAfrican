@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="main-container row">

	<div class="register-business">
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
	@if($business)
		<h3 class="text-center">Business Profile</h3>
		<p class="text-right"><a href="{{url('register-business/'.$business->id.'/edit')}}"><button type="button" class="btn btn-info">Edit Business Profile</button></a></p>
		<dl class="dl-horizontal">
			<dt>Business Logo</dt>
			<dd><img src="{{asset(config('image.logo_image_url').$business->business_logo)}}" style="width:100px;height:100px"/></dd>
			<dt>Business name</dt>
			<dd>{{$business->title}}</dd>
			<dt>Category:</dt>
			<dd>{{ $business->category->title}}</dd>
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
			<dd>{{ $business->mobile_number }}</dd>
			<dt>Secondary Mobile Number</dt>
			<dd>{{ $business->secondary_phone_number }}</dd>
			<dt>Website</dt>
			<dd>{{ $business->website }}</dd>
			<dt>Working Hours</dt>
			<dd>{{ $business->working_hours }}</dd>
			@if($business->business_proof)
				<dt>Identity Proof</dt>
				<dd><img src="{{asset(config('image.document_url').$business->identity_proof)}}" style="width:100px;height:100px"/></dd>
				<dt>Business Proof</dt>
				<dd><img src="{{asset(config('image.document_url').$business->business_proof)}}" style="width:100px;height:100px"/></dd>
				@if($business->is_identity_proof_validate && $business->is_business_proof_validate)
					<dt>Document Status</dt>
					<dd><span class="verified btn-success label"><i class="fa fa-check" aria-hidden="true"></i>
					Verified</span></dd>
				@else
					<dt>Edit Document</dt>
					<dd><a href="{{url('upload')}}"><button>Upload Document</button></a></dd>
					<dt>Document Status</dt>
					<dd> <span class=" pending btn-danger label">Pending</span></dd>
				@endif
			@else
					<dt>Please Upload document to verify your business</dt>
					<dd><a href="{{url('upload')}}"><button>Upload Document</button></a></dd>
			@endif
		@else
			<p>Could not find any profile</p>
		@endif

		</dl>
	</div>
</div>
@endsection