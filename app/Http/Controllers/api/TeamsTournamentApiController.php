<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TeamsTournament;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeamsTournamentApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(TeamsTournament::all());
    }

    public function show(TeamsTournament $TeamsTournament): JsonResponse
    {
        return response()->json($TeamsTournament);
    }

    public function store(Request $request): JsonResponse
    {
        $TeamsTournament = TeamsTournament::create($request->all());

        return response()->json($TeamsTournament, 201);
    }

    public function update(Request $request, TeamsTournament $TeamsTournament): JsonResponse
    {
        $TeamsTournament->update($request->all());

        return response()->json($TeamsTournament);
    }

    public function destroy(TeamsTournament $TeamsTournament): JsonResponse
    {
        $TeamsTournament->delete();

        return response()->json(null, 204);
    }
}
