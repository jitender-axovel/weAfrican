@extends('admin.layouts.adminapp')
@section('title', $page)
@section('content')
	<h2>Banners</h2>
	<hr>
	@include('notification')
	<table id="subscription_list" class="display">
		<thead>
			<tr>
				<th>Business name</th>
				<th>Subscription Plan</th>
				<th>Coverage</th>
				<th>Banner</th>
				<th>Created On</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($banners as $banner)
			<tr>
				<td>{{ $banner->title}}</td>
				<td>{{ $banner->name}}</td>
				<td>@if($banner->country) Country: {{ $banner->country }} @elseif($banner->state) State: {{$banner->state}} @else  City: {{$banner->city}}  @endif
				</td>
				<td>{{ asset(config('image.banner_image_url').$banner->image) }}</td>
				<td>{{ date_format(date_create($banner->created_at), 'F d, Y') }}</td>
				<td>
					<ul class="list-inline">
						<!-- <li>
							<a class="btn btn-warning" href="{{ url('admin/banner/'.$banner->id.'/edit/') }}" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
						</li> -->
						<li>
							<a href="{{ URL::to('admin/banner/block/'.$banner->id) }}">
			                    @if ($banner->is_blocked)
			                    	<button type="button" class="btn btn-danger" title="UnBlock"><i class="fa fa-unlock"></i></button>
		                    	@else
		                    		<button type="button" class="btn btn-success" title="Block"><i class="fa fa-ban"></i></button>
	                    		@endif
			                </a>
						</li>
						<li>
							<form action="{{ url('admin/banner/'.$banner->id) }}" method="POST" onsubmit="deleteBanner('{{$banner->id}}', '{{$banner->title}}', event,this)">
								{{csrf_field()}}
								<button type="submit" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
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
		    $('#subscription_list').DataTable();
		} );
	</script>
@endsection
@section('scripts')
	<script type="text/javascript">
		function deleteBanner(id, title, event,form)
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