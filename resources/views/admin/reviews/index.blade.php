@extends('admin.layouts.adminapp')
@section('title', $page)
@section('content')
	<h2>Business Reviews</h2>
	<hr>
	@include('notification')
	<table id="subscription_list" class="display">
		<thead>
			<tr>
				<th>Business ID</th>
				<th>Business Name</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($businesses as $business)
			<tr>
				<td>{{ $business->business_id}}</td>
				<td>{{ $business->title}}</td>
				<td>
					<ul class="list-inline">
						<li>
							<a href="{{ URL::to('admin/reviews/'.$business->id) }}">
			                    <button type="button" class="btn btn-default" title="View Reviews"><i class="fa fa-eye"></i></button>
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
		    $('#subscription_list').DataTable();
		} );
	</script>
@endsection