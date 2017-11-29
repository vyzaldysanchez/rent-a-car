<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules \{
    GreaterThan, VehicleAvailable
};

class RentCreationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'vehicle_id' => ['required|integer|exists:vehicles', new VehicleAvailable],
            'client_id' => 'required|integer|exists:clients',
            'employee_id' => 'required|integer|exists:employees',
            'rent_date' => 'required|date|after_or_equal:now',
            'return_date' => 'required|date|after_or_equal:rent_date',
            'daily_fee' => ['required|numeric', new GreaterThan(0)],
            'duration_in_days' => ['required|integer', new GreaterThan(0)]
        ];
    }
}
