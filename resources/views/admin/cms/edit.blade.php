@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2>Edit - {{$cmsPage->title}}</h2>
	<hr>
	@include('notification')
	<div class="panel panel-default">
		<div class="panel-body">
			<form action="{{ url('admin/cms/'.$cmsPage->id) }}" method="POST">
				{{csrf_field()}}
				<input type="hidden" name="_method" value="put" />
				<div class="form-group">
					<textarea class="form-control" name="content" rows="15">{{ $cmsPage->content ? $cmsPage->content : old('content') }}</textarea>
				</div>
				<button type="submit" class="btn btn-success btn-block" id="btn-login">Update Content</button>
				</div>
			</form>
		</div>
	</div>
@endsection
@section('scripts')
	<script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
	<script>
		tinymce.init({
			selector: 'textarea',
			menu: {
				view: {title: 'Enter Code', items: 'code'}
			},
			plugins: 'code, textpattern, textcolor',
			toolbar: [
				'undo redo | styleselect | bold italic | link image | alignleft aligncenter alignright alignjustify | fontselect | forecolor | backcolor'
			],
			theme_advanced_fonts: 'Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;AkrutiKndPadmini=Akpdmi-n',
		});
	</script>
@endsection