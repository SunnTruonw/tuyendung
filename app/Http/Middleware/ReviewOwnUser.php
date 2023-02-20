<?php

namespace App\Http\Middleware;

use App\Models\Review;
use Closure;

class ReviewOwnUser
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
        $reviewM=new Review();
        $review=$reviewM->find($idP);
        //  dd($userId!=$idP);
       // dd($product&&$userId==optional($product->user)->id);
        if($review&&$userId==optional($review->user)->id){

            return $next($request);
        }
        return abort(404);
    }
}
