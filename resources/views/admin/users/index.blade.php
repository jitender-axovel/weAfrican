@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2>Users</h2>
	<hr>
	@include('notification')
	<br>
	<form id="form1" action="{{ url('admin/getSearch/') }}" method="GET" class="form-horizontal">
	{{csrf_field()}}
	<input type="hidden" name="page" value="user">
	<div class="col-md-12" style="margin-bottom: 20px">
		<div class="col-md-9">
			<div class="row">
				<div class="col-md-4">
					<select class="form-control" id="select_country" name="country">
		                    <option value=""> Select Country </option>
		            </select>
				</div>
				<div class="col-md-4">
					<select class="form-control" id="select_state" name="state">
		                    <option value=""> Select State </option>
		            </select>
				</div>
				<div class="col-md-4">
					<select class="form-control" id="select_city" name="city">
		                    <option value=""> Select City </option>
		            </select>
				</div>
			</div>
		</div>
		<div class="col-md-3" style="vertical-align: center">
			<button class="btn btn-info"><i class="fa fa-search" aria-hidden="true"></i></button>
			<button class="btn btn-info" onclick="javascript:setSubmit()">CSV</button>
			<a href="{{ url('admin/users/') }}" class="btn btn-info">Reset</a>
		</div>
	</div>
	</form>
	<br><br>
	<table id="users_list" class="display">
		<thead>
			<tr>
				<th>Name</th>
				<th>Mobile No.</th>
				<th>Role</th>
				<th>Mobile Verified</th>
				<th>Created On</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($users as $user)
			<tr>
				<td>{{ $user->full_name}}</td>
				<td>{{ '+' . $user->country_code . '-' . $user->mobile_number }}</td>
				<td>{{ $user->role->name }}</td>
				<td>
					@if($user->is_verified==0)
						Not Verified
					@else
						Verified
					@endif
				</td>
				<td>{{ date_format(date_create($user->created_at), 'd M,Y') }}</td>
				<td>
					<ul class="list-inline">
						@if($user->user_role_id == 4)
						<li>
							<a class="btn btn-info" href="{{url('admin/users/'.$user->id)}}" title="Add business"><i class="fa fa-user-plus" aria-hidden="true"></i>
							</a>
						</li>
						@endif
						<li>
							<a href="{{ url('admin/user/blocked/'.$user->id) }}">
			                    @if($user->is_blocked)
			                    	<button type="button" class="btn btn-danger" title="Unblock"><i class="fa fa-unlock"></i></button>
			                	@else
			                		<button type="button" class="btn btn-success" title="Block"><i class="fa fa-ban"></i></button>
			            		@endif
			        		</a>
						</li>
						<li>
							<a class="btn btn-warning" href="{{ url('admin/users/'.$user->id.'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
						</li>
						<li>
							<form action="{{ url('admin/users/'.$user->id) }}" method="POST" onsubmit="deleteCategory('{{$user->id}}', '{{$user->full_name}}', event,this)">
								{{csrf_field()}}
								{{ method_field('DELETE') }}
								<button type="submit" class="btn btn-danger" title="Delete"><i class="fa fa-trash-o"></i></button>
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
		    $('#users_list').DataTable();
		} );
	</script>
@endsection
@section('scripts')
	<script type="text/javascript">
		function deleteCategory(id, title, event,form)
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
	<script type="text/javascript">
		$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
		$(document).ready( function () {
			$.ajax({
                type:'POST',
                url: '{{ url("category") }}',
                success:function(response)
                {
                    var category = JSON.parse(response);
                    if(Object.keys(category).length>0)
                    {
                        for(key in category){
                            $('#select_category').append($("<option></option>").attr("value",key).text(category[key]));
                        }
                    }
                }
            });
            $.ajax({
                type:'POST',
                url: '{{ url("country") }}',
                success:function(response)
                {
                    var country = JSON.parse(response);
                    if(Object.keys(country).length>0)
                    {
                        for(key in country){
                            $('#select_country').append($("<option></option>").attr("value",key).text(key));
                        }
                    }
                }
            });
		});
		$('#select_category').on('change', function() {
	        if(this.value!=""){
	            $.ajax({
	                type:'POST',
	                url: '{{ url("subcategory") }}',
	                data:{
	                    category : this.value,
	                },success:function(response)
	                {
	                    $('#select_subcategory').find('option').not(':first').remove();
	                    var subcategory = JSON.parse(response);
	                    if(Object.keys(subcategory).length>0)
	                    {
	                        for(key in subcategory){
	                            $('#select_subcategory').append($("<option></option>").attr("value",key).text(subcategory[key]));
	                        }
	                    }else
	                    {
	                    	$('#select_subcategory').find('option').not(':first').remove();
	                    }
	                }
	            });
	        }else
	        {
	            $('#select_subcategory').find('option').not(':first').remove();
	        }
	    });
	    $('#select_country').on('change', function() {
	        if(this.value!=""){
	            $.ajax({
	                type:'POST',
	                url: '{{ url("state") }}',
	                data:{
	                    country : this.value,
	                },success:function(response)
	                {
	                    $('#select_state').find('option').not(':first').remove();
	                    $('#select_city').find('option').not(':first').remove();
	                    var state = JSON.parse(response);
	                    if(state.length>0)
	                    {
	                        for (var x = 0; x < state.length; x++) {
	                            $('#select_state').append($("<option></option>").attr("value",state[x]).text(state[x]));
	                        }
	                    }else
	                    {
	                        $('#select_state').find('option').not(':first').remove();
	                    	$('#select_city').find('option').not(':first').remove();
	                    }
	                }
	            });
	        }else
	        {
	            $('#select_state').find('option').not(':first').remove();
	            $('#select_city').find('option').not(':first').remove();
	        }
	    });
	    $('#select_state').on('change', function() {
	        if(this.value!=""){
	            $.ajax({
	                type:'POST',
	                url: '{{ url("city") }}',
	                data:{
	                	country : $("#select_country option:selected").val(),
	                    state : this.value,
	                },success:function(response)
	                {
	                    $('#select_city').find('option').not(':first').remove();
	                    var city = JSON.parse(response);
	                    if(city.length>0)
	                    {
	                        for (var x = 0; x < city.length; x++) {
	                            $('#select_city').append($("<option></option>").attr("value",city[x]).text(city[x]));
	                        }
	                    }else
	                    {
	                    	$('#select_city').find('option').not(':first').remove();
	                    }
	                }
	            });
	        }else
	        {
	            $('#select_city').find('option').not(':first').remove();
	        }
	    });
	    function setSubmit() {
		    $('#form1').attr('target','')
		    $('#form1').attr('action',"{{ url('admin/getCSV/') }}")
		    $('#form1').submit()
		}
	</script>
@endsection