<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bike;
use Illuminate\Http\JsonResponse;

class BikeController extends Controller
{
    public function index(): JsonResponse
    {
        $bikes = Bike::where('status', 0)
                    ->orderBy('class')
                    ->orderBy('name')
                    ->get();

        return response()->json([
            'status' => 'success',
            'data' => $bikes
        ]);
    }

    public function show(Bike $bike): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $bike
        ]);
    }
}