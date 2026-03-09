<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckWebRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Se lee directamente de la superglobal para evadir la encriptación por defecto de Laravel
        // ya que la cookie se setea de forma cruda mediante JavaScript en el cliente.
        $cookieRole = $_COOKIE['metra_role'] ?? null;
        
        if (!$cookieRole || $cookieRole !== $role) {
            return redirect('/login');
        }

        return $next($request);
    }
}
