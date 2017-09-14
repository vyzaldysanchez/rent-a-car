<?php

namespace App\Http\Controllers;

use App\Models\VehicleBrand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleBrandsController extends Controller
{
    public function index(): JsonResponse
    {
        $brands = VehicleBrand::all();

        if ($brands->count()) {
            return $this->success($brands);
        }

        return $this->noContent();
    }

    public function display(VehicleBrand $brand): JsonResponse
    {
        return $this->success($brand);
    }

    public function store(Request $request): JsonResponse
    {
        $brand = VehicleBrand::create($request->all());
        return $this->created($brand);
    }

    public function update(Request $request, VehicleBrand $brand): JsonResponse
    {
        $brand->update($request->all());
        return $this->success($brand);
    }

    public function delete(VehicleBrand $brand): JsonResponse
    {
        $brand->delete();
        return $this->noContent();
    }
}
