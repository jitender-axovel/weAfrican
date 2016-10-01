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
					{{ $business->bussiness_category_id}}
						
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
						{{ $business->address  }}
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
						{{ $business->phone_number or old('phone_number') }}
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
					<a href="{{asset(config('image.document_url').$business->identity_proof)}}" target="_blank">	<img src="{{asset(config('image.document_url').$business->identity_proof)}}" style="width:100px;height:100px;"/></a>
				<a href="{{ URL::to('admin/business/identity/proof/validate/'.$business->id) }}">
				
			                    @if($business->is_identity_proof_validate)
			                    <button type="button" class="btn btn-success" title="Unverified"><i class="fa fa-ban"></i></button>
			                    	
		                    	@else
		                    		<button type="button" class="btn btn-danger" title="Verified"><i class="fa fa-unlock"></i></button>
		                		@endif
		                    </a>
					</div>
					<label class="control-label col-md-2">Business Proof</label>
					<div class="col-md-4">
					<a href="{{asset(config('image.document_url').$business->business_proof)}}" target="_blank">	<img src="{{asset(config('image.document_url').$business->business_proof)}}" style="width:100px;height:100px;"/></a>
				<a href="{{ URL::to('admin/business/proof/validate/'.$business->id) }}">
			                    @if($business->is_business_proof_validate)
			                    <button type="button" class="btn btn-success" title="Unverified"><i class="fa fa-ban"></i></button>
			                    	
		                    	@else
		                    		<button type="button" class="btn btn-danger" title="Verified"><i class="fa fa-unlock"></i></button>
		                		@endif
		                    </a>
					</div>
				</div>
				@else
				<div class="form-group">	
					<div class="col-md-6">
						<p>User does not upload any document.</p>
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