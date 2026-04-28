<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateMailSettingsRequest;
use App\Mail\TestMail;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

final class SettingController extends Controller
{
    public function showMail(): View
    {
        $this->denyUnlessSuper();

        $settings = [
            'mail_host' => Setting::get('mail_host', ''),
            'mail_port' => Setting::get('mail_port', '587'),
            'mail_encryption' => Setting::get('mail_encryption', 'tls'),
            'mail_username' => Setting::get('mail_username', ''),
            'mail_from_address' => Setting::get('mail_from_address', ''),
            'mail_from_name' => Setting::get('mail_from_name', 'GTE Abruzzo'),
        ];

        return view('admin.settings.mail', compact('settings'));
    }

    public function updateMail(UpdateMailSettingsRequest $request): RedirectResponse
    {
        $fields = [
            'mail_host', 'mail_port', 'mail_encryption',
            'mail_username', 'mail_from_address', 'mail_from_name',
        ];

        foreach ($fields as $key) {
            Setting::set($key, (string) $request->input($key), 'mail');
        }

        if ($request->filled('mail_password')) {
            Setting::set('mail_password', $request->input('mail_password'), 'mail');
        }

        return redirect()->route('admin.settings.mail')
            ->with('success', 'Impostazioni email salvate.');
    }

    public function testMail(): RedirectResponse
    {
        $this->denyUnlessSuper();

        $host = Setting::get('mail_host');

        if (! $host) {
            return redirect()->route('admin.settings.mail')
                ->with('error', 'Configura prima le impostazioni SMTP.');
        }

        $this->applyMailConfig();

        try {
            Mail::to(auth()->user()->email)->send(new TestMail());

            return redirect()->route('admin.settings.mail')
                ->with('success', 'Email di test inviata a '.auth()->user()->email.'.');
        } catch (Throwable $e) {
            return redirect()->route('admin.settings.mail')
                ->with('error', 'Invio fallito: '.$e->getMessage());
        }
    }

    private function denyUnlessSuper(): void
    {
        abort_unless(
            auth()->user()->hasRole(UserRole::SuperAdmin->value),
            403
        );
    }

    private function applyMailConfig(): void
    {
        $map = [
            'mail_host' => 'mail.mailers.smtp.host',
            'mail_port' => 'mail.mailers.smtp.port',
            'mail_encryption' => 'mail.mailers.smtp.encryption',
            'mail_username' => 'mail.mailers.smtp.username',
            'mail_password' => 'mail.mailers.smtp.password',
            'mail_from_address' => 'mail.from.address',
            'mail_from_name' => 'mail.from.name',
        ];

        foreach ($map as $settingKey => $configKey) {
            $value = Setting::get($settingKey);
            if ($value !== null) {
                Config::set($configKey, $value);
            }
        }

        Config::set('mail.default', 'smtp');
    }
}
