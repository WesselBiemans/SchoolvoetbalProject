<?php

namespace App\Http\Controllers;

use App\Models\Players;
use Illuminate\Http\Request;

class PlayersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $player = Players::all();

        return view('players.index', compact('player'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('players.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'team_id' => 'required|integer'
        ]);

        Players::create($request->all());

        return redirect()->route('players.index')
            ->with('success', 'Players created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Players $players)
    {
        return view('players.show', compact('players'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Players $players)
    {
        return view('players.edit', compact('players'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Players $players)
    {
        $request->validate([
            'name' => 'required|string',
            'team_id' => 'required|integer'
        ]);

        $players->update($request->all());

        return redirect()->route('players.index')
            ->with('success', 'Players updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Players $players)
    {
        $players->delete();

        return redirect()->route('players.index')
            ->with('success', 'Players deleted successfully.');
    }
}
