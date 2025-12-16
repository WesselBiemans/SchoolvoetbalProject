<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Matches;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MatchesApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Matches::all());
    }

    public function show(Matches $Matches): JsonResponse
    {
        return response()->json($Matches);
    }

    public function store(Request $request): JsonResponse
    {
        $Matches = Matches::create($request->all());

        return response()->json($Matches, 201);
    }

    public function update(Request $request, Matches $Matches): JsonResponse
    {
        $Matches->update($request->all());

        return response()->json($Matches);
    }

    public function destroy(Matches $Matches): JsonResponse
    {
        $Matches->delete();

        return response()->json(null, 204);
    }
}
