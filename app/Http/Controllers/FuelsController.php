<?php

namespace App\Http\Controllers;

use App\Http\Utils\HttpStatus;
use App\Models\Fuel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FuelsController extends Controller
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
        $fuels = Fuel::all();

        if ($fuels->count()) {
            return $this->response->json($fuels, HttpStatus::SUCCESS);
        }

        return $this->response->json(null, HttpStatus::NO_CONTENT);
    }

    public function display(Fuel $fuel): JsonResponse
    {
        return $this->response->json($fuel, HttpStatus::SUCCESS);
    }

    public function store(Request $request): JsonResponse
    {
        $fuel = Fuel::create($request->all());
        return $this->response->json($fuel, HttpStatus::CREATED);
    }

    public function update(Request $request, Fuel $fuel): JsonResponse
    {
        $fuel->update($request->all());
        return $this->response->json($fuel, HttpStatus::SUCCESS);
    }

    public function delete(Fuel $fuel): JsonResponse
    {
        $fuel->delete();
        return $this->response->json(null, HttpStatus::NO_CONTENT);
    }
}
