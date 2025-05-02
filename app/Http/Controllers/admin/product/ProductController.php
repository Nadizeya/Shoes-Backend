<?php

namespace App\Http\Controllers\admin\product;


use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\ProductImage;
use App\Models\ProductVideo;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Models\ProductVariationImage;
use App\Models\ProductVariationVideo;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'subcategory', 'brand', 'images', 'videos' ,'variations.images',
        'variations.videos' )->get();
        foreach ($products as $product) {
            $product->total_variation_qty = $product->variations->sum('quantity');
            $product->total_sell_qty = $product->variations->sum('sell_qty');
            $product->total_stock_qty = $product->variations->sum('stock_qty');


        }
//        dd($products);

        return view('product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $brands = Brand::all();

        return view('product.createproduct', compact('categories', 'subcategories', 'brands'));
    }
    public function fetchSubcategories(Request $request)
    {

        $categoryId = $request->category_id;
        // dd($categoryId);

        if (is_null($categoryId) || !is_numeric($categoryId)) {
            return response()->json(['error' => 'Invalid category ID'], 400);
        }
        if (is_null($categoryId)) {
            return response()->json(['error' => 'Category ID is required'], 400);
        }

        $subcategories = Subcategory::where('category_id', $categoryId)->get();

        if ($subcategories->isEmpty()) {
            return response()->json(['message' => 'No subcategories found for the selected category'], 404);
        }

        return response()->json(['subcategories' => $subcategories]);


        // return response()->json(['error' => 'Invalid request'], 400);
    }



    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'category_id' => 'required',
    //         'subcategory_id' => 'required',
    //         'brand_id' => 'required',
    //         'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'videos.*' => 'nullable|mimes:mp4,avi,mkv|max:10000',
    //     ]);

    //     $product = Product::create([
    //         'name' => $request->name,
    //         'description' => $request->description,
    //         'category_id' => $request->category_id,
    //         'subcategory_id' => $request->subcategory_id,
    //         'brand_id' => $request->brand_id,
    //     ]);

    //     if ($request->hasFile('images')) {
    //         foreach ($request->file('images') as $image) {
    //             $path = $image->store('product_images', 'public');
    //             ProductImage::create([
    //                 'product_id' => $product->id,
    //                 'path' => $path,
    //             ]);
    //         }
    //     }

    //     if ($request->hasFile('videos')) {
    //         foreach ($request->file('videos') as $video) {
    //             $path = $video->store('product_videos', 'public');
    //             ProductVideo::create([
    //                 'product_id' => $product->id,
    //                 'path' => $path,
    //             ]);
    //         }
    //     }

    //     return redirect()->route('products.index')->with('success', 'Product created successfully.');
    // }


    public function store1(Request $request)
{
    // dd($request->all());
    $request->validate([
        'name' => 'required',
        'category_id' => 'required',
        'brand_id' => 'required',
        'quantity' => 'required',
        'original_price' => 'required',
        'sh_description' => 'required',
        'pd_description' => 'required',
        'size' => 'required',
        'color' => 'required',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'videos.*' => 'nullable|mimes:mp4|max:20000',
    ]);

    // Create the product
    $product = Product::create([
        'name' => $request->name,
        'short_description' => $request->sh_description,
        'description' => $request->pd_description,
        'category_id' => $request->category_id,
        'brand_id' => $request->brand_id,
        'quantity' => $request->quantity,
        'stock_qty' => $request->quantity,
        'sell_qty'=>0,
        'instock' => $request->quantity,
        'original_price' => $request->original_price,
        'is_discount' => $request->isDiscount,
        'discount_percent' => $request->discount_percent,
        'discount_price' => $request->discount_price,
        'is_recommend' => $request->is_recommended,
    ]);

    // Create product variations (size, color, price, quantity)
    foreach ($request->size as $index => $size) {
        ProductVariation::create([
            'product_id' => $product->id,
            'size' => $size,
            'color' => $request->color[$index], // Assuming color array matches size array
            'quantity' => $request->quantity[$index], // Same for quantity
            'price' => $request->price[$index], // Price for this size/color combination
        ]);
    }

    // Handle images
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $imagePath = $this->processImage($image);
            ProductImage::create([
                'product_id' => $product->id,
                'path' => $imagePath,
            ]);
        }
    }

    // Handle videos
    if ($request->hasFile('videos')) {
        foreach ($request->file('videos') as $video) {
            $videoPath = $this->storeVideo($video);
            ProductVideo::create([
                'product_id' => $product->id,
                'path' => $videoPath,
            ]);
        }
    }

    return redirect()->route('products.index');
}


    public function store(Request $request)
    {

//        dd($request->all());
        // 1) Validate
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'category_id'=>'required|exists:categories,id',
            'sh_description' => 'required',
            'pd_description' => 'required',
            // ... other product-level validation

            'variation' => 'required|array',
            'variation.*.size' => 'required|string|max:50',
//            'variation.*.color' => 'required|string|max:50',
            'variation.*.quantity' => 'required|integer|min:0',
            'variation.*.price' => 'required|numeric|min:0',

            // Variation images
            'variation_images' => 'nullable|array',
            'variation_images.*' => 'nullable|array',
            'variation_images.*.*' => 'file|image|mimes:png,jpg,jpeg|max:2048',

            // Variation videos
            'variation_videos' => 'nullable|array',
            'variation_videos.*' => 'nullable|array',
            'variation_videos.*.*' => 'file|mimetypes:video/mp4,video/quicktime,video/x-msvideo|max:20000',
        ]);
        $isRecommended = $request->input('is_recommended') === 'TRUE' ? 1 : 0;
        $totalQuantity = 0; // Initialize total quantity variable


        // 2) Create the product
        $product = Product::create([
            'name' => $request->input('name'),
            'brand_id' => $request->input('brand_id'),
            'category_id'=>$request->input('category_id'),
            'short_description' => $request->sh_description,
            'description' => $request->pd_description,
            'is_recommend' => $isRecommended,
            // ...
        ]);

        // 3) Loop each variation
        foreach ($request->input('variation') as $index => $varData) {
            $variation = ProductVariation::create([
                'product_id' => $product->id,
                'size' => $varData['size'],
//                'color' => $varData['color'],
                'quantity' => $varData['quantity'],
                'price' => $varData['price'],
                'stock_qty'=>$varData['quantity'],
                'sell_qty'=>0
            ]);

            // Images
//            if ($request->hasFile("variation_images.$index")) {
//                foreach ($request->file("variation_images.$index") as $imageFile) {
//                    $imagePath = $imageFile->store('variation-images', 'public');
//                    ProductVariationImage::create([
//                        'product_variation_id' => $variation->id,
//                        'image_path' => $imagePath,
//                    ]);
//                }
//            }
            if ($request->hasFile("variation_images.$index")) {
                foreach ($request->file("variation_images.$index") as $imageFile) {
                    // Use your custom image processing function
                    $imagePath = $this->processImage($imageFile);

                    // Create a record in the product_variation_images table
                    ProductVariationImage::create([
                        'product_variation_id' => $variation->id,
                        'image_path'           => $imagePath,
                    ]);
                }
            }

            // Videos
            if ($request->hasFile("variation_videos.$index")) {
                foreach ($request->file("variation_videos.$index") as $videoFile) {
                    $videoPath = $this->storeVideo($videoFile);
                    ProductVariationVideo::create([
                        'product_variation_id' => $variation->id,
                        'video_path' => $videoPath,
                    ]);
                }
            }
            $totalQuantity += $varData['quantity'];

        }
        $product->update([
            'stock_qty' => $totalQuantity
        ]);
        // 4) Redirect or return JSON
        return redirect()->route('products.index')
            ->with('success', 'Product with variations created successfully!');
    }
    // public function store(Request $request)
    // {
    //     // dd($request->all());
    //     $request->validate([
    //         'name' => 'required',
    //         'category_id' => 'required',
    //         // 'subcategory_id' => 'required',
    //         'brand_id' => 'required',
    //         'quantity'=>'required',
    //         'original_price'=>'required',
    //         'sh_description' => 'required',
    //         'pd_description' => 'required',
    //         'size'=>'required',
    //         'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'videos.*' => 'nullable|mimes:mp4|max:20000',

    //     ]);
    //     // dd($request->all());

    //     // Create the product
    //     $product = Product::create([
    //         'name' => $request->name,
    //         'short_description' => $request->sh_description,
    //         'description' => $request->pd_description,
    //         'category_id' => $request->category_id,
    //         // 'subcategory_id' => $request->subcategory_id,
    //         'brand_id' => $request->brand_id,
    //         'quantity'=>$request->quantity,
    //         'instock'=>$request->quantity,
    //         'original_price'=>$request->original_price,
    //         'is_discount'=>$request->isDiscount,
    //         'discount_percent'=>$request->discount_percent,
    //         'discount_price'=>$request->discount_price,
    //         'is_recommend'=>$request->is_recommended,
    //         'size'=>$request->size,
    //     ]);

    //     // Handle images
    //     if ($request->hasFile('images')) {
    //         foreach ($request->file('images') as $image) {
    //             $imagePath = $this->processImage($image);
    //             // dd($imagePath);
    //             ProductImage::create([
    //                 'product_id' => $product->id,
    //                 'path' => $imagePath,
    //             ]);
    //         }
    //     }


    //     // Handle videos
    //     if ($request->hasFile('videos')) {
    //         foreach ($request->file('videos') as $video) {
    //             $videoPath = $this->storeVideo($video);
    //             ProductVideo::create([
    //                 'product_id' => $product->id,
    //                 'path' => $videoPath,
    //             ]);
    //         }
    //     }

    //     // return redirect()->route('products.index')->with('success', 'Product created successfully.');
    //     return redirect()->route('products.index');
    // }

    private function processImage($image)
    {

        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $directory = public_path('vendors/images/products');
        // $path = $directory . '/' . $name_gen;

        // Ensure the directory exists
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Resize and save the image
        Image::make($image)->resize(626, 626)->save('vendors/images/products/' . $name_gen);

        // Prepare the relative path
        $relativePath = 'vendors/images/products/' . $name_gen;


        return $relativePath;
    }

    private function storeVideo($video)
    {
        // Generate a unique name for the video
        $videoName = hexdec(uniqid()) . '.' . $video->getClientOriginalExtension();

        // Define the directory path where videos will be stored
        $directory = public_path('vendors/videos/products');

        // Ensure the directory exists
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Define the path to store the video
        $videoPath = $directory . '/' . $videoName;

        // Move the uploaded video to the defined directory
        $video->move($directory, $videoName);

        // Prepare the relative path for the video
        $relativePath = 'vendors/videos/products/' . $videoName;

        return $relativePath;
    }

