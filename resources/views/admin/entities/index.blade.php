@extends('layouts.admin')
@section('title', 'Enti territoriali')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-slate-900">Enti territoriali</h1>
        <p class="text-sm text-slate-500 mt-0.5">Comuni, Province, ANAS e Autostrade coinvolti nelle autorizzazioni.</p>
    </div>
    @can('create', \App\Models\Entity::class)
    <a href="{{ route('admin.entities.create') }}"
       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-blue-600 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
        Nuovo ente
    </a>
    @endcan
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    @if($entities->isEmpty())
    <div class="py-16 text-center">
        <p class="text-slate-400 text-sm">Nessun ente registrato.</p>
        <p class="text-xs text-slate-400 mt-1">Gli shapefile dei confini verranno importati in v0.4.x.</p>
    </div>
    @else
    <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Nome</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Tipo</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">ISTAT</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">PEC</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Geometria</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @foreach($entities as $entity)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-4 py-3 text-sm font-medium text-slate-900">{{ $entity->nome }}</td>
                <td class="px-4 py-3">
                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                        {{ $entity->tipo === \App\Enums\EntityType::Comune ? 'bg-blue-100 text-blue-800' :
                          ($entity->tipo === \App\Enums\EntityType::Provincia ? 'bg-purple-100 text-purple-800' :
                          ($entity->tipo === \App\Enums\EntityType::Anas ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-700')) }}">
                        {{ $entity->tipo->label() }}
                    </span>
                </td>
                <td class="px-4 py-3 text-sm font-mono text-slate-600">{{ $entity->codice_istat ?? '—' }}</td>
                <td class="px-4 py-3 text-sm text-slate-600 max-w-xs truncate">{{ $entity->pec ?? '—' }}</td>
                <td class="px-4 py-3">
                    @if($entity->geom)
                    <span class="inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">Presente</span>
                    @else
                    <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-500">Assente</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-right">
                    <a href="{{ route('admin.entities.show', $entity) }}" class="text-sm text-blue-600 hover:underline">Dettaglio</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($entities->hasPages())
    <div class="px-4 py-3 border-t border-slate-200">{{ $entities->links() }}</div>
    @endif
    @endif
</div>
@endsection
