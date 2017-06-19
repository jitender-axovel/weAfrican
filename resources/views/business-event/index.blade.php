@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="container row_pad">
    <h5 class="text-left">Event Details</h5>
    <hr>
    <p class="text-left">You can add multiple events.</p> 
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
    <p class="text-right"><a href="{{url('business-event/create')}}"><button type="button" class="btn btn-info">Add Event</button></a>
    <div class="panel panel-default tab_wide table_set ">
        <table class="table">
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Event Keywords</th>
                    <th>Orgainzer Name</th>
                    <th>Event Start Date</th>
                    <th>Event End Date</th>
                    <th>Address</th>
                    <th>Event Banner</th>
                    <th>Participants</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @if($events->count()) 
                @foreach($events as $event)
                    <tr>
                        <td>{{$event->name}}</td>
                        <td>{{$event->keywords}}</td>
                        <td>{{$event->organizer_name}}</td>
                        <td>{{ date('d M,Y h:i A', strtotime($event->start_date_time))}}</td>
                        <td>{{ date('d M,Y h:i A', strtotime($event->end_date_time))}}</td>
                        <td>{{$event->address}}</td>
                        <td> @if($event->banner)<img  class="event_img" src="{{asset(config('image.banner_image_url').'event/thumbnails/small/'.$event->banner)}}"/>
                        @else Banner not uploded yet @endif</td>
                        <td> {{ isset($event->participations) ? $event->participations->count() : 'Default' }}</td>
                        <td>
                            <ul class="list-inline">
                                <li>
                                    <button type="button" class="btn btn-info btn_fix" data-toggle="modal" data-target="#myModal-{{$event->id}}" title="Download Participant List"><i class="fa fa-download" aria-hidden="true"></i></button>
                                  <!-- Modal -->
                                    <div class="modal fade" id="myModal-{{$event->id}}" role="dialog">
                                    <div class="modal-dialog modal-lg">

                                      <!-- Modal content-->
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h6 class="modal-title">Choose data to show in csv</h6>
                                        </div>
                                        <div class="modal-body">

                                         <form class="form-horizontal" action="{{ url('event/participants/download-csv/'.$event->id) }}" method="POST">
                                            {{csrf_field()}}
                                            <div class="form-group form-inline col-md-4">
                                                <label>First Name</label>
                                                <input type="checkbox" class="form-control" name="first_name" value="first_name">
                                            </div>
                                            <div class="form-group form-inline col-md-4">
                                                <label>Middle Name</label>
                                                <input type="checkbox" class="form-control" name="middle_name" value="middle_name">
                                            </div>
                                            <div class="form-group form-inline col-md-4">
                                                <label>Last Name</label>
                                                <input type="checkbox" class="form-control" name="last_name" value="last_name">
                                            </div>
                                            <div class="form-group form-inline col-md-4">
                                                <label>Mobile Number</label>
                                                <input type="checkbox" class="form-control" name="mobile_number" value="mobile_number">
                                            </div>
                                            <div class="form-group form-inline col-md-4">
                                                <label>Country Code</label>
                                                <input type="checkbox" class="form-control" name="country_code" value="country_code">
                                            </div>
                                            <div class="col-md-12">
                                            <div class="row">
                                            <div class="form-group form-inline col-md-6">
                                                <label>Index</label>
                                                    <input type="number" class="form-control " name="index">
                                            </div>
                                            <div class="form-group form-inline col-md-6">
                                                <label>Limit</label>
                                                    <input type="number" class="form-control " name="limit">
                                            </div>
                                            </div>
                                            </div>
                                        </form>
                                        </div>
                                        <div class="modal-footer">
                                         <button class="btn btn-success" type="submit">Download</button>
                                          <button type="button " class="btn btn-default btn-danger" data-dismiss="modal">Cancel</button>
                                        </div>
                                      </div>
                                    </div>
                                    </div>
                                </li>
                                <li>
                                    <a href="{{url('business-event/'.$event->id.'/edit')}}"><button type="button" class="btn btn-default btn_fix" title="Edit Event"><i class="fa fa-pencil-square-o" aria-hidden="true" ></i></button></a>
                                </li>
                                <li>
                                    <a href="{{url('business-event/'.$event->id)}}"><button type="button" class="btn btn-success btn_fix" title="Edit Event"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                </li>
                                <li>
                                    <form action="{{url('business-event/'.$event->id)}}" method="POST" onsubmit="deleteEvent('{{$event->id}}', '{{$event->title}}', event,this)">
                                        {{csrf_field()}}
                                        <button type="submit" class="btn btn-danger btn_fix" title="Delete Event"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                    </form>
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td>No events found</td>
                </tr>
            @endif    
            </tbody>
        </table>
    </div>
    {{ $events->links() }}
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    function deleteEvent(id, title, event,form)
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