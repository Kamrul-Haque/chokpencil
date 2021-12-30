<?php

namespace App\Http\Middleware;

use Closure;
use App\Course;
use App\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class ShareData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (DB::connection()->getDatabaseName()) {
            $featuredCourses = Course::where('featured', 1)->get();
            $topCategories = Category::orderBy('priority_index', 'desc')->limit(8)->get();

            $data = [
                'featuredCourses' => $featuredCourses,
                'topCategories' => $topCategories,
            ];

            View::share('data', $data);
        }

        return $next($request);
    }
}
