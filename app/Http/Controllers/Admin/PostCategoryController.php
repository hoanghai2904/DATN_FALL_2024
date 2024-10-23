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
    public function addPostCategory()
    {

        $postcategory = PostCategory::all();
        // dd($category);
        return view('admin.postcategory.create')->with((['postcategory' => $postcategory]));
        // return view(self::PATH_VIEW . __FUNCTION__);
    }
    public function addPostPostCategory(Request $req)
    {
        $req->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
        ], [
            'name.required' => 'Tên danh mục không được để trống',
            'name.string' => 'Tên danh mục phải là chuỗi ký tự',
            'name.max' => 'Tên danh mục quá dài',
            'name.regex' => 'Tên danh mục phải là chuỗi ký tự'
        ]);
        $data = [
            'name' => $req->name,
        ];
        PostCategory::create($data);
        return redirect()->route('admin.postcategories.listPostCategory');
    }
}
