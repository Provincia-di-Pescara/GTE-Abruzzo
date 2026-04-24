@extends('layouts.admin')
@section('title', $company->exists ? 'Modifica azienda' : 'Nuova azienda')

@section('content')
<div class="mb-6">
    <nav class="text-sm text-slate-500 mb-2">
        <a href="{{ route('admin.companies.index') }}" class="hover:text-slate-700">Aziende</a>
        <span class="mx-1">/</span>
        <span>{{ $company->exists ? $company->ragione_sociale : 'Nuova' }}</span>
    </nav>
    <h1 class="text-xl font-bold text-slate-900">
        {{ $company->exists ? 'Modifica azienda' : 'Nuova azienda' }}
    </h1>
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
          action="{{ $company->exists ? route('admin.companies.update', $company) : route('admin.companies.store') }}">
        @csrf
        @if($company->exists) @method('PUT') @endif

        <div class="space-y-5">
            <div>
                <label for="ragione_sociale" class="block text-sm font-medium text-slate-700">Ragione sociale <span class="text-red-500">*</span></label>
                <input type="text" id="ragione_sociale" name="ragione_sociale"
                       value="{{ old('ragione_sociale', $company->ragione_sociale) }}" required
                       class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('ragione_sociale') border-red-400 @enderror">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="partita_iva" class="block text-sm font-medium text-slate-700">Partita IVA <span class="text-red-500">*</span></label>
                    <input type="text" id="partita_iva" name="partita_iva"
                           value="{{ old('partita_iva', $company->partita_iva) }}" required maxlength="11"
                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm font-mono shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('partita_iva') border-red-400 @enderror">
                </div>
                <div>
                    <label for="codice_fiscale" class="block text-sm font-medium text-slate-700">Codice fiscale azienda</label>
                    <input type="text" id="codice_fiscale" name="codice_fiscale"
                           value="{{ old('codice_fiscale', $company->codice_fiscale) }}" maxlength="16"
                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm font-mono shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label for="indirizzo" class="block text-sm font-medium text-slate-700">Indirizzo</label>
                <input type="text" id="indirizzo" name="indirizzo"
                       value="{{ old('indirizzo', $company->indirizzo) }}"
                       class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-2">
                    <label for="comune" class="block text-sm font-medium text-slate-700">Comune</label>
                    <input type="text" id="comune" name="comune"
                           value="{{ old('comune', $company->comune) }}"
                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <div>
                    <label for="cap" class="block text-sm font-medium text-slate-700">CAP</label>
                    <input type="text" id="cap" name="cap"
                           value="{{ old('cap', $company->cap) }}" maxlength="5"
                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm font-mono shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label for="provincia" class="block text-sm font-medium text-slate-700">Provincia (sigla)</label>
                <input type="text" id="provincia" name="provincia"
                       value="{{ old('provincia', $company->provincia) }}" maxlength="2"
                       class="mt-1 block w-20 rounded-lg border border-slate-300 px-3 py-2 text-sm uppercase font-mono shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700">E-mail</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email', $company->email) }}"
                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <div>
                    <label for="pec" class="block text-sm font-medium text-slate-700">PEC</label>
                    <input type="email" id="pec" name="pec"
                           value="{{ old('pec', $company->pec) }}"
                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label for="telefono" class="block text-sm font-medium text-slate-700">Telefono</label>
                <input type="text" id="telefono" name="telefono"
                       value="{{ old('telefono', $company->telefono) }}"
                       class="mt-1 block w-48 rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>
        </div>

        <div class="flex gap-3 mt-8 pt-6 border-t border-slate-100">
            <button type="submit"
                    class="px-5 py-2 rounded-lg bg-blue-600 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">
                {{ $company->exists ? 'Salva modifiche' : 'Crea azienda' }}
            </button>
            <a href="{{ $company->exists ? route('admin.companies.show', $company) : route('admin.companies.index') }}"
               class="px-5 py-2 rounded-lg border border-slate-300 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                Annulla
            </a>
        </div>
    </form>
</div>
@endsection
