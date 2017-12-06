<?php
namespace App\Http\Controllers;

use Illuminate\Http \{
    Request, JsonResponse
};
use App\Http\Requests\RentCreationRequest;
use App\Models\Rent;
use App\Events\RentRegistered;
use App\Http\Resources \{
    RentsResource, RentsResourceCollection
};
use App\Events\RentEnded;
use App\Http\Requests\RentCancelationRequest;

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

    public function update(RentCancelationRequest $request, Rent $rent) : JsonResponse
    {
        $request->validate();

        $rent->state = $request->get('state');

        $rent->update();

        \Event::dispatch(new RentEnded($rent));

        return $this->success(new RentsResource($rent));
    }
}
