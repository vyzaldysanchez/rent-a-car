<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleTypesController extends Controller
{
    public function index(): JsonResponse
    {
        $types = VehicleType::all();

        if ($types->count()) {
            return $this->success($types);
        }

        return $this->noContent();
    }

    public function display(VehicleType $vehicleType): JsonResponse
    {
        return $this->success($vehicleType);
    }

    public function store(Request $request): JsonResponse
    {
        $vehicleType = VehicleType::create($request->all());
        return $this->created($vehicleType);
    }

    public function update(Request $request, VehicleType $vehicleType): JsonResponse
    {
        $vehicleType->update($request->all());
        return $this->success($vehicleType);
    }

    public function delete(VehicleType $vehicleType): JsonResponse
    {
        $vehicleType->delete();
        return $this->noContent();
    }
}
