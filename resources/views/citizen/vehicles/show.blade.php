@extends('layouts.citizen')

@section('title', 'Veicolo — ' . $vehicle->targa)

@section('content')
<div class="mb-6">
    <a href="{{ route('my.vehicles.index') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-700 mb-3">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
        Torna ai veicoli
    </a>
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-900 font-mono">{{ $vehicle->targa }}</h1>
            <p class="text-sm text-slate-500 mt-0.5">{{ $vehicle->marca }} {{ $vehicle->modello }}</p>
        </div>
        <div class="flex items-center gap-2">
            @can('update', $vehicle)
            <a href="{{ route('my.vehicles.edit', $vehicle) }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                </svg>
                Modifica
            </a>
            @endcan
            @can('delete', $vehicle)
            <form method="POST" action="{{ route('my.vehicles.destroy', $vehicle) }}"
                  onsubmit="return confirm('Eliminare il veicolo {{ $vehicle->targa }}? L\'operazione è irreversibile.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                    Elimina
                </button>
            </form>
            @endcan
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
    {{-- Dati anagrafici --}}
    <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 p-6">
        <h2 class="text-sm font-semibold text-slate-700 mb-4">Dati veicolo</h2>
        <dl class="grid grid-cols-2 gap-x-6 gap-y-3 text-sm">
            <div>
                <dt class="text-xs text-slate-500">Azienda</dt>
                <dd class="font-medium text-slate-900 mt-0.5">{{ $vehicle->company->ragione_sociale }}</dd>
            </div>
            <div>
                <dt class="text-xs text-slate-500">Tipo</dt>
                <dd class="mt-0.5">
                    @php
                        $badgeColor = match($vehicle->tipo) {
                            \App\Enums\VehicleType::Trattore     => 'bg-blue-100 text-blue-700',
                            \App\Enums\VehicleType::Rimorchio    => 'bg-green-100 text-green-700',
                            \App\Enums\VehicleType::Semirimorchio => 'bg-purple-100 text-purple-700',
                            \App\Enums\VehicleType::MezzoDopera  => 'bg-orange-100 text-orange-700',
                        };
                    @endphp
                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $badgeColor }}">
                        {{ $vehicle->tipo->label() }}
                    </span>
                </dd>
            </div>
            <div>
                <dt class="text-xs text-slate-500">Targa</dt>
                <dd class="font-mono font-semibold text-slate-900 mt-0.5">{{ $vehicle->targa }}</dd>
            </div>
            <div>
                <dt class="text-xs text-slate-500">Numero telaio (VIN)</dt>
                <dd class="font-mono text-slate-700 mt-0.5">{{ $vehicle->numero_telaio ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-slate-500">Marca</dt>
                <dd class="text-slate-700 mt-0.5">{{ $vehicle->marca ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-slate-500">Modello</dt>
                <dd class="text-slate-700 mt-0.5">{{ $vehicle->modello ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-slate-500">Anno immatricolazione</dt>
                <dd class="text-slate-700 mt-0.5">{{ $vehicle->anno_immatricolazione ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-slate-500">N° assi</dt>
                <dd class="text-slate-700 mt-0.5">{{ $vehicle->numero_assi }}</dd>
            </div>
        </dl>
    </div>

    {{-- Masse e dimensioni --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6">
        <h2 class="text-sm font-semibold text-slate-700 mb-4">Masse e dimensioni</h2>
        <dl class="space-y-3 text-sm">
            <div>
                <dt class="text-xs text-slate-500">Massa a vuoto</dt>
                <dd class="font-medium text-slate-900 mt-0.5">
                    {{ $vehicle->massa_vuoto ? number_format($vehicle->massa_vuoto).' kg' : '—' }}
                </dd>
            </div>
            <div>
                <dt class="text-xs text-slate-500">PTT (massa complessiva)</dt>
                <dd class="font-medium text-slate-900 mt-0.5">
                    {{ $vehicle->massa_complessiva ? number_format($vehicle->massa_complessiva).' kg' : '—' }}
                </dd>
            </div>
            <div class="border-t border-slate-100 pt-3">
                <dt class="text-xs text-slate-500">Lunghezza</dt>
                <dd class="text-slate-700 mt-0.5">
                    {{ $vehicle->lunghezza ? number_format($vehicle->lunghezza).' mm' : '—' }}
                </dd>
            </div>
            <div>
                <dt class="text-xs text-slate-500">Larghezza</dt>
                <dd class="text-slate-700 mt-0.5">
                    {{ $vehicle->larghezza ? number_format($vehicle->larghezza).' mm' : '—' }}
                </dd>
            </div>
            <div>
                <dt class="text-xs text-slate-500">Altezza</dt>
                <dd class="text-slate-700 mt-0.5">
                    {{ $vehicle->altezza ? number_format($vehicle->altezza).' mm' : '—' }}
                </dd>
            </div>
        </dl>
    </div>
</div>

{{-- Configurazione assi --}}
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100">
        <h2 class="text-sm font-semibold text-slate-700">Configurazione assi</h2>
    </div>
    @if($vehicle->axles->isEmpty())
    <div class="px-6 py-8 text-center">
        <p class="text-sm text-slate-500">Nessun asse configurato.</p>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50">
                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wide w-16">N°</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Tipo</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wide">Interasse (mm)</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wide">Carico tecnico (kg)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($vehicle->axles as $axle)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-4 py-3 text-center font-semibold text-slate-700">{{ $axle->posizione }}</td>
                    <td class="px-4 py-3 text-slate-700">{{ $axle->tipo->label() }}</td>
                    <td class="px-4 py-3 text-right text-slate-600">
                        {{ $axle->interasse ? number_format($axle->interasse) : '—' }}
                    </td>
                    <td class="px-4 py-3 text-right font-medium text-slate-900">
                        {{ number_format($axle->carico_tecnico) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            @php
                $totalCarico = $vehicle->axles->sum('carico_tecnico');
            @endphp
            <tfoot>
                <tr class="border-t border-slate-200 bg-slate-50">
                    <td colspan="3" class="px-4 py-3 text-right text-xs font-semibold text-slate-500">Totale carico tecnico</td>
                    <td class="px-4 py-3 text-right font-bold text-slate-900">{{ number_format($totalCarico) }} kg</td>
                </tr>
            </tfoot>
        </table>
    </div>
    @endif
</div>
@endsection
