<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Platform;

class PlatformController extends Controller
{
    public function index()
    {

            $platforms = Platform::latest()->get();
            return view('platform', compact('platforms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'platform_name' => 'required|string|max:255',
        ]);

        Platform::create($validated);
        return redirect()->back()->with('success', 'Platform added successfully.');
    }

    public function update(Request $request, Platform $platform)
    {
        $validated = $request->validate([
            'platform_name' => 'required|string|max:255',
        ]);

        $platform->update($validated);
        return redirect()->back()->with('success', 'Platform updated successfully.');
    }

    public function destroy(Platform $platform)
    {
        $platform->delete(); // Soft delete now
        return redirect()->back()->with('success', 'Platform moved to trash successfully.');
    }

    public function trash()
    {
        $trashedPlatforms = Platform::onlyTrashed()->latest()->get();
        return view('platforms.trash', compact('trashedPlatforms'));
    }

    public function restore($id)
    {
        $platform = Platform::withTrashed()->findOrFail($id);
        $platform->restore();
        return redirect()->back()->with('success', 'Platform restored successfully.');
    }

    public function forceDelete($id)
    {
        $platform = Platform::withTrashed()->findOrFail($id);
        $platform->forceDelete();
        return redirect()->back()->with('success', 'Platform permanently deleted.');
    }
}
