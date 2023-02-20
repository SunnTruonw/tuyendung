<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Product;
class ProductOwnUser
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
        $prodctM=new Product();
        $product=$prodctM->find($idP);
        //  dd($userId!=$idP);
       // dd($product&&$userId==optional($product->user)->id);
        if($product&&$userId==optional($product->user)->id){

            return $next($request);
        }
        return abort(404);


    }
}
