<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TournamentApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Tournament::all());
    }

    public function show(Tournament $tournament): JsonResponse
    {
        return response()->json($tournament);
    }

    public function store(Request $request): JsonResponse
    {
        $tournament = Tournament::create($request->all());

        return response()->json($tournament, 201);
    }

    public function update(Request $request, Tournament $tournament): JsonResponse
    {
        $tournament->update($request->all());

        return response()->json($tournament);
    }

    public function destroy(Tournament $tournament): JsonResponse
    {
        $tournament->delete();

        return response()->json(null, 204);
    }
}
