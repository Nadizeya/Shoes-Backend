<?php
namespace App\Http\Controllers\api\product;
use App\Http\Controllers\Controller;

use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WhitelistApiController extends Controller
{
    // Fetch user's whitelisted products
    public function getWhitelist()
    {
        // dd('hit');
        $user = Auth::user();
//        dd($user->id);


//        $whitelistedProducts = $user->whitelisted()
//        ->with([
//        'product' => function ($query) {
//            $query->select('id', 'name', 'original_price', 'short_description')
//                  ->with(['images' => function ($imageQuery) {
//                      $imageQuery->select('id', 'product_id', 'path');
//                  }]);
//                 // Include variations
//        },
//         ])->get();
        $whitelistedProducts = $user->whitelisted()
            ->with([
                // Eager-load only the first image from the variation’s images.
                'images' => function ($query) {
                    $query->select('id', 'product_variation_id', 'image_path');
                },
                // Optionally, load the parent product details
                'product' => function ($query) {
                    $query->select('id', 'name',  'short_description');
                },
            ])
            ->get();
//        dd($whitelistedProducts->toArray());
        $transformed = $whitelistedProducts->map(function ($variation) {
            return [
                'variation_id' => $variation->id,
                'product_id' => $variation->product->id,
                'price'        => (int) $variation->price ?? 0,
                'name'         => $variation->product->name,
                'short_description'=>$variation->product->short_description,

                'image'        => $variation->images->first()?->image_path ?? null,

//                'product'      => $variation->product,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'User whitelist fetched successfully',
            'data' => $transformed
        ]);
    }

    // Add a product to the whitelist
    public function addToWhitelist(Request $request)
    {
        $request->validate([
            // 'product_id' => 'required|exists:products,id'
            'product_variation_id' => 'required|exists:product_variations,id'
        ]);

        $user = Auth::user();
//        dd($user);
        $product_variation_id = $request->product_variation_id;
        $exists = $user->whitelisted()
            ->wherePivot('product_variation_id', $product_variation_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Product variation is already in your whitelist'
            ], 422);
        }


//        dd($product);
        // dd($product_variation_id);

        // $user->whitelistedProducts()->attach($product_variation_id);
//        $user->whitelisted()->attach($product_variation_id);
        $productVariation = ProductVariation::with('product')->findOrFail($product_variation_id);
        $user->whitelisted()->attach($product_variation_id, ['product_id' => $productVariation->product->id,'user_id'=>$user->id]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to whitelist'
        ]);
    }
//     public function addToWhitelist(Request $request)
// {
//     $user = Auth::user();

//     if (!$user) {
//         return response()->json([
//             'success' => false,
//             'message' => 'User not authenticated.',
//         ], 401);
//     }

//     // Validate input
//     $request->validate([
//         'products' => 'required|array',
//         'products.*.product_id' => 'exists:products,id',
//         'products.*.count' => 'integer|min:1', // Ensure count is an integer and at least 1
//     ]);

//     $products = $request->input('products');

//     // Prepare data for attaching
//     $data = [];
//     foreach ($products as $product) {
//         $data[$product['product_id']] = ['count' => $product['count']];
//     }

//     // Attach products with count to the user's whitelist
//     $user->whitelistedProducts()->syncWithoutDetaching($data);

//     return response()->json([
//         'success' => true,
//         'message' => 'Products added to whitelist successfully.',
//     ]);
// }

    // Remove a product from the whitelist
    public function removeFromWhitelist(Request $request)
    {
        $request->validate([
             'product_variation_id' => 'required|exists:product_variations,id'
        ]);

        $user = Auth::user();
        $productId = $request->product_variation_id;

        $user->whitelisted()->detach($productId);

        return response()->json([
            'success' => true,
            'message' => 'Product removed from whitelist'
        ]);
    }
}
