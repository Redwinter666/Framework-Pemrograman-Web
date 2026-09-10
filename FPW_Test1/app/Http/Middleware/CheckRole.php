<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user() || ! in_array($request->user()->role, $roles)) {
            // Mengembalikan tampilan view error kustom
            return response()->view('errors.custom-forbidden', [], 403);
        }

        return $next($request);
    }
}


