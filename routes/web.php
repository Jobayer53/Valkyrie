<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\CustomerRegisterController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\PDFController;


///
// Login



Auth::routes();
///
Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/product/details/{slug}', [FrontendController::class, 'details'])->name('details');
Route::post('/getSize', [FrontendController::class, 'get_size']);
Route::post('/getQuantity', [FrontendController::class, 'get_quantity']);

Route::get('/customer/register', [FrontendController::class, 'customer_register'])->name('customer.register');
Route::get('/customer/login', [FrontendController::class, 'customer_login'])->name('customer.login');
Route::get('/cart', [FrontendController::class, 'cart'])->name('cart');


//PROFILE -> ALL
Route::get('/show/wishlists', [FrontendController::class, 'show_wishlist'])->name('show.wishlist');
Route::get('/show/orderlist', [FrontendController::class, 'show_orderlist'])->name('show.orderlist');





Route::get('/home', [HomeController::class, 'index'])->name('home');

// USERS
Route::get('/user', [HomeController::class, 'users'])->name('user');
Route::get('/user/delete/{user_id}', [HomeController::class, 'user_delete'])->name('user.delete');
Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
Route::post('/profile/update', [HomeController::class, 'profile_update'])->name('profile.update');
Route::post('/photo/update', [HomeController::class, 'photo_update'])->name('photo.update');


// CATEGORY 
Route::get('/category', [CategoryController::class, 'category'])->name('category');
Route::post('/category/store', [CategoryController::class, 'category_store'])->name('category.store');
Route::get('/category/delete/{category_id}', [CategoryController::class, 'category_delete'])->name('category.delete');
Route::get('/category/hard_delete/{category_id}', [CategoryController::class, 'category_hard_delete'])->name('category.hard.delete');
Route::get('/category/edit/{category_id}', [CategoryController::class, 'category_edit'])->name('category.edit');
Route::post('/category/update', [CategoryController::class, 'category_update'])->name('category.update');
Route::get('/category/restore/{category_id}', [CategoryController::class, 'category_restore'])->name('category.restore');



//subcategory
Route::get('/subcategory', [SubcategoryController::class, 'subcategory'])->name('subcategory');
Route::post('/subcategory/store', [SubcategoryController::class, 'subcategory_store'])->name('subcategory.store');
Route::get('/subcategory/edit/{subcategory_id}', [SubcategoryController::class, 'subcategory_edit'])->name('subcategory.edit');
Route::get('/subcategory/delete/{subcategory_id}', [SubcategoryController::class, 'subcategory_delete'])->name('subcategory.delete');
Route::post('/subcategory/update', [SubcategoryController::class, 'subcategory_update'])->name('subcategory.update');



// PRODUCT 
Route::get('/add/product', [ProductController::class, 'add_product'])->name('add.product');
Route::post('/getsubcategory', [ProductController::class, 'getsubcategory']);
Route::post('/product/store', [ProductController::class, 'product_store'])->name('product.store');
Route::get('/product/delete/{product_id}', [ProductController::class, 'product_delete'])->name('product.delete');
Route::get('/product/list', [ProductController::class, 'product_list'])->name('product.list');



// VARIATION
Route::get('/variation', [ProductController::class,'variation'])->name('variation');
Route::post('/variation/store', [ProductController::class,'variation_store'])->name('variation.store');
Route::get('/color/delete/{color_id}', [ProductController::class,'color_delete'])->name('color.delete');
Route::get('/size/delete/{size_id}', [ProductController::class,'size_delete'])->name('size.delete');


// INVENTORY
Route::get('/inventory/{product_id}', [ProductController::class,'inventory'])->name('inventory');
Route::post('/inventory/store', [ProductController::class,'inventory_store'])->name('inventory.store');
Route::get('/inventory/delete/{inventory_id}', [ProductController::class,'inventory_delete'])->name('inventory.delete');



// CART 
Route::post('/add/cart', [CartController::class, 'add_cart'])->name('add.cart');
Route::get('/cart/remove{cart_id}', [CartController::class, 'cart_remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'cart_update'])->name('cart.update');

// WISHLIST
Route::post('/wishlist', [WishlistController::class, 'wishlist'])->name('wishlist');
Route::get('/wishlist/remove{wishlist_id}', [WishlistController::class, 'wishlist_remove'])->name('wishlist.remove');

// CUSTOMER 
Route::post('/customer/register/store', [CustomerRegisterController::class, 'customer_register_store'])->name('customer.register.store');
Route::post('/customer/login/check', [CustomerLoginController::class, 'customer_login_check'])->name('customer.login.check');
Route::get('/customer/logout', [CustomerLoginController::class, 'customer_logout'])->name('customer.logout');
Route::get('/customer/profile', [CustomerController::class, 'customer_profile'])->name('customer.profile');
Route::post('/customer/profile/update', [CustomerController::class, 'customer_profile_update'])->name('customer.profile_update');


// COUPON 
Route::get('/coupon', [CouponController::class, 'coupon'])->name('coupon');
Route::post('/add/coupon', [CouponController::class, 'add_coupon'])->name('add.coupon');
Route::get('/coupon/delete{coupon_id}', [CouponController::class, 'coupon_delete'])->name('coupon.delete');


// CHECKOUT
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/getCity', [CheckoutController::class, 'getcity']);
Route::post('/checkout/store', [CheckoutController::class, 'checkout_store'])->name('checkout.store');
Route::get('/order/success{abc}', [CheckoutController::class, 'order_success'])->name('order.success');
// Route::get('/complete/order', [CheckoutController::class, 'complete_order'])->name('complete.order');

// ORDERS 
Route::get('/orders', [OrderController::class, 'orders'])->name('orders');
Route::post('/order/status', [OrderController::class, 'order_status'])->name('order.status');


// INVOIVCE
Route::get('/download/invoice{order_id}', [CustomerController::class, 'download_invoice'])->name('download.invoice');
Route::get('/download_invoice', [CustomerController::class, 'download']);
// DOMPDF OR PAGE TO PDF DOWNLOAD
Route::get('generate-pdf', [PDFController::class, 'generatePDF']);
//END HERE

// SSLCOMMERZ Start
Route::get('/pay', [SslCommerzPaymentController::class, 'index'])->name('pay');
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);
Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);
Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END


// STRIPE 
Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});