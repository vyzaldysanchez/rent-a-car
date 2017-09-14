<?php

namespace App\Http\Controllers;

use App\Http\Utils\HttpStatus;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehiclesController extends Controller
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
        $types = Vehicle::all();

        if ($types->count()) {
            return $this->response->json($types, HttpStatus::SUCCESS);
        }

        return $this->response->json(null, HttpStatus::NO_CONTENT);
    }

    public function display(Vehicle $vehicle): JsonResponse
    {
        return $this->response->json($vehicle, HttpStatus::SUCCESS);
    }

    public function store(Request $request): JsonResponse
    {
        $vehicle = Vehicle::create($request->all());
        return $this->response->json($vehicle, HttpStatus::CREATED);
    }

    public function update(Request $request, Vehicle $vehicle): JsonResponse
    {
        $vehicle->update($request->all());
        return $this->response->json($vehicle, HttpStatus::SUCCESS);
    }

    public function delete(Vehicle $vehicle): JsonResponse
    {
        $vehicle->delete();
        return $this->response->json(null, HttpStatus::NO_CONTENT);
    }
}