//    public function show($id)
//    {
//        $categories = Category::all();
//        $subcategories = Subcategory::all();
//        $brands = Brand::all();
//        $product = Product::findOrFail($id);
//
//        return view('product.showproduct', compact('product', 'categories', 'subcategories', 'brands'));
//    }
    public function show($id)
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $brands = Brand::all();
        // Eager-load variations + images/videos
        $product = Product::with(['variations.images', 'variations.videos'])
            ->findOrFail($id);

        return view('product.showproduct', compact('product', 'categories', 'subcategories', 'brands'));
    }


//    public function edit($id)
//    {
//        $categories = Category::all();
//        $subcategories = Subcategory::all();
//        $brands = Brand::all();
//        $product = Product::findOrFail($id);
//        // $categories = Category::orderBy('id', 'ASC')->get();
//        // $categories = Category::all();
//        return view('product.editproduct', compact('product', 'categories', 'subcategories', 'brands'));
//    }
    public function edit($id)
    {
        // Fetch product with variations, images, and videos
        $product = Product::with(['variations.images', 'variations.videos'])
            ->findOrFail($id);

        $categories = Category::all();
        $subcategories = Subcategory::all();
        $brands = Brand::all();

        return view('product.editproduct', compact('product', 'categories', 'subcategories', 'brands'));
    }

