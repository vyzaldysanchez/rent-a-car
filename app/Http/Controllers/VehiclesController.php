<?php
namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehiclesController extends Controller
{
    public function index() : JsonResponse
    {
        $vehicles = Vehicle::getWithRelations();

        if ($vehicles->count()) {
            return $this->success($vehicles);
        }

        return $this->noContent();
    }

    public function allAvailable(): JsonResponse
    {
        $vehicles = Vehicle::getAllAvailableWithRelations();

        if ($vehicles->count()) {
            return $this->success($vehicles);
        }

        return $this->noContent();
    }

    public function display(Vehicle $vehicle) : JsonResponse
    {
        return $this->success($vehicle);
    }

    public function store(Request $request) : JsonResponse
    {
        $vehicle = Vehicle::create($request->all());
        return $this->created($vehicle);
    }

    public function update(Request $request, Vehicle $vehicle) : JsonResponse
    {
        $vehicle->update($request->all());
        return $this->success($vehicle);
    }

    public function delete(Vehicle $vehicle) : JsonResponse
    {
        $vehicle->delete();
        return $this->noContent();
    }
}
