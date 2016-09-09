@extends('admin.layouts.adminapp')
@section('title', $page)
@section('content')
	<h2>Edit  Category</h2>
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
		<div class="panel-heading">
			<p class="bold">Edit Category</p>
		</div>
		<div class="panel-body">
			<form  id="category-form" action="{{ url('admin/bussiness/category/'.$category->id) }}" method="POST" class="form-horizontal" enctype='multipart/form-data'>
				{{csrf_field()}}
				<input type="hidden" name="_method" value="put" />
				<div class="form-group">
					<label class="control-label col-md-2">Category Name</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="title" value="{{ $category->title }}" required>
						@if($errors->has('title'))
							<span class="help-block">
								<strong>{{ $errors->first('title') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Confirm Name</label>
					<div class="col-md-10">
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
						<textarea required class="form-control" name="description" >{{$category->description}}</textarea>
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
						 <img src="{{asset(config('image.upload_image_url').$category->image)}}"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Image</label>
					<div class="col-md-10">
						 <input type="file" name="category_image" id="category_image" >
                         <img src="#" alt="Category Image Preview"  id="preview">
						@if($errors->has('category_image'))
							<span class="help-block">
								<strong>{{ $errors->first('category_image') }}</strong>
							</span>
						@endif
					</div>
				</div>							
				<div class="form-group">
					<div class="col-md-12">
						<button type="submit" class="btn btn-default col-md-offset-2" id="btn-login">Update Category</button>
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
