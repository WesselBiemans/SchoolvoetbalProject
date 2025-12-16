<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Teams;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeamsApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Teams::all());
    }

    public function show(Teams $Teams): JsonResponse
    {
        return response()->json($Teams);
    }

    public function store(Request $request): JsonResponse
    {
        $Teams = Teams::create($request->all());

        return response()->json($Teams, 201);
    }

    public function update(Request $request, Teams $Teams): JsonResponse
    {
        $Teams->update($request->all());

        return response()->json($Teams);
    }

    public function destroy(Teams $Teams): JsonResponse
    {
        $Teams->delete();

        return response()->json(null, 204);
    }
}
