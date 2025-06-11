<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function results(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'id'            => 'required|exists:users,id',
            'champion'      => 'required',
            'groups'        => 'required',
            'knockouts'     => 'required',
        ]);

        Game::create([
            'game_id'       => 2,
            'user_id'       => $request->id,
            'champion'      => $request->champion,
            'groups'        => $request->groups,
            'knockouts'     => $request->knockouts,
        ]);

        return response()->json([
            'message' => 'Prediction received successfully.',
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Game $game)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        //
    }
}
