<?php

namespace App\Http\Controllers\admin\user;



use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index()
    {
//        $users = User::where('role', 'user')->latest()->get();
        $users = User::where('role', 'user')
            ->where('verify', 1)
            ->withCount('orders')
            ->withSum('orders', 'total_price')// Add order count
            ->latest()
            ->get();
//        dd($users->count());

        // dd($users);
        return view('users.all_user', compact('users'));
    }

    public function updateStatus(Request $request)
    {
        $user =User::find($request->id);
//        dd($request->all());
        $user->terminate = $request->terminate;
        $user->save();

        return response()->json(['success' => true, 'message' => 'User status updated successfully!']);
    }
//    public function userDetails($id)
//    {
//        $user = User::findOrFail($id);
//        return view('users.userdetails', compact('user'));
//    }
    public function userDetails($id)
    {
//        $user = User::withCount('orders') // Get total order count
//        ->withSum('orders', 'total_price') // Get total order price
//        ->withSum('orders','total_product')
//        ->with(['orders' => function($query) {
//            $query->latest()->first(); // Get the latest order
//        }])
//            ->findOrFail($id);
//
//        $latestOrderDate = optional($user->orders->first())->created_at; // Get latest order date (if exists)
//
//        $user_data= $user::findorFail($id);
//
//        $orders= $user_data->orders;
        $user = User::withCount('orders')
            ->withSum('orders', 'total_price')
            ->withSum('orders', 'total_product')
            ->with(['orders' => function ($query) {
                $query->latest()->with([
                    'items.variation.product',
                    'items.variation.images' => function ($query) {
                        $query->select('id', 'product_variation_id',
                            \DB::raw("CONCAT('" . url('/') . "/', image_path) AS full_image_path"));
                    }
                ]);
            }])
            ->findOrFail($id);

        $latestOrderDate = optional($user->orders->first())->created_at; // Get latest order date if exists

        $user_data = $user; // No need to refetch

        $orders = $user->orders; // Orders now include variations, products, and images
//        $user = User::withCount('orders') // Get total order count
//        ->withSum('orders', 'total_price') // Get total order price
//        ->withSum('orders', 'total_product') // Get total product count
//        ->with(['orders' => function($query) {
//            $query->latest(); // ✅ Correct way to get the latest order
//        }])
//            ->findOrFail($id);
//
//        $latestOrderDate = optional($user->orders->first())->created_at; // ✅ Correctly gets latest order date
//
//        $user_data = $user; // ✅ No need to refetch
//
//        $orders = $user->orders; // ✅ This will now return only the latest order due to `limit(1)`



        return view('users.userdetails', compact('user', 'latestOrderDate','orders'));
    }
    public function deleteUser($id)
    {

        $user = User::findOrFail($id);
        if ($user->profile != null) {
            $img = $user->profile;
            unlink($img);
        }

        User::findOrFail($id)->delete();

        $notification = array(
            'message' => 'User Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.user')->with($notification);
    }
}
