@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="main-container row register-business">
    <h5 class="text-left">Event Details</h5>
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
    <p class="text-right"><a href="{{url('business-event/create')}}"><button type="button" class="btn btn-info">Add Event</button></a></p>
    <div class="panel panel-default ">
        <table class="table">
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Event Title</th>
                    <th>Orgainzer Name</th>
                    <th>Event Start Date& time</th>
                    <th>Event End Date& time</th>
                    <th>Address</th>
                    <th>Participants</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @if($events->count()) 
                @foreach($events as $event)
                    <tr>
                        <td>{{$event->name}}</td>
                        <td>{{$event->title}}</td>
                        <td>{{$event->organizer_name}}</td>
                        <td>{{ date('m-d-Y h:i A', strtotime($event->start_date_time))}}</td>
                        <td>{{ date('m-d-Y h:i A', strtotime($event->end_date_time))}}</td>
                        <td>{{$event->address}}</td>
                        <td> {{ isset($event->participations) ? $event->participations->count() : 'Default' }}</td>
                        <td>
                            <a href="{{url('business-event/'.$event->id.'/edit')}}"><button type="button" class="btn btn-default"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            Edit</button></a>
                            <form action="{{url('business-event/'.$event->id)}}" method="POST" onsubmit="deleteEvent('{{$event->id}}', '{{$event->title}}', event,this)">
                                {{csrf_field()}}
                                <button type="submit" class="btn btn-danger" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                            </form>
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