@extends('layouts.app')
@section('content')
	<div class="main-container row">
		<h3 class="text-center">{{ $cmsPage->title }}</h3>
		<div class="col-md-10 col-md-offset-1">
			@if($cmsPage->content)
			{!! $cmsPage->content !!}
			@else
				<p class="text-center">{{ $cmsPage->title }}'s page content is still being prepared.</p>
			@endif
		</div>
	</div>
@endsection