<?php

namespace App\Http\Controllers;

use App\Models\TeamsTournaments;
use Illuminate\Http\Request;

class TeamsTournamentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teamstournaments = TeamsTournaments::all();

        return view('teamstournaments.index', compact('teamstournaments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teamstournaments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'team_id' => 'required|integer',
            'tournament_id' => 'required|integer'
        ]);


        TeamsTournaments::create($request->all());

        return redirect()->route('teamstournaments.index')
            ->with('success', 'teamstournaments created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TeamsTournaments $teamsTournaments)
    {
        return view('teamstournaments.show', compact('teamsTournaments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeamsTournaments $teamsTournaments)
    {
        return view('teamstournaments.edit', compact('teamsTournaments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeamsTournaments $teamsTournaments)
    {
        $request->validate([
            'team_id' => 'required|integer',
            'tournament_id' => 'required|integer'
        ]);


        $teamsTournaments->update($request->update());

        return redirect()->route('teamstournaments.index')
            ->with('success', 'teamstournaments updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeamsTournaments $teamsTournaments)
    {
        $teamsTournaments->delete();

        return redirect()->route('teamstournaments.index')
            ->with('success', 'teamstournaments de.eted successfully.');
    }
}
