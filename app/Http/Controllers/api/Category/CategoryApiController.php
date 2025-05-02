<?php

namespace App\Http\Controllers\api\Category;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryApiController extends Controller
{
    public function index()
    {
        // dd('hit');
        $categories = Category::with(['mainCategory'])->get();
        // Load main category with each brand

        // Loop through brands and extract main category
        $categoriesData = $categories->map(function ($cat) {
            return [
                'id' => $cat->id,
                'name' => $cat->name,
                'main_category_name' => $cat->mainCategory->name ?? null, // Get main category name if exists
                'main_category_id' => $cat->main_category_id,
//                'image' => $cat->image,
                // 'category_name' => $brand->category->name,
                // 'category_id' => $brand->category->id,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'All  Categories',
            'data' => $categoriesData,
        ]);
    }

    public function getCategory(Request $request, $id)
    {
        // Retrieve the category with its mainCategory
        $category = Category::with('mainCategory')->findOrFail($id);

        // Get pagination parameters (default per_page = 10, page = 1)
        $perPage = $request->get('per_page', 10);
        $page    = $request->get('page', 1);

        // Paginate products for this category while eager-loading necessary relationships
        $productsPaginated = $category->products()
            ->with([
                'brand:id,name',
                'category:id,name',
                'variations.images',
                'videos'
            ])
            ->paginate($perPage, ['*'], 'page', $page);

        // Loop over each product to get the first variation and its first image,
        // and also to set the product's price from the variation price.
        foreach ($productsPaginated->getCollection() as $product) {
            $firstVariation = $product->variations->first();
            if ($firstVariation) {
                $firstImage = $firstVariation->images->first();
                // Optionally, assign the variation price to the product price
                $product->price = $firstVariation->price;
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
                // Return the first variation image's path if available, else null.
                'image'             => $product->first_variation_image ? $product->first_variation_image->image_path : null,
//                'video'             => $product->videos->first()->path ?? null,
            ];
        });

        // Build the final category data with pagination metadata.
        $categoryData = [
            'id'                 => $category->id,
            'name'               => $category->name,
            'main_category_name' => $category->mainCategory->name ?? null,
            'main_category_id'   => $category->main_category_id,
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
            'message' => 'Category and products fetched successfully',
            'data'    => $categoryData,
        ]);
    }
}

//    public function getCategory($id)
//    {
//
////        $category = Category::with(['mainCategory', 'products'])->find($id);
//        $category = Category::with([
//            'mainCategory',
//            'products.brand',
//            'products.variations.images'
//        ])->findOrFail($id);
//
//        // Optionally, loop over each product to get the "first variation" and "first image"
//        foreach ($category->products as $product) {
//            $firstVariation = $product->variations->first(); // or null
//            if ($firstVariation) {
//                $firstImage = $firstVariation->images->first(); // or null
//                $product->price=$firstVariation->price;
//                // You could store it on a custom attribute for easier access in the view:
//                $product->first_variation_image = $firstImage;
//            } else {
//                $product->first_variation_image = null;
//            }
//        }
//
//        // Check if the category is found
//        if (!$category) {
//            return response()->json([
//                'success' => false,
//                'message' => 'Category not found',
//                'data' => [],
//            ]);
//        }
//        $productData = $category->products->map(function ($product) {
//            return [
//                'id' => $product->id,
//                'name' => $product->name,
//                'category_id' => $product->category_id,
//                'brand_id' => $product->brand_id,
//                'brand_name'=>$product->brand->name ?? null,
//                'category_name' => $product->category->name ?? null,
//                'short_description' => $product->short_description,
//                'description' => $product->description,
//                'price' => (int) $product->price,
////                    'original_price' => $product->original_price ?? 0,
////                    'discount_price' => $product->discount_price ?? 0,
////                    'image' => $product->images->first()->path ?? null,
//                'image' => $product->first_variation_image->image_path ?? null ,
//            ];
//        });


        // Shuffle products and take 30 random ones
//        $randomProducts = $category->products->shuffle()->take(30);
//        $products1 = $randomProducts->slice(0, 10)->values();
//        $products2 = $randomProducts->slice(10, 10)->values();
//        $products3 = $randomProducts->slice(20, 30)->values();

        // Prepare the response data
//        $productData = [
//          'Chosen_for_you' => $products1->map(function ($product) {
//                return [
//                    'id' => $product->id,
//                    'name' => $product->name,
//                    'category_id' => $product->category_id,
//                    'brand_id' => $product->brand_id,
//                    'brand_name'=>$product->brand->name ?? null,
//                    'category_name' => $product->category->name ?? null,
//                    'short_description' => $product->short_description,
//                    'description' => $product->description,
//                    'price' => (int) $product->price,
//
////                    'original_price' => $product->original_price ?? 0,
////                    'discount_price' => $product->discount_price ?? 0,
////                    'image' => $product->images->first()->path ?? null,
//                    'image' => $product->first_variation_image->image_path ?? null ,
//                ];
//            }),
//            'New_Arrivals' => $products2->map(function ($product) {
//                return [
//                    'id' => $product->id,
//                    'name' => $product->name,
//                    'category_id' => $product->category_id,
//                    'brand_id' => $product->brand_id,
//                    'brand_name'=>$product->brand->name ?? null,
//                    'category_name' => $product->category->name ?? null,
//
//                    'short_description' => $product->short_description,
//                    'description' => $product->description,
//                    'price' => (int) $product->price,
//
////                    'original_price' => $product->original_price ?? 0,
////                    'discount_price' => $product->discount_price ?? 0,
////                    'image' =>$product->images->first()->path ?? null,
//                    'image' => $product->first_variation_image->image_path ?? null ,
//                ];
//            }),
//
//            'beauty_offer ' =>
//             $products3 == null ?
//             $products3->map(function ($product) {
//                return [
//                    'id' => $product->id,
//                    'name' => $product->name,
//                     'category_id' => $product->category_id,
//                     'brand_id' => $product->brand_id,
//                    'brand_name'=>$product->brand->name ?? null,
//                    'category_name' => $product->category->name ?? null,
//
//                    'short_description' => $product->short_description,
//                    'description' => $product->description,
//                    'price' => (int) $product->price,
//                    'image' => $product->first_variation_image->image_path ?? null ,
////                    'original_price' => $product->original_price ?? 0,
////                    'discount_price' => $product->discount_price ?? 0,
////                    'image' => $product->images->first()->path ?? null,
//                ];
//            })
//            :
//            $products2->map(function ($product) {
//                return [
//                    'id' => $product->id,
//                    'name' => $product->name,
//                     'category_id' => $product->category_id,
//                     'brand_id' => $product->brand_id,
//                    'brand_name'=>$product->brand->name ?? null,
//                    'category_name' => $product->category->name ?? null,
//                    'short_description' => $product->short_description,
//                    'description' => $product->description,
//                    'price' => (int) $product->price,
//
////                    'original_price' => $product->original_price ?? 0,
////                    'discount_price' => $product->discount_price ?? 0,
////                    'image' => $product->images->first()->path ?? null,
//                    'image' => $product->first_variation_image->image_path ?? null ,
//                ];
//            }),
//
//        ];

        // Prepare category data
//        $categoryData = [
//            'id' => $category->id,
//            'name' => $category->name,
//            'main_category_name' => $category->mainCategory->name ?? null,
//            'main_category_id' => $category->main_category_id,
////            'image' => $category->image,
//            'products' => $productData,
//        ];
//
//        // Return JSON response
//        return response()->json([
//            'success' => true,
//            'message' => 'Category and products fetched successfully',
//            'data' => $categoryData,
//        ]);
//    }
//}
