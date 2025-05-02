<?php

namespace App\Http\Controllers\admin\auth;


use App\Models\User;

use App\Jobs\SendMail;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('email', 'remember'));
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return redirect()->back()
                ->withErrors(['email' => 'Your email and password is wrong'])
                ->withInput($request->only('email', 'remember'));
        }
        if (Auth::user()->role != 'admin') {
            return redirect()->back()
                ->withErrors(['email' => 'Your email and password is wrong'])
                ->withInput($request->only('email', 'remember'));
        }

        $user = Auth::user();
        $message = 'Login successful';
        $request->session()->regenerate();

        $notification = array(
            'message' => 'User Login Successfully',
            'alert-type' => 'success'
        );

        return redirect()->intended(RouteServiceProvider::HOME)->with($notification);

        // Redirect to home route with success message
        // return redirect()->route('home', compact('user', 'message'));



        // Redirect to the home route

    }
    public function showLoginForm()
    {
        return view('Auth.login');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $notification = array(
            'message' => 'User Logout Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.login')->with($notification);
    }
    public function changePassword()
    {
        $user = Auth::user(); // Retrieve the authenticated user
        return view('Auth.change_password', compact('user'));
    }
    public function updatePassword(Request $request)
    {
        // Validate the request
        $request->validate([
            'oldPassword' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('The old password is incorrect.');
                }
            }],
            // 'newPassword' => 'required|min:8|confirmed',
            'newPassword' => 'required|min:8',


        ]);

        // Update the password
        $user = Auth::user();
        $user->password = Hash::make($request->input('newPassword'));
        $user->save();

        // Redirect with success message
        $notification = array(
            'message' => 'Password Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('home')->with($notification);
    }

    public function forgotPassword()
    {
        return view('Auth.fogort_password');
    }
    public function sentEmail(Request $request)
    {
        // Validate the email field
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();
        // dd($user);

        if (!$user) {
            // dd('hit');
            $notification = array(
                'message' => 'Email does not exist',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } else if ($user->role == 'user') {
            // dd('hit');
            $notification = array(
                'message' => 'Please fill your email address',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        // Retrieve the username
        $username = $user->name;
        // dd($username);

        // Generate the password reset token

        $code = mt_rand(100000, 999999);




        $dispatchData = [
            'mail_to' => $request->email,
            'subject' => "Password reset",
            'message' => $code,
        ];

        SendMail::dispatch($dispatchData);
        $user->code = $code;
        $user->save();
        $request->session()->put('email', $request->email);

        $notification = array(
            'message' => 'Otp code sent to Your Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.otp')->with($notification);
    }
    public function otp(Request $request)
    {
        $email = $request->session()->get('email');

        return view('Auth.otp_validation', ['email' => $email]);
    }
    public function otpValidation(Request $request)
    {
        // dd($request->all());
        $user = User::where('email', $request->email)->first();



        // Replace 'otp_code' with your actual column name where you store the OTP in the users table
        if ($user->code != $request->otp_code) {
            // dd('hit');
            $notification = array(
                'message' => 'Wrong Otp code',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        // Reset the user's password
        // $user->password = Hash::make($request->password);
        $user->code = null; // Clear the OTP after successful reset
        $user->save();
        $request->session()->put('email', $request->email);

        $notification = array(
            'message' => 'Correct OTP',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.reset-password-confirm')->with($notification);
    }
    public function reset(Request $request)
    {
        $email = $request->session()->get('email');

        return view('Auth.reset_password', ['email' => $email]);
    }
    // public function resetPassword(Request $request)
    // {

    //     $user = User::where('email', $request->email)->first();



    //     // Reset the user's password
    //     $user->password = Hash::make($request->password);
    //     $user->code = null; // Clear the OTP after successful reset
    //     $user->save();

    //     return response()->json(['success' => true, 'msg' => 'Password reset successfully']);
    // }
    public function resetPassword(Request $request)
    {
        // Validate the request
        $request->validate([
            'password' => 'required|string|confirmed', // Ensure password confirmation
            'password_confirmation' => 'required'
        ]);
        // dd($request->password);


        // Find the user by email
        $user = User::where('email', $request->email)->first();
        // dd($user->password, $request->password);

        // Reset the user's password
        $user->password = Hash::make($request->password);
        // Clear the OTP after successful reset
        $user->save();
        $notification = array(
            'message' => 'Reset password successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.login')->with($notification);
    }
}
