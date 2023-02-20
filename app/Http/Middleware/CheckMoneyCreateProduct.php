<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Point;
class CheckMoneyCreateProduct
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
        $pointM=new Point();
        $sumPointCurrent = $pointM->sumPointCurrent($userId);
       // dd($sumPointCurrent <= config('point.typePoint')[2]['point']);
        if($sumPointCurrent < config('point.typePoint')[2]['point']){
            session()->put('urlProductPay',route('profile.createProduct'));
            return redirect()->route('profile.createPayment',['money'=>config('point.typePoint')[2]['point']])->with('mes','Tài khoản của bạn phải lớn hơn <strong>'.number_format(config('point.typePoint')[2]['point']).' VNĐ </strong>  để đăng tin. Vui lòng nạp tiền vào tài khoản để tiếp tục');
        };
        return $next($request);
    }
}
