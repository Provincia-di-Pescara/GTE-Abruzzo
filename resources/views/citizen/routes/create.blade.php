@extends('layouts.citizen')

@section('title', 'Nuovo Percorso')

@section('content')
<div class="mb-6">
    <h1 class="text-xl font-bold text-slate-900">Traccia percorso</h1>
    <p class="text-sm text-slate-500 mt-1">Clicca sulla mappa per aggiungere punti del percorso.</p>
</div>

<form method="POST" action="{{ route('my.routes.store') }}" id="route-form">
    @csrf
    <input type="hidden" name="waypoints" id="input-waypoints">
    <input type="hidden" name="geometry" id="input-geometry">
    <input type="hidden" name="distance_km" id="input-distance-km">

    <div id="map" class="w-full rounded-xl border border-slate-200" style="height: 500px;"></div>

    <div class="mt-4 flex items-center gap-3">
        <button type="submit" id="btn-submit"
            class="px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
            Salva percorso
        </button>
        <button type="button" id="btn-clear"
            class="px-5 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors">
            Azzera
        </button>
    </div>
    @error('geometry')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    @error('waypoints')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
</form>
@endsection

@push('scripts')
@vite('resources/js/route-builder.js')
@endpush
