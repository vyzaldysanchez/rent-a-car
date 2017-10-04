<?php

namespace App\Http\Controllers;

use App\Models\VehicleModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleModelsController extends Controller
{
    public function index(): JsonResponse
    {
        $models = VehicleModel::all();

        if ($models->count()) {
            return $this->success($models);
        }

        return $this->noContent();
    }

    public function display(VehicleModel $model): JsonResponse
    {
        return $this->success($model);
    }

    public function store(Request $request): JsonResponse
    {
        $model = VehicleModel::create($request->all());
        return $this->created($model);
    }

    public function update(Request $request, VehicleModel $model): JsonResponse
    {
        $model->update($request->all());
        return $this->success($model);
    }

    public function delete(VehicleModel $model): JsonResponse
    {
        $model->delete();
        return $this->noContent();
    }
}
