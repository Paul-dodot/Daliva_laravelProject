<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Platform;
use Barryvdh\DomPDF\Facade\Pdf;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $query = Game::with('platform');

        // Search by title
        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by platform
        if ($request->has('platform_id') && !empty($request->platform_id)) {
            $query->where('platform_id', $request->platform_id);
        }

        $games = $query->latest()->get();
        $platforms = Platform::all();
        $activePlatforms = Platform::count();

        return view('dashboard', compact('games', 'platforms', 'activePlatforms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'release_year' => 'required|string|max:4',
            'developer' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'platform_id' => 'required|exists:platforms,id',
            'photo' => 'nullable|image|mimes:jpg,png|max:2048', // 2MB max
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('games', 'public');
        }

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
            'photo' => 'nullable|image|mimes:jpg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($game->photo && \Storage::disk('public')->exists($game->photo)) {
                \Storage::disk('public')->delete($game->photo);
            }
            $validated['photo'] = $request->file('photo')->store('games', 'public');
        }

        $game->update($validated);

        return redirect()->back()->with('success', 'Game updated successfully!');
    }

    public function destroy(Game $game)
    {
        // Delete photo if exists
        if ($game->photo && \Storage::disk('public')->exists($game->photo)) {
            \Storage::disk('public')->delete($game->photo);
        }

        $game->delete(); // Soft delete now
        return redirect()->back()->with('success', 'Game moved to trash successfully!');
    }

    public function trash()
    {
        $trashedGames = Game::onlyTrashed()->with('platform')->latest()->get();
        return view('games.trash', compact('trashedGames'));
    }

    public function restore($id)
    {
        $game = Game::withTrashed()->findOrFail($id);
        $game->restore();
        return redirect()->back()->with('success', 'Game restored successfully!');
    }

    public function forceDelete($id)
    {
        $game = Game::withTrashed()->findOrFail($id);
        // Delete photo if exists
        if ($game->photo && \Storage::disk('public')->exists($game->photo)) {
            \Storage::disk('public')->delete($game->photo);
        }

        $game->forceDelete();
        return redirect()->back()->with('success', 'Game permanently deleted!');
    }

    public function export(Request $request)
    {
        $query = Game::with('platform');

        // Apply same filters as index
        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('platform_id') && !empty($request->platform_id)) {
            $query->where('platform_id', $request->platform_id);
        }

        $games = $query->latest()->get();

        $pdf = Pdf::loadView('games.export', compact('games'));
        $filename = 'games_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($filename);
    }
}