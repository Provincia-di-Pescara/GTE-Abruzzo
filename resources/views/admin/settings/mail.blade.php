@extends('layouts.admin')
@section('title', 'Impostazioni email')

@section('content')
<div class="mb-6">
    <h1 class="text-xl font-bold text-slate-900">Impostazioni email</h1>
    <p class="text-sm text-slate-500 mt-0.5">Configurazione server SMTP per notifiche e PEC.</p>
</div>

<div class="bg-white rounded-xl border border-slate-200 p-6 max-w-2xl">

    <form method="POST" action="{{ route('admin.settings.mail.update') }}" class="space-y-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="sm:col-span-2">
                <label for="mail_host" class="block text-sm font-medium text-slate-700 mb-1">Host SMTP</label>
                <input type="text" id="mail_host" name="mail_host"
                       value="{{ old('mail_host', $settings['mail_host']) }}"
                       placeholder="smtp.example.com"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none @error('mail_host') border-red-400 @enderror">
                @error('mail_host')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="mail_port" class="block text-sm font-medium text-slate-700 mb-1">Porta</label>
                <input type="number" id="mail_port" name="mail_port"
                       value="{{ old('mail_port', $settings['mail_port']) }}"
                       min="1" max="65535"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none @error('mail_port') border-red-400 @enderror">
                @error('mail_port')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label for="mail_encryption" class="block text-sm font-medium text-slate-700 mb-1">Cifratura</label>
            <select id="mail_encryption" name="mail_encryption"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                @foreach(['tls' => 'TLS (raccomandato)', 'ssl' => 'SSL', 'none' => 'Nessuna'] as $val => $label)
                <option value="{{ $val }}" @selected(old('mail_encryption', $settings['mail_encryption']) === $val)>{{ $label }}</option>
                @endforeach
            </select>
            @error('mail_encryption')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="mail_username" class="block text-sm font-medium text-slate-700 mb-1">Username SMTP</label>
            <input type="text" id="mail_username" name="mail_username"
                   value="{{ old('mail_username', $settings['mail_username']) }}"
                   autocomplete="off"
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none @error('mail_username') border-red-400 @enderror">
            @error('mail_username')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="mail_password" class="block text-sm font-medium text-slate-700 mb-1">
                Password SMTP
                <span class="text-xs font-normal text-slate-400">(lascia vuoto per non modificare)</span>
            </label>
            <input type="password" id="mail_password" name="mail_password"
                   autocomplete="new-password"
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
            @error('mail_password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="mail_from_address" class="block text-sm font-medium text-slate-700 mb-1">Indirizzo mittente</label>
                <input type="email" id="mail_from_address" name="mail_from_address"
                       value="{{ old('mail_from_address', $settings['mail_from_address']) }}"
                       placeholder="noreply@provincia.pe.it"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none @error('mail_from_address') border-red-400 @enderror">
                @error('mail_from_address')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="mail_from_name" class="block text-sm font-medium text-slate-700 mb-1">Nome mittente</label>
                <input type="text" id="mail_from_name" name="mail_from_name"
                       value="{{ old('mail_from_name', $settings['mail_from_name']) }}"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none @error('mail_from_name') border-red-400 @enderror">
                @error('mail_from_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex items-center justify-between pt-2 border-t border-slate-100">
            <button type="submit"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                Salva impostazioni
            </button>
        </div>
    </form>

    {{-- Sezione test email --}}
    <div class="mt-8 pt-6 border-t border-slate-200">
        <h2 class="text-sm font-semibold text-slate-700 mb-1">Verifica configurazione</h2>
        <p class="text-xs text-slate-500 mb-4">Invia un'email di test al tuo indirizzo ({{ auth()->user()->email }}) usando le impostazioni salvate.</p>
        <form method="POST" action="{{ route('admin.settings.mail.test') }}">
            @csrf
            <button type="submit"
                    class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                </svg>
                Invia email di test
            </button>
        </form>
    </div>
</div>
@endsection
