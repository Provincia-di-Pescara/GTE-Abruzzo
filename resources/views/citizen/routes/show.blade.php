@extends('layouts.citizen')

@section('title', 'Dettaglio Percorso')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-xl font-bold text-slate-900">Percorso #{{ $route->id }}</h1>
    <a href="{{ route('my.routes.create') }}"
       class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
        Nuovo percorso
    </a>
</div>

<div class="bg-white rounded-xl border border-slate-200 p-5 mb-6">
    <dl class="grid grid-cols-2 gap-4">
        <div>
            <dt class="text-xs text-slate-500 font-medium">Distanza totale</dt>
            <dd class="text-sm font-semibold text-slate-900 mt-1">{{ number_format((float)$route->distance_km, 3, ',', '.') }} km</dd>
        </div>
        <div>
            <dt class="text-xs text-slate-500 font-medium">Salvato il</dt>
            <dd class="text-sm font-semibold text-slate-900 mt-1">{{ $route->created_at->format('d/m/Y H:i') }}</dd>
        </div>
    </dl>
</div>

@if($route->entity_breakdown)
<div class="bg-white rounded-xl border border-slate-200 p-5 mb-6">
    <h2 class="text-sm font-semibold text-slate-700 mb-3">Ripartizione km per ente</h2>
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-slate-100">
                <th class="text-left py-2 text-xs text-slate-500 font-medium">Ente ID</th>
                <th class="text-right py-2 text-xs text-slate-500 font-medium">km</th>
            </tr>
        </thead>
        <tbody>
            @foreach($route->entity_breakdown as $entityId => $km)
            <tr class="border-b border-slate-50">
                <td class="py-2 text-slate-700">{{ $entityId }}</td>
                <td class="py-2 text-right text-slate-900 font-medium">{{ number_format((float)$km, 3, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection
