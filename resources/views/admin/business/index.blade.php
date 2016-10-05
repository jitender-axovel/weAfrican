@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2>User Business</h2>
	<hr>
	@include('notification')
	<table id="categories_list" class="display">
		<thead>
			<tr>
				<th>Business Name</th>
				<th>Mobile Number</th>
				<th>Created On</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($businesses as $business)
			<tr>
				<td>{{ $business->title}}</td>
				<td>{{ $business->mobile_number}}</td>
				<td>{{ date_format(date_create($business->created_at), 'F d, Y') }}</td>
				<td>
					<ul class="list-inline">
						<li>
							<a href="{{ URL::to('admin/business/block/'.$business->id) }}">
			                    @if($business->is_blocked)
			                    	<button type="button" class="btn btn-danger" title="Unblock"><i class="fa fa-unlock"></i></button>
		                    	@else
		                    		<button type="button" class="btn btn-success" title="Block"><i class="fa fa-ban"></i></button>
		                		@endif
		                    </a>
						</li>
						<li>
							<a class="btn btn-warning" href="{{ url('admin/business/'.$business->id.'/edit') }}" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
						</li>
						<li>
							<a class="btn btn-default" href="{{ url('admin/business/'.$business->id) }}" title="View"><i class="fa fa-eye" aria-hidden="true"></i>
</a>
						</li>
					</ul>
				</td>
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