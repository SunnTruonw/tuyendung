<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Point;
class CheckMoneyViewProduct
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
        $user=auth()->user();
        $userId=$user->id;
        $pointM=new Point();
        $sumPointCurrent = $pointM->sumPointCurrent($userId);
        //  dd($sumPointCurrent >= config('point.typePoint')[3]['point']);
        $id=request()->route()->parameter('id');
        $pT=$point= $user->points()->where([
            'userorigin_id'=>$id
        ])->get()->count();

        if($pT>0){
            return $next($request);
        }
        if($sumPointCurrent < config('point.typePoint')[3]['point']){
            session()->put('urlProductPay',url()->current());
            return redirect()->route('profile.createPayment',['money'=>config('point.typePoint')[3]['point']])->with('mes','Tài khoản của bạn phải lớn hơn <strong>'.number_format(config('point.typePoint')[3]['point']).' VNĐ </strong>  để xem tin. Vui lòng nạp tiền vào tài khoản để tiếp tục');
        }else{
           // dd($request->pay==1);
            if(!$request->pay==1){
                return redirect()->route('profile.thongBao',[
                    'mes1'=>'Để xem tin bạn sẽ bị trừ '.number_format(config('point.typePoint')[3]['point']).' VNĐ',
                    'urlBack'=>url()->previous(),
                    'urlNext'=>url()->current().'?pay=1',
                ]);
            }
        }
        //   dd(($next));
        return $next($request);
    }
}
