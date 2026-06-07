<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */


    public function handle(Request $request, Closure $next, ...$rol)
    {
        Log::info('Middleware ejecutado. Rol esperado: ' . $rol[0]);
        Log::info('Rol del usuario autenticado: ' . $request->user()->hasRole($rol));

        foreach ($rol as $r) {
            if ($request->user()->hasRole($r)) {
                return $next($request);
            }
        }
        abort(403, 'No tienes permiso para hacer eso. Vuelve a la página anterior.');
    }}
