<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // $data = Category::query()->latest('id')->paginate(5);
        // $data = null;
        // //        dd($data);
        // return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
        $activeCategories = Category::where('status', 1)->latest()->paginate(5);
        $inactiveCategories = Category::withTrashed()->where('status', 0)->latest()->paginate(5);
        return view('admin.list.index')->with([
            'activeCategories' => $activeCategories,
            'inactiveCategories' => $inactiveCategories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function addCategory()
    {

        $category = Category::all();
        return view('admin.list.create')->with((['category' => $category]));
        // return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addPostCategory(Request $req)
    {
        $req->validate([
            'name' => 'required|string|max:255',

        ], [
            'name.required' => 'Tên danh mục không được để trống',
            'name.string' => 'Tên danh mục phải là chuỗi ký tự',
            'name.max' => 'Tên danh mục quá dài',

        ]);
        $data = [
            'name' => $req->name,
            'slug' => $req->slug,
            'parent_id' => $req->parent_id
        ];
        Category::create($data);
        return redirect()->route('admin.listCategory')->with(['message' => "Thêm mới thành công"]);

        //        dd($request->all());
        //         $data = $request->except('cover');
        // //        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        //         $data['is_active'] ??= 0;
        //         if ($request->hasFile('cover')) {
        //             $data['cover'] = Storage::put(self::PATH_UPLOAD, $request->file('cover'));
        //         } else {
        //             $data['cover'] = '';
        //         }
        //         Category::query()->create($data);

        //         return redirect()->route('admin.categories.index')->with('message', 'Thêm mới thành công');
    }

    /**
     * Display the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    // public function deleteCategory($id)
    // {
    //     $category = Category::find($id);
    //     $category->delete();
    //     return redirect()->route('admin.listCategory')->with(['message' => 'Xóa thành công']);
    // }
    public function deleteCategory($id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->status = 0;
            $category->save();

            $category->delete();
            return redirect()->route('admin.listCategory')->with(['message' => 'Xóa thành công']);
        }

        return redirect()->route('admin.listCategory')->with(['message' => 'Danh mục không tồn tại']);
    }
    public function restoreCategory($id)
    {
        $category = Category::withTrashed()->find($id);

        if ($category) {
            $category->status = 1;
            $category->save();

            $category->restore();
            return redirect()->route('admin.listCategory')->with(['message' => 'Cập nhật thành công']);
        }

        return redirect()->route('admin.listCategory')->with(['message' => 'Danh mục không tồn tại']);
    }
    public function updateCategory($id)
    {
        $category = Category::find($id);
        $categories = Category::all();
        return view('admin.list.update')->with([
            'category' => $category,
            'categories' => $categories
        ]);
    }
    public function updatePutCategory(Request $req, $id)
    {
        $category = Category::find($id);
        $req->validate([
            'name' => 'required|string|max:255',

        ], [
            'name.required' => 'Tên danh mục không được để trống',
            'name.string' => 'Tên danh mục phải là chuỗi ký tự',
            'name.max' => 'Tên danh mục quá dài',

        ]);
        $data = [
            'name' => $req->name,
            'slug' => $req->slug,
            'parent_id' => $req->parent_id
        ];
        $category->update($data);
        return redirect()->route('admin.listCategory')->with(['message' => "Cập nhật thành công"]);
    }
}
