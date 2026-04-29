<?php

declare(strict_types=1);

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use App\Models\Route as RouteModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

final class RouteBuilderController extends Controller
{
    public function create(): View
    {
        $this->authorize('create', RouteModel::class);

        return view('citizen.routes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', RouteModel::class);

        $validated = $request->validate([
            'waypoints' => ['required', 'json'],
            'geometry' => ['required', 'string', 'starts_with:LINESTRING'],
            'distance_km' => ['required', 'numeric', 'min:0'],
        ]);

        $wkt = $validated['geometry'];
        $waypoints = json_encode(json_decode($validated['waypoints'], true));
        $userId = auth()->id();
        $distanceKm = $validated['distance_km'];
        $now = now()->toDateTimeString();

        DB::statement(
            'INSERT INTO routes (user_id, waypoints, geometry, distance_km, created_at, updated_at) VALUES (?, ?, ST_GeomFromText(?), ?, ?, ?)',
            [$userId, $waypoints, $wkt, $distanceKm, $now, $now]
        );

        $route = RouteModel::query()
            ->where('user_id', $userId)
            ->latest()
            ->firstOrFail();

        return redirect()->route('my.routes.show', $route)
            ->with('success', 'Percorso salvato.');
    }

    public function show(RouteModel $route): View
    {
        $this->authorize('view', $route);

        return view('citizen.routes.show', compact('route'));
    }
}
