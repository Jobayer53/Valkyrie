<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    function users(){
        $user_data = User::where('id', '!=', Auth::id())->get();
        $total_user = User::count();
        return view('admin.users.user', compact('user_data', 'total_user'));
    }

    function user_delete($user_id){
        $user = User::find($user_id);

        if($user->image == null){
            User::find($user_id)->delete();
            return back()->with('dlt', 'Deleted Successfully!');
        }
        else{
            $delete_from = public_path('uploads/users/'.$user->image);
            unlink($delete_from);

            User::find($user_id)->delete();
            return back()->with('dlt', 'Deleted Successfully!');
        }
       
    }

//profile
    function profile(){
        return view('admin.users.profile');
    }

//profile update
    function profile_update(Request $request){


        if($request->current_password == ''){
            User::find(Auth::id())->update([
                'name'=>$request->name,
                'email'=>$request->email,
            ]);
            return back();
        }
        else{
            if (Hash::check($request->current_password, Auth::User()->password)) {

                // if($request->new_password == $request->confirm_password){

                    $request->validate([
                        'password'=>'confirmed',
                        'password_confirmation'=>Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                    ]);
                    User::find(Auth::id())->update([
                        'name'=>$request->name,
                        'email'=>$request->email,
                        'password'=>bcrypt($request->password) ,
                    ]);
                    return back();
                // }
                // else{
                //     return back()->with('confirm_password', 'Password Not Match!');
                // }
            }
            else{
                return back()->with('current_password', 'Incorrect Password!');
            }



            // $request->validate([
            //     'password'=>Password::min(8)
            //     ->letters()
            //     ->mixedCase()
            //     ->numbers()
            //     ->symbols()
            // ]);
            // User::find(Auth::id())->update([
            //     'name'=>$request->name,
            //     'email'=>$request->email,
            //     'password'=>bcrypt($request->password) ,
            // ]);
            // return back();
        }
    }
//PHOTO UPDATE 
    function photo_update(Request $request){
       $db_image = Auth::user()->image;

       if($db_image == null){
        $image = $request->image;
        $extension = $image->getClientOriginalExtension();
        $image_name =Auth::user()->id.'.'.$extension;
        
        image::make($image)->save(public_path('uploads/users/'.$image_name));

        User::find(Auth::id())->update([
            'image'=>$image_name,
        ]);
        return back();
       }
       else{
        $delete_from = public_path('uploads/users/'.$db_image);
        unlink($delete_from);

        $image = $request->image;
        $extension = $image->getClientOriginalExtension();
        $image_name =Auth::user()->id.'.'.$extension;
        
        image::make($image)->save(public_path('uploads/users/'.$image_name));

        User::find(Auth::id())->update([
            'image'=>$image_name,
        ]);
        return back();

       }
    }



}
