@extends('admin.layouts.adminapp')
@section('title', $page)
@section('content')
	<h2>Add New Category</h2>
	<hr>
	
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
			<p class="bold">Create New Category</p>
		</div>
		<div class="panel-body">
			<form  id="category-form" action="{{ url('admin/category') }}" method="POST" class="form-horizontal">
				{{csrf_field()}}
				<div class="form-group">
					<label class="control-label col-md-2">Category Name</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
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
					<div class="col-md-12">
						<button type="submit" class="btn btn-default col-md-offset-2" id="btn-login">Create Category</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
@section('scripts')
	<script type="text/javascript" src="{{ asset('js/fine-uploader/jquery.fine-uploader.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/fine-uploader/category.js') }}"></script>

	<script type="text/javascript">
        $(document).ready(function() {
			$('#category-form').submit(function(event) {
				event.preventDefault();
				var actionUrl = $(this).attr('action');
				$.ajax({
					type: 'POST',
					url: actionUrl,
					data: $(this).serialize(),
					success: function(data) {
						var data = JSON.parse(data);
						if(data.status == 'success') {
							swal({
									title: "Done",
									text: "The category data has been saved. Press ok to continue",
									type: "success",
									showCancelButton: false,
									confirmButtonColor: "#DD6B55",
									confirmButtonText: "Ok",
									closeOnConfirm: false,
									allowEscapeKey: false,
								},
								function(isConfirm){
									if(isConfirm) {
										window.location = data.url;
									}
							});
						} else {
							swal({
									title: "Opppsss",
									text: data.response,
									type: "error",
									showCancelButton: false,
									confirmButtonColor: "#DD6B55",
									confirmButtonText: "Ok",
									closeOnConfirm: false,
								},
								function() {
									window.location.reload();
							});
						}
					}
				});
			});
        });
	</script>
@endsection