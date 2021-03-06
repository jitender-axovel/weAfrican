@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2>Edit Event Category</h2>
	<hr>
	@include('notification')
	<div class="panel panel-default">
		<div class="panel-body">
			<form id="category-form" action="{{ url('admin/category/event/'.$category->id) }}" method="POST" class="form-horizontal" enctype='multipart/form-data'>
				{{csrf_field()}}
				{{ method_field('PUT') }}
				<div class="form-group">
					<label class="control-label col-md-2">Category Name</label>
					<div class="col-md-4">
					<input type="text" class="form-control" name="title" value="{{ $category->title or old('title') }}" required>
						@if($errors->has('title'))
						<span class="help-block">
							<strong>{{ $errors->first('title') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Description</label>
					<div class="col-md-10">
						<textarea required class="form-control" name="description" >{{ $category->description or old('description') }}</textarea>
						@if($errors->has('description'))
							<span class="help-block">
								<strong>{{ $errors->first('description') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Image</label>
					<div class="col-md-10">
						<input type="file" name="image" id="image" >
						@if($errors->has('category_image'))
							<span class="help-block">
								<strong>{{ $errors->first('image') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<fieldset class="col-md-10 col-md-offset-2">
						<legend>Image Preview</legend>
						<div class="caption">
							<img id="preview" src="{{asset(config('image.event_category_image_url').'thumbnails/medium/'.$category->image)}}"/>
						</div>
					</fieldset>
				</div>
				<div class="form-group">
					<div class="col-md-4 col-md-offset-1">
						<button type="submit" class="btn btn-success" id="btn-login">Update Category</button>
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

		$("#image").change(function(){
			readURL(this);
		});
	</script>
@endsection
