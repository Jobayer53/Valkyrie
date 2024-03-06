<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Inventory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
   
// ADD CART 
    function add_cart(Request $request){

      

        if(Auth::guard('customerlogin')->id()){
           $request->validate([
            'color_id'=> 'required',
            'size_id'=> 'required',
            'quantity'=> 'required',
           ],
           [
            'color_id.required' =>'Please Select Color!',
            'size_id.required' =>'Please Select Size!',
            'quantity.required' =>'Please Select Quantity!',
           ]);

           $inventory = Inventory::where('product_id', $request->product_id)->
           where('color_id', $request->color_id)->
           where('size_id',$request->size_id)->first()->quantity;
           
           if($inventory >= $request->quantity){
                
                if(Cart::where('customer_id',Auth::guard('customerlogin')->id())->where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id',$request->size_id)->exists()){

                    $cart_quantity = Cart::where('customer_id',Auth::guard('customerlogin')->id())->
                    where('product_id', $request->product_id)->
                    where('color_id', $request->color_id)->
                    where('size_id',$request->size_id)->first()->quantity;

                    if($inventory >= $request->quantity +$cart_quantity ){

                        Cart::where('customer_id',Auth::guard('customerlogin')->id())->
                            where('product_id', $request->product_id)->
                            where('color_id', $request->color_id)->
                            where('size_id',$request->size_id)->increment('quantity', $request->quantity);
                        return back()->with('update_cart', 'Cart Updated Successfully');
                    }
                    else{
                        return back()->with('stock_out', 'Out Of Stock! Total Stock:'.$inventory);
                    }
                    
                }
                else{
                   
                    Cart::insert([
                        'customer_id' => Auth::guard('customerlogin')->id(),
                        'product_id'  => $request->product_id,
                        'color_id'  => $request->color_id,
                        'size_id'  => $request->size_id,
                        'quantity'  => $request->quantity,
                        'created_at'=> Carbon::now(),
                    ]);
                    return back()->with('success', 'Cart Added Successfully');
                }

           }
           else{
            return back()->with('stock_out', 'Out Of Stock! Total Stock:'.$inventory);
           }
        }
        else{
           return redirect()->route('customer.login')->with('add_cart', 'Please Login To Add Cart');

        }
    }

// CART DELETE 
    function cart_remove($cart_id){
        Cart::find($cart_id)->delete();
        return back();
    }
// CART UPDATE 
    function cart_update(Request $request){
    // $carts = $request->all();
    foreach($request->quantity as $key => $cart){
        Cart::find($key)->update([
            'quantity'=>$cart,
        ]);
    } 
    return back();
    }





}
