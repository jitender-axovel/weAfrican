@extends('admin.layouts.adminapp')
@section('title', $page)
@section('content')
	<h2>Add New Advertisement Plan</h2>
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
			<p class="bold">Create New Advertisement Plan</p>
		</div>
		<div class="panel-body">
			<form  id="category-form" action="{{ url('admin/advertisement/plan') }}" method="POST" class="form-horizontal">
				{{csrf_field()}}
				<div class="form-group">
					<label class="control-label col-md-2">City</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="city_id" value="{{ old('city_id')}}" required>
						@if($errors->has('city_id'))
							<span class="help-block">
								<strong>{{ $errors->first('city_id') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Advertisement Plan Name</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
						@if($errors->has('name'))
							<span class="help-block">
								<strong>{{ $errors->first('name') }}</strong>
							</span>
						@endif
					</div>
				</div>
					
				<div class="form-group">
					<div class="col-md-12">
						<button type="submit" class="btn btn-default col-md-offset-2" id="btn-login">Create Advertisement Plan</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
@section('scripts')
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
									text: "The Advertisement Plan has been saved. Press ok to continue",
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