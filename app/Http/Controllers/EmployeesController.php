<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
        $storingResult = Employee::create($request->all());
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
