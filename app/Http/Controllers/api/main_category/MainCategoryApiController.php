<?php

namespace App\Http\Controllers\api\main_category;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainCategoryApiController extends Controller
{
    // public function index()
    // {
    //     $mainCategories = MainCategory::with(['brands', 'categories'])->get();

    //     $mainCategoriesData = $mainCategories->map(function ($category) {
    //         return [
    //             'id' => $category->id,
    //             'name' => $category->name,
    //             'created_at' => $category->created_at,
    //             'updated_at' => $category->updated_at,
    //             'categories' => $category->categories->isNotEmpty() ? $category->categories->map(function ($cat) {
    //                 return [
    //                     'id' => $cat->id,
    //                     'name' => $cat->name,
    //                     'main_category_id' => $cat->main_category_id,
    //                     // 'image' => $brand->image,
    //                     // 'created_at' => $brand->created_at,
    //                     // 'updated_at' => $brand->updated_at,
    //                 ];
    //             }) : null,
    //             'brands' => $category->brands->isNotEmpty() ? $category->brands->map(function ($brand) {
    //                 return [
    //                     'id' => $brand->id,
    //                     'main_category_id' => $brand->main_category_id,
    //                     'name' => $brand->name,
    //                     // 'image' => $brand->image,
    //                     // 'created_at' => $brand->created_at,
    //                     // 'updated_at' => $brand->updated_at,
    //                 ];
    //             }) : null, // If no brands, return null
    //         ];
    //     });

    //     return response()->json([
    //         'success' => true,
    //         'message' => "All Main Categories ",
    //         'data' => $mainCategoriesData,
    //     ]);
    // }

    //     public function index()
    // {
    //     // Fetch all main categories with their categories
    //     $mainCategories = MainCategory::with('categories')->get();

    //     // Separate the 'New' category
    //     $newCategory = $mainCategories->firstWhere('name', 'New');
    //     $otherCategories = $mainCategories->filter(function ($category) {
    //         return $category->name !== 'New';
    //     });

    //     // Construct the 'New' main category data
    //     $newCategoryData = [
    //         'id' => $newCategory->id,
    //         'name' => $newCategory->name,
    //         'created_at' => $newCategory->created_at,
    //         'updated_at' => $newCategory->updated_at,
    //         'categories' => $otherCategories->map(function ($category) {
    //             return [
    //                 'id' => $category->id,
    //                 'name' => 'New ' . $category->name, // Prefix main category name with 'New'
    //                 // 'categories' => $category->categories->map(function ($cat) {
    //                 //     return [
    //                 //         'id' => $cat->id,
    //                 //         'name' => $cat->name,
    //                 //         'main_category_id' => $cat->main_category_id,
    //                 //     ];
    //                 // }),
    //                 'created_at' => $category->created_at,
    //                 'updated_at' => $category->updated_at,
    //             ];
    //         }),
    //     ];

    //     // Map all other main categories with their categories
    //     $mainCategoriesData = $otherCategories->map(function ($category) {
    //         return [
    //             'id' => $category->id,
    //             'name' => $category->name,
    //             'categories' => $category->categories->map(function ($cat) {
    //                 return [
    //                     'id' => $cat->id,
    //                     'name' => $cat->name,
    //                     'main_category_id' => $cat->main_category_id,
    //                 ];
    //             }),
    //             'created_at' => $category->created_at,
    //             'updated_at' => $category->updated_at,
    //         ];
    //     });

    //     // Add the modified 'New' category to the final result
    //     $mainCategoriesData->prepend($newCategoryData);

    //     // Return response
    //     return response()->json([
    //         'success' => true,
    //         'message' => "All Main Categories with New Category and Categories Combined",
    //         'data' => $mainCategoriesData,
    //     ]);
    // }

    // public function index()
    // {
    //     // Fetch all main categories with their categories
    //     $mainCategories = MainCategory::with('categories')->get();

    //     // Separate the 'New' category
    //     $newCategory = $mainCategories->firstWhere('name', 'New');
    //     $otherCategories = $mainCategories->filter(function ($category) {
    //         return $category->name !== 'New';
    //     });

