@extends('layouts.app')
@section('title', $pageTitle)
@section('content')

<div class="main-container row">

	<div class="register-business">
		<h5 class="text-left">Register Business</h5>
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
		<form id="register-form" class="form-horizontal" action="{{ url('upload-document') }}" method="POST" enctype='multipart/form-data'>
		{{csrf_field()}}
		 	<div class="row">
		 	<h6>Please upload documents </h6>
        		<div class="col-md-6 form-group">
            		<label>Please upload Identity Proof here</label>
            		<input required type="file" name="identity_proof" id="identity_proof" required>
					@if($errors->has('identity_proof'))
						<span class="help-block">
							<strong>{{ $errors->first('identity_proof') }}</strong>
						</span>
					@endif
				</div>
		        <div class="col-md-6 form-group">
		            <label>Please upload Business Proof here</label>
		            <input required type="file" name="business_proof" id="business_proof" required>
					@if($errors->has('business_proof'))
						<span class="help-block">
							<strong>{{ $errors->first('business_proof') }}</strong>
						</span>
					@endif
		        </div>
		        <!-- <div class="col-md-6  form-group">
		        	<label class="col-md-6">Image Preview</label>
					<div class="caption col-md-6 col-md-offset-1">
						<img src="#" alt=""  id="preview_identity">
					</div>
				</div>
			  	<div class="col-md-6 form-group">
					<label class="col-md-6">Image Preview</label>
					<div class="caption col-md-6 col-md-offset-1">
						<img src="#" alt=""  id="preview_business">
					</div>
				</div> -->
		         <div class="col-md-6 form-group">
		            <button type="submit" class="btn btn-default">Submit</button>
		        </div>
    		</div>
		</form>
		<div class="row">
			<div class="col-xs-6>
		 		
			<button class="btn btn-default"> <a href="{{ url('register-business/'.Auth::id()) }}">Later</a></button>
			</div>
		</div>
	</div>
</div>
@endsection