@extends('admin.layouts.adminapp')
@section('title', $page)
@section('content')
	<h2>Banners</h2>
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
	<table id="subscription_list" class="display">
		<thead>
			<tr>
				<th>City</th>
				<th>Name</th>
				<th>Created On</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($banners as $banner)
			<tr>
				<td>{{ $banner->city_id}}</td>
				<td>{{ $banner->name}}</td>
				<td>{{ date_format(date_create($banner->created_at), 'F d, Y') }}</td>
				<td>
				<a class="btn btn-info" href="{{ url('admin/banner/'.$banner->id.'/edit/') }}">Edit</a>
				<a href="{{ URL::to('admin/banner/activated/'.$banner->id) }}">
                    @if ($banner->is_activated) <button type="button" class="btn btn-danger">Inactive</button> @else <button type="button" class="btn btn-success">Active</button> @endif </a>
				<form action="{{ url('admin/banner/'.$banner->id) }}" method="POST" class="form-horizontal" onsubmit="deleteBanner('{{$banner->id}}', '{{$banner->name}}', event,this)">
						{{csrf_field()}}
						<input type="hidden" name="method" value="DELETE">
						<button type="submit" class="btn btn-danger">Delete</button>
					</form></td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<script type="text/javascript">
		$(document).ready( function () {
		    $('#subscription_list').DataTable();
		} );
	</script>
@endsection
@section('scripts')
	<script type="text/javascript">
		function deleteBanner(id, name, event,form)
		{   

			event.preventDefault();
			swal({
				title: "Are you sure?",
				text: "You want to delete "+name,
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel pls!",
				closeOnConfirm: false,
				closeOnCancel: false,
				allowEscapeKey: false,
			},
			function(isConfirm){
				if(isConfirm) {
					$.ajax({
						url: $(form).attr('action'),
            			data: $(form).serialize(),
						type: 'DELETE',
						success: function(data) {
							data = JSON.parse(data);
							if(data['status']) {
								swal({
									title: data['message'],
									text: "Press ok to continue",
									type: "success",
									showCancelButton: false,
									confirmButtonColor: "#DD6B55",
									confirmButtonText: "Ok",
									closeOnConfirm: false,
									allowEscapeKey: false,
								},
								function(isConfirm){
									if(isConfirm) {
										window.location.reload();
									}
								});
							} else {
								swal("Error", data['message'], "error");
							}
						}
					});
				} else {
					swal("Cancelled", name+"'s record will not be deleted.", "error");
				}
			});
		}
	</script>
@endsection
						