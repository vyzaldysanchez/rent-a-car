<?php
namespace App\Http\Controllers;

use App\Http\Requests\InspectionCreationRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Inspection;

class InspectionsController extends Controller
{
    /**
     * @param App\Http\Requests\InspectionCreationRequest $request
     * 
     * @return Illuminate\Http\JsonResponse 
     */
    public function store(InspectionCreationRequest $request): JsonResponse
    {
        $request->validate();

        return $this->created(Inspection::create($request->all()));
    }
}
