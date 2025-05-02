<?php

namespace App\Http\Controllers\api;

use App\Jobs\RegisterSendingMail;
use App\Models\CartItem;
use App\Models\User;
use App\Models\Order;
use App\Jobs\SendMail;
use Illuminate\Http\Request;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class AuthApiController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            $formattedErrors = [];
            foreach ($errors as $field => $message) {
                $formattedErrors[$field] = $message[0];
            }

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $formattedErrors,
                ],
                422,
            );
        }
        // Step 1: Send email first (without creating user)
        $emailResponse = $this->sendEmail($request->email);

        // Step 2: Decode email response
        $emailResponseData = json_decode($emailResponse->getContent(), true);
        $code = $emailResponseData['otp'];


        // Step 3: If email failed, do not create the user
        if ($emailResponseData['success']) {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user',
                'code'=> $code,
                'address' => $request->address,
            ]);
            return response()->json([
                'success' => true,
                'email' => $emailResponseData['email'],
                'otp' => $emailResponseData['otp'],
                'message' => $emailResponseData['message'],
            ], 200);
        }


//        $token = $user->createToken('Personal Access Token')->accessToken;
//        $data = [
//            'id' => $user->id,
//            'name' => $user->name,
//            'email' => $user->email,
//            'role' => $user->role,
//            'token' => $token,
//            'address' => $user->address,
//        ];



//        return response()->json(
//            [
//                'success' => true,
//                'message' => 'User registered successfully',
//                'data' => $data,
//            ],
//            201,
//        );
    }
    // public function register(Request $request)
    // {
    //     // Validate the username (which can be either email or phone), and password
    //     $validator = Validator::make($request->all(), [
    //         'username' => [
    //             'required',
    //             'string',
    //             function($attribute, $value, $fail) {
    //                 if (!filter_var($value, FILTER_VALIDATE_EMAIL) && !preg_match('/^[0-9]{10,15}$/', $value)) {
    //                     $fail('The username must be a valid email address or phone number.');
    //                 }
    //             },
    //             'unique:users,email', // Check if the email or phone number is unique
    //             'unique:users,phone'
    //         ],
    //         'password' => 'required|string|min:8',
    //     ]);

    //     // Handle validation errors
    //     if ($validator->fails()) {
    //         $errors = $validator->errors()->toArray();
    //         $formattedErrors = [];
    //         foreach ($errors as $field => $message) {
    //             $formattedErrors[$field] = $message[0];
    //         }

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Validation errors',
    //             'errors' => $formattedErrors
    //         ], 422);
    //     }

    //     // Determine if the username is an email or phone number
    //     $username = $request->input('username');
    //     if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
    //         $email = $username;
    //         $phone = null;
    //     } else {
    //         $email = null;
    //         $phone = $username;
    //     }

    //     // Create the user
    //     $user = User::create([
    //         'name' => $username, // Use the username as the name (can be email or phone)
    //         'email' => $email,
    //         'phone' => $phone,
    //         'password' => Hash::make($request->password),
    //         'role' => 'user',
    //     ]);

    //     // Generate a personal access token
    //     $token = $user->createToken('Personal Access Token')->accessToken;

    //     // Prepare response data
    //     $data = [
    //         'id' => $user->id,
    //         'name' => $user->name,
    //         'email' => $user->email,
    //         'phone' => $user->phone,
    //         'role' => $user->role,
    //         'token' => $token
    //     ];

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'User registered successfully',
    //         'data' => $data
    //     ], 201);
    // }

    // -------------* For Login   *----------------------------------------------
    // public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|string|email',
    //         'password' => 'required|string',
    //     ]);

    //     if ($validator->fails()) {
    //         $errors = $validator->errors()->toArray();
    //         $formattedErrors = [];
    //         foreach ($errors as $field => $message) {
    //             $formattedErrors[$field] = $message[0];
    //         }

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Validation errors',
    //             'errors' => $formattedErrors
    //         ], 422);
    //     }

    //     if (!Auth::attempt($request->only('email', 'password'))) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Your email and password is wrong',
    //         ], 401);
    //     }

    //     $user = $request->user();
    //     $token = $user->createToken('Personal Access Token')->accessToken;
    //     $data = [
    //         'id' => $user->id,
    //         'name' => $user->name,
    //         'email' => $user->email,
    //         'token' => $token
    //     ];

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Login successful',
    //         'data' => $data
    //     ]);
    // }
    // for username and email login
    public function login(Request $request)
    {
        // dd("hit");
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            $formattedErrors = [];
            foreach ($errors as $field => $message) {
                $formattedErrors[$field] = $message[0];
            }

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $formattedErrors,
                ],
                422,
            );
        }

        // Retrieve the username and password from the request
        $username = $request->input('username');
        $password = $request->input('password');

        // Determine if the username is an email or phone number
        $field = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        // Attempt authentication with the appropriate field
        if (!Auth::attempt([$field => $username, 'password' => $password])) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Your email or phone  and  password is wrong',
                ],
                401,
            );
        }

        // If authentication is successful
        $user = $request->user();
