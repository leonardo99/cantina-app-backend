<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if(JWTAuth::parseToken()->authenticate()->type !== "admin") {
                return response()->json(['error' => 'Não autorizado'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Não autenticado'], 401);
        }
        return $next($request);
    }
}
