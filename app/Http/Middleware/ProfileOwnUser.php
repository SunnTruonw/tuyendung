<?php

namespace App\Http\Middleware;

use Closure;

class ProfileOwnUser
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
        $userId=auth()->user()->id;
        $idP= request()->route()->parameter('id')??$request->id;

      //  dd($userId!=$idP);
        if($userId!=$idP){
            return abort(404);
           // return back();
        }
        return $next($request);

    }
}
