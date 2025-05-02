<?php

namespace App\Http\Controllers\admin\order;

use App\Models\Bank;
use App\Models\Order;
use App\Models\Account;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class OrderController extends Controller
{
//    public function index()
//    {
//        $orders = Order::with('items.variation.product', 'user')->get(); // Assuming `Order` has a relationship with `OrderItem`.
//        $total_qty = Order::with('items.variation.product', 'user')
//            ->get()
//            ->flatMap(function ($order) {
//                return $order->items;
//            })
//            ->sum('quantity');
//        return view('orders.index', compact('orders','total_qty'));
//    }
    public function index()
    {
        // Fetch all orders with items, variations, products, and user details
        $orders = Order::with([
            'items.variation.product',
            'items.variation.images' => function ($query) {
                $query->select('id', 'product_variation_id',
                    \DB::raw("CONCAT('" . url('/') . "/', image_path) AS full_image_path"));
            }
        ])->latest()->get();

        // Get total quantity across all orders
        $total_qty = $orders->flatMap(function ($order) {
            return $order->items;
        })->sum('quantity');

        return view('orders.index', compact('orders', 'total_qty'));
    }
    public function pending()
    {
        $orders = Order::with([
            'items.variation.product',
            'items.variation.images:id,product_variation_id,image_path' // Load only required columns
        ])
            ->where('status', 'placed')
            ->latest()
            ->get();

        // Attach full image path dynamically using an accessor or manually
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                foreach ($item->variation->images as $image) {
                    $image->full_image_path = url('/') . '/' . $image->image_path;
                }
            }
        }

        // Get total quantity across all completed (delivered) orders
        $total_qty = $orders->sum(fn($order) => $order->items->sum('quantity'));

        return view('orders.pending', compact('orders', 'total_qty'));
//        $orders = Order::with('items.variation.product', 'user')->where('status', 'placed')->get(); // Assuming `Order` has a relationship with `OrderItem`.
//        return view('orders.pending', compact('orders'));
    }
    public function completed()
    {
//        $orders = Order::with('items.variation.product', 'user')->where('status', 'delivered')->get(); // Assuming `Order` has a relationship with `OrderItem`.
//        return view('orders.completed', compact('orders'));
        // Fetch only delivered orders with optimized eager loading
        $orders = Order::with([
            'items.variation.product',
            'items.variation.images:id,product_variation_id,image_path' // Load only required columns
        ])
            ->where('status', 'delivered')
            ->latest()
            ->get();

        // Attach full image path dynamically using an accessor or manually
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                foreach ($item->variation->images as $image) {
                    $image->full_image_path = url('/') . '/' . $image->image_path;
                }
            }
        }

        // Get total quantity across all completed (delivered) orders
        $total_qty = $orders->sum(fn($order) => $order->items->sum('quantity'));

        return view('orders.completed', compact('orders', 'total_qty'));
    }
    public function confirm()
    {
        // Fetch only delivered orders with optimized eager loading
        $orders = Order::with([
            'items.variation.product',
            'items.variation.images:id,product_variation_id,image_path' // Load only required columns
        ])
            ->where('status', 'shipped')
            ->latest()
            ->get();

        // Attach full image path dynamically using an accessor or manually
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                foreach ($item->variation->images as $image) {
                    $image->full_image_path = url('/') . '/' . $image->image_path;
                }
            }
        }

        // Get total quantity across all completed (delivered) orders
        $total_qty = $orders->sum(fn($order) => $order->items->sum('quantity'));

        return view('orders.confirm', compact('orders', 'total_qty'));
//        $orders = Order::with('items.variation.product', 'user')->where('status', 'shipped')->get(); // Assuming `Order` has a relationship with `OrderItem`.
//        return view('orders.confirm', compact('orders'));
    }
    public function cancel()
    {
        $orders = Order::with([
            'items.variation.product',
            'items.variation.images:id,product_variation_id,image_path' // Load only required columns
        ])
            ->where('status', 'cancel')
            ->latest()
            ->get();

        // Attach full image path dynamically using an accessor or manually
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                foreach ($item->variation->images as $image) {
                    $image->full_image_path = url('/') . '/' . $image->image_path;
                }
            }
        }

        // Get total quantity across all completed (delivered) orders
        $total_qty = $orders->sum(fn($order) => $order->items->sum('quantity'));

        return view('orders.cancel', compact('orders', 'total_qty'));
