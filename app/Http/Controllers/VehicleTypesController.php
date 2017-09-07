<?php

namespace App\Http\Controllers;

use App\Http\Utils\HttpStatus;
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
            return $response->json($types, HttpStatus::SUCCESS);
        }

        return $response->json(null, HttpStatus::NO_CONTENT);
    }

    public function display(VehicleType $vehicleType): JsonResponse
    {
        return response()->json($vehicleType, HttpStatus::SUCCESS);
    }

    public function store(Request $request): JsonResponse
    {
        $vehicleType = VehicleType::create($request->all());
        return response()->json($vehicleType, HttpStatus::CREATED);
    }

    public function update(Request $request, VehicleType $vehicleType): JsonResponse
    {
        $vehicleType->update($request->all());
        return response()->json($vehicleType, HttpStatus::SUCCESS);
    }

    public function delete(VehicleType $vehicleType): JsonResponse
    {
        $vehicleType->delete();
        return response()->json(null, HttpStatus::NO_CONTENT);
    }
}
