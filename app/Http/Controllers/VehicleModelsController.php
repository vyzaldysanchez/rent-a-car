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

        if ($models->count()) {
            return $this->response->json($models, HttpStatus::SUCCESS);
        }

        return $this->response->json(null, HttpStatus::NO_CONTENT);
    }

    public function display(VehicleModel $model): JsonResponse
    {
        return $this->response->json($model, HttpStatus::SUCCESS);
    }

    public function store(Request $request): JsonResponse
    {
        $model = VehicleBrand::create($request->all());
        return $this->response->json($model, HttpStatus::CREATED);
    }

    public function update(Request $request, VehicleModel $model): JsonResponse
    {
        $model->update($request->all());
        return $this->response->json($model, HttpStatus::SUCCESS);
    }

    public function delete(VehicleModel $model): JsonResponse
    {
        $model->delete();
        return $this->response->json(null, HttpStatus::NO_CONTENT);
    }
}
