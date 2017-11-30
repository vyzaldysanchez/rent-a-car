<?php
namespace App\Http\Controllers;

use Illuminate\Http \{
    Request, JsonResponse
};
use App\Http\Requests\RentCreationRequest;
use App\Models\Rent;
use App\Events\RentRegistered;
use App\Http\Resources\RentsResourceCollection;

class RentsController extends Controller
{
    public function index() : JsonResponse
    {
        $rents = Rent::all();

        if ($rents->count()) {
            return $this->success(new RentsResourceCollection($rents));
        }

        return $this->noContent();
    }

    public function store(RentCreationRequest $request) : JsonResponse
    {
        $request->validate();

        $rent = Rent::create($request->all());

        \Event::dispatch(new RentRegistered($rent));

        return $this->created($rent);
    }
}
