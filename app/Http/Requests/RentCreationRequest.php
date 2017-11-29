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
            'vehicle_id' => ['required', 'integer', 'exists:vehicles,id', new VehicleAvailable],
            'client_id' => 'required|integer|exists:clients,id',
            'employee_id' => 'required|integer|exists:employees,id',
            'rent_date' => 'required|date|after_or_equal:now',
            'return_date' => 'required|date|after_or_equal:rent_date',
            'daily_fee' => ['required', 'numeric', new GreaterThan(0)]
        ];
    }
}
