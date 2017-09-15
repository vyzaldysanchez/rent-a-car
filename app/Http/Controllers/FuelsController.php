<?php

namespace App\Http\Controllers;

use App\Models\Fuel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FuelsController extends Controller
{
    public function index(): JsonResponse
    {
        $fuels = Fuel::all();

        if ($fuels->count()) {
            return $this->success($fuels);
        }

        return $this->noContent();
    }

    public function display(Fuel $fuel): JsonResponse
    {
        return $this->success($fuel);
    }

    public function store(Request $request): JsonResponse
    {
        $fuel = Fuel::create($request->all());
        return $this->created($fuel);
    }

    public function update(Request $request, Fuel $fuel): JsonResponse
    {
        $fuel->update($request->all());
        return $this->success($fuel);
    }

    public function delete(Fuel $fuel): JsonResponse
    {
        $fuel->delete();
        return $this->noContent();
    }
}
