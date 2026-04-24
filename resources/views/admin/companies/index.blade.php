@extends('layouts.admin')
@section('title', 'Aziende')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-slate-900">Aziende</h1>
        <p class="text-sm text-slate-500 mt-0.5">Gestione aziende di trasporto e deleghe operative.</p>
    </div>
    @can('create', \App\Models\Company::class)
    <a href="{{ route('admin.companies.create') }}"
       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-blue-600 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
        Nuova azienda
    </a>
    @endcan
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    @if($companies->isEmpty())
    <div class="py-16 text-center">
        <p class="text-slate-400 text-sm">Nessuna azienda registrata.</p>
    </div>
    @else
    <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Ragione sociale</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">P.IVA</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Comune</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Delegati</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @foreach($companies as $company)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-4 py-3 text-sm font-medium text-slate-900">{{ $company->ragione_sociale }}</td>
                <td class="px-4 py-3 text-sm text-slate-600 font-mono">{{ $company->partita_iva }}</td>
                <td class="px-4 py-3 text-sm text-slate-600">{{ $company->comune ? $company->comune.' ('.$company->provincia.')' : '—' }}</td>
                <td class="px-4 py-3 text-sm text-slate-600">{{ $company->users_count }}</td>
                <td class="px-4 py-3 text-right">
                    <a href="{{ route('admin.companies.show', $company) }}" class="text-sm text-blue-600 hover:underline">Dettaglio</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($companies->hasPages())
    <div class="px-4 py-3 border-t border-slate-200">
        {{ $companies->links() }}
    </div>
    @endif
    @endif
</div>
@endsection
