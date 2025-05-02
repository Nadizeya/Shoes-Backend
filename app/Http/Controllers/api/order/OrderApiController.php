<?php

namespace App\Http\Controllers\api\order;

use App\Models\OrderUserAddress;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\ValidationException;

class OrderApiController extends Controller
{
    public function createOrder(Request $request)
    {
        // dd($request->all());

        try {
            $validated = $request->validate(
                [
                    'products' => 'required|array',
                    'products.*.variation_id' => 'required|exists:product_variations,id',
                    'products.*.quantity' => 'required|integer|min:1',
                    'total_price' => 'required|integer|min:1',
                    'account_id' => 'required|exists:accounts,id',
                    'user_id' => 'required|exists:users,id',
                    'user_name' => 'required',
                    'address' => 'required',
                    'phone_number' => 'required',
                    'payment_screenshot' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                ],
                [
                    'products.required' => 'The products field is required.',
                    'products.*.variation_id.exists' => 'The selected variation ID is invalid.',
                    'products.*.quantity.min' => 'Each product quantity must be at least 1.',
                    'total_price.min' => 'The total price must be at least 1.',
                    'account_id.exists' => 'The selected account is invalid.',
                    'user_id.exists' => 'The selected user is invalid.',
                    'user_name.required' => 'The user name field is required.',
                    'address.required' => 'The address field is required.',
                    'phone_number.required' => 'The phone number field is required.',
                    'phone_number.exists' => 'The phone number is already exists',
                ],
            );

            $user = User::findOrFail($validated['user_id']);

            // $user = auth()->user();

            DB::beginTransaction();
            try {
                $lastOrder = Order::orderBy('created_at', 'desc')->first();
                if ($lastOrder && $lastOrder->order_code) {
                    // Assuming order_code format is "NYH-XXXXXX"
                    $lastCode = $lastOrder->order_code; // e.g., "NYH-000001"
                    // Extract numeric part starting at position 4
                    $number = (int) substr($lastCode, 4);
                    $newNumber = $number + 1;
                    // Format new number with 6 digits
                    $orderCode = 'NYH-' . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
                } else {
                    // First order code if none exists
                    $orderCode = 'NYH-000001';
                }
                // Upload the payment screenshot
                // $screenshotPath = $request->file('payment_screenshot')->store('payments', 'public');

                // Create Order
//                $user->update([
//                    'name' => $validated['user_name'],
//                    'address' => $validated['address'],
//                    'phone' => $validated['phone_number'],
//                ]);
                $totalQuantity = collect($validated['products'])->sum('quantity');
                $order_user=OrderUserAddress::create([
                    'username' => $validated['user_name'],
                    'address' => $validated['address'],
                    'phone' => $validated['phone_number'],
                ]);

                $order = $user->orders()->create([
                    'total_price' => $validated['total_price'],
                    'status' => 'placed',
                    'total_product'=>$totalQuantity,
                    'order_user_address_id'=>$order_user->id,
                    'order_code'=>$orderCode
                ]);
                // $user->update(['name' => $variation->quantity - $product['quantity']]);

                $totalPrice = 0;

                foreach ($validated['products'] as $product) {
                    $variation = ProductVariation::lockForUpdate()->find($product['variation_id']);

                    if (  $variation->stock_qty <= $product['quantity'] - 1 ) {
                        throw new \Exception("Not enough stock for {$variation->product->name}");
                    }

                    // Update Stock for Variation
//                    $variation->update([
//                        'stock_qty' => $variation->quantity - $product['quantity'],
//                        'sell_qty'=> $variation->quantity + $product['sell_qty']
//                    ]);
                    $variation->update([
                        'stock_qty' =>  $variation->stock_qty - $product['quantity'] , // Subtract the sold quantity from stock
                        'sell_qty' => $variation->sell_qty + $product['quantity'], // Add the sold quantity to sell_qty
                    ]);

                    // Update Product's Stock and Sell Quantities
                    $productModel = $variation->product;
                    $productModel->stock_qty -= $product['quantity'];
                    $productModel->sell_qty += $product['quantity'];
                    $productModel->save();

                    // Add Order Item
                    $order->items()->create([
                        'product_variation_id' => $variation->id,
                        'quantity' => $product['quantity'],
                        'price' => $variation->price,
                    ]);

                    $totalPrice += $variation->price * $product['quantity'];
                }

                if ($request->hasFile('payment_screenshot')) {
                    $image = $request->file('payment_screenshot');
                    $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                    $directory = public_path('vendors/images/transactions');
                    // $path = $directory . '/' . $name_gen;

                    // Ensure the directory exists
                    if (!is_dir($directory)) {
                        mkdir($directory, 0755, true);
                    }

                    // Resize and save the image
                    Image::make($image)
                        ->resize(626, 626)
                        ->save('vendors/images/transactions/' . $name_gen);

                    // Prepare the relative path
                    $relativePath = 'vendors/images/transactions/' . $name_gen;
                    $transaction = $order->transaction()->create([
                        'account_id' => $validated['account_id'],
                        'payment_screenshot' => $relativePath,
                        'total_price' => $totalPrice,
                        // 'status' => 'pending',
                    ]);
                } else {
                    $transaction = $order->transaction()->create([
                        'account_id' => $validated['account_id'],
                        // 'payment_screenshot' => $relativePath,
                        'total_price' => $totalPrice,
                        // 'status' => 'pending',
                    ]);
                }

                DB::commit();

                return response()->json(['message' => 'Order and transaction created successfully!', 'order' => $order, 'transaction' => $transaction], 201);
            } catch (\Exception $e) {
                DB::rollBack();

                return response()->json(['error' => $e->getMessage()], 400);
            }
        } catch (ValidationException $e) {
            // If validation fails, return the error messages
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                ],
                422,
            );
        }
    }

    public function getOrder(Request $request)
    {
        $validated = $request->validate(
            [
                'user_id' => 'required|exists:users,id',
            ],
            [
                'user_id.exists' => 'The selected user is invalid.',
            ],
        );
        $user = User::findOrFail($validated['user_id']); // Ensure the user exists.
        // dd($user);

        $orders = Order::with('items.variation.product', 'user')
            ->where('user_id', $user->id)
            ->get();
        $customOrders = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'user_id' => $order->user_id,
                'total_price' => (int) $order->total_price,
                'status' => $order->status,
                'order_code'=>$order->order_code,
                'created_date' => $order->created_at,
                'updated_date' => $order->updated_at,

                'order_items' => $order->items->map(function ($item) {
                    return [
                        'id' => $item->id,

                        'quantity' => $item->quantity,
                        'price' => (int) $item->price,

                        'variation' => [
                            'id' => $item->variation->id,
                            'size' => $item->variation->size,
//                            'color' => $item->variation->color,
                            'name' => $item->variation->product->name,
                            'image' => $item->variation->images->first()->image_path ?? null,
                            // 'product' => [
                            //     'id' => $item->variation->product->id,
                            //     'name' => $item->variation->product->name,
                            //     'short_description' => $item->variation->product->short_description,
                            //     'description' => $item->variation->product->description,
                            //     'quantity' => $item->variation->product->quantity,
                            //     'instock' => $item->variation->product->instock,
                            //     'original_price' => $item->variation->product->original_price,
                            //     'discount_price' => $item->variation->product->discount_price,
                            //     'sell_qty' => $item->variation->product->sell_qty,
                            //     'stock_qty' => $item->variation->product->stock_qty,
                            //     'is_recommend' => $item->variation->product->is_recommend,
                            //     'is_discount' => $item->variation->product->is_discount,
                            //     'discount_percent' => $item->variation->product->discount_percent,
                            //     'category_id' => $item->variation->product->category_id,
                            //     'subcategory_id' => $item->variation->product->subcategory_id,
                            //     'brand_id' => $item->variation->product->brand_id,
                            //     'created_at' => $item->variation->product->created_at,
                            //     'updated_at' => $item->variation->product->updated_at,
                            // ],
                        ],
                    ];
                }),
            ];
        });

        return response()->json(
            [
                'success' => false,
                'message' => 'User Orders',
                'data' => $customOrders,
            ],
            200,
        );
    }
    public function show($id, Request $request)
    {
        $validated = $request->validate(
            [
                'user_id' => 'required|exists:users,id',
            ],
            [
                'user_id.exists' => 'The selected user is invalid.',
            ],
        );

        $user = User::findOrFail($validated['user_id']); // Ensure the user exists.

        // Fetch the single order by ID and the user's ID
        $order = Order::with('items.variation.product', 'items.variation.product.images', 'userAddress','user', 'transaction')
            ->where('user_id', $user->id)
            ->findOrFail($id);

        // Build the custom response
        $customOrder = [
            'id' => $order->id,
            'status' => $order->status,
            'order_code'=>$order->order_code,
            'created_date' => $order->created_at,
            'updated_date' => $order->updated_at,
            'order_items' => $order->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'quantity' => $item->quantity,
                    'price' => $item->price * $item->quantity,
                    'size' => $item->variation->size,
//                    'color' => $item->variation->color,
                    'name' => $item->variation->product->name,
                    'image' => $item->variation->images->first()->image_path ?? null,
                ];
            }),
            'delivery' => [
                'address' => $order->userAddress->address ?? null,
                'name' => $order->userAddress->username ?? null,
                'phone_number' => $order->userAddress->phone ?? null,
            ],
            'order_summary' => [
                'total' => $order->total_price - 0,
                'delivery' => 0,
                'receipt_photo'=>$order->transaction->payment_screenshot ?? null,
            ],
        ];

        return response()->json(
            [
                'success' => true,
                'message' => 'User Order details',
                'data' => $customOrder,
            ],
            200,
        );
    }
}
