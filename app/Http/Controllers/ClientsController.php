<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
            $message = 'This identification number ' . $request->identification_number . ' is already in use. Try another one.';
            return $this->unProcessableEntity($message);
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
