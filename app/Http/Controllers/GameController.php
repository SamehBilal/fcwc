<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameResults;
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

        try {
            // Check if the user has already submitted predictions
            $existingPrediction = GameResults::where('user_id', $request->id)
                ->where('game_id', 2)
                ->first();

            if ($existingPrediction) {
                return response()->json([
                    'message' => 'You have already submitted your predictions.',
                ], 400);
            }


            GameResults::create([
                'game_id'       => 2,
                'user_id'       => $request->id,
                'champion'      => json_encode($request->champion),
                'groups'        => json_encode($request->groups),
                'knockouts'     => json_encode($request->knockouts),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while checking existing predictions.',
                'error'   => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'Prediction received successfully.',
        ], 200);
    }

    public function predictResults()
    {
        $predictions = GameResults::all();
        dd($predictions);

        return response()->json($predictions);
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
