@extends('admin.layouts.adminapp')
@section('title', $page)
@section('content')
	<h2>View Business Reviews</h2>
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
	<div class="panel panel-default">
		<div class="panel-body">
		    @if($reviews->count())
			    @foreach($reviews as $key => $review)
			    <div class="form-group">
			        <label class="control-label col-md-2">Review {{++$key}}:</label>
			        <div class="col-md-10">
			            {{ $review->review  }}
			            <ul class="list-inline">
						<li>
							<a href="{{ URL::to('admin/reviews/block/'.$review->id) }}">
			                    @if($review->is_blocked)
			                    	<button type="button" class="btn btn-danger" title="Unblock"><i class="fa fa-unlock"></i></button>
		                    	@else
		                    		<button type="button" class="btn btn-success" title="Block"><i class="fa fa-ban"></i></button>
		                		@endif
		                    </a>
						</li>
						<li>
							<form action="{{ url('admin/reviews/'.$review->id) }}" method="POST" onsubmit="deleteReview('{{$review->id}}', '{{$review->review}}', event,this)">
								{{csrf_field()}}
								<button type="submit" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
							</form>
						</li>
					</ul>
			        </div>
			    </div>
			    @endforeach
			@else
			    <div class="form-group">
			    No reviews found.
			    </div>
		    @endif
		</div>
	</div>
@endsection
@section('scripts')
	<script type="text/javascript">
		function deleteReview(id, name, event,form)
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