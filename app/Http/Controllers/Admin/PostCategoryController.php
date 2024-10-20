<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class PostCategoryController extends Controller
{
    public function show()
    {
        // $data = Category::query()->latest('id')->paginate(5);
        // $data = null;
        // //        dd($data);
        // return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
        $activePostCategories = PostCategory::where('status', 1)->latest()->paginate(5);
        $inactivePostCategories = PostCategory::withTrashed()->where('status', 0)->latest()->paginate(5);
        return view('admin.postcategory.index')->with([
            'activePostCategories' => $activePostCategories,
            'inactivePostCategories' => $inactivePostCategories
        ]);
    }
}
