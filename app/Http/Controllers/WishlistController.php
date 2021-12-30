<?php

namespace App\Http\Controllers;

use App\Course;
use App\Wishlist;

class WishlistController extends Controller
{
    public function index()
    {
        if(auth()->user()->hasRole('STUDENT'))
        {
            $wishlists = auth()->user()->wishlists;
            return view('Wishlist.index', compact('wishlists'));
        }
        else
            return back()->with('toast_warning','You can not access this page');
    }

    public function wishlist(Course $course)
    {
        $this->authorize('wishlist', $course);

        $wishlist = new Wishlist;
        $wishlist->course_id = $course->id;
        $wishlist->user_id = auth()->user()->id;
        $wishlist->save();

        return back()->with('toast_success', 'Wishlisted Successfully!');
    }

    public function remove(Wishlist $wishlist)
    {
        $this->authorize('removeWishlist', $wishlist->course);

        $wishlist->delete();

        return back()->with('toast_error', 'Removed from Wishlist!');
    }
}
