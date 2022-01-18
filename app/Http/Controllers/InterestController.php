<?php

namespace App\Http\Controllers;

use App\Category;
use App\Interest;
use Illuminate\Http\Request;

class InterestController extends Controller
{
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('Student.interests', compact('categories'));
    }

    public function store(Request $request)
    {
        $interests = $request->input('interests');

        if (auth()->user()->interests)
            Interest::destroy(auth()->user()->interests->pluck('id')->flatten());
        if ($interests) {
            foreach ($interests as $key => $value) {
                $category = Category::find($interests[$key]);

                Interest::create([
                    'category_id'=>$category->id,
                    'user_id'=>auth()->user()->id
                ]);
            }
        }

        return back()->with('toast_success', 'Saved Successfully');
    }
}
