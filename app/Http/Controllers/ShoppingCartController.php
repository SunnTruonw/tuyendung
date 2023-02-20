<?php

namespace App\Http\Controllers;

use App\Helper\CartHelper;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Product;

use App\Models\City;
use App\Models\District;
use App\Models\Commune;

use App\Helper\AddressHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Setting;
use App\Http\Requests\Frontend\ValidateAddOrder;
class ShoppingCartController extends Controller
{
    //

    private $product;
    private $order;
    private $cart;
    private $city;
    private $district;
    private $commune;
    private $transaction;
    private $unit;
    private $setting;
   // private $viewCartComponent='frontend.pages.cart.cart-component';
    private $viewCartComponent='frontend.pages.cart.cart-component-by-user';
    public function __construct(Product $product, City $city, District $district, Commune $commune, Order $order, Transaction $transaction,Setting $setting)
    {
        $this->product = $product;
        $this->order = $order;
        $this->city = $city;
        $this->district = $district;
        $this->commune = $commune;
        $this->transaction = $transaction;
        $this->setting=$setting;
        $this->unit="đ";
    }
    public function list()
    {
        $address = new AddressHelper();
        $data = $this->city->orderby('name')->get();
        $cities = $address->cities($data);
      //  dd($this->city->get());
        $this->cart = new CartHelper();
        $data = $this->cart->cartItems;
        $totalPrice =  $this->cart->getTotalPrice();
        $totalOldPrice =  $this->cart->getTotalOldPrice();

        $totalQuantity =  $this->cart->getTotalQuantity();
        $vanchuyen=$this->setting->find(140);
        $thanhtoan=$this->setting->find(139);
        $chinhanh=$this->setting->find(143);
        $dataByUser= $this->cart->getGroupItemByUser();

        return view('frontend.pages.cart.cart', [
            'dataByUser'=>$dataByUser,
            'data' => $data,
            'cities' => $cities,
            'totalPrice' => $totalPrice,
            'totalQuantity' => $totalQuantity,
            'totalOldPrice'=>$totalOldPrice,
            'vanchuyen'=>$vanchuyen,
            'thanhtoan'=>$thanhtoan,
            'chinhanh'=>$chinhanh,
        ]);
    }

    public function add($id,Request $request)
    {
        $this->cart = new CartHelper();

        $quantity=1;
        if($request->has('quantity')&&$request->input('quantity')){
            $quantity=(int) $request->input('quantity');
            if($quantity<=0){
                $quantity=1;
            }
        }

        if($request->has('option')&&$request->input('option')){
           // dd($this->product->mergeOption($request->input('option'))->where('products.id',$id)->get());
            $product=  $this->product->join('options', 'products.id', '=', 'options.product_id')
           ->select('products.*', 'options.size as size', 'options.price as price', 'options.id as option_id')
            ->where('options.id',$request->input('option'))
            ->where('products.id',$id)
           ->first();
        }else{
            $product = $this->product->find($id);
        }

        //  dd($quantity);
        $this->cart->add($product,$quantity);

      //  dd($this->cart->cartItems);
        return response()->json([
            'code' => 200,
            'messange' => 'success'
        ], 200);
    }
    public function buy($id)
    {
        $this->cart = new CartHelper();

        $product = $this->product->find($id);

        $this->cart->add($product);
      //  dd($this->cart->cartItems);
        return redirect()->route("cart.list");
    }
    public function remove($id,Request $request)
    {
        $this->cart = new CartHelper();
        if($request->option){
            $this->cart->remove($id,$request->option);
        }else{
            $this->cart->remove($id);
        }

        $totalPrice =  $this->cart->getTotalPrice();
        $totalQuantity =  $this->cart->getTotalQuantity();
        $totalOldPrice =  $this->cart->getTotalOldPrice();
        return response()->json([
            'code' => 200,
            'htmlcart' => view($this->viewCartComponent, [
                'data' => $this->cart->cartItems,
                'totalPrice' => $totalPrice,
                'totalQuantity' => $totalQuantity,
                'totalOldPrice'=>$totalOldPrice,
            ])->render(),
            'totalPrice' => $totalPrice,
            'messange' => 'success'
        ], 200);
    }
    public function update($id, Request $request)
    {
        $this->cart = new CartHelper();
        $quantity = $request->quantity;
        if($request->option){
            $this->cart->update($id, $quantity,$request->option);
        }else{
            $this->cart->update($id, $quantity);
        }

        $totalPrice =  $this->cart->getTotalPrice();
        $totalQuantity =  $this->cart->getTotalQuantity();
        $totalOldPrice =  $this->cart->getTotalOldPrice();
        return response()->json([
            'code' => 200,
            'htmlcart' => view($this->viewCartComponent, [
                'data' => $this->cart->cartItems,
                'totalPrice' => $totalPrice,
                'totalQuantity' => $totalQuantity,
                'totalOldPrice'=>$totalOldPrice,
            ])->render(),
            'totalPrice' => $totalPrice,
            'totalQuantity' => $totalQuantity,
            'messange' => 'success'
        ], 200);
    }
    public function clear()
    {
        $this->cart = new CartHelper();
        $this->cart->clear();
        $totalPrice =  $this->cart->getTotalPrice();
        $totalQuantity =  $this->cart->getTotalQuantity();
        $totalOldPrice =  $this->cart->getTotalOldPrice();
        return response()->json([
            'code' => 200,
            'htmlcart' => view($this->viewCartComponent, [
                'data' => $this->cart->cartItems,
                'totalPrice' => $totalPrice,
                'totalQuantity' => $totalQuantity,
                'totalOldPrice'=>$totalOldPrice,
            ])->render(),
            'totalPrice' => $totalPrice,
            'totalQuantity' => $totalQuantity,
            'messange' => 'success'
        ], 200);
    }

