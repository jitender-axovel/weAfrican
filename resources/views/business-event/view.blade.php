@extends('layouts.app')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}"/>
@endsection
@section('content')
<div class="container">
    <div class="col-md-12">
    <div class="row">
        <h5 class="text-left">{{$event->name}} - Event Details</h5>
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
        <div class="panel panel-default document">
        	<form class="form-horizontal">
	        	<div class="form-group ">
	        		<label class="col-md-2 control-label">Category : </label>
	        		<label class="col-md-4 control-label align-left">{{$event->category->title}}</label>
	        		<label class="col-md-2 control-label">Name of Event : </label>
	        		<label class="col-md-4 control-label align-left">{{$event->name}}</label>
	        	</div>
	        	<div class="form-group ">
	        		<label class="col-md-2 control-label">Event Keywords : </label>
	        		<label class="col-md-4 control-label align-left">{{$event->keywords}}</label>
	        		<label class="col-md-2 control-label">Organizer Name : </label>
	        		<label class="col-md-4 control-label align-left">{{$event->organizer_name}}</label>
	        	</div>
	        	<div class="form-group ">
	        		<label class="col-md-2 control-label">Description : </label>
	        		<label class="col-md-10 control-label align-left">{{$event->description}}</label>
	        	</div>
	        	<div class="form-group ">
	        		<label class="col-md-2 control-label">Event Start Date &amp; Time:</label>
	        		<label class="col-md-4 control-label align-left">{{date('m/d/Y h:i A', strtotime($event->start_date_time))}}</label>
	        		<label class="col-md-2 control-label">Event End Date &amp; Time</label>
	        		<label class="col-md-4 control-label align-left">{{date('m/d/Y h:i A', strtotime($event->end_date_time))}}</label>
	        	</div>
	        	<div class="form-group">
	                <label class="col-md-2 control-label">Location : </label>
	                <div class="col-md-10">
	                    <div id="map"></div>
	                </div>
	            </div>
	        	<div class="form-group ">
	        		<label class="col-md-2 control-label">Address : </label>
	        		<label class="col-md-4 control-label align-left">{{$event->address}}</label>
	        		<label class="col-md-2 control-label">City : </label>
	        		<label class="col-md-4 control-label align-left">{{$event->city}}</label>
	        	</div>
	        	<div class="form-group ">
	        		<label class="col-md-2 control-label">State : </label>
	        		<label class="col-md-4 control-label align-left">{{$event->state}}</label>
	        		<label class="col-md-2 control-label">Country : </label>
	        		<label class="col-md-4 control-label align-left">{{$event->country}}</label>
	        	</div>
	        	<div class="form-group ">
	        		<label class="col-md-2 control-label">Pincode : </label>
	        		<label class="col-md-4 control-label align-left">{{$event->pin_code}}</label>
	        	</div>
	        	<div class="form-group ">
	        		<label class="col-md-2 control-label">Banner Image : </label>
	        		<div class="col-md-4">
                        <img src="{{asset(config('image.banner_image_url').'event/thumbnails/small/'.$event->banner)}}"/>
                    </div>
	        	</div>
	        	<fieldset>
                    <legend>Event Seating Plan</legend>
                </fieldset>
                <div class="form-group">
                	<label class="col-md-2 control-label">Total Seats</label>
                	<label class="col-md-2 control-label">{{ $event->total_seats }}</label>
                	<label class="col-md-2 control-label">Total Seats Buyed</label>
                	<label class="col-md-2 control-label">{{ $event->soldEventTickets->sum('total_tickets_buyed') }}</label>
                	<label class="col-md-2 control-label">Total Seats Left</label>
                	<label class="col-md-2 control-label">{{ $event->total_seats- $event->soldEventTickets->sum('total_tickets_buyed') }}</label>
                </div>
                @if(count($eventSeatingPlans)>0)
                    @foreach($eventSeatingPlans as $eventSeatingPlans)
                        <div class="form-group">
                            <label class="col-md-2 control-label">
                            @if($eventSeatingPlans->getEventPlanAlias($event->id, $eventSeatingPlans->id)!="" and $eventSeatingPlans->getEventPlanAlias($event->id, $eventSeatingPlans->id)!=NULL)
                            	{{ $eventSeatingPlans->getEventPlanAlias($event->id, $eventSeatingPlans->id) }} 
                            @else
                            	{{$eventSeatingPlans->title}}
                            @endif Seats</label>
                            	@if($eventSeatingPlans->getEventPlanSeats($event->id, $eventSeatingPlans->id))
                            		<label class="col-md-4 control-label align-left">{{$eventSeatingPlans->getEventPlanSeats($event->id, $eventSeatingPlans->id)}}</label>
                            	@else
                            		<label class="col-md-4 control-label align-left"></label>
                            	@endif
                            <label class="col-md-3 control-label">
                            @if($eventSeatingPlans->getEventPlanAlias($event->id, $eventSeatingPlans->id)!="" and $eventSeatingPlans->getEventPlanAlias($event->id, $eventSeatingPlans->id)!=NULL)
                            	{{ $eventSeatingPlans->getEventPlanAlias($event->id, $eventSeatingPlans->id) }} 
                            @else
                            	{{$eventSeatingPlans->title}}
                            @endif
                             Per Ticket Price</label>
                            <label class="col-md-3 control-label align-left">{{ $eventSeatingPlans->getEventPlanSeatsPrice($event->id, $eventSeatingPlans->id) }}</label>
                        </div>
                    @endforeach
                @endif
                <fieldset>
                    <legend>User Buyed Event Tickets</legend>
                </fieldset>
                @if(isset($soldEventTickets) and count($soldEventTickets)>0)
                	<div class="form-group">
                		<div class="col-md-12">
	                		<table class="table">
							  <thead class="thead-default">
							    <tr>
							      <th>#</th>
							      <th>UserName</th>
							      <th>Tickets Buyed</th>
							      <th>Total Cost<small>Excluding Tax</small></th>
							      <th>Buyed On</th>
							    </tr>
							  </thead>
							  <tbody>
						      @foreach($ticket_details as $key => $ticket_detail)
						      	<tr>
						      		<td>{{$key+1}}</td>
						      		<td>{{$ticket_detail->first_name}} {{$ticket_detail->last_name}}</td>
						      		<td>
						      		@foreach(explode(',',$ticket_detail->seating_plans) as $seating_plan)
						      			{{ $event->seatingPlan($seating_plan,$event->id) }} : {{ $event->soldTicket($ticket_detail->user_id,$ticket_detail->business_event_id,$ticket_detail->transaction_id,$seating_plan)->total_tickets_buyed }}&nbsp;&nbsp;
						      		@endforeach
						      		</td>
						      		<td>{{ $ticket_detail->totalprice }} {{ $ticket_detail->currency }}</td>
						      		<td>{{ date('m/d/Y h:i A', strtotime($ticket_detail->created_at)) }}</td>
						      	</tr>
						      @endforeach
							  </tbody>
							</table>
						</div>
                	</div>
                @else
	                <div class="form-group">
	                	<label class="col-md-2 control-label">No Records Found</label>
	                </div>
                @endif
        	</form>
        </div>
        </div>
    </div>
</div>
@endsection
@section('header-scripts')
    <script type="text/javascript" src='https://maps.google.com/maps/api/js?key=AIzaSyDEOk91hx04o7INiXclhMwqQi54n2Zo0gU&libraries=places'></script>
    <script src="{{ asset('js/dist/locationpicker.jquery.js') }}"></script>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('#map').locationpicker({
            location: {
                latitude: {{ $event->latitude }},
                longitude: {{ $event->longitude }}
            },
            radius: 100,
            enableAutocomplete: true,
            onchanged: function (currentLocation, radius, isMarkerDropped) {
                var addressComponents = $(this).locationpicker('map').location.addressComponents;
            },
            oninitialized: function (component) {
                var addressComponents = $(component).locationpicker('map').location.addressComponents;
            }
        });
    });
</script>
@endsection