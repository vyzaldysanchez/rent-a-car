<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Enums\CommonStatus;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeCreationRequest;

class EmployeesController extends Controller
{
    public function index(Request $request) : JsonResponse
    {
        $excludeUserFromRequest = $request->exists('except');
        $filters = $excludeUserFromRequest ? ['user_id' => $request->get('except')] : [];
        $filtersCondition = $excludeUserFromRequest ? '!=' : '';

        $employees = Employee::allWithCredentials($filters, $filtersCondition);

        if ($employees->count()) {
            return $this->success($employees);
        }

        return $this->noContent();
    }

    public function display(Employee $employee) : JsonResponse
    {
        return $this->success($employee);
    }

    public function store(EmployeeCreationRequest $request) : JsonResponse
    {
        $request->validate();

        $user = null;

        if (isset($request->credentials) && !empty($request->credentials)) {
            $user = User::create($request->credentials + ['name' => $request->name]);
        }

        $employeeToStore = $request->all();

        if ($user) {
            $employeeToStore = $employeeToStore + ['user_id' => $user->id];
        }

        $storingResult = Employee::create($employeeToStore);
        $result = Employee::where('id', '=', $storingResult->id)->with(['credentials'])->first();

        return $this->created($result);
    }

    public function update(Request $request, Employee $employee) : JsonResponse
    {
        $credentialsRequest = ['name' => $request->name];

        if (isset($request->credentials) && !empty($request->credentials)) {
            $userFound = User::where('id', '!=', $employee->user_id)
                ->whereEmail($request->credentials['email'])->first();

            if ($userFound) {
                $message = 'The email ' . $request->credentials['email'] . ' is already in use.';
                return $this->unProcessableEntity($message);
            }

            if ($employee->hasInactiveCredentials()) {
                $employee->credentials->activate();
            } elseif (!$employee->credentials) {
                User::create($request->credentials);
            }
        } elseif ($employee->hasActiveCredentials()) {
            $employee->credentials->desactivate();
        }

        if ($employee->credentials) {
            $employee->credentials->save($credentialsRequest);
        }

        $identificationInUse = Employee::existsByIdentificationCard($request['identification_card']);
        $identificationChanged = $employee->identification_card !== $request['identification_card'];

        if ($identificationChanged && $identificationInUse) {
            $message = 'The identification ' . $request['identification_card'] . ' is already in use.';
            return $this->unProcessableEntity($message);
        }

        $employee->update($request->all());

        return $this->success($employee);
    }

    public function delete(Employee $employee) : JsonResponse
    {
        $employee->delete();
        return $this->noContent();
    }
}
