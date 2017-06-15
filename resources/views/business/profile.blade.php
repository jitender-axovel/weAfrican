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
			 	<fieldset>
			    	<legend>Business Profile Details</legend>
				</fieldset>
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
						@if($category_check==1 or $category_check==2)
			    			<label>Profile Pic</label>
			    		@else
			    			<label>Business Logo</label>
			    		@endif
					</div>
					<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
						@if($business->business_logo != NULL)
				            <img src="{{asset(config('image.logo_image_url').'thumbnails/small/'.$business->business_logo)}}"/>
			            @else
				            <img src="{{asset('images/no-uploaded.png')}}"/>
			            @endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
						<label>Business ID</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
						{{$business->business_id}}
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
						<label>Business name</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
						{{$business->title}}
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
						<label>Category:</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
						{{ $business->category->title}}
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
						<label>Bussiness keywords</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
						{{ $business->keywords }}
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
						<label>About Us</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
						{{ $business->about_us }}
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
						<label>Address</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
						{{ $business->user->address }}
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
						<label>City</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
						{{ $business->user->city }}
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
						<label>State</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
						{{ $business->user->state }}
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
						<label>Country</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
						{{ $business->user->country }}
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
						<label>Pin code</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
						{{ $business->user->pin_code }}
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
						<label>Email</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
						{{ $business->user->email }}
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
						<label>Mobile Number</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
						{{ $business->user->mobile_number }} &nbsp;&nbsp;&nbsp;
				        @if($business->user->mobile_verified==0)
				        <a class="btn-danger label" href="{{ url('mobileVerify/') }}"><label >Not Verified</label></a>
				        @else
				        <label class="btn-success label">Verified</label>
				        @endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
						<label>Website</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
						{{ $business->website }}
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
						<label>Working Hours</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
						{!! nl2br(e($business->working_hours)) !!}
					</div>
				</div>
			</div>
			    @if($category_check==1 or $category_check==2)
				   <div class="business-right col-md-6">
				    <fieldset>
				    	<legend>User Portfolio Details</legend>
				    </fieldset>
				    <div class="row">
						<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
							<label>Maritial Status</label>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
							{{ $business->portfolio->maritial_status }}
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
							<label>Ocupation</label>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
							{{ $business->portfolio->occupation }}
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
							<label>Academic Status</label>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
							{{ $business->portfolio->acedimic_status }}
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
							<label>Key Skills</label>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
							{{ $business->portfolio->key_skills }}
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
							<label>Experience</label>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
							{{ $business->portfolio->experience_years }} Years {{ $business->portfolio->experience_months }} months
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
							<label>Height</label>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
							{{ $business->portfolio->height_feets }} feet {{ $business->portfolio->height_inches }} inches
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
							<label>Hair Type</label>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
							{{ $business->portfolio->hair_type }}
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
							<label>Hair Color</label>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
							{{ $business->portfolio->skin_color }}
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
							<label>Skin Color</label>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
							{{ $business->portfolio->hair_color }}
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
							<label>Professional Training</label>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
							@if($business->portfolio->professional_training) Yes @else No @endif
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
							<label>Institute Name</label>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
							{{ $business->portfolio->institute_name }}
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-4 profile_left">
							<label>Portfolio Images</label>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-8 profile_right">
							@if($business->portfolio->image!="")
				        		<div class="col-md-12">
					        		@foreach(explode('|',$business->portfolio->image) as $image)
					        			@if($image!="")
					        			<div class="col-md-3">
					        				<img src="{{asset(config('image.portfolio_image_url').'thumbnails/small/'.$image)}}" class="img">
					        			</div>
					        			@endif
					        		@endforeach
				        		</div>
				        	@endif
						</div>
					</div>
			    @endif    
		    </div>
		  <div class="business-right col-md-12">
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
		
				        <div class="pull-left"><a href="{{url('upload')}}"><button type="button" class="btn btn-info">Upload Document</button></a> </div>
			        @endif
				</dl>
		    </div>

		    <div class="comment-section col-md-12">
		    		<div class="icons_section">
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
				</div> 
				</div>
		</div>
    @else
        <p>Could not find any profile</p>
    @endif	
</div>
@endsection