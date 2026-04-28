@extends('layouts.citizen')

@section('title', 'Miei Veicoli')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-xl font-bold text-slate-900">Miei Veicoli</h1>
        <p class="text-sm text-slate-500 mt-0.5">Veicoli registrati per le tue aziende delegate.</p>
    </div>
    @can('create', \App\Models\Vehicle::class)
    <a href="{{ route('my.vehicles.create') }}"
       class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Aggiungi veicolo
    </a>
    @endcan
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    @if($vehicles->isEmpty())
    <div class="py-16 text-center">
        <svg class="w-12 h-12 text-slate-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
        </svg>
        <p class="text-sm font-medium text-slate-500">Nessun veicolo registrato</p>
        <p class="text-xs text-slate-400 mt-1">Aggiungi il tuo primo veicolo al garage.</p>
        @can('create', \App\Models\Vehicle::class)
        <a href="{{ route('my.vehicles.create') }}"
           class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
            Aggiungi veicolo
        </a>
        @endcan
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Targa</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Tipo</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Azienda</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wide">N° Assi</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wide">PTT (kg)</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wide">Azioni</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($vehicles as $vehicle)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-4 py-3 font-mono font-semibold text-slate-900">{{ $vehicle->targa }}</td>
                    <td class="px-4 py-3">
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
                    </td>
                    <td class="px-4 py-3 text-slate-600">{{ $vehicle->company->ragione_sociale ?? '—' }}</td>
                    <td class="px-4 py-3 text-center text-slate-700">{{ $vehicle->numero_assi }}</td>
                    <td class="px-4 py-3 text-right text-slate-700">
                        {{ $vehicle->massa_complessiva ? number_format($vehicle->massa_complessiva) : '—' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('my.vehicles.show', $vehicle) }}"
                               class="text-xs text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                Dettaglio
                            </a>
                            @can('update', $vehicle)
                            <a href="{{ route('my.vehicles.edit', $vehicle) }}"
                               class="text-xs text-slate-600 hover:text-slate-800 font-medium transition-colors">
                                Modifica
                            </a>
                            @endcan
                            @can('delete', $vehicle)
                            <form method="POST" action="{{ route('my.vehicles.destroy', $vehicle) }}"
                                  onsubmit="return confirm('Eliminare il veicolo {{ $vehicle->targa }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-xs text-red-500 hover:text-red-700 font-medium transition-colors">
                                    Elimina
                                </button>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
