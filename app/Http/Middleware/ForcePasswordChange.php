<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        // Si l'utilisateur est connecté et doit changer son mot de passe
        if (auth()->check() && auth()->user()->must_change_password) {
            // Ne pas rediriger si on est déjà sur la page de changement de mot de passe
            if (!$request->routeIs('password.change')) {
                return redirect()->route('password.change');
            }
        }

        return $next($request);
    }
}
