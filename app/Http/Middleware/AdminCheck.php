<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->isAdmin()) {
            return $next($request);
        }

        // Если пользователь не аутентифицирован или не является администратором, перенаправляем его на страницу с сообщением об ошибке доступа
        return redirect()->route('access_denied');
    }
}
