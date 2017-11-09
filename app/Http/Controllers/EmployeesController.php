<?php

namespace App\Http\Controllers;

use App\Models\Employee;
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
        return $this->created($storingResult);
    }

    public function update(Request $request, Employee $employee): JsonResponse
    {
        $employee->update($request->all());
        return $this->success($employee);
    }

    public function delete(Employee $employee): JsonResponse
    {
        $employee->delete();
        return $this->noContent();
    }
}
