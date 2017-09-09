<?php

namespace App\Http\Controllers;

use App\Http\Utils\HttpStatus;
use App\Models\VehicleBrand;
use Illuminate\Http\JsonResponse;

class VehicleBrandsController extends Controller
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
        $brands = VehicleBrand::all();

        if ($brands->all()) {
            return $this->response->json($brands, HttpStatus::SUCCESS);
        }

        return $this->response->json(null, HttpStatus::NO_CONTENT);
    }

    public function display(VehicleBrand $brand): JsonResponse
    {
        return $this->response->json($brand, HttpStatus::SUCCESS);
    }

    public function store(Request $request): JsonResponse
    {
        $brand = VehicleBrand::create($request->all());
        return $this->response->json($brand, HttpStatus::CREATED);
    }

    public function update(Request $request, VehicleBrand $brand): JsonResponse
    {
        $brand->update($request->all());
        return $this->response->json($brand, HttpStatus::SUCCESS);
    }

    public function delete(VehicleBrand $brand): JsonResponse
    {
        $brand->delete();
        return $this->response->json(null, HttpStatus::NO_CONTENT);
    }
}
