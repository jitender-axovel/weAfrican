@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2>Products</h2>
	<hr>
	@include('notification')
	<table id="subscription_list" class="display">
		<thead>
			<tr>
				<th>Business ID</th>
				<th>Business Name</th>
				<th>Name</th>
				<th>Description</th>
				<th>Price</th>
				<th>Image</th>
				<th>Created On</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($products as $product) 
			<tr>
				<td>{{ $product->business_id}}</td>
				<td>{{ $product->business_name}}</td>
				<td>{{ $product->title}}  </td>
				<td>{{ $product->description}}</td>
                <td>{{ $product->price}}</td>
                <td>
                	@if(explode('|',$product->image)[0]!="")
                		<img src="{{asset(config('image.product_image_url').'thumbnails/small/'.explode('|',$product->image)[0])}}"/>
                	@else
                		<img src="{{asset('images/no-image.jpg')}}"/>
                	@endif
                </td>
				<td>{{ date_format(date_create($product->created_at), 'd M,Y') }}</td>
				<td>
					<a href="{{ URL::to('admin/product/block/'.$product->id) }}">
	                    @if($product->is_blocked)
	                    	<button type="button" class="btn btn-danger" title="Unblock"><i class="fa fa-unlock"></i></button>
	                	@else
	                		<button type="button" class="btn btn-success" title="Block"><i class="fa fa-ban"></i></button>
	            		@endif
	        		</a>
	        		<form action="{{ url('admin/product/'.$product->id) }}" method="POST" onsubmit="deleteProduct('{{$product->id}}', '{{$product->title}}', event,this)">
								{{csrf_field()}}
								{{ method_field('DELETE') }}
								<button type="submit" class="btn btn-danger" title="Delete"><i class="fa fa-trash-o"></i></button>
					</form>
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
		function deleteProduct(id, title, event,form)
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