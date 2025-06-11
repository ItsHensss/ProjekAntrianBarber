<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Jika tidak login, biarkan Filament sendiri yang handle
        if (!$user) {
            return $next($request);
        }

        // Cek apakah user memiliki salah satu role dari Shield
        if (!$user->roles()->exists()) {
            // Logout dan redirect ke login dengan pesan error
            Auth::logout();

            return redirect()->route('filament.admin.auth.login')
                ->withErrors([
                    'email' => 'Anda tidak memiliki akses ke panel admin.',
                ]);
        }

        return $next($request);
    }
}