<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\Thumbnail;
use Carbon\Carbon;
use League\CommonMark\Extension\CommonMark\Parser\Inline\BangParser;

use Intervention\Image\Facades\Image;
use Str;


class ProductController extends Controller
{

//ADD PRODUCT 
    function add_product(){
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.product.addproduct', [
            'categories'=> $categories,
            'subcategories'=> $subcategories,
        ]);
    }

// AJAX SUBCATEGORY SELECT 
    function getsubcategory(Request $request){
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        $str = '<option value="">-- SELECT SUBCATEGORY --</option>';
        foreach($subcategories as $subcategory){
            $str .= '<option value="'.$subcategory->id.'">'.$subcategory->subcategory_name.'</option>';
        }
        echo $str;
    }

// PRODUCT INSERT 
    function product_store(Request $request){
       $product_id = Product::insertGetId([
            'category_id'=>$request->category_id,
            'subcategory_id'=>$request->subcategory_id,
            'product_name'=>$request->product_name,
            'brand'=>$request->brand,
            'price'=>$request->price,
            'discount'=>$request->discount,
            'after_discount'=>$request->price - ($request->price*$request->discount/100),
            'short_desp'=>$request->short_desp,
            'long_desp'=>$request->long_desp,
            'slug'=>Str::lower(str_replace(' ', '-', $request->product_name)).'-'.rand(0,1000000000),
        ]);
//PREVIEW IMAGE INSERT 
        $preview_image = $request->product_preview;
        $extension = $preview_image->getClientOriginalExtension();
        $file_name= Str::random(4).rand(100,999).'.'.$extension;
       Image::make($preview_image)->resize(450,450)->save(public_path('uploads/product/preview/'.$file_name));
        
       Product::find($product_id)->update([
        'preview' => $file_name,
       ]);
//THUMBNAIL IMAGE INSERT 
        foreach($request->product_thumbnail as $thumbnail){
            $extension = $thumbnail->getClientOriginalExtension();
            $file_name= Str::random(4).rand(100,999).'.'.$extension;
            Image::make($thumbnail)->resize(450,450)->save(public_path('uploads/product/thumbnail/'.$file_name));

            Thumbnail::insert([
                'product_id'=>$product_id,
                'thumbnail'=> $file_name,
                'created_at' => Carbon::now(),
            ]);
        }
        return back()->with('success', 'Product Added Successfully!');
    }
// PRODUCT LIST
    function product_list(){
        $products = Product::all();
        return view('admin.product.product',[
            'products' => $products
        ]);
    }
//PRODUCT DELETE 
    function product_delete($product_id){
        $product_preview = Product::find($product_id);
        $preview_location = public_path('uploads/product/preview/'.$product_preview->preview);
        unlink($preview_location);

        $product_thumbnail= Thumbnail::where('product_id', $product_id)->get();
        foreach($product_thumbnail as $thumbanil){
        $thumbnail_location = public_path('uploads/product/thumbnail/'.$thumbanil->thumbnail);
         unlink($thumbnail_location);
         Thumbnail::where('product_id', $product_id)->delete();
        }
        Product::find($product_id)->delete();
        return back()->with('dlt_product', 'Deleted Successfully!');

    }
// VARTATION 
    function variation(){
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.product.variation', [
            'colors' => $colors,
            'sizes' => $sizes,
        ]);
    }
    // COLOR & SIZE
    function variation_store(Request $request){
        if($request->btn == 1){
            Color::insert([
                'color_name' => $request->color_name,
                'color_code' => $request->color_code,
            ]);
            return back()->with('success_color', 'Color Added Successfully!');
        }
        else{
        Size::insert([
            'size_name' => $request->size_name,
        ]);
        return back()->with('success_size', 'Size Added Successfully!');
        }
    }
    // COLOR DELETE
    function color_delete($color_id){
        Color::find($color_id)->delete();
        return back()->with('dlt_color', 'Color Deleted!');
    }
    // SIZE DELETE
    function size_delete($size_id){
        Size::find($size_id)->delete();
        return back()->with('dlt_size', 'Size Deleted!');
    }

// INVENTORY 
     function inventory($product_id){
        $colors = Color::all();
        $sizes = Size::all();
        $product_info = Product::find($product_id);
        $inventories = Inventory::where('product_id', $product_id)->get( );
        return view('admin.product.inventory', [
            'colors' => $colors,
            'sizes' => $sizes,
            'product_info' => $product_info,
            'inventories' => $inventories,
        ]);
     }
     function inventory_store(Request $request){
        Inventory::insert([
            'product_id' => $request->product_id,
            'color_id' => $request->color_id,
            'size_id' => $request->size_id,
            'quantity' => $request->quantity,
        ]);
        return back()->with('success_inventory', 'Inventory Added Successfully!');
     }
     function inventory_delete($inventory_id){
        Inventory::find($inventory_id)->delete();
        return back()->with('dlt_inventory', 'Inventory Item Deleted!');
     }


}
