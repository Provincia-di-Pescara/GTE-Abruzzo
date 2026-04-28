@extends('layouts.citizen')

@section('title', 'Modifica veicolo — ' . $vehicle->targa)

@section('content')
<div class="mb-6">
    <a href="{{ route('my.vehicles.show', $vehicle) }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-700 mb-3">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
        Torna al veicolo
    </a>
    <h1 class="text-xl font-bold text-slate-900">Modifica veicolo — <span class="font-mono">{{ $vehicle->targa }}</span></h1>
    <p class="text-sm text-slate-500 mt-0.5">Modifica i dati del veicolo e la configurazione degli assi.</p>
</div>

<form method="POST" action="{{ route('my.vehicles.update', $vehicle) }}">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-xl border border-slate-200 p-6 mb-4">
        <h2 class="text-sm font-semibold text-slate-700 mb-4">Dati generali</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            {{-- Azienda (read-only) --}}
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1">Azienda</label>
                <input type="text" value="{{ $vehicle->company->ragione_sociale }}" readonly
                       class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-500">
                <p class="mt-1 text-xs text-slate-400">L'azienda non è modificabile dopo la creazione.</p>
            </div>

            {{-- Tipo --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Tipo veicolo <span class="text-red-500">*</span>
                </label>
                <select name="tipo"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                    @foreach(\App\Enums\VehicleType::cases() as $type)
                    <option value="{{ $type->value }}" {{ old('tipo', $vehicle->tipo->value) === $type->value ? 'selected' : '' }}>
                        {{ $type->label() }}
                    </option>
                    @endforeach
                </select>
                @error('tipo')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Targa --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Targa <span class="text-red-500">*</span>
                </label>
                <input type="text" name="targa" value="{{ old('targa', $vehicle->targa) }}"
                       maxlength="15"
                       style="text-transform:uppercase"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm font-mono uppercase focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                @error('targa')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Numero telaio --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Numero telaio (VIN)</label>
                <input type="text" name="numero_telaio" value="{{ old('numero_telaio', $vehicle->numero_telaio) }}"
                       maxlength="17"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm font-mono focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                @error('numero_telaio')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Marca --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Marca</label>
                <input type="text" name="marca" value="{{ old('marca', $vehicle->marca) }}"
                       maxlength="100"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                @error('marca')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Modello --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Modello</label>
                <input type="text" name="modello" value="{{ old('modello', $vehicle->modello) }}"
                       maxlength="100"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                @error('modello')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Anno immatricolazione --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Anno immatricolazione</label>
                <input type="number" name="anno_immatricolazione" value="{{ old('anno_immatricolazione', $vehicle->anno_immatricolazione) }}"
                       min="1900" max="{{ date('Y') }}"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                @error('anno_immatricolazione')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </div>

    {{-- Dati massa --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 mb-4">
        <h2 class="text-sm font-semibold text-slate-700 mb-4">Massa e dimensioni</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Massa a vuoto (kg)</label>
                <input type="number" name="massa_vuoto" value="{{ old('massa_vuoto', $vehicle->massa_vuoto) }}"
                       min="0"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                @error('massa_vuoto')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Massa complessiva / PTT (kg)</label>
                <input type="number" name="massa_complessiva" value="{{ old('massa_complessiva', $vehicle->massa_complessiva) }}"
                       min="0"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                @error('massa_complessiva')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Lunghezza (mm)</label>
                <input type="number" name="lunghezza" value="{{ old('lunghezza', $vehicle->lunghezza) }}"
                       min="0"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                @error('lunghezza')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Larghezza (mm)</label>
                <input type="number" name="larghezza" value="{{ old('larghezza', $vehicle->larghezza) }}"
                       min="0"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                @error('larghezza')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Altezza (mm)</label>
                <input type="number" name="altezza" value="{{ old('altezza', $vehicle->altezza) }}"
                       min="0"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                @error('altezza')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- Configuratore assi --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6"
         x-data="{
            axles: [],
            addAxle() {
                this.axles.push({
                    posizione: this.axles.length + 1,
                    tipo: 'singolo',
                    interasse: '',
                    carico_tecnico: ''
                });
            },
            removeAxle(i) {
                this.axles.splice(i, 1);
                this.axles.forEach((a, idx) => a.posizione = idx + 1);
            }
         }"
         x-init="axles = {{ Js::from($vehicle->axles->map(fn($a) => ['posizione' => $a->posizione, 'tipo' => $a->tipo->value, 'interasse' => $a->interasse ?? '', 'carico_tecnico' => $a->carico_tecnico])->values()) }}">

        <div class="mb-3 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-slate-700">Configurazione assi <span class="text-red-500">*</span></h2>
            <button type="button" @click="addAxle()"
                    x-show="axles.length < 9"
                    class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                + Aggiungi asse
            </button>
        </div>

        @error('axles')
            <p class="mb-2 text-xs text-red-600">{{ $message }}</p>
        @enderror

        <template x-for="(axle, i) in axles" :key="i">
            <div class="grid grid-cols-12 gap-2 mb-2 items-end">
                {{-- Posizione (read-only) --}}
                <div class="col-span-1">
                    <label class="text-xs text-slate-500">N°</label>
                    <input type="text" :value="axle.posizione" readonly
                           class="w-full rounded-lg border border-slate-200 bg-slate-50 px-2 py-2 text-sm text-center">
                    <input type="hidden" :name="`axles[${i}][posizione]`" :value="axle.posizione">
                </div>
                {{-- Tipo asse --}}
                <div class="col-span-3">
                    <label class="text-xs text-slate-500">Tipo</label>
                    <select :name="`axles[${i}][tipo]`" x-model="axle.tipo"
                            class="w-full rounded-lg border border-slate-300 px-2 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                        <option value="singolo">Singolo</option>
                        <option value="tandem">Tandem</option>
                        <option value="tridem">Tridem</option>
                    </select>
                </div>
                {{-- Interasse (mm) --}}
                <div class="col-span-3">
                    <label class="text-xs text-slate-500">Interasse (mm)</label>
                    <input type="number" :name="`axles[${i}][interasse]`" x-model="axle.interasse"
                           min="0" placeholder="es. 1300"
                           class="w-full rounded-lg border border-slate-300 px-2 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                </div>
                {{-- Carico tecnico (kg) --}}
                <div class="col-span-4">
                    <label class="text-xs text-slate-500">Carico tecnico (kg) <span class="text-red-500">*</span></label>
                    <input type="number" :name="`axles[${i}][carico_tecnico]`" x-model="axle.carico_tecnico"
                           min="1" required placeholder="es. 8000"
                           class="w-full rounded-lg border border-slate-300 px-2 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                </div>
                {{-- Rimuovi --}}
                <div class="col-span-1">
                    <button type="button" @click="removeAxle(i)"
                            x-show="axles.length > 1"
                            class="w-full py-2 text-red-500 hover:text-red-700 transition-colors">
                        &#x2715;
                    </button>
                </div>
            </div>
        </template>
    </div>

    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('my.vehicles.show', $vehicle) }}"
           class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-800 transition-colors">
            Annulla
        </a>
        <button type="submit"
                class="inline-flex items-center gap-1.5 px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
            Salva modifiche
        </button>
    </div>

</form>
@endsection
