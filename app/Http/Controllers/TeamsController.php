<?php

namespace App\Http\Controllers;

use App\Models\Teams;
use Illuminate\Http\Request;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $team = Teams::all();

        return view('teams.index', compact('team'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'created_by' => 'required|integer',
            'players' => 'nullable|string',
        ]);

        $team = Teams::create([
            'name' => $request->name,
            'created_by' => $request->created_by,
        ]);

        if ($request->filled('players')) {
            $players = preg_split('/\r\n|\r|\n/', $request->players);

            foreach ($players as $playerName) {
                $playerName = trim($playerName);

                if ($playerName !== '') {
                    $team->players()->create([
                        'name' => $playerName,
                    ]);
                }
            }
        }

        return redirect()
            ->route('teams.index')
            ->with('success', 'Team and players created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Teams $team)
    {
        $team->load('players');

        return view('teams.show', compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teams $team)
    {
        $team->load('players');


        return view('teams.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teams $team)
    {
        $request->validate([
            'name' => 'required|string',
            'created_by' => 'required|integer',
            'players' => 'nullable|string',
        ]);

        $team->update([
            'name' => $request->name,  
            'created_by' => $request->created_by,
        ]);

        if ($request->has('players')) {
            $team->players()->delete();

            if ($request->filled('players')) {
                $players = preg_split('/\r\n|\r|\n/', $request->players);

                foreach ($players as $playerName) {
                    $playerName = trim($playerName);

                    if ($playerName !== '') {
                        $team->players()->create([
                            'name' => $playerName,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('teams.show', $team->id)
            ->with('success', 'Team en spelers succesvol bijgewerkt.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teams $team)
    {
        $team->delete();

        return redirect()->route('teams.index')
            ->with('success', 'Teams deleted successfully.');
    }
}
