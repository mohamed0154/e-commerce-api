<?php

namespace App\Http\Controllers\Carts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Carts\StoreCartRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use App\Traits\GetResponseJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    use GetResponseJson;


    // Store cart index
    public function store(StoreCartRequest $request)
    {

        $data = $request->all();
        $data['user_id'] = Auth::guard('sanctum')->user()->id;
        $product = Product::find($request->product_id);
        
        $check_if_exists = Cart::where([['user_id',$data['user_id'] ],[ 'product_id',$request->product_id]])->first();
        if($check_if_exists){
            return $this->setErrorMessage('the product exists');
        }

        if($product && $product->count == 0) {
            return $this->setErrorMessage('Products are empty');
        }

        $data =  Cart::create($data);
        return $this->setData($data, 'Success', 201);
    }


    // All cart's Products
    public function index(){
        $cart_products = Cart::with('user','product')->get();

        if(empty($cart_products)){
            return $this->setErrorMessage('Cart is Empty. You must add Products');
        }

        return $this->setData($cart_products,'Success');
    }


    // All user's Products
    public function show($cart){
        $user_products = Cart::with('product')->where('user_id',$cart)->get();

        if(empty($user_products)){
            return $this->setErrorMessage('Cart is Empty. You must add Products');
        }

        return $this->setData($user_products,'Success');
    }


    // increase
    public function increase($cart){

        $cart_item = $this->check_cart_item($cart);
        if(!$cart_item){return $this->setErrorMessage('the product not found');}
        
        $product = Product::find($cart_item->product_id);
        if($product && $cart_item->count < $product->count){
            $cart_item->count++;
            $cart_item->save();
            return $this->setSuccessMessage('success',$cart_item);
        }

        return $this->setErrorMessage('Get the maximum number of product');

    }


    // decrease
    public function decrease($cart){
        
        $cart_item = $this->check_cart_item($cart);
        if(!$cart_item){return $this->setErrorMessage('the product not found');}

        if($cart_item->count == 1){
            $cart_item->delete();
            return $this->setSuccessMessage('Product deleted from cart');
        }

        $cart_item->count--;
        $cart_item->save();
        return $this->setErrorMessage('success',$cart_item);

    }


    // delete
    public function destroy($cart){
        
        $cart_item = $this->check_cart_item($cart);
        if(!$cart_item){return $this->setErrorMessage('the product not found');}

        $cart_item->delete();

        return $this->setSuccessMessage('cart item deleted');

    }


    public function check_cart_item($cart){
        $cart_item = Cart::find($cart);
        if(!$cart_item){
            return null;
        }
        return $cart_item;
    }
}
