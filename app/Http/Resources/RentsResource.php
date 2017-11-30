<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Carbon\Carbon;

class RentsResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'duration_in_days' => $this->duration_in_days . ' days',
            'return_date' => Carbon::parse($this->return_date)->toFormattedDateString(),
            'rent_date' => Carbon::parse($this->rent_date)->toFormattedDateString(),
            'vehicle' => $this->vehicle->description,
            'client' => $this->client->name
        ];
    }
}
