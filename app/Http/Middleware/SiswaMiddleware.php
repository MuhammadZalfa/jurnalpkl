<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SiswaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if(!auth()->check()) {
            return redirect()->route('login');
        }
        
        if(auth()->user()->role !== 'siswa') {
            abort(403, 'Unauthorized action.');
        }
        
        return $next($request);
    }
}