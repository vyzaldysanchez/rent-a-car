<?php

namespace App\Http\Controllers;

use App\Http\Utils\HttpStatus;
use App\Models\VehicleModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleModelsController extends Controller
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
        $models = VehicleModel::all();

        if ($models->all()) {
            return $this->response->json($models, HttpStatus::SUCCESS);
        }

        return $this->response->json(null, HttpStatus::NO_CONTENT);
    }

    public function display(VehicleModel $vehicleType): JsonResponse
    {
        return $this->response->json($vehicleType, HttpStatus::SUCCESS);
    }

    public function store(Request $request): JsonResponse
    {
        $vehicleType = VehicleBrand::create($request->all());
        return $this->response->json($vehicleType, HttpStatus::CREATED);
    }

    public function update(Request $request, VehicleModel $vehicleType): JsonResponse
    {
        $vehicleType->update($request->all());
        return $this->response->json($vehicleType, HttpStatus::SUCCESS);
    }

    public function delete(VehicleModel $vehicleType): JsonResponse
    {
        $vehicleType->delete();
        return $this->response->json(null, HttpStatus::NO_CONTENT);
    }
}
