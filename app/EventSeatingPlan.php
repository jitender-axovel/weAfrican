<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\BusinessEventSeat;

class EventSeatingPlan extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['title', 'slug', 'description'];

    public static $updatable = ['title' => "", 'slug' => "", 'description' => ""];

    public static $validater = array(
    	'title' => 'required|unique:event_seating_plans|max:255',
    	'description' => 'required',
    	);

    public static $updateValidater = array(
    	'title' => 'required',
    	'description' => 'required',
    	);
    
    public function getEventPlanSeats($eventId , $planId)
    {
        if(BusinessEventSeat::where('business_event_id', $eventId)->where('event_seating_plan_id', $planId)->first())
        {
            return BusinessEventSeat::where('business_event_id', $eventId)->where('event_seating_plan_id', $planId)->first()->total_seat_available;
        }else
        {
            return 0;
        }
        
    }

    public function getEventPlanAlias($eventId , $planId)
    {
        $businessEventSeat = BusinessEventSeat::where('business_event_id', $eventId)->where('event_seating_plan_id', $planId)->first();
        if($businessEventSeat and $businessEventSeat->seating_plan_alias!="")
        {
            return BusinessEventSeat::where('business_event_id', $eventId)->where('event_seating_plan_id', $planId)->first()->seating_plan_alias;
        }elseif(EventSeatingPlan::whereId($planId)->first())
        {
            return EventSeatingPlan::whereId($planId)->first()->title;
        }else
        {
            return 0;
        }
        
    }

    public function getEventPlanSeatsPrice($eventId , $planId)
    {
        if(BusinessEventSeat::where('business_event_id', $eventId)->where('event_seating_plan_id', $planId)->first())
        {
            return BusinessEventSeat::where('business_event_id', $eventId)->where('event_seating_plan_id', $planId)->first()->per_ticket_price;
        }else
        {
            return 0;
        }
        
    }
}
