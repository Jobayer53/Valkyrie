<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
   function wishlist(Request $request){

      if(Auth::guard('customerlogin')->id()){
         if(wishlist::where('customer_id', $request->customer_id)->where('product_id', $request->product_id)->exists()){
            return back()->with('wishlist_extists' , 'Alreday Added!');
         }
         else{
               Wishlist::insert([
                  'product_id'=> $request->product_id,
                  'customer_id'=> $request->customer_id,
                  'created_at'=>Carbon::now(),
               ]);
               return back()->with('wl_success', 'Added To Wishlist');
         }
  
      }
      else{
          return redirect()->route('customer.login')->with('add_wishlist', 'Please Login To Add Wishlist');
      }
   }
// WISH LIST REMOVE
   function wishlist_remove($wishlist_id){
      Wishlist::find($wishlist_id)->delete();
      return back();
   }





}
