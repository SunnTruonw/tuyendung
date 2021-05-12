<?php

namespace App\Http\Controllers;

use App\Helper\CartHelper;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Point;
use App\Models\City;
use App\Models\District;
use App\Models\Commune;

use App\Helper\AddressHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Setting;

class ShoppingCartController extends Controller
{
    //

    private $product;
    private $point;
    private $order;
    private $cart;
    private $city;
    private $district;
    private $commune;
    private $transaction;
    private $unit;
    private $pointUnit;
    private $setting;
    private $typePoint;
    public function __construct(Product $product, City $city, District $district, Commune $commune, Order $order, Transaction $transaction, Setting $setting, Point $point)
    {
        $this->product = $product;
        $this->point = $point;
        $this->order = $order;
        $this->city = $city;
        $this->district = $district;
        $this->commune = $commune;
        $this->transaction = $transaction;
        $this->setting = $setting;
        $this->unit = "đ";
        $this->pointUnit = config('point.pointUnit');
        $this->typePoint = config('point.typePoint');
    }
    public function list()
    {
        $numberPoint = 0;
        $address = new AddressHelper();
        $data = $this->city->orderby('name')->get();
        $cities = $address->cities($data);
        $this->cart = new CartHelper();
        $data = $this->cart->cartItems;
      //  dd($data);
        $totalPrice =  $this->cart->getTotalPrice();
        $totalQuantity =  $this->cart->getTotalQuantity();
        $totalOldPrice = $this->cart->getTotalOldPrice();

        $totalPriceMoney = $totalPrice;
        $totalPricePoint = 0;

        // dd( $totalOldPrice);
        $user = auth()->guard('web')->user();
        $sumPointCurrent = $this->point->sumPointCurrent($user->id);
       // dd($this->cart->cartItems);
        return view('frontend.pages.cart', [
            'data' => $data,
            'cities' => $cities,
            'totalPrice' => $totalPrice,
            'totalQuantity' => $totalQuantity,
            'totalOldPrice' => $totalOldPrice,
            'unit' => $this->unit,
            'sumPointCurrent' => $sumPointCurrent,
            'totalPriceMoney'=>$totalPriceMoney,
            'totalPricePoint'=>$totalPricePoint,
            'pointUnit' => $this->pointUnit,
            'usePoint' => $numberPoint,
        ]);
    }

