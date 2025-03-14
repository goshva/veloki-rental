<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRentalRequest;
use App\Http\Resources\RentalResource;
use App\Models\Rental;
use App\Services\RentalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RentalController extends Controller
{
    public function __construct(
        private RentalService $rentalService
    ) {}

    public function index(): AnonymousResourceCollection
    {
        $rentals = Rental::with('bikes')
                        ->whereNull('end_time')
                        ->orderByDesc('start_time')
                        ->get();

        return RentalResource::collection($rentals);
    }

    public function store(CreateRentalRequest $request): RentalResource
    {
        $rental = $this->rentalService->createRental($request->validated());
        return new RentalResource($rental);
    }

    public function complete(Rental $rental): JsonResponse
    {
        $result = $this->rentalService->completeRental($rental);
        return response()->json($result);
    }
}