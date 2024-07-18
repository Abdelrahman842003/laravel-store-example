<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChickUserType
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$types)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }
        if (!in_array($user->types, $types)) {
            abort(403);
        }
        return $next($request);
    }
}
