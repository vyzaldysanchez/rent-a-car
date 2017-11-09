<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Utils\HttpStatus;

class EmployeesController extends Controller
{
    public function index(): JsonResponse
    {
        $employees = Employee::all();

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
                
                return $this->unprocessableEntity(new class($message) {
                    public $code = HttpStatus::UNPROCESSABLE_ENTITY;
                    public $message = '';
                            
                    public function __construct($message)
                    {
                        $this->message = $message;
                    }
                });
            }

            $user = User::create($request->credentials + ['name' => $request->name]);
        }

        $employeeToStore = $request->all();

        if ($user) {
            $employeeToStore = $employeeToStore + ['user_id' => $user->id];
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
