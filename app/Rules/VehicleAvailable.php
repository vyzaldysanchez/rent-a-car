<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Enums\VehicleState;
use \App\Models\Vehicle;

class VehicleAvailable implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Vehicle::where('status', '=', VehicleState::AVAILABLE)->find($value) != null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The vehicle is not available.';
    }
}