    //     // Construct the 'New' main category data
    //     $newCategoryData = [
    //         'id' => $newCategory->id,
    //         'name' => $newCategory->name,
    //         'created_at' => $newCategory->created_at,
    //         'updated_at' => $newCategory->updated_at,
    //         'categories' => $otherCategories->map(function ($category) {
    //             // Exclude specific categories
    //             if (in_array($category->name, ['Mini Size', 'Beauty under 10000', 'Sales and offers'])) {
    //                 return null;
    //             }
    //             return [
    //                 'id' => $category->id,
    //                 'name' => 'New ' . $category->name, // Prefix main category name with 'New'
    //                 'created_at' => $category->created_at,
    //                 'updated_at' => $category->updated_at,
    //             ];
    //         })->filter()->values(), // Filter out null values and ensure categories are a plain array
    //     ];

    //     // Map all other main categories with their categories
    //     $mainCategoriesData = $otherCategories->map(function ($category) {
    //         return [
    //             'id' => $category->id,
    //             'name' => $category->name,
    //             'categories' => $category->categories->map(function ($cat) {
    //                 return [
    //                     'id' => $cat->id,
    //                     'name' => $cat->name,
    //                     'main_category_id' => $cat->main_category_id,
    //                 ];
    //             })->values(), // Ensure categories are a plain array
    //             'created_at' => $category->created_at,
    //             'updated_at' => $category->updated_at,
    //         ];
    //     });

    //     // Add the modified 'New' category to the final result
    //     $mainCategoriesData->prepend($newCategoryData);

    //     // Return response
    //     return response()->json([
    //         'success' => true,
    //         'message' => "All Main Categories with 'New' category combined",
    //         'data' => $mainCategoriesData,
    //     ]);
    // }
    public function index()
    {
        // Fetch all main categories with their categories
        $mainCategories = MainCategory::with('categories','brands')->get();


        // Separate the 'New' and 'Mini Size' categories
        $newCategory = $mainCategories->firstWhere('name', 'New');
//        $miniSizeCategory = $mainCategories->firstWhere('name', 'Mini Size');
//        $under20000Category = $mainCategories->firstWhere('name', 'Beauty under 20000');
//        $saleCategory = $mainCategories->firstWhere('name', 'Sales and offers');
        $otherCategories = $mainCategories->filter(function ($category) {
            return !in_array($category->name, ['New', 'Mini Size', 'Beauty under 20000', 'Sales and offers']);
        });

        // Helper function to construct the structure for "New" and "Mini Size"
        $buildCategoryData = function ($category, $allLabel) use ($otherCategories) {
            return [
                'id' => $category->id,
                'name' => $category->name,
//                'created_at' => $category->created_at,
//                'updated_at' => $category->updated_at,
                'categories' => collect([
                    [
                        'id' => 1,
                        'name' => $allLabel,
//                        'created_at' => $category->created_at,
//                        'updated_at' => $category->updated_at,
                    ],
                ])
                    ->concat(
                        $otherCategories
                            ->map(function ($other) use ($category) {
                                // if (in_array($other->name, ['Sales and offers'])) {
                                //     return null;
                                // }
                                // if (in_array($other->name, ['Sales and offers'])) {
                                //     return null;
                                // }
                                $adjustedName = $other->name;

                                if ($category->name === 'Beauty under 20000') {
                                    $adjustedName = $adjustedName . ' under 20000'; // Prefix with "New" if category is "New"
                                }
                                // if ($category->name === 'Sales and offers') {
                                //     $adjustedName =$adjustedName . ' under 20000'; // Prefix with "New" if category is "New"
                                // }
                                if ($category->name === 'New') {
                                    $adjustedName = 'New ' . $adjustedName; // Prefix with "New" if category is "New"
                                }
                                return [
                                    'id' => $other->id,
                                    'name' => $adjustedName,
//                                    'created_at' => $other->created_at,
//                                    'updated_at' => $other->updated_at,
                                ];
                            })
                            ->filter(),
                    )
                    ->values(),
                'brands' =>  []
            ];
        };
//         dd($otherCategories);
        // Construct 'New' and 'Mini Size' categories
        $newCategoryData = $buildCategoryData($newCategory, 'All New');
//        $miniSizeCategoryData = $buildCategoryData($miniSizeCategory, 'All Mini Sizes');
//        $under20000CategoryData = $buildCategoryData($under20000Category, 'All under 20000');
//        $saleCategoryData = $buildCategoryData($saleCategory, 'All Sales');
//        dd($otherCategories);

        // Map all other main categories with their categories
        $mainCategoriesData = $otherCategories->map(function ($category) {

            $brandsData = $category->brands->map(function ($brand) {
                return [
                    'id' => $brand->id,
                    'name' => $brand->name, // If you want to show brand images
//                    'main_category_id' => $brand->main_category_id,

                ];
            });
//
            if($brandsData){
                $is_brand=true;
            }else{
                $is_brand=false;
            }

            $category_data= $category->categories
                ->map(function ($cat) {
                    return [
                        'id' => $cat->id,
                        'name' => $cat->name,

//                            'main_category_id' => $cat->main_category_id,

                    ];
                })
                ->values();
//            dd($category_data);

            return [
                'id' => $category->id,
                'name' => $category->name,
//                'created_at' => $category->created_at,
//                'updated_at' => $category->updated_at,
//                'categories' => $is_brand ? $brandsData : $category_data,
//                'categories' =>  $category_data,
                  'categories'=>$category_data,
                   'brands' => $brandsData->isNotEmpty() ? $brandsData : []
//                'categories' => [
//                    // Always include the categories
//                    'categories' => $category_data,
//                    // If there are brands, include them
//                    'brands' => $brandsData->isNotEmpty() ? $brandsData : []
//                ],


            ];
        });

        // Combine all categories and sort them by ID
//        $finalData = collect([$newCategoryData, $miniSizeCategoryData, $under20000CategoryData, $saleCategoryData])
//            ->concat($mainCategoriesData)
//            ->sortBy('id') // Sort the categories by their IDs
//            ->values(); // Reset keys after sorting
        $finalData = collect([$newCategoryData])
            ->concat($mainCategoriesData)
            ->sortBy('id') // Sort the categories by their IDs
            ->values(); // Reset keys after sorting

        // Return response
        return response()->json([
            'success' => true,
            'message' => "All Main Categories with 'New' and 'Mini Size' categories combined",
            'data' => $finalData,
        ]);
    }

