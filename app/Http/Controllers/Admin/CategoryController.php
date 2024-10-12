<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Flasher\Notyf\Prime\NotyfInterface;



class CategoryController extends Controller
{
    public function show()
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
    }




    public function deleteCategory($id)
    {
        $category = Category::find($id);

        if ($category) {
            // Cập nhật trạng thái
            $category->status = 0;
            $category->save();

            // Xóa danh mục sau khi cập nhật trạng thái
            $category->delete();
        }


        // Chuyển hướng về trang danh sách danh mục
        return redirect()->route('admin.categories.listCategory')->with('message', 'Cập nhật trạng thái danh mục thành công');
    }

    public function restoreCategory($id)
    {
        $category = Category::withTrashed()->find($id);

        if ($category) {
            $category->status = 1;
            $category->save();

            $category->restore();
            return redirect()->route('admin.categories.listCategory')->with(['message' => 'Cập nhật thành công']);
        }

        return redirect()->route('admin.categories.listCategory')->with(['message' => 'Danh mục không tồn tại']);
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

        // Thông báo thành công khi cập nhật


        return redirect()->route('admin.categories.listCategory');
    }
}
