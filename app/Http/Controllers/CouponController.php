<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    function coupon(){
        $coupons= Coupon::all();
        return view('admin.coupon.coupon', [
            'coupons' =>$coupons,
        ]);
    }
// COUPON INSERT
    function add_coupon(Request $request){
        Coupon::insert([
            'coupon_name' => $request->coupon_name,
            'discount' => $request->discount,
            'expire_date' => $request->expire_date,
            'type' => $request->type,
            'created_at' => Carbon::now(),
        ]);
        return back();
    }

// COUPON DELTE
    function coupon_delete($coupon_id){
        Coupon::find($coupon_id)->delete();
        return back();
    }


}
