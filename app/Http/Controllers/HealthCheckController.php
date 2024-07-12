<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class HealthCheckController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getHealthCheckStatus(): JsonResponse
    {
        return response()->json(['status' => 200, 'message' => 'pong']);
    }
}
