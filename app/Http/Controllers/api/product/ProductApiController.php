<?php

namespace App\Http\Controllers\api\product;
use Carbon\Carbon;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class ProductApiController extends Controller
{

//    public function index(Request $request)
//    {
//        $perPage = $request->get('per_page', 30); // Default items per page
//        $page = $request->get('page', 1); // Current page
//
//        // Use select to fetch only required fields to reduce memory usage
////        $products = Product::with(['category:id,name', 'brand:id,name', 'images:id,path,product_id', 'videos:id,path,product_id', 'variations:id,size,price,quantity,product_id'])
////            ->select('id', 'name', 'category_id', 'brand_id', 'short_description', )
////            ->paginate($perPage);
//        $products = Product::with([
//            'category:id,name',
//            'brand:id,name',
//            // Load only the first variation and for that variation, only the first image.
//            'variations' => function ($query) {
//                $query->limit(1)->with([
//                    'images' => function ($query) {
//                        $query->select('id', 'product_variation_id', 'image_path')->limit(1);
//                    }
//                ]);
//            }
//        ])->inRandomOrder()
//            ->select('id', 'name', 'category_id', 'brand_id', 'short_description')
//            ->paginate($perPage);
//
//
//        $totalProducts = $products->total();
//
//
//        $transformedProducts = $products->getCollection()->map(function ($product) {
//            $firstVariation = $product->variations->first();
//            $firstImage = $firstVariation ? $firstVariation->images->first() : null;
//
//            return [
//                'id'                => $product->id,
//                'name'              => $product->name,
//                'category_id'       => $product->category_id,
//                'brand_id'          => $product->brand_id,
//                'brand_name'        => $product->brand->name ?? null,
//                'category_name'     => $product->category->name ?? null,
//                'short_description' => $product->short_description,
//                // Use the first variation's price if available
//                'price'             => $firstVariation ? (int)$firstVariation->price : 0,
//                // Use the first image path of the first variation, or null if none exists
//                'image'             => $firstImage ? $firstImage->image_path : null,
//
//            ];
//        });
//
//// Now, you can return the paginated results along with metadata.
//// For example, if you’re returning JSON:
//        return response()->json([
//            'success' => true,
//            'data' => [
//                'products'   => $transformedProducts,
//                'pagination' => [
//                    'current_page' => $products->currentPage(),
//                    'last_page'    => $products->lastPage(),
//                    'per_page'     => $products->perPage(),
//                    'total'        => $products->total(),
//                ],
//            ],
//        ]);
//    }
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 30); // Default items per page
        $page = $request->get('page', 1); // Current page

        $products = Product::select('id', 'name', 'brand_id', 'category_id', 'description', 'short_description')
            ->with([
                'category:id,name',
                'brand:id,name',
                // Eager-load the variations and each variation's images:
                'variations.images'
            ])
            ->inRandomOrder()
            ->paginate($perPage);


        $totalProducts = $products->total();

        $transformedProducts = $products->map(function ($product) {


            return [
                'id'                => $product->id,
                'name'              => $product->name,
                'category_id'       => $product->category_id,
                'brand_id'          => $product->brand_id,
                'brand_name'        => $product->brand->name ?? null,
                'category_name'     => $product->category->name ?? null,
                'short_description' => $product->short_description,
                "price" => (int) $product->variations->first()->price  ?? 0,
                'image' => $product->variations->first()?->images->first()?->image_path ?? null,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'products'   => $transformedProducts,
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page'    => $products->lastPage(),
                    'per_page'     => $products->perPage(),
                    'total'        => $products->total(),
                ],
            ],
        ]);
    }
    public function RecommendProducts(Request $request)
    {
        $perPage = $request->get('per_page', 30); // Default items per page
        $page = $request->get('page', 1); // Current page

        // Use select to fetch only required fields to reduce memory usage
//        $products = Product::with(['category:id,name', 'brand:id,name', 'images:id,path,product_id', 'videos:id,path,product_id', 'variations:id,size,price,quantity,product_id'])
//            ->select('id', 'name', 'category_id', 'brand_id', 'short_description', )
//            ->paginate($perPage);
        $products = Product::with([
            'category:id,name',
            'brand:id,name',
            // Load only the first variation and for that variation, only the first image.
            'variations' => function ($query) {
                $query->limit(1)->with([
                    'images' => function ($query) {
                        $query->select('id', 'product_variation_id', 'image_path')->limit(1);
                    }
                ]);
            }
        ]) ->where('is_recommend',1)
            ->select('id', 'name', 'category_id', 'brand_id', 'short_description')
            ->paginate($perPage);


        $totalProducts = $products->total();


        $transformedProducts = $products->getCollection()->map(function ($product) {
            $firstVariation = $product->variations->first();
            $firstImage = $firstVariation ? $firstVariation->images->first() : null;

            return [
                'id'                => $product->id,
                'name'              => $product->name,
                'category_id'       => $product->category_id,
                'brand_id'          => $product->brand_id,
                'brand_name'        => $product->brand->name ?? null,
                'category_name'     => $product->category->name ?? null,
                'short_description' => $product->short_description,
                // Use the first variation's price if available
                'price'             => $firstVariation ? (int)$firstVariation->price : 0,
                // Use the first image path of the first variation, or null if none exists
                'image'             => $firstImage ? $firstImage->image_path : null,

            ];
        });

// Now, you can return the paginated results along with metadata.
// For example, if you’re returning JSON:
        return response()->json([
            'success' => true,
            'message'=>"Recommend Products List",
            'data' => [
                'products'   => $transformedProducts,
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page'    => $products->lastPage(),
                    'per_page'     => $products->perPage(),
                    'total'        => $products->total(),
                ],
            ],
        ]);
    }
    // calling after product details
    public function specificProduct()
    {
        $products = Product::select('id', 'name', 'brand_id', 'category_id', 'description', 'short_description')
            ->with([
                'category:id,name',
                'brand:id,name',
                // Eager-load the variations and each variation's images:
                'variations.images'
            ])
            ->inRandomOrder()
            ->limit(40)
            ->get();
//        dd($products);
        // Split the products into two groups of 10
        $products1 = $products->slice(0, 10)->values();
//     dd($products1);
        $products2 = $products->slice(10, 10)->values();
        $products3 = $products->slice(20, 30)->values();

        // Prepare the response data
        $productData = [
            'total' => $products->count(),
            'similar_products' => $products1->map(function ($product) {
                $firstVariation = $product->variations->first();
                $firstImage = $firstVariation ? $firstVariation->images->first() : null;
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category_id' => $product->category_id,
                    'brand_id' => $product->brand_id,
                    'brand_name'        => $product->brand->name ?? null,
                    'category_name' => $product->category->name ?? null,
                    'short_description' => $product->short_description,
                   'price'             => $firstVariation ? (int)$firstVariation->price : 0,
                 'image'             => $firstImage ? $firstImage->image_path : null,
                ];
            }),
            'you_may_also_like' => $products2->map(function ($product) {
                $firstVariation = $product->variations->first();
                $firstImage = $firstVariation ? $firstVariation->images->first() : null;
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category_id' => $product->category_id,
                    'brand_id' => $product->brand_id,
                    'brand_name'        => $product->brand->name ?? null,
                    'category_name' => $product->category->name ?? null,
                    'short_description' => $product->short_description,
                    'price'             => $firstVariation ? (int)$firstVariation->price : 0,
                    'image'             => $firstImage ? $firstImage->image_path : null,
                ];
            }),
            'recently_view' => $products3->map(function ($product) {
                $firstVariation = $product->variations->first();
                $firstImage = $firstVariation ? $firstVariation->images->first() : null;
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category_id' => $product->category_id,
                    'brand_id' => $product->brand_id,
                    'brand_name'        => $product->brand->name ?? null,
                    'category_name' => $product->category->name ?? null,
                    'short_description' => $product->short_description,
                    'price'             => $firstVariation ? (int)$firstVariation->price : 0,
                    'image'             => $firstImage ? $firstImage->image_path : null,
                ];
            }),
        ];

        return response()->json([
            'success' => true,
            'message' => 'Products ',
            // 'data' => $mainCategoriesData,
            'data' => $productData,
        ]);
    }


    // product after checkout
    public function specificProduct2()
    {

        $products = Product::select('id', 'name', 'brand_id', 'category_id', 'description', 'short_description')
            ->with([
                'category:id,name',
                'brand:id,name',
                // Eager-load the variations and each variation's images:
                'variations.images'
            ])
            ->inRandomOrder()
            ->limit(10)
            ->get();
        $product1 = Product::with([
            'category:id,name',
            'brand:id,name',
            // Load only variations with a price less than 20000
            'variations' => function ($query) {
                $query->where('price', '<', 20000);
            }
        ])
            ->whereHas('variations', function ($query) {
                // Filter products to those having at least one variation under 20000
                $query->where('price', '<', 20000);
            })
            ->inRandomOrder()
            ->limit(10)
            ->get();
        // Split the products into two groups of 10
        $products1 = $product1->slice(0, 10)->values();
        // $products2 = $products->slice(0, 10)->values();
        $products3 = $products->slice(0, 10)->values();

        // Prepare the response data
        $productData = [
            'total' => $products->count(),
            'Add these for under 10,000 Ks ' => $products1->map(function ($product) {
                $firstVariation = $product->variations->first();
                $firstImage = $firstVariation ? $firstVariation->images->first() : null;
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category_id' => $product->category_id,
                    'brand_id' => $product->brand_id,
                    'brand_name'        => $product->brand->name ?? null,
                    'category_name' => $product->category->name ?? null,
                    'short_description' => $product->short_description,
                    'price'             => $firstVariation ? (int)$firstVariation->price : 0,
                    'image'             => $firstImage ? $firstImage->image_path : null,
                ];
            }),

            'recently_view' => $products3->map(function ($product) {
                $firstVariation = $product->variations->first();
                $firstImage = $firstVariation ? $firstVariation->images->first() : null;
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category_id' => $product->category_id,
                    'brand_id' => $product->brand_id,
                    'brand_name'        => $product->brand->name ?? null,
                    'category_name' => $product->category->name ?? null,

                    'short_description' => $product->short_description,
                    'price'             => $firstVariation ? (int)$firstVariation->price : 0,
                    'image'             => $firstImage ? $firstImage->image_path : null,
                ];
            }),
        ];

        return response()->json([
            'success' => true,
            'message' => 'Products ',
            // 'data' => $mainCategoriesData,
            'data' => $productData,
        ]);
    }

    public function getProduct(Request $request,$id)
    {

        $product = Product::with(['variations', 'category', 'brand', 'images', 'videos','variations.images','variations.videos','category.maincategory'])->findOrFail($id);
        if($product == null){
            return  response()->json([
                'success'=>false,
                'message'=>"Product Not Found",
            ],404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'short_description' => $product->short_description,
                'description'=>$product->description,
                'image'=>$product->variations->first()->images->first()->image_path ?? null,

                'maincategory_id'=>$product->category->maincategory->id,
                'maincategory_name'=>$product->category->maincategory->name,
                'category_id' => $product->category_id,
                'brand_id' => $product->brand_id,
                'brand_name'        => $product->brand->name ?? null,
                'category_name' => $product->category->name ?? null,

                'product_variations' => $product->variations->map(function ($variant) {
                    return [
                        'id' => $variant->id,
                        'size' => $variant->size,
                        'price' => (int) $variant->price,
                        'quantity' => $variant->stock_qty,
                        'stock_qty'=>$variant->stock_qty,
                        'images'=>$variant->images->map(function($image){
                            return $image->image_path ;
                        }),
                        'videos'=>$variant->videos->map(function($video){
                            return $video->video_path ;
                        }),
                    ];
                }), // Items grouped by size and color
            ],
        ]);


    }
    public function getProductAfterLogin(Request $request,$id)
    {

        $product = Product::with(['variations', 'category', 'brand', 'images', 'videos','variations.images','variations.videos','category.maincategory'])->find($id);

//        dd($product);
        if($product == null){
            return  response()->json([
                'success'=>false,
                'message'=>"Product Not Found",
            ],404);
        }

        $user =Auth::user();
//        dd($user);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => "Invalid token",
            ], 401);
        }
        $isLoved = $user->whitelisted()
            ->where('product_variations.product_id', $product->id)
            ->exists();


        return response()->json([
            'success' => true,
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'short_description' => $product->short_description,
                'description'=>$product->description,
                'image'=>$product->variations->first()->images->first()->image_path ?? null,

                'maincategory_id'=>$product->category->maincategory->id,
                'maincategory_name'=>$product->category->maincategory->name,
                'category_id' => $product->category_id,
                'brand_id' => $product->brand_id,
                'brand_name'        => $product->brand->name ?? null,
                'category_name' => $product->category->name ?? null,
                'isLoved'=>$isLoved,

                'product_variations' => $product->variations->map(function ($variant) {
                    return [
                        'id' => $variant->id,
                        'size' => $variant->size,
                        'price' => (int) $variant->price,
                        'quantity' => $variant->stock_qty,
                        'stock_qty'=>$variant->stock_qty,
                        'images'=>$variant->images->map(function($image){
                            return $image->image_path ;
                        }),
                        'videos'=>$variant->videos->map(function($video){
                            return $video->video_path ;
                        }),
                    ];
                }), // Items grouped by size and color
            ],
        ]);


    }


    public function getAllNewProducts(Request $request)
    {
        // dd('hit');
        $perPage = $request->get('per_page', 30); // Default items per page
        $page = $request->get('page', 1); // Current page
        // Get products created in the last 30 days
        $newProducts = Product::with('variations') // Assuming 'items' is a relationship in the Product model
            ->where('created_at', '>=', Carbon::now()->subDays(7))
//            ->orderBy('created_at', 'desc')
            ->inRandomOrder()
            ->select('id', 'name', 'category_id', 'brand_id', 'short_description')
            ->paginate($perPage);
//            ->get();
        $transformedProducts = $newProducts->getCollection()->map(function ($product) {
            $firstVariation = $product->variations->first();
            $firstImage = $firstVariation ? $firstVariation->images->first() : null;

            return [
                'id'                => $product->id,
                'name'              => $product->name,
                'category_id'       => $product->category_id,
                'brand_id'          => $product->brand_id,
                'brand_name'        => $product->brand->name ?? null,
                'category_name'     => $product->category->name ?? null,
                'short_description' => $product->short_description,
                // Use the first variation's price if available
                'price'             => $firstVariation ? (int)$firstVariation->price : 0,
                // Use the first image path of the first variation, or null if none exists
                'image'             => $firstImage ? $firstImage->image_path : null,

            ];
        });
        return response()->json([
            'success' => true,
//            'data' => $newProducts,
         'message'=>"All New Products",
            'data' => [
                'products'   => $transformedProducts,
                'pagination' => [
                    'current_page' => $newProducts->currentPage(),
                    'last_page'    => $newProducts->lastPage(),
                    'per_page'     => $newProducts->perPage(),
                    'total'        => $newProducts->total(),
                ],
            ],
        ]);
    }
}
