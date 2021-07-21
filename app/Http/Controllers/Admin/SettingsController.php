<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function editProfile()
    {
        $user = User::find(Auth::id());

        return view('admin.settings.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,id',
            'image' => 'mimes:png,jpg,jpeg,bmp'
        ]);

        $user = User::find(Auth::id());

        $image = $request->file('image');
        $slug = str_slug($request->name);

        if(isset($image))
        {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imageName  = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if(!Storage::disk('public')->exists('user'))
            {
                Storage::disk('public')->makeDirectory('user');
            }

            //delete old user image
            if(Storage::disk('public')->exists('user/'.$user->image) && strcmp($user->image, "default.png") != 0)
            {
                Storage::disk('public')->delete('user/'.$user->image);
            }

            $userImage = Image::make($image)->resize(500,500)->stream();

            Storage::disk('public')->put('user/'.$imageName, $userImage);

        } else {
            $imageName = $user->image;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->image = $imageName;
        
        $user->save();
       
        Toastr::success('Profile Successfully Updated !' ,'Success');

        return redirect()->back();
    }

    public function editPassword()
    {

        return view('admin.settings.password');
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:5|confirmed'
        ]);

        $hashedPassword = Auth::user()->password;

        if(Hash::check($request->old_password, $hashedPassword))
        {
            if(!Hash::check($request->password, $hashedPassword))
            {
                $user = User::find(Auth::id());

                $user->password = Hash::make($request->password);

                $user->save();

                Toastr::success('Password Successfully Changed !','Success');

                Auth::logout();

                return redirect()->back();
            }
            else
            {
                Toastr::error('New Password cannot be same as Old Password.','Error');

                return redirect()->back();
            }
        }
        else
        {
            Toastr::error('Wrong Old Password.','Error');
            
            return redirect()->back();
        }
    }
}
