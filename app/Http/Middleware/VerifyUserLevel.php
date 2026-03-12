<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyUserLevel
{
    /**
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $level = $request->user()?->level;
        $allowed = ["pengguna", "admin", "pengguna"];

        if (!$level || !in_array($level, $allowed, true)) {
            abort(403, "Level pengguna tidak valid.");
        }

        return $next($request);
    }
}