<?php

namespace App\Http\Controllers;

use App\Models\Teams;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tournament = Tournament::all();

        return view('tournament.index', compact('tournament'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $teams = Teams::all();
        return view('tournament.create', compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'created_by' => 'required|integer',
            'teams' => 'required|array',
        ]);

        $teams = $request->teams;

        if (count($teams) < 4) {
            return back()->withErrors([
                'teams' => 'Een toernooi moet minimaal uit 4 teams bestaan.'
            ]);
        }

        $tournament = Tournament::create($request->only([
            'name',
            'description',
            'start_date',
            'created_by'
        ]));

        $tournament->teams()->attach($teams);

        $this->generateMatches($tournament, $teams);

        return redirect()->route('tournament.index')
            ->with('success', 'Tournament created successfully.');
    }
    private function generateMatches(Tournament $tournament, array $teams)
    {
        $teamCount = count($teams);
        $matchDay = 0;

        for ($i = 0; $i < $teamCount; $i++) {
            for ($j = $i + 1; $j < $teamCount; $j++) {
                $tournament->matches()->create([
                    'team_1_id' => $teams[$i],
                    'team_2_id' => $teams[$j],
                    'referee_id' => 1,
                    'match_date' => date('Y-m-d H:i:s', strtotime($tournament->start_date . ' + ' . $matchDay . ' days')),
                ]);
                $matchDay++;
            }
        }
    }





    /**
     * Display the specified resource.
     */
    public function show(Tournament $tournament)
    {
        return view('tournament.show', compact('tournament'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tournament $tournament)
    {
        return view('tournament.edit', compact('tournament'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tournament $tournament)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'start_date' => 'required',
            'created_by' => 'required|integer'
        ]);


        $tournament->update($request->all());

        return redirect()->route('tournament.index')
            ->with('success', 'Tournament updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tournament $tournament)
    {
        $tournament->delete();

        return redirect()->route('tournament.index')
            ->with('success', 'Tournament deleted successfully.');
    }
}
