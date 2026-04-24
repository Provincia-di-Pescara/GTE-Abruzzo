@extends('layouts.admin')
@section('title', $company->ragione_sociale)

@section('content')
<div class="mb-6 flex items-start justify-between">
    <div>
        <nav class="text-sm text-slate-500 mb-2">
            <a href="{{ route('admin.companies.index') }}" class="hover:text-slate-700">Aziende</a>
            <span class="mx-1">/</span>
            <span>{{ $company->ragione_sociale }}</span>
        </nav>
        <h1 class="text-xl font-bold text-slate-900">{{ $company->ragione_sociale }}</h1>
        <p class="text-sm font-mono text-slate-500 mt-0.5">P.IVA {{ $company->partita_iva }}</p>
    </div>
    <div class="flex gap-2">
        @can('update', $company)
        <a href="{{ route('admin.companies.edit', $company) }}"
           class="px-4 py-2 rounded-lg border border-slate-300 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
            Modifica
        </a>
        @endcan
        @can('delete', $company)
        <form method="POST" action="{{ route('admin.companies.destroy', $company) }}"
              onsubmit="return confirm('Eliminare questa azienda?')">
            @csrf @method('DELETE')
            <button type="submit" class="px-4 py-2 rounded-lg bg-red-600 text-sm font-semibold text-white hover:bg-red-700 transition-colors">
                Elimina
            </button>
        </form>
        @endcan
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Dati anagrafici --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <div class="px-4 py-3 bg-slate-50 border-b border-slate-200">
                <h2 class="text-sm font-semibold text-slate-700">Dati anagrafici</h2>
            </div>
            <dl class="divide-y divide-slate-100">
                @foreach([
                    ['Ragione sociale', $company->ragione_sociale],
                    ['P.IVA', $company->partita_iva],
                    ['C.F. Azienda', $company->codice_fiscale ?? '—'],
                    ['Indirizzo', $company->indirizzo ?? '—'],
                    ['Comune', $company->comune ? $company->comune.' ('.$company->provincia.')' : '—'],
                    ['CAP', $company->cap ?? '—'],
                    ['E-mail', $company->email ?? '—'],
                    ['PEC', $company->pec ?? '—'],
                    ['Telefono', $company->telefono ?? '—'],
                ] as [$label, $value])
                <div class="flex px-4 py-2.5 text-sm">
                    <dt class="w-28 shrink-0 text-slate-500">{{ $label }}</dt>
                    <dd class="text-slate-900">{{ $value }}</dd>
                </div>
                @endforeach
            </dl>
        </div>
    </div>

    {{-- Delegati --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <div class="px-4 py-3 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-slate-700">Utenti delegati</h2>
                <span class="text-xs text-slate-400">{{ $company->users->count() }} utenti</span>
            </div>
            @if($company->users->isEmpty())
            <p class="px-4 py-8 text-center text-sm text-slate-400">Nessun utente associato.</p>
            @else
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Utente</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Ruolo</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Valida dal</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Stato</th>
                        @can('approveDelegation', $company)
                        <th class="px-4 py-2"></th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($company->users as $user)
                    <tr>
                        <td class="px-4 py-2.5 text-sm">
                            <div class="font-medium text-slate-900">{{ $user->name }}</div>
                            <div class="text-xs text-slate-400">{{ $user->email }}</div>
                        </td>
                        <td class="px-4 py-2.5 text-sm text-slate-600 capitalize">{{ $user->pivot->role }}</td>
                        <td class="px-4 py-2.5 text-sm text-slate-600">{{ \Carbon\Carbon::parse($user->pivot->valid_from)->format('d/m/Y') }}</td>
                        <td class="px-4 py-2.5">
                            @if($user->pivot->approved_at)
                            <span class="inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">Approvata</span>
                            @else
                            <span class="inline-flex items-center rounded-full bg-amber-100 px-2 py-0.5 text-xs font-medium text-amber-800">In attesa</span>
                            @endif
                        </td>
                        @can('approveDelegation', $company)
                        <td class="px-4 py-2.5 text-right">
                            @if(!$user->pivot->approved_at)
                            <form method="POST" action="{{ route('admin.companies.delegation.action', [$company, $user]) }}" class="inline-flex gap-2">
                                @csrf
                                <button name="action" value="approve" class="text-xs text-green-700 font-medium hover:underline">Approva</button>
                                <button name="action" value="reject" class="text-xs text-red-600 font-medium hover:underline"
                                        onclick="return confirm('Rifiutare questa delega?')">Rifiuta</button>
                            </form>
                            @endif
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection
