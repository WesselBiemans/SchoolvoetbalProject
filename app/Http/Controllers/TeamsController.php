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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'created_by' => 'required|integer'
        ]);

        Teams::create($request->all());


        return redirect()->route('teams.index')
            ->with('success', 'Teams created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teams $teams)
    {
        return view('teams.show', compact('teams'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teams $teams)
    {
        return view('teams.edit', compact('teams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teams $teams)
    {
        $request->validate([
            'name' => 'required|string',
            'created_by' => 'required|integer'
        ]);

        $teams->update($request->all());

        return redirect()->route('teams.index')
            ->with('success', 'Teams updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teams $teams)
    {
        $teams->delete();

        return redirect()->route('teams.index')
            ->with('success', 'Teams deleted successfully.');
    }
}
