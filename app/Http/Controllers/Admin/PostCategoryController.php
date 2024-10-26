<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class PostCategoryController extends Controller
{
    public function show(Request $request)
    {
        $query = PostCategory::withTrashed();
        if ($request->has('status')) {

            if ($request->status == '0') {
            } elseif ($request->status == '1') {

                $query->where('status', 1);
            } elseif ($request->status == '2') {

                $query->where('status', 0);
            }
        }
        // Phân trang
        $postcategories = $query->orderBy('status', 'desc')->latest()->paginate(5);
        return view('admin.postcategory.index')->with([
            'postcategories' => $postcategories,
            'selectedStatus' => $request->status
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
        $existingCategory = PostCategory::where('name', $req->name)->first();

        if ($existingCategory) {
            return redirect()->back()->withErrors(['name' => 'Danh mục đã tồn tại.'])->withInput();
        }

        $req->validate([
            'name' => 'required|string|max:255|regex:/^[\p{L}\s]+$/u'

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
        session()->flash('success', 'Thêm danh mục thành công!');

        return redirect()->route('admin.postcategories.listPostCategory');
    }
}
