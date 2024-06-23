<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if ($request->user() === null) {
            return redirect('/login');
        }

        switch ($role) {
            case 'employee':
                if ($request->user()->isEmployee() || $request->user()->isManager() || $request->user()->isAdmin()) {
                    break;
                }

                return redirect('/');
            case 'manager':
                if ($request->user()->isManager() || $request->user()->isAdmin()) {
                    break;
                }

                return redirect('/');
            case 'admin':
                if ($request->user()->isAdmin()) {
                    break;
                }

                return redirect('/');
            default:
                abort(500, 'No such role, error in configuration of middleware in routes!');
        }

        return $next($request);
    }
}
