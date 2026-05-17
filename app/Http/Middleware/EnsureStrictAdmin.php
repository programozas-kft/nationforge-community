<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStrictAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isStrictAdmin()) {
            abort(403, 'Hozzáférés megtagadva.');
        }

        return $next($request);
    }
}
