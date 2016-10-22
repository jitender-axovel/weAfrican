@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2>Cms Pages</h2>
	<hr>
	@include('notification')
	<table id="categories_list" class="display">
		<thead>
			<tr>
				<th>Title</th>
				<th>Created On</th>
				<th>URL</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($cmsPages as $cmsPage)
			<tr>
				<td>{{ $cmsPage->title}}</td>
				<td>{{ date_format(date_create($cmsPage->created_at), 'd M,Y') }}</td>
				<td>
					<a href="{{ url('cms/'.$cmsPage->slug) }}" class="btn btn-success" title="Visit" target="_blank"><i class="fa fa-eye"></i></a>
				</td>
				<td>
					<a class="btn btn-info" href="{{ url('admin/cms/'.$cmsPage->id.'/edit/') }}" title="Edit"><i class="fa fa-pencil"></i></a>
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