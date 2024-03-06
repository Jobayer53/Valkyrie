<?php

namespace App\Http\Controllers;

use App\Models\BillingDetails;
use App\Models\CustomerLogin;
use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use PDF;

class CustomerController extends Controller
{
    //customer profile
// PROFILE VIEW
function customer_profile(){
    $customers=  CustomerLogin::where('id', Auth::guard('customerlogin')->id())->get(); 
      return view('frontend.customer_profile',[
          'customers' => $customers,
      ]);
  }
    //customer profile update
    function customer_profile_update(Request $request){
       if($request->password == ''){
        if($request->profile_photo == ''){
            //intert without photo and password
            CustomerLogin::find(Auth::guard('customerlogin')->id())->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->mobile,
                'country'=>$request->country,
                'address'=>$request->address,
                'updated_at'=>Carbon::now(),
            ]);
            return back()->with('success', 'Profile Updated Successfully');
        }else{
             //intert with photo and without password
             $upload_file=$request->profile_photo;
             $extension=$upload_file->getClientOriginalExtension();
             $file_name= Auth::guard('customerlogin')->id().".".$extension;
             Image::make($upload_file)->save(public_path('uploads/customer/'.$file_name));
                CustomerLogin::find(Auth::guard('customerlogin')->id())->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'mobile'=>$request->mobile,
                    'country'=>$request->country,
                    'address'=>$request->address,
                    'photo'=>$file_name,
                    'updated_at'=>Carbon::now(),
                ]);
                return back()->with('success', 'Profile Updated Successfully');

    }
 }else {
    if($request->profile_photo == ''){
        //intert without photo and with password
        CustomerLogin::find(Auth::guard('customerlogin')->id())->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'mobile'=>$request->mobile,
            'country'=>$request->country,
            'address'=>$request->address,
            'password'=>bcrypt($request->password),
            'updated_at'=>Carbon::now(),
        ]);
        return back()->with('success', 'Profile Updated Successfully');
    }else{
         //intert with photo and with password
         $upload_file=$request->profile_photo;
         $extension=$upload_file->getClientOriginalExtension();
         $file_name= Auth::guard('customerlogin')->id().".".$extension;
         Image::make($upload_file)->save(public_path('uploads/customer/'.$file_name));
            CustomerLogin::find(Auth::guard('customerlogin')->id())->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'mobile'=>$request->mobile,
                'country'=>$request->country,
                'address'=>$request->address,
                'password'=>bcrypt($request->password),
                'photo'=>$file_name,
                'updated_at'=>Carbon::now(),
            ]);
            return back()->with('success', 'Profile Updated Successfully');

       }
     }
 }

    function download_invoice($order_id){
        $order_info = Order::find($order_id);
        $billing_info = BillingDetails::where('order_id', $order_info->order_id)->get();
        $order_product_info = OrderProduct::where('order_id', $order_info->order_id)->get();    
        $invoice = PDF::loadView('invoice.download_invoice', [
        'order_info' => $order_info,
        'billing_info' => $billing_info,
        'order_product_info' => $order_product_info,
        ]);
        return $invoice->download('itsolutionstuff.pdf');
    }
    function download(){
        return view('invoice.download_invoice');
    }


}