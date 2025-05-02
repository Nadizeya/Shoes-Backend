<?php

namespace App\Http\Controllers\api;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function addToCart(Request $request)
{

    // dd("hit");
    $user = Auth::user();

    // Validate incoming request data
    $request->validate([
//        'product_id' => 'required|exists:products,id',
        'product_variations_id' => 'required|exists:product_variations,id', // Using 'product_variations_id' for variant
        'quantity' => 'required|integer|min:0|max:5',
    ]);

    // Find the product and the selected product variation (variant)

    $variant = ProductVariation::find($request->product_variations_id); // Find the variant by 'product_variations_id'

//    dd($variant->stock_qty,$request->quantity);

    if (!$variant) {
        return response()->json([
            'success' => false,
            'message' => 'Variant not found.',
        ], 404);
    }


    // Check if the variant has enough stock
    if ($request->quantity >  $variant->stock_qty) {
        return response()->json([
            'success' => false,
            'message' => 'Not enough stock for the selected variant.',
        ], 400);
    }

        $cat = CartItem::where('user_id', $user->id)
            ->where('product_variations_id', $request->product_variations_id)
            ->where('product_id', $variant->product->id)
            ->first();

        if ($cat) {
            if ($request->quantity == 0) {
                // If the new quantity is 0, delete the cart item.
                $cat->delete();
            } else {
                // Update the existing cart item's quantity.
                $cat->quantity = $request->quantity + $cat->quantity;
                $cat->save();
            }
        } else {
            if ($request->quantity > 0) {
                // Create a new cart item if quantity is greater than 0.
                $cat = CartItem::create([
                    'user_id'               => $user->id,
                    'product_id'            => $variant->product->id,
                    'product_variations_id' => $request->product_variations_id,
                    'quantity'              => $request->quantity,
                ]);
            }
        }
//    dd($cat);// dd($request->all());

    // Create or update cart item
//    $cartItem = $user->cartItems()->create(
//        [
//            'product_id' => $variant->product->id,
//            'product_variations_id' => $request->product_variations_id,
//            'quantity' => $request->quantity, // Using the correct column name for the variant
//        ],
//
//    );


    return response()->json([
        'success' => true,
        'message' => 'Product added to cart.',
    ]);
}


