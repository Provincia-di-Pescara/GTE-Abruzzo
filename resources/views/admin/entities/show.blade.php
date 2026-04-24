@extends('layouts.admin')
@section('title', $entity->nome)

@section('content')
<div class="mb-6 flex items-start justify-between">
    <div>
        <nav class="text-sm text-slate-500 mb-2">
            <a href="{{ route('admin.entities.index') }}" class="hover:text-slate-700">Enti</a>
            <span class="mx-1">/</span>
            <span>{{ $entity->nome }}</span>
        </nav>
        <div class="flex items-center gap-3">
            <h1 class="text-xl font-bold text-slate-900">{{ $entity->nome }}</h1>
            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-blue-100 text-blue-800">
                {{ $entity->tipo->label() }}
            </span>
        </div>
    </div>
    <div class="flex gap-2">
        @can('update', $entity)
        <a href="{{ route('admin.entities.edit', $entity) }}"
           class="px-4 py-2 rounded-lg border border-slate-300 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
            Modifica
        </a>
        @endcan
        @can('delete', $entity)
        <form method="POST" action="{{ route('admin.entities.destroy', $entity) }}"
              onsubmit="return confirm('Eliminare questo ente?')">
            @csrf @method('DELETE')
            <button type="submit" class="px-4 py-2 rounded-lg bg-red-600 text-sm font-semibold text-white hover:bg-red-700 transition-colors">
                Elimina
            </button>
        </form>
        @endcan
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="px-4 py-3 bg-slate-50 border-b border-slate-200">
            <h2 class="text-sm font-semibold text-slate-700">Dati anagrafici</h2>
        </div>
        <dl class="divide-y divide-slate-100">
            @foreach([
                ['Codice ISTAT', $entity->codice_istat ?? '—'],
                ['Indirizzo', $entity->indirizzo ?? '—'],
                ['E-mail', $entity->email ?? '—'],
                ['PEC', $entity->pec ?? '—'],
                ['Telefono', $entity->telefono ?? '—'],
                ['C.F. / P.IVA', $entity->codice_fisc_piva ?? '—'],
                ['Codice SDI', $entity->codice_sdi ?? '—'],
            ] as [$label, $value])
            <div class="flex px-4 py-2.5 text-sm">
                <dt class="w-28 shrink-0 text-slate-500">{{ $label }}</dt>
                <dd class="text-slate-900">{{ $value }}</dd>
            </div>
            @endforeach
        </dl>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="px-4 py-3 bg-slate-50 border-b border-slate-200">
            <h2 class="text-sm font-semibold text-slate-700">Geometria GIS</h2>
        </div>
        <div class="p-4">
            @if($entity->geom)
            <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-800">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/></svg>
                MULTIPOLYGON presente
            </span>
            <p class="mt-3 text-xs text-slate-400 font-mono truncate">{{ substr($entity->geom, 0, 120) }}…</p>
            @else
            <div class="text-center py-6">
                <p class="text-sm text-slate-400">Geometria non ancora caricata.</p>
                <p class="text-xs text-slate-400 mt-1">L'import shapefile dei confini comunali avverrà in v0.4.x.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
