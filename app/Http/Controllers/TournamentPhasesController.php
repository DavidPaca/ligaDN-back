<?php

namespace App\Http\Controllers;

use App\Models\tournament_phases;
use Illuminate\Http\Request;

class TournamentPhasesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $tournament_phases = tournament_phases:: where('status', 'V')
        ->get();
        return $tournament_phases;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(tournament_phases $tournament_phases)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(tournament_phases $tournament_phases)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, tournament_phases $tournament_phases)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(tournament_phases $tournament_phases)
    {
        //
    }
}
