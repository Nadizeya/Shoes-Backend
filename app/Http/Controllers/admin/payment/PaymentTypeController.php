<?php

namespace App\Http\Controllers\admin\payment;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class PaymentTypeController extends Controller
{
    public function index()
    {
        // $brands = Brand::all();
        // $brands = Brand::orderBy('id', 'desc')->get();
        $banks = Bank::latest()->get();
        return view('payment_type.index', compact('banks'));
    }

    public function create()
    {
        return view('payment_type.create');
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
            'bank_name' => 'required',
            'bank_type' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $directory = public_path('vendors/images/bank');
            // $path = $directory . '/' . $name_gen;

            // Ensure the directory exists
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            // Resize and save the image
            Image::make($image)->resize(626, 626)->save('vendors/images/bank/' . $name_gen);

            // Prepare the relative path
            $relativePath = 'vendors/images/bank/' . $name_gen;
            Bank::create([
            'bank_name' => $request->bank_name,
            'bank_type' => $request->bank_type,
            'image' => $relativePath, // Store image paths as JSON in the existing 'image' column
        ]);
        }else{
            Bank::create([
            'bank_name' => $request->bank_name,
            'bank_type' => $request->bank_type,
             // Store image paths as JSON in the existing 'image' column
        ]);
        }


        $notification = array(
            'message' => 'Brand created successfully.',
            'alert-type' => 'success'
        );

        return redirect()->route('payment_type.index')->with($notification);
    }
    public function show($id)
    {
        $bank = Bank::FindOrFail($id);

        return view('payment_type.showpayment', compact('bank'));
    }

    public function edit($id)
    {
        $bank = Bank::FindOrFail($id);

        return view('payment_type.edit', compact('bank'));
    }

    public function update(Request $request, $id)
    {
        // dd($id);
        $request->validate([
            'bank_name' => 'required',
            'bank_type' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $bank = Bank::FindOrFail($id);



        $imagePath = $bank->image;


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
            $directory = public_path('vendors/images/bank');
            // Ensure the directory exists
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
            // Resize and save the image
            Image::make($image)->resize(626, 626)->save($directory . '/' . $name_gen);
            // Prepare the relative path
            $imagePath = 'vendors/images/bank/' . $name_gen;



            $bank->update([
                'bank_name' => $request->bank_name,
                'bank_type' => $request->bank_type,
                'image' => $imagePath,
            ]);



        }else{
            $bank->update([
                'bank_name' => $request->bank_name,
                'bank_type' => $request->bank_type,

            ]);
        }


        $notification = array(
            'message' => 'Bank Updated Successfully',
            'alert-type' => 'success'
        );


        return redirect()->route('payment_type.index')->with($notification);
    }

    public function destroy($id)
    {

        $bank = Bank::FindOrFail($id);
        $imagePath=$bank->image;
        // Delete image
        if ($bank->image) {
                if (file_exists(public_path($imagePath))) {
                    unlink(public_path($imagePath));
                }

        }

        $bank->delete();
        $notification = array(
            'message' => 'Brand Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('payment_type.index')->with($notification);
    }
}
