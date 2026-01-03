<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CashierMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        if (!in_array(auth()->user()->role, ['admin', 'manager', 'cashier'])) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}