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
	    <div class="panel panel-default ">
	    	@if($business->banner != NULL)
	    		<img class="business_image" src="{{asset(config('image.banner_image_url').'business/'.$business->banner)}}"/>
	    	@else
	            <img class="event_image" src="{{asset('images/blank-image.jpeg')}}" style="width:100px;height:100px"/>
            @endif
	    </div>
	    <div class="comment-section">
			<div class="col-md-3 col-sm-3 col-xs-3 item item-1">
				<p class="disc_like">20</p>
				<p class="tile_like">Likes</p>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-3 item item-2">
				<p class="disc_dislike">4</p>
				<p class="tile_dislike">Dislikes</p>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-3 item item-3">
				<p class="disc_follow">2</p>
				<p class="tile_follow">Followers</p>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-3 item item-4">
				<p class="disc_review">20</p>
				<p class="tile_review">Ratings</p>
			</div>
		</div>
		<div class="business-profile">
			<div class="business-left col-md-8">
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
			    </dl>
		    </div>
		    <div class="business-right col-md-4">
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
				        <dt>Please Upload document to verify your business</dt>
				        <dd><a href="{{url('upload')}}"><button>Upload Document</button></a> </dd>
			        @endif
				</dl>
		    </div>
		</div>
    @else
        <p>Could not find any profile</p>
    @endif	
</div>
@endsection