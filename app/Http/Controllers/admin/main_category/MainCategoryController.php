<?php

namespace App\Http\Controllers\admin\main_category;


use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MainCategory;

class MainCategoryController extends Controller
{
    public function index()
    {
        // $category = Category::all();
        // $category = Category::orderBy('id', 'desc')->get();
        $category = MainCategory::latest()->get();
        return view('main_category.index', compact('category'));
    }

    public function create()
    {
        return view('main_category.createmaincategory');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);



        MainCategory::create([
            'name' => $request->name,
        ]);
        $notification = array(
            'message' => 'Main Category Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('main_categories.index')->with($notification);
    }
    public function show($id)
    {
        $category = MainCategory::FindOrFail($id);

        return view('main_category.showmaincategory', compact('category'));
    }

    public function edit($id)
    {
        $category = MainCategory::findOrFail($id);
        return view('main_category.editmaincategory', compact('category'));
    }

    public function update(Request $request, MainCategory $main_category)
    {
        $request->validate([
            'name' => 'required',

        ]);
        // dd($request->name);

        $main_category->update([
            'name' => $request->name,

        ]);
        // dd($main_category);
        $notification = array(
            'message' => 'Main Category updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('main_categories.index')->with($notification);
    }

    public function destroy(MainCategory $mainCategory)
    {
//      dd($mainCategory);

        $mainCategory->delete();
        $notification = array(
            'message' => 'Main Category deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('main_categories.index')->with($notification);
    }
}