//        $orders = Order::with('items.variation.product', 'user')->where('status', 'cancel')->get(); // Assuming `Order` has a relationship with `OrderItem`.
//        return view('orders.cancel', compact('orders'));
    }

    public function show($id)
    {
//        $order = Order::with('items.variation.product', 'user', 'transaction','userAddress')->findOrFail($id);
//
//        $orderItems = $order->items;
//
//        // Calculate total quantity
//        $total_qty = $orderItems->sum('quantity');
//
//
//        return view('orders.show', compact('order', 'total_qty'));


        $order = Order::with([
            'items.variation.product',
            'items.variation.images' => function ($query) {
                $query->select('id', 'product_variation_id',
                    \DB::raw("CONCAT('" . url('/') . "/', image_path) AS full_image_path"));
            },
            'user',
            'transaction',
            'transaction.account.bank',
            'userAddress'
        ])->findOrFail($id);

        $orderItems = $order->items;
        $total_qty = $orderItems->sum('quantity'); // Calculate total quantity

        return view('orders.show', compact('order', 'total_qty'));
    }
    public function generateVoucher(Request $request)
    {

        $order = Order::with('items.variation.product', 'user', 'transaction')->findOrFail($request->id);

        $orderItems = $order->items;

        // Calculate total quantity
        $total_qty = $orderItems->sum('quantity');
        $invoiceData = (object) [
            'order_code' => $order->order_code,
            'name' => $order->user->name,
            'address'=>$order->user->address,
            'phone'=>$order->user->phone,
            'status' => $order->status,
//            'date' => now()->format('d M Y'),
             'date'=>$order->created_at->format('d M Y'),
            'amount' => $order->total_price ?? 0,
            'total_qty' => $total_qty,
            'items' => $order->items // Pass order items directly
        ];


        // Generate PDF using Laravel DomPDF

        $pdf = PDF::loadView('voucher.template', compact('invoiceData'));

        // Define the folder path
        $folderPath = public_path('vendors/vouchers');

        // Ensure the directory exists
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        // Define the PDF file path
        $pdfPath = "vendors/vouchers/voucher_{$order->id}.pdf";

        // Save the PDF file
        file_put_contents(public_path($pdfPath), $pdf->output());

        return response()->json([
            'success' => true,
            'voucher_url' => asset($pdfPath)
        ]);

    }

    public function update(Request $request, $id)
    {
        // dd($id);
        $request->validate([
            'status' => 'required',
        ]);
        $order = Order::findorFail($id);

        $order->update([
            'status' => $request->status,
        ]);

        $notification = [
            'message' => 'Order Status Updated  Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }
    public function updateFromUser(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $order = Order::findOrFail($id);

        $order->update([
            'status' => $request->status,
        ]);

        $notification = [
            'message' => 'Order Status Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }



    public function deleteOrder($id)
    {
        DB::beginTransaction();
        try {
            // Find the order with items and user address
            $order = Order::with(['items.variation', 'userAddress'])->findOrFail($id);

            // Ensure only canceled orders can be deleted
            if ($order->status !== 'cancel') {
                $notification = [
                    'message' => 'Only  Cancel Order Can Be Delete  ',
                    'alert-type' => 'error',
                ];
                return redirect()->back()->with($notification);
            }

            // Restore stock and adjust sell quantity
            foreach ($order->items as $item) {
                $variation = $item->variation;
                if ($variation) {
                    $variation->update([
                        'stock_qty' => $variation->stock_qty + $item->quantity, // Restore stock
                        'sell_qty' => max(0, $variation->sell_qty - $item->quantity) // Adjust sell qty safely
                    ]);
                }
            }

            // Delete associated user address (if exists)
            if ($order->userAddress) {
                $order->userAddress->delete();
            }

            // Delete order items before deleting order
            $order->items()->delete();

            // Delete order
            $order->delete();

            DB::commit();

            $notification = [
                'message' => 'Order Delete Successfully ',
                'alert-type' => 'success',
            ];
            return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = [
                'message' => 'Order Delete Successfully '.$e->getMessage(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($notification);
//            return response()->json([
//                'message' => 'Something went wrong! ' . $e->getMessage(),
//                'alert-type' => 'error'
//            ], 400);
        }
    }

    public function deleteOrderFromShow($id)
    {
        DB::beginTransaction();
        try {
            // Find the order with items and user address
            $order = Order::with(['items.variation', 'userAddress'])->findOrFail($id);

            // Ensure only canceled orders can be deleted
            if ($order->status !== 'cancel') {
                $notification = [
                    'message' => 'Only  Cancel Order Can Be Delete  ',
                    'alert-type' => 'error',
                ];
                return redirect()->back()->with($notification);
            }

            // Restore stock and adjust sell quantity
            foreach ($order->items as $item) {
                $variation = $item->variation;
                if ($variation) {
                    $variation->update([
                        'stock_qty' => $variation->stock_qty + $item->quantity, // Restore stock
                        'sell_qty' => max(0, $variation->sell_qty - $item->quantity) // Adjust sell qty safely
                    ]);
                }
            }

            // Delete associated user address (if exists)
            if ($order->userAddress) {
                $order->userAddress->delete();
            }

            // Delete order items before deleting order
            $order->items()->delete();

            // Delete order
            $order->delete();

            DB::commit();

            $notification = [
                'message' => 'Order Delete Successfully ',
                'alert-type' => 'success',
            ];
            return redirect()->route('order.all')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = [
                'message' => 'Order Delete Successfully '.$e->getMessage(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($notification);
//            return response()->json([
//                'message' => 'Something went wrong! ' . $e->getMessage(),
//                'alert-type' => 'error'
//            ], 400);
        }
    }
}