    public function getMainCategoryById(Request $request, $id)
    {
        // Retrieve the main category along with its relationships
        $mainCategory = MainCategory::with(['categories', 'brands'])->find($id);

        // If the main category is not found, return a 404 response
        if (!$mainCategory) {
            return response()->json([
                'success' => false,
                'message' => 'Main Category Not Found',
            ], 404);
        }
        if($mainCategory->name == "New"){
            $mainCategories = MainCategory::with(['categories', 'brands'])->get();

            // Filter out the "New" category from the list to obtain other categories
            $otherCategories = $mainCategories->filter(function ($category) {
                return $category->name !== "New";
            });

            // Define a helper function to build the desired category structure
            $buildCategoryData = function ($category, $allLabel) use ($otherCategories) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'new_categories' => collect([
                        [
                            'id' => 1,
                            'name' => $allLabel,
                        ],
                    ])->concat(
                        $otherCategories->map(function ($other) use ($category) {
                            $adjustedName = $other->name;
                            // Adjust name based on special conditions if needed

                            return [
                                'id' => $other->id,
                                'name' => $adjustedName,
                            ];
                        })->filter()
                    )->values(),
                    'categories'=>[],
                    'brands' => [] // For this special case, brands are set to an empty array
                ];
            };

            // Use the helper function to build the special "New" category data
            $transformedData = $buildCategoryData($mainCategory, 'All New');
        }else{
            $transformedData = [
                'id'         => $mainCategory->id,
                'name'       => $mainCategory->name,
                'new_categories'=>[],
                'categories' => $mainCategory->categories->map(function ($cat) {
                    return [
                        'id'   => $cat->id,
                        'name' => $cat->name,
                    ];
                })->values(),  // Reset keys after mapping
                'brands'     => $mainCategory->brands->map(function ($brand) {
                    return [
                        'id'   => $brand->id,
                        'name' => $brand->name,
                    ];
                })->values(),
            ];
        }
        // Transform the main category data into the desired structure


        // Return the transformed data as a JSON response
        return response()->json([
            'success' => true,
            'message' => 'Main Category retrieved successfully',
            'data'    => $transformedData,
        ]);
    }

    public function getProductsByManinCategories($id){
        $mainCategory = MainCategory::with(['categories', 'brands'])->find($id);

        // If the main category is not found, return a 404 response
        if (!$mainCategory) {
            return response()->json([
                'success' => false,
                'message' => 'Main Category Not Found',
            ], 404);
        }
        if($mainCategory->name="Brand"){
            
        }
    }

    // public function index()
    // {
    //     // Fetch all main categories with their categories
    //     $mainCategories = MainCategory::with('categories')->get();

    //     // Separate the 'New' and 'Mini Size' categories
    //     $newCategory = $mainCategories->firstWhere('name', 'New');
    //     $miniSizeCategory = $mainCategories->firstWhere('name', 'Mini Size');
    //     $otherCategories = $mainCategories->filter(function ($category) {
    //         return !in_array($category->name, ['New', 'Mini Size']);
    //     });

    //     // Construct the 'New' main category data with 'All New' included
    //     $newCategoryData = [
    //         'id' => $newCategory->id,
    //         'name' => $newCategory->name,
    //         'created_at' => $newCategory->created_at,
    //         'updated_at' => $newCategory->updated_at,
    //         'categories' => collect([
    //             [
    //                 'id' => 1,
    //                 'name' => 'All New',
    //                 'created_at' => $newCategory->created_at,
    //                 'updated_at' => $newCategory->updated_at,
    //             ],
    //         ])->concat($otherCategories->map(function ($category) {
    //             if (in_array($category->name, ['Beauty under 10000', 'Sales and offers'])) {
    //                 return null;
    //             }
    //             return [
    //                 'id' => $category->id,
    //                 'name' => 'New ' . $category->name,
    //                 'created_at' => $category->created_at,
    //                 'updated_at' => $category->updated_at,
    //             ];
    //         })->filter())->values(),
    //     ];

    //     // Construct the 'Mini Size' main category with similar structure
    //     $miniSizeCategoryData = [
    //         'id' => $miniSizeCategory->id,
    //         'name' => $miniSizeCategory->name,
    //         'created_at' => $miniSizeCategory->created_at,
    //         'updated_at' => $miniSizeCategory->updated_at,
    //         'categories' => collect([
    //             [
    //                 'id' => 1,
    //                 'name' => 'All Mini Sizes',
    //                 'created_at' => $newCategory->created_at,
    //                 'updated_at' => $newCategory->updated_at,
    //             ],
    //         ])->concat($otherCategories->map(function ($category) {
    //             if (in_array($category->name, ['Beauty under 10000', 'Sales and offers'])) {
    //                 return null;
    //             }
    //             return [
    //                 'id' => $category->id,
    //                 'name' =>  $category->name,
    //                 'created_at' => $category->created_at,
    //                 'updated_at' => $category->updated_at,
    //             ];
    //         })->filter())->values(),
    //     ];

    //     // Map all other main categories with their categories
    //     $mainCategoriesData = $otherCategories->map(function ($category) {
    //         return [
    //             'id' => $category->id,
    //             'name' => $category->name,
    //             'categories' => $category->categories->map(function ($cat) {
    //                 return [
    //                     'id' => $cat->id,
    //                     'name' => $cat->name,
    //                     'main_category_id' => $cat->main_category_id,
    //                 ];
    //             })->values(),
    //             'created_at' => $category->created_at,
    //             'updated_at' => $category->updated_at,
    //         ];
    //     });

    //     // Prepend 'New' and 'Mini Size' categories to the final result
    //     $mainCategoriesData->prepend($miniSizeCategoryData);
    //     $mainCategoriesData->prepend($newCategoryData);

    //     // Return response
    //     return response()->json([
    //         'success' => true,
    //         'message' => "All Main Categories with 'New' and 'Mini Size' categories combined",
    //         'data' => $mainCategoriesData,
    //     ]);
    // }

    public function home()
    {
//        $products = Product::select('id', 'name', 'brand_id', 'category_id', 'description', 'short_description', )
//            // ->with(['category:id,name', 'brand:id,name']) // Eager load categories and brands
//            ->inRandomOrder()
//            ->limit(40)
//            ->get();
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
        // Split the products into two groups of 10
        $products1 = $products->slice(0, 10)->values();
        $products2 = $products->slice(10, 10)->values();
        $products3 = $products->slice(20, 30)->values();
        $products4 = $products->slice(30, 40)->values();

        // Prepare the response data
        $productData = [
            'total' => $products->count(),
            'beauty_offer' => $products1->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category_id' => $product->category_id,
                    'brand_id' => $product->brand_id,
                    'brand_name'=>$product->brand->name ?? null,
                    'category_name' => $product->category->name ?? null,
                    'short_description' => $product->short_description,
                     "price" => (int) $product->variations->first()->price  ?? 0,
//                    'original_price' => $product->original_price ?? 0,
//                    'discount_price' => $product->discount_price ?? 0,

//                    'image' => $product->images->first()->path ?? null,
                    'image' => $product->variations->first()?->images->first()?->image_path ?? null,   // if still null, default to null
                ];
            }),
            'Choose_for_you' => $products2->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category_id' => $product->category_id,
                    'brand_id' => $product->brand_id,
                    'brand_name'=>$product->brand->name ?? null,
                    'category_name' => $product->category->name ?? null,

                    'short_description' => $product->short_description,
                    'original_price' => $product->original_price ?? 0,
                    'discount_price' => $product->discount_price ?? 0,
                    'image' => $product->images->first()->path ?? null,
                ];
            }),
            'New_Arrivals' => $products3->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category_id' => $product->category_id,
                    'brand_id' => $product->brand_id,
                    'brand_name'=>$product->brand->name ?? null,
                    'category_name' => $product->category->name ?? null,
                    'short_description' => $product->short_description,
                    'original_price' => $product->original_price ?? 0,
                    'discount_price' => $product->discount_price ?? 0,
                    'image' => $product->images->first()->path ?? null,
                ];
            }),
            'Your_trending_picks' => $products4->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category_id' => $product->category_id,
                    'brand_id' => $product->brand_id,
                    'brand_name'=>$product->brand->name ?? null,
                    'category_name' => $product->category->name ?? null,
                    'short_description' => $product->short_description,
                    'original_price' => $product->original_price ?? 0,
                    'discount_price' => $product->discount_price ?? 0,
                    'image' => $product->images->first()->path ?? null,
                ];
            }),
        ];

        return response()->json([
            'success' => true,
            'message' => 'Home Screen ',
            // 'data' => $mainCategoriesData,
            'data' => $productData,
        ]);
    }
    public function globalSearch(Request $request)
    {
        $validated = $request->validate([
            'query' => 'required|string|max:255',
        ]);

        $query = $validated['query'];

        // Fetch products matching the search term.
        // Note: I added 'short_description' to the select since it is used in the transformation.
        $products = Product::select('id', 'name', 'description', 'short_description')
            ->with([
                // Load only the first variation for each product.
                'variations' => function ($query) {
                    $query->limit(1);
                },
                // For the loaded variation, load only the first image.
                'variations.images' => function ($query) {
                    // Make sure to select the foreign key 'product_variation_id' so the relationship works.
                    $query->select('id', 'product_variation_id', 'image_path')->limit(1);
                }
            ])
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->limit(3)
            ->get();

        // Transform each product to include the first variation's price and first variation image.
        $transformedProducts = $products->map(function ($product) {
            // Retrieve the first variation (if it exists)
            $firstVariation = $product->variations->first();
            // Retrieve the first image of that variation (if exists)
            $firstImage = $firstVariation ? $firstVariation->images->first() : null;

            return [
                'id'                => $product->id,
                'name'              => $product->name,
                'short_description' => $product->short_description,
                // Set price based on the first variation's price, or null if none exists.
                'price'             =>  $firstVariation ? (int) $firstVariation->price : 0,
                // Set image to the first variation's first image path, or null.
                'image'             => $firstImage ? $firstImage->image_path : null,
            ];
        });

        // Search Brands matching the query.
        $brands = Brand::select('id', 'name', 'image')
            ->where('name', 'LIKE', "%{$query}%")
            ->limit(3)
            ->get();

        // Search Categories matching the query.
        $categories = Category::select('id', 'name')
            ->where('name', 'LIKE', "%{$query}%")
            ->limit(3)
            ->get();

        // Combine all results.
        $results = [
            'products'   => $transformedProducts,
            'brands'     => $brands,
            'categories' => $categories,
        ];

        return response()->json([
            'success' => true,
            'message' => 'Global search results',
            'data'    => $results,
        ], 200);
    }
