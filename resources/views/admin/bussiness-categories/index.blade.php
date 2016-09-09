@extends('admin.layouts.adminapp')
@section('title', $page)
@section('content')
	<h2>Categories</h2>
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
	<table id="categories_list" class="display">
		<thead>
			<tr>
				<th>Title</th>
				<th>Description</th>
				<th>Icon</th>
				<th>Created On</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($categories as $category)
			<tr>
				<td>{{ $category->title}}</td>
				<td>{{ $category->description }}
				<td><img src="{{asset(config('image.upload_image_url').$category->image)}}" style="width:100px;height:100px;"/>
				</td>
				<td>{{ date_format(date_create($category->created_at), 'F d, Y') }}</td>
				<td>
                <a href="{{ url('admin/bussiness/category/'.$category->id.'/edit/') }}"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true" title = "Edit"></i></a>
				<a href="{{ URL::to('admin/bussiness/category/block/'.$category->id) }}">
                    @if($category->is_blocked) <button type="button" class="btn btn-danger">Unblock</button> @else <button type="button" class="btn btn-success">Block</button> @endif </a>
				<form action="{{ url('admin/bussiness/category/'.$category->id) }}" method="POST" class="form-horizontal" onsubmit="deleteCategory('{{$category->id}}', '{{$category->title}}', event,this)">
						{{csrf_field()}}
						<input type="hidden" name="method" value="DELETE">
						<button type="submit" class=""><i class="fa fa-trash-o" aria-hidden="true" title="Delete"></i>
						</button>
					</form></td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<script type="text/javascript">
		$(document).ready( function () {
		    $('#categories_list').DataTable();
		} );
	</script>
@endsection
@section('scripts')
	<script type="text/javascript">
		function deleteCategory(id, title, event,form)
		{   

			event.preventDefault();
			swal({
				title: "Are you sure?",
				text: "You want to delete "+title,
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
					swal("Cancelled", title+"'s record will not be deleted.", "error");
				}
			});
		}
	</script>
@endsection