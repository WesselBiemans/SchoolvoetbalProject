<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use Illuminate\Http\Request;

class MatchesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $match = Matches::all();

        return view('matches.index', compact('match'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('matches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'team_1_id' => 'required|integer',
            'team_2_id' => 'required|integer',
            'tournament_id' => 'required|integer',
            'team_1_score' => 'required|integer',
            'team_2_score' => 'required|integer',
            'match_date' => 'required|date',
        ]);

        Matches::create($request->all());

        return redirect()->route('matches.index')
            ->with('success', 'Matches created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Matches $match)
    {
        return view('matches.show', compact('match'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matches $match)
    {
        return view('matches.edit', compact('match'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Matches $match)
    {
        $request->validate([
            'team_1_id' => 'required|integer',
            'team_2_id' => 'required|integer',
            'tournament_id' => 'required|integer',
            'team_1_score' => 'required|integer',
            'team_2_score' => 'required|integer',
            'match_date' => 'required|date',
        ]);

        $match->update($request->all());

        return redirect()->route('matches.index')
            ->with('success', 'Match updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matches $match)
    {
        $match->delete();

        return redirect()->route('matches.index')
            ->with('success', 'Match deleted successfully.');
    }
}
