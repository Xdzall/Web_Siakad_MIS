<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserAbility
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $ability){
        $user = $request->user();
        
        if ($ability === 'mahasiswa' && !$user->hasRole('mahasiswa')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        if ($ability === 'dosen' && !$user->hasRole('dosen')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        return $next($request);
    }
}