    public function add($id)
    {
        $this->cart = new CartHelper();

        $product = $this->product->find($id);

        $this->cart->add($product);
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
    public function remove($id, Request $request)
    {
        $user = auth()->guard('web')->user();
        $sumPointCurrent = $this->point->sumPointCurrent($user->id);



        $this->cart = new CartHelper();
        $this->cart->remove($id);
        $totalPrice =  $this->cart->getTotalPrice();
        $totalQuantity =  $this->cart->getTotalQuantity();

        $totalOldPrice =  $this->cart->getTotalOldPrice();
        //    dd( $totalOldPrice);
        $numberPoint = 0;
        $errorNumberPoint = false;
        if ($request->has('usePoint')) {

            $numberPoint = (int)$request->input('usePoint');
            if ($numberPoint) {
                //  dd($numberPoint);
                if ($numberPoint > $sumPointCurrent) {
                    $errorNumberPoint = "Số điểm sử dụng phải nhỏ hơn số điểm hiện có :" . $sumPointCurrent . " " . $this->pointUnit;
                    $totalPriceMoney = $totalPrice;
                    $totalPricePoint = 0;
                } elseif (pointToMoney($numberPoint) > $totalPrice) {
                    $errorNumberPoint = "Số điểm sử dụng tương đương với ".number_format(pointToMoney($numberPoint))." ".$this->unit." nhỏ hơn tổng giá trị sản phẩm:" . number_format($totalPrice) . " " . $this->unit;
                    $totalPriceMoney = $totalPrice;
                    $totalPricePoint = 0;
                } else {
                    $totalPriceMoney = $totalPrice - pointToMoney($numberPoint);
                    $totalPricePoint = $numberPoint;
                }
            }else{
                $totalPriceMoney=$totalPrice;
                $totalPricePoint=0;
            }
        } else {
            $totalPriceMoney = $totalPrice - pointToMoney($numberPoint);
            $totalPricePoint = $numberPoint;
        }
        //   dd($errorNumberPoint);
        // dd($totalPriceMoney);
        $totalQuantity =  $this->cart->getTotalQuantity();
        return response()->json([
            'code' => 200,
            'htmlcart' => view('frontend.components.cart-component', [
                'data' => $this->cart->cartItems,
                'totalPrice' => $totalPrice,
                'totalQuantity' => $totalQuantity,

                'totalPriceMoney' => $totalPriceMoney,
                'totalPricePoint' => $totalPricePoint,
                'sumPointCurrent' => $sumPointCurrent,
                'totalOldPrice' => $totalOldPrice,
                'errorNumberPoint' => $errorNumberPoint,
                'usePoint' => $numberPoint,
                'pointUnit' => $this->pointUnit,
                'unit' => $this->unit,

            ])->render(),
            // 'totalPrice' => $totalPrice,
            'messange' => 'success'
        ], 200);
    }
    public function update($id, Request $request)
    {

        $user = auth()->guard('web')->user();
        $sumPointCurrent = $this->point->sumPointCurrent($user->id);
        $this->cart = new CartHelper();
        $quantity = $request->quantity;
        if($id){
            $this->cart->update($id, $quantity);
        }
        $totalPrice =  $this->cart->getTotalPrice();
        $totalOldPrice =  $this->cart->getTotalOldPrice();
        //    dd( $totalOldPrice);
        $numberPoint = 0;
        $errorNumberPoint = false;

        if ($request->has('usePoint')) {

            $numberPoint = (int)$request->input('usePoint');
          //  dd( $totalPrice);
            if ($numberPoint) {
                //  dd($numberPoint);
                if ($numberPoint > $sumPointCurrent) {
                    $errorNumberPoint = "Số điểm sử dụng phải nhỏ hơn số điểm hiện có :" . number_format($sumPointCurrent) . " " . $this->pointUnit;
                    $totalPriceMoney = $totalPrice;
                    $totalPricePoint = 0;
                } elseif (pointToMoney($numberPoint) > $totalPrice) {
                    $errorNumberPoint = "Số điểm sử dụng tương đương với ".number_format(pointToMoney($numberPoint))." ".$this->unit." nhỏ hơn tổng giá trị sản phẩm:" . number_format($totalPrice) . " " . $this->unit;
                    $totalPriceMoney = $totalPrice;
                    $totalPricePoint = 0;
                } else {
                    $totalPriceMoney = $totalPrice - pointToMoney($numberPoint);
                    $totalPricePoint = $numberPoint;
                }
            }else{
                $totalPriceMoney=$totalPrice;
                $totalPricePoint=0;
            }
        } else {
            $totalPriceMoney = $totalPrice - pointToMoney($numberPoint);
            $totalPricePoint = $numberPoint;
        }



        //   dd($totalPriceMoney);
        //   dd($errorNumberPoint);
        // dd($totalPriceMoney);
        $totalQuantity =  $this->cart->getTotalQuantity();
        return response()->json([
            'code' => 200,
            'htmlcart' => view('frontend.components.cart-component', [
                'data' => $this->cart->cartItems,
                'totalPrice' => $totalPrice,
                'totalPriceMoney' => $totalPriceMoney,
                'totalPricePoint' => $totalPricePoint,
                'totalQuantity' => $totalQuantity,
                'sumPointCurrent' => $sumPointCurrent,
                'totalOldPrice' => $totalOldPrice,
                'errorNumberPoint' => $errorNumberPoint,
                'usePoint' => $numberPoint,
                'pointUnit' => $this->pointUnit,
                'unit' => $this->unit,
            ])->render(),
            // 'totalPrice' => number_format($totalPrice),
            // 'totalQuantity' => number_format($totalQuantity),
            // 'totalPriceMoney'=>number_format($totalPriceMoney),
            // 'totalPricePoint'=>number_format($totalPricePoint),
            // 'totalOldPrice'=>number_format($totalOldPrice),
            // 'sumPointCurrent'=>$sumPointCurrent,
            'messange' => 'success'
        ], 200);
    }
    public function clear()
    {
        $this->cart = new CartHelper();
        $this->cart->clear();
        $totalPrice =  $this->cart->getTotalPrice();
        $totalQuantity =  $this->cart->getTotalQuantity();
        return response()->json([
            'code' => 200,
            'htmlcart' => view('frontend.components.cart-component', [
                'data' => $this->cart->cartItems,
                'totalPrice' => $totalPrice,
                'totalQuantity' => $totalQuantity,
            ])->render(),
            'totalPrice' => $totalPrice,
            'totalQuantity' => $totalQuantity,
            'messange' => 'success'
        ], 200);
    }

    public function postOrder(Request $request)
    {
         $this->cart = new CartHelper();
        $dataCart = $this->cart->cartItems;
        if(count($dataCart)){
            try {
                DB::beginTransaction();

                //  dd($dataCart);
                $totalPrice =  $this->cart->getTotalPrice();
                $totalQuantity =  $this->cart->getTotalQuantity();
                // $dataOrderCreate = [
                //     "quantity" => $request->input('quantity'),
                // ];

                $dataTransactionCreate = [
                    'total' => $totalPrice,
                    'point' => $request->input('usePoint')?$request->input('usePoint'):0,
                    'money'=>$totalPrice - (pointToMoney($request->input('usePoint')?$request->input('usePoint'):0)),
                    'name' => $request->input('name'),
                    'phone' => $request->input('phone'),
                    'note' => $request->input('note'),
                    'email' => $request->input('email'),
                    'status' => 1,
                    'city_id' => $request->input('city_id'),
                    'district_id' => $request->input('district_id'),
                    'commune_id' => $request->input('commune_id'),
                    'address_detail' => $request->input('address_detail'),
                    'admin_id' => 0,
                    'user_id' => Auth::check() ? Auth::user()->id : 0,
                ];

                if($request->has('usePoint')){
                    if($request->input('usePoint')){
                        $dataTransactionCreate['point'] =$request->input('usePoint');
                        $dataTransactionCreate['money']=$totalPrice -pointToMoney($dataTransactionCreate['point']);

                        $user = auth()->guard('web')->user();
                        if ($user) {
                            $user->points()->create([
                                'type' => $this->typePoint[6]['type'],
                                'point' =>0- $dataTransactionCreate['point'],
                                'active' => 1,
                            ]);
                        }
                    }else{
                        $dataTransactionCreate['point'] =0;
                        $dataTransactionCreate['money']=$totalPrice;
                    }
                }

            //    dd($this->transaction);
                $transaction = $this->transaction->create($dataTransactionCreate);
                $dataOrderCreate = [];
                foreach ($dataCart as $cart) {
                    $dataOrderCreate[] = [
                        'name' => $cart['name'],
                        'quantity' => $cart['quantity'],
                        'new_price' => $cart['totalPriceOneItem'],
                        'old_price' => $cart['totalOldPriceOneItem'],
                        'avatar_path' => $cart['avatar_path'],
                        'sale' => $cart['sale'],
                        'product_id' => $cart['id'],
                    ];
                    $product = $this->product->find($cart['id']);
                    $pay = $product->pay;
                    $product->update([
                        'pay' => $pay + $cart['quantity'],
                    ]);
                }
                //   dd($dataOrderCreate);
                // insert database in orders table by createMany
                $transaction->orders()->createMany($dataOrderCreate);



                $this->cart->clear();
                DB::commit();
                return redirect()->route('cart.order.sucess', ['id' => $transaction->id])->with("sucess", "Đặt hàng thành công");
            } catch (\Exception $exception) {
                //throw $th;
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return redirect()->route('cart.order.sucess', ['id' => $transaction->id])->with("error", "Đặt hàng không thành công");
            }
        }else{
            return;
        }

    }
    public function getOrderSuccess(Request $request)
    {
        $id = $request->id;
        $data = $this->transaction->find($id);
        return view('frontend.pages.order-sucess', [
            'data' => $data,
            'pointUnit' => $this->pointUnit,
            'unit' => $this->unit,
        ]);
    }
}
