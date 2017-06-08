@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2>Add User Business</h2>
	<hr>
	@include('notification')
	<div class="panel panel-default">
		<div class="panel-body">
			<form id="category-form" action="{{ url('admin/users')}}" method="POST" class="form-horizontal" enctype='multipart/form-data'>
				{{csrf_field()}}
				<input type="hidden" class="form-control" name="id" value="{{ $user->id }}" required>
				<div class="form-group">
					<label class="control-label col-md-2">Full Name:</label>
					<div class="col-md-4">
						{{$user->first_name}} {{$user->middle_name}} {{$user->last_name}}
					</div>
					<label class="control-label col-md-2">Category</label>
					<div class="col-md-4">
						<select required class="form-control" name="bussiness_category_id" id="bussiness_category_id" required>
							<option value="" selected>Select category</option>
							@foreach($categories as $category)
								<option value="{{ $category->id }}" @if($category->title == old('bussiness_category_id')){{ 'selected'}} @endif >{{ $category->title }}</option>
							@endforeach
						</select>
						@if($errors->has('bussiness_category_id'))
						<span class="help-block">
							<strong>{{ $errors->first('bussiness_category_id') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Bussiness Title:</label>
					<div class="col-md-4">
					<input type="text" class="form-control" name="title" value="{{old('title') }}" required>
						@if($errors->has('title'))
						<span class="help-block">
							<strong>{{ $errors->first('title') }}</strong>
						</span>
						@endif
					</div>
					<div id="subcategory" style="display: none">
						<label for="subcategory" class="col-md-2 control-label required">Sub Category:</label>
                        <div class="col-md-4">
                            <select name="bussiness_subcategory_id" id="bussiness_subcategory_id" class="form-control selectpicker">
                                <option value="" selected>Select Sub Category</option>
                            </select>
                            @if ($errors->has('bussiness_subcategory_id'))
                                <span class="help-block">
                                <strong>{{ $errors->first('bussiness_subcategory_id') }}</strong>
                                </span>
                            @endif
                        </div>
					</div>
					
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Bussiness keywords:</label>
					<div class="col-md-4">
					<input type="text" class="form-control" name="keywords" value="{{ old('keywords') }}" required>
						@if($errors->has('keywords'))
						<span class="help-block">
							<strong>{{ $errors->first('keywords') }}</strong>
						</span>
						@endif
					</div>
					<label class="control-label col-md-2">About Us:</label>
					<div class="col-md-4">
						<input type="text" class="form-control" name="about_us" value="{{ old('about_us') }}" >
						@if($errors->has('about_us'))
						<span class="help-block">
							<strong>{{ $errors->first('about_us') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Address:</label>
					<div class="col-md-4">
					<input type="text" class="form-control" name="address" value="{{ old('address') }}">
						@if($errors->has('address'))
						<span class="help-block">
							<strong>{{ $errors->first('address') }}</strong>
						</span>
						@endif
					</div>
					<label class="control-label col-md-2">City:</label>
					<div class="col-md-4">
						<input type="text" class="form-control" name="city" value="{{ old('city') }}" >
						@if($errors->has('city'))
						<span class="help-block">
							<strong>{{ $errors->first('city') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">State:</label>
					<div class="col-md-4">
						<input type="text" class="form-control" name="state" value="{{ old('state') }}">
						@if($errors->has('state'))
						<span class="help-block">
							<strong>{{ $errors->first('state') }}</strong>
						</span>
						@endif
					</div>
					<label class="control-label col-md-2">Country:</label>
					<div class="col-md-4">
					<input type="text" class="form-control" name="country" value="{{ old('country') }}">
						@if($errors->has('country'))
						<span class="help-block">
							<strong>{{ $errors->first('country') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Pin Code: (format:110075)</label>
					<div class="col-md-4">
						<input type="text" class="form-control" name="pin_code" value="{{ old('pin_code') }}" required>
						@if($errors->has('pin_code'))
						<span class="help-block">
							<strong>{{ $errors->first('pin_code') }}</strong>
						</span>
						@endif
					</div>
					<label class="control-label col-md-2">Email:</label>
					<div class="col-md-4">
					<input type="text" class="form-control" name="email" value="{{ $user->email}}" required>
						@if($errors->has('email'))
						<span class="help-block">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Mobile Number:</label>
					<div class="col-md-4">
						<input type="text" class="form-control" name="mobile_number" value="{{ $user->mobile_number}}">
						@if($errors->has('mobile_number'))
						<span class="help-block">
							<strong>{{ $errors->first('mobile_number') }}</strong>
						</span>
						@endif
					</div>
					<label class="control-label col-md-2">Website</label>
					<div class="col-md-4">
						<input type="text" class="form-control" name="website" value="{{ old('website') }}">
						@if($errors->has('website'))
						<span class="help-block">
							<strong>{{ $errors->first('website') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group">	
					<label class="control-label col-md-2">Working Hours</label>
					<div class="col-md-4">
						<input type="text" class="form-control" name="website" value="{{ old('working_hours') }}">
						@if($errors->has('working_hours'))
						<span class="help-block">
							<strong>{{ $errors->first('working_hours') }}</strong>
						</span>
						@endif
					</div>
				</div>
				  <div class="form-group">
                <label for="business_logo" class="col-md-2 control-label">Edit Business Logo:</label>
                <div class="col-md-4">
                    <input type="file" name="business_logo" id="business_logo">
                    @if ($errors->has('business_logo'))
                        <span class="help-block">
                        <strong>{{ $errors->first('business_logo') }}</strong>
                        </span>
                    @endif
                </div>
                <label for="logo_preview" class="col-md-2 control-label">
                Logo Preview:
                </label>
                <div class="col-md-4">
                    <img src="#" alt=""  id="preview">
                </div>
            </div>
				<button type="submit" class="btn btn-success" id="btn-login">Create User Business</button>
			</form>
		</div>
	</div>
@endsection
@section('scripts')
<script type="text/javascript">
    function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
          }
        reader.readAsDataURL(input.files[0]);
      }
    }
    
    $("#business_logo").change(function(){
        readURL(this);
    });
    $('#bussiness_category_id').on('change', function() {
        if(this.value!=""){
            $.ajax({
                type:'POST',
                url: '{{ url("subcategory") }}',
                data:{
                    _token: "{{ csrf_token() }}",
                    user_role : 3,
                    category : this.value,
                },success:function(response)
                {
                    $('#bussiness_subcategory_id').find('option').not(':first').remove();
                    $('#subcategory').show();
                    $('#bussiness_subcategory_id').attr('required', false);
                    var subcategory = JSON.parse(response);
                    if(Object.keys(subcategory).length>0)
                    {
                        for(key in subcategory){
                            $('#bussiness_subcategory_id').append($("<option></option>").attr("value",key).text(subcategory[key]));
                        }
                        $('#subcategory').show();
                        $('#bussiness_subcategory_id').attr('required', true);
                    }else
                    {
                        $('#subcategory').hide();
                    }
                }
            });
        }else
        {
            $('#bussiness_subcategory_id').find('option').not(':first').remove();
            $('#bussiness_subcategory_id').attr('required', false);
            $('#subcategory').hide();
        }
    });
</script>
@endsection