@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2>View Users Conversations</h2>
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
		    @if($conversations->count())
			    @foreach($conversations as $key => $conversation)
			    <div class="form-group">
			        <label class="control-label col-md-2">{{ $conversation->sender->full_name}}</label>
			        <div class="col-md-10">
			            {{ $conversation->message }}
			        </div>
			    </div>
			    @endforeach
			@else
			    <div class="form-group">
			    No conversation found.
			    </div>
		    @endif
		</div>
	</div>
@endsection