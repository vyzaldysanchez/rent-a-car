<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Enums\CommonStatus;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function index(): JsonResponse
    {
        $employees = Employee::allWithCredentials();

        if ($employees->count()) {
            return $this->success($employees);
        }

        return $this->noContent();
    }

    public function display(Employee $employee): JsonResponse
    {
        return $this->success($employee);
    }

    public function store(Request $request): JsonResponse
    {
        $user = null;

        if (isset($request->credentials) && !empty($request->credentials)) {
            if (User::findByEmail($request->credentials['email'])) {
                $message = 'The email ' . $request->credentials['email'] . ' is already in use.';
                return $this->unProcessableEntity($message);
            }

            $user = User::create($request->credentials + ['name' => $request->name]);
        }

        $employeeToStore = $request->all();

        if ($user) {
            $employeeToStore = $employeeToStore + ['user_id' => $user->id];
        }

        if (Employee::existsByIdentificationCard($employeeToStore['identification_card'])) {
            $message = 'The identification ' . $employeeToStore['identification_card'] . ' is already in use.';
            return $this->unProcessableEntity($message);
        }

        $storingResult = Employee::create($employeeToStore);
        $result = Employee::where('id', '=', $storingResult->id)->with(['credentials'])->first();

        return $this->created($result);
    }

    public function update(Request $request, Employee $employee): JsonResponse
    {
        $credentialsRequest = ['name' => $request->name];

        if (isset($request->credentials) && !empty($request->credentials)) {
            $credentialsRequest +=  $request->credentials;

            $userFound = User::where('id', '!=', $employee->user_id)
                ->whereEmail($request->credentials['email'])->first();

            if ($userFound) {
                $message = 'The email ' . $request->credentials['email'] . ' is already in use.';
                return $this->unProcessableEntity($message);
            }

            if ($employee->hasInactiveCredentials()) {
                $employee->credentials->activate();
            }
        } elseif ($employee->hasActiveCredentials()) {
            $employee->credentials->desactivate();
        }

        $identificationInUse = Employee::existsByIdentificationCard($request['identification_card']);
        $identificationChanged = $employee->identification_card !== $request['identification_card'];

        if ($identificationChanged && $identificationInUse) {
            $message = 'The identification ' . $request['identification_card'] . ' is already in use.';
            return $this->unProcessableEntity($message);
        }

        $employee->update($request->all() + $credentialsRequest);

        return $this->success($employee);
    }

    public function delete(Employee $employee): JsonResponse
    {
        $employee->delete();
        return $this->noContent();
    }
}
