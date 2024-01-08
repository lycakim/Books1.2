<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Books;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    //
    public function UserDashboard(){
        return view('user.index');
        // return view('admin.admin_dashboard');
    } // End Method

    

    public function UserLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    } // End Method

    public function create(){
        return view('register');
    } // End Method

    public function login(){
        return redirect('/');
    } // End Method

    public function UserProfile(){
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('user.user_profile_view', compact('profileData'));
    } // End Method

    public function UserProfileStore(Request $request){
        $id = Auth::user()->id;
        $data = User::find($id); 
        $data->username = $request->username;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        // $data->photo = 'sample';

        if ($request->file('profilePhoto')){
            $file = $request->file('profilePhoto');
            @unlink(public_path('upload/admin_images/'.$data->photo));
            $filename = date('YmdHis').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $data->photo = $filename;
            echo $filename;
        }
        $data->save();

        $notification = array(
            'message' => 'User Profile Update Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method
    
    public function UserChangePassword(Request $request){
        $id = Auth::user()->id;
        $profileData = User::find($id);

        return view('user.user_change_password', compact('profileData'));
    } // End Method

    public function UserUpdatePassword(Request $request){
        // Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);
        // Match the old password
        if(!Hash::check($request->old_password, auth::user()->password)){
            $notification = array(
                'message' => 'Old Password does not match!',
                'alert-type' => 'warning'
            );

            return back()->with($notification);
        }


        // Update the new password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = array(
            'message' => 'Password Changed Successfully',
            'alert-type' => 'success'
        );
        return back()->with($notification);
        
    } // End Method

}