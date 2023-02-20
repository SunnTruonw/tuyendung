<?php

namespace App\Http\Middleware;

use Closure;

class CheckTypeUserCreateProduct
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

        $typeU=auth()->user()->type;

        if($typeU==2||$typeU==4){
            return $next($request);
        }
        return abort(404);
    }
}
