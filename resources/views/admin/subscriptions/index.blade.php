@extends('admin.layouts.adminapp')
@section('title', $page)
@section('content')
	<h2>Subscription Plans</h2>
	<hr>
	@include('notification')
	<table id="subscription_list" class="display">
		<thead>
			<tr>
				<th>Name</th>
				<th>Product Limit</th>
				<th>Service Limit</th>
				<th>Price (per month)</th>
				<th>Created On</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($subscriptions as $subscription)
			<tr>
				<td>{{ $subscription->title}}</td>
				<td>{{ $subscription->product_limit}}</td>
                <td>{{ $subscription->service_limit}}</td>
                <td>{{ $subscription->price}}</td>
				<td>{{ date_format(date_create($subscription->created_at), 'F d, Y') }}</td>
				<td>
					<a class="btn btn-info" href="{{ url('admin/subscription/plan/'.$subscription->id.'/edit/') }}" title="Edit"><i class="fa fa-pencil"></i></a>
					<a href="{{ URL::to('admin/subscription/plan/block/'.$subscription->id) }}">
	                    @if($subscription->is_blocked)
	                    	<button type="button" class="btn btn-danger" title="Unblock"><i class="fa fa-unlock"></i></button>
	                	@else
	                		<button type="button" class="btn btn-success" title="Block"><i class="fa fa-ban"></i></button>
	            		@endif
	        		</a>
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