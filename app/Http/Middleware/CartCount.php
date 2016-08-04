<?php

namespace App\Http\Middleware;

use Closure;
use Cart;

class CartCount
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
        $request->request->add(['cart_count' => Cart::count()]);
        return $next($request);
    }
}