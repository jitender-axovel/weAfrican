@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="main-container row register-business">
	<h5 class="text-left">Business Profile</h5>
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

    @if($business)
	    <div class="row">
	    	<div class="col-md-9">
	    		@if($business->is_update==1)
	    			<div class="notifications">
					    <div class="alert alert-warning alert-block">
					        <button type="button" class="close" data-dismiss="alert">×</button>
					        <h6>Update Your Portfolio</h6>
						</div>
					</div>
	    		@endif
	    	</div>
	    	<div class="col-md-3">
	    		<p class="text-right"><a href="{{url('register-business/'.$business->id.'/edit')}}"><button type="button" class="btn btn-info">Edit Business Profile</button> </a> </p>
	    	</div>
	    </div>
	    <div class="panel panel-default ">
	    	@if($business->banner != NULL)
	    		<img class="banner_image" src="{{asset(config('image.banner_image_url').'business/'.$business->banner)}}"/>
	    	@else
	            <img class="banner_image" src="{{asset('images/blank-image.jpeg')}}">
            @endif
	    </div>
		<div class="business-profile">
			<div class="business-left col-md-6">
			    <dl class="dl-horizontal">
			    	@if($category_check==1 or $category_check==2)
			    		<dt>Profile Pic</dt>
			    	@else
			    		<dt>Business Logo</dt>
			    	@endif
			        <dd>
		          	@if($business->business_logo != NULL)
			            <img src="{{asset(config('image.logo_image_url').'thumbnails/small/'.$business->business_logo)}}"/>
		            @else
			            <img src="{{asset('images/no-uploaded.png')}}"/>
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
			        <dd>{{ $business->user->address }}</dd>
			        <dt>City</dt>
			        <dd>{{ $business->user->city }}</dd>
			        <dt>State</dt>
			        <dd>{{ $business->user->state }}</dd>
			        <dt>Country:</dt>
			        <dd>{{ $business->user->country }}</dd>
			        <dt>Pin code</dt>
			        <dd>{{ $business->user->pin_code }}</dd>
			        <dt>Email</dt>
			        <dd>{{ $business->user->email }}</dd>
			        <dt>Mobile Number</dt>
			        <dd>{{ $business->user->mobile_number }} &nbsp;&nbsp;&nbsp;
			        @if($business->user->mobile_verified==0)
			        <a class="btn-danger label" href="{{ url('mobileVerify/') }}"><label >Not Verified</label></a>
			        @else
			        <label class="btn-success label">Verified</span>
			        @endif
			        </dd>
			        <dt>Website</dt>
			        <dd>{{ $business->website }}</dd>
			        <dt>Working Hours</dt>
			        <dd>
			        	{!! nl2br(e($business->working_hours)) !!}
			        </dd>
			    </dl>
			    @if($category_check==1 or $category_check==2)
				    <fieldset>
				    	<legend>Login Information</legend>
				    </fieldset>
				    <dl class="dl-horizontal">
			    		<dt>Maritial Status</dt>
			    		<dd></dd>
			    		<dt>Maritial Status</dt>
			    		<dd></dd>
			    		<dt>Maritial Status</dt>
			    		<dd></dd>
			    		<dt>Maritial Status</dt>
			    		<dd></dd>
			    		<dt>Maritial Status</dt>
			    		<dd></dd>
				        <dt></dt>
				    </dl>
			    @endif    
		    </div>
		    <div class="business-right col-md-6">
				<dl class="dl-horizontal">
					@if($business->business_proof)
				        <dt>Identity Proof</dt>
				        <dd>
				        	@if($business->identity_proof)
				            <a href="{{asset(config('image.document_url').$business->identity_proof)}}" target="_blank">	
				            <i class="fa fa-file-text fa-2x" aria-hidden="true" title="see document"></i> </a>
				            @endif
				        </dd>
				       
				        <dt>Business Proof</dt>
				        <dd>
				        	@if($business->business_proof)
				            <a href="{{asset(config('image.document_url').$business->business_proof)}}" target="_blank">	
				            <i class="fa fa-file-text fa-2x" aria-hidden="true" title="see document"></i>
				            </a>
				            @endif
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
				        <dt>Upload Document</dt>
				        <dd><a href="{{url('upload')}}"><button>Upload Document</button></a> </dd>
			        @endif
				</dl>
		    </div>
		    <div class="comment-section col-md-12">
			    	<div class="col-md-2 like item">
			        	<span class="label label-warning" title="Likes"><i class="fa fa-thumbs-o-up" aria-hidden="true"><span class="badge">{{$business->getLikes()}}</span></i></span>
					</div>

					<div class="col-md-2 dislike item">
						<span class="label label-primary" title="Dislikes"><i class="fa fa-thumbs-o-down" aria-hidden="true">
						<span class="badge">{{$business->getDislikes()}}</span></i></span>
					</div>

					<div class="col-md-2 rating item">
						<span class="label label-success" title="Ratings"><i class="fa fa-star-o" aria-hidden="true">
						<span class="badge">{{(int)$business->getRatings()}}</span></i>
						</span>
					</div>

					<div class="col-md-2 favourite item">
						<span class="label label-info" title="Favourites"><i class="fa fa-heart-o" aria-hidden="true">
						<span class="badge">{{$business->getFavourites()}}</span></i>
						</span>
					</div>

					<div class="col-md-2 followers item">
						<span class="label label-danger" title="Followers"><i class="fa fa-users" aria-hidden="true">
						<span class="badge">{{$business->getFollowers()}}</span></i></span>
					</div>
				</div> 
		</div>
    @else
        <p>Could not find any profile</p>
    @endif	
</div>
@endsection