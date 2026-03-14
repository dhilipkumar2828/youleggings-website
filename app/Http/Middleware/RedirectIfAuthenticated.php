<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;

use Closure;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated

{

    /**

     * Handle an incoming request.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \Closure  $next

     * @param  string|null  ...$guards

     * @return mixed

     */

    public function handle(Request $request, Closure $next, ...$guards)

    {

        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                // If it's an admin, go to HOME (/admin)
                if ($user && ($user->role == 'admin' || $user->role == 'Super Admin')) {
                    return redirect(RouteServiceProvider::HOME);
                }
                // If it's a customer, go to frontend instead of being trapped in admin loop
                return redirect()->route('index');
            }

            if ($guard=="customer" && Auth::guard($guard)->check()) {
                return redirect('user/auth');
            }
        }

        return $next($request);

    }

}
