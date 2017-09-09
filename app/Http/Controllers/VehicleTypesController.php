<?php

namespace App\Http\Controllers;

use App\Http\Utils\HttpStatus;
use App\Models\VehicleType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleTypesController extends Controller
{
    /**
     * @var \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    private $response;

    public function __construct()
    {
        $this->response = response();
    }

    public function index(): JsonResponse
    {
        $types = VehicleType::all();

        if ($types->count()) {
            return $this->response->json($types, HttpStatus::SUCCESS);
        }

        return $this->response->json(null, HttpStatus::NO_CONTENT);
    }

    public function display(VehicleType $vehicleType): JsonResponse
    {
        return $this->response->json($vehicleType, HttpStatus::SUCCESS);
    }

    public function store(Request $request): JsonResponse
    {
        $vehicleType = VehicleType::create($request->all());
        return $this->response->json($vehicleType, HttpStatus::CREATED);
    }

    public function update(Request $request, VehicleType $vehicleType): JsonResponse
    {
        $vehicleType->update($request->all());
        return $this->response->json($vehicleType, HttpStatus::SUCCESS);
    }

    public function delete(VehicleType $vehicleType): JsonResponse
    {
        $vehicleType->delete();
        return $this->response->json(null, HttpStatus::NO_CONTENT);
    }
}
