<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Players;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlayersApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Players::all());
    }

    public function show(Players $Players): JsonResponse
    {
        return response()->json($Players);
    }

    public function store(Request $request): JsonResponse
    {
        $Players = Players::create($request->all());

        return response()->json($Players, 201);
    }

    public function update(Request $request, Players $Players): JsonResponse
    {
        $Players->update($request->all());

        return response()->json($Players);
    }

    public function destroy(Players $Players): JsonResponse
    {
        $Players->delete();

        return response()->json(null, 204);
    }
}
