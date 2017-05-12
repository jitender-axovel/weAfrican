@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
<h2>View User Business</h2>
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
		<div class="panel-body">
				<div class="form-group">
					<label class="control-label col-md-2">Bussiness Title:</label>
					<div class="col-md-4">
					{{ $business->title  }}
						
					</div>
					<label class="control-label col-md-2">Category</label>
					<div class="col-md-4">
					{{ $business->category->title}}
						
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Bussiness keywords:</label>
					<div class="col-md-4">
					{{ $business->keywords  }}
						
					</div>
					
					<label class="control-label col-md-2">Website</label>
					<div class="col-md-4">
						{{ $business->website or old('website') }}
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Address:</label>
					<div class="col-md-4">
					{{ $business->address  }}
					</div>
					<label class="control-label col-md-2">City:</label>
					<div class="col-md-4">
						{{ $business->city  }}
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">State:</label>
					<div class="col-md-4">
						{{ $business->state }}
					</div>
					<label class="control-label col-md-2">Country:</label>
					<div class="col-md-4">
					{{ $business->country or old('country') }}
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Pin code:</label>
					<div class="col-md-4">
						{{ $business->pin_code or old('pin_code') }}
					</div>
					<label class="control-label col-md-2">Email:</label>
					<div class="col-md-4">
					{{ $business->email or old('email') }}
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Primary Mobile Number:</label>
					<div class="col-md-4">
						{{ $business->mobile_number or old('mobile_number') }}
					</div>
					<label class="control-label col-md-2">Secondary Mobile Number:</label>
					<div class="col-md-4">
					{{ $business->secondary_phone_number }}
					</div>
				</div>
				<div class="form-group">	
					<label class="control-label col-md-2">About Us:</label>
					<div class="col-md-4">
						{{ $business->about_us }}
					</div>
					<label class="control-label col-md-2">Working Hours</label>
					<div class="col-md-4">
						{{ $business->working_hours or old('working_hours') }}
					</div>
				</div>
				@if($business->business_proof)
				<div class="form-group">	
					<label class="control-label col-md-2">Identity Proof</label>
					<div class="col-md-4">
						<a href="{{asset(config('image.document_url').$business->identity_proof)}}" target="_blank">	
							<i class="fa fa-file-text fa-2x" aria-hidden="true" title="see document"></i>
						</a>
						<div class="verified">
							<a href="{{ URL::to('admin/business/identity/proof/validate/'.$business->id) }}">
							@if($business->is_identity_proof_validate)
			                    <button type="button" class="btn btn-danger" title="Unverified">Unverified</button>
	                    	@else
	                    		<button type="button" class="btn btn-success" title="Verified">Verified</button>
	                		@endif
		                    </a>
	                    </div>
					</div>
					<label class="control-label col-md-2">Business Proof</label>
					<div class="col-md-4">
						<a href="{{asset(config('image.document_url').$business->business_proof)}}" target="_blank">	
							<i class="fa fa-file-text fa-2x" aria-hidden="true"></i>
						</a>
						<div class="verified">
							<a href="{{ URL::to('admin/business/proof/validate/'.$business->id) }}">
		                    @if($business->is_business_proof_validate)
			                    <button type="button" class="btn btn-danger" title="Unverified">Unverified</button>
	                    	@else
	                    		<button type="button" class="btn btn-success" title="Verified">Verified</button>
		                		@endif
		                    </a>
	                    </div>
					</div>
				</div>
				@else
				<div class="form-group">
					<label class="control-label col-md-2">Business Proof</label>	
					<div class="col-md-4">
						<p>User does not upload Identity Proof yet.</p>
					</div>
					<label class="control-label col-md-2">Identity Proof</label>	
					<div class="col-md-4">
						<p>User does not upload Business Proof yet.</p>
					</div>
				</div>
				@endif
		</div>
	</div>
<style>
.form-group {
  overflow: hidden;
}
</style>
@endsection