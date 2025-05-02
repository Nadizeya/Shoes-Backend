<?php

namespace App\Http\Controllers\admin\user;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;



class AdminController extends Controller
{
    public function show()
    {
        $user = Auth::user(); // Retrieve the authenticated user
        return view('profile', compact('user'));
    }
    public function uploadProfilePicture(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Handle the uploaded file
        if ($request->hasFile('profile')) {
            $image = $request->file('profile');
            // $filename = time() . '.' . $image->getClientOriginalExtension();
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            // Resize and save the image
            // $path = storage_path('app/public/vendors/images/profile/' . $filename);
            // dd($path);
            Image::make($image)->resize(626, 626)->save('vendors/images/profile/' . $name_gen);
            $save_url = 'vendors/images/profile/' . $name_gen;


            // Optionally delete the old profile picture
            if ($user->profile) {
                Storage::delete('app/public/vendors/images/profile/' . $user->profile);
            }

            // Update user's profile picture path
            $user->profile = $save_url;
            $user->save();
        }
        $notification = array(
            'message' => 'User Updated Successfully',
            'alert-type' => 'success'
        );



        return redirect()->back()->with($notification);
    }
    public function edit()
    {
        $user = Auth::user(); // Retrieve the authenticated user
        return view('editprofile', compact('user'));
    }
    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        // dd($request->all());

        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|in:male,female',
            'country' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            // 'visa_card' => 'nullable|string|max:20',
            // 'paypal_id' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|url',
            'viber' => 'nullable|url',
            'telegram' => 'nullable|url',
        ]);
        // dd($validated);
        User::findOrFail($user->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'Country' => $request->country,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'phone' => $request->phone,
            'address' => $request->address,
            // 'visa_card' => 'nullable|string|max:20',
            // 'paypal_id' => 'nullable|string|max:255',
            'facebook_url' => $request->facebook_url,
            'viber' => $request->viber,
            'telegram' => $request->telegram,
            'update_at' => Date::now()



        ]);
        // dd($request->all());
        $notification = array(
            'message' => 'Profile Updated without Image Successfully',
            'alert-type' =>
            'success'
        );

        // Update user information

        return redirect('admin/profile/')->with($notification);
    }
}
