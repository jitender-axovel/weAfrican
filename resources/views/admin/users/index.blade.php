@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2>Users</h2>
	<hr>
	@include('notification')
	<table id="users_list" class="display">
		<thead>
			<tr>
				<th>Name</th>
				<th>Mobile No.</th>
				<th>Role</th>
				<th>Mobile Verified</th>
				<th>Created On</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($users as $user)
			<tr>
				<td>{{ $user->full_name}}</td>
				<td>{{ '+' . $user->country_code . '-' . $user->mobile_number }}</td>
				<td>{{ $user->role->name }}</td>
				<td>
					@if($user->is_verified==0)
						Not Verified
					@else
						Verified
					@endif
				</td>
				<td>{{ date_format(date_create($user->created_at), 'd M,Y') }}</td>
				<td>
					<ul class="list-inline">
						@if($user->user_role_id == 4)
						<li>
							<a class="btn btn-info" href="{{url('admin/users/'.$user->id)}}" title="Add business"><i class="fa fa-user-plus" aria-hidden="true"></i>
							</a>
						</li>
						@endif
						<li>
							<a href="{{ url('admin/user/blocked/'.$user->id) }}">
			                    @if($user->is_blocked)
			                    	<button type="button" class="btn btn-danger" title="Unblock"><i class="fa fa-unlock"></i></button>
			                	@else
			                		<button type="button" class="btn btn-success" title="Block"><i class="fa fa-ban"></i></button>
			            		@endif
			        		</a>
						</li>
						<li>
							<a class="btn btn-warning" href="{{ url('admin/users/'.$user->id.'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
						</li>
						<li>
							<form action="{{ url('admin/users/'.$user->id) }}" method="POST" onsubmit="deleteCategory('{{$user->id}}', '{{$user->full_name}}', event,this)">
								{{csrf_field()}}
								{{ method_field('DELETE') }}
								<button type="submit" class="btn btn-danger" title="Delete"><i class="fa fa-trash-o"></i></button>
							</form>
						</li>
					</ul>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<script type="text/javascript">
		$(document).ready( function () {
		    $('#users_list').DataTable();
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