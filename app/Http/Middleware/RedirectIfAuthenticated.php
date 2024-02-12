<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                if (Auth::user()->role === 'admin') {
                    return to_route('admin.test')->with('success', 'You are logged in as an admin');
                } elseif (Auth::user()->role === 'member') {
                    return to_route('member.test')->with('success', 'You are logged in as a member');
                } elseif (Auth::user()->role === 'organizer') {
                    return to_route('organizer.test')->with('success', 'You are logged in as an organizer');
                }
            }
        }
        return $next($request);
    }
}
