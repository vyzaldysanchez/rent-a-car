<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\NotExists;

class EmployeeCreationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'name' => 'required',
            'identification_card' => ['required', 'unique:employees'],
            'work_schedule' => 'required',
            'admission_date' => 'required',
            'credentials.email' => ['required_with:credentials', 'unique:users,email']
        ];
    }

    public function messages() : array
    {
        return [
            'credentials.email.required_with' => 'The email for the credentials is missing.',
            'credentials.email.unique' => 'The email provided is already taken.'
        ];
    }
}
