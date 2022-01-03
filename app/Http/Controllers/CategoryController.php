<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->paginate();
        return view('Category.index', compact('categories'));
    }

    public function create()
    {
        return view('Category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:categories,name',
            'image' => 'required|file|mimes:jpg,jpeg,png|max:2024'
        ]);

        $category = new Category;
        $category->name = $request->name;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('CategoryImages');
            $category->image = 'storage/' . $path;
        }

        $category->save();

        return redirect()->route('admin.category.index')->with('toast_success', 'Created Successfully');
    }

    public function show(Category $category)
    {
        $courses = $category->courses()->paginate(5);

        return view('Course.index', compact('courses'));
    }

    public function edit(Category $category)
    {
        return view('Category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:categories,name,' . $category->id,
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2024'
        ]);

        $category->name = $request->name;
        $oldImage = $category->getOriginal('image');

        if ($request->hasFile('image')) {
            if (File::exists($oldImage))
                File::delete($oldImage);

            $path = $request->file('image')->store('CategoryImages');
            $category->image = 'storage/' . $path;
        }

        $category->save();

        return redirect()->route('admin.category.index')->with('toast_info', 'Updated Successfully');
    }

    public function destroy(Category $category)
    {
        $oldImage = $category->getOriginal('image');

        if (File::exists($oldImage))
            File::delete($oldImage);

        $category->delete();

        return redirect()->route('admin.category.index')->with('toast_error', 'Record Deleted');
    }
}
