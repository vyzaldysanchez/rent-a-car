<?php
namespace App\Listeners;

use App\Events\RentRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Vehicle;

class RentRegisteredListener
{
    /**
     * Handle the event.
     *
     * @param  RentRegistered  $event
     * @return void
     */
    public function handle(RentRegistered $event)
    {
        Vehicle::where('id', '=', $event->rent->vehicle_id)->first()->setAsRented();
    }
}
