<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InspectionCreationRequest extends FormRequest
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
            'has_scratches' => 'required|boolean',
            'has_spare_tire' => 'required|boolean',
            'has_jack' => 'required|boolean',
            'has_broken_glasses' => 'required|boolean',
            'fuel_qty' => 'required|numeric',
            'top_left_tire_state' => 'required|string',
            'top_right_tire_state' => 'required|string',
            'bottom_left_tire_state' => 'required|string',
            'bottom_right_tire_state' => 'required|string',
            'client_id' => 'required|integer|exists:clients,id',
            'employee_id' => 'required|integer|exists:employees,id',
            'vehicle_id' => 'required|integer|exists:vehicles,id',
            'rent_id' => 'required|integer|exists:rents,id'
        ];
    }
}
