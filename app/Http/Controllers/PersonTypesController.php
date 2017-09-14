<?php

namespace App\Http\Controllers;

use App\Models\PersonType;
use Illuminate\Http\JsonResponse;

class PersonTypesController extends Controller
{
    public function index(): JsonResponse
    {
        $personTypes = PersonType::all();

        if ($personTypes->count()) {
            return $this->success($personTypes);
        }

        return $this->noContent();
    }

    public function display(PersonType $personType): JsonResponse
    {
        return $this->success($personType);
    }

    public function store(Request $request): JsonResponse
    {
        $personType = PersonType::create($request->all());
        return $this->created($personType);
    }

    public function update(Request $request, PersonType $personType): JsonResponse
    {
        $personType->update($request->all());
        return $this->success($personType);
    }

    public function delete(PersonType $personType): JsonResponse
    {
        $personType->delete();
        return $this->noContent();
    }
}
