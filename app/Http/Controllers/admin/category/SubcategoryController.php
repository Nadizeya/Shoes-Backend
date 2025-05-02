<?php

namespace App\Http\Controllers\admin\category;


use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::with('category')->get();
        // $categories = $subcategories->map(function ($subcategory) {
        //     return $subcategory->category;
        // });
        // dd($categories);
        return view('subcategory.index', compact('subcategories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('subcategory.createsubcategory', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);


        Subcategory::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);
        $notification = array(
            'message' => 'SubCategory Created Successfully',
            'alert-type' => 'success'
        );


        return redirect()->route('subcategories.index')->with($notification);
    }
    public function show($id)
    {
        $subcategory = SubCategory::FindOrFail($id);
        $categories = Category::orderBy('id', 'ASC')->get();
        return view('subcategory.showsubcategory', compact('subcategory'));
    }


    public function edit($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $categories = Category::orderBy('id', 'ASC')->get();
        // $categories = Category::all();
        return view('subcategory.editsubcategory', compact('subcategory', 'categories',));
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',

        ]);



        $subcategory->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);
        $notification = array(
            'message' => 'SubCategory Updated Successfully',
            'alert-type' => 'success'
        );


        return redirect()->route('subcategories.index')->with($notification);
    }

    public function destroy(Subcategory $subcategory)
    {


        $subcategory->delete();
        $notification = array(
            'message' => 'SubCategory Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('subcategories.index')->with($notification);
    }
}
