<!DOCTYPE html>
<html lang="it" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Configurazione iniziale — GTE Abruzzo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased">

<div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">

    {{-- Header --}}
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-600 mb-4">
            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-slate-900">GTE Abruzzo</h1>
        <p class="text-sm text-slate-500 mt-1">Gestionale Trasporti Eccezionali</p>
    </div>

    {{-- Step indicator --}}
    @isset($currentStep)
    <div class="sm:mx-auto sm:w-full sm:max-w-lg mb-8">
        <div class="flex items-center justify-between px-4">
            @foreach([
                ['num' => 1, 'label' => 'Account'],
                ['num' => 2, 'label' => 'Applicazione'],
                ['num' => 3, 'label' => 'Posta'],
                ['num' => 4, 'label' => 'Riepilogo'],
            ] as $step)
            <div class="flex flex-col items-center flex-1">
                <div class="flex items-center w-full">
                    @if (!$loop->first)
                    <div class="flex-1 h-0.5 {{ $currentStep > $step['num'] - 1 ? 'bg-blue-600' : 'bg-slate-200' }}"></div>
                    @endif
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-semibold shrink-0
                        {{ $currentStep === $step['num'] ? 'bg-blue-600 text-white ring-4 ring-blue-100' : ($currentStep > $step['num'] ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-500') }}">
                        @if($currentStep > $step['num'])
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        @else
                        {{ $step['num'] }}
                        @endif
                    </div>
                    @if (!$loop->last)
                    <div class="flex-1 h-0.5 {{ $currentStep > $step['num'] ? 'bg-blue-600' : 'bg-slate-200' }}"></div>
                    @endif
                </div>
                <span class="mt-2 text-xs font-medium {{ $currentStep === $step['num'] ? 'text-blue-600' : 'text-slate-400' }}">{{ $step['label'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endisset

    {{-- Card --}}
    <div class="sm:mx-auto sm:w-full sm:max-w-lg">
        <div class="bg-white py-8 px-6 shadow-sm rounded-2xl border border-slate-100 sm:px-10">
            @yield('content')
        </div>
        <p class="mt-6 text-center text-xs text-slate-400">
            Provincia di Pescara — EUPL-1.2 — <a href="https://github.com/provincia-di-pescara/gte-abruzzo" class="underline">GitHub</a>
        </p>
    </div>
</div>

</body>
</html>
