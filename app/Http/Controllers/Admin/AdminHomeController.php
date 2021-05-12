<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Post;
use App\Models\User;
class AdminHomeController extends Controller
{
    //
    private $transaction;
    private $user;
    private $product;
    private $post;
    private $listStatus;
    public function __construct(Transaction $transaction,User $user,Post $post,Product $product)
    {
        $this->middleware('auth:admin');
        $this->transaction=$transaction;
        $this->listStatus=$this->transaction->listStatus;
        $this->user=$user;
        $this->post=$post;
        $this->product=$product;
    }
    public function index(){
        $totalTransaction=$this->transaction->all()->count();
        $totalMember=$this->user->all()->count();
        $totalProduct=$this->product->all()->count();
        $totalPost=$this->post->all()->count();
        $countTransaction=[];
        // lấy số giao dịch đã bị hủy bỏ
        $countTransaction['-1']=$this->transaction->where([
            ['status', '=', '-1'],
        ])->count();
         // lấy số lượng đơn hàng đã đặt hàng thành công
        $countTransaction['1']=$this->transaction->where([
            ['status', '=', '1'],
        ])->count();
         // lấy số giao dịch đã tiếp nhận
        $countTransaction['2']=$this->transaction->where([
            ['status', '=', '2'],
        ])->count();
         // lấy số giao dịch đang vận chuyển
        $countTransaction['3']=$this->transaction->where([
            ['status', '=', '3'],
        ])->count();
         // lấy số giao dịch đã hoàn thành
        $countTransaction['4']=$this->transaction->where([
            ['status', '=', '4'],
        ])->count();
        // lấy 20 giao dịch mới nhất chưa được xử lý
        // trạng thái là 1 2 3
        $newTransaction=$this->transaction->whereIn('status',[1,2,3])->orderByDesc('created_at')->limit(20)->get();
        $topPayProduct=$this->product->orderByDesc('pay')->get();
        return view("admin/pages/index",[
            'totalTransaction'=>$totalTransaction,
            'totalMember'=>$totalMember,
            'totalProduct'=>$totalProduct,
            'totalPost'=>$totalPost,
            'countTransaction'=>$countTransaction,
            'newTransaction'=>$newTransaction,
            'topPayProduct'=>$topPayProduct,
            'listStatus'=>$this->listStatus,
        ]);
    }
}
