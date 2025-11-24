<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Platform;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::with('platform')->latest()->get();
        $platforms = Platform::all();
        $activePlatforms = Platform::count();

        return view('dashboard', compact('games', 'platforms', 'activePlatforms' ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'release_year' => 'required|string|max:4',
            'developer' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'platform_id' => 'required|exists:platforms,id',
        ]);

        Game::create($validated);

        return redirect()->back()->with('success', 'Game added successfully!');
    }

    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'release_year' => 'required|string|max:4',
            'developer' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'platform_id' => 'required|exists:platforms,id',
        ]);

        $game->update($validated);

        return redirect()->back()->with('success', 'Game updated successfully!');
    }

    public function destroy(Game $game)
    {
        $game->delete();
        return redirect()->back()->with('success', 'Game deleted successfully!');
    }
}