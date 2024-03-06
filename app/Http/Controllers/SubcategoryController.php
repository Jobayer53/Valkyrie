<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;
use App\Models\Subcategory;
use Intervention\Image\Facades\Image;


class SubcategoryController extends Controller
{
//ALL DATA SHOW
   function subcategory(){
    $categories = Category::all();
    $subcategories = Subcategory::all();
    return view('admin.subcategory.subcategory', [
        'categories'=>$categories,
        'subcategories'=>$subcategories,
    ]);
   }
//SUBCATEGORY INSERT
   function subcategory_store(Request $request){
        $request->validate([
            'subcategory_name'=>'required',
            'subcategory_image'=>'required',    
        ]);
        $id =Subcategory::insertGetId([
            'subcategory_name'=>$request->subcategory_name,
            'category_id'=>$request->category_id,
        ]);

        $subcategory_image = $request->subcategory_image;
        $extension = $subcategory_image->getClientOriginalExtension();
        // $file_name= Str::random(4).rand(100,999).'.'.$extension;
        $file_name = $id.'.'.$extension;
        $img = Image::make($subcategory_image)->save(public_path('uploads/subcategory/'.$file_name));
        Subcategory::find($id)->update([
            'subcategory_image'=> $file_name,
        ]);

        return back()->with('success', 'Category Data Added Successfully');
   }
//EDIT
   function subcategory_edit($subcategory_id){
    $categories = Category::all();
    $subcategory_info = Subcategory::find($subcategory_id);
    return view('admin.subcategory.edit', [
        'subcategory_info'=>$subcategory_info,
        'categories'=>$categories,
    ]);
   }

//UPDATE
   function subcategory_update(Request $request){
    $id = $request->id;
    if($request->subcategory_image== ''){
        Subcategory::find($id)->update([
            'category_id'=>$request->category_id,
            'subcategory_name'=>$request->subcategory_name,
        ]);
        return back()->with('update', 'Updated Successfully!');
    }
    else{
        $image = Subcategory::where('id', $id)->first()->subcategory_image;
        $delete_from = public_path('uploads/subcategory/'.$image);
        unlink($delete_from);

        $uploaded_image = $request->subcategory_image;
        $extension = $uploaded_image->getClientOriginalExtension();
        $image_name =$id.'.'.$extension;
        
        image::make($uploaded_image)->save(public_path('uploads/subcategory/'.$image_name));

        Subcategory::find($id)->update([
            'category_id'=>$request->category_id,
            'subcategory_name'=>$request->subcategory_name,
            'subcategory_image'=>$image_name,
        ]);
        return back()->with('update', 'Updated Successfully!'); 
    }

   }
//DELETE
   function subcategory_delete($subcategory_id){

    $db_image = Subcategory::where('id', $subcategory_id)->first()->subcategory_image;
    echo $db_image;
    $delete_from = public_path('uploads/subcategory/'.$db_image);
    unlink($delete_from);

    Subcategory::find($subcategory_id)->delete();
    return back()->with('dlt', 'Deleted Successfully!');


   }


}
