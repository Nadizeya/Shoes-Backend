<?php

namespace App\Http\Controllers\admin\category;


use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MainCategory;

class CategoryController extends Controller
{
    public function index()
    {
        // $category = Category::all();
        // $category = Category::orderBy('id', 'desc')->get();
        // $category = Category::latest()->get();
        $category = Category::with('mainCategory')->get();

        return view('category.index', compact('category'));
    }

    public function create()
    {
        $main = MainCategory::all();
        return view('category.createcategory', compact('main'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'main_category_id' => 'required'
        ]);



        Category::create([
            'name' => $request->name,
            'main_category_id' => $request->main_category_id,

        ]);
        $notification = array(
            'message' => 'Category Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('categories.index')->with($notification);
    }
    public function show($id)
    {
        $category = Category::FindOrFail($id);
        // $main = MainCategory::orderBy('id', 'ASC')->get();

        return view('category.showcategory', compact('category'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $main_categories = MainCategory::orderBy('id', 'ASC')->get();
        return view('category.editcategory', compact('category', 'main_categories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',

        ]);


        $category->update([
            'name' => $request->name,

        ]);
        $notification = array(
            'message' => 'Category updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('categories.index')->with($notification);
    }

    public function destroy(Category $category)
    {

        if ($category->products()->count() > 0) {
            $notification = array(
                'message' => 'Cannot delete this category because it has associated products.',
                'alert-type' => 'error'
            );
            return redirect()->route('categories.index')->with($notification);

        }
//      dd($category);
        $category->delete();
        $notification = array(
            'message' => 'Category deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('categories.index')->with($notification);
    }
}
