<?php
namespace App\Http\Controllers;

use Illuminate\Http \{
    Request, JsonResponse
};
use App\Http\Requests\RentCreationRequest;
use App\Models\Rent;
use App\Events\RentRegistered;

class RentsController extends Controller
{
    public function store(RentCreationRequest $request) : JsonResponse
    {
        $validFields = $request->validate();
        $comment = $request->get('comment');

        $rent = Rent::create($validFields + compact('comment'));

        \Event::dispatch(new RentRegistered($rent));

        return $this->created($rent);
    }
}
