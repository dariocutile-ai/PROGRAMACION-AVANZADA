<?php

namespace App\Listeners;

use App\Models\AuditLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use Illuminate\Http\Request;

class AuthAuditListener
{
    public function __construct(private Request $request) {}

    public function handleLogin(Login $event): void
    {
        $this->log($event->user?->id, 'login', 'Authentication');
    }

    public function handleLogout(Logout $event): void
    {
        $this->log($event->user?->id, 'logout', 'Authentication');
    }

    public function handleFailed(Failed $event): void
    {
        $this->log($event->user?->id, 'failed_login', 'Authentication', [
            'email' => $event->credentials['email'] ?? null,
        ]);
    }

    private function log(?int $userId, string $action, string $module, array $details = []): void
    {
        AuditLog::create([
            'user_id' => $userId,
            'action' => $action,
            'module' => $module,
            'ip_address' => $this->request->ip(),
            'details' => $details,
        ]);
    }
}
