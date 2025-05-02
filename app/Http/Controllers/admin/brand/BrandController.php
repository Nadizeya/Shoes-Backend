<?php

namespace App\Http\Controllers\admin\brand;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        // $brands = Brand::all();
        // $brands = Brand::orderBy('id', 'desc')->get();
        // $brands = Brand::latest()->get();
        // $main = MainCategory::all();
        $brands = Brand::with('mainCategory')->latest()->get();
        return view('brands.index', compact('brands'));
    }

    public function create()
    {
        return view('brands.createbrand');
    }

    // public function store(Request $request)
    // {

    //     $request->validate([
    //         'name' => 'required',
    //         'multi_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $imagePaths = [];
    //     if ($request->hasFile('multi_image')) {
    //         foreach ($request->file('multi_image') as $file) {
    //             $name_gen = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
    //             $directory = public_path('vendors/images/brands');
    //             $path = $directory . '/' . $name_gen;

    //             // Ensure the directory exists
    //             if (!is_dir($directory)) {
    //                 mkdir($directory, 0755, true);
    //             }

    //             // Resize and save the image
    //             Image::make($file)->resize(626, 626)->save($path);

    //             // Prepare the relative path
    //             $relativePath = 'vendors/images/brands/' . $name_gen;
    //             $imagePaths[] = $relativePath;
    //         }
    //     }

    //     Brand::create([
    //         'name' => $request->name,
    //         'image' => json_encode($imagePaths), // Store image paths as JSON in the existing 'image' column
    //     ]);

    //     return redirect()->route('brands.index')->with('success', 'Brand created successfully.');
    // }
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $directory = public_path('vendors/images/brands');
            // $path = $directory . '/' . $name_gen;

            // Ensure the directory exists
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            // Resize and save the image
            Image::make($image)->resize(626, 626)->save('vendors/images/brands/' . $name_gen);

            // Prepare the relative path
            $relativePath = 'vendors/images/brands/' . $name_gen;
            Brand::create([
                'name' => $request->name,
                'image' => $relativePath,
                'main_category_id' => 2 // Store image paths as JSON in the existing 'image' column
            ]);
        } else {
            Brand::create([
                'name' => $request->name,
                'image' => $request->image,
                'main_category_id' => 2 // Store image paths as JSON in the existing 'image' column
            ]);
        }


        $notification = array(
            'message' => 'Brand created successfully.',
            'alert-type' => 'success'
        );

        return redirect()->route('brands.index')->with($notification);
    }
    public function show($id)
    {
        $brand = Brand::FindOrFail($id);

        return view('brands.showbrand', compact('brand'));
    }

    public function edit($id)
    {
        $brand = Brand::FindOrFail($id);

        return view('brands.editbrand', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        // dd($brand->id);
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $brand->image;

        // dd($request->all(),$imagePath);
        if ($request->hasFile('image')) {
            // Delete old image
            if ($imagePath) {
                if (file_exists(public_path($imagePath))) {
                    unlink(public_path($imagePath));
                }
                $imagePath->delete();
                // Storage::disk('public')->delete($imagePath);
            }
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $directory = public_path('vendors/images/brands');
            // Ensure the directory exists
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
            // Resize and save the image
            Image::make($image)->resize(626, 626)->save($directory . '/' . $name_gen);
            // Prepare the relative path
            $imagePath = 'vendors/images/brands/' . $name_gen;
        }

        $brand->update([
            'name' => $request->name,
            'image' => $imagePath,
        ]);
        $notification = array(
            'message' => 'Brand Updated Successfully',
            'alert-type' => 'success'
        );


        return redirect()->route('brands.index')->with($notification);
    }

    public function destroy(Brand $brand)
    {

        if ($brand->products()->count() > 0) {
            $notification = array(
                'message' => 'Cannot delete this brand because it has associated products.',
                'alert-type' => 'error'
            );
            return redirect()->route('brands.index')->with($notification);

        }
        // Delete image
        if ($brand->image_path) {
        }

        $brand->delete();
        $notification = array(
            'message' => 'Brand Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('brands.index')->with($notification);
    }
}
