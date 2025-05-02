<?php

namespace App\Http\Controllers\api\brand;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandApiController extends Controller
{
    public function index()
    {

        // dd('hit');
        $brands = Brand::with(['mainCategory'])->get(); // Load main category with each brand

        // Loop through brands and extract main category
        $brandsData = $brands->map(function ($brand) {
            return [
                'id' => $brand->id,
                'name' => $brand->name,
                'main_category_name' => $brand->mainCategory->name ?? null, // Get main category name if exists
                'main_category_id' => $brand->main_category_id,
                'image' => $brand->image,
                // 'category_name' => $brand->category->name,
                // 'category_id' => $brand->category->id,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => "All Brands with Categories",
            'data' => $brandsData,
        ]);
    }
    // public function getBrand($id)
    // {

    //     $brand = Brand::with(['mainCategory'])->find($id);

    //     // Check if the brand is found
    //     if (!$brand) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Brand not found',
    //             'data' => []
    //         ]);
    //     }

    //     // Fetch products associated with this brand
    //     $products = Product::where('brand_id', $id)->inRandomOrder()->limit(10)->get();

    //     // Prepare brand data
    //     $brandData = [
    //         'id' => $brand->id,
    //         'name' => $brand->name,
    //         'main_category_name' => $brand->mainCategory->name ?? null,
    //         'main_category_id' => $brand->main_category_id,
    //         'image' => $brand->image,
    //         // 'category_name' => $brand->category->name ?? null,
    //         // 'category_id' => $brand->category->id ?? null,
    //         'products' => $products ?? null
    //     ];

    //     // Prepare response data
    //     // $responseData = [
    //     //     'brand' => $brandData,

    //     // ];

    //     // Return JSON response
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Brand and products fetched successfully',
    //         'data' => $brandData
    //     ]);
    // }
//    public function getBrand($id)
//    {
//        // Fetch the brand with its main category and products, including their categories
////        $brand = Brand::with(['mainCategory', 'products.category'])->find($id);
//        // Eager-load brand relations, including products, their categories, and variations+images
//        $brand = Brand::with([
//            'mainCategory',
//            'products.category',
//            'products.variations.images'
//        ])->findOrFail($id);
//
//        // Optionally, loop over each product to get the "first variation" and "first image"
//        foreach ($brand->products as $product) {
//            $firstVariation = $product->variations->first(); // or null
//            if ($firstVariation) {
//                $firstImage = $firstVariation->images->first(); // or null
//                // You could store it on a custom attribute for easier access in the view:
//                $product->first_variation_image = $firstImage;
//                $product->price=$firstVariation->price;
//            } else {
//                $product->first_variation_image = null;
//            }
//        }
////        dd($brand);
//
//        // Check if the brand is found
//        if (!$brand) {
//            return response()->json([
//                'success' => false,
//                'message' => 'Brand not found',
//                'data' => []
//            ]);
//        }
//
//
//
//        // Prepare brand data
//        $brandData = [
//            'id' => $brand->id,
//            'name' => $brand->name,
//            'main_category_name' => $brand->mainCategory->name ?? null,
//            'main_category_id' => $brand->main_category_id,
//            'image' => $brand->image,
//            // 'products' => $brand->products->generate()->take(10)->map(function ($product) {
//            'products' => $brand->products->random(10)
//                ->map(function ($product) {
//                    return [
//                        'id' => $product->id,
//                        'name' => $product->name,
//                        'category_id' => $product->category_id,
//                        'brand_id' => $product->brand_id,
//                        'brand_name'=>$product->brand->name ?? null,
//                        'category_name' => $product->category->name ?? null,
//                        'short_description' => $product->short_description,
//                        'description' => $product->description,
//                        'price' => (int) $product->price,
////                        'original_price' => $product->original_price ?? 0,
////                        'discount_price' => $product->discount_price ?? 0,
//                        'image' => $product->first_variation_image->image_path ?? null ,
//                        // Include other product details as needed
//                    ];
//                })
//        ];
//
//        // Return JSON response
//        return response()->json([
//            'success' => true,
//            'message' => 'Brand and products fetched successfully',
//            'data' => $brandData
//        ]);
//    }
    public function getBrand(Request $request, $id)
    {
        // Get pagination parameters (default per_page = 10, page = 1)
        $perPage = $request->get('per_page', 10);
        $page    = $request->get('page', 1);


        $brand = Brand::with([
            'mainCategory',
            'products.category',
            'products.brand',
            'products.variations.images',
            'products.videos' // if you use product-level videos
        ])->findOrFail($id);

        // Paginate the products for this brand.
        $productsPaginated = $brand->products()->paginate($perPage, ['*'], 'page', $page);

        // Loop over each product (in the paginated collection) to set custom attributes.
        foreach ($productsPaginated->getCollection() as $product) {
            $firstVariation = $product->variations->first();
            if ($firstVariation) {
                $firstImage = $firstVariation->images->first();
                // Set product price from the first variation's price
                $product->price = $firstVariation->price;
                // Store the first variation image for easier access
                $product->first_variation_image = $firstImage;
            } else {
                $product->first_variation_image = null;
            }
        }

        // Transform each product to include only the desired fields.
        $transformedProducts = $productsPaginated->getCollection()->map(function ($product) {
            return [
                'id'                => $product->id,
                'name'              => $product->name,
                'category_id'       => $product->category_id,
                'brand_id'          => $product->brand_id,
                'brand_name'        => $product->brand->name ?? null,
                'category_name'     => $product->category->name ?? null,
                'short_description' => $product->short_description,
                'price'             => (int) $product->price ?? 0,
                // Return the first variation image path if available, otherwise null.
                'image'             => $product->first_variation_image ? $product->first_variation_image->image_path : null,
                // Optionally include videos if needed:
//                'video'             => $product->videos->first()->path ?? null,
            ];
        });

        // Prepare the final brand data along with pagination metadata.
        $brandData = [
            'id'                 => $brand->id,
            'name'               => $brand->name,
            'main_category_name' => $brand->mainCategory->name ?? null,
            'main_category_id'   => $brand->main_category_id,
            'image'              => $brand->image,
            'products'           => $transformedProducts,
            'pagination'         => [
                'current_page' => $productsPaginated->currentPage(),
                'last_page'    => $productsPaginated->lastPage(),
                'per_page'     => $productsPaginated->perPage(),
                'total'        => $productsPaginated->total(),
            ],
        ];

        return response()->json([
            'success' => true,
            'message' => 'Brand and products fetched successfully',
            'data'    => $brandData,
        ]);
    }
}
