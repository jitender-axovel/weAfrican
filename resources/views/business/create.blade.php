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
	<h3 class="text-center">Register Business</h3>
	<form id="register-form" class="form-horizontal" action="{{ url('register-business') }}" method="POST">
        {{csrf_field()}}
		<div class="form-group">
			<label class="control-label col-sm-2" for="business_name">Business name:</label>
			<div class="col-sm-10">
				<input  type="text" class="form-control" name="title" value="{{old('title')}}">
			</div>
		</div>	
		<div class="form-group">
			<label class="control-label col-sm-2" for="category">Category:</label>
			<div class="col-sm-10">
				<select required name="bussiness_category_id" required>
					<option value="" selected>Select category</option>
					@foreach($categories as $category)
						<option value="{{ $category->id }}" >{{ $category->title }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="business_name">Bussiness keywords</label>
			<div class="col-sm-10">
				<input required type="text" class="form-control" name="keywords" value="{{old('keywords')}}">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="about_us">About Us:</label>
			<div class="col-sm-10">
				<textarea required class="form-control" name="about_us" value="{{old('about_us')}}"></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="address">Address:</label>
			<div class="col-sm-10">
				<input required type="text" class="form-control" name="address" value="{{old('address')}}">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="city">City:</label>
			<div class="col-sm-10">
				<input required type="text" class="form-control" name="city" value="{{old('city')}}">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="state">State:</label>
			<div class="col-sm-10">
				<input required type="text" class="form-control" name="state" value="{{old('state')}}">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="country">Country:</label>
			<div class="col-sm-10">
				<input required type="text" class="form-control" name="country" value="{{old('country')}}">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="pin_code">Pin code:</label>
			<div class="col-sm-10">
				<input required type="number" class="form-control" name="pin_code" value="{{old('pin_code')}}" >
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="email">Email:</label>
			<div class="col-sm-10">
				<input required type="email" class="form-control" name="email" value="{{old('email')}}">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="phone_number">Primary Mobile Number:</label>
			<div class="col-sm-10">
				<input required type="number" class="form-control" name="phone_number" value="{{old('phone_number')}}">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="secondary_phone_number">Secondary Mobile Number:</label>
			<div class="col-sm-10">
				<input required type="number" class="form-control" name="secondary_phone_number" value="{{old('secondary_phone_number')}}">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="website">Website</label>
			<div class="col-sm-10">
				<input required type="text" class="form-control" name="website" value="{{old('website')}}">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="working_hours">Working Hours:</label>
			<div class="col-sm-10">
				<textarea required class="form-control" name="working_hours" ></textarea>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<div class="checkbox">
					<label><input type="checkbox" name="is_agree_to_terms" value="{{old('is_agree_to_terms')}}"> I hereby declare, that I have read and accepted the Terms & Conditions.</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">Submit</button>
			</div>
		</div>
	</form>
</div>
@endsection