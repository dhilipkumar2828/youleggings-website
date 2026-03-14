<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;

class Admin

{

    /**

     * Handle an incoming request.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \Closure  $next

     * @return mixed

     */

    public function handle(Request $request, Closure $next)
    {
        $role = auth()->user()->role;
        if($role == 'admin' || $role == 'Super Admin'){
            return $next($request);
        }
        else{
            // If already logged in but not an admin, redirect to frontend instead of login to avoid loop
            return redirect()->route('index')->with('error', "You don't have permission to access the admin area.");
        }
    }

}
