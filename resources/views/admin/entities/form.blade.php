@extends('layouts.admin')
@section('title', $entity->exists ? 'Modifica ente' : 'Nuovo ente')

@section('content')
<div class="mb-6">
    <nav class="text-sm text-slate-500 mb-2">
        <a href="{{ route('admin.entities.index') }}" class="hover:text-slate-700">Enti</a>
        <span class="mx-1">/</span>
        <span>{{ $entity->exists ? $entity->nome : 'Nuovo' }}</span>
    </nav>
    <h1 class="text-xl font-bold text-slate-900">{{ $entity->exists ? 'Modifica ente' : 'Nuovo ente territoriale' }}</h1>
</div>

@if($errors->any())
<div class="mb-4 rounded-lg bg-red-50 border border-red-200 p-4">
    <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
    </ul>
</div>
@endif

<div class="bg-white rounded-xl border border-slate-200 p-6 max-w-2xl">
    <form method="POST"
          action="{{ $entity->exists ? route('admin.entities.update', $entity) : route('admin.entities.store') }}">
        @csrf
        @if($entity->exists) @method('PUT') @endif

        <div class="space-y-5">
            <div>
                <label for="nome" class="block text-sm font-medium text-slate-700">Nome <span class="text-red-500">*</span></label>
                <input type="text" id="nome" name="nome"
                       value="{{ old('nome', $entity->nome) }}" required
                       class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('nome') border-red-400 @enderror">
            </div>

            <div>
                <label for="tipo" class="block text-sm font-medium text-slate-700">Tipo <span class="text-red-500">*</span></label>
                <select id="tipo" name="tipo" required
                        class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="">— Seleziona —</option>
                    @foreach($types as $type)
                    <option value="{{ $type->value }}" @selected(old('tipo', $entity->tipo?->value) === $type->value)>{{ $type->label() }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="codice_istat" class="block text-sm font-medium text-slate-700">Codice ISTAT</label>
                <input type="text" id="codice_istat" name="codice_istat"
                       value="{{ old('codice_istat', $entity->codice_istat) }}" maxlength="10"
                       class="mt-1 block w-40 rounded-lg border border-slate-300 px-3 py-2 text-sm font-mono shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700">E-mail</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email', $entity->email) }}"
                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <div>
                    <label for="pec" class="block text-sm font-medium text-slate-700">PEC</label>
                    <input type="email" id="pec" name="pec"
                           value="{{ old('pec', $entity->pec) }}"
                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="telefono" class="block text-sm font-medium text-slate-700">Telefono</label>
                    <input type="text" id="telefono" name="telefono"
                           value="{{ old('telefono', $entity->telefono) }}"
                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <div>
                    <label for="codice_sdi" class="block text-sm font-medium text-slate-700">Codice SDI</label>
                    <input type="text" id="codice_sdi" name="codice_sdi"
                           value="{{ old('codice_sdi', $entity->codice_sdi) }}" maxlength="7"
                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm font-mono shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label for="indirizzo" class="block text-sm font-medium text-slate-700">Indirizzo sede</label>
                <input type="text" id="indirizzo" name="indirizzo"
                       value="{{ old('indirizzo', $entity->indirizzo) }}"
                       class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <div>
                <label for="codice_fisc_piva" class="block text-sm font-medium text-slate-700">Codice fiscale / P.IVA</label>
                <input type="text" id="codice_fisc_piva" name="codice_fisc_piva"
                       value="{{ old('codice_fisc_piva', $entity->codice_fisc_piva) }}" maxlength="16"
                       class="mt-1 block w-48 rounded-lg border border-slate-300 px-3 py-2 text-sm font-mono shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <div>
                <label for="geom" class="block text-sm font-medium text-slate-700">Geometria (WKT — opzionale)</label>
                <textarea id="geom" name="geom" rows="4"
                          placeholder="MULTIPOLYGON (((...))), oppure lascia vuoto. Verrà popolato automaticamente con l'import shapefile (v0.4.x)."
                          class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-xs font-mono shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">{{ old('geom', $entity->geom) }}</textarea>
                <p class="mt-1 text-xs text-slate-400">Formato WKT valido per MariaDB (MULTIPOLYGON). Lascia vuoto se non disponibile.</p>
            </div>
        </div>

        <div class="flex gap-3 mt-8 pt-6 border-t border-slate-100">
            <button type="submit"
                    class="px-5 py-2 rounded-lg bg-blue-600 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">
                {{ $entity->exists ? 'Salva modifiche' : 'Crea ente' }}
            </button>
            <a href="{{ $entity->exists ? route('admin.entities.show', $entity) : route('admin.entities.index') }}"
               class="px-5 py-2 rounded-lg border border-slate-300 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                Annulla
            </a>
        </div>
    </form>
</div>
@endsection
