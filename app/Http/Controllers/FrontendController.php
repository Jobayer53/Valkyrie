<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\category;
use App\Models\Color;
use App\Models\Coupon;
use App\Models\CustomerLogin;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Size;
use App\Models\Thumbnail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    function index(){
        $categories = category::all();
        $products = Product::all();
        return view('frontend.index', [
            'categories' => $categories,
            'products'  => $products,
        ]);
    }
// DETAIS PAGE 
    function details($slug){
        $products = Product::where('slug', $slug)->get();
        $related_products = Product::where('category_id', $products->first()->category_id)->where('id','!=', $products->first()->id)->get();
        $categories = Category::where('id',$products->first()->category_id)->get();
        $thumbnails = Thumbnail::where('product_id', $products->first()->id)->get();
    
        $inventories = Inventory::where('product_id', $products->first()->id)
        ->groupBy('color_id')
        ->selectRaw('count(*) as total, color_id')->get();
        $sizes = Size::all();
        
     
        // foreach( $inventories  as $inventory){
        //    echo $inventory->color_id;
        // }
        // $sizes = Size::where('id', $inventories->first()->size_id)->get();
        // $colors = Color::where('id', $inventory->color_id)->get();
       


        return view('frontend.details',[
            'products' => $products,
            'categories' => $categories,
            'thumbnails' => $thumbnails,
            'inventories' => $inventories,
            'sizes' => $sizes,
            'related_products' => $related_products,
            
        ]);
    }

// AJAX SIZE SHOW 
    function get_size(Request $request){

      $sizes = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->get();
        
      $str = '';
      foreach($sizes as $size){
         
        $str .= '<div class="form-check size-option form-option form-check-inline mb-2">
                    <input class="form-check-input id_size" '.( $size->rel_to_size->id == 1 ? 'checked':'' ).' type="radio" name="size_id" id="'.$size->rel_to_size->id.'"  value="'.$size->rel_to_size->id.'" >


                    <input type="hidden" id="product_id" name="product_id" value="'.$request->product_id.'" >
                    <input type="hidden" id="color_id" name="color_id" value="'.$request->color_id.'" >

                   

                    <label class="form-option-label" for="'.$size->rel_to_size->id.'">'.$size->rel_to_size->size_name.'</label>
                </div>';
               
      }

        echo $str;
    }

// AJAX QUANTITY SHOW
    function get_quantity(Request $request){
        
        $quantity = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->first()->quantity;

        $qntty= '';
        for($i = 1; $i <= $quantity; $i++){

           $qntty .= ' <option value="'.$i.'">'.$i.'</option> ';
        };
        echo $qntty;

    }

// CUSTOMER / FRONTEND USERS
    function customer_register(){
        return view('frontend.customer_register');
    }
    function customer_login(){
        return view('frontend.customer_login');
    }

// CART PAGE VIEW
    function cart(Request $request){
        $coupon = $request->coupon_code;
        $message = null;
        $type = null;
        if($coupon == ''){
            $discount= 0;
        }
        else{
            if(Coupon::where('coupon_name', $coupon)->exists()){
                if(Carbon::now()->format('Y-m-d') >Coupon::where('coupon_name', $coupon)->first()->expire_date){
                    $message= ' Coupon Code Expired!';
                    $discount= 0;
                }
                else{
                    
                    $discount = Coupon::where('coupon_name', $coupon)->first()->discount;
                    $type = Coupon::where('coupon_name', $coupon)->first()->type;
                }
            }
            else{
                $message= 'Invalid Coupon Code!';
                $discount= 0;
            }
        }
       


        $carts = Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.cart',[
            'carts'=> $carts,
            'message'=> $message,
            'discount'=> $discount,
            'type'=> $type,
        ]);
    }

// SAME WORK BUT POST METHOD

    // function cart_coupon(Request $request){
    //    $coupon = $request->coupon_code;
      
        // if(Coupon::where('coupon_name', $coupon)->exists()){
        //    if(Carbon::now()->format('Y-m-d') >Coupon::where('coupon_name', $coupon)->first()->expire_date){
        //         return back()->with([
        //             'discount'=> 0,
        //             'invalid'=> ' Coupon Code Expired!',
        //         ]);
        //    }
        //    else{
        //     $discount = Coupon::where('coupon_name', $coupon)->first()->discount;
        //         return back()->with([
        //             'discount'=> $discount,
        //             'coupon'=> $coupon,
        //         ]);
        //    }
        // }
        // else{
        //     return back()->with([
        //         'discount'=> 0,
        //         'invalid'=> 'Invalid Coupon Code!',
        //     ]) ;
        // }

        // value="{{ (session('coupon'))?session('coupon'):'' }}"]
//
        // @if(session('invalid'))
        //     <div class="alert alert-danger" >{{ session('invalid') }}</div>
        // @endif
//
        // @if(session('discount'))
        // {{ session('discount') }}
        // @else
        // 0
        //  @endif
//
    // }


// PROFILE VIEW

    function show_wishlist(){
        $customers=  CustomerLogin::where('id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.customer_wishlist',[
            'customers' => $customers,
        ]);
    }
    function show_orderlist(){
        $customers=  CustomerLogin::where('id', Auth::guard('customerlogin')->id())->get(); 
        $orders = Order::where('customer_id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.customer_orderlist',[
            'customers' => $customers,
            'orders' => $orders,
        ]);
    }

       
      
 



}