//    public function globalSearch(Request $request)
//    {
//        $validated = $request->validate([
//            'query' => 'required|string|max:255',
//        ]);
//
//        $query = $validated['query'];
//
//        // Search Products
//        // $products = Product::select('id', 'name', 'description', 'original_price', 'discount_price')
//        //     ->with('images')
//        //     ->where('name', 'LIKE', "%{$query}%")
//        //     ->orWhere('description', 'LIKE', "%{$query}%")
//        //     ->limit(10)
//        //     ->get();
////        $products = Product::select('id', 'name', 'description', 'original_price', 'discount_price')
////            ->with([
////                'images' => function ($query) {
////                    $query->select('id', 'product_id', 'path')->limit(1); // Fetch only the first image
////                },
////            ])
////            ->where('name', 'LIKE', "%{$query}%")
////            ->orWhere('description', 'LIKE', "%{$query}%")
////            ->limit(3)
////            ->get();
////
////        // Format the response to include only the first image path
////        $products = $products->map(function ($product) {
////            return [
////                'id' => $product->id,
////                'name' => $product->name,
////                'description' => $product->description,
////                'original_price' => $product->original_price,
////                'discount_price' => $product->discount_price,
////                'image' => $product->images->first() ? $product->images->first()->path : null,
////            ];
////        });
//        $products = Product::select('id', 'name', 'description')
//            ->with([
//                // Load only the first variation
//                'variations' => function ($query) {
//                    $query->limit(1);
//                },
//                // For the loaded variation, load only the first image.
//                'variations.images' => function ($query) {
//                    // Adjust column names if needed. Here we assume 'image_path' holds the path.
//                    $query->select('id', 'product_variation_id', 'image_path')->limit(1);
//                }
//            ])
//            ->where(function ($q) use ($query) {
//                $q->where('name', 'LIKE', "%{$query}%")
//                    ->orWhere('description', 'LIKE', "%{$query}%");
//            })
//            ->limit(3)
//            ->get();
//
//        // Transform each product to include first variation's price and image.
//        $transformedProducts = $products->map(function ($product) {
//            // Get the first variation, if it exists.
//            $firstVariation = $product->variations->first();
//            // Get the first image of that variation, if available.
//            $firstImage = $firstVariation ? $firstVariation->images->first() : null;
//
//            return [
//                'id'          => $product->id,
//                'name'        => $product->name,
//                'short_description' => $product->short_description,
//                // Use the price from the first variation; otherwise, null.
//                'price'       => $firstVariation ? $firstVariation->price : null,
//                // Return the first variation image path (or null if not available).
//                'image'       => $firstImage ? $firstImage->image_path : null,
//            ];
//        });
//
//        // Search Brands
//        $brands = Brand::select('id', 'name','image')
//            ->where('name', 'LIKE', "%{$query}%")
//            ->limit(3)
//            ->get();
//
//        // Search Categories
//        $categories = Category::select('id', 'name')
//            ->where('name', 'LIKE', "%{$query}%")
//            ->limit(3)
//            ->get();
//
//        // Combine results
//        $results = [
//            'products' => $transformedProducts,
//            'brands' => $brands,
//            'categories' => $categories,
//        ];
//
//        return response()->json(
//            [
//                'success' => true,
//                'message' => 'Global search results',
//                'data' => $results,
//            ],
//            200,
//        );
//    }

    // public function home()
    // {
    //     // $mainCategories = MainCategory::with(['brands', 'categories'])->get();

    //     // $mainCategoriesData = $mainCategories->map(function ($category) {
    //     //     return [
    //     //         'id' => $category->id,
    //     //         'name' => $category->name,
    //     //         'created_at' => $category->created_at,
    //     //         'updated_at' => $category->updated_at,
    //     //         'categories' => $category->categories->isNotEmpty() ? $category->categories->map(function ($cat) {
    //     //             return [
    //     //                 'id' => $cat->id,
    //     //                 'name' => $cat->name,
    //     //                 'main_category_id' => $cat->main_category_id,
    //     //                 // 'image' => $brand->image,
    //     //                 // 'created_at' => $brand->created_at,
    //     //                 // 'updated_at' => $brand->updated_at,
    //     //             ];
    //     //         }) : null,
    //     //         'brands' => $category->brands->isNotEmpty() ? $category->brands->map(function ($brand) {
    //     //             return [
    //     //                 'id' => $brand->id,
    //     //                 'main_category_id' => $brand->main_category_id,
    //     //                 'name' => $brand->name,
    //     //                 // 'image' => $brand->image,
    //     //                 // 'created_at' => $brand->created_at,
    //     //                 // 'updated_at' => $brand->updated_at,
    //     //             ];
    //     //         }) : null, // If no brands, return null
    //     //     ];
    //     // });

    //     // dd($products1);

    //     $products = Product::select('id', 'name', 'brand_id', 'category_id', 'description', 'short_description', 'original_price', 'discount_price')
    //         // ->with(['category:id,name', 'brand:id,name']) // Eager load categories and brands
    //         ->inRandomOrder()
    //         ->limit(30)
    //         ->get();
    //     // Split the products into two groups of 10
    //     $products1 = $products->slice(0, 10);
    //     $products2 = $products->slice(10, 10);
    //     $products3 = $products->slice(20, 30);

    //     // Prepare the response data
    //     $productData = [
    //         'total' => $products->count(),
    //         'beauty_offer' => $products1->map(function ($product) {
    //             return [
    //                 'id' => $product->id,
    //                 'name' => $product->name,
    //                 'category_id' => $product->category_id,
    //                 'brand_id' => $product->brand_id,
    //                 'category_name' => $product->category->name ?? null,
    //                 'short_description' => $product->short_description,
    //                 'description' => $product->description,
    //                 'original_price' => $product->original_price ?? 0,
    //                 'discount_price' => $product->discount_price  ?? 0,

    //                 'image' => $product->images ?? null,
    //             ];
    //         }),
    //         'Choose_for_you' => $products2->map(function ($product) {
    //             return [
    //                 'id' => $product->id,
    //                 'name' => $product->name,
    //                 'category_id' => $product->category_id,
    //                 'brand_id' => $product->brand_id,
    //                 'category_name' => $product->category->name ?? null,

    //                 'short_description' => $product->short_description,
    //                 'description' => $product->description,
    //                 'original_price' => $product->original_price ?? 0,
    //                 'discount_price' => $product->discount_price  ?? 0,
    //                 'image' => $product->image,
    //             ];
    //         }),
    //         'New_Arrivals' => $products3->map(function ($product) {
    //             return [
    //                 'id' => $product->id,
    //                 'name' => $product->name,
    //                 'category_id' => $product->category_id,
    //                 'brand_id' => $product->brand_id,
    //                 'category_name' => $product->category->name ?? null,

    //                 'short_description' => $product->short_description,
    //                 'description' => $product->description,
    //                 'original_price' => $product->original_price ?? 0,
    //                 'discount_price' => $product->discount_price  ?? 0,
    //                 'image' => $product->image,
    //             ];
    //         }),

    //     ];

    //     // return response()->json($responseData);
    //     // $data = [
    //     //     // 'maincategroies' => $mainCategories,
    //     //     'products' => $productData
    //     // ];

    //     return response()->json([
    //         'success' => true,
    //         'message' => "Home Screen ",
    //         // 'data' => $mainCategoriesData,
    //         'data' => $productData,
    //     ]);
    // }
}