    public function postOrder(ValidateAddOrder $request)
    {

        $this->cart = new CartHelper();
        $dataCart = $this->cart->cartItems;
        //  dd($request->all());
        if(!count($dataCart)){
            return redirect()->route('cart.order.error')->with("error", "Đặt hàng không thành công! Bạn chưa chọn sản phẩm nào");
        }

        try {
            DB::beginTransaction();
            $dataByUser= $this->cart->getGroupItemByUser();
            $group =  makeGroupTransaction($this->transaction);
            foreach ($dataByUser as $key => $dataOfUser) {
                $totalPrice =  $dataOfUser['totalPriceByUser'];
                $totalQuantity =  $dataOfUser['totalQuantityByUser'];
                $dataTransactionCreate = [
                    'total' => $totalPrice,
                    'name' => $request->input('name'),
                    'phone' => $request->input('phone'),
                    'note' => $request->input('note'),
                    'email' => $request->input('email'),
                    'status' => 1,
                    'city_id' => $request->input('city_id'),
                    'district_id' => $request->input('district_id'),
                    'commune_id' => $request->input('commune_id'),
                    'address_detail' => $request->input('address_detail'),
                    'httt' => $request->input('httt'),
                    'cn' => $request->input('cn'),
                    'admin_id' => 0,
                    'user_id' => Auth::check() ? Auth::user()->id : 0,
                    'code'=>makeCodeTransaction($this->transaction),
                    'origin_id'=>$key?$key:null,
                    'group'=>$group,
                ];
                //  dd($dataTransactionCreate);
                $transaction = $this->transaction->create($dataTransactionCreate);
                // dd($transaction);
                $dataOrderCreate = [];
                foreach ($dataOfUser['item'] as $cart) {

                    $dataOrderCreate[] = [
                        'name' => $cart['name'],
                        'quantity' => $cart['quantity'],
                        'new_price' => $cart['totalPriceOneItem'],
                        'old_price' => $cart['totalOldPriceOneItem'],
                        'avatar_path' => $cart['avatar_path'],
                        'sale' => $cart['sale'],
                        'size' => $cart['size'],
                        'option_id' => $cart['option_id']??0,
                        'product_id' => $cart['id'],
                    ];

                    $product=$this->product->find($cart['id']);
                    $pay= $product->pay;
                    $product->update([
                        'pay'=>$pay+$cart['quantity'],
                    ]);
                }
                // insert database in orders table by createMany
                $transaction->orders()->createMany($dataOrderCreate);
            }

            $this->cart->clear();
            DB::commit();
           return redirect()->route('cart.order.sucess',['id'=>$group])->with("sucess", "Đặt hàng thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
          return redirect()->route('cart.order.error')->with("error", "Đặt hàng không thành công");
        }
    }
    public function getOrderSuccess(Request $request){
        $group=$request->id;
        $data = $this->transaction->where('group',$group)->get();
        $count =$this->transaction->select(Transaction::raw('SUM(total) as total_money'))->where('group',$group)->first()->total_money;
        // dd($count);
        return view('frontend.pages.cart.order-sucess', [
             'data' => $data,
             'count'=>$count
        ]);
    }
    public function getOrderError(Request $request){
        $data = null;
        return view('frontend.pages.cart.order-sucess', [
             'data' => $data,
        ]);
    }
    public function checkLogin(Request $request){
        if (!Auth::check()) {
            session()->put('urlBack', route('cart.list'));
            return redirect()->route('login');
        }
        return redirect()->route('cart.list');
    }

    // store order

}
