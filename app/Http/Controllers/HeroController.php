<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HeroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heroes = Hero::where('active', true)
            ->orderBy('order')
            ->get();

        return response()->json($heroes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:heroes',
            'description' => 'required|string',
            'image_path' => 'required|string',
            'video_path' => 'required|string',
            'abilities' => 'nullable|array',
            'order' => 'nullable|integer',
            'active' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $hero = Hero::create($validated);

        return response()->json($hero, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Hero $hero)
    {
        return response()->json($hero);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hero $hero)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|unique:heroes,slug,' . $hero->id,
            'description' => 'sometimes|required|string',
            'image_path' => 'sometimes|required|string',
            'video_path' => 'sometimes|required|string',
            'abilities' => 'nullable|array',
            'order' => 'nullable|integer',
            'active' => 'nullable|boolean',
        ]);

        $hero->update($validated);

        return response()->json($hero);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hero $hero)
    {
        $hero->delete();

        return response()->json(null, 204);
    }
}