//    public function update(Request $request, Product $product)
//    {
//        // Validate the request
//        $request->validate([
//            'name' => 'required',
//            'category_id' => 'required',
//            // 'subcategory_id' => 'required',
//            'brand_id' => 'required',
//            'sh_description' => 'required',
//            'pd_description' => 'required',
//            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
//            'videos.*' => 'nullable|mimes:mp4|max:20000',
//        ]);
//        $cleanedText = strip_tags($request->sh_description);
//        $desc = strip_tags($request->pd_description);
//        $desc = html_entity_decode($desc);
//
//        // Optionally, decode HTML entities
//        $cleanedText = html_entity_decode($cleanedText);
//
//
//        // Update the product details
//        $product->update([
//            'name' => $request->name,
//            'short_description' => $cleanedText,
//            'description' => $desc,
//            'category_id' => $request->category_id,
//            // 'subcategory_id' => $request->subcategory_id,
//            'brand_id' => $request->brand_id,
//            'quantity'=>$request->quantity,
//            'original_price'=>$request->original_price,
//            'is_discount'=>$request->isDiscount,
//            'discount_percent'=>$request->discount_percent,
//            'discount_price'=>$request->discount_price,
//            'is_recommend'=>$request->is_recommended,
//        ]);
//
//        // Handle images
//        if ($request->hasFile('images')) {
//            // Delete old images
//            foreach ($product->images as $image) {
//                if (file_exists(public_path($image->path))) {
//                    unlink(public_path($image->path));
//                }
//                $image->delete();
//            }
//
//            // Save new images
//            foreach ($request->file('images') as $image) {
//                $imagePath = $this->processImage($image);
//                ProductImage::create([
//                    'product_id' => $product->id,
//                    'path' => $imagePath,
//                ]);
//            }
//        }
//
//        // Handle videos
//        if ($request->hasFile('videos')) {
//            // Delete old videos
//            foreach ($product->videos as $video) {
//                if (file_exists(public_path($video->path))) {
//                    unlink(public_path($video->path));
//                }
//                $video->delete();
//            }
//
//            // Save new videos
//            foreach ($request->file('videos') as $video) {
//                $videoPath = $this->storeVideo($video);
//                ProductVideo::create([
//                    'product_id' => $product->id,
//                    'path' => $videoPath,
//                ]);
//            }
//        }
//        $notification = array(
//            'message' => 'Product Updated Successfully',
//            'alert-type' => 'success'
//        );
//
//        return redirect()->route('products.index')->with($notification);
//    }
//    public function update(Request $request, Product $product)
//    {
//
//        // 1️⃣ **Validate the request data**
//        $request->validate([
//            'name' => 'required|string|max:255',
//            'brand_id' => 'required|exists:brands,id',
//            'category_id' => 'required|exists:categories,id',
//            'sh_description' => 'required|string',
//            'pd_description' => 'required|string',
//            'is_recommended' => 'nullable|boolean',
//
//            // Existing Variations Validation
//            'variation' => 'required|array',
//            'variation.*.size' => 'required|string|max:50',
//            'variation.*.quantity' => 'required|integer|min:0',
//            'variation.*.price' => 'required|numeric|min:0',
//
//            // New Variations Validation
//            'new_variation' => 'nullable|array',
//            'new_variation.*.size' => 'required|string|max:50',
//            'new_variation.*.quantity' => 'required|integer|min:0',
//            'new_variation.*.price' => 'required|numeric|min:0',
//
//            // Images
//            'new_variation_images' => 'nullable|array',
//            'new_variation_images.*.*' => 'file|image|mimes:png,jpg,jpeg|max:2048',
//
//            // Videos
//            'new_variation_videos' => 'nullable|array',
//            'new_variation_videos.*.*' => 'file|mimetypes:video/mp4,video/quicktime,video/x-msvideo|max:20000',
//        ]);
//
//        // 2️⃣ **Update product details**
//        $product->update([
//            'name' => $request->input('name'),
//            'brand_id' => $request->input('brand_id'),
//            'category_id' => $request->input('category_id'),
//            'short_description' => $request->input('sh_description'),
//            'description' => $request->input('pd_description'),
//            'is_recommend' => $request->input('is_recommended') ? 1 : 0,
//        ]);
//
//        $totalQuantity = 0;
//
//        // 3️⃣ **Update existing variations**
//        foreach ($request->input('variation') as $variationId => $varData) {
//            $variation = ProductVariation::findOrFail($variationId);
//            $variation->update([
//                'size' => $varData['size'],
//                'quantity' => $varData['quantity'],
//                'price' => $varData['price'],
//            ]);
//            $totalQuantity += $varData['quantity'];
//
//            // 4️⃣ **Store new images if provided**
//            if ($request->hasFile("new_variation_images.$variationId")) {
//                foreach ($request->file("new_variation_images.$variationId") as $imageFile) {
//                    $imagePath = $this->processImage($imageFile);
//                    ProductVariationImage::create([
//                        'product_variation_id' => $variation->id,
//                        'image_path' => $imagePath,
//                    ]);
//                }
//            }
//
//            // 5️⃣ **Store new videos if provided**
//            if ($request->hasFile("new_variation_videos.$variationId")) {
//                foreach ($request->file("new_variation_videos.$variationId") as $videoFile) {
//                    $videoPath = $this->storeVideo($videoFile);
//                    ProductVariationVideo::create([
//                        'product_variation_id' => $variation->id,
//                        'video_path' => $videoPath,
//                    ]);
//                }
//            }
//        }
//
//        // 6️⃣ **Add new variations**
//        if ($request->has('new_variation')) {
//            foreach ($request->input('new_variation') as $newVarData) {
//                $newVariation = ProductVariation::create([
//                    'product_id' => $product->id,
//                    'size' => $newVarData['size'],
//                    'quantity' => $newVarData['quantity'],
//                    'price' => $newVarData['price'],
//                ]);
//
//                $totalQuantity += $newVarData['quantity'];
//
//                // 7️⃣ **Store new variation images**
//                if ($request->hasFile("new_variation_images.new_{$newVariation->id}")) {
//                    foreach ($request->file("new_variation_images.new_{$newVariation->id}") as $imageFile) {
//                        $imagePath = $this->processImage($imageFile);
//                        ProductVariationImage::create([
//                            'product_variation_id' => $newVariation->id,
//                            'image_path' => $imagePath,
//                        ]);
//                    }
//                }
//
//                // 8️⃣ **Store new variation videos**
//                if ($request->hasFile("new_variation_videos.new_{$newVariation->id}")) {
//                    foreach ($request->file("new_variation_videos.new_{$newVariation->id}") as $videoFile) {
//                        $videoPath = $this->storeVideo($videoFile);
//                        ProductVariationVideo::create([
//                            'product_variation_id' => $newVariation->id,
//                            'video_path' => $videoPath,
//                        ]);
//                    }
//                }
//            }
//        }
//
//        // 9️⃣ **Update total stock quantity**
//        $product->update([
//            'stock_qty' => $totalQuantity
//        ]);
//
//        // 🔟 **Redirect with success message**
//        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
//    }
    public function update(Request $request, Product $product)
    {
        // ✅ Validate input data
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'sh_description' => 'required|string',
            'pd_description' => 'required|string',
            'is_recommended' => 'nullable|boolean',

            'variation' => 'required|array',
            'variation.*.size' => 'required|string|max:50',
            'variation.*.quantity' => 'required|integer|min:0',
            'variation.*.price' => 'required|numeric|min:0',

            // New images and videos
            'new_variation_images' => 'nullable|array',
            'new_variation_images.*.*' => 'file|image|mimes:png,jpg,jpeg|max:2048',
            'new_variation_videos' => 'nullable|array',
            'new_variation_videos.*.*' => 'file|mimetypes:video/mp4,video/quicktime,video/x-msvideo|max:20000',
        ]);

        // ✅ Update product details
        $product->update([
            'name' => $request->input('name'),
            'brand_id' => $request->input('brand_id'),
            'category_id' => $request->input('category_id'),
            'short_description' => $request->input('sh_description'),
            'description' => $request->input('pd_description'),
            'is_recommend' => $request->input('is_recommended') ? 1 : 0,
        ]);

        $totalQuantity = 0;

        // ✅ Update existing variations
        foreach ($request->input('variation') as $variationId => $varData) {
            $variation = ProductVariation::findOrFail($variationId);
            $variation->update([
                'size' => $varData['size'],
                'quantity' => $varData['quantity'],
                'price' => $varData['price'],
            ]);
            $totalQuantity += $varData['quantity'];

            // ✅ Store new images
            if ($request->hasFile("new_variation_images.$variationId")) {
                foreach ($request->file("new_variation_images.$variationId") as $imageFile) {
                    $imagePath = $imageFile->store('variation-images', 'public');
                    ProductVariationImage::create([
                        'product_variation_id' => $variation->id,
                        'image_path' => $imagePath,
                    ]);
                }
            }

            // ✅ Store new videos
            if ($request->hasFile("new_variation_videos.$variationId")) {
                foreach ($request->file("new_variation_videos.$variationId") as $videoFile) {
                    $videoPath = $videoFile->store('variation-videos', 'public');
                    ProductVariationVideo::create([
                        'product_variation_id' => $variation->id,
                        'video_path' => $videoPath,
                    ]);
                }
            }
        }

        // ✅ Update stock quantity
        $product->update(['stock_qty' => $totalQuantity]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }
    public function destroy(Product $product)
    {

//        dd($product);
        $productWithRelations = Product::with('variations.orderItems', 'variations.images', 'variations.videos')->find($product->id);

        // Check if any variations have order items
        foreach ($productWithRelations->variations as $variation) {
//            dd($variation);
            if ($variation->orderItems()->exists()) {
                $notification = array(
                    'message' => 'Cannot delete this product because already ordered.',
                    'alert-type' => 'error'
                );
                return redirect()->route('products.index')->with($notification);
            }
        }
        foreach ($productWithRelations->variations as $variation) {
            // Delete images
            foreach ($variation->images as $image) {
                // Remove image file from storage (if stored in 'storage/app/public' or 'public')
                if (file_exists(public_path($image->image_path))) {
                    unlink(public_path($image->image_path));
                }
                $image->delete(); // Delete image record from database
            }

            // Delete videos
            foreach ($variation->videos as $video) {
                // Remove video file from storage (if stored in 'storage/app/public' or 'public')
                if (file_exists(public_path( $video->video_path))) {
                    unlink(public_path( $video->video_path));
                }
                $video->delete(); // Delete video record from database
            }

            // Delete the variation itself
            $variation->delete();
        }

        // If no order items exist, delete variations first, then delete the product


        // Delete associated images
//        foreach ($product->images as $image) {
//            // Check if the file exists and delete it
//            if (file_exists(public_path($image->path))) {
//                unlink(public_path($image->path));
//            }
//            // Delete the image record from the database
//            $image->delete();
//        }
//
//        // Delete associated videos
//        foreach ($product->videos as $video) {
//            // Check if the file exists and delete it
//            if (file_exists(public_path($video->path))) {
//                unlink(public_path($video->path));
//            }
//            // Delete the video record from the database
//            $video->delete();
//        }
//        $product->variations()->delete(); // Deletes variations

        // Delete the product
        $product->delete();

        // Prepare notification
        $notification = array(
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'success'
        );

        // Redirect back to products index with notification
        return redirect()->route('products.index')->with($notification);
    }
}
