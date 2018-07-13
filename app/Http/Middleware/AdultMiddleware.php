<?php

namespace App\Http\Middleware;

use Closure;

class AdultMiddleware
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
        if ($request->input('age') < 18) {
            return redirect()->route('refuse');
        }
        return $next($request);
    }
}
