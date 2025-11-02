<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $episodes = Episode::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('episode_number')
            ->get();

        return response()->json($episodes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:episodes',
            'description' => 'required|string',
            'thumbnail' => 'required|string',
            'video_url' => 'required|string',
            'episode_number' => 'required|integer|unique:episodes',
            'published_at' => 'nullable|date',
            'featured' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $episode = Episode::create($validated);

        return response()->json($episode, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Episode $episode)
    {
        return response()->json($episode);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Episode $episode)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|unique:episodes,slug,' . $episode->id,
            'description' => 'sometimes|required|string',
            'thumbnail' => 'sometimes|required|string',
            'video_url' => 'sometimes|required|string',
            'episode_number' => 'sometimes|required|integer|unique:episodes,episode_number,' . $episode->id,
            'published_at' => 'nullable|date',
            'featured' => 'nullable|boolean',
        ]);

        $episode->update($validated);

        return response()->json($episode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Episode $episode)
    {
        $episode->delete();

        return response()->json(null, 204);
    }
}
