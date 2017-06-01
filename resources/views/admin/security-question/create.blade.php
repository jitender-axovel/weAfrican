@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2>Add New Event Seating Plan</h2>
	<hr>
	@include('notification')
	<div class="panel panel-default">
		<div class="panel-body">
			<form  id="category-form" action="{{ url('admin/security-question') }}" method="POST" class="form-horizontal" enctype='multipart/form-data'>
				{{csrf_field()}}
				<div class="form-group">
					<label class="control-label col-md-2">Security Question</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="question" value="{{ old('question') }}" required>
						@if($errors->has('question'))
							<span class="help-block">
								<strong>{{ $errors->first('question') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Confirm Security Question</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="confirm_question" value="" required >
						@if($errors->has('confirm_question'))
							<span class="help-block">
								<strong>{{ $errors->first('confirm_question') }}</strong>
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
