<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Display the specified user.
     */
    public function show(string $id)
    {
        return User::findOrFail($id);
    }

    /**
     * Search for a user by email or name.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json(['error' => 'Query parameter is required'], 400);
        }

        $user = User::where('email', $query)
            ->orWhere('name', 'like', "%{$query}%")
            ->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return $user;
    }
}
