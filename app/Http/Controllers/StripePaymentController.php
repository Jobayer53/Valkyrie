<?php
    
namespace App\Http\Controllers;
     
use Illuminate\Http\Request;
use Session;
use Stripe;
use App\Mail\InvoiceMail;
use App\Models\BillingDetails;
use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Str;
     
class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('stripe');
    }
    
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        $data = session('data');
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => 100 *$data['sub_total']+ $data['charge'],
                "currency" => "bdt",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com." 
        ]);
      
// ORDER
    $order_id= '#'. Str::upper(Str::random(3)).'-'.rand(99999999999,10000000000);
    Order::insert([
       'order_id'      => $order_id,
       'customer_id'   => Auth::guard('customerlogin')->id(),
       'sub_total'     => $data['sub_total'],
       'total'         => $data['sub_total'] + $data['charge'],
       'discount'      => $data['discount'],
       'charge'        => $data['charge'],
       'payment_method'=> $data['payment_method'],
       'created_at'    => Carbon::now(),

    ]);
// BILLING DETAILS 
    BillingDetails::insert([
       'order_id'     => $order_id,
       'customer_id'  => Auth::guard('customerlogin')->id(),
       'name'         =>$data['name'],
       'email'        =>$data['email'],
       'company'      =>$data['company'],
       'mobile_number'=>$data['mobile_number'],
       'address'      =>$data['address'],
       'country_id'   =>$data['country_id'],
       'city_id'      =>$data['city_id'],
       'zip'          =>$data['zip'],
       'notes'        =>$data['notes'],
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
    }




}