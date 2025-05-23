<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DosenWali
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->is_wali) {
            return redirect()->route('dosen.dashboard')
                ->with('error', 'Akses ditolak. Anda bukan dosen wali.');
        }

        return $next($request);
    }
}