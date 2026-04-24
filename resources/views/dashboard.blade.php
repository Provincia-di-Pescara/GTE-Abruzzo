<!DOCTYPE html>
<html lang="it" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard — GTE Abruzzo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased">

<nav class="bg-white border-b border-slate-200 px-6 py-3 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center">
            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
            </svg>
        </div>
        <span class="text-sm font-semibold text-slate-900">GTE Abruzzo</span>
    </div>

    <div class="flex items-center gap-4">
        <span class="text-sm text-slate-500">{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                Esci
            </button>
        </form>
    </div>
</nav>

<main class="max-w-4xl mx-auto px-6 py-12">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Benvenuto, {{ auth()->user()->name }}</h1>
        <p class="text-slate-500 mt-1">Il sistema GTE Abruzzo è operativo. Le funzionalità saranno disponibili nelle prossime versioni.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach([
            ['title' => 'Identità & RBAC', 'desc' => 'SPID/CIE, ruoli e aziende', 'milestone' => 'v0.2.x', 'color' => 'amber'],
            ['title' => 'Garage Virtuale', 'desc' => 'Veicoli, assi e tariffario usura', 'milestone' => 'v0.3.x', 'color' => 'orange'],
            ['title' => 'WebGIS & Routing', 'desc' => 'Leaflet, OSRM, intersezione spaziale', 'milestone' => 'v0.4.x', 'color' => 'purple'],
            ['title' => 'State Machine', 'desc' => 'Wizard domanda, pareri, PEC', 'milestone' => 'v0.5.x', 'color' => 'blue'],
            ['title' => 'PagoPA & PDF', 'desc' => 'Pagamenti, firma PAdES, protocollo', 'milestone' => 'v0.6.x', 'color' => 'green'],
            ['title' => 'AINOP/PDND', 'desc' => 'Integrazione infrastrutture nazionali', 'milestone' => 'v1.0.0', 'color' => 'red'],
        ] as $item)
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wide">{{ $item['milestone'] }}</span>
                <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-500">In sviluppo</span>
            </div>
            <h3 class="font-semibold text-slate-900 text-sm">{{ $item['title'] }}</h3>
            <p class="text-xs text-slate-500 mt-1">{{ $item['desc'] }}</p>
        </div>
        @endforeach
    </div>
</main>

</body>
</html>
