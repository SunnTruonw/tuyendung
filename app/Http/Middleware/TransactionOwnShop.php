<?php

namespace App\Http\Middleware;

use App\Models\Transaction;
use Closure;

class TransactionOwnShop
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
        $idT= request()->route()->parameter('id');
        $tranM=new Transaction();
        $tran=$tranM->find($idT);
        //  dd($userId!=$idP);
       // dd($product&&$userId==optional($product->user)->id);
        if($tran&&$userId==$tran->origin_id){

            return $next($request);
        }
        return abort(404);
    }
}
