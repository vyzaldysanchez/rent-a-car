<?php

namespace App\Http\Controllers;

use App\VehicleType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleTypesController extends Controller
{
    public function index(): JsonResponse
    {
        $response = response();
        $types = VehicleType::all();

        if ($types->all()) {
            return $response->json($types, 200);
        }

        return $response->json(null, 204);
    }

    public function display(VehicleType $vehicleType): JsonResponse
    {
        return response()->json($vehicleType, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $vehicleType = VehicleType::create($request->all());
        return response()->json($vehicleType, 201);
    }

    public function update(Request $request, VehicleType $vehicleType): JsonResponse
    {
        $vehicleType->save($request->all());
        return response()->json($vehicleType, 200);
    }

    public function delete(VehicleType $vehicleType): JsonResponse
    {
        $vehicleType->delete();
        return response()->json(null, 204);
    }
}
