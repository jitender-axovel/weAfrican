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
				<td>{{ date_format(date_create($user->created_at), 'F d, Y') }}</td>
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