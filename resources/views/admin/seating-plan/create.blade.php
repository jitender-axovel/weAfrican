@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2>Add New Event Seating Plan</h2>
	<hr>
	@include('notification')
	<div class="panel panel-default">
		<div class="panel-body">
			<form  id="category-form" action="{{ url('admin/seating-plan') }}" method="POST" class="form-horizontal" enctype='multipart/form-data'>
				{{csrf_field()}}
				<div class="form-group">
					<label class="control-label col-md-2">Seating Plan Name</label>
					<div class="col-md-4">
						<input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
						@if($errors->has('title'))
							<span class="help-block">
								<strong>{{ $errors->first('title') }}</strong>
							</span>
						@endif
					</div>
					<label class="control-label col-md-2">Confirm Seating Plan Name</label>
					<div class="col-md-4">
						<input type="text" class="form-control" name="confirm_title" value="" required >
						@if($errors->has('confirm_title'))
							<span class="help-block">
								<strong>{{ $errors->first('confirm_title') }}</strong>
							</span>
						@endif
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-md-2">Description</label>
					<div class="col-md-10">
						<textarea required class="form-control" name="description" >{{ old('description') }}</textarea>
						@if($errors->has('description'))
							<span class="help-block">
								<strong>{{ $errors->first('description') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-4 col-md-offset-1">
						<button type="submit" class="btn btn-success" id="btn-login">Create Seating Plan</button>
					</div>
				</div>
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

    $("#category_image").change(function(){
        readURL(this);
    });
	</script>
@endsection
