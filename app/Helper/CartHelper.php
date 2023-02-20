<?php

namespace App\Helper;

use Illuminate\Http\Request;

use function PHPSTORM_META\map;

//use Illuminate\Support\Facades\Session;
class CartHelper
{
    public $cartItems = [];
    public $totalQuantity = 0;
    public $totalPrice = 0;
    public $totalOldPrice = 0;

    public function __construct()
    {
        // session()->flush();

        $this->cartItems = session()->has('cart') ? session('cart') : [];
        //   $this->cartItems = Session::has('cart') ? Session::session('cart') : [];
        $this->totalQuantity = $this->getTotalQuantity();
        $this->totalPrice = $this->getTotalPrice();
        $this->totalOldPrice = $this->getTotalOldPrice();
    }
    public function add($product, $quantity = 1)
    {
        if (isset($this->cartItems[$product->id])) {
            $this->cartItems[$product->id]['quantity'] +=  $quantity;
            $this->cartItems[$product->id]['totalPriceOneItem'] = $this->getTotalPriceOneItem($this->cartItems[$product->id]);
            $this->cartItems[$product->id]['totalOldPriceOneItem'] = $this->getTotalOldPriceOneItem($this->cartItems[$product->id]);
        } else {
            $option_id=$product->option_id;
            if(!$product->option_id){
                $option_id=0;
            }
            $cartItem = [
                'id' => $product->id,
                'option_id'=>$product->option_id,
                'price' => $product->price,
                'sale' => $product->sale,
                'size'=>$product->size,
                'name' => $product->name,
                'avatar_path' => $product->avatar_path,
                'quantity' => $quantity,
                'user_id' => $product->user_id,
            ];
            $cartItem['totalPriceOneItem'] = $this->getTotalPriceOneItem($cartItem);
            $cartItem['totalOldPriceOneItem'] = $this->getTotalOldPriceOneItem($cartItem);
            $this->cartItems[$product->id.'-'.$option_id] = $cartItem;
        }
        session(['cart' => $this->cartItems]);
        $this->resetCartItem();
    }
    public function remove($id,$option_id=0)
    {
        if (isset($this->cartItems[$id.'-'.$option_id])) {
            unset($this->cartItems[$id.'-'.$option_id]);
        }
        // Session::put('cart' , $this->cartItems);
        session(['cart' => $this->cartItems]);
        $this->resetCartItem();
    }
    public function update($id, $quantity,$option_id=0)
    {
        if (isset($this->cartItems[$id.'-'.$option_id])) {
            $this->cartItems[$id.'-'.$option_id]['quantity'] = $quantity;
            $this->cartItems[$id.'-'.$option_id]['totalPriceOneItem'] = $this->getTotalPriceOneItem($this->cartItems[$id.'-'.$option_id]);
            $this->cartItems[$id.'-'.$option_id]['totalOldPriceOneItem'] = $this->getTotalOldPriceOneItem($this->cartItems[$id.'-'.$option_id]);
        }
        //  Session::put('cart' , $this->cartItems);
        session(['cart' => $this->cartItems]);
        $this->resetCartItem();
    }
    public function clear()
    {
        $this->cartItems = [];
        session()->forget('cart');
        $this->resetCartItem();
    }
    public function getTotalPriceOneItem($item)
    {
        $t = 0;
        $t +=  $item['price'] * (100 - $item['sale']) / 100 * $item['quantity'];
        return $t;
    }
    public function getTotalOldPriceOneItem($item)
    {
        $t = 0;
        $t +=  $item['price']  * $item['quantity'];
        return $t;
    }
    public function getTotalPrice()
    {
        $tP = 0;
        if ($this->cartItems) {
            foreach ($this->cartItems as $cartItem) {
                $tP +=  $cartItem['price'] * (100 - $cartItem['sale']) / 100 * $cartItem['quantity'];
            }
        }
        return $tP;
    }

    public function getTotalOldPrice()
    {
        $tP = 0;
        if ($this->cartItems) {
            foreach ($this->cartItems as $cartItem) {
                $tP +=  $cartItem['price']  * $cartItem['quantity'];
            }
        }
        return $tP;
    }

    public function getTotalQuantity()
    {
        $tQ = 0;
        foreach ($this->cartItems as $cartItem) {
            $tQ += $cartItem['quantity'];
        }
        return $tQ;
    }
    public function resetCartItem(){
        $this->cartItems = session()->has('cart') ? session('cart') : [];
        return $this;
    }
    public function  getGroupItemByUser(){
        $data=collect($this->cartItems)->groupby('user_id');
        $data= $data->map(function($value,$index){
            $item=collect();
           // dd($value,$index);
            $item['item']=$value;

            $item['totalPriceByUser']=$this->getTotalPriceByUser($value);
            $item['totalOldPriceByUser']=$this->getTotalOldPriceByUser($value);
            $item['totalQuantityByUser']=$this->getTotalQuantityByUser($value);
            return $item;
        });
        return $data;
    }

    public function getTotalPriceByUser($data=[])
    {
        $tP = 0;
        if ($data) {
            foreach ($data as $cartItem) {
                $tP +=  $cartItem['price'] * (100 - $cartItem['sale']) / 100 * $cartItem['quantity'];
            }
        }
        return $tP;
    }
    public function getTotalOldPriceByUser($data=[])
    {
        $tP = 0;
        if ($data) {
            foreach ($data as $cartItem) {
                $tP +=  $cartItem['price']  * $cartItem['quantity'];
            }
        }
        return $tP;
    }
    public function getTotalQuantityByUser($data=[])
    {
        $tQ = 0;
        foreach ($data as $cartItem) {
            $tQ += $cartItem['quantity'];
        }
        return $tQ;
    }
}
