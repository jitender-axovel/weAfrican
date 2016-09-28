@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
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
			<div class="row">
				<label class="control-label col-sm-2" for="business_name">Business name:</label>
				<div class="col-sm-10">
					{{$business->title}}
				</div>
			</div>	
			<div class="row">
				<label class="control-label col-sm-2" for="category">Category:</label>
				<div class="col-sm-10">
					{{ $business->bussiness_category_id}}
				</div>
			</div>
			<div class="row">
				<label class="control-label col-sm-2" for="business_name">Bussiness keywords</label>
				<div class="col-sm-10">
					{{ $business->keywords }}
				</div>
			</div>
			<div class="row">
				<label class="control-label col-sm-2" for="about_us">About Us:</label>
				<div class="col-sm-10">
					{{ $business->about_us }}
				</div>
			</div>
			<div class="row">
				<label class="control-label col-sm-2" for="address">Address:</label>
				<div class="col-sm-10">
					{{ $business->address }}
				</div>
			</div>
			<div class="row">
				<label class="control-label col-sm-2" for="city">City:</label>
				<div class="col-sm-10">
					{{ $business->city }}
				</div>
			</div>
			<div class="row">
				<label class="control-label col-sm-2" for="state">State:</label>
				<div class="col-sm-10">
					{{ $business->state }}
				</div>
			</div>
			<div class="row">
				<label class="control-label col-sm-2" for="country">Country:</label>
				<div class="col-sm-10">
					{{ $business->country }}
				</div>
			</div>
			<div class="row">
				<label class="control-label col-sm-2" for="pin_code">Pin code:</label>
				<div class="col-sm-10">
					{{ $business->pin_code }}
				</div>
			</div>
			<div class="row">
				<label class="control-label col-sm-2" for="email">Email:</label>
				<div class="col-sm-10">
					{{ $business->email }}
				</div>
			</div>
			<div class="row">
				<label class="control-label col-sm-2" for="phone_number">Primary Mobile Number:</label>
				<div class="col-sm-10">
					{{ $business->phone_number }}
				</div>
			</div>
			<div class="row">
				<label class="control-label col-sm-2" for="secondary_phone_number">Secondary Mobile Number:</label>
				<div class="col-sm-10">
					{{ $business->secondary_phone_number }}
				</div>
			</div>
			<div class="row">
				<label class="control-label col-sm-2" for="website">Website:</label>
				<div class="col-sm-10">
					{{ $business->website }}
				</div>
			</div>
			<div class="row">
				<label class="control-label col-sm-2" for="working_hours">Working Hours:</label>
				<div class="col-sm-10">
					{{ $business->working_hours }}
				</div>
			</div>
	</div>
@endsection