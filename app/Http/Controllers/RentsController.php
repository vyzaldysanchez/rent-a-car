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
        $request->validate();
        
        $rent = Rent::create($request->all());

        \Event::dispatch(new RentRegistered($rent));

        return $this->created($rent);
    }
}
