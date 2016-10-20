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
			            <ul class="list-inline text-right">
						<li>
							<a href="{{ URL::to('admin/reviews/block/'.$review->id) }}">
			                    @if($review->is_blocked)
			                    	<button type="button" class="btn btn-danger" title="Unblock"><i class="fa fa-unlock"></i></button>
		                    	@else
		                    		<button type="button" class="btn btn-success" title="Block"><i class="fa fa-ban"></i></button>
		                		@endif
		                    </a>
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