<?php
namespace App\Listeners;

use App\Events\RentEnded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Vehicle;

class RentEndedListener
{
    /**
     * Handle the event.
     *
     * @param  RentEnded  $event
     * @return void
     */
    public function handle(RentEnded $event)
    {
        Vehicle::where('id', '=', $event->rent->vehicle_id)->first()->setAsAvailable();
    }
}
