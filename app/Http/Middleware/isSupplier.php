<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class isSupplier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->hasRole(supplierRolesList())) {
            return $next($request);
        }
        else{
            abort(404);
        }
    }
}