//        dd($user);
        if($user->role === "user"){
//            dd($user->verify , $user->terminate);
            if(($user->verify == 0 && $user->terminate == 1) ||$user->verify == 0 ){
                return response()->json([
                    'success' => false,
                    'message' => 'Login Unsuccessful',
                    'data' => 'You are terminate From Our Website. Please Contact.' ,
                ],403);
            }
            if($user->terminate == 1 ){
                return response()->json([
                    'success' => false,
                    'message' => 'Login Unsuccessful',
                    'data' => 'You are terminate From Our Website. Please Contact.' ,
                ],403);
            }
        }
        $token = $user->createToken('Personal Access Token')->accessToken;
        $orders = Order::with('items.variation.product', 'user')
            ->where('user_id', $user->id)
            ->get();
        $orderCount = $orders->count();
        $cat = CartItem::where('user_id', $user->id)->get();
        $loveListedProducts = $user->whitelisted()
        ->with([
        'product' => function ($query) {
            $query->select('id', 'name', 'short_description')
                  ->with(['images' => function ($imageQuery) {
                      $imageQuery->select('id', 'product_id', 'path');
                  }]);
                 // Include variations
        },
         ])->get();
        $loveCount = $loveListedProducts->count();

        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'photo'=>$user->profile,
            'verify'=>$user->verify,
            'terminate'=>$user->termiante,
            'dob'=>$user->dob,
            'user'=>$user->gender,
            'role' => $user->role,
            'phone' => $user->phone,
            'address'=>$user->address,
            'order_count'=>$orderCount,
            'whilist_count'=>$loveCount,
            'add_to_cart'=>$cat->count(),
            'token' => $token,
        ];

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => $data,
        ]);
    }

    public function UserbyId($id){
        $user= User::find($id);
        $orders = Order::with('items.variation.product', 'user')
            ->where('user_id', $user->id)
            ->get();
        $orderCount = $orders->count();
        $cat = CartItem::where('user_id', $user->id)->get();
        $loveListedProducts = $user->whitelisted()
            ->with([
                'product' => function ($query) {
                    $query->select('id', 'name', 'short_description')
                        ->with(['images' => function ($imageQuery) {
                            $imageQuery->select('id', 'product_id', 'path');
                        }]);
                    // Include variations
                },
            ])->get();
        $loveCount = $loveListedProducts->count();
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'photo'=>$user->profile,
            'verify'=>$user->verify,
            'terminate'=>$user->termiante,
            'dob'=>$user->dob,
            'user'=>$user->gender,
            'role' => $user->role,
            'phone' => $user->phone,
            'address'=>$user->address,
            'order_count'=>$orderCount,
            'whilist_count'=>$loveCount,
            'add_to_cart'=>$cat->count(),
        ];

        return response()->json([
            'success' => true,
            'message' => 'User Details',
            'data' => $data,
        ]);
    }
    public function updateUser(Request $request, $id)
    {
        // Retrieve the user by ID.
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        // Validate the incoming request.
        $data = $request->validate([
            'name'    => 'sometimes|string|max:255|unique:users,name,'.$id,
            'email'   => 'sometimes|email|max:255|unique:users,email,'.$id,
            'phone'   => 'sometimes|string|max:20|unique:users,phone,'.$id,
            'address' => 'sometimes|string|max:255',
            'profile' => 'sometimes|image|max:2048',
        ]);

        // Handle profile image upload, if provided.
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
//            $user->save();
        }

        // Update the user with validated data.
        $user->update($data);

        // Recalculate aggregated data for the updated user.

        // Build the updated user data structure.
        $updatedUserData = [
            'id'            => $user->id,
            'name'          => $user->name,
            'email'         => $user->email,
            'profile'       => $user->profile,
            'verify'        => $user->verify,
            'terminate'     => $user->terminate,
            'dob'           => $user->dob,
            'gender'        => $user->gender,
            'role'          => $user->role,
            'phone'         => $user->phone,
            'address'       => $user->address,

        ];

        // Return the updated user data as a JSON response.
        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'data'    => $updatedUserData,
        ]);
    }
    public function sendEmail($email1)
    {


        $email = $email1;

        // **Step 1: Check if the email domain is valid**
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !$this->isValidEmailDomain($email)) {
            return response()->json(['success' => false, 'msg' => 'Invalid email address'], 400);
        }



        // **Step 3: Generate OTP**
        $otp = mt_rand(100000, 999999);

        try {
            $dispatchData = [
                'mail_to' => $email,
                'subject' => 'Verify Your Email',
                'message' =>  $otp,
            ];

            RegisterSendingMail::dispatchSync($dispatchData); // Send email synchronously

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully.',
                'email' => $email,
                'otp' => $otp,
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => 'Email delivery failed'], 500);
        }
    }
    public function otpValidationRegister(Request $request)
    {

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->role == 'admin') {
            return response()->json(['success' => false, 'msg' => 'User not found'], 404);
        }
        // Replace 'otp_code' with your actual column name where you store the OTP in the users table
        if ($user->code !== $request->otp_code) {
            return response()->json(['success' => false, 'msg' => 'Wrong  OTP'], 400);
        }

        // Reset the user's password

        $user->code = null; // Clear the OTP after successful reset
        $user->verify=1;
        $user->save();
        $token = $user->createToken('Personal Access Token')->accessToken;
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'token' => $token,
            'address' => $user->address,
        ];



        return response()->json(
            [
                'success' => true,
                'message' => 'User registered successfully',
                'data' => $data,
            ],
            201,
        );

    }





    // -------------*  For Email Send For Reset Password *------------------------
    public function sendResetLinkEmail(Request $request)
    {
        // Validate the email field
        $request->validate(['email' => 'required|email']);
        // dd($request->email);
        $user = User::where('email', $request->email)->first();
        // dd($user->role);

        if ($user == null || $user->role == 'admin') {
            return response()->json(['success' => false, 'msg' => 'Email not found'], 404);
        }
        // Simulate email not found error
        if (!filter_var($user->email, FILTER_VALIDATE_EMAIL) || !$this->isValidEmailDomain($user->email)) {
            return response()->json(['success' => false, 'msg' => 'Address not found'], 404);
        }

        // Retrieve the username
        $username = $user->name;

        // dd($username);

        // Generate the password reset token

        $code = mt_rand(100000, 999999);

        // Prepare email details
        // $details = [
        //     'email' => $request->email,
        //     'name' => $username, // Fetch the user's name from the database if needed
        //     'reset_code' => $code,
        // ];
        // dd($details);

        // Send the email
        // Mail::to($details['email'])->send(new PasswordResetMail($details));
        $dispatchData = [
            'mail_to' => $request->email,
            'subject' => 'Password reset',
            'message' => $code,
        ];

        SendMail::dispatch($dispatchData);
        $user->code = $code;
        $user->save();

        return response()->json(
            [
                'success' => true,
                'message' => 'Otp Sent successfully',
                'data' => [
                    'otp_code' => $code,
                ],
            ],
            200,
        );
    }

    // -------------* For Reset Password *-------------------------------------------------------
    public function otpValidation(Request $request)
    {

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->role == 'admin') {
            return response()->json(['success' => false, 'msg' => 'User not found'], 404);
        }
        // Replace 'otp_code' with your actual column name where you store the OTP in the users table
        if ($user->code !== $request->otp_code) {
            return response()->json(['success' => false, 'msg' => 'Wrong  OTP'], 400);
        }

        // Reset the user's password
        $user->password = Hash::make($request->password);
        $user->code = null; // Clear the OTP after successful reset
        $user->save();

        return response()->json(['success' => true, 'msg' => 'Correct OTP']);
    }
    public function resetPassword(Request $request)
    {
        // dd('hit');
        // Validate the request
        $request->validate([
            'password' => 'required|string', // Ensure password
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();
        // dd($user->password, $request->password);

        if (!$user || $user->role == 'admin') {
            return response()->json(['success' => false, 'msg' => 'User not found'], 404);
        }

        // Reset the user's password
        $user->password = Hash::make($request->password);
        // Clear the OTP after successful reset
        $user->save();
        return response()->json(
            [
                'success' => true,
                'message' => 'Password Reset Successfully',
            ],
            200,
        );
    }

    // -------------* For Change Password *----------------------------------------------------
    public function changePassword(Request $request)
    {
        // Get the authenticated user
        // $user = auth()->user();
        $user = User::find($request->user_id);
        $validatedData = $request->all();
        if (!$user || $user->role == 'admin') {
            return response()->json(['success' => false, 'msg' => 'Something Was Wrong']);
        } else {
            // Validate the incoming request data
            // $validatedData = $request->validate([
            //     'old_password' => 'required|string',
            //     'new_password' => 'required|string|min:8|confirmed', // The confirmed rule ensures new_password_confirmation is also provided and matches new_password
            // ]);

            // Check if the provided current password matches the user's password
            if (!Hash::check($validatedData['old_password'], $user->password)) {
                return response()->json(['success' => false, 'msg' => 'Old password is incorrect'], 400);
            }

            // Update the user's password
            $user->password = Hash::make($validatedData['new_password']);
            $user->save();

            // Return a success response
            return response()->json(['success' => true, 'msg' => 'Password changed successfully']);
        }
    }
    public function mail()
    {
        $jobs = DB::table('jobs')->get();
        $failedJobs = DB::table('failed_jobs')->get();

        return view('welcome', compact('jobs', 'failedJobs'));
    }

    public function logout(Request $request)
    {
        // Get the authenticated user
        $user = Auth::guard('api')->user();

        if ($user) {
            // Simply respond with a success message
            return response()->json(
                [
                    'message' => 'Logout successfully',
                    'status' => true,
                ],
                200,
            );
        }

        return response()->json(
            [
                'message' => 'User not authenticated',
                'status' => false,
            ],
            401,
        );
    }
    /**
     * Simulate email validation to check if domain exists
     */
    private function isValidEmailDomain($email)
    {
        $domain = substr(strrchr($email, "@"), 1);
        return checkdnsrr($domain, "MX"); // Check if domain has MX records
    }
}
