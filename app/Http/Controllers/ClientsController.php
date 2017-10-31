<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Utils\HttpStatus;

class ClientsController extends Controller
{
    public function index(): JsonResponse
    {
        $clients = Client::all();

        if ($clients->count()) {
            return $this->success($clients);
        }

        return $this->noContent();
    }

    public function display(Client $client): JsonResponse
    {
        return $this->success($client);
    }

    public function store(Request $request): JsonResponse
    {
        if (Client::findByIdentification($request->identification_number)) {
            return $this->unprocessableEntity(new class {
                public $code = HttpStatus::UNPROCESSABLE_ENTITY;
                public $message = 'This identification number is already in use. Try another one.';
            });
        }

        $storingResult = Client::create($request->all());
        return $this->created($storingResult);
    }

    public function update(Request $request, Client $client): JsonResponse
    {
        $client->update($request->all());
        return $this->success($client);
    }

    public function delete(Client $client): JsonResponse
    {
        $client->delete();
        return $this->noContent();
    }
}