//public function viewCart()
//{
//
//
//    $user = Auth::user();
//
//// Get cart items with related product, variations, and images
//$cartItems = $user->cartItems()
//    ->with([
//        'product' => function ($query) {
//            $query->select('id', 'name',  'short_description')
//                  ->with(['images' => function ($imageQuery) {
//                      $imageQuery->select('id', 'product_id', 'path');
//                  }])
//                  ->with('variations'); // Include variations
//        },
//    ])
//    ->get();
//
////// Group cart items by both product_id and variant_id
////$groupedCartItems = $cartItems->groupBy(function ($cartItem) {
////    return $cartItem->product_id . '-' . $cartItem->variant_id; // Group by product and variant
////});
////
////// Now, we'll flatten the grouped items and calculate the total price and quantity for each group.
////$groupedCartItems = $groupedCartItems->map(function ($group) {
////    $cartItem = $group->first(); // Get the first cart item in the group as a representative
////    $variant = $cartItem->variant;
////
////    // Calculate the total price for this group
////    $totalPrice = $group->sum(function ($item) {
////        return $item->quantity * $item->variant->price; // Total price = quantity * variant price
////    });
////
////    return [
////        'id' => $cartItem->id, // First item in the group (for the ID)
//////        'user_id' => $cartItem->user_id,
//////        'product_id' => $cartItem->product_id,
////        'quantity' => $group->sum('quantity'), // Sum of quantities in this group
////        'total_price' => $totalPrice,
////        'created_at' => $cartItem->created_at,
////        'updated_at' => $cartItem->updated_at,
////        'product' => [
////            'id' => $cartItem->product->id,
////            'name' => $cartItem->product->name,
////            'short_description' => $cartItem->product->short_description,
//////            'original_price' => $cartItem->product->original_price,
////            'image' => $cartItem->product->images->first()->path ?? null, // Image of the first product
////            'item' => [
////                'id'=>$variant->id,
////                'size' => $variant->size ?? null,
////                'color' => $variant->color ?? null,
////                'price' => $variant->price ?? 0,
////            ]
////        ]
////    ];
////})->values(); // Convert the result to a simple indexed array
////
////// Calculate the overall total price
////$total = $groupedCartItems->sum('total_price');
////
////// Return the response
////return response()->json([
////    'success' => true,
////    'data' => $groupedCartItems,
////    'total' => $total,
////]);
//    $groupedCartItems = $cartItems->groupBy(function ($cartItem) {
//        return $cartItem->product_id . '-' . $cartItem->variant_id; // Group by product and variant
//    });
//
//// Flatten the grouped items and calculate the total price and quantity for each group.
//    $groupedCartItems = $groupedCartItems->map(function ($group) {
//        // Use the first cart item in the group as a representative
//        $cartItem = $group->first();
//        // Get the product variation (make sure your CartItem model has a 'variant' relationship)
//        $variant = $cartItem->variant;
//
//        // Calculate the total price for this group:
//        $totalPrice = $group->sum(function ($item) {
//            return $item->quantity * $item->variant->price; // Quantity * variant price
//        });
//
//        return [
//            'id'          => $cartItem->id, // Using the first cart item's ID as representative
//            'quantity'    => $group->sum('quantity'), // Sum of quantities for this variant
//            'total_price' => $totalPrice,
//            'created_at'  => $cartItem->created_at,
//            'updated_at'  => $cartItem->updated_at,
//            'product'     => [
//                'id'                => $cartItem->product->id,
//                'name'              => $cartItem->product->name,
//                'short_description' => $cartItem->product->short_description,
//                // Use the first variation image (from the variant) instead of the product's own images:
//                'image'             => $variant && $variant->images->first() ? $variant->images->first()->path : null,
//                'item'              => [
//                    'id'    => $variant->id,
//                    'size'  => $variant->size ?? null,
//                    'color' => $variant->color ?? null,
//                    'price' => $variant->price ?? 0,
//                    // Optionally, you can include the variation image here as well:
//                    // 'image' => $variant->images->first() ? $variant->images->first()->path : null,
//                ]
//            ]
//        ];
//    })->values(); // Convert the result to a simple indexed array
//
//// Calculate the overall total price for all cart items.
//    $total = $groupedCartItems->sum('total_price');
//
//// Return the response
//    return response()->json([
//        'success' => true,
//        'data'    => $groupedCartItems,
//        'total'   => $total,
//    ]);
//}
    // Update Cart Item
    public function viewCart()
    {
        $user = Auth::user();

        // Retrieve cart items with the product variation (alias 'variant')
        // and eager-load for that variant its images (limit to 1)
        $cartItems = $user->cartItems()
            ->with([
                'variant' => function ($query) {
                    $query->select('id', 'price', 'size', 'product_id')
                        ->with([
                            'images' => function ($query) {
                                $query->select('id', 'product_variation_id', 'image_path')->limit(1);
                            }
                        ]);
                },
                // Optionally, load the parent product if needed:
                'product' => function ($query) {
                    $query->select('id', 'name', 'short_description');
                },
            ])
            ->get();


        // Transform each cart item to show variation details
        $transformedCartItems = $cartItems->map(function ($item) {

            $variant = $item->variant()->with('images')->first();

// Check if images exist
            $firstImage = $variant->images->isNotEmpty() ? $variant->images->first()->image_path : null;



            return [
                'cart_item_id' => $item->id,
                'quantity'     => $item->quantity,
                'total_price'=>$item->quantity * $variant->price,
                'price'=>(int)$variant->price,
                 'product_id'=> $item->product->id,
                'name'=>$item->product->name,
                'short_description'=>$item->product->short_description,
                'image' => $firstImage,

                'variant'      => [
                    'id'    => $variant ? $variant->id : null,
                    'size'  => $variant ? $variant->size : null,
                    'price' => $variant ? (int) $variant->price : 0,
                    'image' => $firstImage,
                ],
                // Optionally include product details if needed:
//                'product' => $item->product,
            ];
        });


        // Optionally calculate the overall total price
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * ($item->variant ? $item->variant->price : 0);
        });

        return response()->json([
            'success' => true,
            'data'    => $transformedCartItems,
            'total'   => $total,
        ]);
    }
    public function updateCart(Request $request, $cartItemId)
    {
        $user = Auth::user();

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = $user->cartItems()->find($cartItemId);

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found.',
            ], 404);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully.',
        ]);
    }

    // Remove Item from Cart
    public function removeFromCart($cartItemId)
    {
        $user = Auth::user();

        $cartItem = $user->cartItems()->find($cartItemId);

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found.',
            ], 404);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart item removed successfully.',
        ]);
    }
}
