<?php

namespace App\Http\Controllers;
use App\Models\category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Monolog\Handler\FingersCrossedHandler;
use str;

use Intervention\Image\Facades\Image;


class CategoryController extends Controller
{

//show chategory
   function category(){
    $categories=Category::all();
    $trash_category = Category::onlyTrashed()->get();
    return view('admin.category.category',[
        'categories'=>$categories,
        'trash_category'=>$trash_category,

    ]);
   }
   function category_store(Request $request){
    $request->validate([
        'category_name'=>'required',        
        'category_image'=>'required | mimes:jpg,gif,webp,png,jpeg | file|max:512',        
        
                
    ],[
       'category_name.required'=> 'Category Name Required!' ,
       'category_image.required'=> 'Category Image Required!' ,
    ]);
    $id = Category::insertGetId([
        'category_name'=> $request->category_name,
        'icon'=> $request->icon,
        'added_by'=> Auth::id(),
        'created_at'=> Carbon::now(),
    ]);

    $category_image = $request->category_image;
    $extension = $category_image->getClientOriginalExtension();
    // $file_name= Str::random(4).rand(100,999).'.'.$extension;
    $file_name = $id.'.'.$extension;
    $img = Image::make($category_image)->save(public_path('uploads/category/'.$file_name));
    Category::find($id)->update([
        'category_image'=> $file_name,
    ]);

    return back()->with('success', 'Category Data Added Successfully');

   }




//soft delete
   function category_delete($category_id){

    // $image = Category::where('id', $category_id)->first()->category_image;
    // $delete_location = public_path('uploads/category/'.$image);
    // unlink($delete_location);

    Category::Find($category_id)->delete();
    return back()->with('dlt', 'Category Item Deleted Successfully!');
   }
//hard delete
   function category_hard_delete($category_id){

    $image = Category::onlyTrashed()->where('id', $category_id)->first()->category_image;
    $delete_location = public_path('uploads/category/'.$image);
    unlink($delete_location);

    Category::onlyTrashed()->Find($category_id)->forceDelete();
    return back()->with('hard_dlt', 'Category Item Deleted Successfully!');
   }

// edit
   function category_edit($category_id){
    $category_info = Category::find($category_id);
    return view('admin.category.edit',[
        'category_info'=> $category_info,
    ]);
   }
// update
   function category_update(Request $request){
    if($request->category_image ==''){
       Category::find($request->category_id)->update([ 
        'category_name'=>$request->category_name,
       ]);
       return back()->with('update', 'Updated Successfully!');
    }
    else{

        $image = Category::where('id', $request->category_id)->first()->category_image;
        $delete_location = public_path('uploads/category/'.$image);
        unlink($delete_location);

        $category_image = $request->category_image;
        $extension = $category_image->getClientOriginalExtension();
        // $file_name= Str::random(4).rand(100,999).'.'.$extension;
        $file_name = $request->category_id.'.'.$extension;
        $img = Image::make($category_image)->save(public_path('uploads/category/'.$file_name));
        Category::find($request->category_id)->update([ 
            'category_name'=>$request->category_name,
            'category_image'=>$file_name,
           ]);
           return back()->with('update', 'Updated Successfully!');
        }

   }
   
//restore

   function category_restore($category_id){
    Category::onlyTrashed()->find($category_id)->restore();
    return back();
   }






}
