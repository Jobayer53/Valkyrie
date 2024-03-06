<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\BillingDetails;
use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;

use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;


class CheckoutController extends Controller
{
   function checkout(){
      $total_count = Cart::where('customer_id', Auth::guard('customerlogin')->id())->count();
      $carts = Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
      $countries = Country::all();
      $cities = City::all();
    return view('frontend.checkout',[
      'total_count'=> $total_count,
      'carts' => $carts,
      'countries' => $countries,
      'cities' => $cities,
    ]);
   }
//  COUNTRY AND CITY SHOW 
   function getcity(Request $request){
      $cities = City::where('country_id', $request->country_id)->get();
      $str = '<option value="">-- Select City --</option>' ;
      foreach($cities as $city){
         $str .= '<option value="'.$city->id.'">'.$city->name.'</option>' ;
      }      
      echo $str;
   }
// CHECKOUT STORE
    function checkout_store(Request $request){
      if($request->payment_method == 1){
// ORDER
      $order_id= '#'. Str::upper(Str::random(3)).'-'.rand(99999999999,10000000000);
      Order::insert([
         'order_id'      => $order_id,
         'customer_id'   => Auth::guard('customerlogin')->id(),
         'sub_total'     => $request->sub_total,
         'total'         => $request->sub_total + $request->charge,
         'discount'      => $request->discount,
         'charge'        => $request->charge,
         'payment_method'=> $request->payment_method,
         'created_at'    => Carbon::now(),

      ]);
// BILLING DETAILS 
      BillingDetails::insert([
         'order_id'     => $order_id,
         'customer_id'  => Auth::guard('customerlogin')->id(),
         'name'         =>$request->name,
         'email'        =>$request->email,
         'company'      =>$request->company,
         'mobile_number'=>$request->mobile_number,
         'address'      =>$request->address,
         'country_id'   =>$request->country_id,
         'city_id'      =>$request->city_id,
         'zip'          =>$request->zip,
         'notes'        =>$request->notes,
         'created_at'   =>Carbon::now(),

      ]);
// ORDERD PRODUCTS
      $carts = Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
      foreach($carts as $cart ){
         OrderProduct::insert([
            'order_id'     => $order_id,
            'customer_id'  => Auth::guard('customerlogin')->id(),
            'product_id'   => $cart->product_id,
            'price'        => $cart->rel_to_product->after_discount,
            'color_id'     => $cart->color_id,   
            'size_id'      => $cart->size_id,
            'quantity'     => $cart->quantity,
            'created_at'   => Carbon::now(),

         ]);
         Inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quantity', $cart->quantity);
      }


// SENDING MAIL TO USER
      // Mail::to($request->email)->send(new InvoiceMail($order_id));
// SENDING SMS TO USER 
      // $url = "http://66.45.237.70/api.php";
      // $number=$request->mobile_number;
      // $text="Congratulations! your order has been successfully placed! Please ready TK: 3736(include vat.)";
      // $data= array(
      // 'username'=>"01834833973",
      // 'password'=>"TE47RSDM",
      // 'number'=>"$number",
      // 'message'=>"$text"
      // );

      // $ch = curl_init(); // Initialize cURL
      // curl_setopt($ch, CURLOPT_URL,$url);
      // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
      // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      // $smsresult = curl_exec($ch);
      // $p = explode("|",$smsresult);
      // $sendstatus = $p[0];
//    DELETE AFTER ORDER 
      // Cart::where('customer_id',  Auth::guard('customerlogin')->id())->delete();
      $abc = substr($order_id, 1,15);
      return redirect()->route('order.success',$abc)->with([
         'success' => 'success fully added',
     
      ]);
      // return redirect()->route('complete.order')->with('order_id',$order_id);

      }
// SSL COMMERZ 
      else if($request->payment_method == 2){
         $data = $request->all();
         return redirect()->route('pay')->with('data', $data);
      }
      else{
         $data = $request->all();
         return view('frontend.stripe',[
            'data'=> $data,
         ]);
      }


    }

    function order_success($abc){
      if(session('success')){
           return view('frontend.complete_order', [
         'order_id'=> $abc,
      ]);
      }
      else{
         abort('404');
      }
   
     

    }



}
