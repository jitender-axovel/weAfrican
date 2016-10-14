@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="main-container row register-business">
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
    <h5 class="text-left">Business Profile</h5>
    @if($business)
	    <p class="text-right"><a href="{{url('register-business/'.$business->id.'/edit')}}"><button type="button" class="btn btn-info">Edit Business Profile</button> </a> </p>
	    <dl class="dl-horizontal">
	        <dt>Business Logo</dt>
	        <dd>
          	@if($business->business_logo != NULL)
	            <img src="{{asset(config('image.logo_image_url').$business->business_logo)}}" style="width:100px;height:100px"/>
            @else
	            <img src="{{asset('images/no-uploaded.png')}}" style="width:100px;height:100px"/>
            @endif
	        </dd>
	        <dt>Business ID</dt>
	        <dd>{{$business->business_id}}</dd>
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
		        <dd>
		            <a href="{{asset(config('image.document_url').$business->identity_proof)}}" target="_blank">	
		            <i class="fa fa-file-text fa-2x" aria-hidden="true" title="see document"></i>
		        </dd>
		        </a>
		        <dt>Business Proof</dt>
		        <dd>
		            <a href="{{asset(config('image.document_url').$business->business_proof)}}" target="_blank">	
		            <i class="fa fa-file-text fa-2x" aria-hidden="true" title="see document"></i>
		            </a>
		        </dd>
	        	@if($business->is_identity_proof_validate && $business->is_business_proof_validate)
			        <dt>Document Status</dt>
			        <dd><span class="verified btn-success label"><i class="fa fa-check" aria-hidden="true"></i>
			            Verified</span>
			        </dd>
	        	@else
			        <dt>Edit Document</dt>
			        <dd><a href="{{url('upload')}}"><button>Upload Document</button></a></dd>
			        <dt>Document Status</dt>
			        <dd> <span class=" pending btn-danger label">Pending Verification</span></dd>
	        	@endif
	        @else
		        <dt>Please Upload document to verify your business</dt>
		        <dd><a href="{{url('upload')}}"><button>Upload Document</button></a> </dd>
	        @endif
	    </dl>
    @else
        <p>Could not find any profile</p>
    @endif	
</div>
@endsection